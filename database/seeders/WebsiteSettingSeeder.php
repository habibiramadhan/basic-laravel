<?php
// database/seeders/WebsiteSettingSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteSetting;

class WebsiteSettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Sewa Alat Berat', 'type' => 'text', 'description' => 'Nama Website'],
            ['key' => 'site_tagline', 'value' => 'Solusi Penyewaan Alat Berat Terpercaya', 'type' => 'text', 'description' => 'Tagline Website'],
            ['key' => 'contact_phone', 'value' => '+62 812-3456-7890', 'type' => 'phone', 'description' => 'Nomor Telepon'],
            ['key' => 'contact_email', 'value' => 'info@sewalat.com', 'type' => 'email', 'description' => 'Email Kontak'],
            ['key' => 'contact_address', 'value' => 'Jl. Raya Bogor No. 123, Jakarta Selatan', 'type' => 'textarea', 'description' => 'Alamat Lengkap'],
            ['key' => 'whatsapp_number', 'value' => '628123456789', 'type' => 'phone', 'description' => 'Nomor WhatsApp'],
            ['key' => 'bank_name', 'value' => 'Bank BCA', 'type' => 'text', 'description' => 'Nama Bank'],
            ['key' => 'bank_account', 'value' => '1234-5678-9012', 'type' => 'text', 'description' => 'Nomor Rekening'],
            ['key' => 'bank_holder', 'value' => 'PT Sewa Alat Berat Indonesia', 'type' => 'text', 'description' => 'Atas Nama Rekening'],
            ['key' => 'footer_copyright', 'value' => '© 2025 Sewa Alat Berat. All rights reserved.', 'type' => 'text', 'description' => 'Copyright Footer'],
            ['key' => 'hero_title', 'value' => 'Sewa Alat Berat Berkualitas', 'type' => 'text', 'description' => 'Judul Hero Homepage'],
            ['key' => 'hero_subtitle', 'value' => 'Dapatkan alat berat terbaik untuk proyek Anda dengan layanan terpercaya dan harga kompetitif.', 'type' => 'textarea', 'description' => 'Subjudul Hero'],
            ['key' => 'operational_hours', 'value' => 'Senin - Jumat: 08:00 - 17:00 WIB, Sabtu: 08:00 - 15:00 WIB', 'type' => 'text', 'description' => 'Jam Operasional'],
            ['key' => 'service_area', 'value' => 'Jakarta, Bogor, Depok, Tangerang, Bekasi (Jabodetabek)', 'type' => 'text', 'description' => 'Area Layanan'],
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::create($setting);
        }
    }
}