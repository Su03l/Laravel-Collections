<?php

namespace App\Http\Controllers\Api\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecordResource;
use App\Models\Appointment;
use App\Models\MedicalConsent;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Traits\HttpResponses;
use App\Traits\LogsMedicalAccess;

class HistoryController extends Controller
{
    // 
    use HttpResponses, LogsMedicalAccess;

    // get patient history
    public function getPatientHistory(User $patient)
    {
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

        // 3. Check if the doctor has access to the patient's medical records   
        if (!$hasAppointment && !$hasConsent) {
            return $this->error(null, 'Unauthorized to view this patient history. Consent required.', 403);
        }

        // 4. Get the patient's medical records
        $records = MedicalRecord::where('patient_id', $patient->id)
            ->with(['doctor', 'attachments'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Log access for each record
        foreach ($records as $rec) {
            $this->logAccess($rec->id, 'view_history');
        }

        return $this->success(MedicalRecordResource::collection($records), 'Patient medical history');
    }
}
