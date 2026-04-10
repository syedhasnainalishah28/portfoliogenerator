@extends('admin.layout')
@section('title', 'Vault Analytics')
@section('page-title', 'Vault Analytics')

@section('content')
<div class="space-y-8">
    
    <!-- Header Controls -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-brand-panel border border-white/5 rounded-2xl p-6 backdrop-blur-xl">
        <div class="flex items-center gap-4">
            <span class="text-[10px] font-bold uppercase tracking-widest text-white/40">Vault Filter:</span>
            <div class="flex gap-2">
                <a href="{{ route('admin.licenses.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request('status') ? 'bg-white/5 text-white/40 hover:text-white' : 'bg-brand-gold/10 text-brand-gold border border-brand-gold/20' }}">All Keys</a>
                <a href="{{ route('admin.licenses.index', ['status' => 'active']) }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request('status') === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-white/5 text-white/40 hover:text-white' }}">Active Uplinks</a>
                <a href="{{ route('admin.licenses.index', ['status' => 'expired']) }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request('status') === 'expired' ? 'bg-red-500/10 text-red-500 border border-red-500/20' : 'bg-white/5 text-white/40 hover:text-white' }}">Terminated</a>
                <a href="{{ route('admin.licenses.index', ['status' => 'unassigned']) }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request('status') === 'unassigned' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : 'bg-white/5 text-white/40 hover:text-white' }}">Dormant</a>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="text-[10px] font-bold uppercase tracking-widest text-white/30 hidden lg:block mr-4 border-r border-white/10 pr-4">
                Total Keys: {{ $licenses->total() }}
            </div>
            <a href="{{ route('admin.licenses.generate') }}" class="px-5 py-2.5 rounded-xl bg-brand-gold text-black text-[10px] font-bold uppercase tracking-widest hover:brightness-110 shadow-lg shadow-brand-gold/20 transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i> Manual Forge
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-brand-panel border border-white/5 rounded-2xl overflow-hidden backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] font-bold uppercase tracking-widest text-white/30">
                        <th class="px-8 py-5">Cryptographic Signature</th>
                        <th class="px-8 py-5">Assigned Agent (Uplink)</th>
                        <th class="px-8 py-5">Tier Class</th>
                        <th class="px-8 py-5 text-center">Lifecycle Limit</th>
                        <th class="px-8 py-5 text-center">Protocol State</th>
                        <th class="px-8 py-5 text-right">Extend Override</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @forelse($licenses as $license)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <!-- Key -->
                        <td class="px-8 py-5">
                            <span class="font-mono text-sm tracking-widest font-black text-brand-gold bg-brand-gold/5 border border-brand-gold/10 px-3 py-1.5 rounded-lg select-all">
                                {{ $license->license_key }}
                            </span>
                        </td>

                        <!-- User -->
                        <td class="px-8 py-5">
                            @if($license->user)
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-white/60 text-xs font-bold">
                                        {{ strtoupper(substr($license->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-white text-xs">{{ $license->user->name }}</span>
                                        <span class="text-[9px] font-bold tracking-wider uppercase text-white/30 mt-0.5">Assigned</span>
                                    </div>
                                </div>
                            @else
                                <span class="bg-white/5 text-white/40 border border-white/10 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest">
                                    Offline (Dormant)
                                </span>
                            @endif
                        </td>

                        <!-- Plan -->
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-white text-xs">{{ $license->plan->name }}</span>
                                <span class="text-[9px] font-bold tracking-widest uppercase text-white/30">{{ $license->duration_months }} Months</span>
                            </div>
                        </td>

                        <!-- Expiry -->
                        <td class="px-8 py-5 text-center">
                            @if($license->expires_at)
                                <div class="flex flex-col gap-1 items-center">
                                    <span class="font-bold text-white text-xs">{{ $license->expires_at->format('M d, Y') }}</span>
                                    <span class="text-[9px] font-bold tracking-widest uppercase text-white/30">
                                        {{ $license->expires_at->diffForHumans() }}
                                    </span>
                                </div>
                            @else
                                <span class="text-white/20 font-bold text-xl">-</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-8 py-5 text-center">
                            @if(!$license->user_id)
                                <span class="bg-amber-500/10 text-amber-500 border border-amber-500/20 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest">Unassigned</span>
                            @elseif(!$license->expires_at || $license->expires_at->isFuture())
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.1)]">Active</span>
                            @else
                                <span class="bg-red-500/10 text-red-500 border border-red-500/20 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest">Terminated</span>
                            @endif
                        </td>

                        <!-- Extension -->
                        <td class="px-8 py-5 text-right">
                            @if($license->user_id)
                                <form method="POST" action="{{ route('admin.licenses.extend', $license) }}" class="inline-block" onsubmit="return confirm('Initiate protocol extension by 1 month?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/[0.03] border border-white/10 hover:border-brand-gold/30 hover:bg-brand-gold/10 hover:text-brand-gold text-white/50 text-xs font-bold uppercase tracking-wider transition-all">
                                        <i class="fas fa-arrow-up-right-dots"></i> Sync +1M
                                    </button>
                                </form>
                            @else
                                <span class="text-[9px] font-bold tracking-widest uppercase text-white/20">Requires Payload Bonding</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 text-white/20 mb-4">
                                <i class="fas fa-key text-2xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-white/40 italic">Vault is empty.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($licenses->hasPages())
    <div class="mt-8">
        {{ $licenses->links() }}
    </div>
    @endif
</div>
@endsection
