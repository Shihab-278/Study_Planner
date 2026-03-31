<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PomodoroController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()
            ->where('status', 'pending')
            ->with('subject')
            ->orderBy('deadline')
            ->get();

        return view('study.pomodoro', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'nullable|exists:tasks,id',
            'duration' => 'required|integer|min:1',
            'type' => 'required|in:focus,break',
        ]);

        if ($validated['task_id'] ?? null) {
            $request->user()->tasks()->findOrFail($validated['task_id']);
        }

        $request->user()->pomodoroSessions()->create([
            'task_id' => $validated['task_id'],
            'duration' => $validated['duration'],
            'type' => $validated['type'],
            'completed_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
