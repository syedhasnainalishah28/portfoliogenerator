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
<body class="overflow-x-hidden w-full" style="background-color: #000000; font-family: sans-serif;">
    <!-- Main Application Container (Hidden on Mobile) -->
    <div id="app" class="hidden md:block w-full h-screen"></div>

    <!-- Mobile Warning Overlay -->
    <div class="md:hidden flex flex-col items-center justify-center text-center" style="background-color: #000000; color: white; min-height: 100vh; padding: 2rem;">
        <!-- SVG Laptop Icon -->
        <svg style="color: #FFDE00; width: 6rem; height: 6rem; margin-bottom: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #FFFFFF; line-height: 1.2;">Desktop Required</h1>
        
        <p style="color: #A0A0A0; font-size: 1.125rem; line-height: 1.6; margin-bottom: 3rem; max-width: 90%;">
            The HA Tech Portfolio Architect is a <br/><strong style="color: #FFDE00; font-weight: 600;">powerful workstation</strong>.<br><br>
            For a better experience and to design your portfolio efficiently, please use a laptop or desktop computer.
        </p>
        
        <a href="{{ route('dashboard') }}" style="background-color: #FFDE00; color: #000000; padding: 1rem 2.5rem; border-radius: 9999px; font-weight: 800; font-size: 1.125rem; text-decoration: none; box-shadow: 0 10px 25px -5px rgba(255, 222, 0, 0.4); display: inline-block;">
            Back to Dashboard
        </a>
    </div>
</body>
</html>
