<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Checkout — HA Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fff; margin: 0; padding: 0; }
        
        .ha-input {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            font-size: 14px;
            color: #111;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            background: #fff;
        }
        .ha-input:focus {
            border-color: #000;
            box-shadow: 0 0 0 1px #000;
        }

        .payment-method-card {
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .payment-method-card:first-child { border-radius: 6px 6px 0 0; }
        .payment-method-card:last-child { border-radius: 0 0 6px 6px; border-top: none; }
        .payment-method-card.single-method { border-radius: 6px; border-top: 1px solid #e5e7eb; }
        
        /* Middle borders fix */
        .payment-method-card + .payment-method-card { border-top: 1px solid #e5e7eb; }

        input[type="radio"]:checked + .payment-method-wrapper .payment-method-card {
            background-color: #fafafa;
            border-color: #e5e7eb;
        }

        .radio-dot {
            width: 16px; height: 16px; border-radius: 50%; border: 1px solid #d1d5db;
            display: flex; align-items: center; justify-content: center;
        }
        input[type="radio"]:focus + .payment-method-wrapper .radio-dot {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0,0,0,0.1);
        }
        input[type="radio"]:checked + .payment-method-wrapper .radio-dot {
            border-color: #0a0a0a;
            background: #0a0a0a;
        }
        input[type="radio"]:checked + .payment-method-wrapper .radio-dot::after {
            content: ""; width: 6px; height: 6px; border-radius: 50%; background: #fff;
        }

        .file-upload-btn {
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            transition: background 0.2s;
        }
        .file-upload-btn:hover { background: #f9fafb; }

        .btn-submit {
            background: #000;
            color: #fff;
            width: 100%;
            padding: 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            transition: opacity 0.2s, transform 0.1s;
        }
        .btn-submit:hover { opacity: 0.9; }
        .btn-submit:active { transform: scale(0.99); }
    </style>
</head>
<body class="flex flex-col md:flex-row min-h-screen">

    <!-- LEFT SIDE: Dark Order Summary -->
    <div class="w-full md:w-[45%] bg-[#0a0a0a] text-white flex flex-col pt-10 md:pt-20 px-8 lg:px-20 min-h-[40vh] md:min-h-screen">
        <a href="{{ route('purchase.plans') }}" class="text-white/50 hover:text-white transition-colors mb-8 flex items-center gap-2 text-sm w-fit">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>

        <div class="mb-8">
            <div class="text-white/60 font-medium text-[15px] mb-1">Subscribe to HA Tech</div>
            <div class="flex items-start gap-1">
                <div class="text-4xl md:text-5xl font-bold tracking-tight" id="main-usd-price">US${{ number_format($plan->price_usd, 2) }}</div>
                <div class="text-white/60 text-sm mt-3 md:mt-4">per<br>{{ $plan->duration_months > 1 ? $plan->duration_months . ' months' : 'month' }}</div>
            </div>
            
            <div class="mt-4 flex flex-col gap-1">
                <div class="text-amber-400 font-semibold flex items-center gap-2">
                    <span id="live-pkr-badge" class="px-2.5 py-1 rounded-md bg-amber-500/10 border border-amber-500/20 text-xs">≈ Rs <span id="main-pkr-price">Loading...</span> PKR</span>
                </div>
                <div class="text-[11px] text-white/30 hidden md:block" id="exchange-rate-note">Live rate: 1 USD = 0 PKR</div>
            </div>
        </div>

        <div class="rounded-lg border border-white/10 bg-white/[0.02] p-4 mb-6 relative overflow-hidden group">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('HA-Tech.png') }}" class="w-8 h-8 object-contain shrink-0 drop-shadow-[0_0_10px_rgba(242,139,17,0.3)]" alt="HA Tech">
                    <div>
                        <div class="font-semibold text-[15px]">{{ $plan->name }}</div>
                        <div class="text-white/40 text-xs">Billed every {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }}</div>
                    </div>
                </div>
                <div class="font-semibold">US${{ number_format($plan->price_usd, 2) }}</div>
            </div>
        </div>

        <div class="space-y-3 text-[14px]">
            <div class="flex justify-between text-white/70">
                <span>Subtotal</span>
                <span>US${{ number_format($plan->price_usd, 2) }}</span>
            </div>
            <div class="flex justify-between text-white/70">
                <span>Tax</span>
                <span>US$0.00</span>
            </div>
            <div class="flex justify-between font-semibold border-t border-white/10 pt-3 mt-3 text-[15px]">
                <span>Total due today</span>
                <span>US${{ number_format($plan->price_usd, 2) }}</span>
            </div>
            <div class="flex justify-between text-amber-500 font-semibold mb-6">
                <span>Pay in PKR</span>
                <span id="summary-pkr">Rs Loading...</span>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: White Checkout Form -->
    <div class="w-full md:w-[55%] bg-white pt-10 md:pt-20 px-8 lg:px-24 xl:px-40 flex flex-col h-full overflow-y-auto">
        <form method="POST" action="{{ route('purchase.submit', $plan->slug) }}" enctype="multipart/form-data" class="w-full max-w-[480px]">
            @csrf
            <input type="hidden" name="amount_pkr" id="amount_pkr_input" value="">
            <input type="hidden" name="exchange_rate" id="exchange_rate_input" value="">

            <!-- Fake App/Wallet Button (Aesthetic unclickable) -->
            <div class="w-full h-12 rounded-md bg-[#00D632] text-white font-bold flex items-center justify-center gap-2 mb-6 cursor-not-allowed opacity-90 shadow-sm" title="Only manual payment is available right now">
                Pay with <svg class="w-5 h-5 mx-1" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg> link
            </div>
            
            <div class="flex items-center gap-4 mb-6">
                <div class="h-px bg-gray-200 flex-1"></div>
                <div class="text-gray-400 text-xs font-medium uppercase tracking-wider">OR</div>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <!-- Contact Info -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Contact information</h2>
                <div class="relative">
                    <label class="absolute text-xs text-gray-500 left-3 top-2 pointer-events-none">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled
                        class="w-full border border-gray-300 rounded-md pt-6 pb-2 px-3 text-sm text-gray-900 bg-gray-50 cursor-not-allowed" />
                </div>
            </div>

            <!-- Payment Method Form -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Payment method</h2>
                
                <div class="rounded-md overflow-hidden" id="methods-container">
                    @foreach($paymentMethods as $index => $method)
                    <label class="block relative group {{ count($paymentMethods) == 1 ? 'single-method' : '' }}">
                        <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="peer absolute opacity-0" required {{ $index === 0 ? 'checked' : '' }}
                            onchange="showInstructions('instruction-{{ $method->id }}')">
                        
                        <div class="payment-method-wrapper cursor-pointer">
                            <div class="payment-method-card flex items-center gap-3">
                                <div class="radio-dot"></div>
                                <div class="flex-1 font-medium text-sm text-gray-900">{{ $method->name }}</div>
                            </div>
                        </div>

                        <!-- Instructions Block (Expands below the selected radio) -->
                        <div id="instruction-{{ $method->id }}" class="instruction-body hidden bg-[#fafafa] border-x border-b border-gray-200 p-4 pt-1 mb-[1px]">
                            <div class="text-xs text-gray-600 space-y-2">
                                <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                    <span>Account Title</span>
                                    <span class="font-semibold text-gray-900">{{ $method->account_title }}</span>
                                </div>
                                <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                    <span>Account No.</span>
                                    <span class="font-semibold text-gray-900 bg-gray-200 px-1.5 py-0.5 rounded">{{ $method->account_number }}</span>
                                </div>
                                @if($method->instructions)
                                    <div class="pt-1 text-gray-500 leading-relaxed">{{ $method->instructions }}</div>
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach
                    @error('payment_method_id')<p class="text-red-500 text-xs mt-1 px-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Proof of Payment (Stripe-like clean fields) -->
            <div class="mb-8 p-4 rounded-md border border-gray-200 bg-gray-50">
                <h2 class="text-[14px] font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Payment Verification
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <input type="text" name="transaction_hash" placeholder="Transaction ID (e.g. 05442531393)" required class="ha-input" value="{{ old('transaction_hash') }}">
                        @error('transaction_hash')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="file-upload-btn focus-within:ring-2 focus-within:ring-black">
                            <span>Upload Screenshot</span>
                            <input type="file" name="screenshot" accept=".jpg,.jpeg,.png,.pdf" required class="sr-only" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen'">
                        </label>
                        <span id="file-name" class="text-xs text-gray-500 truncate max-w-[200px]">No file chosen</span>
                    </div>
                    <p class="text-[11px] text-gray-500">Max 5MB (JPG, PNG, PDF)</p>
                    @error('screenshot')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pb-10">
                <button type="submit" class="btn-submit">
                    Subscribe
                </button>
                <p class="text-center text-[11px] text-gray-500 mt-4 px-4 leading-relaxed">
                    By subscribing, you authorize HA Tech to verify your pending payment. Manual verification may take up to 2-12 hours before your license is generated.
                </p>
                <div class="flex justify-center items-center gap-4 text-[11px] text-gray-400 mt-4 font-medium">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-2h2v2h-2zm0-4V7h2v6h-2z"/></svg>
                        Secure Checkout
                    </span>
                    <span class="text-gray-300">|</span>
                    <span>Terms</span>
                    <span class="text-gray-300">|</span>
                    <span>Privacy</span>
                </div>
            </div>
        </form>
    </div>

    <!-- Live Rate Script & UI Logic -->
    <script>
        function showInstructions(id) {
            document.querySelectorAll('.instruction-body').forEach(el => el.classList.add('hidden'));
            const target = document.getElementById(id);
            if(target) target.classList.remove('hidden');
        }

        // Initialize first selected method expansion
        document.addEventListener('DOMContentLoaded', () => {
            const checkedRadio = document.querySelector('input[name="payment_method_id"]:checked');
            if(checkedRadio) {
                const id = checkedRadio.getAttribute('onchange').match(/'([^']+)'/)[1];
                showInstructions(id);
            }
        });

        // Live Rate API
        async function fetchRate() {
            let rate = 278; // Fallback
            try {
                const res = await fetch('https://open.er-api.com/v6/latest/USD');
                const data = await res.json();
                if (data?.rates?.PKR) rate = data.rates.PKR;
            } catch(e) {}
            
            const usd = {{ (float) $plan->price_usd }};
            const pkr = Math.round(usd * rate);
            
            document.getElementById('exchange-rate-note').textContent = `Live rate: 1 USD = ${rate.toFixed(2)} PKR`;
            document.getElementById('main-pkr-price').textContent = pkr.toLocaleString('en-PK');
            document.getElementById('summary-pkr').textContent = 'Rs ' + pkr.toLocaleString('en-PK');
            
            document.getElementById('amount_pkr_input').value = pkr;
            document.getElementById('exchange_rate_input').value = rate;
        }
        
        fetchRate();
        setInterval(fetchRate, 60000);
    </script>
</body>
</html>
