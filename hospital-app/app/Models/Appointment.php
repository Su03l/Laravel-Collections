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

    // relationship to patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
