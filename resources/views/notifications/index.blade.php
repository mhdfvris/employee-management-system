<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-blue-900 shadow-xl shadow-blue-900/20 sm:rounded-lg p-6">

                @php
                    $unreadCount = $notifications->whereNull('read_at')->count();
                @endphp

                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-blue-100">All Notifications</h3>
                        <p class="mt-1 text-sm text-blue-300">
                            Stay updated on overdue tasks, reviews, and team activity.
                        </p>
                    </div>

                    @if($unreadCount > 0)
                        <form method="POST" action="{{ route('notifications.readAll') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                                Mark all as read
                            </button>
                        </form>
                    @endif
                </div>

                @if($notifications->isEmpty())
                    <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-12 text-center">
                        <p class="text-lg font-semibold text-blue-200">No notifications yet</p>
                        <p class="mt-2 text-sm text-blue-300">New task alerts and updates will appear here.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($notifications as $notification)
                            @php
                                $type = $notification->data['type'] ?? 'default';
                                $title = $notification->data['title'] ?? 'Untitled';
                                $isUnread = is_null($notification->read_at);

                                $badgeClasses = match ($type) {
                                    'task_awaiting_review' => 'bg-purple-200 text-purple-800',
                                    'task_overdue' => 'bg-red-200 text-red-800',
                                    'task_done', 'task_completed' => 'bg-emerald-200 text-emerald-800',
                                    default => 'bg-blue-200 text-blue-800',
                                };

                                $cardClasses = $isUnread
                                    ? 'border-blue-500/60 bg-blue-950 shadow-lg shadow-blue-900/20'
                                    : 'border-blue-800 bg-blue-950/60';

                                $label = match ($type) {
                                    'task_awaiting_review' => 'Awaiting Review',
                                    'task_overdue' => 'Overdue',
                                    'task_done', 'task_completed' => 'Completed',
                                    default => 'Update',
                                };

                                $message = match ($type) {
                                    'task_awaiting_review' => "Task {$title} is awaiting review.",
                                    'task_overdue' => "Task {$title} is overdue.",
                                    'task_done', 'task_completed' => "Task {$title} has been completed.",
                                    default => "You have a new notification.",
                                };
                            @endphp

                            <div class="rounded-xl border p-4 transition {{ $cardClasses }}">
                                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                    <div class="min-w-0">
                                        <div class="mb-2 flex flex-wrap items-center gap-2">
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                                {{ $label }}
                                            </span>

                                            @if($isUnread)
                                                <span class="rounded-full bg-amber-200 px-3 py-1 text-xs font-semibold text-amber-800">
                                                    New
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-sm leading-6 text-blue-100">
                                            {!! nl2br(e($message)) !!}
                                        </p>

                                        <p class="mt-2 text-xs text-blue-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    @if($isUnread)
                                        <form method="POST" action="{{ route('notifications.readOne', $notification->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center rounded-lg bg-blue-900 px-3 py-2 text-xs font-semibold text-blue-100 transition hover:bg-blue-800 hover:text-white">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
