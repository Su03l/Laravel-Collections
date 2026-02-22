<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use HttpResponses;

    // this for store /api/reset-password
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        // التحقق من صحة OTP
        if ($user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return $this->error(null, 'رمز التحقق غير صحيح أو منتهي الصلاحية', 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return $this->success([
            'email' => $user->email,
            'message' => 'تم تحديث كلمة المرور بنجاح، يمكنك الآن تسجيل الدخول'
        ], 'تم تغيير كلمة المرور بنجاح');
    }
}
