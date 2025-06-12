<!-- resources/views/admin/customer/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Customer')
@section('page-title', 'Detail Customer')
@section('page-subtitle', 'Informasi lengkap customer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>{{ $customer->nama_lengkap }}
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-warning rounded-circle p-4 d-inline-block">
                            <i class="fas fa-user fa-3x text-dark"></i>
                        </div>
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="fw-bold">Nama:</td>
                            <td>{{ $customer->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Username:</td>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email:</td>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Telepon:</td>
                            <td>{{ $customer->no_telepon }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Alamat:</td>
                            <td>{{ $customer->alamat }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Bergabung:</td>
                            <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status:</td>
                            <td>
                                <span class="badge bg-success">Active Customer</span>
                            </td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.customer.whatsapp', $customer) }}" 
                           target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp Customer
                        </a>
                        
                        <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Booking
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-primary fs-4">{{ $booking_stats['total'] }}</div>
                            <small class="text-muted">Total Booking</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-warning fs-4">{{ $booking_stats['pending'] }}</div>
                            <small class="text-muted">Pending</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-success fs-4">{{ $booking_stats['selesai'] }}</div>
                            <small class="text-muted">Selesai</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-info fs-5">Rp {{ number_format($booking_stats['total_spent'], 0, ',', '.') }}</div>
                            <small class="text-muted">Total Spent</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            @if($customer->pemesanan->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Booking
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Booking</th>
                                        <th>Alat</th>
                                        <th>Periode</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->pemesanan as $booking)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $booking->kode_booking }}</div>
                                            <small class="text-muted">{{ $booking->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        
                                        <td>
                                            <div class="fw-bold">{{ $booking->alat->nama_alat }}</div>
                                            <small class="text-muted">{{ $booking->alat->merk }}</small>
                                        </td>
                                        
                                        <td>
                                            <div>{{ $booking->tanggal_mulai->format('d/m/Y') }}</div>
                                            <small class="text-muted">s/d {{ $booking->tanggal_selesai->format('d/m/Y') }}</small>
                                            <div><span class="badge bg-secondary">{{ $booking->durasi_hari }} hari</span></div>
                                        </td>
                                        
                                        <td class="fw-bold">{{ $booking->total_harga_formatted }}</td>
                                        
                                        <td>
                                            <span class="badge {{ $booking->status_badge }}">
                                                {{ ucfirst($booking->status_pemesanan) }}
                                            </span>
                                        </td>
                                        
                                        <td class="text-center">
                                            @if($booking->pembayaranAktif)
                                                @php
                                                    $paymentClass = match($booking->pembayaranAktif->status_bayar) {
                                                        'pending' => 'text-warning',
                                                        'verified' => 'text-success',
                                                        'rejected' => 'text-danger',
                                                        default => 'text-secondary'
                                                    };
                                                @endphp
                                                <i class="fas fa-circle {{ $paymentClass }}" 
                                                   title="{{ ucfirst($booking->pembayaranAktif->status_bayar) }}"></i>
                                            @else
                                                <i class="fas fa-circle text-muted" title="Belum ada pembayaran"></i>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('admin.booking.show', $booking) }}" 
                                               class="btn btn-outline-info btn-sm" title="Detail Booking">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Booking</h5>
                        <p class="text-muted">Customer ini belum pernah melakukan booking</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table-borderless td {
    padding: 0.5rem 0;
}

.badge {
    font-size: 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(255, 193, 7, 0.1);
}
</style>
@endpush