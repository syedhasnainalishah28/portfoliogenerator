<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\LicenseIssuedMail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'plan', 'paymentMethod'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'plan', 'paymentMethod', 'license']);
        return view('admin.orders.show', compact('order'));
    }

    public function approve(Request $request, Order $order)
    {
        abort_if($order->status !== 'pending', 422, 'Order is not pending.');

        // Generate license
        $license = License::create([
            'user_id'              => $order->user_id,
            'plan_id'              => $order->plan_id,
            'license_key'          => License::generateKey(),
            'is_used'              => true,
            'activated_at'         => now(),
            'expires_at'           => now()->addMonths((int) $order->plan->duration_months),
            'is_manually_generated'=> false,
            'generated_by_admin'   => Auth::guard('admin')->id(),
        ]);

        // Update order
        $order->update([
            'status'      => 'approved',
            'license_id'  => $license->id,
            'approved_at' => now(),
            'admin_note'  => $request->admin_note,
        ]);

        // Update user
        $order->user->update([
            'license_id'         => $license->id,
            'license_expires_at' => $license->expires_at,
        ]);

        // Dispatch Email
        Mail::to($order->user->email)->send(new LicenseIssuedMail($order->user, $license));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order approved. License key: ' . $license->license_key . ' (Email Sent)');
    }

    public function reject(Request $request, Order $order)
    {
        abort_if($order->status !== 'pending', 422, 'Order is not pending.');

        $order->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order rejected.');
    }

    public function screenshot(Order $order)
    {
        abort_if(!$order->screenshot_path, 404);
        return Storage::disk('local')->response($order->screenshot_path);
    }
}
