<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'appointment_id' => $this->appointment_id,
            'doctor_name' => $this->doctor->name,
            'diagnosis' => $this->diagnosis,
            'prescription' => $this->prescription,
            'created_at' => $this->created_at->toDateTimeString(),
            'attachments' => $this->attachments->map(function ($attachment) {
                return [
                    'id' => $attachment->id,
                    'file_name' => $attachment->file_name,
                    'file_type' => $attachment->file_type,
                    'url' => url("/api/medical-attachments/{$attachment->id}"),
                ];
            }),
        ];
    }
}
