<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    // this for using the factory to use fake
    use HasFactory;

    // the request the response
    protected $fillable = [
        'title',
        'content',
        'is_pinned',
        'category',
        'status'
    ];

    // this for casts the choose the type
    protected $casts = [
        'is_pinned' => 'boolean',
    ];
}
