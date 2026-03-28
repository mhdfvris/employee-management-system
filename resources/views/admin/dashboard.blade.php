<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-400">System Overview</p>
                    <h3 class="mt-2 text-3xl font-bold text-blue-100">Monitor your system at a glance</h3>
                    <p class="mt-2 text-sm text-blue-300">Track managers, employees, and task statuses from one place.</p>
                </div>

                <a href="{{ route('admin.managers.index') }}"
                   class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-base font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                    Manage Managers
                </a>
            </div>

            @php
                $total = max($stats['tasks_total'], 1);
            @endphp

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-10">
                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-800 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">Managers</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-blue-100">{{ $stats['managers'] }}</p>
                        <span class="rounded-full bg-blue-800/40 px-3 py-1 text-xs font-semibold text-blue-200">Admins</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-800 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">Employees</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-blue-100">{{ $stats['employees'] }}</p>
                        <span class="rounded-full bg-blue-800/40 px-3 py-1 text-xs font-semibold text-blue-200">Team</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-950 bg-gradient-to-br from-blue-950 via-indigo-950 to-blue-900 p-5 shadow-xl shadow-blue-950/30">
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
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-100">Top Manager</h4>
                    <p class="mt-1 text-sm text-blue-300">Best based on completed tasks.</p>

                    @if($topManager)
                        <div class="mt-5 rounded-xl border border-blue-800 bg-blue-950/40 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-lg font-semibold text-white">{{ $topManager->name }}</p>
                                    <p class="mt-1 text-sm text-blue-300">{{ $topManager->email }}</p>
                                </div>

                                <span class="rounded-full bg-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-800">
                                    {{ $topManager->done_tasks_count }} done
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-3 text-sm">
                                <div class="rounded-lg bg-gray-900/70 px-3 py-3 text-blue-200">
                                    Employees
                                    <div class="mt-1 text-lg font-bold text-white">{{ $topManager->employees_count }}</div>
                                </div>
                                <div class="rounded-lg bg-gray-900/70 px-3 py-3 text-blue-200">
                                    Total Tasks
                                    <div class="mt-1 text-lg font-bold text-white">{{ $topManager->managed_tasks_count }}</div>
                                </div>
                                <div class="rounded-lg bg-gray-900/70 px-3 py-3 text-blue-200">
                                    Overdue
                                    <div class="mt-1 text-lg font-bold {{ $topManager->overdue_tasks_count > 0 ? 'text-red-300' : 'text-white' }}">
                                        {{ $topManager->overdue_tasks_count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-5 rounded-xl border border-dashed border-blue-800 bg-blue-950 px-6 py-10 text-center">
                            <p class="text-blue-200">No manager data yet.</p>
                        </div>
                    @endif
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-100">Most Overloaded Manager</h4>
                    <p class="mt-1 text-sm text-blue-300">Based on overdue tasks and current workload.</p>

                    @if($overloadedManager)
                        <div class="mt-5 rounded-xl border border-blue-800 bg-blue-950/40 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-lg font-semibold text-white">{{ $overloadedManager->name }}</p>
                                    <p class="mt-1 text-sm text-blue-300">{{ $overloadedManager->email }}</p>
                                </div>

                                <span class="rounded-full {{ $overloadedManager->overdue_tasks_count > 0 ? 'bg-red-200 text-red-800' : 'bg-blue-200 text-blue-800' }} px-3 py-1 text-xs font-semibold">
                                    {{ $overloadedManager->overdue_tasks_count }} overdue
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-3 text-sm">
                                <div class="rounded-lg bg-gray-900/70 px-3 py-3 text-blue-200">
                                    Employees
                                    <div class="mt-1 text-lg font-bold text-white">{{ $overloadedManager->employees_count }}</div>
                                </div>
                                <div class="rounded-lg bg-gray-900/70 px-3 py-3 text-blue-200">
                                    Total Tasks
                                    <div class="mt-1 text-lg font-bold text-white">{{ $overloadedManager->managed_tasks_count }}</div>
                                </div>
                                <div class="rounded-lg bg-gray-900/70 px-3 py-3 text-blue-200">
                                    Done
                                    <div class="mt-1 text-lg font-bold text-white">{{ $overloadedManager->done_tasks_count }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-5 rounded-xl border border-dashed border-blue-800 bg-blue-950 px-6 py-10 text-center">
                            <p class="text-blue-200">No manager workload data yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                <h4 class="text-lg font-semibold text-blue-100">Recently Added Managers</h4>
                <p class="mt-1 text-sm text-blue-300">Latest manager accounts in the system.</p>

                <div class="mt-5 space-y-3">
                    @forelse($recentManagers as $manager)
                        <div class="flex items-center justify-between rounded-xl border border-blue-800 bg-blue-950/30 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold text-blue-100">{{ $manager->name }}</p>
                                <p class="text-xs text-blue-300">{{ $manager->email }}</p>
                            </div>

                            <span class="text-xs text-blue-400">
                                {{ $manager->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-blue-300">No managers found.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
