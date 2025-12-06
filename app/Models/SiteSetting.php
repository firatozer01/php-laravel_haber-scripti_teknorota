<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $guarded = [];

    // Helper to get value
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? ($setting->value ?? $setting->image) : $default;
    }
}
