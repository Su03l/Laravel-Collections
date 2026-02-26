<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_record_id',
        'action',
        'ip_address',
        'user_agent',
    ];

    // the login activity belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
