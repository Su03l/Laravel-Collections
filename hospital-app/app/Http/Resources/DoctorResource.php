<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->name,
            'specialty' => $this->specialization,
            'years_of_experience' => $this->experience_years . ' سنة',
            'about' => $this->bio,
            'profile_photo' => $this->image,

            // جلب بيانات المستشفى والعيادة بذكاء
            'hospital' => [
                'id' => $this->hospital->id,
                'name' => $this->hospital->name,
                'location' => $this->hospital->city,
            ],
            'clinic' => [
                'id' => $this->clinic->id,
                'name' => $this->clinic->name,
            ],
        ];
    }
}
