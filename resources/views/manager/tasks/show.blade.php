<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Task Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-4">
                    {{ $task->title }}
                </h3>

                @php
                    $status = $task->status;
                    $classes = match ($status) {
                        'pending'         => 'bg-yellow-100 text-yellow-800',
                        'in_progress'     => 'bg-blue-100 text-blue-800',
                        'awaiting_review' => 'bg-purple-100 text-purple-800',
                        'done'            => 'bg-green-100 text-green-800',
                        'overdue'         => 'bg-red-100 text-red-800',
                        default           => 'bg-gray-100 text-gray-800',
                    };
                @endphp

                <p class="text-sm text-gray-600 mb-2">
                    Status:
                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded {{ $classes }}">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </p>

                @if($task->status === 'awaiting_review')
                    <div class="mt-4 border rounded p-4 bg-gray-50">
                        <h4 class="font-semibold mb-3">Review Actions</h4>

                        {{-- Approve --}}
                        <form method="POST" action="{{ route('manager.tasks.approve', $task) }}" class="mb-4">
                            @csrf
                            @method('PATCH')

                            <label class="block text-sm font-medium mb-1">Approve Comment (optional)</label>
                            <textarea name="comment" class="border rounded w-full px-3 py-2 text-sm" rows="2"
                                    placeholder="Optional note for approval..."></textarea>

                            <button type="submit" class="mt-2 bg-green-600 text-white text-sm px-3 py-2 rounded">
                                Approve as Done
                            </button>
                        </form>

                        {{-- Send Back --}}
                        <form method="POST" action="{{ route('manager.tasks.sendBack', $task) }}">
                            @csrf
                            @method('PATCH')

                            <label class="block text-sm font-medium mb-1">Send Back Comment (required)</label>
                            <textarea name="comment" class="border rounded w-full px-3 py-2 text-sm" rows="3"
                                    placeholder="Explain what needs to be fixed..." required>{{ old('comment') }}</textarea>

                            @error('comment')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <button type="submit" class="mt-2 bg-yellow-600 text-white text-sm px-3 py-2 rounded">
                                Send Back
                            </button>
                        </form>
                    </div>
                @endif

                <p class="text-sm text-gray-600 mb-4">
                    Due date:
                    <span class="font-medium">
                        {{ $task->due_date }}
                    </span>
                </p>

                <div class="mb-4">
                    <h4 class="font-semibold mb-1">Description</h4>
                    <p class="text-gray-800">
                        {{ $task->description ?: 'No description provided.' }}
                    </p>
                </div>

                @if($task->reviews->isNotEmpty())
                    <div class="mt-6 border-t pt-4">
                        <h4 class="font-semibold mb-2">Review History</h4>

                        <div class="space-y-3">
                            @foreach ($task->reviews as $review)
                                <div class="border rounded p-3 bg-gray-50">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>
                                            {{ ucfirst(str_replace('_', ' ', $review->decision)) }}
                                            by {{ $review->manager->name }}
                                        </span>
                                        <span>{{ $review->created_at->format('d M Y, H:i') }}</span>
                                    </div>

                                    <p class="text-gray-800 text-sm">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                <div class="mt-6 border-t pt-4">
                    <h4 class="font-semibold mb-2">Manage Task</h4>

                    <form method="POST" action="{{ route('manager.tasks.updateAssignee', $task) }}" class="flex flex-wrap items-center gap-3">
                        @csrf
                        @method('PATCH')

                        <select name="user_id" class="border rounded px-2 py-1 text-sm">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $task->user_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->email }})
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-indigo-600 text-white text-sm px-3 py-1 rounded">
                            Reassign
                        </button>
                    </form>

                    @error('user_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <form method="POST" action="{{ route('manager.tasks.updateStatus', $task) }}" class="flex items-center gap-3">
                        @csrf
                        @method('PATCH')

                        <select name="status" class="border rounded px-2 py-1 text-sm">
                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="awaiting_review" {{ $task->status === 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                        </select>

                        <button type="submit" class="bg-blue-600 text-white text-sm px-3 py-1 rounded">
                            Save
                        </button>
                    </form>

                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('manager.tasks.index') }}" class="text-gray-600">
                        ← Back to All Tasks
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
