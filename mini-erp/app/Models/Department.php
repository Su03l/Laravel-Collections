<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // the requset fillable
    protected $fillable = ['name'];

    // the departement belong to users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
