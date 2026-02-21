<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    protected $fillable = ['habit_id', 'completed_date', 'completed'];

    protected $casts = [
        'completed_date' => 'date',
        'completed' => 'boolean',
    ];
}
