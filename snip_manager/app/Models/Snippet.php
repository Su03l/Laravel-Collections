<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $fillable = ['category_id', 'title', 'code', 'description', 'language'];

    // الكود ينتمي لقسم واحد
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
