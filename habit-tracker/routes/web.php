<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    // تسجيل دخول تلقائي لأغراض التطوير
    if (!Auth::check()) {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }
        Auth::login($user);
    }
    return redirect()->route('habits.index');
});

// إزالة middleware المصادقة مؤقتاً أو تركه إذا كنا نسجل الدخول تلقائياً
Route::middleware(['auth'])->group(function () {
    Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    Route::post('/habits/{habit}/toggle', [HabitController::class, 'toggleLog'])->name('habits.toggle');
    Route::get('/stats', [HabitController::class, 'stats'])->name('habits.stats');
    Route::get('/habits/export', [HabitController::class, 'export'])->name('habits.export');
});
