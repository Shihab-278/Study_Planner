<x-layouts.study title="Create Task">
    <div class="max-w-lg">
        <form method="POST" action="{{ route('tasks.store') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @csrf
            <div class="mb-5">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Task Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition"
                       placeholder="e.g., Complete Chapter 5 exercises">
                @error('title') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description <span class="text-gray-400 font-normal">(optional)</span></label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none resize-none transition"
                          placeholder="Add more details...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="subject_id" class="block text-sm font-semibold text-gray-700 mb-2">Subject <span class="text-gray-400 font-normal">(optional)</span></label>
                <select name="subject_id" id="subject_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    <option value="">No subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <div>
                    <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    @error('deadline') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">Priority</label>
                    <select name="priority" id="priority"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/25 transition-all">
                    Create Task
                </button>
                <a href="{{ route('tasks.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.study>
