<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    // fillable 
    protected $fillable = ['name', 'slug', 'color', 'type', 'icon'];

    // snippets has many relationship 
    public function snippets()
    {
        return $this->hasMany(Snippet::class);
    }
}
