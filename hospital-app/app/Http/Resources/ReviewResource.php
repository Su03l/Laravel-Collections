<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'rating'       => (int) $this->rating,
            'comment'      => $this->comment,
            'patient_name' => $this->patient->name,
            'patient_image'=> $this->patient->avatar ? url($this->patient->avatar) : null, // Assuming avatar field exists
            'created_at'   => $this->created_at->diffForHumans(), // e.g., "2 days ago"
        ];
    }
}
