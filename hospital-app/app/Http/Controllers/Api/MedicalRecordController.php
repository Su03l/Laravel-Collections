<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecordResource;
use App\Models\Appointment;
use App\Models\MedicalAccessLog;
use App\Models\MedicalAttachment;
use App\Models\MedicalConsent;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Traits\HttpResponses;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MedicalRecordController extends Controller
{
    use HttpResponses;

    // log access for a medical record
    private function logAccess($recordId, $action = 'view', $userId = null) {
        MedicalAccessLog::create([
            'user_id' => $userId ?? auth()->id(),
            'medical_record_id' => $recordId,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    // the store record for a patient
    public function storeRecord(Request $request, Appointment $appointment)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'files.*' => 'file|mimes:pdf,jpg,png|max:10240', // 10MB max
            'categories.*' => 'nullable|string|in:General,X-Ray,Lab-Result,Prescription,Report',
            'descriptions.*' => 'nullable|string|max:255',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // Check if the doctor is the owner of the appointment
        if (!$appointment->doctor_id || $appointment->doctor_id !== auth()->user()->doctorProfile->id) {
            return $this->error('Unauthorized', 403);
        }

        // Check if the appointment is completed
        if ($appointment->status !== 'completed') {
            return $this->error('Patient must be attended first', 400);
        }

        // Check if a record already exists for this appointment
        if (MedicalRecord::where('appointment_id', $appointment->id)->exists()) {
            return $this->error('Medical record already exists for this appointment', 409);
        }

        return DB::transaction(function () use ($request, $appointment) {
            $record = MedicalRecord::create([
                'appointment_id' => $appointment->id,
                'patient_id'     => $appointment->patient_id,
                'doctor_id'      => $appointment->doctor_id,
                'diagnosis'      => $request->diagnosis,
                'prescription'   => $request->prescription,
                'doctor_notes'   => $request->doctor_notes,
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $index => $file) {
                    // Save to private disk
                    $path = $file->store('medical_records/' . $record->id, 'private');
                    $record->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientOriginalExtension(),
                        'category'    => $request->categories[$index] ?? 'General',
                        'description' => $request->descriptions[$index] ?? null,
                    ]);
                }
            }
            return $this->success($record, 'Medical record saved successfully');
        });
    }

    public function updateRecord(Request $request, MedicalRecord $record)
    {
        $this->authorize('update', $record);

        // Check if 48 hours have passed
        if ($record->created_at->diffInHours(now()) > 48) {
            return $this->error('Cannot update medical record after 48 hours', 403);
        }

        $validator = Validator::make($request->all(), [
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'doctor_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $record->update([
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
            'doctor_notes' => $request->doctor_notes,
        ]);

        return $this->success($record, 'Medical record updated successfully');
    }

    public function downloadAttachment(MedicalAttachment $attachment)
    {
        $this->authorize('view', $attachment->medicalRecord);

        $this->logAccess($attachment->medicalRecord->id, 'download_attachment');

        if (Storage::disk('private')->exists($attachment->file_path)) {
             return Storage::disk('private')->download($attachment->file_path, $attachment->file_name);
        }

        return $this->error('File not found', 404);
    }

    public function getRecord(Appointment $appointment)
    {
        $record = MedicalRecord::where('appointment_id', $appointment->id)->with('attachments')->first();

        if (!$record) {
            return $this->error('Record not found', 404);
        }

        $this->authorize('view', $record);

        $this->logAccess($record->id, 'view');

        return $this->success(new MedicalRecordResource($record));
    }

    public function getPatientHistory(User $patient) {
        $doctor = auth()->user()->doctorProfile;

        // 1. Check if there is a direct appointment relationship
        $hasAppointment = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->exists();

        // 2. Check for explicit consent
        $hasConsent = MedicalConsent::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->where('is_active', true)
            ->exists();

        if (!$hasAppointment && !$hasConsent) {
            return $this->error(null, 'Unauthorized to view this patient history. Consent required.', 403);
        }

        $records = MedicalRecord::where('patient_id', $patient->id)
            ->with(['doctor', 'attachments'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Log access for each record
        foreach($records as $rec) { $this->logAccess($rec->id, 'view_history'); }

        return $this->success(MedicalRecordResource::collection($records), 'Patient medical history');
    }

    public function downloadPrescription(MedicalRecord $record) {
        // Check authorization (Patient or Doctor)
        $this->authorize('view', $record);

        $this->logAccess($record->id, 'download_pdf');

        // Generate PDF using DomPDF
        $pdf = Pdf::loadView('pdf.prescription', [
            'record' => $record,
            'hospital' => $record->doctor->hospital,
            // 'qr_code' => base64_encode(QrCode::format('svg')->size(100)->generate(url("/verify/prescription/{$record->id}")))
        ]);

        return $pdf->download("prescription_{$record->id}.pdf");
    }

    // --- Consent Management ---

    public function grantConsent(Request $request) {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // Prevent duplicate active consents
        MedicalConsent::updateOrCreate(
            [
                'patient_id' => auth()->id(),
                'doctor_id' => $request->doctor_id,
            ],
            [
                'consented_at' => now(),
                'ip_address' => $request->ip(),
                'is_active' => true,
            ]
        );

        return $this->success(null, 'Consent granted successfully to the doctor.');
    }

    public function revokeConsent(Request $request) {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        MedicalConsent::where('patient_id', auth()->id())
            ->where('doctor_id', $request->doctor_id)
            ->update(['is_active' => false]);

        return $this->success(null, 'Consent revoked successfully.');
    }

    // --- Secure Sharing ---

    public function createShareToken(MedicalRecord $record) {
        $this->authorize('view', $record); // Only the patient (or the doctor)

        // Only patient can share their own record
        if (auth()->id() !== $record->patient_id) {
             return $this->error('Only the patient can share their medical record.', 403);
        }

        $token = Str::random(64);
        // Save token in cache for 24 hours
        Cache::put("share_token_{$token}", $record->id, now()->addHours(24));

        return $this->success([
            'share_link' => url("/api/shared/view/{$token}"),
            'expires_at' => now()->addHours(24)
        ], 'Secure share link created (valid for 24 hours)');
    }

    public function viewSharedRecord($token) {
        $recordId = Cache::get("share_token_{$token}");

        if (!$recordId) {
            return $this->error('Invalid or expired share link', 404);
        }

        $record = MedicalRecord::with(['doctor', 'attachments', 'patient'])->find($recordId);

        if (!$record) {
            return $this->error('Record not found', 404);
        }

        // Log access (anonymous or system user)
        // Since this is a public link, we might not have an auth user.
        // We log it with the patient ID as the "owner" of the action, or handle it differently.
        // For now, we'll log it with the patient's ID but mark action as 'view_shared'

        $this->logAccess($record->id, 'view_shared', $record->patient_id);

        return $this->success(new MedicalRecordResource($record), 'Shared Medical Record');
    }
}
