<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    // this for using the factory to use fake
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'is_pinned',
        'category',
        'status'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];
}
