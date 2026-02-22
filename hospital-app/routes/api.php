<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendOtpController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\VerifyOtpController;
use App\Http\Controllers\Patient\AvatarController;
use App\Http\Controllers\Patient\UpdateProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Routes with Rate Limiting
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/forgot-password', ForgotPasswordController::class);
    Route::post('/reset-password', ResetPasswordController::class);
});

// OTP Verification with stricter Rate Limiting (3 attempts per 5 minutes)
Route::middleware('throttle:3,5')->group(function () {
    Route::post('/verify-otp', VerifyOtpController::class);
});

// Resend OTP with custom Rate Limiter
Route::middleware('throttle:otp-requests')->post('/resend-otp', ResendOtpController::class);

Route::middleware(['auth:sanctum', '2fa'])->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::post('/toggle-2fa', TwoFactorController::class);
    Route::post('/change-password', ChangePasswordController::class);

    // Patient Routes
    Route::post('/update-medical-profile', UpdateProfileController::class);
    Route::post('/update-avatar', [AvatarController::class, 'update']);

    Route::get('/user', function (Request $request) {
        return new \App\Http\Resources\UserResource($request->user()->load('patientProfile'));
    });
});
