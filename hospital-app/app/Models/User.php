<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'otp',
        'otp_expires_at',
        'two_factor_enabled',
        'role',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // every user has one patient profile
    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class);
    }

    // every user has one doctor profile
    public function doctorProfile()
    {
        return $this->hasOne(Doctor::class, 'id');
    }

    // every user has many login activities
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function isDoctor()
    {
        return $this->role === 'doctor';
    }
}
