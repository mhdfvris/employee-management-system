<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Managers (Admin)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                

                <div class="mb-4 flex justify-end">
                    <a href="{{ route('admin.managers.create') }}" class="bg-blue-600 text-white px-4 py-2 text-sm rounded">
                        + New Manager
                    </a>
                </div>

                @if($managers->isEmpty())
                    <p>No managers found.</p>
                @else
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Name</th>
                                <th class="py-2">Email</th>
                                <th class="py-2 text-center">Employees</th>
                                <th class="py-2 text-center">Tasks</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($managers as $manager)
                                <tr class="border-b">
                                    <td class="py-2">{{ $manager->name }}</td>
                                    <td class="py-2">{{ $manager->email }}</td>
                                    <td class="py-2 text-center">
                                        {{ $manager->employees_count }}
                                    </td>
                                    <td class="py-2 text-center">{{ $manager->managed_tasks_count }}</td>

                                    <td class="py-2 flex gap-3">
                                        <a href="{{ route('admin.managers.edit', $manager) }}" class="text-blue-600 text-sm">
                                            Edit
                                        </a>
                                        
                                        <a href="{{ route('admin.managers.reassign', $manager) }}" class="text-indigo-600 text-sm">
                                            Reassign
                                        </a>

                                        <form method="POST" action="{{ route('admin.managers.destroy', $manager) }}"
                                            onsubmit="return confirm('Delete this manager?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 text-sm">
                                                Delete
                                            </button>
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
</x-app-layout>
