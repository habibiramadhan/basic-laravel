<?php
// app/Http/Controllers/Customer/PaymentController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Pemesanan;

class PaymentController extends Controller
{
    public function uploadTransfer(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:pemesanan,id',
            'bukti_transfer' => 'required|image|max:2048',
        ], [
            'booking_id.required' => 'Booking tidak ditemukan',
            'bukti_transfer.required' => 'Bukti transfer wajib diupload',
            'bukti_transfer.image' => 'File harus berupa gambar',
            'bukti_transfer.max' => 'Ukuran file maksimal 2MB',
        ]);
        
        $booking = Pemesanan::where('user_id', auth()->id())->findOrFail($request->booking_id);
        
        if ($booking->status_pemesanan !== 'pending') {
            return back()->with('error', 'Booking ini sudah diproses');
        }
        
        $path = $request->file('bukti_transfer')->store('payments', 'public');
        
        Pembayaran::create([
            'pemesanan_id' => $booking->id,
            'metode_pembayaran' => 'upload_transfer',
            'bukti_transfer' => $path,
            'jumlah_bayar' => $booking->total_harga,
            'tanggal_bayar' => now(),
            'status_bayar' => 'pending'
        ]);
        
        return redirect()->route('customer.dashboard')
                        ->with('success', 'Bukti transfer berhasil diupload. Menunggu verifikasi admin.');
    }
    
    public function whatsappConfirm(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:pemesanan,id',
        ]);
        
        $booking = Pemesanan::where('user_id', auth()->id())->findOrFail($request->booking_id);
        
        if ($booking->status_pemesanan !== 'pending') {
            return back()->with('error', 'Booking ini sudah diproses');
        }
        
        Pembayaran::create([
            'pemesanan_id' => $booking->id,
            'metode_pembayaran' => 'whatsapp_confirm',
            'jumlah_bayar' => $booking->total_harga,
            'tanggal_bayar' => now(),
            'status_bayar' => 'pending',
            'catatan' => 'Menunggu konfirmasi via WhatsApp'
        ]);
        
        $message = "Halo Admin, saya ingin konfirmasi pembayaran untuk:\n\n";
        $message .= "Kode Booking: {$booking->kode_booking}\n";
        $message .= "Alat: {$booking->alat->nama_alat}\n";
        $message .= "Total: Rp " . number_format($booking->total_harga) . "\n";
        $message .= "Periode: {$booking->tanggal_mulai->format('d/m/Y')} sampai {$booking->tanggal_selesai->format('d/m/Y')}\n\n";
        $message .= "Saya sudah transfer pembayaran. Mohon dikonfirmasi. Terima kasih.";
        
        $waNumber = setting('whatsapp_number', '628123456789');
        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
        
        return redirect()->away($waLink);
    }
}