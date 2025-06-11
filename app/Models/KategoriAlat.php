<?php
// app/Models/KategoriAlat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAlat extends Model
{
    use HasFactory;

    protected $table = 'kategori_alat';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    public function alatBerat()
    {
        return $this->hasMany(AlatBerat::class, 'kategori_id');
    }

    public function alatTersedia()
    {
        return $this->hasMany(AlatBerat::class, 'kategori_id')->where('status', 'tersedia');
    }
}