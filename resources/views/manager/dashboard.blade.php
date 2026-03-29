<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white tracking-tight">
            Manager Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-400">Team Overview</p>
                    <h3 class="mt-2 text-3xl font-bold text-white">Manage your team at a glance</h3>
                    <p class="mt-2 text-sm text-slate-400">Track workload, monitor overdue tasks, and manage employees from one place.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('manager.tasks.index') }}"
                       class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:bg-indigo-500">
                        Manage Tasks
                    </a>

                    <a href="{{ route('manager.employees.index') }}"
                       class="inline-flex items-center rounded-xl border border-slate-700 bg-slate-800 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:border-slate-600 hover:bg-slate-700 hover:text-white">
                        Manage Employees
                    </a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-800 bg-white p-5 shadow-xl shadow-black/10">
                    <p class="text-sm font-medium text-slate-500">Employees</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['employees'] }}</p>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Team</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-white p-5 shadow-xl shadow-black/10">
                    <p class="text-sm font-medium text-slate-500">Total Tasks</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['tasks_total'] }}</p>
                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">All</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-white p-5 shadow-xl shadow-black/10">
                    <p class="text-sm font-medium text-slate-500">Pending</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['pending'] }}</p>
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Pending</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-white p-5 shadow-xl shadow-black/10">
                    <p class="text-sm font-medium text-slate-500">In Progress</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['in_progress'] }}</p>
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">Active</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-white p-5 shadow-xl shadow-black/10">
                    <p class="text-sm font-medium text-slate-500">Awaiting Review</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['awaiting_review'] }}</p>
                        <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">Review</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-white p-5 shadow-xl shadow-black/10">
                    <p class="text-sm font-medium text-slate-500">Overdue</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['overdue'] }}</p>
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Urgent</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-white p-5 shadow-xl shadow-black/10">
                    <p class="text-sm font-medium text-slate-500">Done</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['done'] }}</p>
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Completed</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-800 p-5 text-white shadow-xl shadow-black/20">
                    <p class="text-sm font-medium text-slate-300">Completion Rate</p>
                    @php
                        $total = max($stats['tasks_total'], 1);
                        $completion = round(($stats['done'] / $total) * 100);
                    @endphp
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold">{{ $completion }}%</p>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-slate-200">Performance</span>
                    </div>
                    <div class="mt-4 h-2.5 w-full rounded-full bg-white/10">
                        <div class="h-2.5 rounded-full bg-indigo-400" style="width: {{ $completion }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-slate-800 bg-white p-6 shadow-xl shadow-black/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-slate-900">Quick Actions</h4>
                            <p class="mt-1 text-sm text-slate-500">Handle your most common manager actions fast.</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <a href="{{ route('manager.tasks.create') }}"
                           class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                            + Create New Task
                        </a>

                        <a href="{{ route('manager.tasks.index') }}"
                           class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                            View All Tasks
                        </a>

                        <a href="{{ route('manager.employees.create') }}"
                           class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            + Add Employee
                        </a>

                        <a href="{{ route('manager.employees.index') }}"
                           class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:border-purple-200 hover:bg-purple-50 hover:text-purple-700">
                            Manage Team
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-white p-6 shadow-xl shadow-black/10">
                    <h4 class="text-lg font-semibold text-slate-900">Workload Summary</h4>
                    <p class="mt-1 text-sm text-slate-500">A quick breakdown of current team task distribution.</p>

                    <div class="mt-5 space-y-4">
                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">Pending</span>
                                <span class="text-slate-500">{{ $stats['pending'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100">
                                <div class="h-2.5 rounded-full bg-yellow-400" style="width: {{ max(8, round(($stats['pending'] / max($stats['tasks_total'], 1)) * 100)) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">In Progress</span>
                                <span class="text-slate-500">{{ $stats['in_progress'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100">
                                <div class="h-2.5 rounded-full bg-blue-500" style="width: {{ max(8, round(($stats['in_progress'] / max($stats['tasks_total'], 1)) * 100)) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">Awaiting Review</span>
                                <span class="text-slate-500">{{ $stats['awaiting_review'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100">
                                <div class="h-2.5 rounded-full bg-purple-500" style="width: {{ max(8, round(($stats['awaiting_review'] / max($stats['tasks_total'], 1)) * 100)) }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">Done</span>
                                <span class="text-slate-500">{{ $stats['done'] }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100">
                                <div class="h-2.5 rounded-full bg-green-500" style="width: {{ max(8, round(($stats['done'] / max($stats['tasks_total'], 1)) * 100)) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
