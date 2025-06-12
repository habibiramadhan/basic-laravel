<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview sistem sewa alat berat')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, var(--primary-yellow), var(--dark-yellow));">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Total Alat</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_alat'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-truck fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Alat Tersedia</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['alat_tersedia'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545, #fd7e14);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Sedang Disewa</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['alat_disewa'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-tools fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #6f42c1, #e83e8c);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Total Customer</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_customer'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning rounded-circle p-2 me-3">
                            <i class="fas fa-calendar-day text-dark"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0">Booking Hari Ini</h6>
                            <h4 class="mb-0 text-warning fw-bold">{{ $stats['booking_hari_ini'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info rounded-circle p-2 me-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0">Pending Approval</h6>
                            <h4 class="mb-0 text-info fw-bold">{{ $stats['booking_pending'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle p-2 me-3">
                            <i class="fas fa-dollar-sign text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0">Revenue Bulan Ini</h6>
                            <h4 class="mb-0 text-success fw-bold">Rp {{ number_format($stats['revenue_bulan_ini'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Booking Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($recent_bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Customer</th>
                                        <th>Alat</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_bookings as $booking)
                                    <tr>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ $booking->kode_booking }}</span>
                                        </td>
                                        <td>{{ $booking->user->nama_lengkap }}</td>
                                        <td>{{ $booking->alat->nama_alat }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($booking->status_pemesanan) {
                                                    'pending' => 'bg-warning text-dark',
                                                    'dikonfirmasi' => 'bg-info',
                                                    'berlangsung' => 'bg-success',
                                                    'selesai' => 'bg-secondary',
                                                    'dibatalkan' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($booking->status_pemesanan) }}</span>
                                        </td>
                                        <td class="fw-bold">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada booking terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-star me-2"></i>Alat Populer
                    </h5>
                </div>
                <div class="card-body">
                    @if($alat_populer->count() > 0)
                        @foreach($alat_populer as $alat)
                        <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                            <div class="bg-warning rounded-circle p-2 me-3">
                                <i class="fas fa-truck text-dark"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $alat->nama_alat }}</h6>
                                <small class="text-muted">{{ $alat->pemesanan_count }} kali disewa</small>
                            </div>
                            <div>
                                @php
                                    $statusClass = match($alat->status) {
                                        'tersedia' => 'bg-success',
                                        'disewa' => 'bg-warning text-dark',
                                        'maintenance' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ ucfirst($alat->status) }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-truck fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada data alat</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table-hover tbody tr:hover {
    background-color: rgba(255, 193, 7, 0.1);
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}
</style>
@endpush