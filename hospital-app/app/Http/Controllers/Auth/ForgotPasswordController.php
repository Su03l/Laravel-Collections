<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    use HttpResponses;

    public function __invoke(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        Mail::to($user->email)->send(new ResetPasswordMail($otp));

        return $this->success([
            'email' => $user->email,
            'message' => 'تم إرسال الرمز بنجاح'
        ], 'تم إرسال رمز إعادة التعيين لإيميلك');
    }
}
