<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SecurityAlertMail;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChangePasswordController extends Controller
{
    use HttpResponses;

    // this for store /api/change-password
    public function __invoke(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->error(null, 'كلمة المرور الحالية غير صحيحة', 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // محاولة إرسال التنبيه الأمني مع تسجيل أي خطأ
        try {
            Mail::to($user->email)->send(new SecurityAlertMail($user, 'password_changed', [
                'ip' => $request->ip(),
                'device' => $request->userAgent(),
                'time' => now()->toDateTimeString(),
            ]));
        } catch (\Exception $e) {
            Log::error('فشل إرسال تنبيه تغيير كلمة المرور: ' . $e->getMessage());
        }

        return $this->success([
            'user_id' => $user->id,
            'email' => $user->email,
            'updated_at' => now()->toDateTimeString()
        ], 'تم تغيير كلمة المرور بنجاح');
    }
}
