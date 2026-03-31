<x-layouts.study title="Subjects">
    <x-slot:headerAction>
        <a href="{{ route('subjects.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/25 transition-all hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Subject
        </a>
    </x-slot:headerAction>

    @if($subjects->isEmpty())
        <div class="text-center py-20">
            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mb-5">
                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No subjects yet</h3>
            <p class="text-gray-400 mb-6 max-w-sm mx-auto">Create your first subject to start organizing your studies efficiently.</p>
            <a href="{{ route('subjects.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-xl hover:shadow-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create First Subject
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($subjects as $subject)
                @php $pct = $subject->tasks_count > 0 ? round(($subject->completed_tasks_count / $subject->tasks_count) * 100) : 0; @endphp
                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                    {{-- Top color bar --}}
                    <div class="h-1.5" style="background: linear-gradient(90deg, {{ $subject->color }}, {{ $subject->color }}88)"></div>

                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background-color: {{ $subject->color }}15">
                                    <div class="w-5 h-5 rounded-lg" style="background-color: {{ $subject->color }}"></div>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-gray-900">{{ $subject->name }}</h3>
                                    <p class="text-xs text-gray-400">{{ $subject->tasks_count }} tasks</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('subjects.edit', $subject) }}" class="p-2 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('subjects.destroy', $subject) }}" onsubmit="return confirm('Delete this subject?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($subject->tasks_count > 0)
                            <div>
                                <div class="flex justify-between text-[11px] mb-1.5">
                                    <span class="text-gray-400 font-medium">Progress</span>
                                    <span class="font-bold" style="color: {{ $subject->color }}">{{ $pct }}%</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%; background-color: {{ $subject->color }}"></div>
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1.5">{{ $subject->completed_tasks_count }} of {{ $subject->tasks_count }} completed</p>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">No tasks assigned yet</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.study>
