<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white tracking-tight">
            Manage Tasks
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-800 bg-white shadow-xl shadow-black/10">
                <div class="border-b border-slate-200 p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">All Assigned Tasks</h3>
                            <p class="mt-1 text-sm text-slate-500">Review task progress, due dates, and employee assignments.</p>
                        </div>

                        <a href="{{ route('manager.tasks.create') }}"
                           class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-500">
                            + New Task
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($tasks->isEmpty())
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                            <p class="text-lg font-semibold text-slate-700">No tasks found</p>
                            <p class="mt-2 text-sm text-slate-500">Create a new task to start managing team work.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
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
                                            $status = $task->status;
                                            $classes = match ($status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'done' => 'bg-green-100 text-green-800',
                                                'awaiting_review' => 'bg-purple-100 text-purple-800',
                                                'overdue' => 'bg-red-100 text-red-800',
                                                default => 'bg-slate-100 text-slate-700',
                                            };

                                            $dueDate = \Carbon\Carbon::parse($task->due_date);
                                            $dueClasses = $dueDate->isPast() && $status !== 'done'
                                                ? 'text-red-600 font-semibold'
                                                : ($dueDate->isToday() ? 'text-amber-600 font-semibold' : 'text-slate-600');
                                        @endphp

                                        <tr class="border-b border-slate-100 transition hover:bg-slate-50">
                                            <td class="px-4 py-4">
                                                <div class="font-semibold text-slate-900">{{ $task->user->name ?? 'Unknown' }}</div>
                                            </td>

                                            <td class="px-4 py-4">
                                                <div class="font-medium text-slate-800">{{ $task->title }}</div>
                                            </td>

                                            <td class="px-4 py-4">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $classes }}">
                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-4">
                                                <span class="{{ $dueClasses }}">
                                                    {{ $dueDate->format('d M Y') }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-4 text-right">
                                                <a href="{{ route('manager.tasks.show', $task) }}"
                                                   class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200">
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
