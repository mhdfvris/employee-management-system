<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            New Task
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20">
                <div class="p-8 text-blue-100">
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-blue-100">Create a New Task</h3>
                        <p class="mt-1 text-sm text-blue-300">
                            Add a task, set a deadline, and update its progress as you work.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Title</label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Enter task title"
                                class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 placeholder-blue-400 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                required
                            >
                            @error('title')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-blue-200 font-semibold">Description</label>
                            <textarea
                                name="description"
                                rows="4"
                                placeholder="Add more details about this task"
                                class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 placeholder-blue-400 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="mb-2">
                                <label class="block mb-2 text-blue-200 font-semibold">Status</label>
                                <select
                                    name="status"
                                    class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                    required
                                >
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="awaiting_review" {{ old('status') == 'awaiting_review' ? 'selected' : '' }}>Awaiting Review</option>
                                </select>
                                <p class="mt-2 text-xs text-blue-300">
                                    Choose <span class="font-semibold text-purple-300">Awaiting Review</span> only when the task is ready to be checked.
                                </p>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label class="block mb-2 text-blue-200 font-semibold">Due Date</label>
                                <input
                                    type="date"
                                    name="due_date"
                                    value="{{ old('due_date') }}"
                                    min="{{ now()->toDateString() }}"
                                    class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                    required
                                >
                                <p class="mt-2 text-xs text-blue-300">
                                    Set a realistic deadline to avoid the task becoming overdue.
                                </p>
                                @error('due_date')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 rounded-2xl border border-blue-800 bg-blue-950/40 p-5">
                            <h4 class="text-sm font-semibold uppercase tracking-wider text-blue-300">
                                Task Tips
                            </h4>
                            <ul class="mt-3 space-y-2 text-sm text-blue-200">
                                <li>• Start with <span class="font-semibold text-yellow-200">Pending</span> if work has not started yet.</li>
                                <li>• Move to <span class="font-semibold text-blue-200">In Progress</span> when actively working on it.</li>
                                <li>• Use <span class="font-semibold text-purple-300">Awaiting Review</span> when you want your manager to review it.</li>
                            </ul>
                        </div>

                        <div class="mt-8 flex items-center justify-between">
                            <a
                                href="{{ route('tasks.index') }}"
                                class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-base font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-base font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700"
                            >
                                Save Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
