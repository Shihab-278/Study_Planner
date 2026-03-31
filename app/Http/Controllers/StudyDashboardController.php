<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudyDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();

        $totalSubjects = $user->subjects()->count();
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();
        $pendingTasks = $user->tasks()->where('status', 'pending')->count();

        $todayFocusSeconds = $user->pomodoroSessions()
            ->where('type', 'focus')
            ->whereNotNull('completed_at')
            ->whereDate('completed_at', $today)
            ->sum('duration');

        $totalFocusSeconds = $user->pomodoroSessions()
            ->where('type', 'focus')
            ->whereNotNull('completed_at')
            ->sum('duration');

        $todaySessions = $user->pomodoroSessions()
            ->where('type', 'focus')
            ->whereNotNull('completed_at')
            ->whereDate('completed_at', $today)
            ->count();

        $recentTasks = $user->tasks()
            ->with('subject')
            ->where('status', 'pending')
            ->orderBy('deadline')
            ->limit(5)
            ->get();

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
                'minutes' => round($minutes),
            ];
        }

        return view('study.dashboard', compact(
            'totalSubjects',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'todayFocusSeconds',
            'totalFocusSeconds',
            'todaySessions',
            'recentTasks',
            'weeklyData',
        ));
    }
}
