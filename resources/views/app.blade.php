<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="HA Tech The Gen Z Hustler - Professional portfolio generator for students.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HA Tech Portfolio Generator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden w-full bg-[#121212]">
    <!-- Main Application Container (Hidden on Mobile) -->
    <div id="app" class="hidden md:block w-full h-screen"></div>

    <!-- Mobile Warning Overlay -->
    <div class="md:hidden flex flex-col items-center justify-center min-h-[100dvh] bg-[#121212] text-white p-6 text-center">
        <!-- SVG Laptop Icon -->
        <svg class="w-24 h-24 mb-6 text-[#922ff5]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        <h1 class="text-3xl font-extrabold mb-4 tracking-tight">Desktop Required</h1>
        <p class="text-gray-400 text-lg leading-relaxed mb-8">
            The HA Tech Portfolio Architect is a powerful workstation.<br><br>
            For a better experience and to design your portfolio efficiently, please use a laptop or desktop computer.
        </p>
        <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-[#922ff5] hover:bg-[#7b1dd6] text-white rounded-full font-bold shadow-lg shadow-[#922ff5]/30 transition-all active:scale-95">
            Back to Dashboard
        </a>
    </div>
</body>
</html>
