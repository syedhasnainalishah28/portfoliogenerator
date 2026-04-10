<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenseController extends Controller
{
    public function show()
    {
        if (Auth::user()->hasActiveLicense()) {
            return redirect()->route('dashboard');
        }
        return view('license.activate');
    }

    public function activate(Request $request)
    {
        $request->validate(['license_key' => 'required|string']);

        $key     = strtoupper(trim($request->license_key));
        $license = License::where('license_key', $key)->first();

        if (!$license) {
            return back()->withErrors(['license_key' => 'Invalid license key. Please check and try again.']);
        }

        if ($license->is_used && $license->user_id !== Auth::id()) {
            return back()->withErrors(['license_key' => 'This license key has already been used.']);
        }

        if ($license->isExpired()) {
            return back()->withErrors(['license_key' => 'This license key has expired. Please contact support.']);
        }

        $plan      = $license->plan;
        $expiresAt = now()->addMonths($plan->duration_months);

        // Bind license to user
        $license->update([
            'is_used'      => true,
            'user_id'      => Auth::id(),
            'activated_at' => now(),
            'expires_at'   => $expiresAt,
        ]);

        Auth::user()->update([
            'license_id'         => $license->id,
            'license_expires_at' => $expiresAt,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'License activated! Welcome to HA Tech. Your access is valid until ' . $expiresAt->format('d M Y') . '.');
    }
}
