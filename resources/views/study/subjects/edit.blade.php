<x-layouts.study title="Edit Subject">
    <div class="max-w-lg">
        <form method="POST" action="{{ route('subjects.update', $subject) }}" class="bg-white rounded-xl border border-gray-200 p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Subject Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $subject->name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="color" id="color" value="{{ old('color', $subject->color) }}"
                           class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer p-0.5">
                    <span class="text-sm text-gray-500">Choose a color to identify this subject</span>
                </div>
                @error('color')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    Update Subject
                </button>
                <a href="{{ route('subjects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.study>
