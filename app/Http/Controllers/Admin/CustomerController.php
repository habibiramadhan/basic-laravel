<?php
// app/Http/Controllers/Admin/CustomerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->withCount(['pemesanan']);
        
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_telepon', 'like', '%' . $request->search . '%');
        }
        
        $customers = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'active_customers' => User::where('role', 'customer')
                                     ->whereHas('pemesanan', function($q) {
                                         $q->whereIn('status_pemesanan', ['dikonfirmasi', 'berlangsung']);
                                     })->count(),
            'new_this_month' => User::where('role', 'customer')
                                   ->whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count()
        ];
        
        return view('admin.customer.index', compact('customers', 'stats'));
    }
    
    public function show(User $customer)
    {
        if (!$customer->isCustomer()) {
            abort(404);
        }
        
        $customer->load(['pemesanan' => function($query) {
            $query->with(['alat', 'pembayaranAktif'])->orderBy('created_at', 'desc');
        }]);
        
        $booking_stats = [
            'total' => $customer->pemesanan->count(),
            'pending' => $customer->pemesanan->where('status_pemesanan', 'pending')->count(),
            'dikonfirmasi' => $customer->pemesanan->where('status_pemesanan', 'dikonfirmasi')->count(),
            'berlangsung' => $customer->pemesanan->where('status_pemesanan', 'berlangsung')->count(),
            'selesai' => $customer->pemesanan->where('status_pemesanan', 'selesai')->count(),
            'total_spent' => $customer->pemesanan->where('status_pemesanan', 'selesai')->sum('total_harga')
        ];
        
        return view('admin.customer.show', compact('customer', 'booking_stats'));
    }
    
    public function whatsapp(User $customer)
    {
        if (!$customer->isCustomer()) {
            abort(404);
        }
        
        $message = "Halo {$customer->nama_lengkap},\n\n";
        $message .= "Kami dari " . setting('site_name', 'Sewa Alat Berat') . ".\n";
        $message .= "Ada yang bisa kami bantu terkait layanan penyewaan alat berat?\n\n";
        $message .= "Terima kasih.";
        
        $waNumber = preg_replace('/[^0-9]/', '', $customer->no_telepon);
        if (substr($waNumber, 0, 1) == '0') {
            $waNumber = '62' . substr($waNumber, 1);
        }
        
        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
        
        return redirect()->away($waLink);
    }
}