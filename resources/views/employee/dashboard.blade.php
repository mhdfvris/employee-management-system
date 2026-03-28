<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Employee Dashboard
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-400">My Workspace</p>
                    <h3 class="mt-2 text-3xl font-bold text-blue-100">Track your tasks clearly</h3>
                    <p class="mt-2 text-sm text-blue-300">Monitor progress, deadlines, and tasks waiting for review.</p>
                </div>

                <a href="{{ route('tasks.index') }}"
                   class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                    View My Tasks
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-800 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">Total</p>
                    <p class="mt-3 text-3xl font-bold text-blue-100">{{ $stats['total'] }}</p>
                </div>

                <div class="rounded-2xl border border-yellow-900 bg-gradient-to-br from-yellow-900/80 to-gray-900 p-5 shadow-xl shadow-yellow-900/30">
                    <p class="text-sm font-medium text-yellow-200">Pending</p>
                    <p class="mt-3 text-3xl font-bold text-yellow-100">{{ $stats['pending'] }}</p>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900/80 to-gray-900 p-5 shadow-xl shadow-blue-900/30">
                    <p class="text-sm font-medium text-blue-200">In Progress</p>
                    <p class="mt-3 text-3xl font-bold text-blue-100">{{ $stats['in_progress'] }}</p>
                </div>

                <div class="rounded-2xl border border-purple-900 bg-gradient-to-br from-purple-900/80 to-gray-900 p-5 shadow-xl shadow-purple-900/30">
                    <p class="text-sm font-medium text-purple-200">Awaiting Review</p>
                    <p class="mt-3 text-3xl font-bold text-purple-100">{{ $stats['awaiting_review'] }}</p>
                </div>

                <div class="rounded-2xl border border-red-900 bg-gradient-to-br from-red-900/80 to-gray-900 p-5 shadow-xl shadow-red-900/30">
                    <p class="text-sm font-medium text-red-200">Overdue</p>
                    <p class="mt-3 text-3xl font-bold text-red-100">{{ $stats['overdue'] }}</p>
                </div>

                <div class="rounded-2xl border border-emerald-900 bg-gradient-to-br from-emerald-900/80 to-gray-900 p-5 shadow-xl shadow-emerald-900/30">
                    <p class="text-sm font-medium text-emerald-200">Done</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-100">{{ $stats['done'] }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-100">Progress Summary</h4>
                    <p class="mt-1 text-sm text-blue-300">A quick look at your current workload.</p>

                    @php
                        $total = max($stats['total'], 1);
                    @endphp

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

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-6 shadow-xl shadow-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-100">Upcoming Deadlines</h4>
                    <p class="mt-1 text-sm text-blue-300">Tasks that need your attention soon.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($upcomingTasks as $task)
                            @php
                                $dueDate = \Carbon\Carbon::parse($task->due_date);
                                $daysLeft = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
                            @endphp

                            <div class="rounded-xl border border-blue-800 bg-blue-950/40 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-blue-100">{{ $task->title }}</p>
                                        <p class="mt-1 text-xs text-blue-300">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </p>
                                    </div>

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        @if($daysLeft <= 1) bg-red-200 text-red-800
                                        @elseif($daysLeft <= 3) bg-yellow-200 text-yellow-800
                                        @else bg-blue-200 text-blue-800
                                        @endif">
                                        @if($daysLeft === 0)
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
