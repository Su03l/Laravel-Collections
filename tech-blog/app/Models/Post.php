<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'content'];

    // --- الكود الجديد: الفلتر العالمي ---
    protected static function booted(): void
    {
        // هذا الفلتر بيشتغل مع أي استعلام للمقالات
        static::addGlobalScope('activeAuthor', function (Builder $builder) {
            $builder->whereHas('user', function ($query) {
                $query->where('is_active', true);
            });
        });
    }
    // ------------------------------------

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

    // جلب التعليقات الأساسية فقط (بدون الردود)
    public function rootComments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    // علاقة اللايكات (Polymorphic)
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // علاقة المحفوظات
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
