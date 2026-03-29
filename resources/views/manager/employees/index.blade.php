<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white tracking-tight">
            Manage Employees
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-800 bg-white shadow-xl shadow-black/10">
                <div class="border-b border-slate-200 p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Team Members</h3>
                            <p class="mt-1 text-sm text-slate-500">Add, review, and maintain your employee records.</p>
                        </div>

                        <a href="{{ route('manager.employees.create') }}"
                           class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-500">
                            + Add Employee
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($employees->isEmpty())
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                            <p class="text-lg font-semibold text-slate-700">No employees found</p>
                            <p class="mt-2 text-sm text-slate-500">Add your first employee to start assigning work.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                                        <th class="px-4 py-3 font-semibold">Name</th>
                                        <th class="px-4 py-3 font-semibold">Email</th>
                                        <th class="px-4 py-3 font-semibold">Employee ID</th>
                                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $emp)
                                        <tr class="border-b border-slate-100 transition hover:bg-slate-50">
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700">
                                                        {{ strtoupper(substr($emp->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-slate-900">{{ $emp->name }}</p>
                                                        <p class="text-xs text-slate-500">Employee</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-4 py-4 text-slate-700">{{ $emp->email }}</td>
                                            <td class="px-4 py-4 text-slate-700">{{ $emp->employee_id }}</td>

                                            <td class="px-4 py-4">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('manager.employees.edit', $emp) }}"
                                                       class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('manager.employees.destroy', $emp) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Delete employee?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
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
    </div>
</x-app-layout>
