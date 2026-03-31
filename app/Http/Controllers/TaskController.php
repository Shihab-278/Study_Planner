<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->tasks()->with('subject')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->paginate(15)->withQueryString();
        $subjects = $request->user()->subjects()->orderBy('name')->get();

        return view('study.tasks.index', compact('tasks', 'subjects'));
    }

    public function create(Request $request)
    {
        $subjects = $request->user()->subjects()->orderBy('name')->get();

        return view('study.tasks.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subject_id' => 'nullable|exists:subjects,id',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        if ($validated['subject_id'] ?? null) {
            $subject = $request->user()->subjects()->findOrFail($validated['subject_id']);
        }

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit(Request $request, Task $task)
    {
        $this->authorize($task);

        $subjects = $request->user()->subjects()->orderBy('name')->get();

        return view('study.tasks.edit', compact('task', 'subjects'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize($task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subject_id' => 'nullable|exists:subjects,id',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        if ($validated['subject_id'] ?? null) {
            $subject = $request->user()->subjects()->findOrFail($validated['subject_id']);
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function toggleStatus(Task $task)
    {
        $this->authorize($task);

        $task->update([
            'status' => $task->status === 'pending' ? 'completed' : 'pending',
        ]);

        return back()->with('success', 'Task status updated!');
    }

    public function destroy(Task $task)
    {
        $this->authorize($task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    private function authorize(Task $task): void
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
