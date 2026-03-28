<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Task Details
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-blue-900 shadow-xl shadow-blue-900/20 sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-4 text-blue-100">
                    {{ $task->title }}
                </h3>

                @php
                    $status = $task->status;
                    $classes = match ($status) {
                        'pending'         => 'bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 text-yellow-900 shadow shadow-yellow-400/30',
                        'in_progress'     => 'bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 text-blue-900 shadow shadow-blue-400/30',
                        'awaiting_review' => 'bg-gradient-to-r from-purple-300 via-purple-400 to-purple-500 text-purple-900 shadow shadow-purple-400/30',
                        'done'            => 'bg-gradient-to-r from-emerald-300 via-emerald-400 to-emerald-500 text-emerald-900 shadow shadow-emerald-400/30',
                        'overdue'         => 'bg-gradient-to-r from-red-300 via-red-400 to-red-500 text-red-900 shadow shadow-red-400/30',
                        default           => 'bg-blue-950 text-blue-200',
                    };
                @endphp

                <p class="text-sm text-blue-300 mb-2">
                    Status:
                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded {{ $classes }}">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </p>

                @if($task->status === 'awaiting_review')
                    <div class="mt-4 border border-blue-800 rounded p-4 bg-blue-950">
                        <h4 class="font-semibold mb-3 text-blue-100">Review Actions</h4>

                        {{-- Approve --}}
                        <form method="POST" action="{{ route('manager.tasks.approve', $task) }}" class="mb-4">
                            @csrf
                            @method('PATCH')

                            <label class="block text-sm font-medium text-blue-200 mb-1">Approve Comment (optional)</label>
                            <textarea name="comment" class="border border-blue-800 bg-blue-950 text-blue-200 rounded w-full px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30" rows="2"
                                    placeholder="Optional note for approval..."></textarea>

                            <button type="submit" class="mt-2 bg-gradient-to-r from-emerald-500 to-emerald-700 text-white text-sm px-3 py-2 rounded shadow-lg shadow-emerald-900/30 transition hover:from-emerald-600 hover:to-emerald-800">
                                Approve as Done
                            </button>
                        </form>

                        {{-- Send Back --}}
                        <form method="POST" action="{{ route('manager.tasks.sendBack', $task) }}">
                            @csrf
                            @method('PATCH')

                            <label class="block text-sm font-medium text-blue-200 mb-1">Send Back Comment (required)</label>
                            <textarea name="comment" class="border border-blue-800 bg-blue-950 text-blue-200 rounded w-full px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30" rows="3"
                                    placeholder="Explain what needs to be fixed..." required>{{ old('comment') }}</textarea>

                            @error('comment')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <button type="submit" class="mt-2 bg-gradient-to-r from-yellow-400 to-yellow-600 text-yellow-900 text-sm px-3 py-2 rounded shadow-lg shadow-yellow-900/30 transition hover:from-yellow-500 hover:to-yellow-700">
                                Send Back
                            </button>
                        </form>
                    </div>
                @endif

                <p class="text-sm text-blue-300 mb-4">
                    Due date:
                    <span class="font-medium text-blue-100">
                        {{ $task->due_date }}
                    </span>
                </p>

                <div class="mb-4">
                    <h4 class="font-semibold mb-1 text-blue-100">Description</h4>
                    <p class="text-blue-200">
                        {{ $task->description ?: 'No description provided.' }}
                    </p>
                </div>

                @if($task->reviews->isNotEmpty())
                    <div class="mt-6 border-t border-blue-800 pt-4">
                        <h4 class="font-semibold mb-2 text-blue-100">Review History</h4>

                        <div class="space-y-3">
                            @foreach ($task->reviews as $review)
                                <div class="border border-blue-800 rounded p-3 bg-blue-950">
                                    <div class="flex justify-between text-sm text-blue-400 mb-1">
                                        <span>
                                            {{ ucfirst(str_replace('_', ' ', $review->decision)) }}
                                            by {{ $review->manager->name }}
                                        </span>
                                        <span>{{ $review->created_at->format('d M Y, H:i') }}</span>
                                    </div>

                                    <p class="text-blue-200 text-sm">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                <div class="mt-6 border-t border-blue-800 pt-4">
                    <h4 class="font-semibold mb-2 text-blue-100">Manage Task</h4>

                    <div class="flex flex-col md:flex-row md:items-center md:gap-6 gap-4">
                        <form method="POST" action="{{ route('manager.tasks.updateAssignee', $task) }}" class="flex flex-wrap items-center gap-3">
                            @csrf
                            @method('PATCH')

                            <select name="user_id" class="border border-blue-800 bg-blue-950 text-blue-200 rounded px-2 py-1 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $task->user_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->email }})
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm px-3 py-1 rounded shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                                Reassign
                            </button>
                        </form>

                        @error('user_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <form method="POST" action="{{ route('manager.tasks.updateStatus', $task) }}" class="flex items-center gap-3">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="border border-blue-800 bg-blue-950 text-blue-200 rounded px-2 py-1 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="awaiting_review" {{ $task->status === 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                            </select>

                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm px-3 py-1 rounded shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                                Save
                            </button>
                        </form>

                        @error('status')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 mb-4 flex justify-start">
                    <a href="{{ route('manager.tasks.index') }}"
                       class="inline-flex items-center gap-2 font-bold text-sm px-3 py-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-md shadow-indigo-900/20 hover:from-blue-700 hover:to-indigo-800 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        Back to All Tasks
                    </a>
                </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
