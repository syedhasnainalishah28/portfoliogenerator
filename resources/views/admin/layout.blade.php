<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — HA Tech</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        syne: ['Syne', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            gold: '#D4A853',
                            dark: '#0D0D14',    // Less aggressively black background
                            surface: '#15151E', // Brighter Sidebar
                            panel: 'rgba(255, 255, 255, 0.04)', // Much more visible panel background
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-brand-dark text-white font-sans antialiased min-h-screen flex selection:bg-brand-gold selection:text-black">

    <!-- Sidebar Wrapper -->
    <aside class="w-72 bg-brand-surface border-r border-white/5 flex flex-col fixed h-screen z-50">
        <!-- Brand -->
        <div class="p-8 flex items-center gap-4 border-b border-white/5">
            <img src="{{ asset('HA-Tech.png') }}" class="w-10 h-10 object-contain drop-shadow-[0_0_10px_rgba(212,168,83,0.4)]" alt="HA Tech">
            <div>
                <h1 class="font-syne font-bold text-white text-lg tracking-tight leading-none uppercase">HA Tech</h1>
                <p class="text-[8px] uppercase tracking-widest text-brand-gold mt-1 font-bold">Admin OS v2</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <div class="text-[10px] font-bold uppercase tracking-widest text-white/20 mb-4 px-4">Core Systems</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-brand-gold/10 text-brand-gold' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-chart-pie w-5 text-center"></i>
                <span class="tracking-wide">Overview</span>
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold {{ request()->routeIs('admin.users.*') ? 'bg-brand-gold/10 text-brand-gold' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="tracking-wide">Active Agents</span>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold {{ request()->routeIs('admin.orders.*') ? 'bg-brand-gold/10 text-brand-gold' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-file-invoice-dollar w-5 text-center"></i>
                <span class="tracking-wide">Operations</span>
            </a>
            
            <a href="{{ route('admin.licenses.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold {{ request()->routeIs('admin.licenses.*') ? 'bg-brand-gold/10 text-brand-gold' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-key w-5 text-center"></i>
                <span class="tracking-wide">Vault Access</span>
            </a>
            
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold {{ request()->routeIs('admin.settings') ? 'bg-brand-gold/10 text-brand-gold' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-sliders-h w-5 text-center"></i>
                <span class="tracking-wide">Config Node</span>
            </a>
        </nav>

        <!-- Admin Profile / Logout -->
        <div class="p-6 border-t border-white/5 bg-white/[0.01]">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#A67C3A] to-[#D4A853] flex items-center justify-center text-black font-bold text-sm">
                    {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">{{ auth('admin')->user()->name }}</p>
                    <p class="text-[9px] text-white/30 uppercase tracking-widest mt-0.5">Primary Root</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 rounded-xl border border-red-500/20 text-red-500 text-xs font-bold uppercase tracking-widest hover:bg-red-500/10 transition-colors">
                    Terminate
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 ml-72 relative min-h-screen">
        <!-- Global Glow Effect -->
        <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-brand-gold opacity-5 blur-[120px] pointer-events-none rounded-full"></div>

        <div class="p-10 lg:p-14 relative z-10 w-full max-w-7xl mx-auto">
            <!-- Header -->
            <header class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="font-syne font-bold text-white text-3xl tracking-tight">@yield('page-title', 'Overview')</h2>
                </div>
                <div class="hidden sm:block">
                    <div class="bg-brand-panel border border-white/5 px-6 py-2.5 rounded-xl text-xs font-semibold text-white/50 tracking-wider backdrop-blur-md">
                        <i class="far fa-clock mr-2 text-brand-gold/50"></i>
                        {{ now()->format('D, d M Y — H:i') }}
                    </div>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-8 p-4 rounded-xl bg-brand-gold/10 border border-brand-gold/20 flex items-center gap-4 text-brand-gold text-sm font-semibold shadow-lg shadow-brand-gold/5 animate-in fade-in slide-in-from-top-4 duration-300">
                    <i class="fas fa-check-circle text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 p-4 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center gap-4 text-red-500 text-sm font-semibold animate-in fade-in slide-in-from-top-4 duration-300">
                    <i class="fas fa-exclamation-triangle text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>
</body>
</html>
