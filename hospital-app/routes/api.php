<?php

use App\Http\Controllers\Api\Admin\AdminClinicController;
use App\Http\Controllers\Api\Admin\DoctorManagementController;
use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\MedicalRecord\AttachmentController;
use App\Http\Controllers\Api\MedicalRecord\ConsentController;
use App\Http\Controllers\Api\MedicalRecord\HistoryController;
use App\Http\Controllers\Api\MedicalRecord\RecordManagementController;
use App\Http\Controllers\Api\MedicalRecord\SharingController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ReviewController;
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
    Route::post('/register', RegisterController::class); // register with rate limiting
    Route::post('/login', LoginController::class);
    Route::post('/forgot-password', ForgotPasswordController::class);
    Route::post('/reset-password', ResetPasswordController::class);
});

// Public Routes (No Auth Required)
Route::get('/hospitals', [HospitalController::class, 'index']);
Route::get('/clinics', [HospitalController::class, 'getClinics']);
Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);
Route::post('/doctors/{doctor}/slots', [DoctorController::class, 'availableSlots']);

// Shared Medical Record (Public Access via Token)
Route::get('/shared/view/{token}', [SharingController::class, 'viewShared']);

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

    // Appointment Routes
    Route::get('/appointments/slots', [AppointmentController::class, 'getAvailableSlots']);
    Route::post('/appointments/book', [AppointmentController::class, 'book']);
    Route::get('/appointments/my-appointments', [AppointmentController::class, 'myAppointments']);
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
    Route::post('/appointments/{id}/reschedule', [AppointmentController::class, 'update']);
    Route::post('/appointments/{id}/attend', [AppointmentController::class, 'markAsAttended']);

    // Reviews
    Route::post('/appointments/{appointment}/review', [ReviewController::class, 'store']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // Medical Records Routes
    Route::post('/appointments/{appointment}/medical-record', [RecordManagementController::class, 'store']);
    Route::get('/appointments/{appointment}/medical-record', [RecordManagementController::class, 'show']);
    Route::put('/medical-records/{record}', [RecordManagementController::class, 'update']);

    // Attachments & Prescriptions
    Route::get('/medical-attachments/{attachment}', [AttachmentController::class, 'download']);
    Route::get('/medical-records/{record}/prescription', [AttachmentController::class, 'downloadPrescription']);

    // History
    Route::get('/patients/{patient}/history', [HistoryController::class, 'getPatientHistory']);

    // Consent & Sharing
    Route::post('/medical-consent/grant', [ConsentController::class, 'grant']);
    Route::post('/medical-consent/revoke', [ConsentController::class, 'revoke']);
    Route::post('/medical-records/{record}/share', [SharingController::class, 'createToken']);
});

// Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/stats', [DoctorManagementController::class, 'dashboardStats']);

    // doctors management
    Route::post('/doctors', [DoctorManagementController::class, 'store']);
    Route::post('/doctors/{doctor}/schedule', [DoctorManagementController::class, 'updateSchedule']);

    // clinics management
    Route::post('/clinics', [AdminClinicController::class, 'store']);

    // users management
    Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus']);
});
