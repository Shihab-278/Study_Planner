<x-layouts.study title="Pomodoro Timer">
    <div x-data="pomodoroTimer()" x-init="init()" class="max-w-5xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Timer --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    {{-- Gradient header bar --}}
                    <div class="h-1.5 transition-all duration-500"
                         :style="'background: linear-gradient(90deg, ' + (mode === 'focus' ? '#6366f1, #a855f7' : (mode === 'short_break' ? '#10b981, #34d399' : '#3b82f6, #60a5fa')) + ')'"></div>

                    <div class="p-8 text-center">
                        {{-- Mode Tabs --}}
                        <div class="inline-flex bg-gray-100 rounded-xl p-1 mb-10">
                            <button @click="setMode('focus')"
                                    :class="mode === 'focus' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-5 py-2 text-sm font-semibold rounded-lg transition-all">
                                Focus
                            </button>
                            <button @click="setMode('short_break')"
                                    :class="mode === 'short_break' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-5 py-2 text-sm font-semibold rounded-lg transition-all">
                                Short Break
                            </button>
                            <button @click="setMode('long_break')"
                                    :class="mode === 'long_break' ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-5 py-2 text-sm font-semibold rounded-lg transition-all">
                                Long Break
                            </button>
                        </div>

                        {{-- Circular Timer --}}
                        <div class="relative w-72 h-72 mx-auto mb-10">
                            <svg class="w-72 h-72 transform -rotate-90" viewBox="0 0 288 288">
                                <circle cx="144" cy="144" r="132" stroke="#f3f4f6" stroke-width="6" fill="none"/>
                                <circle cx="144" cy="144" r="132"
                                        stroke="url(#timerGrad)" stroke-width="6" fill="none"
                                        stroke-linecap="round"
                                        :stroke-dasharray="circumference"
                                        :stroke-dashoffset="strokeDashoffset"
                                        class="transition-all duration-1000 ease-linear"/>
                            </svg>
                            <svg class="w-0 h-0 absolute">
                                <defs>
                                    <linearGradient id="timerGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" :stop-color="mode === 'focus' ? '#6366f1' : (mode === 'short_break' ? '#10b981' : '#3b82f6')"/>
                                        <stop offset="100%" :stop-color="mode === 'focus' ? '#a855f7' : (mode === 'short_break' ? '#34d399' : '#60a5fa')"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-6xl font-bold tabular-nums tracking-tight text-gray-900" x-text="displayTime"></span>
                                <span class="text-xs font-semibold mt-2 uppercase tracking-widest"
                                      :class="mode === 'focus' ? 'text-indigo-500' : (mode === 'short_break' ? 'text-emerald-500' : 'text-blue-500')"
                                      x-text="modeLabel"></span>
                            </div>
                        </div>

                        {{-- Controls --}}
                        <div class="flex items-center justify-center gap-5">
                            <button @click="reset()" class="w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                            <button @click="toggle()"
                                    class="w-20 h-20 rounded-2xl flex items-center justify-center text-white shadow-xl transition-all transform hover:scale-105 hover:-translate-y-1"
                                    :class="mode === 'focus' ? 'bg-gradient-to-br from-indigo-500 to-purple-600 shadow-indigo-500/30' : (mode === 'short_break' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 shadow-emerald-500/30' : 'bg-gradient-to-br from-blue-500 to-cyan-600 shadow-blue-500/30')">
                                <svg x-show="!running" class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <svg x-show="running" x-cloak class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </button>
                            <button @click="skip()" class="w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>

                        {{-- Session dots --}}
                        <div class="mt-8 flex items-center justify-center gap-2">
                            <template x-for="i in 4" :key="i">
                                <div class="w-3 h-3 rounded-full transition-all duration-300"
                                     :class="i <= completedPomodoros % 4 ? (mode === 'focus' ? 'bg-indigo-500 scale-110' : 'bg-emerald-500 scale-110') : 'bg-gray-200'"></div>
                            </template>
                            <span class="text-xs text-gray-400 ml-2 font-semibold" x-text="'Session #' + (completedPomodoros + 1)"></span>
                        </div>

                        {{-- Task selector --}}
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Linked Task</label>
                            <select x-model="selectedTask"
                                    class="mt-2 w-full max-w-sm mx-auto px-4 py-3 border border-gray-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                                <option value="">No task linked</option>
                                @foreach($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}{{ $task->subject ? ' — ' . $task->subject->name : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Settings --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Timer Settings</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-2">Focus (min)</label>
                            <input type="number" x-model.number="settings.focus" @change="updateSettings()" min="1" max="120"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-center font-semibold transition">
                        </div>
                        <div>
                            <label class="block text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-2">Short Break</label>
                            <input type="number" x-model.number="settings.shortBreak" @change="updateSettings()" min="1" max="30"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-center font-semibold transition">
                        </div>
                        <div>
                            <label class="block text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-2">Long Break</label>
                            <input type="number" x-model.number="settings.longBreak" @change="updateSettings()" min="1" max="60"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-center font-semibold transition">
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <input type="checkbox" x-model="settings.autoStart" id="autoStart" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="autoStart" class="text-sm text-gray-600">Auto-start next session</label>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                {{-- Today's Stats --}}
                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg shadow-indigo-500/20">
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-indigo-200 mb-4">Today's Progress</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 rounded-xl p-3 backdrop-blur">
                            <p class="text-2xl font-bold" x-text="todaySessions.filter(s => s.type === 'focus').length">0</p>
                            <p class="text-[11px] text-indigo-200">Sessions</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-3 backdrop-blur">
                            <p class="text-2xl font-bold" x-text="formatTotalTime(todaySessions.filter(s => s.type === 'focus'))">0m</p>
                            <p class="text-[11px] text-indigo-200">Total Focus</p>
                        </div>
                    </div>
                </div>

                {{-- Sessions Log --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Session Log</h3>
                    <div class="space-y-2 max-h-80 overflow-y-auto" x-show="todaySessions.length > 0">
                        <template x-for="(session, index) in todaySessions" :key="index">
                            <div class="flex items-center gap-3 p-2.5 rounded-xl bg-gray-50/50">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                     :class="session.type === 'focus' ? 'bg-indigo-50' : 'bg-emerald-50'">
                                    <svg x-show="session.type === 'focus'" class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <svg x-show="session.type === 'break'" class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800" x-text="session.type === 'focus' ? 'Focus Session' : 'Break'"></p>
                                    <p class="text-[11px] text-gray-400" x-text="Math.round(session.duration / 60) + ' min'"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="todaySessions.length === 0" class="text-center py-8">
                        <div class="w-12 h-12 mx-auto bg-gray-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">No sessions yet</p>
                        <p class="text-xs text-gray-300 mt-1">Start focusing!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pomodoroTimer() {
            return {
                mode: 'focus',
                running: false,
                seconds: 25 * 60,
                totalSeconds: 25 * 60,
                interval: null,
                completedPomodoros: 0,
                selectedTask: '',
                todaySessions: [],
                circumference: 2 * Math.PI * 132,
                settings: { focus: 25, shortBreak: 5, longBreak: 15, autoStart: false },

                init() {
                    const saved = localStorage.getItem('pomodoroSettings');
                    if (saved) this.settings = { ...this.settings, ...JSON.parse(saved) };
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
                    return this.circumference * (1 - this.seconds / this.totalSeconds);
                },

                setMode(m) {
                    this.stop();
                    this.mode = m;
                    this.totalSeconds = m === 'focus' ? this.settings.focus * 60 : (m === 'short_break' ? this.settings.shortBreak * 60 : this.settings.longBreak * 60);
                    this.seconds = this.totalSeconds;
                },
                toggle() { this.running ? this.stop() : this.start(); },
                start() {
                    if (this.seconds <= 0) return;
                    this.running = true;
                    this.interval = setInterval(() => { this.seconds--; if (this.seconds <= 0) this.complete(); }, 1000);
                },
                stop() { this.running = false; if (this.interval) { clearInterval(this.interval); this.interval = null; } },
                reset() { this.stop(); this.seconds = this.totalSeconds; },
                skip() { this.complete(); },
                complete() {
                    this.stop();
                    const elapsed = this.totalSeconds - this.seconds;
                    const sessionType = this.mode === 'focus' ? 'focus' : 'break';
                    if (elapsed > 0) this.saveSession(sessionType, this.totalSeconds);
                    this.notify();
                    if (this.mode === 'focus') {
                        this.completedPomodoros++;
                        this.setMode(this.completedPomodoros % 4 === 0 ? 'long_break' : 'short_break');
                    } else {
                        this.setMode('focus');
                    }
                    if (this.settings.autoStart) this.start();
                },
                async saveSession(type, duration) {
                    try {
                        const res = await fetch('{{ route("pomodoro.store") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                            body: JSON.stringify({ task_id: this.selectedTask || null, duration, type })
                        });
                        if (res.ok) this.todaySessions.unshift({ type, duration });
                    } catch (e) { console.error('Failed to save:', e); }
                },
                notify() {
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification('StudyFlow', { body: this.mode === 'focus' ? 'Focus complete! Take a break.' : 'Break over! Time to focus.' });
                    }
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.connect(gain); gain.connect(ctx.destination);
                        osc.frequency.value = 800; gain.gain.value = 0.3;
                        osc.start(); setTimeout(() => osc.stop(), 200);
                    } catch(e) {}
                },
                updateSettings() {
                    localStorage.setItem('pomodoroSettings', JSON.stringify(this.settings));
                    if (!this.running) this.setMode(this.mode);
                },
                formatTotalTime(sessions) {
                    const total = sessions.reduce((sum, s) => sum + s.duration, 0);
                    const h = Math.floor(total / 3600);
                    const m = Math.floor((total % 3600) / 60);
                    return h > 0 ? h + 'h ' + m + 'm' : m + 'm';
                }
            };
        }
        if ('Notification' in window && Notification.permission === 'default') Notification.requestPermission();
    </script>
</x-layouts.study>
