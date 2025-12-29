<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('manager.employees.update', $employee) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $employee->name) }}"
                               class="border rounded w-full px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $employee->email) }}"
                               class="border rounded w-full px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Employee ID</label>
                        <input type="text" name="employee_id"
                               value="{{ old('employee_id', $employee->employee_id) }}"
                               class="border rounded w-full px-3 py-2" required>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('manager.employees.index') }}" class="text-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Update Employee
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
