<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Mail\OTPMail;
use App\Mail\SecurityAlertMail;
use App\Models\LoginActivity;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    use HttpResponses;

    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error(null, 'بيانات الدخول غير صحيحة', 401);
        }

        if (!$user->email_verified_at) {
            $otp = rand(100000, 999999);
            $user->update(['otp' => $otp, 'otp_expires_at' => now()->addMinutes(10)]);
            Mail::to($user->email)->send(new OTPMail($user, $otp));
            return $this->error(null, 'يرجى تفعيل حسابك أولاً. تم إرسال رمز جديد.', 403);
        }

        if ($user->two_factor_enabled) {
            $otp = rand(100000, 999999);
            $user->update(['otp' => $otp, 'otp_expires_at' => now()->addMinutes(5)]);
            Mail::to($user->email)->send(new OTPMail($user, $otp));
            return $this->success(['requires_2fa' => true, 'message' => 'يرجى إدخال رمز التحقق الثنائي']);
        }

        LoginActivity::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            Mail::to($user->email)->send(new SecurityAlertMail($user, 'login', [
                'ip' => $request->ip(),
                'device' => $request->userAgent(),
                'time' => now()->toDateTimeString(),
            ]));
        } catch (\Exception $e) {
            Log::error('فشل إرسال تنبيه تسجيل الدخول: ' . $e->getMessage());
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->success([
            'user' => new UserResource($user->load('patientProfile')),
            'token' => $token
        ]);
    }
}
