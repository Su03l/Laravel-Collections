<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BookmarkController;

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

    // مسار عرض المقالات المحفوظة في لوحة التحكم
    Route::get('/dashboard/bookmarks', [BookmarkController::class, 'index'])->name('user.bookmarks');

    // إضافة مقال جديد
    Route::get('/dashboard/posts/create', [UserPostController::class, 'create'])->name('user.posts.create');
    Route::post('/dashboard/posts', [UserPostController::class, 'store'])->name('user.posts.store');

    // المسارات الجديدة (التعديل والحذف)
    Route::get('/dashboard/posts/{post}/edit', [UserPostController::class, 'edit'])->name('user.posts.edit');
    Route::put('/dashboard/posts/{post}', [UserPostController::class, 'update'])->name('user.posts.update');
    Route::delete('/dashboard/posts/{post}', [UserPostController::class, 'destroy'])->name('user.posts.destroy');
});

// مسارات لوحة تحكم الإدارة (Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // الصفحة الرئيسية للأدمن
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // مسار حظر/تفعيل اليوزر
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');

    // مسار حذف مقال
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('admin.posts.destroy');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // مسارات اللايكات
    Route::post('/posts/{post}/like', [LikeController::class, 'togglePost'])->name('likes.post');
    Route::post('/comments/{comment}/like', [LikeController::class, 'toggleComment'])->name('likes.comment');

    // مسار حفظ المقال
    Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
});

require __DIR__.'/auth.php';
