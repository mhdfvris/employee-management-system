<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Manage Managers (Admin)
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20 p-10">

                <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4 md:items-center justify-between">
                    <div class="flex flex-col md:flex-row gap-4 w-full md:w-2/3 items-center">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search managers..."
                            class="w-full px-4 py-2 rounded-lg bg-blue-950 border border-blue-800 text-blue-100 focus:ring focus:ring-blue-500/30"
                        >
                        <select name="filter"
                            class="px-4 py-2 rounded-lg bg-blue-950 border border-blue-800 text-blue-100 min-w-[150px]">
                            <option value="">All Managers</option>
                            <option value="has_employees" {{ request('filter') == 'has_employees' ? 'selected' : '' }}>
                                With Employees
                            </option>
                            <option value="no_employees" {{ request('filter') == 'no_employees' ? 'selected' : '' }}>
                                No Employees
                            </option>
                        </select>
                        <button class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">
                            Apply
                        </button>
                        <a href="{{ route('admin.managers.index') }}"
                           class="px-4 py-2 rounded-lg bg-gray-700 text-white hover:bg-gray-600">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="mb-8 flex justify-end md:-mt-16">
                    <a href="{{ route('admin.managers.create') }}"
                       class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-base font-semibold text-white shadow-lg transition hover:from-blue-600 hover:to-indigo-700">
                        + New Manager
                    </a>
                </div>

                @if($managers->isEmpty())
                    <p class="text-blue-200">No managers found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-base text-blue-100">
                            <thead>
                                <tr class="border-b border-blue-800">
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3 text-center">Employees</th>
                                    <th class="py-3 text-center">Tasks</th>
                                    <th class="py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($managers as $manager)
                                    <tr class="border-b border-blue-800 hover:bg-blue-950/40 transition">
                                        <td class="py-3 font-semibold">
                                            {{ $manager->name }}
                                        </td>

                                        <td class="py-3 text-blue-300">
                                            {{ $manager->email }}
                                        </td>

                                        <td class="py-3 text-center">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $manager->employees_count > 0 ? 'bg-blue-700 text-white' : 'bg-gray-600 text-gray-200' }}">
                                                {{ $manager->employees_count }}
                                            </span>
                                        </td>

                                        <td class="py-3 text-center">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $manager->managed_tasks_count > 0 ? 'bg-purple-700 text-white' : 'bg-gray-600 text-gray-200' }}">
                                                {{ $manager->managed_tasks_count }}
                                            </span>
                                        </td>

                                        <td class="py-3">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.managers.show', $manager) }}"
                                                class="inline-flex items-center rounded-lg bg-blue-900 px-3 py-2 text-sm font-medium text-blue-100 transition hover:bg-blue-800">
                                                    View
                                                </a>

                                                <a href="{{ route('admin.managers.edit', $manager) }}"
                                                class="inline-flex items-center rounded-lg bg-blue-950 px-3 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                                                    Edit
                                                </a>

                                                <a href="{{ route('admin.managers.reassign', $manager) }}"
                                                class="inline-flex items-center rounded-lg bg-blue-950 px-3 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                                                    Reassign
                                                </a>

                                                <form method="POST"
                                                    action="{{ route('admin.managers.destroy', $manager) }}"
                                                    onsubmit="return confirm('Delete this manager?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center rounded-lg bg-red-200 px-3 py-2 text-sm font-medium text-red-900 transition hover:bg-red-400 hover:text-white">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
