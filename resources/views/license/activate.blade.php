<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate License — HA Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800;900&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0a0a10; } .font-syne { font-family: 'Syne', sans-serif; }</style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-3 mb-4">
            <img src="{{ asset('HA-Tech.png') }}" class="w-10 h-10 object-contain drop-shadow-[0_0_15px_rgba(242,139,17,0.4)]" alt="HA Tech">
            <span class="font-syne font-black text-white text-2xl">HA Tech</span>
        </div>
        <h1 class="font-syne font-black text-white text-2xl mb-2">Enter Your License Key</h1>
        <p class="text-white/40 text-sm">To access the dashboard, enter the license key you received after purchase.</p>
    </div>

    @if(session('warning'))
    <div class="mb-5 p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-sm">{{ session('warning') }}</div>
    @endif

    <div class="rounded-2xl p-8 border border-white/10" style="background: rgba(255,255,255,0.04);">
        <form method="POST" action="{{ route('license.activate') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-white/40 uppercase tracking-widest mb-2">License Key</label>
                <input type="text" name="license_key" placeholder="HATK-XXXX-XXXX-XXXX"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3.5 text-white placeholder-white/20 font-mono text-center text-lg tracking-widest focus:outline-none focus:border-amber-500/50 transition-colors uppercase"
                    oninput="this.value = this.value.toUpperCase()" required>
                @error('license_key')
                <p class="mt-2 text-red-400 text-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <button type="submit" class="w-full py-3.5 rounded-xl font-black text-black text-sm hover:opacity-90 transition-all" style="background: linear-gradient(135deg,#f28b11,#f2b311);">
                🔑 Activate License
            </button>
        </form>
    </div>

    <div class="text-center mt-6 space-y-2">
        <p class="text-white/30 text-sm">Don't have a license? <a href="{{ route('purchase.plans') }}" class="text-amber-400 hover:text-amber-300 font-semibold">Purchase one →</a></p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-white/20 text-xs hover:text-white/50 transition-colors">Sign out</button>
        </form>
    </div>
</div>
</body>
</html>
