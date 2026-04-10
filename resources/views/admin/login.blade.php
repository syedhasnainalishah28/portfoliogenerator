<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo-tags />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800;900&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #050505; }
        .font-syne { font-family: 'Syne', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    
    <!-- Background Effects -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-amber-500/10 to-amber-600/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="w-full max-w-[420px] relative z-10">
        <!-- Logo -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-4 mb-5">
                <img src="{{ asset('HA-Tech.png') }}" class="w-12 h-12 object-contain drop-shadow-[0_0_15px_rgba(242,139,17,0.4)]" alt="HA Tech">
                <span class="font-syne font-black text-white text-3xl tracking-wide">HA Tech</span>
            </div>
            <p class="text-amber-400/60 text-xs font-bold uppercase tracking-[0.2em]">Secure Admin Console</p>
        </div>

        <!-- Card -->
        <div class="rounded-[2rem] p-10 border border-white/10 shadow-2xl relative overflow-hidden" style="background: rgba(10,10,10,0.8); backdrop-filter: blur(20px);">
            <div class="absolute inset-0 bg-gradient-to-br from-white/[0.02] to-transparent pointer-events-none"></div>
            
            <h1 class="font-syne font-black text-white text-2xl mb-8">Sign In</h1>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6 relative z-10">
                @csrf
                <div>
                    <label class="block text-[11px] font-black text-white/40 uppercase tracking-widest mb-2.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-4 text-white placeholder-white/20 focus:outline-none focus:border-amber-500/50 focus:bg-black transition-all text-sm shadow-inner"
                        placeholder="admin@hatech.io">
                </div>
                <div>
                    <div class="flex items-center justify-between pointer-events-none">
                        <label class="block text-[11px] font-black text-white/40 uppercase tracking-widest mb-2.5">Master Password</label>
                    </div>
                    <input type="password" name="password" required autocomplete="current-password"
                        class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-4 text-white placeholder-white/20 focus:outline-none focus:border-amber-500/50 focus:bg-black transition-all text-sm shadow-inner"
                        placeholder="••••••••••••">
                </div>
                <button type="submit" class="w-full mt-2 py-4 rounded-xl font-black text-black text-sm transition-all hover:scale-[1.02] shadow-[0_4px_20px_-5px_rgba(242,139,17,0.4)]" style="background: linear-gradient(135deg,#f28b11,#f2b311);">
                    Authenticate & Access
                </button>
            </form>
        </div>
        
        <div class="text-center mt-8">
            <p class="text-white/20 text-[10px] uppercase tracking-widest font-bold">Encrypted Connection • Unauthorized access is logged</p>
        </div>
    </div>

</body>
</html>
