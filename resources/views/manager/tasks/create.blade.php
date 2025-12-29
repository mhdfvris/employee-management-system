<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Task (Manager)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('manager.tasks.store') }}">
                    @csrf

                    <!-- Employee -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Assign To (Employee)
                        </label>
                        <select name="user_id" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">-- Select Employee --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('user_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full border rounded px-3 py-2 text-sm">
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full border rounded px-3 py-2 text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Status
                        </label>
                        <select name="status" class="w-full border rounded px-3 py-2 text-sm">
                            @php $current = old('status', 'pending'); @endphp
                            <option value="pending" {{ $current === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $current === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="done" {{ $current === 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Due Date
                        </label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                               class="w-full border rounded px-3 py-2 text-sm">
                        @error('due_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('manager.tasks.index') }}" class="text-gray-600 text-sm">
                            ← Back to All Tasks
                        </a>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 text-sm rounded">
                            Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
