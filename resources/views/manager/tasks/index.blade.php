<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Tasks (Manager)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('manager.tasks.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 text-sm rounded">
                            + New Task
                        </a>
                    </div>

                    @if($tasks->isEmpty())
                        <p>No tasks found.</p>
                    @else
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Employee</th>
                                    <th class="py-2">Title</th>
                                    <th class="py-2">Status</th>
                                    <th class="py-2">Due Date</th>
                                    <th class="py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $task->user->name ?? 'Unknown' }}</td>
                                        <td class="py-2">{{ $task->title }}</td>
                                        <td class="py-2">
                                            @php
                                                $status = $task->status;
                                                $classes = match ($status) {
                                                    'pending'     => 'bg-yellow-100 text-yellow-800',
                                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                                    'done'        => 'bg-green-100 text-green-800',
                                                    'awaiting_review' => 'bg-purple-100 text-purple-800',
                                                    'overdue'     => 'bg-red-100 text-red-800',
                                                    default       => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp

                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded {{ $classes }}">
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </span>
                                        </td>
                                        <td class="py-2">{{ $task->due_date }}</td>
                                        <td class="py-2">
                                            <a href="{{ route('manager.tasks.show', $task) }}" class="text-blue-600">
                                                View
                                            </a>
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
