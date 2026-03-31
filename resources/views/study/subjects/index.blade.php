<x-layouts.study title="Subjects">
    <x-slot:headerAction>
        <a href="{{ route('subjects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Subject
        </a>
    </x-slot:headerAction>

    @if($subjects->isEmpty())
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">No subjects yet</h3>
            <p class="text-gray-500 mb-4">Create your first subject to start organizing your studies.</p>
            <a href="{{ route('subjects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                Create Subject
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($subjects as $subject)
                <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-sm transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $subject->color }}20">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $subject->color }}"></div>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">{{ $subject->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $subject->tasks_count }} tasks</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('subjects.edit', $subject) }}" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('subjects.destroy', $subject) }}" onsubmit="return confirm('Delete this subject? Its tasks will be preserved.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    @if($subject->tasks_count > 0)
                        <div class="mt-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Progress</span>
                                <span>{{ $subject->completed_tasks_count }}/{{ $subject->tasks_count }}</span>
                            </div>
                            <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all" style="width: {{ ($subject->completed_tasks_count / $subject->tasks_count) * 100 }}%; background-color: {{ $subject->color }}"></div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.study>
