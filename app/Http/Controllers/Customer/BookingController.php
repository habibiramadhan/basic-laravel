<?php
// app/Http/Controllers/Customer/BookingController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\AlatBerat;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Pemesanan::with(['alat', 'pembayaranAktif'])
                             ->where('user_id', auth()->id())
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);
        
        return view('customer.booking.index', compact('bookings'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alat_berat,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'lokasi_penggunaan' => 'required|string|max:500',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'alat_id.required' => 'Alat harus dipilih',
            'alat_id.exists' => 'Alat tidak ditemukan',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'lokasi_penggunaan.required' => 'Lokasi penggunaan wajib diisi',
        ]);
        
        $alat = AlatBerat::findOrFail($request->alat_id);
        
        if ($alat->status !== 'tersedia') {
            return back()->with('error', 'Alat sedang tidak tersedia');
        }
        
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $durasi = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
        $totalHarga = $durasi * $alat->harga_per_hari;
        
        $booking = Pemesanan::create([
            'kode_booking' => Pemesanan::generateKodeBooking(),
            'user_id' => auth()->id(),
            'alat_id' => $alat->id,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'durasi_hari' => $durasi,
            'harga_per_hari' => $alat->harga_per_hari,
            'total_harga' => $totalHarga,
            'lokasi_penggunaan' => $request->lokasi_penggunaan,
            'catatan' => $request->catatan,
            'contact_admin' => setting('whatsapp_number'),
        ]);
        
        return redirect()->route('customer.booking.payment', $booking->id)
                        ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }
    
    public function show($id)
    {
        $booking = Pemesanan::with(['alat', 'pembayaran'])
                            ->where('user_id', auth()->id())
                            ->findOrFail($id);
        
        return view('customer.booking.show', compact('booking'));
    }
    
    public function payment($id)
    {
        $booking = Pemesanan::with('alat')
                            ->where('user_id', auth()->id())
                            ->findOrFail($id);
        
        if ($booking->status_pemesanan !== 'pending') {
            return redirect()->route('customer.booking.show', $booking->id)
                           ->with('info', 'Booking ini sudah diproses.');
        }
        
        return view('customer.booking.payment', compact('booking'));
    }
}