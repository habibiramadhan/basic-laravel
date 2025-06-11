<?php
// app/Models/WebsiteSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $table = 'website_settings';
    
    protected $fillable = ['key', 'value', 'type', 'description'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
    
    public static function getAll()
    {
        return Cache::remember('website_settings', 3600, function () {
            return static::pluck('value', 'key');
        });
    }
}