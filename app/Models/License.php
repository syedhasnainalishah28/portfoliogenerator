<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class License extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'license_key', 'is_used',
        'activated_at', 'expires_at', 'is_manually_generated', 'generated_by_admin'
    ];

    protected $casts = [
        'is_used'                => 'boolean',
        'is_manually_generated'  => 'boolean',
        'activated_at'           => 'datetime',
        'expires_at'             => 'datetime',
    ];

    public function user()  { return $this->belongsTo(User::class); }
    public function plan()  { return $this->belongsTo(Plan::class); }
    public function order() { return $this->hasOne(Order::class); }
    public function admin() { return $this->belongsTo(Admin::class, 'generated_by_admin'); }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isActive(): bool
    {
        return $this->is_used && !$this->isExpired();
    }

    public function getStatusBadgeAttribute(): string
    {
        if (!$this->is_used)   return 'unused';
        if ($this->isExpired()) return 'expired';
        return 'active';
    }

    public static function generateKey(): string
    {
        do {
            $key = 'HATK-' .
                strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4)) . '-' .
                strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4)) . '-' .
                strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));
        } while (self::where('license_key', $key)->exists());

        return $key;
    }
}
