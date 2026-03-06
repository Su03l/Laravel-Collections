<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    // the fillable 
    protected $fillable = ['category_id', 'title', 'code', 'description', 'language'];

    // the category belongs to snippet
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
