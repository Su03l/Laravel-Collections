<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password',
        'role', 'is_active', 'avatar', 'header_image', 'bio',
        'date_of_birth', 'country', 'website_url', 'github_url'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // علاقة اليوزر بالمقالات (يملك عدة مقالات)
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // علاقة اليوزر بالتعليقات
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // دالة مساعدة سريعة لمعرفة هل هو أدمن؟
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // دوال مساعدة (Helpers) تفك أزمة في الـ Blade
    public function hasLiked($model)
    {
        return $this->likes()
            ->where('likeable_id', $model->id)
            ->where('likeable_type', get_class($model))
            ->exists();
    }

    public function hasBookmarked($post)
    {
        return $this->bookmarks()->where('post_id', $post->id)->exists();
    }
}
