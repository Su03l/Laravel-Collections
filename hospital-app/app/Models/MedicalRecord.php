<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MedicalRecord extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'diagnosis',
        'prescription',
        'doctor_notes',
    ];

    // the medical record belongs to an appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // the medical record belongs to a patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function attachments()
    {
        return $this->hasMany(MedicalAttachment::class);
    }
}
