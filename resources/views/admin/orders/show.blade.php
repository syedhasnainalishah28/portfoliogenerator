@extends('admin.layout')
@section('title', 'Order ' . $order->order_number)
@section('page-title')
<div class="flex items-center gap-4">
    <a href="{{ route('admin.orders.index') }}" class="text-white/30 hover:text-white transition-colors">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    Order Validation
</div>
@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-8">

    {{-- Order Details --}}
    <div class="lg:col-span-2 space-y-8">
        {{-- Info Card --}}
        <div class="rounded-3xl p-8 border border-white/5 shadow-2xl relative overflow-hidden" style="background: rgba(15,15,15,0.6); backdrop-filter: blur(20px);">
            <div class="absolute inset-0 bg-gradient-to-br from-white/[0.02] to-transparent pointer-events-none"></div>
            
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-white/5 relative z-10">
                <div>
                    <h3 class="font-syne font-black text-white text-xl">Transaction DNA</h3>
                    <p class="text-xs text-white/40 mt-1 uppercase tracking-widest font-bold">Ref: {{ $order->order_number }}</p>
                </div>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border badge-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-y-8 gap-x-4 text-sm relative z-10">
                @php $rows = [
                    ['Purchased Plan',      $order->plan->name . ' (' . $order->plan->duration_months . ' months)'],
                    ['Gateway Method',      $order->paymentMethod->name],
                    ['Expected Value',      '$' . $order->amount_usd],
                    ['Claimed Payment',     $order->amount_pkr ? '₨ ' . number_format($order->amount_pkr) : '—'],
                    ['Applied Exchange',    $order->exchange_rate ? '1 USD = ' . $order->exchange_rate . ' PKR' : '—'],
                    ['Transaction Hash',    $order->transaction_hash ?? '—'],
                    ['Submitted On',        $order->created_at->format('d M Y, H:i')],
                    ['Processed On',        $order->approved_at?->format('d M Y, H:i') ?? '—'],
                ]; @endphp
                @foreach($rows as [$label, $value])
                <div>
                    <div class="text-[10px] text-white/30 uppercase tracking-[0.15em] font-black mb-2">{{ $label }}</div>
                    <div class="text-white font-semibold text-sm @if($label === 'Transaction Hash') font-mono text-amber-400 @endif">{{ $value }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Payment Screenshot --}}
        @if($order->screenshot_path)
        <div class="rounded-3xl p-8 border border-white/5 shadow-2xl relative overflow-hidden" style="background: rgba(15,15,15,0.6); backdrop-filter: blur(20px);">
            <div class="absolute inset-0 bg-gradient-to-br from-white/[0.02] to-transparent pointer-events-none"></div>
            <h3 class="font-syne font-black text-white text-xl mb-6 relative z-10">Payment Proof</h3>
            <a href="{{ route('admin.orders.screenshot', $order) }}" target="_blank" class="block relative z-10 group overflow-hidden rounded-2xl border border-white/10 hover:border-amber-500/50 transition-colors bg-black/50 p-2">
                <img src="{{ route('admin.orders.screenshot', $order) }}" alt="Payment Proof"
                    class="object-contain w-full max-h-[500px] rounded-xl">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity backdrop-blur-sm">
                    <span class="ha-btn-gold">View Full Resolution</span>
                </div>
            </a>
        </div>
        @endif
    </div>

    {{-- User + Action Panel --}}
    <div class="space-y-8">
        {{-- User Card --}}
        <div class="rounded-3xl p-8 border border-white/5 shadow-2xl relative overflow-hidden text-center" style="background: rgba(15,15,15,0.6); backdrop-filter: blur(20px);">
            <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-amber-500/20 to-amber-600/5 border-2 border-amber-500/30 flex items-center justify-center text-amber-400 text-3xl font-black mb-4 shadow-[0_0_30px_rgba(242,139,17,0.2)]">
                {{ strtoupper(substr($order->user->name, 0, 1)) }}
            </div>
            <div class="font-syne font-black text-white text-xl">{{ $order->user->name }}</div>
            <div class="text-xs text-white/40 mt-1 font-mono">{{ $order->user->email }}</div>
            <div class="mt-4 inline-flex px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-[10px] uppercase tracking-widest text-white/50">
                System User
            </div>
        </div>

        {{-- License Info (if approved) --}}
        @if($order->license)
        <div class="rounded-3xl p-8 border border-emerald-500/30 shadow-[0_10px_40px_-10px_rgba(16,185,129,0.2)] relative overflow-hidden" style="background: linear-gradient(135deg, rgba(16,185,129,0.1) 0%, rgba(16,185,129,0.02) 100%);">
            <h3 class="font-syne font-black text-emerald-400 text-lg mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>    
                License Deployed
            </h3>
            <div class="font-mono text-xl font-black text-white tracking-[0.15em] mb-2">{{ $order->license->license_key }}</div>
            <div class="text-xs text-emerald-400/60 font-bold uppercase tracking-widest">Valid until: {{ $order->license->expires_at?->format('F d, Y') }}</div>
        </div>
        @endif

        {{-- Actions --}}
        @if($order->status === 'pending')
        <div class="rounded-3xl p-8 border border-white/5 shadow-2xl relative overflow-hidden" style="background: rgba(15,15,15,0.6); backdrop-filter: blur(20px);">
            <h3 class="font-syne font-black text-white text-lg mb-6">Decision matrix</h3>

            <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 mb-6">
                <p class="text-xs text-amber-400/80 font-bold leading-relaxed">Ensure the Transaction Hash matches your Bank/JazzCash statement before approving.</p>
            </div>

            <form method="POST" action="{{ route('admin.orders.approve', $order) }}" class="mb-5">
                @csrf
                <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-2">Note to User (Optional)</p>
                <textarea name="admin_note" placeholder="E.g. Thanks for the quick payment..." rows="2"
                    class="ha-input mb-4"></textarea>
                <button type="submit" class="w-full py-4 rounded-xl font-black text-black text-sm uppercase tracking-widest shadow-[0_4px_20px_-5px_rgba(34,197,94,0.4)] hover:scale-[1.02] hover:brightness-110 transition-all" style="background: linear-gradient(135deg,#22c55e,#16a34a);"
                    onclick="return confirm('APPROVE order & Generate License?')">
                    Approve Request
                </button>
            </form>

            <form method="POST" action="{{ route('admin.orders.reject', $order) }}">
                @csrf
                <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-2 border-t border-white/10 pt-5 mt-5">Rejection Reason</p>
                <textarea name="admin_note" placeholder="Required for rejection..." rows="2" required
                    class="ha-input mb-4 focus:border-red-500/60"></textarea>
                <button type="submit" class="ha-btn-danger w-full py-4 text-xs tracking-widest uppercase"
                    onclick="return confirm('REJECT this order? This cannot be undone easily.')">
                    Reject Purchase
                </button>
            </form>
        </div>
        @elseif($order->status === 'rejected')
        <div class="rounded-3xl p-6 border border-red-500/20 text-center bg-red-500/5">
            <h3 class="text-sm font-black text-red-400 uppercase tracking-widest mb-2">Purchase Rejected</h3>
            <p class="text-xs text-red-400/60 leading-relaxed">{{ $order->admin_note ?? 'No reason provided.' }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
