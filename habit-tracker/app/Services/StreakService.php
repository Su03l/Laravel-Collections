<?php

namespace App\Services;

use App\Models\Habit;
use Carbon\Carbon;

class StreakService
{
    // to calculate the streak
    public function calculateStreak(Habit $habit)
    {
        $streak = 0;
        $date = Carbon::today();

        // نجلب تواريخ الإكمال مرتبة تنازلياً
        $completedDates = $habit->logs()
            ->where('completed', true)
            ->orderBy('completed_date', 'desc')
            ->pluck('completed_date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();

        // إذا لم يسجل اليوم، نبدأ الفحص من أمس
        if (!in_array($date->format('Y-m-d'), $completedDates)) {
            $date->subDay();
        }

        // حلقة تكرارية لفحص الأيام المتتالية
        while (in_array($date->format('Y-m-d'), $completedDates)) {
            $streak++;
            $date->subDay();
        }

        $habit->update([
            'current_streak' => $streak,
            'best_streak' => max($streak, $habit->best_streak)
        ]);

        return $streak;
    }
}
