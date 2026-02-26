<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'consented_at',
        'ip_address',
        'is_active',
    ];

    // casts for the fields
    protected $casts = [
        'consented_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // the consent belongs to a patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // the consent belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
