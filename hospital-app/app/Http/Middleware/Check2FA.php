<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Check2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // إذا كان اليوزر مسجل دخول ومفعل الـ 2FA وعنده OTP لم يتم التحقق منه بعد (ليس null)
        if ($user && $user->two_factor_enabled && $user->otp !== null) {
            return response()->json([
                'status' => 'Error',
                'message' => 'يرجى إكمال التحقق الثنائي (2FA) أولاً',
                'requires_2fa' => true
            ], 403);
        }

        return $next($request);
    }
}
