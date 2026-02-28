<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'clinic_id',
        'name',
        'specialization',
        'bio',
        'experience_years',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // the doctor belongs to a hospital
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    // the doctor belongs to a clinic
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    // the doctor has many schedules
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    // the doctor has many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // the doctor has many reviews
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // the doctor has many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
