<?php
// database/seeders/KategoriAlatSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriAlat;

class KategoriAlatSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            [
                'nama_kategori' => 'Excavator',
                'deskripsi' => 'Alat berat untuk penggalian dan pemindahan tanah'
            ],
            [
                'nama_kategori' => 'Bulldozer',
                'deskripsi' => 'Alat berat untuk mendorong dan meratakan tanah'
            ],
            [
                'nama_kategori' => 'Wheel Loader',
                'deskripsi' => 'Alat berat untuk memuat dan memindahkan material'
            ],
            [
                'nama_kategori' => 'Crane',
                'deskripsi' => 'Alat angkat untuk konstruksi bangunan tinggi'
            ],
            [
                'nama_kategori' => 'Dump Truck',
                'deskripsi' => 'Kendaraan untuk mengangkut material dalam jumlah besar'
            ],
            [
                'nama_kategori' => 'Compactor',
                'deskripsi' => 'Alat untuk memadatkan tanah dan aspal'
            ]
        ];

        foreach ($kategoris as $kategori) {
            KategoriAlat::create($kategori);
        }
    }
}