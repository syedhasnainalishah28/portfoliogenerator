<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HA Tech Portfolio Generator') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f0f2f5] text-[#1e1b20] overflow-x-hidden w-full pb-20 lg:pb-0">
    
    <!-- Mobile Top Header -->
    <div class="lg:hidden bg-white border-b border-[#e5e7eb] sticky top-0 z-40 px-5 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('HA-Tech.png') }}" class="w-8 h-8 object-contain shrink-0 drop-shadow-[0_0_10px_rgba(242,139,17,0.3)]" alt="HA Tech">
            <p class="font-extrabold tracking-tight text-lg text-[#1e1b20]">HA Tech</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="w-8 h-8 bg-orange-50 border border-orange-200 rounded-full flex items-center justify-center text-[#f28b11] font-bold text-sm relative group animate-pulse-slow">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            <div class="absolute inset-0 rounded-full border border-[#f28b11] shadow-[0_0_12px_rgba(242,139,17,0.6)] group-hover:scale-110 transition-transform"></div>
        </a>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#e5e7eb] flex items-center justify-evenly pb-5 pt-2 px-2 z-50 shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 p-2 w-16 {{ request()->routeIs('dashboard') ? 'text-[#f28b11]' : 'text-[#9ca3af] hover:text-gray-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span class="text-[10px] font-bold">Home</span>
        </a>
        
        <!-- Generator / Create Center Button -->
        <a href="{{ route('generator') }}" class="flex flex-col items-center relative group w-16">
            <div class="absolute -top-7 w-14 h-14 rounded-full bg-gradient-to-r from-[#f28b11] to-[#f2b311] text-white flex items-center justify-center shadow-lg shadow-orange-500/40 border-[6px] border-[#f0f2f5] group-hover:-translate-y-1 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <span class="text-[10px] font-bold mt-8 {{ request()->routeIs('generator') ? 'text-[#f28b11]' : 'text-[#9ca3af]' }}">Build</span>
        </a>

        <!-- Portfolios -->
        <a href="{{ route('portfolios.index') }}" class="flex flex-col items-center gap-1 p-2 w-16 {{ request()->routeIs('portfolios.*') ? 'text-[#f28b11]' : 'text-[#9ca3af] hover:text-gray-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <span class="text-[10px] font-bold">Assets</span>
        </a>
    </div>

    <!-- Desktop Wrapper -->
    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex w-72 bg-white border-r border-[#e5e7eb] flex-col items-stretch flex-shrink-0 sticky top-0 h-screen">
            <div class="p-6 flex items-center gap-3">
                <img src="{{ asset('HA-Tech.png') }}" class="w-8 h-8 object-contain shrink-0 drop-shadow-[0_0_10px_rgba(242,139,17,0.3)]" alt="HA Tech">
                <div>
                    <p class="text-xl font-extrabold tracking-tight">HA Tech</p>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#f28b11]">VVIP Portal</p>
                </div>
            </div>
            
            <div class="px-6 pb-2 text-xs font-semibold text-[#9ca3af] uppercase tracking-wider">Main Workspace</div>
            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-orange-50 text-[#f28b11]' : 'text-[#5e5963] hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#f28b11]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('generator') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all {{ request()->routeIs('generator') ? 'bg-orange-50 text-[#f28b11]' : 'text-[#5e5963] hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('generator') ? 'text-[#f28b11]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Generator App
                </a>
                <a href="{{ route('portfolios.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all {{ request()->routeIs('portfolios.*') ? 'bg-orange-50 text-[#f28b11]' : 'text-[#5e5963] hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('portfolios.*') ? 'text-[#f28b11]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Your Portfolios
                </a>
                
                <div class="pt-6 pb-2 text-xs font-semibold text-[#9ca3af] uppercase tracking-wider">Account</div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all {{ request()->routeIs('profile.*') ? 'bg-orange-50 text-[#f28b11]' : 'text-[#5e5963] hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-[#f28b11]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile Settings
                </a>
            </nav>
            
            <div class="p-6 mt-auto">
                <div class="rounded-2xl border border-[#e5e7eb] bg-gray-50/50 p-4 text-center">
                    <div class="w-10 h-10 mx-auto rounded-full bg-white flex items-center justify-center text-[#f28b11] font-bold text-sm mb-3 border border-gray-200">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <p class="text-sm font-bold text-[#1e1b20] truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-[#9ca3af] truncate mb-4">{{ auth()->user()->email }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="ha-btn-secondary w-full py-2 text-xs border border-gray-200 hover:bg-white text-[#cf3434]">Sign Out</button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full lg:max-h-screen overflow-y-auto">
            @isset($header)
                <header class="bg-white border-b border-[#e5e7eb] sticky top-0 z-10 hidden lg:block">
                    <div class="px-6 py-5 sm:px-8">{{ $header }}</div>
                </header>
            @endisset
            <main class="flex-1">{{ $slot }}</main>
        </div>
    </div>
</body>
</html>
