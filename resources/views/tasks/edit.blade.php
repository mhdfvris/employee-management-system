<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20">
                <div class="p-10 text-blue-100">
                    @if($task->reviews->isNotEmpty())
                        <div class="mb-10 rounded-2xl border border-purple-800 bg-purple-950 p-6">
                            <h4 class="font-semibold mb-2 text-purple-200">Manager Feedback</h4>
                            <div class="space-y-3">
                                @foreach ($task->reviews as $review)
                                    <div class="border border-purple-700 rounded p-3 bg-purple-900/60">
                                        <div class="text-sm text-purple-300 mb-1">
                                            {{ ucfirst(str_replace('_', ' ', $review->decision)) }}
                                            • {{ $review->created_at->format('d M Y, H:i') }}
                                        </div>
                                        <p class="text-purple-100 text-sm">
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Title</label>
                            <input type="text" name="title" value="{{ old('title', $task->title) }}"
                                class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" required>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Description</label>
                            <textarea name="description" class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" rows="3">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Status</label>
                            <select name="status" class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" required>
                                <option value="pending"     {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="awaiting_review" {{ old('status') == 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block mb-2 text-blue-200 font-semibold">Due Date</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}"
                                class="border border-blue-800 bg-blue-950 text-blue-100 rounded w-full px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30" required>
                        </div>

                        <div class="flex justify-between items-center mt-8">
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-base font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">Cancel</a>
                            <button type="submit" class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-base font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
