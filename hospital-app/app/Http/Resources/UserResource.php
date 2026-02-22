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
            'two_factor_enabled' => (bool) $this->two_factor_enabled,
            'medical_profile' => new PatientProfileResource($this->whenLoaded('patientProfile')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
