<?php
// app/Models/Pembayaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pemesanan_id',
        'metode_pembayaran',
        'bukti_transfer',
        'jumlah_bayar',
        'tanggal_bayar',
        'status_bayar',
        'catatan',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'verified_at' => 'datetime',
        'jumlah_bayar' => 'decimal:2'
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function getBuktiTransferUrlAttribute()
    {
        return $this->bukti_transfer ? Storage::url($this->bukti_transfer) : null;
    }

    public function getJumlahBayarFormattedAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_bayar, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-warning',
            'verified' => 'bg-success',
            'rejected' => 'bg-danger'
        ];

        return $badges[$this->status_bayar] ?? 'bg-secondary';
    }

    public function getMetodeBadgeAttribute()
    {
        if ($this->metode_pembayaran === 'upload_transfer') {
            return '<span class="badge bg-primary"><i class="fa fa-upload"></i> Upload Transfer</span>';
        }
        
        return '<span class="badge bg-success"><i class="fab fa-whatsapp"></i> WhatsApp</span>';
    }

    public function isUploadMethod()
    {
        return $this->metode_pembayaran === 'upload_transfer';
    }

    public function isWhatsappMethod()
    {
        return $this->metode_pembayaran === 'whatsapp_confirm';
    }

    public function isPending()
    {
        return $this->status_bayar === 'pending';
    }

    public function isVerified()
    {
        return $this->status_bayar === 'verified';
    }

    public function scopePending($query)
    {
        return $query->where('status_bayar', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status_bayar', 'verified');
    }
}