<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Plan — Purchase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #050505; color: #fff; }
        .font-syne { font-family: 'Syne', sans-serif; }
        
        .plan-card {
            background: rgba(10,10,10,0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        .plan-card:hover {
            border-color: rgba(242,139,17,0.3);
            transform: translateY(-5px);
            box-shadow: 0 15px 40px -10px rgba(242,139,17,0.15);
        }
        
    </style>
</head>
<body class="min-h-screen pt-20 pb-10 px-6 relative overflow-hidden">
    
    <!-- Background Glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-amber-500/10 blur-[120px] rounded-full pointer-events-none"></div>

<div class="max-w-5xl mx-auto relative z-10">
    <a href="{{ url('/') }}" class="text-white/50 hover:text-white transition-colors mb-8 flex items-center gap-2 text-sm w-fit font-medium">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Return to Home
    </a>

    <div class="text-center mb-16">
        <h1 class="text-5xl md:text-6xl font-syne font-black mb-6 tracking-tight">Choose Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-[#f2b311]">Empire</span> Plan</h1>
        <p class="text-white/50 text-lg max-w-2xl mx-auto">Select the plan to generate your payment instructions. Gain instant access to the builder upon verification.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        @foreach($plans as $plan)
        <div class="plan-card rounded-[2rem] p-8 md:p-10 relative group">
            
            @if($loop->index === 1)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-500 to-[#f2b311] text-black text-[10px] font-black uppercase tracking-[0.2em] px-4 py-1.5 rounded-full shadow-[0_0_15px_rgba(242,139,17,0.4)]">
                    Most Popular
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 to-transparent rounded-[2rem] pointer-events-none"></div>
            @endif

            <div class="text-xs font-black tracking-[0.2em] text-amber-500 uppercase mb-4">{{ $plan->duration_months }} Months Access</div>
            <div class="text-2xl font-syne font-black mb-2">{{ $plan->name }}</div>
            
            <div class="flex items-end gap-1 mb-8 pb-8 border-b border-white/5">
                <span class="text-5xl font-black tracking-tighter">${{ $plan->price_usd }}</span>
                <span class="text-white/40 mb-1 font-semibold">/ {{ $plan->duration_months > 1 ? $plan->duration_months . ' mos' : 'mo' }}</span>
            </div>
            
            <ul class="space-y-4 mb-10 text-sm text-white/70 font-medium">
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Full system access
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    All premium templates
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ $plan->duration_months }} months validity
                </li>
            </ul>

            <a href="{{ route('purchase.payment', $plan->slug) }}" class="block w-full py-4 rounded-2xl text-center text-sm font-black text-black transition-all hover:scale-[1.02] shadow-[0_4px_20px_-5px_rgba(242,139,17,0.3)]" style="background: linear-gradient(135deg,#f28b11,#f2b311);">
                Select Plan
            </a>
        </div>
        @endforeach
    </div>
</div>
</body>
</html>
