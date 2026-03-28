<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Employee Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-8 lg:px-12">
            <div class="rounded-3xl border-2 border-blue-900 bg-gray-900 shadow-2xl shadow-blue-900/30 p-14">
                <p class="text-blue-200 mb-10 text-2xl font-bold tracking-wide text-center">My Task Overview</p>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-10">
                    <div class="rounded-2xl border border-yellow-900 bg-gradient-to-br from-yellow-900/80 to-gray-900 p-6 shadow shadow-yellow-900/20 text-center">
                        <p class="text-base font-semibold text-yellow-200">Pending</p>
                        <p class="text-3xl font-extrabold text-yellow-100">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-blue-900 bg-gradient-to-br from-blue-900/80 to-gray-900 p-6 shadow shadow-blue-900/20 text-center">
                        <p class="text-base font-semibold text-blue-200">In Progress</p>
                        <p class="text-3xl font-extrabold text-blue-100">{{ $stats['in_progress'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-purple-900 bg-gradient-to-br from-purple-900/80 to-gray-900 p-6 shadow shadow-purple-900/20 text-center">
                        <p class="text-base font-semibold text-purple-200">Awaiting Review</p>
                        <p class="text-3xl font-extrabold text-purple-100">{{ $stats['awaiting_review'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-red-900 bg-gradient-to-br from-red-900/80 to-gray-900 p-6 shadow shadow-red-900/20 text-center">
                        <p class="text-base font-semibold text-red-200">Overdue</p>
                        <p class="text-3xl font-extrabold text-red-100">{{ $stats['overdue'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-900 bg-gradient-to-br from-emerald-900/80 to-gray-900 p-6 shadow shadow-emerald-900/20 text-center">
                        <p class="text-base font-semibold text-emerald-200">Done</p>
                        <p class="text-3xl font-extrabold text-emerald-100">{{ $stats['done'] }}</p>
                    </div>
                </div>

                <div class="mt-12 flex justify-center">
                    <a href="{{ route('tasks.index') }}"
                       class="inline-flex items-center rounded-2xl bg-gradient-to-r from-indigo-500 via-blue-600 to-indigo-700 px-10 py-4 text-lg font-bold text-white shadow-xl shadow-indigo-900/30 transition hover:from-indigo-600 hover:to-blue-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        View My Tasks
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
