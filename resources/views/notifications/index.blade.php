<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if($notifications->isEmpty())
                    <p class="text-gray-600">No notifications.</p>
                @else
                    <ul class="space-y-3">
                        @foreach ($notifications as $notification)
                            <li class="border rounded p-3 bg-gray-50">
                                <p class="text-sm text-gray-800">
                                    @if($notification->data['type'] === 'task_awaiting_review')
                                        Task <strong>{{ $notification->data['title'] }}</strong>
                                        is awaiting review.
                                    @elseif($notification->data['type'] === 'task_overdue')
                                        Task <strong>{{ $notification->data['title'] }}</strong>
                                        is overdue.
                                    @else
                                        New notification.
                                    @endif
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
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
