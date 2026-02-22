<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'blood_type' => $this->blood_type,
            'chronic_diseases' => $this->chronic_diseases,
            'allergies' => $this->allergies,
            'past_surgeries' => $this->past_surgeries,
        ];
    }
}
