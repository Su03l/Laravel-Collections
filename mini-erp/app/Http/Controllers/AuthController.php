<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. التحقق من البيانات وتوجيه المستخدم
    public function login(Request $request)
    {
        // التحقق من المدخلات
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // التوجيه الذكي بناءً على الصلاحية (Role-based Redirect)
            if (auth()->user()->role === 'admin') {
                return redirect()->intended(route('employees.index'));
            }

            // إذا كان موظف عادي، نوجهه للوحة الخاصة فيه
            return redirect()->intended(route('employee.dashboard'));
        }

        // إذا البيانات خطأ، نرجعه مع رسالة
        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة، تأكد من الإيميل أو الرقم السري.',
        ])->onlyInput('email');
    }

    // 3. تسجيل الخروج
    public function logout(Request $request)
    {
        // تسجيل الخروج
        Auth::logout();

        //  إلغاء الجلسة
        $request->session()->invalidate();

        // تجديد رمز الجلسة
        $request->session()->regenerateToken();

        // التوجيه إلى صفحة تسجيل الدخول
        return redirect()->route('login');
    }
}
