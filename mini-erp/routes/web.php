<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;

// --- مسارات الزوار (الضيوف) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- مسارات المسجلين دخولهم (مدراء أو موظفين) ---
Route::middleware('auth')->group(function () {

    // تسجيل الخروج للجميع
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. مسار الموظف العادي (يشوف بياناته فقط)
    Route::get('/my-dashboard', function () {
        return view('employee.dashboard', ['user' => auth()->user()]);
    })->name('employee.dashboard');

});

// --- مسارات الإدارة (محمية بصلاحية الأدمن فقط) ---
Route::middleware(['auth', 'admin'])->group(function () {
    // توجيه الصفحة الرئيسية للأدمن
    Route::get('/', function () {
        return redirect()->route('employees.index');
    });

    Route::resource('employees', EmployeeController::class)->except(['show']);
});
