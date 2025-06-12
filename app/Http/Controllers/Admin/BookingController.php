<?php
// app/Http/Controllers/Admin/BookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\AlatBerat;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['user', 'alat.kategori', 'pembayaranAktif']);
        
        if ($request->filled('search')) {
            $query->where('kode_booking', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('alat', function($q) use ($request) {
                      $q->where('nama_alat', 'like', '%' . $request->search . '%');
                  });
        }
        
        if ($request->filled('status')) {
            $query->where('status_pemesanan', $request->status);
        }
        
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        
        if ($request->filled('alat')) {
            $query->where('alat_id', $request->alat);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $alats = AlatBerat::select('id', 'nama_alat')->get();
        
        $stats = [
            'total' => Pemesanan::count(),
            'pending' => Pemesanan::where('status_pemesanan', 'pending')->count(),
            'dikonfirmasi' => Pemesanan::where('status_pemesanan', 'dikonfirmasi')->count(),
            'berlangsung' => Pemesanan::where('status_pemesanan', 'berlangsung')->count(),
            'selesai' => Pemesanan::where('status_pemesanan', 'selesai')->count(),
        ];
        
        return view('admin.booking.index', compact('bookings', 'alats', 'stats'));
    }
    
    public function show(Pemesanan $booking)
    {
        $booking->load(['user', 'alat.kategori', 'pembayaran' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return view('admin.booking.show', compact('booking'));
    }
    
    public function updateStatus(Request $request, Pemesanan $booking)
    {
        $validated = $request->validate([
            'status_pemesanan' => 'required|in:pending,dikonfirmasi,berlangsung,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        $oldStatus = $booking->status_pemesanan;
        $newStatus = $validated['status_pemesanan'];
        
        if ($oldStatus == 'dikonfirmasi' && $newStatus == 'berlangsung') {
            $booking->alat->update(['status' => 'disewa']);
        }
        
        if ($newStatus == 'selesai') {
            $booking->alat->update(['status' => 'tersedia']);
        }
        
        if ($newStatus == 'dibatalkan') {
            $booking->alat->update(['status' => 'tersedia']);
        }
        
        $booking->update($validated);
        
        $statusMessages = [
            'dikonfirmasi' => 'Booking telah dikonfirmasi',
            'berlangsung' => 'Booking sedang berlangsung, alat sudah digunakan',
            'selesai' => 'Booking selesai, alat sudah dikembalikan',
            'dibatalkan' => 'Booking dibatalkan'
        ];
        
        $message = $statusMessages[$newStatus] ?? 'Status booking berhasil diperbarui';
        
        return redirect()->back()->with('success', $message);
    }
    
    public function destroy(Pemesanan $booking)
    {
        if (in_array($booking->status_pemesanan, ['berlangsung', 'selesai'])) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus booking yang sedang berlangsung atau sudah selesai');
        }
        
        if ($booking->status_pemesanan == 'dikonfirmasi') {
            $booking->alat->update(['status' => 'tersedia']);
        }
        
        $booking->delete();
        
        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dihapus');
    }
    
    public function whatsappCustomer(Pemesanan $booking)
    {
        $customer = $booking->user;
        $message = "Halo {$customer->nama_lengkap},\n\n";
        $message .= "Mengenai booking Anda:\n";
        $message .= "Kode: {$booking->kode_booking}\n";
        $message .= "Alat: {$booking->alat->nama_alat}\n";
        $message .= "Periode: {$booking->tanggal_mulai->format('d/m/Y')} - {$booking->tanggal_selesai->format('d/m/Y')}\n\n";
        $message .= "Silakan hubungi kami jika ada yang ingin ditanyakan. Terima kasih.";
        
        $waNumber = preg_replace('/[^0-9]/', '', $customer->no_telepon);
        if (substr($waNumber, 0, 1) == '0') {
            $waNumber = '62' . substr($waNumber, 1);
        }
        
        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
        
        return redirect()->away($waLink);
    }
    
    public function export(Request $request)
    {
        $query = Pemesanan::with(['user', 'alat.kategori']);
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('status')) {
            $query->where('status_pemesanan', $request->status);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'booking_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Kode Booking',
                'Customer',
                'No. Telepon',
                'Alat',
                'Kategori',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Durasi (Hari)',
                'Harga per Hari',
                'Total Harga',
                'Status',
                'Lokasi',
                'Tanggal Booking'
            ]);
            
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->kode_booking,
                    $booking->user->nama_lengkap,
                    $booking->user->no_telepon,
                    $booking->alat->nama_alat,
                    $booking->alat->kategori->nama_kategori,
                    $booking->tanggal_mulai->format('d/m/Y'),
                    $booking->tanggal_selesai->format('d/m/Y'),
                    $booking->durasi_hari,
                    number_format($booking->harga_per_hari, 0),
                    number_format($booking->total_harga, 0),
                    ucfirst($booking->status_pemesanan),
                    $booking->lokasi_penggunaan,
                    $booking->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}