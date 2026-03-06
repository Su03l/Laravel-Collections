<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    // القسم يملك عدة أكواد
    public function snippets()
    {
        return $this->hasMany(Snippet::class);
    }
}
