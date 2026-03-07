<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

// مسارات لوحة التحكم (محمية بتسجيل الدخول وبصلاحية المدير)
Route::middleware(['auth', 'admin'])->group(function () {

    // سطر واحد فقط يبني لك كل الروابط (index, create, store, edit, update, destroy)
    Route::resource('employees', EmployeeController::class);

});
