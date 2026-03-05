<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // هذي الدالة اللي تخلي اللايك يركب على (مقال) أو (تعليق)
    public function likeable()
    {
        return $this->morphTo();
    }
}
