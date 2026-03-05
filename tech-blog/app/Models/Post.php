<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'content'];

    // المقال ينتمي لكاتب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // المقال يحتوي على عدة تعليقات
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // المقال يحتوي على عدة مرفقات (صور/ملفات)
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    // المقال يرتبط بعدة هاشتاقات (علاقة Many-to-Many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
