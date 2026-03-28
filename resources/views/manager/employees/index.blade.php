<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Manage Employees
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20">

                <!-- Header -->
                <div class="border-b border-blue-800 p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-100">Team Members</h3>
                            <p class="mt-1 text-sm text-blue-300">Add, review, and maintain your employee records.</p>
                        </div>

                        <a href="{{ route('manager.employees.create') }}"
                           class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                            + Add Employee
                        </a>
                    </div>
                </div>

                <div class="p-6">

                    <!-- 🔍 SEARCH -->
                    <form method="GET" class="mb-6 flex flex-col md:flex-row gap-3 md:items-center md:justify-start">
                        <div class="flex gap-2 w-full md:w-auto">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search by name, email, or ID..."
                                   class="w-full md:w-80 px-4 py-2 rounded-lg bg-gray-800 border border-blue-900 text-blue-100 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-500 transition">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- ERROR MODAL -->
                    @if (session('error'))
                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-8 py-6 text-base font-medium text-rose-300 shadow-2xl shadow-black/30 flex flex-col items-center gap-4 max-w-md w-full">
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($employees->isEmpty())
                        <div class="rounded-2xl border border-dashed border-blue-800 bg-blue-950 px-6 py-12 text-center">
                            <p class="text-lg font-semibold text-blue-200">No employees found</p>
                        </div>
                    @else

                        <!-- TABLE -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-blue-800 text-xs uppercase tracking-wider text-blue-300">
                                        <th class="px-4 py-3 font-semibold">Name</th>
                                        <th class="px-4 py-3 font-semibold">Email</th>
                                        <th class="px-4 py-3 font-semibold">Employee ID</th>
                                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($employees as $emp)
                                        <tr class="border-b border-blue-900 transition hover:bg-blue-950/60">

                                            <!-- CLICKABLE NAME -->
                                            <td class="px-4 py-4">
                                                <a href="{{ route('manager.employees.show', $emp) }}"
                                                   class="flex items-center gap-3 group">

                                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-200 text-sm font-bold text-blue-900">
                                                        {{ strtoupper(substr($emp->name, 0, 1)) }}
                                                    </div>

                                                    <div>
                                                        <p class="font-semibold text-blue-100 group-hover:text-white transition">
                                                            {{ $emp->name }}
                                                        </p>
                                                        <p class="text-xs text-blue-300">Employee</p>
                                                    </div>
                                                </a>
                                            </td>

                                            <td class="px-4 py-4 text-blue-200">{{ $emp->email }}</td>
                                            <td class="px-4 py-4 text-blue-200">{{ $emp->employee_id }}</td>

                                            <td class="px-4 py-4">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('manager.employees.edit', $emp) }}"
                                                       class="inline-flex items-center rounded-lg bg-blue-950 px-3 py-2 text-sm font-medium text-blue-200 hover:bg-blue-900 hover:text-white">
                                                        Edit
                                                    </a>

                                                    <!-- DELETE CONFIRM -->
                                                    <form action="{{ route('manager.employees.destroy', $emp) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center rounded-lg bg-red-200 px-3 py-2 text-sm font-medium text-red-900 hover:bg-red-400 hover:text-white">
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

                        <!-- 📄 PAGINATION -->
                        <div class="mt-6">
                            {{ $employees->links() }}
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
