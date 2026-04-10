@extends('admin.layout')
@section('title', 'System Dashboard')
@section('page-title', 'Protocol Metrics')

@section('content')
<div class="space-y-12">
    
    <!-- Bento Grid for Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
        $cards = [
            ['fas fa-clock', 'Pending Protocols', $stats['pending_orders'], 'Requires Authorization', 'text-amber-500', 'bg-amber-500'],
            ['fas fa-check-circle', 'Approved Node Access', $stats['total_orders'], 'System-wide activations', 'text-emerald-500', 'bg-emerald-500'],
            ['fas fa-key', 'Active Uplinks', $stats['active_licenses'], 'Current live connections', 'text-sky-500', 'bg-sky-500'],
            ['fas fa-times-circle', 'Terminated Access', $stats['expired_licenses'], 'Cycle rotation required', 'text-red-500', 'bg-red-500'],
            ['fas fa-cube', 'Total Vault Artifacts', $stats['total_licenses'], 'Historical records', 'text-purple-500', 'bg-purple-500'],
            ['fas fa-money-bill-wave', 'Total Capital (USD)', '$' . number_format($stats['revenue_usd'], 2), 'Verified throughput', 'text-brand-gold', 'bg-brand-gold'],
        ];
        @endphp

        @foreach($cards as [$icon, $label, $value, $sub, $textColor, $bgColor])
        <div class="bg-brand-panel border border-white/5 rounded-3xl p-6 relative overflow-hidden group hover:bg-white/[0.03] transition-all duration-300">
            <!-- Glow -->
            <div class="absolute -right-6 -top-6 w-24 h-24 {{ $bgColor }} opacity-[0.03] rounded-full blur-2xl group-hover:opacity-10 transition-opacity"></div>
            
            <div class="flex items-center justify-between mb-8">
                <div class="w-12 h-12 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center text-lg {{ $textColor }} shadow-inner">
                    <i class="{{ $icon }}"></i>
                </div>
                <div class="text-[9px] font-bold uppercase tracking-widest text-white/20 px-3 py-1 rounded-full border border-white/5 bg-white/[0.02]">
                    Metric Secure
                </div>
            </div>
            
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/40 mb-1">{{ $label }}</p>
                <div class="text-4xl font-syne font-bold text-white tracking-tighter">{{ $value }}</div>
                <p class="text-[10px] uppercase font-bold tracking-widest text-white/20 mt-3">{{ $sub }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-brand-panel border border-white/5 rounded-3xl overflow-hidden mt-12 backdrop-blur-xl">
        <div class="px-8 py-6 flex items-center justify-between border-b border-white/5 bg-white/[0.01]">
            <div>
                <h3 class="font-syne font-bold text-white text-xl tracking-tight">Recent System Throughput</h3>
                <p class="text-[10px] uppercase font-bold tracking-widest text-white/30 mt-1">Latest encrypted transactions processed by core</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 rounded-xl border border-white/10 text-white/50 text-[10px] font-bold uppercase tracking-widest hover:text-white hover:bg-white/5 transition-colors">
                Audit All Trails
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-black/20 border-b border-white/5 text-[10px] font-bold uppercase tracking-widest text-white/30">
                        <th class="px-8 py-5">Signal ID</th>
                        <th class="px-8 py-5">Agent Identity</th>
                        <th class="px-8 py-5">Protocol Class</th>
                        <th class="px-8 py-5">Value</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right w-24">Ops</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-8 py-4">
                            <span class="font-mono text-xs font-bold text-brand-gold">{{ $order->order_number }}</span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-white">{{ $order->user->name }}</span>
                                <span class="text-[10px] tracking-wider text-white/40 mt-0.5">{{ $order->user->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-xs font-semibold text-white/60">
                                <i class="fas fa-microchip text-white/20 mr-2"></i> {{ $order->plan->name }}
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-sm font-bold text-white">${{ number_format($order->amount_usd, 2) }}</span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if($order->status === 'approved')
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-lg text-[9px] font-bold uppercase tracking-widest">Approved</span>
                            @elseif($order->status === 'pending')
                                <span class="bg-amber-500/10 text-amber-500 border border-amber-500/20 px-3 py-1 rounded-lg text-[9px] font-bold uppercase tracking-widest">Pending</span>
                            @else
                                <span class="bg-red-500/10 text-red-500 border border-red-500/20 px-3 py-1 rounded-lg text-[9px] font-bold uppercase tracking-widest">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="w-10 h-10 inline-flex items-center justify-center rounded-xl bg-white/[0.02] border border-white/5 text-brand-gold hover:bg-brand-gold/10 transition-colors">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 text-white/20 mb-4">
                                <i class="fas fa-ghost text-2xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-white/30 italic">No signals detected in the current cycle.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
