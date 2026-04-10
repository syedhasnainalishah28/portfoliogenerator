<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'account_title', 'account_number', 'logo', 'instructions', 'is_active'];

    public function orders() { return $this->hasMany(Order::class); }
}
