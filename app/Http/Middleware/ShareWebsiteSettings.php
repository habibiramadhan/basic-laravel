<?php
// app/Http/Middleware/ShareWebsiteSettings.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ShareWebsiteSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = Cache::remember('website_settings', 3600, function () {
            return WebsiteSetting::getAll();
        });
        
        View::share('websiteSettings', $settings);
        
        return $next($request);
    }
}