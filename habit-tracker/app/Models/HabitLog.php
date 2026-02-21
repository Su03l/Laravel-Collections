<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    // the req
    protected $fillable = ['habit_id', 'completed_date', 'completed'];

    // the casts
    protected $casts = [
        'completed_date' => 'date',
        'completed' => 'boolean',
    ];
}
