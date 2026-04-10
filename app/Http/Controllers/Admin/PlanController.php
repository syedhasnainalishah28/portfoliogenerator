<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PlanController extends Controller
{
    public function index()
    {
        $plans          = Plan::all();
        $paymentMethods = PaymentMethod::all();
        return view('admin.settings', compact('plans', 'paymentMethods'));
    }

    public function updatePlan(Request $request, Plan $plan)
    {
        $request->validate(['price_usd' => 'required|numeric|min:0']);
        $plan->update(['price_usd' => $request->price_usd]);
        return back()->with('success', 'Plan price updated successfully.');
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'account_title'  => 'required|string|max:200',
            'account_number' => 'required|string|max:100',
            'instructions'   => 'nullable|string',
        ]);

        PaymentMethod::create($request->only('name', 'account_title', 'account_number', 'instructions') + ['is_active' => true]);
        return back()->with('success', 'Payment method added.');
    }

    public function updatePaymentMethod(Request $request, PaymentMethod $method)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'account_title'  => 'required|string|max:200',
            'account_number' => 'required|string|max:100',
            'instructions'   => 'nullable|string',
            'is_active'      => 'boolean',
        ]);

        $method->update($request->only('name', 'account_title', 'account_number', 'instructions') + ['is_active' => $request->boolean('is_active')]);
        return back()->with('success', 'Payment method updated.');
    }

    public function destroyPaymentMethod(PaymentMethod $method)
    {
        $method->delete();
        return back()->with('success', 'Payment method removed.');
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        try {
            Mail::raw('This is a test email sent from the HA Tech Admin Console. If you are reading this, your SMTP configuration is perfectly fine!', function($msg) use ($request) {
                $msg->to($request->email)->subject('HA Tech — Test Configuration Email');
            });
            return back()->with('success', 'Test email dispatched successfully to ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Mail Error: ' . $e->getMessage());
        }
    }
}
