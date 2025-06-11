<?php
// app/Models/AlatBerat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AlatBerat extends Model
{
    use HasFactory;

    protected $table = 'alat_berat';

    protected $fillable = [
        'kategori_id',
        'nama_alat',
        'merk',
        'model',
        'harga_per_hari',
        'foto_utama',
        'spesifikasi',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'harga_per_hari' => 'decimal:2'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAlat::class, 'kategori_id');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'alat_id');
    }

    public function getFotoUtamaUrlAttribute()
    {
        return $this->foto_utama ? Storage::url($this->foto_utama) : '/assets/img/no-image.jpg';
    }

    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_per_hari, 0, ',', '.');
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    public function isTersedia()
    {
        return $this->status === 'tersedia';
    }
}