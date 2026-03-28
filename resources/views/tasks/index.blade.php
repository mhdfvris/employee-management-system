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
                    <div class="mb-6 flex justify-between items-center">
                        <a href="{{ route('tasks.create') }}"
                            class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                            + New Task
                        </a>
                    </div>

                    @if($tasks->isEmpty())
                        <p class="text-blue-300">No tasks yet.</p>
                    @else
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
                                    <tr class="border-b border-blue-900 transition hover:bg-blue-950/60">
                                        <td class="py-4">{{ $task->title }}</td>
                                        <td class="py-4">
                                            @php
                                                $status = $task->status;
                                                $classes = match ($status) {
                                                    'pending'     => 'bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 text-yellow-900 shadow shadow-yellow-400/30',
                                                    'in_progress' => 'bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 text-blue-900 shadow shadow-blue-400/30',
                                                    'done'        => 'bg-gradient-to-r from-emerald-300 via-emerald-400 to-emerald-500 text-emerald-900 shadow shadow-emerald-400/30',
                                                    'awaiting_review' => 'bg-gradient-to-r from-purple-300 via-purple-400 to-purple-500 text-purple-900 shadow shadow-purple-400/30',
                                                    'overdue'     => 'bg-gradient-to-r from-red-300 via-red-400 to-red-500 text-red-900 shadow shadow-red-400/30',
                                                    default       => 'bg-blue-950 text-blue-200',
                                                };
                                            @endphp

                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $classes }}">
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </span>
                                        </td>
                                        <td class="py-4">{{ $task->due_date }}</td>
                                        <td class="py-4 text-right">
                                            @if($task->status !== 'overdue')
                                                <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center rounded-lg bg-blue-950 px-3 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">Edit</a>

                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block ml-2"
                                                    onsubmit="return confirm('Delete this task?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="inline-flex items-center rounded-lg bg-red-200 px-3 py-2 text-sm font-medium text-red-900 transition hover:bg-red-400 hover:text-white">Delete</button>
                                                </form>
                                            @else
                                                <span class="text-blue-400 text-sm">Locked</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
