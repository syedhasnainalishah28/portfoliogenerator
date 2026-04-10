<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'slug', 'duration_months', 'price_usd', 'is_active'];

    public function licenses() { return $this->hasMany(License::class); }
    public function orders()   { return $this->hasMany(Order::class); }

    public function getPricePkrAttribute(): string
    {
        // Estimated display — actual rate fetched on frontend
        return 'PKR ' . number_format($this->price_usd * 278, 0);
    }
}
