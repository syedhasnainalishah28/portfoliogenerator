@extends('admin.layout')
@section('title', 'System License Generation')
@section('page-title')
<div class="flex items-center gap-6">
    <a href="{{ route('admin.licenses.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 text-white/40 hover:text-white hover:bg-white/10 transition-colors">
        <i class="fas fa-arrow-left"></i>
    </a>
    <span class="font-syne font-bold text-white text-3xl tracking-tight">Manual Key Forge</span>
</div>
@endsection

@section('content')
<div class="max-w-3xl animate-in fade-in slide-in-from-bottom-6 duration-700">
    
    <div class="bg-brand-panel border border-white/5 rounded-[40px] p-10 md:p-14 relative overflow-hidden backdrop-blur-xl shadow-2xl">
        
        <div class="flex items-center gap-6 mb-10">
            <div class="w-16 h-16 rounded-2xl bg-brand-gold/10 flex items-center justify-center text-brand-gold text-2xl shadow-[0_0_30px_rgba(212,168,83,0.15)] ring-1 ring-brand-gold/20">
                <i class="fas fa-microchip"></i>
            </div>
            <div>
                <h2 class="font-syne font-bold text-white text-2xl tracking-tight">Protocol Signature Bypass</h2>
                <p class="text-[10px] text-brand-gold font-bold uppercase tracking-[0.2em] mt-1">Generate unassigned cryptographic seeds</p>
            </div>
        </div>
        
        <div class="pl-[5.5rem] mb-12">
            <p class="text-white/40 text-sm leading-relaxed font-semibold italic border-l-2 border-brand-gold/30 pl-6">
                "Authorize the generation of stand-alone keys for offline distribution. These signatures remain dormant until manually bonded by a verified user uplink."
            </p>
        </div>

        <form method="POST" action="{{ route('admin.licenses.store') }}" class="space-y-10 pl-[5.5rem]">
            @csrf
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-white/40 mb-3">Deployment Tier Level</label>
                <div class="relative">
                    <i class="fas fa-cubes-stacked absolute left-6 top-1/2 -translate-y-1/2 text-white/20"></i>
                    <select name="plan_id" required class="w-full bg-white/5 border border-white/10 rounded-2xl pl-16 pr-6 py-4 text-sm font-semibold text-white focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all appearance-none cursor-pointer hover:bg-white/10 shadow-inner">
                        <option value="" class="bg-brand-surface">-- Select Target Infrastructure Tier --</option>
                        @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" class="bg-brand-surface">{{ strtoupper($plan->name) }} ({{ $plan->duration_months }} Months • ${{ $plan->price_usd }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-white/40">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                @error('plan_id')<p class="mt-3 text-red-500 font-bold text-[10px] uppercase tracking-widest">{{ $message }}</p>@enderror
            </div>

            <div class="p-8 rounded-3xl border border-brand-gold/10 bg-brand-gold/5 space-y-6">
                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-brand-gold/80 mb-2 border-b border-brand-gold/10 pb-4">
                    <i class="fas fa-shield-halved"></i>
                    Security Protocol Rules
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <p class="flex items-center gap-3 text-[11px] font-bold text-white/50 uppercase tracking-wider">
                        <i class="fas fa-check-circle text-emerald-500/50"></i> RSA-4096 16-Char Seed
                    </p>
                    <p class="flex items-center gap-3 text-[11px] font-bold text-white/50 uppercase tracking-wider">
                        <i class="fas fa-check-circle text-emerald-500/50"></i> Zero-Bind Latency
                    </p>
                    <p class="flex items-center gap-3 text-[11px] font-bold text-white/50 uppercase tracking-wider">
                        <i class="fas fa-check-circle text-emerald-500/50"></i> Static Claim Ready
                    </p>
                    <p class="flex items-center gap-3 text-[11px] font-bold text-white/50 uppercase tracking-wider">
                        <i class="fas fa-check-circle text-emerald-500/50"></i> SSL Encrypted Dispatch
                    </p>
                </div>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-4 py-5 rounded-2xl bg-brand-gold text-black font-bold uppercase tracking-widest text-sm hover:brightness-110 shadow-[0_0_30px_rgba(212,168,83,0.15)] hover:shadow-[0_0_40px_rgba(212,168,83,0.3)] transition-all">
                <span>Authorize Key Forge</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>
@endsection
