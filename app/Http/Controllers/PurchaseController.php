<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function plans()
    {
        $plans = Plan::where('is_active', true)->orderBy('duration_months')->get();
        return view('purchase.plans', compact('plans'));
    }

    public function payment(Plan $plan)
    {
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('purchase.payment', compact('plan', 'paymentMethods'));
    }

    public function submit(Request $request, Plan $plan)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'transaction_hash'  => 'required|string|max:255',
            'screenshot'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'amount_pkr'        => 'required|numeric',
            'exchange_rate'     => 'required|numeric',
        ]);

        $path = $request->file('screenshot')->store('payment-proofs', 'local');

        $order = Order::create([
            'user_id'           => Auth::id(),
            'plan_id'           => $plan->id,
            'order_number'      => Order::generateOrderNumber(),
            'amount_usd'        => $plan->price_usd,
            'amount_pkr'        => $request->amount_pkr,
            'exchange_rate'     => $request->exchange_rate,
            'payment_method_id' => $request->payment_method_id,
            'transaction_hash'  => $request->transaction_hash,
            'screenshot_path'   => $path,
            'status'            => 'pending',
        ]);

        return redirect()->route('purchase.receipt', $order)
            ->with('success', 'Order submitted! Your payment is under review.');
    }

    public function receipt(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        $order->load('plan', 'paymentMethod', 'license');
        return view('purchase.receipt', compact('order'));
    }
}
