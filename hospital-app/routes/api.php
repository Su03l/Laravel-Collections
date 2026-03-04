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
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Auth
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/register', RegisterController::class); // Register
    Route::post('/login', LoginController::class);
    Route::post('/forgot-password', ForgotPasswordController::class);
    Route::post('/reset-password', ResetPasswordController::class);
});

// Public Info
Route::get('/hospitals', [HospitalController::class, 'index']);
Route::get('/clinics', [HospitalController::class, 'getClinics']);
Route::get('/doctors', [DoctorController::class, 'index']); // List Doctors
Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);
Route::post('/doctors/{doctor}/slots', [DoctorController::class, 'availableSlots']);

// Shared Medical Record (Public Access via Token)
Route::get('/shared/view/{token}', [SharingController::class, 'viewShared']);

// OTP Verification
Route::middleware('throttle:3,5')->group(function () {
    Route::post('/verify-otp', VerifyOtpController::class);
});
Route::middleware('throttle:otp-requests')->post('/resend-otp', ResendOtpController::class);


/*
|--------------------------------------------------------------------------
| المسارات المحمية (Protected Routes - Sanctum & 2FA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', '2fa'])->group(function () {

    // Logout & Security
    Route::post('/logout', LogoutController::class);
    Route::post('/toggle-2fa', TwoFactorController::class);
    Route::post('/change-password', ChangePasswordController::class);

    // User Profile
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user()->load('patientProfile'));
    });
    Route::post('/update-avatar', [AvatarController::class, 'update']);

    // Notifications (Common)
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    /*
    |----------------------------------------------------------------------
    | 2. بوابة المريض (Patient Routes)
    |----------------------------------------------------------------------
    */
    Route::prefix('patient')->middleware('role:patient')->group(function () {
        // Profile
        Route::post('/update-medical-profile', UpdateProfileController::class);

        // Appointments
        Route::get('/appointments/slots', [AppointmentController::class, 'getAvailableSlots']);
        Route::post('/appointments/book', [AppointmentController::class, 'book']);
        Route::get('/appointments/my-list', [AppointmentController::class, 'myAppointments']);
        Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
        Route::post('/appointments/{id}/reschedule', [AppointmentController::class, 'update']);

        // Reviews
        Route::post('/appointments/{appointment}/review', [ReviewController::class, 'store']);

        // Medical Records & Sharing
        Route::get('/medical-attachments/{attachment}/download', [AttachmentController::class, 'download']);
        Route::get('/medical-records/{record}/prescription', [AttachmentController::class, 'downloadPrescription']);
        Route::post('/medical-consent/grant', [ConsentController::class, 'grant']);
        Route::post('/medical-consent/revoke', [ConsentController::class, 'revoke']);
        Route::post('/medical-records/{record}/share', [SharingController::class, 'createToken']);
    });

    /*
    |----------------------------------------------------------------------
    | 3. بوابة الدكتور (Doctor Routes)
    |----------------------------------------------------------------------
    */
    Route::prefix('doctor')->middleware('role:doctor')->group(function () {
        // Schedule & Appointments
        // Note: Doctor schedule management is currently in Admin/DoctorManagementController,
        // but doctors should be able to manage their own schedule too.
        // For now, we use AppointmentController for attendance.
        Route::post('/appointments/{id}/attend', [AppointmentController::class, 'markAsAttended']);

        // Medical Records
        Route::get('/patient/{patient}/history', [HistoryController::class, 'getPatientHistory']);
        Route::post('/appointments/{appointment}/record', [RecordManagementController::class, 'store']);
        Route::get('/appointments/{appointment}/record', [RecordManagementController::class, 'show']);
        Route::put('/medical-records/{record}', [RecordManagementController::class, 'update']);
    });

    /*
    |----------------------------------------------------------------------
    | 4. بوابة الإدارة (Admin Routes)
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard/stats', [DoctorManagementController::class, 'dashboardStats']);

        // Doctors Management
        Route::post('/doctors', [DoctorManagementController::class, 'store']);
        Route::post('/doctors/{doctor}/schedule', [DoctorManagementController::class, 'updateSchedule']);

        // Clinics Management
        Route::post('/clinics', [AdminClinicController::class, 'store']);

        // Users Management
        Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus']);
    });

});
