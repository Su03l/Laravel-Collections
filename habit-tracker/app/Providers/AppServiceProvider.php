<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تسجيل دخول تلقائي لأول مستخدم في قاعدة البيانات (لأغراض التطوير فقط)
        if (app()->environment('local')) {
            try {
                $user = User::first();
                if ($user) {
                    Auth::login($user);
                } else {
                    // إنشاء مستخدم افتراضي إذا لم يوجد
                    $user = User::create([
                        'name' => 'Test User',
                        'email' => 'test@example.com',
                        'password' => bcrypt('password'),
                    ]);
                    Auth::login($user);
                }
            } catch (\Exception $e) {
                // تجاهل الخطأ في حالة عدم وجود الجداول بعد
            }
        }
    }
}
