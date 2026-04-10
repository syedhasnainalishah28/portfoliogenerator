<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $query = License::with(['user', 'plan'])->latest();

        if ($request->filled('search')) {
            $query->where('license_key', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%'));
        }

        if ($request->filled('status')) {
            match ($request->status) {
                'active'  => $query->where('is_used', true)->whereDate('expires_at', '>=', now()),
                'expired' => $query->where('is_used', true)->whereDate('expires_at', '<', now()),
                'unused'  => $query->where('is_used', false),
                default   => null,
            };
        }

        $licenses = $query->paginate(20);
        return view('admin.licenses.index', compact('licenses'));
    }

    public function generate()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('admin.licenses.generate', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate(['plan_id' => 'required|exists:plans,id']);

        $plan    = Plan::findOrFail($request->plan_id);
        $license = License::create([
            'user_id'               => null,
            'plan_id'               => $plan->id,
            'license_key'           => License::generateKey(),
            'is_used'               => false,
            'is_manually_generated' => true,
            'generated_by_admin'    => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.licenses.index')
            ->with('new_license_key', $license->license_key)
            ->with('success', 'Manual license generated for plan: ' . $plan->name);
    }

    public function extend(Request $request, License $license)
    {
        $request->validate(['months' => 'required|integer|min:1|max:24']);

        $base = $license->expires_at && $license->expires_at->isFuture()
            ? $license->expires_at
            : now();

        $newExpiry = $base->copy()->addMonths($request->months);

        $license->update(['expires_at' => $newExpiry]);

        if ($license->user) {
            $license->user->update(['license_expires_at' => $newExpiry]);
        }

        return back()->with('success', 'License extended until ' . $newExpiry->format('d M Y'));
    }

    public function expire(License $license)
    {
        $license->update(['expires_at' => now()->subSecond()]);

        if ($license->user) {
            $license->user->update(['license_expires_at' => now()->subSecond()]);
        }

        return back()->with('success', 'License expired immediately.');
    }
}
