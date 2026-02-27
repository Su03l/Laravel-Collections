<?php

namespace App\Http\Controllers\Api\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Models\MedicalConsent;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsentController extends Controller
{
    // traits for http responses
    use HttpResponses;

    // grant consent to a doctor    
    public function grant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        // validate request 
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

    public function revoke(Request $request)
    {
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
}
