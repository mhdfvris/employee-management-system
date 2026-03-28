<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            My Tasks
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20 overflow-hidden">
                <div class="p-8 text-blue-100">
                    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <a href="{{ route('tasks.create') }}"
                            class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                            + New Task
                        </a>

                        <form method="GET" class="flex flex-col gap-3 md:flex-row">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search tasks..."
                                   class="w-full md:w-72 rounded-lg border border-blue-800 bg-blue-950 px-4 py-2 text-sm text-blue-100 placeholder-blue-400 focus:border-blue-500 focus:ring focus:ring-blue-500/30">

                            <select name="status"
                                    class="rounded-lg border border-blue-800 bg-blue-950 px-4 py-2 text-sm text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                <option value="">All Statuses</option>
                                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                                <option value="awaiting_review" @selected(request('status') === 'awaiting_review')>Awaiting Review</option>
                                <option value="done" @selected(request('status') === 'done')>Done</option>
                                <option value="overdue" @selected(request('status') === 'overdue')>Overdue</option>
                            </select>

                            <button type="submit"
                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500">
                                Filter
                            </button>
                        </form>
                    </div>

                    @if($tasks->isEmpty())
                        <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-12 text-center">
                            <p class="text-lg font-semibold text-blue-200">No tasks found</p>
                            <p class="mt-2 text-sm text-blue-300">Try adjusting your search or create a new task.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-blue-800 text-xs uppercase tracking-wider text-blue-300">
                                        <th class="py-3">Title</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Due Date</th>
                                        <th class="py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        @php
                                            $dueDate = \Carbon\Carbon::parse($task->due_date);
                                            $isLate = $dueDate->isPast() && $task->status !== 'done';
                                            $isToday = $dueDate->isToday() && $task->status !== 'done';
                                            $isTomorrow = $dueDate->isTomorrow() && $task->status !== 'done';
                                            $isLocked = $task->status === 'overdue' || $isLate;

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
                                            <td class="py-4">
                                                <div class="font-medium text-blue-200">{{ $task->title }}</div>
                                                @if($task->description)
                                                    <div class="mt-1 max-w-md truncate text-xs text-blue-400">
                                                        {{ $task->description }}
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="py-4">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $classes }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>

                                            <td class="py-4">
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

                                            <td class="py-4 text-right">
                                                <a href="{{ route('tasks.show', $task) }}"
                                                class="inline-flex items-center rounded-lg bg-blue-900 px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-800">
                                                    View
                                                </a>

                                                @if(!$isLocked)
                                                    <a href="{{ route('tasks.edit', $task) }}"
                                                    class="ml-2 inline-flex items-center rounded-lg bg-blue-950 px-3 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                        class="inline-block ml-2"
                                                        onsubmit="return confirm('Delete this task?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="inline-flex items-center rounded-lg bg-red-200 px-3 py-2 text-sm font-medium text-red-900 transition hover:bg-red-400 hover:text-white">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="ml-2 text-sm font-medium text-red-300">Locked</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $tasks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
