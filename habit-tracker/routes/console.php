<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    // جلب المستخدمين اللي عندهم عادات ما كملوها اليوم
    $users = User::whereHas('habits', function($query) {
        $query->whereDoesntHave('logs', function($q) {
            $q->whereDate('completed_date', now());
        });
    })->get();

    foreach ($users as $user) {
        // هنا يمكن إرسال إشعار حقيقي باستخدام Notification Class
        // مثال: $user->notify(new HabitReminderNotification());
        // حالياً سنكتفي بتسجيل في اللوج كإثبات للمفهوم
        \Illuminate\Support\Facades\Log::info("Reminder sent to user: {$user->id}");
    }
})->dailyAt('20:00');
