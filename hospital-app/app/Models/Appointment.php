<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Appointment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'patient_notes',
    ];

    // the patient who has the appointment
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // the appoinment belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
