<?php

namespace App\Services;

use App\Models\Setting;
use Carbon\Carbon;
use App\Models\Appointment;

class AppointmentService
{
    // build and return available slots for a doctor on a specific date
    public function generateAvailableSlots($doctor, $date)
    {
        // 1. Get appointment duration from settings (Default 15 min)
        $duration = Setting::where('key', 'appointment_duration')->value('value') ?? 15;

        // 2. Get doctor's schedule for this day
        $dayName = Carbon::parse($date)->format('l');
        $schedule = $doctor->schedules()->where('day_of_week', $dayName)->first();

        if (!$schedule) return [];

        // 3. Get already booked slots
        $bookedSlots = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $date)
            ->whereIn('status', ['confirmed', 'pending'])
            ->pluck('start_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $slots = [];
        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);
        $isToday = Carbon::parse($date)->isToday();

        // 4. Split schedule into slots
        while ($start->copy()->addMinutes($duration) <= $end) {
            $timeSlot = $start->format('H:i');

            // Check if the slot is in the past (for today)
            $isPastTime = $isToday && Carbon::parse($date . ' ' . $timeSlot)->isPast();

            // Add slot only if not booked and not in the past
            if (!in_array($timeSlot, $bookedSlots) && !$isPastTime) {
                $slots[] = [
                    'start' => $timeSlot,
                    'end' => $start->copy()->addMinutes($duration)->format('H:i'),
                ];
            }
            $start->addMinutes($duration);
        }

        return $slots;
    }
}
