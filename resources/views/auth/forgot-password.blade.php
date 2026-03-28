<x-guest-layout>
    <div class="mx-auto max-w-xl rounded-3xl border border-blue-900 bg-gray-900 p-8 shadow-xl shadow-blue-900/20">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-400">Password Reset</p>
            <h2 class="mt-2 text-2xl font-bold text-blue-100">Reset your password</h2>
            <p class="mt-2 text-sm text-blue-300">
                Enter your email address and we’ll send you a password reset link.
            </p>
        </div>

        <x-auth-session-status class="mb-4 rounded-xl border border-emerald-800 bg-emerald-950/60 px-4 py-3 text-sm text-emerald-300" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    class="mt-2"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    placeholder="Enter your email"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('login') }}"
                   class="text-sm text-blue-300 underline hover:text-white">
                    Back to login
                </a>

                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
