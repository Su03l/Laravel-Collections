<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use App\Services\StreakService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class HabitController extends Controller
{
    // this for testing
    protected $streakService;

    // the constructor
    public function __construct(StreakService $streakService)
    {
        $this->streakService = $streakService;
    }

    // index method for displaying habits list
    public function index()
    {
        // get habits with latest logs for the last 7 days
        $habits = auth()->user()->habits()
            ->with(['logs' => function ($query) {
                $query->whereDate('completed_date', '>=', Carbon::today()->subDays(6));
            }])
            ->latest()
            ->get();

        return Inertia::render('Habits/Index', [
            'habits' => $habits
        ]);
    }

    // show method for displaying a single habit
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string',
        ]);

        auth()->user()->habits()->create($data);

        return redirect()->route('habits.index')->with('message', 'تم إضافة العادة بنجاح!');
    }

    // show method for displaying a single habit
    public function toggleLog(Habit $habit)
    {
        $today = Carbon::today()->toDateString();
        $user = auth()->user();
        $message = '';

        // search for the log for today
        $log = $habit->logs()->whereDate('completed_date', $today)->first();

        if ($log) {
            $log->update(['completed' => !$log->completed]);
            if ($log->completed) {
                $message = 'تم إنجاز العادة! (+10 XP)';
                $user->increment('xp', 10);
            } else {
                $message = 'تم إلغاء الإنجاز. (-10 XP)';
                $user->decrement('xp', 10);
            }
        } else {
            $habit->logs()->create([
                'completed_date' => $today,
                'completed' => true
            ]);
            $message = 'تم إنجاز العادة! (+10 XP)';
            $user->increment('xp', 10);
        }

        // منطق الترقية (كل 100 نقطة مستوى جديد)
        // نستخدم max(1, ...) لضمان عدم نزول المستوى عن 1
        $newLevel = max(1, floor($user->xp / 100) + 1);

        if ($newLevel > $user->level) {
            $user->update(['level' => $newLevel]);
            $message .= "  مبروك! وصلت للمستوى {$newLevel}";
        } elseif ($newLevel < $user->level) {
             $user->update(['level' => $newLevel]);
        }

        // تحديث الـ Streak بعد كل عملية تغيير
        $this->streakService->calculateStreak($habit);

        return redirect()->back()->with('message', $message);
    }

    // show method for displaying a single habit
    public function stats()
    {
        $stats = auth()->user()->habits()->withCount(['logs as completed_count' => function ($query) {
            $query->where('completed', true);
        }])->get()->map(function ($habit) {
            $daysSinceCreation = $habit->created_at->diffInDays(now());
            $efficiency = $daysSinceCreation > 0
                ? round(($habit->completed_count / $daysSinceCreation) * 100)
                : ($habit->completed_count > 0 ? 100 : 0);

            return [
                'name' => $habit->name,
                'completed' => $habit->completed_count,
                'streak' => $habit->current_streak,
                'best_streak' => $habit->best_streak, // نحتاج هذا للأوسمة
                'efficiency' => min(100, $efficiency)
            ];
        });

        return Inertia::render('Habits/Stats', [
            'stats' => $stats
        ]);
    }

    // show method for displaying a single habit
    public function export()
    {
        $habits = auth()->user()->habits()->with('logs')->get();

        $fileName = 'habit_sync_report_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($habits) {
            $file = fopen('php://output', 'w');
            // كتابة العناوين (Headers)
            fputcsv($file, ['اسم العادة', 'التاريخ', 'الحالة', 'الـ Streak وقتها']);

            foreach ($habits as $habit) {
                foreach ($habit->logs as $log) {
                    fputcsv($file, [
                        $habit->name,
                        $log->completed_date->format('Y-m-d'),
                        $log->completed ? 'مكتمل' : 'غير مكتمل',
                        $habit->current_streak
                    ]);
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
