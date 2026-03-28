<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @if(!app()->environment('testing'))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-900 via-gray-800 to-blue-950 text-blue-100">
        <div class="min-h-screen flex items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="w-full max-w-6xl">
                <div class="mb-8 flex justify-center">
                    <a href="/">
                        <x-application-logo class="h-20 w-20 fill-current text-slate-500" />
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
