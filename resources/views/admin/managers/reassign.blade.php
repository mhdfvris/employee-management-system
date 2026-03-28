<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Reassign Employees
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20 p-10">

                <p class="text-blue-200 mb-6 text-lg font-semibold">
                    Moving employees from:
                    <span class="font-bold text-white">{{ $manager->name }}</span>
                    ({{ $manager->email }})
                </p>

                @if($employees->isEmpty())
                    <p class="text-blue-300 mb-6">
                        This manager has no employees to reassign.
                    </p>

                    <a href="{{ route('admin.managers.index') }}"
                       class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-base font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                        ← Back to Managers
                    </a>
                @else
                    @if(session('error'))
                        <div class="mb-4 rounded-lg bg-red-900/80 px-4 py-2 text-red-200">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6 text-sm text-blue-300">
                        Total Employees: <span class="font-bold text-white">{{ $employees->count() }}</span>
                    </div>

                    <div class="mb-8">
                        <h3 class="mb-2 font-semibold text-blue-200">Employees affected</h3>
                        <ul class="list-disc pl-5 text-base text-blue-100 space-y-1">
                            @foreach($employees as $e)
                                <li>{{ $e->name }} ({{ $e->email }})</li>
                            @endforeach
                        </ul>
                    </div>

                    @if($recommendedManager)
                        <div class="mb-6 rounded-xl border border-green-700 bg-green-900/30 p-4">
                            <p class="text-sm text-green-300">
                                Recommended:
                                <span class="font-bold text-white">{{ $recommendedManager->name }}</span>
                                — {{ $recommendedManager->employees_count }} employees,
                                {{ $recommendedManager->managed_tasks_count }} tasks
                            </p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.managers.reassign.store', $manager) }}">
                        @csrf

                        <div class="mb-10">
                            <label class="block mb-2 text-base font-semibold text-blue-200">
                                New Manager
                            </label>

                            <select
                                name="new_manager_id"
                                class="w-full rounded border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                required
                            >
                                @foreach($otherManagers as $m)
                                    <option
                                        value="{{ $m->id }}"
                                        {{ $recommendedManager && $m->id === $recommendedManager->id ? 'selected' : '' }}
                                    >
                                        {{ $m->name }} ({{ $m->email }}) — {{ $m->employees_count }} employees, {{ $m->managed_tasks_count }} tasks
                                        {{ $recommendedManager && $m->id === $recommendedManager->id ? ' [Recommended]' : '' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('new_manager_id')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-sm text-blue-300">
                                The recommended manager is preselected, but you can choose any other available manager.
                            </p>
                        </div>

                        <div class="flex gap-4 items-center mt-8">
                            <button
                                type="submit"
                                onclick="return confirm('Reassign ALL employees to the selected manager?');"
                                class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-base font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700"
                            >
                                Reassign Employees
                            </button>

                            <a href="{{ route('admin.managers.index') }}"
                               class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-base font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                                Cancel
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
