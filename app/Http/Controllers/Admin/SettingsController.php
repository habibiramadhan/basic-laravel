<?php
// app/Http/Controllers/Admin/SettingsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $rules = [
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:500',
            'whatsapp_number' => 'nullable|string|max:20',
            'bank_name' => 'required|string|max:100',
            'bank_account' => 'required|string|max:50',
            'bank_holder' => 'required|string|max:255',
            'footer_copyright' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'operational_hours' => 'nullable|string|max:255',
            'service_area' => 'nullable|string|max:255',
        ];
        
        $validated = $request->validate($rules);
        
        foreach ($validated as $key => $value) {
            WebsiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        
        Cache::forget('website_settings');
        
        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}