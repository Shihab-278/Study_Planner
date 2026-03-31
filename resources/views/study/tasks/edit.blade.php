<x-layouts.study title="Edit Task">
    <div class="max-w-lg">
        <form method="POST" action="{{ route('tasks.update', $task) }}" class="bg-white rounded-xl border border-gray-200 p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400">(optional)</span></label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none resize-none">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Subject <span class="text-gray-400">(optional)</span></label>
                <select name="subject_id" id="subject_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="">No subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $task->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline <span class="text-gray-400">(optional)</span></label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    @error('deadline')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select name="priority" id="priority"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    Update Task
                </button>
                <a href="{{ route('tasks.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.study>
