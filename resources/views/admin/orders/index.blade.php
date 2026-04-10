@extends('admin.layout')
@section('title', 'Order Intelligence')
@section('page-title', 'Protocol Operations')

@section('content')
<div class="space-y-8">
    
    <!-- Header Controls -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-brand-panel border border-white/5 rounded-2xl p-6 backdrop-blur-xl">
        <div class="flex items-center gap-4">
            <span class="text-[10px] font-bold uppercase tracking-widest text-white/40">Status Filter:</span>
            <div class="flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request('status') ? 'bg-white/5 text-white/40 hover:text-white' : 'bg-brand-gold/10 text-brand-gold border border-brand-gold/20' }}">All Core</a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request('status') === 'pending' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : 'bg-white/5 text-white/40 hover:text-white' }}">Pending</a>
                <a href="{{ route('admin.orders.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request('status') === 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-white/5 text-white/40 hover:text-white' }}">Approved</a>
            </div>
        </div>
        
        <div class="text-[10px] font-bold uppercase tracking-widest text-white/30 hidden lg:block">
            <i class="fas fa-shield-halved text-brand-gold mr-2 opacity-50"></i> Total Audits: {{ $orders->total() }}
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-brand-panel border border-white/5 rounded-2xl overflow-hidden backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] font-bold uppercase tracking-widest text-white/30">
                        <th class="px-8 py-5">Signal ID / Date</th>
                        <th class="px-8 py-5">Agent Network</th>
                        <th class="px-8 py-5">Protocol Class</th>
                        <th class="px-8 py-5">Financial Node</th>
                        <th class="px-8 py-5 text-center">Clearance</th>
                        <th class="px-8 py-5 text-right">Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @forelse($orders as $order)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <!-- ID & Date -->
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1.5">
                                <span class="font-mono text-[11px] font-bold text-brand-gold">#{{ $order->order_number }}</span>
                                <span class="text-[10px] uppercase font-semibold text-white/40 tracking-wider">
                                    <i class="far fa-calendar-alt opacity-50 mr-1"></i> {{ $order->created_at->format('M d, H:i') }}
                                </span>
                            </div>
                        </td>

                        <!-- User -->
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-semibold text-white group-hover:text-brand-gold transition-colors">{{ $order->user->name }}</span>
                                <span class="text-[10px] font-bold tracking-wider uppercase text-white/30 mt-0.5">{{ $order->user->email }}</span>
                            </div>
                        </td>

                        <!-- Plan -->
                        <td class="px-8 py-5">
                            <span class="bg-white/5 border border-white/10 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest text-white/60">
                                <i class="fas fa-microchip opacity-50 mr-1.5"></i> {{ $order->plan->name }}
                            </span>
                        </td>

                        <!-- Payment -->
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                <span class="font-bold text-white text-base">${{ number_format($order->amount_usd, 2) }}</span>
                                <span class="text-[10px] uppercase tracking-widest font-semibold text-white/40">
                                    <i class="fas fa-wallet opacity-50 mr-1"></i> {{ optional($order->payment_method)->name ?? (is_string($order->payment_method) ? $order->payment_method : 'N/A') }}
                                </span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-8 py-5 text-center">
                            @if($order->status === 'approved')
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.1)]">Approved</span>
                            @elseif($order->status === 'pending')
                                <span class="bg-amber-500/10 text-amber-500 border border-amber-500/20 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest">Pending</span>
                            @elseif($order->status === 'rejected')
                                <span class="bg-red-500/10 text-red-500 border border-red-500/20 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest">Rejected</span>
                            @else
                                <span class="bg-white/5 text-white/50 border border-white/10 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest">{{ $order->status }}</span>
                            @endif
                        </td>

                        <!-- Action -->
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/[0.03] border border-white/10 hover:border-brand-gold/30 hover:bg-brand-gold/10 hover:text-brand-gold text-white/50 text-xs font-bold uppercase tracking-wider transition-all">
                                Inspect <i class="fas fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 text-white/20 mb-4">
                                <i class="fas fa-satellite text-2xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-white/40 italic">No operations recorded matching current parameters.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($orders->hasPages())
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
