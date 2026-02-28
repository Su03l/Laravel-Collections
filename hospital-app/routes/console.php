<?php

use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Display an inspiring quote every hour
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Run the ghost cleaner every hour
Schedule::command('appointments:update-missed')->hourly();

// Run daily reminders at 9:00 AM
Schedule::call(function () {
    $tomorrow = now()->addDay()->toDateString();
    $appointments = Appointment::where('appointment_date', $tomorrow)
                    ->where('status', 'confirmed')
                    ->with(['patient', 'doctor'])
                    ->get();

    foreach ($appointments as $app) {
        $app->patient->notify(new AppointmentReminderNotification($app));
    }
})->dailyAt('09:00');
