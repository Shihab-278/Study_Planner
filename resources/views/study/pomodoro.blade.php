<x-layouts.study title="Pomodoro Timer">
    <div x-data="pomodoroTimer()" x-init="init()" class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Timer --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center">
                    {{-- Mode Tabs --}}
                    <div class="inline-flex bg-gray-100 rounded-lg p-1 mb-8">
                        <button @click="setMode('focus')"
                                :class="mode === 'focus' ? 'bg-indigo-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-md transition">
                            Focus
                        </button>
                        <button @click="setMode('short_break')"
                                :class="mode === 'short_break' ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-md transition">
                            Short Break
                        </button>
                        <button @click="setMode('long_break')"
                                :class="mode === 'long_break' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-md transition">
                            Long Break
                        </button>
                    </div>

                    {{-- Circular Timer --}}
                    <div class="relative w-64 h-64 mx-auto mb-8">
                        <svg class="w-64 h-64 transform -rotate-90" viewBox="0 0 256 256">
                            <circle cx="128" cy="128" r="120" stroke="#f3f4f6" stroke-width="8" fill="none"/>
                            <circle cx="128" cy="128" r="120"
                                    :stroke="mode === 'focus' ? '#6366f1' : (mode === 'short_break' ? '#22c55e' : '#3b82f6')"
                                    stroke-width="8" fill="none"
                                    stroke-linecap="round"
                                    :stroke-dasharray="circumference"
                                    :stroke-dashoffset="strokeDashoffset"
                                    class="transition-all duration-1000 ease-linear"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-5xl font-bold tabular-nums" :class="mode === 'focus' ? 'text-gray-900' : 'text-gray-700'" x-text="displayTime"></span>
                            <span class="text-sm font-medium mt-2"
                                  :class="mode === 'focus' ? 'text-indigo-600' : (mode === 'short_break' ? 'text-green-600' : 'text-blue-600')"
                                  x-text="modeLabel"></span>
                        </div>
                    </div>

                    {{-- Controls --}}
                    <div class="flex items-center justify-center gap-4">
                        <button @click="reset()" class="w-12 h-12 rounded-full border-2 border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:border-gray-300 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                        <button @click="toggle()"
                                :class="mode === 'focus' ? 'bg-indigo-600 hover:bg-indigo-700' : (mode === 'short_break' ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700')"
                                class="w-16 h-16 rounded-full flex items-center justify-center text-white shadow-lg transition transform hover:scale-105">
                            <svg x-show="!running" class="w-7 h-7 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <svg x-show="running" x-cloak class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                            </svg>
                        </button>
                        <button @click="skip()" class="w-12 h-12 rounded-full border-2 border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:border-gray-300 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Session counter --}}
                    <div class="mt-6 flex items-center justify-center gap-2">
                        <template x-for="i in 4" :key="i">
                            <div class="w-3 h-3 rounded-full transition"
                                 :class="i <= completedPomodoros % 4 ? (mode === 'focus' ? 'bg-indigo-500' : 'bg-green-500') : 'bg-gray-200'"></div>
                        </template>
                        <span class="text-xs text-gray-400 ml-2" x-text="'#' + (completedPomodoros + 1)"></span>
                    </div>

                    {{-- Task selector --}}
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <label class="text-sm font-medium text-gray-700">Linked Task</label>
                        <select x-model="selectedTask"
                                class="mt-1 w-full max-w-xs mx-auto px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                            <option value="">No task linked</option>
                            @foreach($tasks as $task)
                                <option value="{{ $task->id }}">{{ $task->title }}{{ $task->subject ? ' — ' . $task->subject->name : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Custom Settings --}}
                <div class="bg-white rounded-xl border border-gray-200 p-6 mt-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Timer Settings</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Focus (min)</label>
                            <input type="number" x-model.number="settings.focus" @change="updateSettings()" min="1" max="120"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-center">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Short Break (min)</label>
                            <input type="number" x-model.number="settings.shortBreak" @change="updateSettings()" min="1" max="30"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-center">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Long Break (min)</label>
                            <input type="number" x-model.number="settings.longBreak" @change="updateSettings()" min="1" max="60"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-center">
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-2">
                        <input type="checkbox" x-model="settings.autoStart" id="autoStart" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="autoStart" class="text-sm text-gray-600">Auto-start next session</label>
                    </div>
                </div>
            </div>

            {{-- Sidebar: Today's sessions --}}
            <div>
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Today's Sessions</h3>
                    <div class="space-y-3" x-show="todaySessions.length > 0">
                        <template x-for="(session, index) in todaySessions" :key="index">
                            <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                     :class="session.type === 'focus' ? 'bg-indigo-50' : 'bg-green-50'">
                                    <svg x-show="session.type === 'focus'" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <svg x-show="session.type === 'break'" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900" x-text="session.type === 'focus' ? 'Focus Session' : 'Break'"></p>
                                    <p class="text-xs text-gray-400" x-text="Math.round(session.duration / 60) + ' min'"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                    <p x-show="todaySessions.length === 0" class="text-sm text-gray-400 text-center py-4">No sessions yet today. Start focusing!</p>

                    {{-- Stats --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Focus sessions</span>
                            <span class="font-medium text-gray-900" x-text="todaySessions.filter(s => s.type === 'focus').length"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Total focus</span>
                            <span class="font-medium text-gray-900" x-text="formatTotalTime(todaySessions.filter(s => s.type === 'focus'))"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pomodoroTimer() {
            return {
                mode: 'focus', // focus, short_break, long_break
                running: false,
                seconds: 25 * 60,
                totalSeconds: 25 * 60,
                interval: null,
                completedPomodoros: 0,
                selectedTask: '',
                todaySessions: [],
                circumference: 2 * Math.PI * 120,
                settings: {
                    focus: 25,
                    shortBreak: 5,
                    longBreak: 15,
                    autoStart: false,
                },

                init() {
                    const saved = localStorage.getItem('pomodoroSettings');
                    if (saved) {
                        this.settings = { ...this.settings, ...JSON.parse(saved) };
                    }
                    this.totalSeconds = this.settings.focus * 60;
                    this.seconds = this.totalSeconds;
                },

                get displayTime() {
                    const m = Math.floor(this.seconds / 60);
                    const s = this.seconds % 60;
                    return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                },

                get modeLabel() {
                    if (this.mode === 'focus') return 'Focus Time';
                    if (this.mode === 'short_break') return 'Short Break';
                    return 'Long Break';
                },

                get strokeDashoffset() {
                    const progress = this.seconds / this.totalSeconds;
                    return this.circumference * (1 - progress);
                },

                get progress() {
                    return ((this.totalSeconds - this.seconds) / this.totalSeconds) * 100;
                },

                setMode(m) {
                    this.stop();
                    this.mode = m;
                    if (m === 'focus') {
                        this.totalSeconds = this.settings.focus * 60;
                    } else if (m === 'short_break') {
                        this.totalSeconds = this.settings.shortBreak * 60;
                    } else {
                        this.totalSeconds = this.settings.longBreak * 60;
                    }
                    this.seconds = this.totalSeconds;
                },

                toggle() {
                    if (this.running) {
                        this.stop();
                    } else {
                        this.start();
                    }
                },

                start() {
                    if (this.seconds <= 0) return;
                    this.running = true;
                    this.interval = setInterval(() => {
                        this.seconds--;
                        if (this.seconds <= 0) {
                            this.complete();
                        }
                    }, 1000);
                },

                stop() {
                    this.running = false;
                    if (this.interval) {
                        clearInterval(this.interval);
                        this.interval = null;
                    }
                },

                reset() {
                    this.stop();
                    this.seconds = this.totalSeconds;
                },

                skip() {
                    this.complete();
                },

                complete() {
                    this.stop();
                    const elapsed = this.totalSeconds - this.seconds;
                    const sessionType = this.mode === 'focus' ? 'focus' : 'break';

                    // Save session if any time elapsed
                    if (elapsed > 0) {
                        this.saveSession(sessionType, this.totalSeconds);
                    }

                    // Play notification sound
                    this.notify();

                    if (this.mode === 'focus') {
                        this.completedPomodoros++;
                        // Every 4 pomodoros, take a long break
                        if (this.completedPomodoros % 4 === 0) {
                            this.setMode('long_break');
                        } else {
                            this.setMode('short_break');
                        }
                    } else {
                        this.setMode('focus');
                    }

                    if (this.settings.autoStart) {
                        this.start();
                    }
                },

                async saveSession(type, duration) {
                    try {
                        const response = await fetch('{{ route("pomodoro.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                task_id: this.selectedTask || null,
                                duration: duration,
                                type: type,
                            })
                        });
                        if (response.ok) {
                            this.todaySessions.unshift({ type, duration });
                        }
                    } catch (e) {
                        console.error('Failed to save session:', e);
                    }
                },

                notify() {
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification('StudyFlow', {
                            body: this.mode === 'focus' ? 'Focus session complete! Take a break.' : 'Break is over! Time to focus.',
                        });
                    }
                    // Also play a beep
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.frequency.value = 800;
                        gain.gain.value = 0.3;
                        osc.start();
                        setTimeout(() => osc.stop(), 200);
                    } catch(e) {}
                },

                updateSettings() {
                    localStorage.setItem('pomodoroSettings', JSON.stringify(this.settings));
                    // If not running, update current timer
                    if (!this.running) {
                        this.setMode(this.mode);
                    }
                },

                formatTotalTime(sessions) {
                    const total = sessions.reduce((sum, s) => sum + s.duration, 0);
                    const h = Math.floor(total / 3600);
                    const m = Math.floor((total % 3600) / 60);
                    return h > 0 ? h + 'h ' + m + 'm' : m + 'm';
                }
            };
        }

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    </script>
</x-layouts.study>
