@extends('admin.layout')
@section('title', 'System Settings')
@section('page-title', 'Global Configurations')

@section('content')
<div class="grid xl:grid-cols-2 gap-12">

    {{-- Plan Prices --}}
    <div class="space-y-8 relative">
        <div class="absolute -left-20 top-20 w-64 h-64 bg-emerald-500/10 blur-[80px] rounded-full pointer-events-none"></div>

        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                <i class="fas fa-cubes-stacked text-lg"></i>
            </div>
            <div>
                <h2 class="font-syne font-black text-white text-2xl tracking-tight">Subscription Tiers</h2>
                <p class="text-[11px] text-white/30 font-bold uppercase tracking-widest mt-0.5">Manage live USD values & cycles</p>
            </div>
        </div>

        <div class="space-y-6 relative z-10">
            @foreach($plans as $plan)
            <div class="glass-panel p-8 group transition-all hover:bg-white/[0.04]">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div class="font-syne font-black text-white text-xl">{{ $plan->name }}</div>
                        <div class="text-[10px] text-[#D4A853] font-black uppercase tracking-[0.2em] mt-1.5 flex items-center gap-2">
                             <i class="fas fa-sync-alt animate-spin-slow"></i>
                             {{ $plan->duration_months }} Month Cycle
                        </div>
                    </div>
                    <div class="text-4xl font-black text-white/40 group-hover:text-white transition-colors tracking-tighter">
                        <span class="text-sm align-top mr-1 font-bold text-white/20">$</span>{{ $plan->price_usd }}
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="flex relative z-10 bg-black/40 p-1.5 border border-white/10 rounded-2xl focus-within:border-[#D4A853]/40 transition-all">
                    @csrf @method('PATCH')
                    <div class="flex items-center px-4 border-r border-white/5 text-white/20 text-xs font-black">USD</div>
                    <input type="number" name="price_usd" value="{{ $plan->price_usd }}" step="0.01" min="0" required
                        class="flex-1 bg-transparent border-none px-5 py-3 text-white text-sm font-black focus:outline-none appearance-none">
                    <button type="submit" class="ha-btn-gold !py-2.5 !px-6 !text-[9px]">Apply Changes</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Payment Methods --}}
    <div class="space-y-8 relative">
        <div class="absolute -right-20 bottom-20 w-64 h-64 bg-amber-500/10 blur-[80px] rounded-full pointer-events-none"></div>
        
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-[#D4A853] shadow-[0_0_15px_rgba(212,168,83,0.2)]">
                <i class="fas fa-wallet text-lg"></i>
            </div>
            <div>
                <h2 class="font-syne font-black text-white text-2xl tracking-tight">Gateway Nodes</h2>
                <p class="text-[11px] text-white/30 font-bold uppercase tracking-widest mt-0.5">Active Fiat Payment Endpoints</p>
            </div>
        </div>

        {{-- Add New --}}
        <div class="rounded-[32px] p-8 border-2 border-[#D4A853]/20 relative overflow-hidden mb-10 bg-gradient-to-br from-[#D4A853]/[0.05] to-transparent shadow-2xl">
            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4A853] mb-8 flex items-center gap-3">
                <i class="fas fa-plus-circle text-xs"></i>
                Deploy New Endpoint
            </h3>
            <form method="POST" action="{{ route('admin.payment-methods.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="ha-label">Provider Name</label>
                        <input type="text" name="name" placeholder="JazzCash / IBAN" required class="ha-input bg-black/40">
                    </div>
                    <div class="space-y-2">
                        <label class="ha-label">Account Title</label>
                        <input type="text" name="account_title" placeholder="John Doe" required class="ha-input bg-black/40">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="ha-label">Registry Number / IBAN</label>
                    <input type="text" name="account_number" placeholder="0000 0000 0000 00" required class="ha-input bg-black/40 font-mono tracking-widest text-xs">
                </div>
                <div class="space-y-2">
                    <label class="ha-label">Deployment Instructions</label>
                    <textarea name="instructions" placeholder="Enter transfer instructions for users..." rows="2" class="ha-input bg-black/40 resize-none text-xs"></textarea>
                </div>
                <button type="submit" class="ha-btn-gold w-full flex items-center justify-center gap-3">
                    <i class="fas fa-shield-alt text-[10px]"></i>
                    Initialize Gateway
                </button>
            </form>
        </div>

        {{-- Existing Methods --}}
        <div class="space-y-5 relative z-10">
            @foreach($paymentMethods as $method)
            <div class="glass-panel p-8 {{ !$method->is_active ? 'border-red-500/10 opacity-70' : '' }} transition-all hover:bg-white/[0.03]">
                
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="font-syne font-black text-white text-lg tracking-tight">{{ $method->name }}</span>
                            <span class="badge {{ $method->is_active ? 'badge-active' : 'badge-rejected' }}">
                                {{ $method->is_active ? 'Active' : 'Halted' }}
                            </span>
                        </div>
                        <div class="text-[11px] font-bold text-white/30 uppercase tracking-widest mb-1">{{ $method->account_title }}</div>
                        <div class="text-xs font-mono text-[#D4A853] font-black tracking-[0.2em]">{{ $method->account_number }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/10">
                        <i class="fas fa-university"></i>
                    </div>
                </div>

                <div class="flex gap-3">
                    <form method="POST" action="{{ route('admin.payment-methods.update', $method) }}" class="flex-1">
                        @csrf @method('PATCH')
                        <input type="hidden" name="name" value="{{ $method->name }}">
                        <input type="hidden" name="account_title" value="{{ $method->account_title }}">
                        <input type="hidden" name="account_number" value="{{ $method->account_number }}">
                        <input type="hidden" name="instructions" value="{{ $method->instructions }}">
                        <input type="hidden" name="is_active" value="{{ $method->is_active ? '0' : '1' }}">
                        
                        <button type="submit" class="w-full text-[9px] font-black uppercase tracking-[0.2em] py-3 rounded-xl border {{ $method->is_active ? 'border-white/10 text-white/30 hover:text-white' : 'bg-emerald-500/10 border-emerald-500/20 text-emerald-500 hover:bg-emerald-500/20' }} transition-all">
                            {{ $method->is_active ? 'Cease Operations' : 'Restore Signal' }}
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('admin.payment-methods.destroy', $method) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-11 h-11 flex items-center justify-center rounded-xl bg-red-500/5 border border-red-500/10 text-red-500/40 hover:text-red-500 transition-all" onclick="return confirm('Drop gateway endpoint permanently?')">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- SMTP Tester --}}
    <div class="xl:col-span-2 pt-12">
        <div class="glass-panel p-10 bg-gradient-to-r from-[#D4A853]/[0.03] to-transparent">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-[#D4A853]/10 flex items-center justify-center text-[#D4A853] text-xl shadow-[0_0_20px_rgba(212,168,83,0.2)]">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <div>
                        <h2 class="font-syne font-black text-white text-2xl tracking-tight">SMTP Signal Diagnostics</h2>
                        <p class="text-[11px] text-white/30 font-bold uppercase tracking-widest mt-1">Verify global communication status</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.settings.test-email') }}" class="flex flex-col sm:flex-row gap-3 flex-1 max-w-lg">
                    @csrf
                    <input type="email" name="email" placeholder="Test recipient address..." required class="ha-input !py-3.5 flex-1">
                    <button type="submit" class="ha-btn-gold !py-3.5 !px-8 flex items-center gap-3">
                        <i class="fas fa-location-arrow text-[10px]"></i>
                        Dispatch
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
