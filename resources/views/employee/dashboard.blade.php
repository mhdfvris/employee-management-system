<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employee Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700 mb-4">My Task Overview</p>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                    <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-center">
                        <p class="text-sm">Pending</p>
                        <p class="text-xl font-bold">{{ $stats['pending'] }}</p>
                    </div>

                    <div class="bg-blue-100 text-blue-800 p-4 rounded text-center">
                        <p class="text-sm">In Progress</p>
                        <p class="text-xl font-bold">{{ $stats['in_progress'] }}</p>
                    </div>

                    <div class="bg-purple-100 text-purple-800 p-4 rounded text-center">
                        <p class="text-sm">Awaiting Review</p>
                        <p class="text-xl font-bold">{{ $stats['awaiting_review'] }}</p>
                    </div>

                    <div class="bg-red-100 text-red-800 p-4 rounded text-center">
                        <p class="text-sm">Overdue</p>
                        <p class="text-xl font-bold">{{ $stats['overdue'] }}</p>
                    </div>

                    <div class="bg-green-100 text-green-800 p-4 rounded text-center">
                        <p class="text-sm">Done</p>
                        <p class="text-xl font-bold">{{ $stats['done'] }}</p>
                    </div>

                </div>

                <div class="mt-6">
                    <a href="{{ route('tasks.index') }}"
                    class="inline-block bg-blue-600 text-white px-4 py-2 rounded text-sm">
                        View My Tasks
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
