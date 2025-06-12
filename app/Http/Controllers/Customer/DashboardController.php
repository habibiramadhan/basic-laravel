<?php
// app/Http/Controllers/Customer/DashboardController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_booking' => Pemesanan::where('user_id', $user->id)->count(),
            'pending_booking' => Pemesanan::where('user_id', $user->id)->where('status_pemesanan', 'pending')->count(),
            'active_booking' => Pemesanan::where('user_id', $user->id)->whereIn('status_pemesanan', ['dikonfirmasi', 'berlangsung'])->count(),
            'completed_booking' => Pemesanan::where('user_id', $user->id)->where('status_pemesanan', 'selesai')->count(),
        ];
        
        $recentBookings = Pemesanan::with(['alat', 'pembayaranAktif'])
                                  ->where('user_id', $user->id)
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get();
        
        return view('customer.dashboard', compact('stats', 'recentBookings'));
    }
}