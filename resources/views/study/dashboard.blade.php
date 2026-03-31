<x-layouts.study title="Dashboard">
    {{-- Greeting + Quote --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ auth()->user()->name }}!
                </h2>
                <p class="text-gray-500 mt-1 text-sm italic">"{{ $quote['text'] }}" — {{ $quote['author'] }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if($streak > 0)
                <div class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/60 rounded-xl">
                    <span class="text-xl">🔥</span>
                    <div>
                        <p class="text-lg font-bold text-amber-700 leading-none">{{ $streak }}</p>
                        <p class="text-[10px] text-amber-600 font-medium uppercase tracking-wider">Day Streak</p>
                    </div>
                </div>
                @endif
                @if($overdueTasks > 0)
                <a href="{{ route('tasks.index', ['status' => 'pending']) }}" class="flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200/60 rounded-xl hover:bg-red-100 transition">
                    <span class="text-lg">⚠️</span>
                    <div>
                        <p class="text-lg font-bold text-red-700 leading-none">{{ $overdueTasks }}</p>
                        <p class="text-[10px] text-red-600 font-medium uppercase tracking-wider">Overdue</p>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Daily Goal Progress --}}
        <div class="gradient-border rounded-2xl p-5 bg-white">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Daily Goal</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $dailyGoalPercent }}%</p>
                </div>
                <div class="relative w-14 h-14">
                    <svg class="w-14 h-14 transform -rotate-90" viewBox="0 0 56 56">
                        <circle cx="28" cy="28" r="24" stroke="#f3f4f6" stroke-width="4" fill="none"/>
                        <circle cx="28" cy="28" r="24" stroke="url(#goalGrad)" stroke-width="4" fill="none"
                                stroke-linecap="round"
                                stroke-dasharray="{{ 2 * 3.14159 * 24 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 24 * (1 - $dailyGoalPercent / 100) }}"/>
                    </svg>
                    <svg class="w-0 h-0 absolute">
                        <defs>
                            <linearGradient id="goalGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#6366f1"/>
                                <stop offset="100%" stop-color="#a855f7"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-1000" style="width: {{ $dailyGoalPercent }}%"></div>
            </div>
            <p class="text-[11px] text-gray-400 mt-2">{{ floor($todayFocusSeconds / 3600) }}h {{ floor(($todayFocusSeconds % 3600) / 60) }}m of {{ floor($dailyGoalSeconds / 3600) }}h goal</p>
        </div>

        {{-- Today's Focus --}}
        <div class="gradient-border rounded-2xl p-5 bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Today's Focus</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ floor($todayFocusSeconds / 3600) }}h {{ floor(($todayFocusSeconds % 3600) / 60) }}m</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-[11px] text-gray-400 mt-3">{{ $todaySessions }} sessions completed</p>
        </div>

        {{-- Completed Tasks --}}
        <div class="gradient-border rounded-2xl p-5 bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tasks Done</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $completedTasks }}<span class="text-sm font-normal text-gray-400">/{{ $totalTasks }}</span></p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-400 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden mt-3">
                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400" style="width: {{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%"></div>
            </div>
            <p class="text-[11px] text-gray-400 mt-2">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}% completion rate</p>
        </div>

        {{-- Total Focus --}}
        <div class="gradient-border rounded-2xl p-5 bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Focus</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ floor($totalFocusSeconds / 3600) }}h {{ floor(($totalFocusSeconds % 3600) / 60) }}m</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-400 rounded-xl flex items-center justify-center shadow-lg shadow-violet-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-[11px] text-gray-400 mt-3">{{ $totalSubjects }} subjects · {{ $pendingTasks }} pending</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Weekly Focus Chart --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Weekly Focus Time</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Your study activity this week</p>
                </div>
                <a href="{{ route('analytics.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 px-3 py-1.5 bg-indigo-50 rounded-lg transition">View Details</a>
            </div>
            <canvas id="weeklyChart" height="180"></canvas>
        </div>

        {{-- Upcoming Tasks --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Upcoming Tasks</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $pendingTasks }} tasks remaining</p>
                </div>
                <a href="{{ route('tasks.create') }}" class="w-7 h-7 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 hover:bg-indigo-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </a>
            </div>
            <div class="space-y-1">
                @forelse($recentTasks as $task)
                    <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition group">
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-5 h-5 rounded-full border-2 border-gray-300 hover:border-indigo-500 flex-shrink-0 transition group-hover:border-indigo-400"></button>
                        </form>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $task->title }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                @if($task->subject)
                                    <span class="inline-flex items-center gap-1 text-[11px] text-gray-400">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $task->subject->color }}"></span>
                                        {{ $task->subject->name }}
                                    </span>
                                @endif
                                @if($task->deadline)
                                    <span class="text-[11px] {{ $task->deadline->isPast() ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                        {{ $task->deadline->format('M d') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $task->priority === 'high' ? 'bg-red-400' : ($task->priority === 'medium' ? 'bg-amber-400' : 'bg-emerald-400') }}"></span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-12 h-12 mx-auto bg-gray-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">No pending tasks</p>
                        <a href="{{ route('tasks.create') }}" class="text-xs text-indigo-600 font-medium mt-1 inline-block">Create one</a>
                    </div>
                @endforelse
            </div>
            @if($recentTasks->isNotEmpty())
                <a href="{{ route('tasks.index') }}" class="block text-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 mt-4 pt-4 border-t border-gray-100 transition">
                    View All Tasks →
                </a>
            @endif
        </div>
    </div>

    {{-- Bottom Row: Subject Progress + Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Subject Progress --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Subject Progress</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Track completion across subjects</p>
                </div>
                <a href="{{ route('subjects.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 px-3 py-1.5 bg-indigo-50 rounded-lg transition">All Subjects</a>
            </div>
            @if($subjectProgress->isNotEmpty())
                <div class="space-y-4">
                    @foreach($subjectProgress as $subject)
                        @php $pct = $subject->tasks_count > 0 ? round(($subject->completed_tasks_count / $subject->tasks_count) * 100) : 0; @endphp
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: {{ $subject->color }}15">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $subject->color }}"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <p class="text-sm font-semibold text-gray-800">{{ $subject->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $subject->completed_tasks_count }}/{{ $subject->tasks_count }} tasks · {{ $pct }}%</p>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%; background-color: {{ $subject->color }}"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-sm text-gray-400">No subjects yet</p>
                    <a href="{{ route('subjects.create') }}" class="text-xs text-indigo-600 font-medium mt-1 inline-block">Create your first subject</a>
                </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="space-y-4">
            <a href="{{ route('pomodoro.index') }}" class="group flex items-center gap-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-5 shadow-lg shadow-indigo-500/20 hover:shadow-xl hover:shadow-indigo-500/30 transition-all hover:-translate-y-0.5">
                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-white">Start Focus Session</p>
                    <p class="text-xs text-indigo-200">Begin a Pomodoro timer</p>
                </div>
                <svg class="w-5 h-5 text-white/50 ml-auto group-hover:text-white/80 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="{{ route('tasks.create') }}" class="group flex items-center gap-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">Add New Task</p>
                    <p class="text-xs text-gray-400">Create a study task</p>
                </div>
                <svg class="w-5 h-5 text-gray-300 ml-auto group-hover:text-gray-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="{{ route('analytics.index') }}" class="group flex items-center gap-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-violet-100 transition">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">View Analytics</p>
                    <p class="text-xs text-gray-400">Study insights & charts</p>
                </div>
                <svg class="w-5 h-5 text-gray-300 ml-auto group-hover:text-gray-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weeklyData = @json($weeklyData);
            const ctx = document.getElementById('weeklyChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.15)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: weeklyData.map(d => d.day),
                    datasets: [{
                        label: 'Focus (min)',
                        data: weeklyData.map(d => d.minutes),
                        backgroundColor: weeklyData.map((d, i) => i === weeklyData.length - 1 ? 'rgba(99, 102, 241, 0.9)' : 'rgba(99, 102, 241, 0.3)'),
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 32,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e1b4b',
                            titleFont: { size: 11, weight: '600' },
                            bodyFont: { size: 12 },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: ctx => ctx.parsed.y + ' minutes'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f3f4f6', drawBorder: false },
                            ticks: { callback: v => v + 'm', font: { size: 11 }, color: '#9ca3af' },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11, weight: '500' }, color: '#6b7280' },
                            border: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.study>
