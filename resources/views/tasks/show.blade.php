<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Task Details
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php
                $dueDate = \Carbon\Carbon::parse($task->due_date);
                $isLate = $dueDate->isPast() && $task->status !== 'done';
                $isToday = $dueDate->isToday();
            @endphp

            <!-- Task Info -->
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20 p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

                    <div>
                        <h3 class="text-xl font-semibold text-blue-100">
                            {{ $task->title }}
                        </h3>

                        <p class="mt-2 text-sm text-blue-300">
                            {{ $task->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($isLate)
                            bg-red-200 text-red-800
                        @elseif($task->status === 'awaiting_review')
                            bg-purple-200 text-purple-800
                        @elseif($task->status === 'done')
                            bg-emerald-200 text-emerald-800
                        @elseif($task->status === 'in_progress')
                            bg-blue-200 text-blue-800
                        @else
                            bg-yellow-200 text-yellow-800
                        @endif
                    ">
                        {{ $isLate ? 'Overdue' : ucfirst(str_replace('_',' ',$task->status)) }}
                    </span>
                </div>

                <!-- Due Date -->
                <div class="mt-6">
                    <p class="text-sm text-blue-300">Due Date</p>

                    <p class="text-lg font-semibold
                        {{ $isLate ? 'text-red-400' : ($isToday ? 'text-yellow-300' : 'text-blue-100') }}">
                        {{ $dueDate->format('d M Y') }}
                    </p>

                    @if($isLate)
                        <p class="text-xs text-red-300 mt-1">This task is overdue</p>
                    @elseif($isToday)
                        <p class="text-xs text-yellow-300 mt-1">Due today</p>
                    @endif
                </div>
            </div>

            <!-- Manager Feedback -->
            @if($task->reviews->isNotEmpty())
                <div class="rounded-2xl border border-purple-800 bg-purple-950 p-6">
                    <h4 class="text-lg font-semibold text-purple-200 mb-3">
                        Manager Feedback
                    </h4>

                    <div class="space-y-3">
                        @foreach ($task->reviews as $review)
                            <div class="rounded-xl border border-purple-700 bg-purple-900/60 p-4">
                                <div class="text-sm text-purple-300 mb-1">
                                    {{ ucfirst(str_replace('_',' ',$review->decision)) }}
                                    • {{ $review->created_at->format('d M Y, H:i') }}
                                </div>

                                <p class="text-sm text-purple-100">
                                    {{ $review->comment }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Activity Log -->
            @if($task->activities->isNotEmpty())
                <div class="rounded-2xl border border-blue-800 bg-blue-950/40 p-6">
                    <h4 class="text-lg font-semibold text-blue-100 mb-3">
                        Activity Timeline
                    </h4>

                    <div class="space-y-3">
                        @foreach ($task->activities as $activity)
                            <div class="text-sm text-blue-300 border-b border-blue-900 pb-2">
                                <span class="font-semibold text-blue-200">
                                    {{ ucfirst(str_replace('_',' ',$activity->action)) }}
                                </span>
                                <span class="text-xs text-blue-400">
                                    • {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex justify-between items-center">
                <a href="{{ route('tasks.index') }}"
                   class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-sm font-medium text-blue-200 hover:bg-blue-900 hover:text-white">
                    Back
                </a>

                @if(!$isLate)
                    <a href="{{ route('tasks.edit', $task) }}"
                       class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:from-blue-600 hover:to-indigo-700">
                        Edit Task
                    </a>
                @else
                    <span class="text-sm text-red-300 font-semibold">
                        Locked (Overdue)
                    </span>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
