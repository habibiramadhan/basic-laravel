<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\AlatBerat;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }
    
    public function bookingReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'nullable|in:pending,dikonfirmasi,berlangsung,selesai,dibatalkan',
            'format' => 'required|in:view,pdf'
        ]);
        
        // Jika view, redirect ke booking index dengan filter
        if ($request->format == 'view') {
            $params = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ];
            
            if ($request->filled('status')) {
                $params['status'] = $request->status;
            }
            
            return redirect()->route('admin.booking.index', $params);
        }
        
        // Jika PDF, generate laporan
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        $query = Pemesanan::with(['user', 'alat.kategori', 'pembayaranAktif'])
                          ->whereBetween('created_at', [$startDate, $endDate->endOfDay()]);
        
        if ($request->filled('status')) {
            $query->where('status_pemesanan', $request->status);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        $summary = [
            'total_booking' => $bookings->count(),
            'total_revenue' => $bookings->where('status_pemesanan', 'selesai')->sum('total_harga'),
            'pending' => $bookings->where('status_pemesanan', 'pending')->count(),
            'dikonfirmasi' => $bookings->where('status_pemesanan', 'dikonfirmasi')->count(),
            'berlangsung' => $bookings->where('status_pemesanan', 'berlangsung')->count(),
            'selesai' => $bookings->where('status_pemesanan', 'selesai')->count(),
            'dibatalkan' => $bookings->where('status_pemesanan', 'dibatalkan')->count(),
        ];
        
        $data = [
            'bookings' => $bookings,
            'summary' => $summary,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status_filter' => $request->status,
            'report_type' => 'Laporan Booking'
        ];
        
        $pdf = Pdf::loadView('admin.report.booking-pdf', $data);
        $filename = 'laporan-booking-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
    
    public function equipmentReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:view,pdf'
        ]);
        
        // Jika view, redirect ke equipment index
        if ($request->format == 'view') {
            return redirect()->route('admin.equipment.index');
        }
        
        // Jika PDF, generate laporan
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        $alats = AlatBerat::with(['kategori'])
                         ->withCount(['pemesanan as total_booking' => function($query) use ($startDate, $endDate) {
                             $query->whereBetween('created_at', [$startDate, $endDate->endOfDay()]);
                         }])
                         ->withSum(['pemesanan as total_revenue' => function($query) use ($startDate, $endDate) {
                             $query->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                                   ->where('status_pemesanan', 'selesai');
                         }], 'total_harga')
                         ->orderBy('total_booking', 'desc')
                         ->get();
        
        $summary = [
            'total_alat' => $alats->count(),
            'alat_tersedia' => $alats->where('status', 'tersedia')->count(),
            'alat_disewa' => $alats->where('status', 'disewa')->count(),
            'alat_maintenance' => $alats->where('status', 'maintenance')->count(),
            'total_booking' => $alats->sum('total_booking'),
            'total_revenue' => $alats->sum('total_revenue') ?? 0,
        ];
        
        $data = [
            'alats' => $alats,
            'summary' => $summary,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'report_type' => 'Laporan Performa Alat'
        ];
        
        $pdf = Pdf::loadView('admin.report.equipment-pdf', $data);
        $filename = 'laporan-alat-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
    
    public function paymentReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'metode' => 'nullable|in:upload_transfer,whatsapp_confirm',
            'status' => 'nullable|in:pending,verified,rejected',
            'format' => 'required|in:view,pdf'
        ]);
        
        // Jika view, redirect ke payment index dengan filter
        if ($request->format == 'view') {
            $params = [];
            
            if ($request->filled('metode')) {
                $params['metode'] = $request->metode;
            }
            
            if ($request->filled('status')) {
                $params['status'] = $request->status;
            }
            
            return redirect()->route('admin.payment.index', $params);
        }
        
        // Jika PDF, generate laporan
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        $query = Pembayaran::with(['pemesanan.user', 'pemesanan.alat'])
                          ->whereBetween('created_at', [$startDate, $endDate->endOfDay()]);
        
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }
        
        if ($request->filled('status')) {
            $query->where('status_bayar', $request->status);
        }
        
        $payments = $query->orderBy('created_at', 'desc')->get();
        
        $summary = [
            'total_payment' => $payments->count(),
            'total_amount' => $payments->sum('jumlah_bayar'),
            'verified_amount' => $payments->where('status_bayar', 'verified')->sum('jumlah_bayar'),
            'pending' => $payments->where('status_bayar', 'pending')->count(),
            'verified' => $payments->where('status_bayar', 'verified')->count(),
            'rejected' => $payments->where('status_bayar', 'rejected')->count(),
            'upload_transfer' => $payments->where('metode_pembayaran', 'upload_transfer')->count(),
            'whatsapp_confirm' => $payments->where('metode_pembayaran', 'whatsapp_confirm')->count(),
        ];
        
        $data = [
            'payments' => $payments,
            'summary' => $summary,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'metode_filter' => $request->metode,
            'status_filter' => $request->status,
            'report_type' => 'Laporan Pembayaran'
        ];
        
        $pdf = Pdf::loadView('admin.report.payment-pdf', $data);
        $filename = 'laporan-pembayaran-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
    
    public function customerReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:view,pdf'
        ]);
        
        // Jika view, redirect ke customer index
        if ($request->format == 'view') {
            return redirect()->route('admin.customer.index');
        }
        
        // Jika PDF, generate laporan
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        $customers = User::where('role', 'customer')
                        ->withCount(['pemesanan as total_booking' => function($query) use ($startDate, $endDate) {
                            $query->whereBetween('created_at', [$startDate, $endDate->endOfDay()]);
                        }])
                        ->withSum(['pemesanan as total_spent' => function($query) use ($startDate, $endDate) {
                            $query->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
                                  ->where('status_pemesanan', 'selesai');
                        }], 'total_harga')
                        ->having('total_booking', '>', 0)
                        ->orderBy('total_spent', 'desc')
                        ->get();
        
        $summary = [
            'total_customer_active' => $customers->count(),
            'total_booking' => $customers->sum('total_booking'),
            'total_revenue' => $customers->sum('total_spent') ?? 0,
            'avg_booking_per_customer' => $customers->count() > 0 ? round($customers->sum('total_booking') / $customers->count(), 2) : 0,
            'avg_spent_per_customer' => $customers->count() > 0 ? round(($customers->sum('total_spent') ?? 0) / $customers->count(), 0) : 0,
        ];
        
        $data = [
            'customers' => $customers,
            'summary' => $summary,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'report_type' => 'Laporan Customer'
        ];
        
        $pdf = Pdf::loadView('admin.report.customer-pdf', $data);
        $filename = 'laporan-customer-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}