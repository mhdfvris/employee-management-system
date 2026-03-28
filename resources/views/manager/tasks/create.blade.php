<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Create Task (Manager)
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">

                <!-- Form -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-900 border border-blue-900 shadow-xl shadow-blue-900/20 sm:rounded-lg p-6">
                        <form method="POST" action="{{ route('manager.tasks.store') }}">
                            @csrf

                            <!-- Employee -->
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-blue-200 mb-1">
                                    Assign To (Employee)
                                </label>
                                <select name="user_id" class="w-full border border-blue-800 bg-blue-950 text-blue-200 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                    <option value="">-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('user_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} - {{ $employee->tasks_count }} active task{{ $employee->tasks_count == 1 ? '' : 's' }}
                                            @if($employee->overdue_tasks_count > 0)
                                                ({{ $employee->overdue_tasks_count }} overdue)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-blue-300 mt-2">
                                    Employees with fewer tasks are shown first to help balance workload.
                                </p>
                            </div>

                            <!-- Title -->
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-blue-200 mb-1">
                                    Title
                                </label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="w-full border border-blue-800 bg-blue-950 text-blue-200 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                @error('title')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-blue-200 mb-1">
                                    Description
                                </label>
                                <textarea name="description" rows="5"
                                          class="w-full border border-blue-800 bg-blue-950 text-blue-200 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <!-- Status -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-blue-200 mb-1">
                                        Status
                                    </label>
                                    <select name="status" class="w-full border border-blue-800 bg-blue-950 text-blue-200 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                        @php $current = old('status', 'pending'); @endphp
                                        <option value="pending" {{ $current === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $current === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="awaiting_review" {{ $current === 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                                        <option value="done" {{ $current === 'done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Due Date -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-blue-200 mb-1">
                                        Due Date
                                    </label>
                                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                                           class="w-full border border-blue-800 bg-blue-950 text-blue-200 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                    @error('due_date')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between items-center gap-4">
                                <a href="{{ route('manager.tasks.index') }}"
                                   class="inline-flex items-center gap-2 font-bold text-sm px-3 py-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-md shadow-indigo-900/20 hover:from-blue-700 hover:to-indigo-800 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Back to All Tasks
                                </a>

                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 text-sm rounded shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                                    Create Task
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Workload Panel -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-900 border border-blue-900 shadow-xl shadow-blue-900/20 sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-100">Employee Workload</h3>
                        <p class="mt-1 text-sm text-blue-300">Use this to assign tasks more evenly.</p>

                        <div class="mt-5 space-y-3">
                            @forelse ($employees as $employee)
                                @php
                                    $workloadLabel = 'Low';
                                    $workloadClasses = 'bg-emerald-100 text-emerald-800';

                                    if ($employee->tasks_count >= 5 && $employee->tasks_count < 8) {
                                        $workloadLabel = 'Medium';
                                        $workloadClasses = 'bg-yellow-100 text-yellow-800';
                                    } elseif ($employee->tasks_count >= 8) {
                                        $workloadLabel = 'High';
                                        $workloadClasses = 'bg-red-100 text-red-800';
                                    }
                                @endphp

                                <div class="rounded-xl border border-blue-800 bg-blue-950/60 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-blue-100">{{ $employee->name }}</p>
                                            <p class="text-xs text-blue-300">{{ $employee->email }}</p>
                                        </div>

                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $workloadClasses }}">
                                            {{ $workloadLabel }}
                                        </span>
                                    </div>

                                    <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                                        <div class="rounded-lg bg-gray-900/70 px-3 py-2 text-blue-200">
                                            Total: <span class="font-semibold text-white">{{ $employee->tasks_count }}</span>
                                        </div>
                                        <div class="rounded-lg bg-gray-900/70 px-3 py-2 text-blue-200">
                                            Overdue: <span class="font-semibold text-red-300">{{ $employee->overdue_tasks_count }}</span>
                                        </div>
                                        <div class="rounded-lg bg-gray-900/70 px-3 py-2 text-blue-200">
                                            Pending: <span class="font-semibold text-yellow-300">{{ $employee->pending_tasks_count }}</span>
                                        </div>
                                        <div class="rounded-lg bg-gray-900/70 px-3 py-2 text-blue-200">
                                            Progress: <span class="font-semibold text-blue-300">{{ $employee->in_progress_tasks_count }}</span>
                                        </div>
                                    </div>

                                    @if($employee->awaiting_review_tasks_count > 0)
                                        <p class="mt-3 text-xs text-purple-300">
                                            {{ $employee->awaiting_review_tasks_count }} task{{ $employee->awaiting_review_tasks_count == 1 ? '' : 's' }} awaiting review
                                        </p>
                                    @endif
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-blue-800 bg-blue-950 px-4 py-8 text-center">
                                    <p class="text-sm font-semibold text-blue-200">No employees available</p>
                                    <p class="mt-1 text-xs text-blue-300">Create an employee first before assigning tasks.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
