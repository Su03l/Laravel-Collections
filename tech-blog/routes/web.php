<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserPostController;

// الصفحة الرئيسية
Route::get('/', [PostController::class, 'index'])->name('home');

// صفحة قراءة المقال بالكامل
Route::get('/post/{slug}', [PostController::class, 'show'])->name('posts.show');

// صفحة بروفايل الكاتب (لعرض معلوماته وكل مقالاته)
Route::get('/author/{username}', [AuthorController::class, 'show'])->name('author.show');

// إضافة تعليق (محمي: لازم تسجيل دخول)
Route::post('/post/{post}/comment', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

// مسارات لوحة التحكم (Breeze)
Route::middleware(['auth', 'verified'])->group(function () {

    // لوحة تحكم اليوزر (عرض مقالاته)
    Route::get('/dashboard', [UserPostController::class, 'index'])->name('dashboard');

    // إضافة مقال جديد
    Route::get('/dashboard/posts/create', [UserPostController::class, 'create'])->name('user.posts.create');
    Route::post('/dashboard/posts', [UserPostController::class, 'store'])->name('user.posts.store');

    // المسارات الجديدة (التعديل والحذف)
    Route::get('/dashboard/posts/{post}/edit', [UserPostController::class, 'edit'])->name('user.posts.edit');
    Route::put('/dashboard/posts/{post}', [UserPostController::class, 'update'])->name('user.posts.update');
    Route::delete('/dashboard/posts/{post}', [UserPostController::class, 'destroy'])->name('user.posts.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
