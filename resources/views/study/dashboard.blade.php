<x-layouts.study title="Dashboard">
    {{-- Greeting --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ auth()->user()->name }}! 👋</h2>
        <p class="text-gray-500 mt-1">Here's your study progress for today.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Today's Focus Time --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Focus</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ floor($todayFocusSeconds / 3600) }}h {{ floor(($todayFocusSeconds % 3600) / 60) }}m</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $todaySessions }} sessions today</p>
        </div>

        {{-- Total Focus Time --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Focus</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ floor($totalFocusSeconds / 3600) }}h {{ floor(($totalFocusSeconds % 3600) / 60) }}m</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">All time</p>
        </div>

        {{-- Completed Tasks --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Completed Tasks</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $completedTasks }}/{{ $totalTasks }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}% completion rate</p>
        </div>

        {{-- Subjects --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Subjects</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSubjects }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $pendingTasks }} pending tasks</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Weekly Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Weekly Focus Time</h3>
            <canvas id="weeklyChart" height="200"></canvas>
        </div>

        {{-- Recent Tasks --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900">Upcoming Tasks</h3>
                <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
            </div>
            @forelse($recentTasks as $task)
                <div class="flex items-start gap-3 py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="mt-0.5 w-5 h-5 rounded-full border-2 border-gray-300 hover:border-indigo-500 flex-shrink-0 transition"></button>
                    </form>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $task->title }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($task->subject)
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $task->subject->color }}"></span>
                                    {{ $task->subject->name }}
                                </span>
                            @endif
                            @if($task->deadline)
                                <span class="text-xs {{ $task->deadline->isPast() ? 'text-red-500' : 'text-gray-400' }}">
                                    {{ $task->deadline->format('M d') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded-full font-medium
                        {{ $task->priority === 'high' ? 'bg-red-50 text-red-700' : ($task->priority === 'medium' ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700') }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-400 py-4 text-center">No pending tasks. Add one!</p>
            @endforelse
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('tasks.create') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow-sm transition group">
            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 transition">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">New Task</p>
                <p class="text-xs text-gray-500">Add a study task</p>
            </div>
        </a>
        <a href="{{ route('pomodoro.index') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow-sm transition group">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">Start Focus</p>
                <p class="text-xs text-gray-500">Begin a Pomodoro session</p>
            </div>
        </a>
        <a href="{{ route('subjects.create') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow-sm transition group">
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">New Subject</p>
                <p class="text-xs text-gray-500">Organize your studies</p>
            </div>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const weeklyData = @json($weeklyData);
            new Chart(document.getElementById('weeklyChart'), {
                type: 'bar',
                data: {
                    labels: weeklyData.map(d => d.day),
                    datasets: [{
                        label: 'Focus (min)',
                        data: weeklyData.map(d => d.minutes),
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { callback: v => v + 'm' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-layouts.study>
