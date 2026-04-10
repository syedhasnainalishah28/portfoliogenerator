@extends('admin.layout')
@section('title', 'Order Analytics')
@section('page-title', 'Order Intelligence')

@section('content')
<div class="space-y-10">
    {{-- Operations Filter --}}
    <div class="flex items-center gap-4 bg-white/[0.02] p-2 rounded-2xl border border-white/5 w-fit backdrop-blur-md">
        <a href="{{ route('admin.orders.index') }}" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all {{ !request('status') ? 'bg-[#D4A853]/20 text-[#D4A853]' : 'text-white/30 hover:text-white hover:bg-white/5' }}">
            <i class="fas fa-layer-group mr-2"></i>
            All Streams
        </a>
        @foreach(['pending','approved','rejected'] as $s)
        <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
            class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all {{ request('status') === $s ? 'badge-'.$s : 'text-white/30 hover:text-white hover:bg-white/5' }}">
            {{ $s }}
        </a>
        @endforeach
    </div>

    <!-- Data Streams -->
    <div class="table-container">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="table-th text-center w-24">ID Node</th>
                    <th class="table-th">Customer Identity</th>
                    <th class="table-th">Tier Selection</th>
                    <th class="table-th">Value Flux</th>
                    <th class="table-th">Gateway</th>
                    <th class="table-th">Timestamp</th>
                    <th class="table-th">Status</th>
                    <th class="table-th text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="table-row">
                    <td class="table-td text-center">
                        <span class="font-mono text-[10px] font-black p-2 bg-white/5 rounded-lg text-[#D4A853]">#{{ $order->order_number }}</span>
                    </td>
                    <td class="table-td">
                        <div class="font-bold text-white text-sm">{{ $order->user->name }}</div>
                        <div class="text-[10px] text-white/30 font-black uppercase mt-0.5 tracking-wider">{{ $order->user->email }}</div>
                    </td>
                    <td class="table-td">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/[0.03] border border-white/5 rounded-lg text-xs font-bold text-white/80">
                            <i class="fas fa-cube text-[#D4A853]/50 text-[10px]"></i>
                            {{ $order->plan->name }}
                        </div>
                    </td>
                    <td class="table-td">
                        <div class="font-black text-white text-base">${{ $order->amount_usd }}</div>
                        @if($order->amount_pkr)<div class="text-[9px] text-white/30 font-bold uppercase mt-0.5">₨{{ number_format($order->amount_pkr) }}</div>@endif
                    </td>
                    <td class="table-td">
                        <div class="flex items-center gap-2 text-xs font-bold text-white/60">
                            <i class="fas fa-university text-[10px] text-white/20"></i>
                            {{ $order->paymentMethod->name }}
                        </div>
                    </td>
                    <td class="table-td">
                        <div class="text-[10px] font-black text-white/40 uppercase tracking-tighter leading-tight">
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <span class="text-[#D4A853]/40">{{ $order->created_at->format('H:i:s') }}</span>
                        </div>
                    </td>
                    <td class="table-td">
                        <span class="badge badge-{{ $order->status }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="table-td text-right">
                        @if($order->status === 'pending')
                        <a href="{{ route('admin.orders.show', $order) }}" class="ha-btn-gold !py-2.5 !px-5 !text-[9px]">
                            Validate
                        </a>
                        @else
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-white/20 hover:text-[#D4A853] transition-colors text-xs font-black uppercase tracking-widest">
                            Review
                            <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="table-td text-center py-24">
                        <i class="fas fa-inbox text-4xl text-white/5 mb-4 block"></i>
                        <span class="text-white/20 font-black uppercase tracking-widest text-xs">No active data streams found.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="mt-8">
        {{ $orders->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
