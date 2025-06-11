<?php
// app/Models/Pemesanan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'kode_booking',
        'user_id',
        'alat_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_hari',
        'harga_per_hari',
        'total_harga',
        'lokasi_penggunaan',
        'catatan',
        'status_pemesanan',
        'contact_admin'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'harga_per_hari' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alat()
    {
        return $this->belongsTo(AlatBerat::class, 'alat_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pemesanan_id');
    }

    public function pembayaranAktif()
    {
        return $this->hasOne(Pembayaran::class, 'pemesanan_id')->latest();
    }

    public static function generateKodeBooking()
    {
        $today = Carbon::today();
        $count = static::whereDate('created_at', $today)->count() + 1;
        return 'SWA' . $today->format('Ymd') . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    public function getTotalHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-warning',
            'dikonfirmasi' => 'bg-success',
            'berlangsung' => 'bg-primary',
            'selesai' => 'bg-secondary',
            'dibatalkan' => 'bg-danger'
        ];

        return $badges[$this->status_pemesanan] ?? 'bg-secondary';
    }

    public function scopePending($query)
    {
        return $query->where('status_pemesanan', 'pending');
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status_pemesanan', ['dikonfirmasi', 'berlangsung']);
    }

    public function hitungDurasi()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }

    public function hitungTotalHarga()
    {
        return $this->durasi_hari * $this->harga_per_hari;
    }
}