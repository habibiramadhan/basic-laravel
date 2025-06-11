<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'nama_lengkap' => 'Administrator System',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'no_telepon' => '+62812-3456-7890',
            'alamat' => 'Jl. Raya Bogor No. 123, Jakarta',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'bibi',
            'nama_lengkap' => 'bibi Demo',
            'email' => 'bibi@bibi.com',
            'password' => Hash::make('bibi123'),
            'no_telepon' => '+62813-9876-5432',
            'alamat' => 'Jl. bibi Demo No. 456, Bogor',
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}