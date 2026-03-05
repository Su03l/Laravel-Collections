<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // أضفنا الـ parent_id هنا
    protected $fillable = ['user_id', 'post_id', 'parent_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // علاقة اللايكات للتعليق (Polymorphic)
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // الردود التابعة لهذا التعليق (الأبناء)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // التعليق الأساسي (الأب)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
