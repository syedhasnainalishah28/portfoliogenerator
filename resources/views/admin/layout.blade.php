<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — HA Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts - Synced with Home Page -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Syne:wght@400;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons Pack -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body { font-family: 'Inter', sans-serif; background: #050508; color: #fff; overflow-x: hidden; }
        .font-syne { font-family: 'Syne', sans-serif; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #222; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
        
        /* Sidebar Styling */
        .sidebar { 
            background: #090910; 
            border-right: 1px solid rgba(255,255,255,0.05); 
            box-shadow: 10px 0 30px rgba(0,0,0,0.5);
            z-index: 50;
        }
        .sidebar-link { 
            @apply flex items-center gap-4 px-6 py-4 rounded-2xl text-white/40 hover:text-white hover:bg-white/[0.03] transition-all text-[13px] font-bold tracking-wide; 
        }
        .sidebar-link i { @apply text-base w-5 text-center; }
        .sidebar-link.active { 
            background: linear-gradient(90deg, rgba(212,168,83,0.1) 0%, transparent 100%); 
            color: #D4A853;
            border-right: 3px solid #D4A853;
            border-radius: 16px 0 0 16px;
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
        }
        
        .ha-input { 
            @apply w-full bg-white/[0.02] border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-white/20 focus:outline-none focus:border-[#D4A853]/50 focus:bg-white/[0.05] transition-all text-sm backdrop-blur-md; 
        }
        .ha-label { @apply block text-[10px] font-black uppercase tracking-[0.2em] text-white/30 mb-2.5 ml-1; }
        
        .ha-btn-gold { 
            @apply px-8 py-4 rounded-2xl text-[#050508] text-xs font-black uppercase tracking-[0.15em] transition-all shadow-[0_10px_20px_-5px_rgba(212,168,83,0.3)]; 
            background: linear-gradient(135deg, #A67C3A, #D4A853); 
        }
        .ha-btn-gold:hover { transform: translateY(-2px); shadow-[0_15px_30px_-5px_rgba(212,168,83,0.5)]; filter: brightness(1.1); }
        
        .ha-btn-outline { 
            @apply px-7 py-4 rounded-2xl border border-white/10 text-white/70 text-xs font-bold uppercase tracking-widest hover:bg-white/5 hover:border-white/20 transition-all; 
        }

        .table-container { 
            @apply glass-panel overflow-hidden;
        }
        .table-th { @apply px-8 py-5 text-left text-[10px] font-black text-white/30 uppercase tracking-[0.2em] bg-white/[0.01] border-b border-white/5; }
        .table-td { @apply px-8 py-5 text-sm text-white/70 border-b border-white/[0.02]; }
        .table-row:last-child .table-td { border-bottom: none; }
        .table-row:hover { background: rgba(255,255,255,0.01); }

        .top-bar { 
            background: rgba(9, 9, 16, 0.8); 
            backdrop-filter: blur(20px); 
            border-bottom: 1px solid rgba(255,255,255,0.05); 
            z-index: 40;
        }

        .badge { @apply px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border; }
        .badge-pending  { @apply bg-yellow-500/10 text-yellow-500 border-yellow-500/20; }
        .badge-approved { @apply bg-emerald-500/10 text-emerald-500 border-emerald-500/20; }
        .badge-rejected { @apply bg-red-500/10 text-red-500 border-red-500/20; }
        .badge-active   { @apply bg-emerald-500/10 text-emerald-500 border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.1)]; }
        .badge-expired  { @apply bg-red-500/10 text-red-500 border-red-500/20; }
        .badge-unused   { @apply bg-white/5 text-white/40 border-white/10; }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="sidebar w-[300px] fixed h-screen flex flex-col pt-10">
        <!-- Brand -->
        <div class="px-10 mb-12">
            <div class="flex items-center gap-4">
                <img src="{{ asset('HA-Tech.png') }}" class="w-12 h-12 object-contain drop-shadow-[0_0_20px_rgba(212,168,83,0.4)]" alt="HA Tech">
                <div>
                    <h1 class="font-syne font-black text-white text-xl tracking-tight leading-none">HA TECH</h1>
                    <p class="text-[9px] uppercase tracking-[0.3em] text-[#D4A853] mt-1 font-bold">Admin OS v2.0</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i>
                <span>Active Agents</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Operations</span>
                @php $pending = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pending > 0)
                <span class="ml-auto bg-[#D4A853] text-[#050508] text-[9px] font-black px-2 py-0.5 rounded-full">{{ $pending }}</span>
                @endif
            </a>
            <a href="{{ route('admin.licenses.index') }}" class="sidebar-link {{ request()->routeIs('admin.licenses.*') ? 'active' : '' }}">
                <i class="fas fa-key"></i>
                <span>Access Vault</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Config Node</span>
            </a>
        </nav>

        <!-- Admin Card -->
        <div class="p-6 mt-auto border-t border-white/5 bg-white/[0.01]">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#A67C3A] to-[#D4A853] flex items-center justify-center text-[#050508] font-black text-lg">
                    {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-black text-white truncate">{{ auth('admin')->user()->name }}</p>
                    <p class="text-[10px] text-white/30 uppercase tracking-[0.2em] mt-0.5">Primary Root</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full py-4 rounded-2xl border border-red-500/10 text-red-500/60 hover:text-red-500 hover:bg-red-500/5 transition-all text-[10px] font-black uppercase tracking-[0.2em]">
                    Terminate Session
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 ml-[300px] min-h-screen relative">
        <!-- Glows -->
        <div class="fixed top-0 right-0 w-[800px] h-[600px] bg-[#D4A853]/[0.03] blur-[150px] -z-10 pointer-events-none"></div>

        <!-- Top Header -->
        <header class="top-bar sticky top-0 px-12 py-8 flex items-center justify-between">
            <h2 class="font-syne font-black text-white text-3xl tracking-tight">@yield('page-title', 'System Overview')</h2>
            
            <div class="flex items-center gap-6">
                <div class="hidden lg:flex flex-col items-end">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#D4A853]">System Status</p>
                    <p class="text-xs text-white/40 font-bold">Online & Synchronized</p>
                </div>
                <div class="h-10 w-px bg-white/10"></div>
                <div class="bg-white/5 border border-white/10 px-5 py-2.5 rounded-2xl text-[11px] font-black text-white/60">
                    {{ now()->format('D, d M — H:i') }}
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="p-12">
            @if(session('success'))
                <div class="mb-10 p-5 rounded-3xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                        <i class="fas fa-check"></i>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-10 p-5 rounded-3xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center shrink-0">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
