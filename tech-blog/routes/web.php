<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthorController;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
