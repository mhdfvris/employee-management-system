<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-blue-900 shadow-xl shadow-blue-900/20 sm:rounded-lg p-6">

                @if($notifications->isEmpty())
                    <p class="text-blue-300">No notifications.</p>
                @else
                    <ul class="space-y-3">
                        @foreach ($notifications as $notification)
                            <li class="border border-blue-800 rounded p-3 bg-blue-950">
                                <p class="text-sm text-blue-100">
                                    @if($notification->data['type'] === 'task_awaiting_review')
                                        Task <strong class="text-purple-200">{{ $notification->data['title'] }}</strong>
                                        is awaiting review.
                                    @elseif($notification->data['type'] === 'task_overdue')
                                        Task <strong class="text-red-200">{{ $notification->data['title'] }}</strong>
                                        is overdue.
                                    @else
                                        <span class="text-blue-200">New notification.</span>
                                    @endif
                                </p>

                                <p class="text-xs text-blue-400 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
