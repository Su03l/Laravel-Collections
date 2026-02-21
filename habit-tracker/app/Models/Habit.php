<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'description', 'color', 'icon',
        'user_id', 'current_streak', 'best_streak'
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(HabitLog::class);
    }
}
