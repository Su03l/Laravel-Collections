<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Todo extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'completed',
        'priority',
        'due_date',
        'order'
    ];

    //
    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date'
    ];

    // every todo has many categories
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_todo');
    }
}
