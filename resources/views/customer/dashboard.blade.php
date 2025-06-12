<!-- resources/views/customer/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Customer - ' . setting('site_name'))

@section('content')
<div class="bg-warning py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-dark mb-0">Dashboard Customer</h1>
                <p class="text-dark mb-0">Selamat datang, {{ auth()->user()->nama_lengkap }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100 border-primary">
                <div class="card-body">
                    <i class="fas fa-calendar-alt text-primary fa-2x mb-2"></i>
                    <h3 class="text-primary">{{ $stats['total_booking'] }}</h3>
                    <p class="card-text">Total Booking</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100 border-warning">
                <div class="card-body">
                    <i class="fas fa-clock text-warning fa-2x mb-2"></i>
                    <h3 class="text-warning">{{ $stats['pending_booking'] }}</h3>
                    <p class="card-text">Menunggu Konfirmasi</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100 border-success">
                <div class="card-body">
                    <i class="fas fa-cog text-success fa-2x mb-2"></i>
                    <h3 class="text-success">{{ $stats['active_booking'] }}</h3>
                    <p class="card-text">Sedang Berlangsung</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100 border-secondary">
                <div class="card-body">
                    <i class="fas fa-check text-secondary fa-2x mb-2"></i>
                    <h3 class="text-secondary">{{ $stats['completed_booking'] }}</h3>
                    <p class="card-text">Selesai</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aksi Cepat</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('catalog.index') }}" class="btn btn-warning">
                            <i class="fas fa-truck me-2"></i>Lihat Katalog
                        </a>
                        <a href="{{ route('customer.booking.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Riwayat Booking
                        </a>
                        <a href="https://wa.me/{{ setting('whatsapp_number') }}" target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Admin
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Bookings -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Booking Terbaru</h5>
                    <a href="{{ route('customer.booking.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($recentBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Alat</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td class="fw-bold">{{ $booking->kode_booking }}</td>
                                            <td>{{ $booking->alat->nama_alat }}</td>
                                            <td>
                                                {{ $booking->tanggal_mulai->format('d/m/Y') }} - 
                                                {{ $booking->tanggal_selesai->format('d/m/Y') }}
                                            </td>
                                            <td class="fw-bold text-warning">{{ $booking->total_harga_formatted }}</td>
                                            <td>
                                                <span class="badge {{ $booking->status_badge }}">
                                                    {{ ucfirst($booking->status_pemesanan) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.booking.show', $booking->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($booking->status_pemesanan == 'pending' && !$booking->pembayaranAktif)
                                                    <a href="{{ route('customer.booking.payment', $booking->id) }}" 
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-credit-card"></i>
                                                    </a>
                                                @endif
                                                <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Halo, saya ingin menanyakan booking {{ $booking->kode_booking }}" 
                                                   target="_blank" class="btn btn-sm btn-success">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5>Belum Ada Booking</h5>
                            <p class="text-muted">Mulai booking alat berat untuk proyek Anda</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-warning">
                                <i class="fas fa-truck me-2"></i>Lihat Katalog
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection