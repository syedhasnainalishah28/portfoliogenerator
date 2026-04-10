@extends('admin.layout')
@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    {{-- Stat Cards --}}
    @php
    $cards = [
        ['🟡', 'Pending Orders',    $stats['pending_orders'],   'Requires your review'],
        ['✅', 'Approved Orders',   $stats['total_orders'],     'All time purchases'],
        ['🔑', 'Active Licenses',   $stats['active_licenses'],  'Currently in use'],
        ['❌', 'Expired Licenses',  $stats['expired_licenses'], 'Needs renewal/extension'],
        ['📦', 'Total Licenses',    $stats['total_licenses'],   'Generated all time'],
        ['💰', 'Revenue (USD)',      '$' . number_format($stats['revenue_usd'], 2), 'Total approved payments'],
    ];
    @endphp

    @foreach($cards as [$icon, $label, $value, $sub])
    <div class="stat-card rounded-3xl p-6 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 text-6xl opacity-5 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500">{{ $icon }}</div>
        <div class="relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-xl mb-4 group-hover:bg-amber-500/10 group-hover:border-amber-500/20 transition-colors">
                {{ $icon }}
            </div>
            <div class="text-4xl font-syne font-black text-white tracking-tight mb-1">{{ $value }}</div>
            <div class="text-sm font-bold text-white/70 uppercase tracking-wider">{{ $label }}</div>
            <div class="text-[11px] text-white/30 mt-2">{{ $sub }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Recent Orders --}}
<div class="table-container pt-2">
    <div class="px-8 py-6 flex items-center justify-between border-b border-white/10">
        <div>
            <h2 class="font-syne font-black text-white text-lg tracking-wide">Recent Transactions</h2>
            <p class="text-xs text-white/40 mt-1">Latest 5 orders placed by users.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-xl border border-white/10 text-xs font-bold text-white/50 hover:bg-white/5 hover:text-white transition-colors">View All Orders</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr>
                <th class="table-th">Order #</th>
                <th class="table-th">Customer</th>
                <th class="table-th">Plan</th>
                <th class="table-th">Value</th>
                <th class="table-th">Status</th>
                <th class="table-th text-right">Action</th>
            </tr></thead>
            <tbody>
            @forelse($recentOrders as $order)
            <tr class="table-row">
                <td class="table-td font-mono text-xs font-bold text-amber-500">{{ $order->order_number }}</td>
                <td class="table-td">
                    <div class="font-bold text-white">{{ $order->user->name }}</div>
                    <div class="text-[11px] text-white/40 mt-0.5">{{ $order->user->email }}</div>
                </td>
                <td class="table-td font-semibold text-white/80">{{ $order->plan->name }}</td>
                <td class="table-td font-black text-white">${{ $order->amount_usd }}</td>
                <td class="table-td">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border badge-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="table-td text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-bold text-amber-500 hover:text-amber-400 hover:underline">Review →</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="table-td text-center text-white/30 py-12 font-medium">No recent orders found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
