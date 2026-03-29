<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Add Employee
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-blue-900 shadow-2xl shadow-blue-900/30 rounded-2xl p-8">

                <form action="{{ route('manager.employees.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-blue-100 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="border border-blue-800 bg-blue-950 text-blue-100 rounded-lg w-full px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-500/30 transition" required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-blue-100 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="border border-blue-800 bg-blue-950 text-blue-100 rounded-lg w-full px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-500/30 transition" required>
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-blue-100 mb-1">Employee ID</label>
                        <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                            class="border border-blue-800 bg-blue-950 text-blue-100 rounded-lg w-full px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-500/30 transition" required>
                        @error('employee_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-blue-100 mb-1">Initial Password</label>
                        <input type="password" name="password"
                            class="border border-blue-800 bg-blue-950 text-blue-100 rounded-lg w-full px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-500/30 transition" required>
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-8 mb-2 flex justify-between items-center gap-4">
                        <a href="{{ route('manager.employees.index') }}"
                           class="inline-flex items-center gap-2 font-semibold text-sm px-3 py-1.5 rounded-md bg-gradient-to-r from-blue-700 to-indigo-800 text-white shadow-md shadow-indigo-900/20 hover:from-blue-800 hover:to-indigo-900 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-150">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            Back to All Employees
                        </a>

                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-1.5 text-sm rounded-md font-semibold shadow-lg shadow-indigo-900/30 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-150">
                            Create Employee
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
