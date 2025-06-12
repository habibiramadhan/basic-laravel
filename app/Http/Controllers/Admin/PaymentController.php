<?php
// app/Http/Controllers/Admin/PaymentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['pemesanan.user', 'pemesanan.alat']);
        
        if ($request->filled('search')) {
            $query->whereHas('pemesanan', function($q) use ($request) {
                $q->where('kode_booking', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('nama_lengkap', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status_bayar', $request->status);
        }
        
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }
        
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        
        $payments = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'total' => Pembayaran::count(),
            'pending' => Pembayaran::where('status_bayar', 'pending')->count(),
            'verified' => Pembayaran::where('status_bayar', 'verified')->count(),
            'rejected' => Pembayaran::where('status_bayar', 'rejected')->count(),
            'upload_transfer' => Pembayaran::where('metode_pembayaran', 'upload_transfer')->count(),
            'whatsapp_confirm' => Pembayaran::where('metode_pembayaran', 'whatsapp_confirm')->count(),
        ];
        
        return view('admin.payment.index', compact('payments', 'stats'));
    }
    
    public function show(Pembayaran $payment)
    {
        $payment->load(['pemesanan.user', 'pemesanan.alat.kategori']);
        return view('admin.payment.show', compact('payment'));
    }
    
    public function verify(Request $request, Pembayaran $payment)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        if ($validated['action'] == 'approve') {
            $payment->update([
                'status_bayar' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->user()->nama_lengkap,
                'catatan' => $validated['catatan'] ?? null
            ]);
            
            $payment->pemesanan->update(['status_pemesanan' => 'dikonfirmasi']);
            
            $message = 'Pembayaran berhasil diverifikasi dan booking dikonfirmasi';
        } else {
            $payment->update([
                'status_bayar' => 'rejected',
                'catatan' => $validated['catatan'] ?? 'Pembayaran ditolak oleh admin'
            ]);
            
            $message = 'Pembayaran ditolak';
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    public function updateStatus(Request $request, Pembayaran $payment)
    {
        $validated = $request->validate([
            'status_bayar' => 'required|in:pending,verified,rejected',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        $oldStatus = $payment->status_bayar;
        $newStatus = $validated['status_bayar'];
        
        if ($newStatus == 'verified' && $oldStatus != 'verified') {
            $validated['verified_at'] = now();
            $validated['verified_by'] = auth()->user()->nama_lengkap;
            
            $payment->pemesanan->update(['status_pemesanan' => 'dikonfirmasi']);
        }
        
        $payment->update($validated);
        
        $statusMessages = [
            'verified' => 'Pembayaran diverifikasi, booking dikonfirmasi',
            'rejected' => 'Pembayaran ditolak',
            'pending' => 'Status dikembalikan ke pending'
        ];
        
        $message = $statusMessages[$newStatus] ?? 'Status pembayaran berhasil diperbarui';
        
        return redirect()->back()->with('success', $message);
    }
    
    public function destroy(Pembayaran $payment)
    {
        if ($payment->status_bayar == 'verified') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus pembayaran yang sudah diverifikasi');
        }
        
        if ($payment->bukti_transfer) {
            Storage::disk('public')->delete($payment->bukti_transfer);
        }
        
        $payment->delete();
        
        return redirect()->route('admin.payment.index')->with('success', 'Data pembayaran berhasil dihapus');
    }
    
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:verify,reject,delete',
            'payment_ids' => 'required|array',
            'payment_ids.*' => 'exists:pembayaran,id',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        $payments = Pembayaran::whereIn('id', $validated['payment_ids'])->get();
        $count = 0;
        
        foreach ($payments as $payment) {
            if ($validated['action'] == 'verify' && $payment->status_bayar == 'pending') {
                $payment->update([
                    'status_bayar' => 'verified',
                    'verified_at' => now(),
                    'verified_by' => auth()->user()->nama_lengkap,
                    'catatan' => $validated['catatan'] ?? null
                ]);
                
                $payment->pemesanan->update(['status_pemesanan' => 'dikonfirmasi']);
                $count++;
            } elseif ($validated['action'] == 'reject' && $payment->status_bayar == 'pending') {
                $payment->update([
                    'status_bayar' => 'rejected',
                    'catatan' => $validated['catatan'] ?? 'Pembayaran ditolak secara bulk'
                ]);
                $count++;
            } elseif ($validated['action'] == 'delete' && $payment->status_bayar != 'verified') {
                if ($payment->bukti_transfer) {
                    Storage::disk('public')->delete($payment->bukti_transfer);
                }
                $payment->delete();
                $count++;
            }
        }
        
        $actionMessages = [
            'verify' => "berhasil diverifikasi",
            'reject' => "berhasil ditolak", 
            'delete' => "berhasil dihapus"
        ];
        
        $message = "{$count} pembayaran {$actionMessages[$validated['action']]}";
        
        return redirect()->back()->with('success', $message);
    }
    
    public function export(Request $request)
    {
        $query = Pembayaran::with(['pemesanan.user', 'pemesanan.alat']);
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('status')) {
            $query->where('status_bayar', $request->status);
        }
        
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }
        
        $payments = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'payment_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'ID Payment',
                'Kode Booking',
                'Customer',
                'No. Telepon',
                'Alat',
                'Metode Pembayaran',
                'Jumlah Bayar',
                'Status',
                'Tanggal Bayar',
                'Verified At',
                'Verified By',
                'Catatan'
            ]);
            
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->pemesanan->kode_booking,
                    $payment->pemesanan->user->nama_lengkap,
                    $payment->pemesanan->user->no_telepon,
                    $payment->pemesanan->alat->nama_alat,
                    $payment->metode_pembayaran == 'upload_transfer' ? 'Upload Transfer' : 'WhatsApp Konfirmasi',
                    number_format($payment->jumlah_bayar, 0),
                    ucfirst($payment->status_bayar),
                    $payment->tanggal_bayar->format('d/m/Y'),
                    $payment->verified_at ? $payment->verified_at->format('d/m/Y H:i') : '-',
                    $payment->verified_by ?? '-',
                    $payment->catatan ?? '-'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}