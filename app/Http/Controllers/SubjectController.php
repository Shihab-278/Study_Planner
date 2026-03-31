<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = $request->user()->subjects()
            ->withCount(['tasks', 'tasks as completed_tasks_count' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->latest()
            ->get();

        return view('study.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('study.subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $request->user()->subjects()->create($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully!');
    }

    public function edit(Subject $subject)
    {
        $this->authorize($subject);

        return view('study.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $this->authorize($subject);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully!');
    }

    public function destroy(Subject $subject)
    {
        $this->authorize($subject);

        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully!');
    }

    private function authorize(Subject $subject): void
    {
        if ($subject->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
