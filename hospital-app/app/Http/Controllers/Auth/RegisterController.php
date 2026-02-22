<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\OTPMail;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use HttpResponses;

    // this for store /api/register
    public function __invoke(RegisterRequest $request)
    {
        $otp = rand(100000, 999999); // توليد OTP

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // إرسال الإيميل
        Mail::to($user->email)->send(new OTPMail($user, $otp));

        // لا ننشئ توكن هنا، بل ننتظر التحقق من الـ OTP
        return $this->success([
            'user' => new UserResource($user),
            'message' => 'تم إنشاء الحساب بنجاح. يرجى التحقق من بريدك الإلكتروني لتفعيل الحساب.'
        ]);
    }
}
