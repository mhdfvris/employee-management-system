<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-200 tracking-tight">
            Edit Manager (Admin)
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 min-h-screen">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-blue-900 bg-gray-900 shadow-xl shadow-blue-900/20 p-10">
                <form method="POST" action="{{ route('admin.managers.update', $manager) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <label class="block text-base font-semibold text-blue-200 mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', $manager->name) }}"
                               class="w-full border border-blue-800 bg-blue-950 text-blue-100 rounded px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-10">
                        <label class="block text-base font-semibold text-blue-200 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $manager->email) }}"
                               class="w-full border border-blue-800 bg-blue-950 text-blue-100 rounded px-4 py-3 text-base focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center mt-8">
                        <a href="{{ route('admin.managers.index') }}" class="inline-flex items-center rounded-lg bg-blue-950 px-4 py-2 text-base font-medium text-blue-200 transition hover:bg-blue-900 hover:text-white">
                            Go back
                        </a>
                            <button type="submit" class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
