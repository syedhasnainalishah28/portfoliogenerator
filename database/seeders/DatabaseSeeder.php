<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\PaymentMethod;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add default admin
        Admin::firstOrCreate(
            ['email' => 'admin@hatech.io'],
            [
                'name'     => 'Syed Hasnain',
                'password' => Hash::make('ha-secure-1234!!'),
            ]
        );

        // Add default plans if not exists
        $plans = [
            [
                'name'            => 'The Starter',
                'slug'            => 'starter',
                'duration_months' => 1,
                'price_usd'       => 9.00,
                'is_active'       => true,
            ],
            [
                'name'            => 'The Freelancer',
                'slug'            => 'freelancer',
                'duration_months' => 6,
                'price_usd'       => 39.00,
                'is_active'       => true,
            ],
            [
                'name'            => 'The Agency Boss',
                'slug'            => 'agency-boss',
                'duration_months' => 12,
                'price_usd'       => 59.00,
                'is_active'       => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::firstOrCreate(['slug' => $plan['slug']], $plan);
        }

        // Add default payment methods
        $methods = [
            [
                'name'           => 'JazzCash',
                'account_title'  => 'Syed Hasnain Ali Shah',
                'account_number' => '0300 0000000', // Update this
                'instructions'   => 'Transfer the exact PKR amount mentioned in the total. Write your email in the payment description if possible.',
                'is_active'      => true,
            ],
            [
                'name'           => 'Bank Transfer',
                'account_title'  => 'HA Tech / Syed Hasnain',
                'account_number' => 'PK00 BAAH 1234 5678 9012', // Update this
                'instructions'   => 'Local IBFT. Keep screenshot ready before submitting.',
                'is_active'      => true,
            ]
        ];

        foreach ($methods as $method) {
            PaymentMethod::firstOrCreate(['name' => $method['name']], $method);
        }
    }
}
