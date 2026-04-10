<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Order;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'total_orders'     => Order::count(),
            'active_licenses'  => License::where('is_used', true)->whereDate('expires_at', '>=', now())->count(),
            'expired_licenses' => License::where('is_used', true)->whereDate('expires_at', '<', now())->count(),
            'total_licenses'   => License::count(),
            'revenue_usd'      => Order::where('status', 'approved')->sum('amount_usd'),
        ];

        $recentOrders = Order::with(['user', 'plan'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
