<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Edit Employee
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-blue-900 shadow-xl shadow-blue-900/20 sm:rounded-lg p-6">

                <form action="{{ route('manager.employees.update', $employee) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-blue-200 mb-1">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $employee->name) }}"
                               class="border border-blue-800 bg-blue-950 text-blue-200 rounded w-full px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-blue-200 mb-1">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $employee->email) }}"
                               class="border border-blue-800 bg-blue-950 text-blue-200 rounded w-full px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-blue-200 mb-1">Employee ID</label>
                        <input type="text" name="employee_id"
                               value="{{ old('employee_id', $employee->employee_id) }}"
                               class="border border-blue-800 bg-blue-950 text-blue-200 rounded w-full px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30" required>
                    </div>

                    <div class="mt-6 mb-4 flex justify-between items-center gap-4">
                        <a href="{{ route('manager.employees.index') }}"
                           class="inline-flex items-center gap-2 font-bold text-sm px-3 py-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-md shadow-indigo-900/20 hover:from-blue-700 hover:to-indigo-800 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            Back to All Employees
                        </a>

                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 text-sm rounded shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                            Update Employee
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
