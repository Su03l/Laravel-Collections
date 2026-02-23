<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'is_active' => (bool) $this->is_active,
            'two_factor_enabled' => (bool) $this->two_factor_enabled,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

            // يظهر فقط للمريض
            'medical_info' => $this->when($this->role === 'patient', function () {
                return new PatientProfileResource($this->whenLoaded('patientProfile'));
            }),

            // يظهر فقط للدكتور
            'doctor_details' => $this->when($this->role === 'doctor', function () {
                return $this->doctorProfile ? [
                    'specialty' => $this->doctorProfile->specialization,
                    'hospital' => $this->doctorProfile->hospital->name ?? null,
                ] : null;
            }),
        ];
    }
}
