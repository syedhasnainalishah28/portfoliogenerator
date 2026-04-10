<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-seo-tags />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#1E0907] antialiased bg-[#f0f2f5] overflow-x-hidden w-full max-w-[100vw]">
        <div class="min-h-screen flex flex-col justify-center items-center p-4">
            <div class="w-full max-w-sm sm:max-w-md flex flex-col items-center">
                <a href="/" class="text-center block mb-6">
                    <p class="text-3xl font-extrabold text-[#111]">HA Tech</p>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[#f28b11]">The Gen Z Hustler</p>
                </a>

                <div class="ha-card w-full px-6 sm:px-8 py-6 sm:py-8 overflow-hidden rounded-2xl sm:rounded-[2rem] shadow-xl shadow-maroon/5 relative z-10 box-border">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
