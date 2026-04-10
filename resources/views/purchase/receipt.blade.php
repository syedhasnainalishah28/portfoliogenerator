<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Receipt — HA Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800;900&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0a0a10; } .font-syne { font-family: 'Syne', sans-serif; }</style>
</head>
<body class="min-h-screen text-white pt-20 px-6 flex flex-col items-center">

<div class="w-full max-w-xl text-center mb-8">
    <div class="inline-flex items-center gap-3 mb-6">
        <img src="{{ asset('HA-Tech.png') }}" class="w-12 h-12 object-contain drop-shadow-[0_0_15px_rgba(242,139,17,0.4)]" alt="HA Tech">
        <span class="font-syne font-black text-white text-3xl">HA Tech</span>
    </div>
    
    @if(session('success'))
    <div class="mb-8 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm flex items-center justify-center gap-2 font-bold">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
</div>

<div class="w-full max-w-xl rounded-3xl p-8 border border-white/10 shadow-2xl relative" style="background: rgba(255,255,255,0.03);">
    {{-- Status Banner --}}
    @if($order->status === 'pending')
    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-yellow-500 text-black text-xs font-black tracking-widest uppercase px-5 py-1.5 rounded-full shadow-lg">
        ⏳ Order Pending Verification
    </div>
    @elseif($order->status === 'approved')
    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs font-black tracking-widest uppercase px-5 py-1.5 rounded-full shadow-lg">
        ✅ Payment Approved
    </div>
    @else
    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-red-500 text-white text-xs font-black tracking-widest uppercase px-5 py-1.5 rounded-full shadow-lg">
        ❌ Order Rejected
    </div>
    @endif

    <div class="text-center mb-8 border-b border-white/5 pb-8">
        <h2 class="text-xs text-white/40 uppercase tracking-widest font-bold mb-1">Receipt ID</h2>
        <div class="text-2xl font-mono text-white">{{ $order->order_number }}</div>
    </div>

    <div class="space-y-4 text-sm font-medium border-b border-white/5 pb-8 mb-8">
        <div class="flex justify-between"><span class="text-white/40">Customer</span> <span class="text-white text-right">{{ $order->user->name }}<br><span class="text-xs text-white/30">{{ $order->user->email }}</span></span></div>
        <div class="flex justify-between"><span class="text-white/40">Plan</span> <span class="text-white">{{ $order->plan->name }}</span></div>
        <div class="flex justify-between"><span class="text-white/40">Duration</span> <span class="text-white">{{ $order->plan->duration_months }} Months</span></div>
        <div class="flex justify-between"><span class="text-white/40">Method</span> <span class="text-white">{{ $order->paymentMethod->name }}</span></div>
        <div class="flex justify-between mt-4 border-t border-white/5 pt-4"><span class="text-white/40">Amount Paid</span> <span class="text-xl font-bold text-amber-400">₨ {{ number_format($order->amount_pkr ?? 0) }}</span></div>
    </div>

    @if($order->status === 'approved' && $order->license)
        <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-6 text-center">
            <h3 class="text-xs text-amber-400 font-bold uppercase tracking-widest mb-3">Your License Key</h3>
            <div class="font-mono text-xl md:text-2xl font-black text-amber-400 tracking-wider mb-4">{{ $order->license->license_key }}</div>
            <p class="text-xs text-amber-400/60 mb-4">Expires: {{ $order->license->expires_at->format('d M Y') }}</p>
            <a href="{{ route('dashboard') }}" class="inline-block py-3 px-8 rounded-xl font-black text-black text-sm hover:opacity-90 transition-all shadow-[0_0_20px_rgba(242,139,17,0.2)]" style="background: linear-gradient(135deg,#f28b11,#f2b311);">
                Enter Dashboard Now
            </a>
        </div>
    @elseif($order->status === 'rejected')
        <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 text-center">
            <h3 class="font-syne font-bold text-red-400 mb-2">Payment Rejected</h3>
            <p class="text-sm text-red-300/70">{{ $order->admin_note ?? 'Your payment could not be verified. Please contact support.' }}</p>
            <a href="{{ route('purchase.plans') }}" class="mt-4 inline-block text-xs text-red-400 hover:text-red-300 underline">Try Again</a>
        </div>
    @else
        <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-6 text-center">
            <h3 class="font-syne font-bold text-white mb-2">Verification in Progress</h3>
            <p class="text-sm text-white/50 mb-4">Our team is verifying your payment screenshot with the bank/JazzCash. This usually takes 2-12 hours.</p>
            <p class="text-xs text-white/30 truncate">Tx: {{ $order->transaction_hash }}</p>
        </div>
    @endif
</div>

<div class="mt-8">
    <a href="{{ url('/') }}" class="text-sm text-white/30 hover:text-white transition-colors">Return to Home</a>
</div>
</body>
</html>
