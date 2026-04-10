@extends('admin.layout')
@section('title', 'System License Generation')
@section('page-title')
<div class="flex items-center gap-6">
    <a href="{{ route('admin.licenses.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/5 border border-white/5 text-white/40 hover:text-[#D4A853] hover:bg-[#D4A853]/5 hover:border-[#D4A853]/20 transition-all">
        <i class="fas fa-arrow-left"></i>
    </a>
    Manual Key Forge
</div>
@endsection

@section('content')
<div class="max-w-3xl relative animate-in fade-in slide-in-from-bottom-6 duration-700">
    
    <!-- Background Sparkle -->
    <div class="absolute -top-20 -right-20 w-[400px] h-[400px] bg-[#D4A853]/[0.05] blur-[100px] rounded-full pointer-events-none"></div>

    <div class="glass-panel p-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-white/[0.02] to-transparent pointer-events-none"></div>
        
        <div class="relative z-10 flex items-center gap-4 mb-3">
            <div class="w-10 h-10 rounded-xl bg-[#D4A853]/10 flex items-center justify-center text-[#D4A853] text-sm shadow-[0_0_15px_rgba(212,168,83,0.2)]">
                <i class="fas fa-bolt"></i>
            </div>
            <h2 class="font-syne font-black text-white text-2xl tracking-tight">Master Protocol Bypass</h2>
        </div>
        <p class="text-white/30 text-sm mb-10 leading-relaxed font-bold tracking-wide relative z-10 pl-14">
            Generate unassigned cryptographic keys for manual distribution. These keys do not initiate their lifecycle until bonded by an active agent.
        </p>

        <form method="POST" action="{{ route('admin.licenses.store') }}" class="space-y-10 relative z-10">
            @csrf
            <div>
                <label class="ha-label">Deployment Framework Tier</label>
                <div class="relative group">
                    <i class="fas fa-layer-group absolute left-6 top-1/2 -translate-y-1/2 text-white/20 group-hover:text-[#D4A853] transition-colors"></i>
                    <select name="plan_id" required
                        class="ha-input !pl-14 appearance-none cursor-pointer font-bold transition-all hover:bg-white/[0.06]">
                        <option value="" class="bg-[#090910]">-- Select Target Tier --</option>
                        @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" class="bg-[#090910]">{{ $plan->name }} ({{ $plan->duration_months }} Cycle • ${{ $plan->price_usd }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-[#D4A853]">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                @error('plan_id')<p class="mt-2 text-red-500 font-bold text-xs uppercase tracking-widest pl-1">{{ $message }}</p>@enderror
            </div>

            <div class="p-8 rounded-[32px] border border-[#D4A853]/10 bg-[#D4A853]/[0.02] space-y-4">
                <div class="flex items-center gap-4 text-xs font-black uppercase tracking-[0.2em] text-[#D4A853]/60 mb-2">
                    <i class="fas fa-shield-alt"></i>
                    Protocol Rules
                </div>
                <p class="flex items-center gap-3 text-[11px] font-bold text-white/30 uppercase tracking-widest">
                    <i class="fas fa-check-circle text-emerald-500/50 text-[10px]"></i>
                    Auto-generated 16-character cryptographic seed.
                </p>
                <p class="flex items-center gap-3 text-[11px] font-bold text-white/30 uppercase tracking-widest">
                    <i class="fas fa-check-circle text-emerald-500/50 text-[10px]"></i>
                    Stays globally unassigned until manually claimed.
                </p>
                <p class="flex items-center gap-3 text-[11px] font-bold text-white/30 uppercase tracking-widest">
                    <i class="fas fa-check-circle text-emerald-500/50 text-[10px]"></i>
                    Activation date binds only upon first user claim.
                </p>
            </div>

            <button type="submit" class="ha-btn-gold w-full flex items-center justify-center gap-4">
                <span>Authorize Forge Registry</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>
@endsection
