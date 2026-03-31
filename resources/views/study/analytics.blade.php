<x-layouts.study title="Analytics">
    <div class="space-y-6">
        {{-- Stats row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Monthly Focus</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ floor($monthlyMinutes / 60) }}h {{ round($monthlyMinutes % 60) }}m</p>
                <p class="text-xs text-gray-400 mt-1">Last 30 days</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Sessions</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $monthlySessionCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Last 30 days</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Daily Average</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $avgDailyMinutes }}m</p>
                <p class="text-xs text-gray-400 mt-1">Based on last 7 days</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Task Completion</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</p>
                <p class="text-xs text-gray-400 mt-1">{{ $completedTasks }}/{{ $totalTasks }} tasks</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Weekly Focus Chart --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Weekly Focus Time</h3>
                <canvas id="weeklyFocusChart" height="250"></canvas>
            </div>

            {{-- Subject Distribution --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Tasks by Subject</h3>
                @if($subjectData->isNotEmpty())
                    <canvas id="subjectChart" height="250"></canvas>
                @else
                    <div class="flex items-center justify-center h-48 text-gray-400 text-sm">
                        No subjects yet. Create subjects to see the distribution.
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Task Completion Chart --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Task Progress</h3>
                @if($totalTasks > 0)
                    <canvas id="taskProgressChart" height="250"></canvas>
                @else
                    <div class="flex items-center justify-center h-48 text-gray-400 text-sm">
                        No tasks yet. Create tasks to track progress.
                    </div>
                @endif
            </div>

            {{-- Subject Progress Table --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Subject Progress</h3>
                @if($subjectData->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($subjectData as $subject)
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $subject['color'] }}"></span>
                                        <span class="text-sm font-medium text-gray-900">{{ $subject['name'] }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $subject['completed'] }}/{{ $subject['total'] }}</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" style="width: {{ $subject['total'] > 0 ? ($subject['completed'] / $subject['total']) * 100 : 0 }}%; background-color: {{ $subject['color'] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center justify-center h-48 text-gray-400 text-sm">
                        No subjects yet.
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

            // Weekly Focus Chart
            new Chart(document.getElementById('weeklyFocusChart'), {
                type: 'line',
                data: {
                    labels: weeklyData.map(d => d.day + '\n' + d.date),
                    datasets: [{
                        label: 'Focus (min)',
                        data: weeklyData.map(d => d.minutes),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366f1',
                        pointRadius: 5,
                        pointHoverRadius: 7,
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

            // Subject Distribution
            if (subjectData.length > 0) {
                new Chart(document.getElementById('subjectChart'), {
                    type: 'doughnut',
                    data: {
                        labels: subjectData.map(s => s.name),
                        datasets: [{
                            data: subjectData.map(s => s.total),
                            backgroundColor: subjectData.map(s => s.color),
                            borderWidth: 2,
                            borderColor: '#fff',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 16, usePointStyle: true }
                            }
                        },
                        cutout: '65%',
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
                            backgroundColor: ['#22c55e', '#e5e7eb'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 16, usePointStyle: true }
                            }
                        },
                        cutout: '70%',
                    }
                });
            }
        });
    </script>
</x-layouts.study>
