<x-layouts.study title="Tasks">
    <x-slot:headerAction>
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Task
        </a>
    </x-slot:headerAction>

    {{-- Filters --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap items-center gap-3 mb-6">
        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        <select name="subject_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <option value="">All Subjects</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
            @endforeach
        </select>
        <select name="priority" class="px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <option value="">All Priority</option>
            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Filter</button>
        @if(request()->hasAny(['status', 'subject_id', 'priority']))
            <a href="{{ route('tasks.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Clear</a>
        @endif
    </form>

    @if($tasks->isEmpty())
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">No tasks found</h3>
            <p class="text-gray-500 mb-4">Create your first task to get started.</p>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                Create Task
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="divide-y divide-gray-100">
                @foreach($tasks as $task)
                    <div class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition {{ $task->status === 'completed' ? 'opacity-60' : '' }}">
                        {{-- Toggle --}}
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-5 h-5 rounded-full border-2 flex-shrink-0 flex items-center justify-center transition
                                {{ $task->status === 'completed' ? 'border-green-500 bg-green-500' : 'border-gray-300 hover:border-indigo-500' }}">
                                @if($task->status === 'completed')
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </button>
                        </form>

                        {{-- Task info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 {{ $task->status === 'completed' ? 'line-through' : '' }}">{{ $task->title }}</p>
                            <div class="flex items-center gap-3 mt-1">
                                @if($task->subject)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                        <span class="w-2 h-2 rounded-full" style="background-color: {{ $task->subject->color }}"></span>
                                        {{ $task->subject->name }}
                                    </span>
                                @endif
                                @if($task->deadline)
                                    <span class="text-xs {{ $task->deadline->isPast() && $task->status === 'pending' ? 'text-red-500 font-medium' : 'text-gray-400' }}">
                                        📅 {{ $task->deadline->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Priority --}}
                        <span class="px-2.5 py-1 text-xs rounded-full font-medium flex-shrink-0
                            {{ $task->priority === 'high' ? 'bg-red-50 text-red-700' : ($task->priority === 'medium' ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700') }}">
                            {{ ucfirst($task->priority) }}
                        </span>

                        {{-- Actions --}}
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <a href="{{ route('tasks.edit', $task) }}" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
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
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    @endif
</x-layouts.study>
