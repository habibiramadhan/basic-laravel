<?php
// app/helpers.php

use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            return WebsiteSetting::get($key, $default);
        });
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('whatsappUrl')) {
    function whatsappUrl($message = '')
    {
        $number = setting('whatsapp_number', '628123456789');
        return "https://wa.me/{$number}" . ($message ? "?text=" . urlencode($message) : '');
    }
}