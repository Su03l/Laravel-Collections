<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

// ⚠️ مسار مؤقت للمطورين فقط عشان ندخل كأدمن
Route::get('/dev-login', function () {
    // تسجيل الدخول بحساب أول مستخدم في الداتابيز (اللي هو المدير العام اللي سويناه بالسيدر)
    auth()->loginUsingId(1);
    return redirect()->route('employees.index');
});

// مسارات لوحة التحكم (محمية بتسجيل الدخول وبصلاحية المدير)
Route::middleware(['auth', 'admin'])->group(function () {

    // سطر واحد فقط يبني لك كل الروابط (index, create, store, edit, update, destroy)
    Route::resource('employees', EmployeeController::class);

});
