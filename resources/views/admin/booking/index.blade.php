<!-- resources/views/admin/booking/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Booking')
@section('page-title', 'Kelola Booking')
@section('page-subtitle', 'Manajemen pemesanan alat berat')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Total Booking</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Pending</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Dikonfirmasi</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['dikonfirmasi'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Berlangsung</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['berlangsung'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-play-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <div class="input-group" style="min-width: 250px;">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari kode booking, customer, atau alat..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-warning" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <select name="status" class="form-select" style="max-width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                
                <input type="date" name="tanggal" class="form-control" 
                       value="{{ request('tanggal') }}" style="max-width: 150px;">
                
                <select name="alat" class="form-select" style="max-width: 200px;">
                    <option value="">Semua Alat</option>
                    @foreach($alats as $alat)
                        <option value="{{ $alat->id }}" {{ request('alat') == $alat->id ? 'selected' : '' }}>
                            {{ $alat->nama_alat }}
                        </option>
                    @endforeach
                </select>
                
                @if(request()->hasAny(['search', 'status', 'tanggal', 'alat']))
                    <a href="{{ route('admin.booking.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.booking.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
               class="btn btn-success">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
        </div>
    </div>
    
    @if($bookings->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-warning">
                            <tr>
                                <th width="10%">Kode Booking</th>
                                <th width="15%">Customer</th>
                                <th width="15%">Alat</th>
                                <th width="12%">Periode</th>
                                <th width="8%">Durasi</th>
                                <th width="12%">Total</th>
                                <th width="10%">Status</th>
                                <th width="8%">Payment</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $booking->kode_booking }}</div>
                                    <small class="text-muted">{{ $booking->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                
                                <td>
                                    <div class="fw-bold">{{ $booking->user->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $booking->user->no_telepon }}</small>
                                </td>
                                
                                <td>
                                    <div class="fw-bold">{{ $booking->alat->nama_alat }}</div>
                                    <small class="text-muted">{{ $booking->alat->kategori->nama_kategori }}</small>
                                </td>
                                
                                <td>
                                    <div>{{ $booking->tanggal_mulai->format('d/m/Y') }}</div>
                                    <small class="text-muted">s/d {{ $booking->tanggal_selesai->format('d/m/Y') }}</small>
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $booking->durasi_hari }} hari</span>
                                </td>
                                
                                <td class="fw-bold text-warning">{{ $booking->total_harga_formatted }}</td>
                                
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
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.booking.show', $booking) }}" 
                                           class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <div class="dropdown">
                                            <button class="btn btn-outline-warning dropdown-toggle" 
                                                    type="button" data-bs-toggle="dropdown" title="Status">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if($booking->status_pemesanan == 'pending')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.booking.status', $booking) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_pemesanan" value="dikonfirmasi">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check me-2 text-success"></i>Konfirmasi
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.booking.status', $booking) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_pemesanan" value="dibatalkan">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-times me-2 text-danger"></i>Batalkan
                                                            </button>
                                                        </form>
                                                    </li>
                                                @elseif($booking->status_pemesanan == 'dikonfirmasi')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.booking.status', $booking) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_pemesanan" value="berlangsung">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-play me-2 text-primary"></i>Mulai Sewa
                                                            </button>
                                                        </form>
                                                    </li>
                                                @elseif($booking->status_pemesanan == 'berlangsung')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.booking.status', $booking) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_pemesanan" value="selesai">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-flag-checkered me-2 text-success"></i>Selesaikan
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        
                                        <a href="{{ route('admin.booking.whatsapp', $booking) }}" 
                                           class="btn btn-outline-success" title="WhatsApp Customer" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">
                        @if(request()->hasAny(['search', 'status', 'tanggal', 'alat']))
                            Tidak ada booking yang ditemukan
                        @else
                            Belum ada booking
                        @endif
                    </h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'status', 'tanggal', 'alat']))
                            Coba ubah filter pencarian
                        @else
                            Booking customer akan muncul di sini
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background-color: #ffc107 !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(255, 193, 7, 0.1);
}

.badge {
    font-size: 0.75rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.4rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
}

.dropdown-item:hover {
    background-color: rgba(255, 193, 7, 0.1);
}
</style>
@endpush