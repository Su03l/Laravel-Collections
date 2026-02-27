<?php

namespace App\Http\Controllers\Api\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecordResource;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Traits\HttpResponses;
use App\Traits\LogsMedicalAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecordManagementController extends Controller
{
    // traits
    use HttpResponses, LogsMedicalAccess;

    public function store(Request $request, Appointment $appointment)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'files.*' => 'file|mimes:pdf,jpg,png|max:10240', // 10MB max
            'categories.*' => 'nullable|string|in:General,X-Ray,Lab-Result,Prescription,Report',
            'descriptions.*' => 'nullable|string|max:255',
        ]);

        //  Validate request
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

        // Create record and using transaction to ensure data consistency
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

    // update record 
    public function update(Request $request, MedicalRecord $record)
    {
        $this->authorize('update', $record);

        // Check if 48 hours have passed
        if ($record->created_at->diffInHours(now()) > 48) {
            return $this->error('Cannot update medical record after 48 hours', 403);
        }

        // Validate request 
        $validator = Validator::make($request->all(), [
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'doctor_notes' => 'nullable|string',
        ]);

        //  check validation
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // update record
        $record->update([
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
            'doctor_notes' => $request->doctor_notes,
        ]);

        return $this->success($record, 'Medical record updated successfully');
    }

    public function show(Appointment $appointment)
    {
        $record = MedicalRecord::where('appointment_id', $appointment->id)->with('attachments')->first();

        if (!$record) {
            return $this->error('Record not found', 404);
        }

        $this->authorize('view', $record);

        $this->logAccess($record->id, 'view');

        return $this->success(new MedicalRecordResource($record));
    }
}
