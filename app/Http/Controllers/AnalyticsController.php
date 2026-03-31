<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Weekly focus data (last 7 days)
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $minutes = $user->pomodoroSessions()
                ->where('type', 'focus')
                ->whereNotNull('completed_at')
                ->whereDate('completed_at', $date)
                ->sum('duration') / 60;
            $weeklyData[] = [
                'day' => $date->format('D'),
                'date' => $date->format('M d'),
                'minutes' => round($minutes),
            ];
        }

        // Subject distribution
        $subjectData = $user->subjects()
            ->withCount(['tasks', 'tasks as completed_tasks_count' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->get()
            ->map(fn ($s) => [
                'name' => $s->name,
                'color' => $s->color,
                'total' => $s->tasks_count,
                'completed' => $s->completed_tasks_count,
            ]);

        // Monthly data (last 30 days)
        $monthlyMinutes = $user->pomodoroSessions()
            ->where('type', 'focus')
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', Carbon::today()->subDays(30))
            ->sum('duration') / 60;

        $monthlySessionCount = $user->pomodoroSessions()
            ->where('type', 'focus')
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', Carbon::today()->subDays(30))
            ->count();

        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();

        // Daily average
        $avgDailyMinutes = count($weeklyData) > 0
            ? round(collect($weeklyData)->avg('minutes'))
            : 0;

        return view('study.analytics', compact(
            'weeklyData',
            'subjectData',
            'monthlyMinutes',
            'monthlySessionCount',
            'totalTasks',
            'completedTasks',
            'avgDailyMinutes',
        ));
    }
}
