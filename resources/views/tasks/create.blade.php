<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            New Task
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20">
                <div class="p-10 text-blue-100">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Title</label>
                            <input type="text" name="title" class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" value="{{ old('title') }}" required>
                            @error('title')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Description</label>
                            <textarea name="description" class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Status</label>
                            <select name="status" class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="awaiting_review" {{ old('status') == 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                            </select>
                            @error('status')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label class="block mb-2 text-blue-200 font-semibold">Due Date</label>
                            <input type="date" name="due_date" class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" value="{{ old('due_date') }}" required>
                            @error('due_date')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between items-center mt-8">
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-base font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">Cancel</a>
                            <button type="submit" class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-base font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
