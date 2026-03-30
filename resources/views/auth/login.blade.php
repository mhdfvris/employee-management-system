<x-guest-layout>
    <div class="grid gap-8 lg:grid-cols-2 lg:items-stretch">

        <!-- Left / Branding Panel -->
        <div class="rounded-3xl border border-blue-900 bg-gradient-to-br from-blue-950 via-indigo-950 to-gray-900 p-8 text-blue-100 shadow-xl shadow-blue-900/20 flex flex-col justify-between min-h-[620px]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-400">Welcome to TaskFlow</p>
                <h1 class="mt-6 text-4xl font-bold leading-tight text-white">
                    Manage tasks, teams, and progress in one place.
                </h1>
                <p class="mt-5 text-base leading-7 text-blue-300">
                    Sign in to access your workspace as an employee, manager, or administrator.
                </p>
            </div>

            <div class="space-y-4">
                <div class="rounded-2xl border border-blue-800 bg-blue-950/40 p-4">
                    <p class="font-semibold text-blue-100">Task Tracking</p>
                    <p class="mt-1 text-sm text-blue-300">Monitor progress, deadlines, and review status clearly.</p>
                </div>

                <div class="rounded-2xl border border-blue-800 bg-blue-950/40 p-4">
                    <p class="font-semibold text-blue-100">Team Management</p>
                    <p class="mt-1 text-sm text-blue-300">Managers and admins can organize teams efficiently.</p>
                </div>

                <div class="rounded-2xl border border-blue-800 bg-blue-950/40 p-4">
                    <p class="font-semibold text-blue-100">Notifications</p>
                    <p class="mt-1 text-sm text-blue-300">Stay updated on approvals, overdue tasks, and actions.</p>
                </div>
            </div>
        </div>

        <!-- Right / Login Form -->
        <div class="rounded-3xl border border-blue-900 bg-gray-900 p-8 shadow-xl shadow-blue-900/20 flex flex-col justify-center min-h-[620px]">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-blue-100">Welcome back</h2>
                <p class="mt-2 text-sm text-blue-300">Sign in to continue to your TaskFlow workspace.</p>
            </div>

            <x-auth-session-status class="mb-4 rounded-xl border border-emerald-800 bg-emerald-950/60 px-4 py-3 text-sm text-emerald-300" :status="session('status')" />
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            
            <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
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
                        autocomplete="username"
                        placeholder="Enter your email"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-5">
                    <x-input-label for="password" :value="__('Password')" />

                    <div class="relative mt-2">
                        <x-text-input
                            id="password"
                            class="pr-16"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />

                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-sm text-blue-300 hover:text-white"
                        >
                            <span x-text="showPassword ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-5 flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-blue-800 bg-blue-950 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-blue-300">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-300 underline hover:text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-5 rounded-2xl border border-blue-800 bg-blue-950/40 p-4">
                    <p class="text-sm text-blue-300">
                        Don’t have an account? Please contact your manager or system administrator.
                    </p>
                </div>

                <div class="mt-5">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

                    @error('g-recaptcha-response')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
