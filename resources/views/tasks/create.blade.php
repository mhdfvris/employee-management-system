<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Task
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-1">Title</label>
                            <input type="text" name="title" class="border rounded w-full px-3 py-2"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Description</label>
                            <textarea name="description" class="border rounded w-full px-3 py-2"
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Status</label>
                            <select name="status" class="border rounded w-full px-3 py-2" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="awaiting_review" {{ old('status') == 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Due Date</label>
                            <input type="date" name="due_date" class="border rounded w-full px-3 py-2"
                                   value="{{ old('due_date') }}" required>
                            @error('due_date')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('tasks.index') }}" class="text-gray-600">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                Save Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
