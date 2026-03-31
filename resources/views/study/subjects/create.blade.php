<x-layouts.study title="Create Subject">
    <div class="max-w-lg">
        <form method="POST" action="{{ route('subjects.store') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Subject Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition"
                       placeholder="e.g., Mathematics, Programming">
                @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">Color</label>
                <div class="flex items-center gap-4">
                    <input type="color" name="color" id="color" value="{{ old('color', '#6366f1') }}"
                           class="w-12 h-12 rounded-xl border border-gray-200 cursor-pointer p-1">
                    <div>
                        <p class="text-sm text-gray-600">Choose a color</p>
                        <p class="text-xs text-gray-400">This helps identify the subject visually</p>
                    </div>
                </div>
                @error('color') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/25 transition-all">
                    Create Subject
                </button>
                <a href="{{ route('subjects.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.study>
