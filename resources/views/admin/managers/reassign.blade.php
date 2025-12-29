<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reassign Employees
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <p class="text-gray-700 mb-4">
                    Moving employees from:
                    <span class="font-semibold">{{ $manager->name }}</span>
                    ({{ $manager->email }})
                </p>

                @if($employees->isEmpty())
                    <p class="text-sm text-gray-600">
                        This manager has no employees to reassign.
                    </p>

                    <div class="mt-6">
                        <a href="{{ route('admin.managers.index') }}" class="text-gray-600">
                            ← Back to Managers
                        </a>
                    </div>
                @else

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 text-red-800 px-4 py-2 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">Employees affected</h3>
                        <ul class="list-disc pl-5 text-sm text-gray-700">
                            @foreach($employees as $e)
                                <li>{{ $e->name }} ({{ $e->email }})</li>
                            @endforeach
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('admin.managers.reassign.store', $manager) }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-1 font-medium">New Manager</label>
                            <select name="new_manager_id" class="border rounded w-full px-3 py-2" required>
                                @foreach($otherManagers as $m)
                                    <option value="{{ $m->id }}">
                                        {{ $m->name }} ({{ $m->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('new_manager_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm"
                                onclick="return confirm('Reassign ALL employees to the selected manager?');">
                            Reassign Employees
                        </button>

                        <a href="{{ route('admin.managers.index') }}" class="ml-3 text-gray-600 text-sm">
                            Cancel
                        </a>
                    </form>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
