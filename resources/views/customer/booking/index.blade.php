<!-- resources/views/customer/booking/index.blade.php -->
@extends('layouts.app')

@section('title', 'Riwayat Booking - ' . setting('site_name'))

@section('content')
<div class="bg-warning py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-dark mb-0">Riwayat Booking</h1>
                <p class="text-dark mb-0">Kelola semua booking Anda</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Booking</h5>
                    <a href="{{ route('catalog.index') }}" class="btn btn-warning">
                        <i class="fas fa-plus me-2"></i>Booking Baru
                    </a>
                </div>
                <div class="card-body">
                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Booking</th>
                                        <th>Alat</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td class="fw-bold">{{ $booking->kode_booking }}</td>
                                            <td>
                                                <div>{{ $booking->alat->nama_alat }}</div>
                                                <small class="text-muted">{{ $booking->alat->merk }}</small>
                                            </td>
                                            <td>
                                                <div>{{ $booking->tanggal_mulai->format('d/m/Y') }}</div>
                                                <small class="text-muted">s/d {{ $booking->tanggal_selesai->format('d/m/Y') }}</small>
                                            </td>
                                            <td>{{ $booking->durasi_hari }} hari</td>
                                            <td class="fw-bold text-warning">{{ $booking->total_harga_formatted }}</td>
                                            <td>
                                                <span class="badge {{ $booking->status_badge }}">
                                                    {{ ucfirst(str_replace('_', ' ', $booking->status_pemesanan)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($booking->pembayaranAktif)
                                                    <span class="badge {{ $booking->pembayaranAktif->status_badge }}">
                                                        {{ ucfirst($booking->pembayaranAktif->status_bayar) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">Belum Bayar</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('customer.booking.show', $booking->id) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    @if($booking->status_pemesanan == 'pending' && !$booking->pembayaranAktif)
                                                        <a href="{{ route('customer.booking.payment', $booking->id) }}" 
                                                           class="btn btn-sm btn-warning" title="Bayar">
                                                            <i class="fas fa-credit-card"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Halo admin, saya ingin menanyakan booking dengan kode {{ $booking->kode_booking }}" 
                                                       target="_blank" class="btn btn-sm btn-success" title="WhatsApp">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                            <h4>Belum Ada Booking</h4>
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