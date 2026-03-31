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

        // Weekly data for chart
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

        // Study streak calculation
        $streak = 0;
        $checkDate = Carbon::today();
        while (true) {
            $hasSessions = $user->pomodoroSessions()
                ->where('type', 'focus')
                ->whereNotNull('completed_at')
                ->whereDate('completed_at', $checkDate)
                ->exists();
            if ($hasSessions) {
                $streak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }

        // Daily goal (2 hours = 7200 seconds)
        $dailyGoalSeconds = 7200;
        $dailyGoalPercent = min(100, round(($todayFocusSeconds / $dailyGoalSeconds) * 100));

        // Subject progress
        $subjectProgress = $user->subjects()
            ->withCount(['tasks', 'tasks as completed_tasks_count' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->limit(5)
            ->get();

        // Overdue tasks count
        $overdueTasks = $user->tasks()
            ->where('status', 'pending')
            ->whereNotNull('deadline')
            ->where('deadline', '<', $today)
            ->count();

        // Motivational quotes
        $quotes = [
            ['text' => 'The secret of getting ahead is getting started.', 'author' => 'Mark Twain'],
            ['text' => 'It always seems impossible until it\'s done.', 'author' => 'Nelson Mandela'],
            ['text' => 'Success is the sum of small efforts repeated day in and day out.', 'author' => 'Robert Collier'],
            ['text' => 'The beautiful thing about learning is that no one can take it away from you.', 'author' => 'B.B. King'],
            ['text' => 'Education is the passport to the future.', 'author' => 'Malcolm X'],
            ['text' => 'The expert in anything was once a beginner.', 'author' => 'Helen Hayes'],
            ['text' => 'Don\'t let what you cannot do interfere with what you can do.', 'author' => 'John Wooden'],
            ['text' => 'The only way to do great work is to love what you do.', 'author' => 'Steve Jobs'],
            ['text' => 'Study hard what interests you the most in the most undisciplined way.', 'author' => 'Richard Feynman'],
            ['text' => 'Live as if you were to die tomorrow. Learn as if you were to live forever.', 'author' => 'Mahatma Gandhi'],
        ];
        $quote = $quotes[array_rand($quotes)];

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
            'streak',
            'dailyGoalPercent',
            'dailyGoalSeconds',
            'subjectProgress',
            'overdueTasks',
            'quote',
        ));
    }
}
