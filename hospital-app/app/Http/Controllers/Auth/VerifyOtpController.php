<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\LoginActivity;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyOtpController extends Controller
{
    use HttpResponses;

    // this for store /api/verify-otp
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // التحقق من صحة OTP
        if ($user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return $this->error(null, 'رمز التحقق غير صحيح أو منتهي الصلاحية', 400);
        }

        $isFirstTime = $user->email_verified_at === null;

        // تصفير الـ OTP بعد الاستخدام الناجح
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => $user->email_verified_at ?? now(), // تفعيل الإيميل إذا لم يكن مفعل
        ]);

        // إرسال رسالة ترحيبية عند أول تفعيل للحساب
        if ($isFirstTime) {
            Mail::to($user->email)->send(new WelcomeMail($user));
        }

        // تسجيل نشاط الدخول
        LoginActivity::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token,
        ], 'تم التحقق بنجاح وتسجيل الدخول');
    }
}
