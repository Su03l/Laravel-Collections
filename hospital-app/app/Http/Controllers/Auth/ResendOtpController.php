<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResendOtpController extends Controller
{
    use HttpResponses;

    // this for store /api/resend-otp
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // التحقق من عدم وجود حظر مؤقت (اختياري، لكن الـ Rate Limiter يكفي)

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $expiresAt
        ]);

        // send the mail
        Mail::to($user->email)->send(new OTPMail($user, $otp));

        return $this->success([
            'email' => $user->email,
            'expires_at' => $expiresAt->toDateTimeString(),
            'message' => 'تم إرسال رمز جديد صالح لمدة 10 دقائق'
        ], 'تم إعادة إرسال رمز التحقق بنجاح');
    }
}
