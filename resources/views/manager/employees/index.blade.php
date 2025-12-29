<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employees
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="mb-4">
                        <a href="{{ route('manager.employees.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded">
                            + Add Employee
                        </a>
                    </div>

                    @if($employees->isEmpty())
                        <p>No employees found.</p>
                    @else
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Name</th>
                                    <th class="py-2">Email</th>
                                    <th class="py-2">Employee ID</th>
                                    <th class="py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $emp)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $emp->name }}</td>
                                        <td class="py-2">{{ $emp->email }}</td>
                                        <td class="py-2">{{ $emp->employee_id }}</td>
                                        <td class="py-2">
                                            <a href="{{ route('manager.employees.edit', $emp) }}"
                                               class="text-blue-600">Edit</a>

                                            <form action="{{ route('manager.employees.destroy', $emp) }}"
                                                  method="POST" class="inline-block ml-2"
                                                  onsubmit="return confirm('Delete employee?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
