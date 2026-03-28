<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Manage Tasks
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20">
                <div class="border-b border-blue-800 p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-100">All Assigned Tasks</h3>
                            <p class="mt-1 text-sm text-blue-300">Review task progress, due dates, and employee assignments.</p>
                        </div>

                        <a href="{{ route('manager.tasks.create') }}"
                           class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                            + New Task
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($tasks->isEmpty())
                        <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-12 text-center">
                            <p class="text-lg font-semibold text-blue-200">No tasks found</p>
                            <p class="mt-2 text-sm text-blue-300">Create a new task to start managing team work.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-blue-800 text-xs uppercase tracking-wider text-blue-300">
                                        <th class="px-4 py-3 font-semibold">Employee</th>
                                        <th class="px-4 py-3 font-semibold">Title</th>
                                        <th class="px-4 py-3 font-semibold">Status</th>
                                        <th class="px-4 py-3 font-semibold">Due Date</th>
                                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        @php
                                            $dueDate = \Carbon\Carbon::parse($task->due_date);
                                            $isLate = $dueDate->isPast() && $task->status !== 'done';
                                            $isToday = $dueDate->isToday() && $task->status !== 'done';
                                            $isTomorrow = $dueDate->isTomorrow() && $task->status !== 'done';

                                            $status = $task->status;

                                            if ($isLate && $task->status !== 'done') {
                                                $statusLabel = 'Overdue';
                                                $classes = 'bg-gradient-to-r from-red-300 via-red-400 to-red-500 text-red-900 shadow shadow-red-400/30';
                                            } else {
                                                $statusLabel = ucfirst(str_replace('_', ' ', $status));
                                                $classes = match ($status) {
                                                    'pending' => 'bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 text-yellow-900 shadow shadow-yellow-400/30',
                                                    'in_progress' => 'bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 text-blue-900 shadow shadow-blue-400/30',
                                                    'done' => 'bg-gradient-to-r from-emerald-300 via-emerald-400 to-emerald-500 text-emerald-900 shadow shadow-emerald-400/30',
                                                    'awaiting_review' => 'bg-gradient-to-r from-purple-300 via-purple-400 to-purple-500 text-purple-900 shadow shadow-purple-400/30',
                                                    'overdue' => 'bg-gradient-to-r from-red-300 via-red-400 to-red-500 text-red-900 shadow shadow-red-400/30',
                                                    default => 'bg-blue-950 text-blue-200',
                                                };
                                            }

                                            $dueClasses = $isLate
                                                ? 'text-red-400 font-semibold'
                                                : ($isToday
                                                    ? 'text-amber-300 font-semibold'
                                                    : ($isTomorrow
                                                        ? 'text-yellow-200 font-semibold'
                                                        : 'text-blue-300'));

                                            $dueHint = $isLate
                                                ? 'Overdue'
                                                : ($isToday
                                                    ? 'Due today'
                                                    : ($isTomorrow
                                                        ? 'Due tomorrow'
                                                        : null));
                                        @endphp

                                        <tr class="border-b border-blue-900 transition hover:bg-blue-950/60">
                                            <td class="px-4 py-4">
                                                <div class="font-semibold text-blue-100">{{ $task->user->name ?? 'Unknown' }}</div>
                                            </td>

                                            <td class="px-4 py-4">
                                                <div class="font-medium text-blue-200">{{ $task->title }}</div>
                                            </td>

                                            <td class="px-4 py-4">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $classes }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-4">
                                                <div class="flex flex-col">
                                                    <span class="{{ $dueClasses }}">
                                                        {{ $dueDate->format('d M Y') }}
                                                    </span>

                                                    @if($dueHint)
                                                        <span class="mt-1 text-xs {{ $isLate ? 'text-red-300' : 'text-yellow-300' }}">
                                                            {{ $dueHint }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-4 py-4 text-right">
                                                <a href="{{ route('manager.tasks.show', $task) }}"
                                                   class="inline-flex items-center rounded-lg bg-blue-950 px-3 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
