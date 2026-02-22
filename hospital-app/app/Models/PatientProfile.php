<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientProfile extends Model
{
    use HasFactory, HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'blood_type',
        'chronic_diseases',
        'allergies',
        'past_surgeries',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
