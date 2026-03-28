<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Manager Profile
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-200 text-xl font-bold text-blue-900">
                        {{ strtoupper(substr($manager->name, 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="text-2xl font-semibold text-blue-100">{{ $manager->name }}</h3>
                        <p class="mt-1 text-sm text-blue-300">{{ $manager->email }}</p>
                        <p class="text-xs text-blue-400">Manager account</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.managers.edit', $manager) }}"
                       class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                        Edit
                    </a>

                    <a href="{{ route('admin.managers.reassign', $manager) }}"
                       class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                        Reassign Employees
                    </a>

                    <a href="{{ route('admin.managers.index') }}"
                       class="inline-flex items-center rounded-lg bg-gray-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-600">
                        Back
                    </a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-800 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">Employees</p>
                    <p class="mt-3 text-3xl font-bold text-blue-100">{{ $manager->employees_count }}</p>
                </div>

                <div class="rounded-2xl border border-blue-950 bg-gradient-to-br from-blue-950 via-indigo-950 to-blue-900 p-5 shadow-xl shadow-blue-950/30">
                    <p class="text-sm font-medium text-blue-200">Total Tasks</p>
                    <p class="mt-3 text-3xl font-bold text-blue-100">{{ $manager->managed_tasks_count }}</p>
                </div>

                <div class="rounded-2xl border border-yellow-900 bg-gradient-to-br from-yellow-900/80 to-gray-900 p-5 shadow-xl shadow-yellow-900/30">
                    <p class="text-sm font-medium text-yellow-200">Pending</p>
                    <p class="mt-3 text-3xl font-bold text-yellow-100">{{ $manager->pending_tasks_count }}</p>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900/80 to-gray-900 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">In Progress</p>
                    <p class="mt-3 text-3xl font-bold text-blue-100">{{ $manager->in_progress_tasks_count }}</p>
                </div>

                <div class="rounded-2xl border border-purple-900 bg-gradient-to-br from-purple-900/80 to-gray-900 p-5 shadow-xl shadow-purple-900/30">
                    <p class="text-sm font-medium text-purple-200">Awaiting Review</p>
                    <p class="mt-3 text-3xl font-bold text-purple-100">{{ $manager->awaiting_review_tasks_count }}</p>
                </div>

                <div class="rounded-2xl border border-red-900 bg-gradient-to-br from-red-900/80 to-gray-900 p-5 shadow-xl shadow-red-900/30">
                    <p class="text-sm font-medium text-red-200">Overdue</p>
                    <p class="mt-3 text-3xl font-bold text-red-100">{{ $manager->overdue_tasks_count }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-100">Assigned Employees</h4>
                    <p class="mt-1 text-sm text-blue-300">Employees currently under this manager.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($employees as $employee)
                            <div class="flex items-center justify-between rounded-xl border border-blue-800 bg-blue-950/30 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-blue-100">{{ $employee->name }}</p>
                                    <p class="text-xs text-blue-300">{{ $employee->email }}</p>
                                </div>

                                <span class="rounded-full bg-blue-800/40 px-3 py-1 text-xs font-semibold text-blue-200">
                                    Employee
                                </span>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-10 text-center">
                                <p class="text-blue-200">No employees assigned.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-100">Recent Team Tasks</h4>
                    <p class="mt-1 text-sm text-blue-300">Latest tasks under this manager’s team.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($recentTasks as $task)
                            @php
                                $statusClasses = match($task->status) {
                                    'pending' => 'bg-yellow-200 text-yellow-800',
                                    'in_progress' => 'bg-blue-200 text-blue-800',
                                    'awaiting_review' => 'bg-purple-200 text-purple-800',
                                    'done' => 'bg-emerald-200 text-emerald-800',
                                    default => 'bg-red-200 text-red-800',
                                };
                            @endphp

                            <div class="rounded-xl border border-blue-800 bg-blue-950/30 px-4 py-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-blue-100">{{ $task->title }}</p>
                                        <p class="text-xs text-blue-300">{{ $task->user->name ?? 'Unknown employee' }}</p>
                                    </div>

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-10 text-center">
                                <p class="text-blue-200">No recent tasks.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>