<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PomodoroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudyDashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('study.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Study Planner Routes (all authenticated users)
Route::middleware(['auth'])->prefix('study')->group(function () {
    Route::get('/', StudyDashboardController::class)->name('study.dashboard');

    Route::resource('subjects', SubjectController::class)->except(['show']);
    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');

    Route::get('pomodoro', [PomodoroController::class, 'index'])->name('pomodoro.index');
    Route::post('pomodoro', [PomodoroController::class, 'store'])->name('pomodoro.store');

    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});

// Admin Routes (admin role only)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';
