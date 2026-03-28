<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20">
                <div class="p-8 text-blue-100">

                    @php
                        $dueDate = \Carbon\Carbon::parse($task->due_date);
                        $isLate = $dueDate->isPast() && $task->status !== 'done';
                    @endphp

                    @if($task->reviews->isNotEmpty())
                        <div class="mb-8 rounded-2xl border border-purple-800 bg-purple-950 p-6">
                            <h4 class="mb-3 text-base font-semibold text-purple-200">Manager Feedback</h4>

                            <div class="space-y-3">
                                @foreach ($task->reviews as $review)
                                    <div class="rounded-xl border border-purple-700 bg-purple-900/60 p-4">
                                        <div class="mb-1 text-sm text-purple-300">
                                            {{ ucfirst(str_replace('_', ' ', $review->decision)) }}
                                            • {{ $review->created_at->format('d M Y, H:i') }}
                                        </div>
                                        <p class="text-sm text-purple-100">
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($isLate)
                        <div class="mb-8 rounded-2xl border border-red-800 bg-red-950 p-5">
                            <h4 class="text-base font-semibold text-red-200">Task Locked</h4>
                            <p class="mt-1 text-sm text-red-300">
                                This task is overdue and can no longer be edited.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="mb-2 block font-semibold text-blue-200">Title</label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $task->title) }}"
                                   class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                   required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="mb-2 block font-semibold text-blue-200">Description</label>
                            <textarea name="description"
                                      rows="4"
                                      class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="mb-2">
                                <label class="mb-2 block font-semibold text-blue-200">Status</label>
                                <select name="status"
                                        class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                        required>
                                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="awaiting_review" {{ old('status', $task->status) == 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                                </select>
                                <p class="mt-2 text-xs text-blue-300">
                                    Set to <span class="font-semibold text-purple-300">Awaiting Review</span> when ready for manager review.
                                </p>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label class="mb-2 block font-semibold text-blue-200">Due Date</label>
                                <input type="date"
                                       name="due_date"
                                       value="{{ old('due_date', $task->due_date) }}"
                                       class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                       required>
                                @error('due_date')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-between">
                            <a href="{{ route('tasks.index') }}"
                               class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-base font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-base font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                                Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
