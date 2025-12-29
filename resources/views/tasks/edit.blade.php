<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    @if($task->reviews->isNotEmpty())
        <div class="mb-6 border rounded p-4 bg-purple-50">
            <h4 class="font-semibold mb-2">Manager Feedback</h4>

            <div class="space-y-3">
                @foreach ($task->reviews as $review)
                    <div class="border rounded p-3 bg-white">
                        <div class="text-sm text-gray-600 mb-1">
                            {{ ucfirst(str_replace('_', ' ', $review->decision)) }}
                            • {{ $review->created_at->format('d M Y, H:i') }}
                        </div>

                        <p class="text-gray-800 text-sm">
                            {{ $review->comment }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block mb-1">Title</label>
                            <input type="text" name="title" value="{{ old('title', $task->title) }}"
                                class="border rounded w-full px-3 py-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Description</label>
                            <textarea name="description" class="border rounded w-full px-3 py-2" rows="3">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Status</label>
                            <select name="status" class="border rounded w-full px-3 py-2" required>
                                <option value="pending"     {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="awaiting_review" {{ old('status') == 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Due Date</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}"
                                class="border rounded w-full px-3 py-2" required>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('tasks.index') }}" class="text-gray-600">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Task</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
