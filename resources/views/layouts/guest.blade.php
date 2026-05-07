<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 antialiased bg-slate-950">
        <div class="min-h-screen relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.2),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(56,189,248,0.16),_transparent_30%)]"></div>

            <div class="relative min-h-screen flex flex-col items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
                <a href="/" class="mb-8 inline-flex items-center justify-center rounded-3xl border border-white/10 bg-white/5 px-4 py-3 text-white shadow-lg shadow-slate-950/40 backdrop-blur-sm transition hover:border-white/20 hover:bg-white/10">
                    <x-application-logo class="w-14 h-14 text-white" />
                    <span class="ml-3 text-sm font-semibold tracking-wide">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="w-full max-w-4xl mx-auto">
                    <div class="w-full bg-white/95 backdrop-blur-xl border border-white/10 shadow-2xl shadow-slate-950/30 rounded-[2rem] overflow-hidden">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
