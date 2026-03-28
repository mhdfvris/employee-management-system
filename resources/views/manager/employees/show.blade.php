<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Employee Profile
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Top Bar -->
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-200 text-xl font-bold text-blue-900">
                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="text-2xl font-semibold text-blue-100">{{ $employee->name }}</h3>
                        <p class="mt-1 text-sm text-blue-300">{{ $employee->email }}</p>
                        <p class="text-xs text-blue-400">Employee ID: {{ $employee->employee_id }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('manager.employees.edit', $employee) }}"
                       class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-500">
                        Edit Employee
                    </a>

                    <a href="{{ route('manager.employees.index') }}"
                       class="inline-flex items-center rounded-xl bg-blue-950 px-4 py-2.5 text-sm font-semibold text-blue-200 transition hover:bg-blue-900 hover:text-white">
                        Back to Employees
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-5 shadow-xl shadow-blue-900/20">
                    <p class="text-sm text-blue-300">Total Tasks</p>
                    <p class="mt-3 text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-5 shadow-xl shadow-blue-900/20">
                    <p class="text-sm text-blue-300">Pending</p>
                    <p class="mt-3 text-3xl font-bold text-yellow-300">{{ $stats['pending'] }}</p>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-5 shadow-xl shadow-blue-900/20">
                    <p class="text-sm text-blue-300">In Progress</p>
                    <p class="mt-3 text-3xl font-bold text-blue-300">{{ $stats['in_progress'] }}</p>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-5 shadow-xl shadow-blue-900/20">
                    <p class="text-sm text-blue-300">Awaiting Review</p>
                    <p class="mt-3 text-3xl font-bold text-purple-300">{{ $stats['awaiting_review'] }}</p>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-5 shadow-xl shadow-blue-900/20">
                    <p class="text-sm text-blue-300">Done</p>
                    <p class="mt-3 text-3xl font-bold text-green-300">{{ $stats['done'] }}</p>
                </div>

                <div class="rounded-2xl border border-blue-900 bg-gray-900 p-5 shadow-xl shadow-blue-900/20">
                    <p class="text-sm text-blue-300">Overdue</p>
                    <p class="mt-3 text-3xl font-bold text-red-300">{{ $stats['overdue'] }}</p>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="mt-8 rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20">
                <div class="border-b border-blue-800 p-6">
                    <h4 class="text-lg font-semibold text-blue-100">Assigned Tasks</h4>
                    <p class="mt-1 text-sm text-blue-300">Tasks currently assigned to this employee.</p>
                </div>

                <div class="p-6">
                    @if($tasks->isEmpty())
                        <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-12 text-center">
                            <p class="text-lg font-semibold text-blue-200">No tasks assigned</p>
                            <p class="mt-2 text-sm text-blue-300">This employee has no tasks yet.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-blue-800 text-xs uppercase tracking-wider text-blue-300">
                                        <th class="px-4 py-3 font-semibold">Title</th>
                                        <th class="px-4 py-3 font-semibold">Status</th>
                                        <th class="px-4 py-3 font-semibold">Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr class="border-b border-blue-900 transition hover:bg-blue-950/60">
                                            <td class="px-4 py-4">
                                                <div>
                                                    <p class="font-semibold text-blue-100">{{ $task->title }}</p>
                                                    <p class="mt-1 text-xs text-blue-300">
                                                        {{ \Illuminate\Support\Str::limit($task->description, 70) }}
                                                    </p>
                                                </div>
                                            </td>

                                            <td class="px-4 py-4">
                                                @php
                                                    $statusClasses = match($task->status) {
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                                        'awaiting_review' => 'bg-purple-100 text-purple-800',
                                                        'done' => 'bg-green-100 text-green-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                @endphp

                                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-4 text-blue-200">
                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '—' }}
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