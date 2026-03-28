<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Manager Dashboard
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-400">Team Overview</p>
                    <h3 class="mt-2 text-3xl font-bold text-blue-100">Manage your team at a glance</h3>
                    <p class="mt-2 text-sm text-blue-300">Track workload, monitor overdue tasks, and manage employees from one place.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('manager.tasks.index') }}"
                       class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                        Manage Tasks
                    </a>

                    <a href="{{ route('manager.employees.index') }}"
                       class="inline-flex items-center rounded-xl border border-blue-700 bg-blue-900 px-5 py-3 text-sm font-semibold text-blue-100 transition hover:border-blue-600 hover:bg-blue-800 hover:text-white">
                        Manage Employees
                    </a>
                </div>
            </div>

            @php
                $total = max($stats['tasks_total'], 1);
                $completion = round(($stats['done'] / $total) * 100);
            @endphp

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-800 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">Employees</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-blue-100">{{ $stats['employees'] }}</p>
                        <span class="rounded-full bg-blue-800/40 px-3 py-1 text-xs font-semibold text-blue-200">Team</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-800 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">Total Tasks</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-blue-100">{{ $stats['tasks_total'] }}</p>
                        <span class="rounded-full bg-blue-800/40 px-3 py-1 text-xs font-semibold text-blue-200">All</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-yellow-900 bg-gradient-to-br from-yellow-900/80 to-gray-900 p-5 shadow-xl shadow-yellow-900/30">
                    <p class="text-sm font-medium text-yellow-200">Pending</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-yellow-100">{{ $stats['pending'] }}</p>
                        <span class="rounded-full bg-yellow-200 px-3 py-1 text-xs font-semibold text-yellow-800">Pending</span>
                    </div>
                    <div class="mt-4 h-2.5 w-full rounded-full bg-yellow-800/30">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-200 shadow shadow-yellow-400/30" style="width: {{ max(8, round(($stats['pending'] / $total) * 100)) }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900/80 to-gray-900 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">In Progress</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-blue-100">{{ $stats['in_progress'] }}</p>
                        <span class="rounded-full bg-blue-200 px-3 py-1 text-xs font-semibold text-blue-800">Active</span>
                    </div>
                    <div class="mt-4 h-2.5 w-full rounded-full bg-blue-800/30">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-blue-400 to-blue-200 shadow shadow-blue-400/30" style="width: {{ max(8, round(($stats['in_progress'] / $total) * 100)) }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-purple-900 bg-gradient-to-br from-purple-900/80 to-gray-900 p-5 shadow-xl shadow-purple-900/30">
                    <p class="text-sm font-medium text-purple-200">Awaiting Review</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-purple-100">{{ $stats['awaiting_review'] }}</p>
                        <span class="rounded-full bg-purple-200 px-3 py-1 text-xs font-semibold text-purple-800">Review</span>
                    </div>
                    <div class="mt-4 h-2.5 w-full rounded-full bg-purple-800/30">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-purple-400 to-purple-200 shadow shadow-purple-400/30" style="width: {{ max(8, round(($stats['awaiting_review'] / $total) * 100)) }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-red-900 bg-gradient-to-br from-red-900/80 to-gray-900 p-5 shadow-xl shadow-red-900/30">
                    <p class="text-sm font-medium text-red-200">Overdue</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-red-100">{{ $stats['overdue'] }}</p>
                        <span class="rounded-full bg-red-200 px-3 py-1 text-xs font-semibold text-red-800">Urgent</span>
                    </div>
                    <div class="mt-4 h-2.5 w-full rounded-full bg-red-800/30">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-red-400 to-red-200 shadow shadow-red-400/30" style="width: {{ max(8, round(($stats['overdue'] / $total) * 100)) }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-emerald-900 bg-gradient-to-br from-emerald-900/80 to-gray-900 p-5 shadow-xl shadow-emerald-900/30">
                    <p class="text-sm font-medium text-emerald-200">Done</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-emerald-100">{{ $stats['done'] }}</p>
                        <span class="rounded-full bg-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-800">Completed</span>
                    </div>
                    <div class="mt-4 h-2.5 w-full rounded-full bg-emerald-800/30">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-200 shadow shadow-emerald-400/30" style="width: {{ max(8, round(($stats['done'] / $total) * 100)) }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-800 p-5 text-blue-100 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">Completion Rate</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold">{{ $completion }}%</p>
                        <span class="rounded-full bg-blue-800/40 px-3 py-1 text-xs font-semibold text-blue-200">Performance</span>
                    </div>
                    <div class="mt-4 h-2.5 w-full rounded-full bg-blue-800/40">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-blue-400 to-indigo-400" style="width: {{ $completion }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-blue-100">Quick Actions</h4>
                            <p class="mt-1 text-sm text-blue-300">Handle your most common manager actions fast.</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <a href="{{ route('manager.tasks.create') }}"
                           class="rounded-xl border border-blue-800 bg-blue-950 px-4 py-4 text-sm font-semibold text-blue-200 transition hover:border-blue-600 hover:bg-blue-900 hover:text-white">
                            + Create New Task
                        </a>

                        <a href="{{ route('manager.tasks.index') }}"
                           class="rounded-xl border border-blue-800 bg-blue-950 px-4 py-4 text-sm font-semibold text-blue-200 transition hover:border-blue-600 hover:bg-blue-900 hover:text-white">
                            View All Tasks
                        </a>

                        <a href="{{ route('manager.employees.create') }}"
                           class="rounded-xl border border-emerald-800 bg-emerald-950 px-4 py-4 text-sm font-semibold text-emerald-200 transition hover:border-emerald-600 hover:bg-emerald-900 hover:text-white">
                            + Add Employee
                        </a>

                        <a href="{{ route('manager.employees.index') }}"
                           class="rounded-xl border border-purple-800 bg-purple-950 px-4 py-4 text-sm font-semibold text-purple-200 transition hover:border-purple-600 hover:bg-purple-900 hover:text-white">
                            Manage Team
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-100">Workload Summary</h4>
                    <p class="mt-1 text-sm text-blue-300">A quick breakdown of current team task distribution.</p>

                    <div class="mt-5 space-y-4">
                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-yellow-200">Pending</span>
                                <span class="text-yellow-100">{{ $stats['pending'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-yellow-900/30">
                                <div class="h-2.5 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-200" style="width: {{ max(8, round(($stats['pending'] / $total) * 100)) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-blue-200">In Progress</span>
                                <span class="text-blue-100">{{ $stats['in_progress'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-blue-900/30">
                                <div class="h-2.5 rounded-full bg-gradient-to-r from-blue-400 to-blue-200" style="width: {{ max(8, round(($stats['in_progress'] / $total) * 100)) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-purple-200">Awaiting Review</span>
                                <span class="text-purple-100">{{ $stats['awaiting_review'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-purple-900/30">
                                <div class="h-2.5 rounded-full bg-gradient-to-r from-purple-400 to-purple-200" style="width: {{ max(8, round(($stats['awaiting_review'] / $total) * 100)) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-emerald-200">Done</span>
                                <span class="text-emerald-100">{{ $stats['done'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-emerald-900/30">
                                <div class="h-2.5 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-200" style="width: {{ max(8, round(($stats['done'] / $total) * 100)) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics + Urgent Tasks -->
            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-blue-100">Top Employee Performance</h4>
                            <p class="mt-1 text-sm text-blue-300">Based on completed tasks.</p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-4">
                        @forelse($employeePerformance as $employee)
                            @php
                                $employeeTotal = max($employee->tasks_count, 1);
                                $donePercent = round(($employee->done_tasks_count / $employeeTotal) * 100);
                            @endphp

                            <div class="rounded-xl border border-blue-800 bg-blue-950/40 p-4">
                                <div class="mb-2 flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-blue-100">{{ $employee->name }}</p>
                                        <p class="text-xs text-blue-300">
                                            {{ $employee->done_tasks_count }} done / {{ $employee->tasks_count }} total
                                        </p>
                                    </div>

                                    @if($employee->overdue_tasks_count > 0)
                                        <span class="rounded-full bg-red-200 px-3 py-1 text-xs font-semibold text-red-800">
                                            {{ $employee->overdue_tasks_count }} overdue
                                        </span>
                                    @else
                                        <span class="rounded-full bg-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-800">
                                            On track
                                        </span>
                                    @endif
                                </div>

                                <div class="h-2.5 w-full rounded-full bg-blue-900/40">
                                    <div class="h-2.5 rounded-full bg-gradient-to-r from-blue-400 to-indigo-400" style="width: {{ max(8, $donePercent) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-12 text-center">
                                <p class="text-lg font-semibold text-blue-200">No employee data yet</p>
                                <p class="mt-2 text-sm text-blue-300">Performance data will appear once tasks are assigned.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-blue-100">Upcoming Deadlines</h4>
                            <p class="mt-1 text-sm text-blue-300">Tasks that need attention soon.</p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse($upcomingDeadlines as $task)
                            @php
                                $dueDate = \Carbon\Carbon::parse($task->due_date);
                                $daysLeft = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
                            @endphp

                            <div class="rounded-xl border border-blue-800 bg-blue-950/40 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-blue-100">{{ $task->title }}</p>
                                        <p class="mt-1 text-xs text-blue-300">
                                            {{ $task->user->name ?? 'Unknown employee' }}
                                        </p>
                                    </div>

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        @if($daysLeft <= 1) bg-red-200 text-red-800
                                        @elseif($daysLeft <= 3) bg-yellow-200 text-yellow-800
                                        @else bg-blue-200 text-blue-800
                                        @endif">
                                        @if($daysLeft < 0)
                                            Overdue
                                        @elseif($daysLeft === 0)
                                            Due today
                                        @elseif($daysLeft === 1)
                                            Due tomorrow
                                        @else
                                            In {{ $daysLeft }} days
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-12 text-center">
                                <p class="text-lg font-semibold text-blue-200">No upcoming deadlines</p>
                                <p class="mt-2 text-sm text-blue-300">You’re all caught up for now.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6 border-t border-blue-800 pt-6">
                        <h5 class="text-sm font-semibold uppercase tracking-wider text-blue-300">Recently Created Tasks</h5>

                        <div class="mt-4 space-y-3">
                            @forelse($recentTasks as $task)
                                <div class="flex items-center justify-between rounded-xl border border-blue-800 bg-blue-950/30 px-4 py-3">
                                    <div>
                                        <p class="text-sm font-semibold text-blue-100">{{ $task->title }}</p>
                                        <p class="text-xs text-blue-300">{{ $task->user->name ?? 'Unknown employee' }}</p>
                                    </div>

                                    <span class="text-xs text-blue-400">
                                        {{ $task->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-blue-300">No recent tasks yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
