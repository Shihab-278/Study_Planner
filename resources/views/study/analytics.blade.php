<x-layouts.study title="Analytics">
    <div class="space-y-6">
        {{-- Period Selector --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Study Analytics</h2>
                <p class="text-sm text-gray-400 mt-0.5">Track your learning journey</p>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="gradient-border bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Monthly Focus</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ floor($monthlyMinutes / 60) }}h {{ round($monthlyMinutes % 60) }}m</p>
                <p class="text-xs text-gray-400 mt-1">Last 30 days</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Sessions</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $monthlySessionCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Last 30 days</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Daily Average</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $avgDailyMinutes }}m</p>
                <p class="text-xs text-gray-400 mt-1">Based on last 7 days</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Task Completion</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</p>
                <p class="text-xs text-gray-400 mt-1">{{ $completedTasks }}/{{ $totalTasks }} tasks</p>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Weekly Focus Chart --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Weekly Focus Time</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Minutes spent per day</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                </div>
                <canvas id="weeklyFocusChart" height="220"></canvas>
            </div>

            {{-- Subject Distribution --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Tasks by Subject</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Distribution across subjects</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    </div>
                </div>
                @if($subjectData->isNotEmpty())
                    <canvas id="subjectChart" height="220"></canvas>
                @else
                    <div class="flex flex-col items-center justify-center h-48 text-center">
                        <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">No subjects yet</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Task Progress --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Task Progress</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Completed vs pending</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                @if($totalTasks > 0)
                    <div class="flex items-center justify-center">
                        <div class="relative">
                            <canvas id="taskProgressChart" width="200" height="200"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-gray-900">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</span>
                                <span class="text-[11px] text-gray-400 font-semibold">Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            <span class="text-xs text-gray-500">Completed ({{ $completedTasks }})</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-gray-200"></div>
                            <span class="text-xs text-gray-500">Pending ({{ $totalTasks - $completedTasks }})</span>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-48 text-center">
                        <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">No tasks yet</p>
                    </div>
                @endif
            </div>

            {{-- Subject Progress Table --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Subject Progress</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Task completion by subject</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
                @if($subjectData->isNotEmpty())
                    <div class="space-y-5">
                        @foreach($subjectData as $subject)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ $subject['color'] }}"></div>
                                        <span class="text-sm font-semibold text-gray-800">{{ $subject['name'] }}</span>
                                    </div>
                                    <span class="text-xs font-semibold tabular-nums" style="color: {{ $subject['color'] }}">{{ $subject['completed'] }}/{{ $subject['total'] }}</span>
                                </div>
                                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500" style="width: {{ $subject['total'] > 0 ? ($subject['completed'] / $subject['total']) * 100 : 0 }}%; background-color: {{ $subject['color'] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-48 text-center">
                        <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">No subjects yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const weeklyData = @json($weeklyData);
            const subjectData = @json($subjectData);
            const totalTasks = {{ $totalTasks }};
            const completedTasks = {{ $completedTasks }};

            // Weekly Focus Chart — area style
            new Chart(document.getElementById('weeklyFocusChart'), {
                type: 'line',
                data: {
                    labels: weeklyData.map(d => d.day),
                    datasets: [{
                        label: 'Focus (min)',
                        data: weeklyData.map(d => d.minutes),
                        borderColor: '#6366f1',
                        backgroundColor: (ctx) => {
                            const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, ctx.chart.height);
                            g.addColorStop(0, 'rgba(99, 102, 241, 0.15)');
                            g.addColorStop(1, 'rgba(99, 102, 241, 0.01)');
                            return g;
                        },
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f8fafc', drawBorder: false }, ticks: { callback: v => v + 'm', font: { size: 11 }, color: '#9ca3af' } },
                        x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af' } }
                    }
                }
            });

            // Subject Distribution
            if (subjectData.length > 0) {
                new Chart(document.getElementById('subjectChart'), {
                    type: 'doughnut',
                    data: {
                        labels: subjectData.map(s => s.name),
                        datasets: [{
                            data: subjectData.map(s => s.total),
                            backgroundColor: subjectData.map(s => s.color),
                            borderWidth: 3,
                            borderColor: '#fff',
                            hoverOffset: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 16, usePointStyle: true, pointStyleWidth: 10, font: { size: 12 } }
                            }
                        },
                        cutout: '68%',
                    }
                });
            }

            // Task Progress
            if (totalTasks > 0) {
                new Chart(document.getElementById('taskProgressChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Completed', 'Pending'],
                        datasets: [{
                            data: [completedTasks, totalTasks - completedTasks],
                            backgroundColor: ['#10b981', '#f3f4f6'],
                            borderWidth: 0,
                            hoverOffset: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        cutout: '75%',
                    }
                });
            }
        });
    </script>
</x-layouts.study>
