<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MedicalAttachment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'medical_record_id',
        'file_path',
        'file_name',
        'file_type',
        'category',
        'description',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
