<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    // Clear cache whenever a setting is created, updated, or deleted
    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget('global_settings');
        });

        static::deleted(function ($setting) {
            Cache::forget('global_settings');
        });
    }

    /**
     * Get a cached setting value by key
     */
    public static function get($key, $default = null)
    {
        try {
            $settings = Cache::rememberForever('global_settings', function () {
                return self::pluck('value', 'key')->toArray();
            });

            return $settings[$key] ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}
