@extends('admin.layout')
@section('title', 'Config Node')
@section('page-title', 'System Settings')

@section('content')
<div class="space-y-12 pb-20">

    <!-- Email Diagnostics -->
    <div class="bg-brand-panel border border-white/5 rounded-3xl overflow-hidden backdrop-blur-xl">
        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.01]">
            <h3 class="font-syne font-bold text-white text-xl">SMTP Diagnostics</h3>
            <p class="text-[10px] font-bold uppercase tracking-widest text-white/40 mt-1">Test network transmission capabilities</p>
        </div>
        <form method="POST" action="{{ route('admin.settings.test-email') }}" class="p-8 flex flex-col sm:flex-row gap-6 items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-white/50 mb-3">Target Inbox</label>
                <input type="email" name="email" value="{{ auth('admin')->user()->email }}" required class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-sm font-semibold text-white focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all">
            </div>
            <button type="submit" class="px-8 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white/60 text-xs font-bold uppercase tracking-widest hover:text-brand-gold hover:border-brand-gold/30 hover:bg-brand-gold/10 transition-all whitespace-nowrap">
                <i class="fas fa-paper-plane mr-2"></i> Send Test Packet
            </button>
        </form>
    </div>

    <!-- Access Tiers (Plans) -->
    <div class="bg-brand-panel border border-white/5 rounded-3xl overflow-hidden backdrop-blur-xl">
        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.01]">
            <h3 class="font-syne font-bold text-white text-xl">Access Tiers Configuration</h3>
            <p class="text-[10px] font-bold uppercase tracking-widest text-white/40 mt-1">Manage protocol lifecycles and capital requirements</p>
        </div>
        <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($plans as $plan)
                <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="p-6 rounded-2xl bg-white/[0.02] border border-white/5 hover:bg-white/[0.04] transition-colors">
                    @csrf
                    @method('PATCH')
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-white/5">
                        <div class="w-12 h-12 rounded-xl bg-brand-gold/10 flex items-center justify-center text-brand-gold text-lg">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-lg">{{ $plan->name }}</h4>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">{{ $plan->duration_months }} Months Lifecycle</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-white/50 mb-3">Capital Value (USD)</label>
                        <div class="flex items-center gap-4">
                            <div class="relative flex-1">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-white/30 font-bold">$</span>
                                <input type="number" step="0.01" name="price_usd" value="{{ $plan->price_usd }}" required class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-9 pr-4 text-sm font-semibold text-white focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all font-mono">
                            </div>
                            <button type="submit" class="px-6 py-3.5 rounded-xl bg-brand-gold/10 border border-brand-gold/20 text-brand-gold text-xs font-bold uppercase tracking-widest hover:brightness-110 hover:bg-brand-gold/20 transition-all">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div>

    <!-- Payment Gateways -->
    <div class="bg-brand-panel border border-white/5 rounded-3xl overflow-hidden backdrop-blur-xl">
        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.01] flex items-center justify-between">
            <div>
                <h3 class="font-syne font-bold text-white text-xl">Financial Nodes</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/40 mt-1">Manual transaction routing configurations</p>
            </div>
        </div>

        <div class="p-8 space-y-8">
            <!-- Add New Method -->
            <form method="POST" action="{{ route('admin.payment-methods.store') }}" class="p-6 rounded-2xl bg-white/[0.01] border border-dashed border-white/20">
                @csrf
                <div class="mb-4 flex items-center gap-3 text-brand-gold">
                    <i class="fas fa-plus-circle"></i>
                    <h4 class="font-bold text-sm uppercase tracking-widest">Register New Node</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-white/40 mb-2">Node Alias (Bank Name)</label>
                        <input type="text" name="name" required placeholder="Crypto / Wire Transfer" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-white/40 mb-2">Account Identity</label>
                        <input type="text" name="account_title" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-white/40 mb-2">Routing Number / Address</label>
                        <input type="text" name="account_number" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-xs text-white  focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all">
                    </div>
                </div>
                <div>
                     <label class="block text-[10px] font-bold uppercase tracking-widest text-white/40 mb-2">Operational Instructions (Optional)</label>
                     <input type="text" name="instructions" placeholder="Enter network TRC20 or specific branch code..." class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all">
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-brand-gold text-black text-xs font-bold uppercase tracking-widest hover:brightness-110 shadow-lg shadow-brand-gold/20 transition-all">
                        Register Node
                    </button>
                </div>
            </form>

            <div class="border-t border-white/5 pt-8 grid grid-cols-1 gap-6">
                @foreach($paymentMethods as $method)
                    <form method="POST" action="{{ route('admin.payment-methods.update', $method) }}" class="flex flex-col md:flex-row gap-6 p-6 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-brand-gold/20 transition-colors group">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">
                             <div>
                                 <label class="block text-[9px] font-bold uppercase tracking-widest text-white/30 mb-1">Node Alias</label>
                                 <input type="text" name="name" value="{{ $method->name }}" required class="w-full bg-transparent border-b border-white/10 py-2 text-sm font-semibold text-white focus:outline-none focus:border-brand-gold transition-colors">
                             </div>
                             <div>
                                 <label class="block text-[9px] font-bold uppercase tracking-widest text-white/30 mb-1">Account Identity</label>
                                 <input type="text" name="account_title" value="{{ $method->account_title }}" required class="w-full bg-transparent border-b border-white/10 py-2 text-sm font-semibold text-white focus:outline-none focus:border-brand-gold transition-colors">
                             </div>
                             <div>
                                 <label class="block text-[9px] font-bold uppercase tracking-widest text-white/30 mb-1">Routing Code</label>
                                 <input type="text" name="account_number" value="{{ $method->account_number }}" required class="w-full bg-transparent border-b border-white/10 py-2 text-sm font-semibold text-brand-gold focus:outline-none focus:border-brand-gold transition-colors font-mono tracking-widest">
                             </div>
                             <div>
                                 <label class="block text-[9px] font-bold uppercase tracking-widest text-white/30 mb-1">Status Protocol</label>
                                 <select name="is_active" class="w-full bg-transparent border-b border-white/10 py-2 text-sm font-semibold {{ $method->is_active ? 'text-emerald-400' : 'text-white/40' }} focus:outline-none focus:border-brand-gold transition-colors">
                                     <option value="1" class="bg-brand-surface" {{ $method->is_active ? 'selected' : '' }}>Online (Active)</option>
                                     <option value="0" class="bg-brand-surface" {{ !$method->is_active ? 'selected' : '' }}>Offline (Deactivated)</option>
                                 </select>
                             </div>
                             <div class="md:col-span-2">
                                 <label class="block text-[9px] font-bold uppercase tracking-widest text-white/30 mb-1">Instructions</label>
                                 <input type="text" name="instructions" value="{{ $method->instructions }}" class="w-full bg-transparent border-b border-white/10 py-2 text-xs text-white/60 focus:outline-none focus:border-brand-gold transition-colors block">
                             </div>
                        </div>

                        <div class="flex md:flex-col justify-end gap-3 md:w-32 items-end">
                            <button type="submit" class="w-full flex-1 md:flex-none px-4 py-3 rounded-xl bg-white/5 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-brand-gold hover:text-black transition-all text-center border border-white/10">
                                Apply
                            </button>
                    </form>
                    
                    <form method="POST" action="{{ route('admin.payment-methods.destroy', $method) }}" onsubmit="return confirm('Sever this financial node permanently?');" class="w-full flex-[0.5] md:flex-none">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-3 rounded-xl border border-red-500/20 text-red-500/60 hover:text-red-500 hover:bg-red-500/10 text-[10px] font-bold uppercase tracking-widest transition-all text-center">
                            Sever
                        </button>
                    </form>
                        </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
