<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @if(!app()->environment('testing'))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100">
        <div class="min-h-screen bg-gradient-to-b from-slate-900 via-slate-950 to-slate-950">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="border-b border-slate-800/80 bg-slate-900/70 backdrop-blur">
                    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        <div class="rounded-2xl border border-slate-800 bg-slate-900/80 px-6 py-5 shadow-lg shadow-black/20">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mt-6 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-300 shadow-lg shadow-black/10">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-6 rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm font-medium text-rose-300 shadow-lg shadow-black/10">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="pb-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>