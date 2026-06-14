<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>IRDCRP Admin Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 antialiased bg-slate-950">
        <div class="irdc-auth-page">
            <div class="irdc-auth-bg"></div>

            <div class="irdc-auth-wrap">
                <a href="/" class="irdc-auth-brand" aria-label="Return to IRDCRP website">
                    <x-application-logo class="irdc-auth-brand__logo" />
                    <span>IRDCRP Admin</span>
                </a>

                <div class="irdc-auth-frame">
                    <div class="w-full overflow-hidden rounded-[2rem] border border-white/10 bg-white/95 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
