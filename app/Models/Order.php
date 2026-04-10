<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'license_id', 'order_number',
        'amount_usd', 'amount_pkr', 'exchange_rate',
        'payment_method_id', 'transaction_hash', 'screenshot_path',
        'status', 'admin_note', 'approved_at',
    ];

    protected $casts = ['approved_at' => 'datetime'];

    public function user()          { return $this->belongsTo(User::class); }
    public function plan()          { return $this->belongsTo(Plan::class); }
    public function license()       { return $this->belongsTo(License::class); }
    public function paymentMethod() { return $this->belongsTo(PaymentMethod::class); }

    public static function generateOrderNumber(): string
    {
        $year  = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'HA-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'green',
            'rejected' => 'red',
            default    => 'yellow',
        };
    }
}
