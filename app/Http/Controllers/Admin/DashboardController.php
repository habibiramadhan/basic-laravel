<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlatBerat;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $stats = [
            'total_alat' => AlatBerat::count(),
            'alat_tersedia' => AlatBerat::where('status', 'tersedia')->count(),
            'alat_disewa' => AlatBerat::where('status', 'disewa')->count(),
            'total_customer' => User::where('role', 'customer')->count(),
            'booking_hari_ini' => Pemesanan::whereDate('created_at', $today)->count(),
            'booking_pending' => Pemesanan::where('status_pemesanan', 'pending')->count(),
            'booking_berlangsung' => Pemesanan::where('status_pemesanan', 'berlangsung')->count(),
            'revenue_bulan_ini' => Pemesanan::whereMonth('created_at', $today->month)
                                           ->whereYear('created_at', $today->year)
                                           ->where('status_pemesanan', '!=', 'dibatalkan')
                                           ->sum('total_harga')
        ];
        
        $recent_bookings = Pemesanan::with(['user', 'alat'])
                                   ->orderBy('created_at', 'desc')
                                   ->limit(5)
                                   ->get();
        
        $alat_populer = AlatBerat::withCount(['pemesanan'])
                                ->orderBy('pemesanan_count', 'desc')
                                ->limit(5)
                                ->get();
        
        return view('admin.dashboard', compact('stats', 'recent_bookings', 'alat_populer'));
    }
}