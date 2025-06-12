<!-- resources/views/admin/equipment/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Alat Berat')
@section('page-title', 'Detail Alat Berat')
@section('page-subtitle', 'Informasi lengkap alat berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-truck me-2"></i>{{ $equipment->nama_alat }}
                    </h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.equipment.edit', $equipment) }}" class="btn btn-sm btn-dark">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle dropdown-toggle-split" 
                                data-bs-toggle="dropdown">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.equipment.index') }}">
                                    <i class="fas fa-list me-2"></i>Kembali ke Daftar
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.equipment.destroy', $equipment) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash me-2"></i>Hapus Alat
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($equipment->foto_utama)
                                <img src="{{ $equipment->foto_utama_url }}" 
                                     alt="{{ $equipment->nama_alat }}" 
                                     class="img-fluid rounded mb-3">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                                     style="height: 300px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p>Tidak ada foto</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">Kategori:</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $equipment->kategori->nama_kategori }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Merk:</td>
                                    <td>{{ $equipment->merk }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Model:</td>
                                    <td>{{ $equipment->model ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Harga per Hari:</td>
                                    <td class="fw-bold text-warning fs-5">{{ $equipment->harga_formatted }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        @php
                                            $statusClass = match($equipment->status) {
                                                'tersedia' => 'bg-success',
                                                'disewa' => 'bg-warning text-dark',
                                                'maintenance' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($equipment->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Ditambahkan:</td>
                                    <td>{{ $equipment->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Terakhir Update:</td>
                                    <td>{{ $equipment->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($equipment->deskripsi)
                    <div class="mt-4">
                        <h6 class="fw-bold">Deskripsi:</h6>
                        <p class="text-muted">{{ $equipment->deskripsi }}</p>
                    </div>
                    @endif
                    
                    @if($equipment->spesifikasi)
                    <div class="mt-3">
                        <h6 class="fw-bold">Spesifikasi:</h6>
                        <div class="bg-light p-3 rounded">
                            <pre class="mb-0" style="white-space: pre-wrap;">{{ $equipment->spesifikasi }}</pre>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Booking
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $totalBooking = $equipment->pemesanan->count();
                        $bookingSelesai = $equipment->pemesanan->where('status_pemesanan', 'selesai')->count();
                        $bookingAktif = $equipment->pemesanan->whereIn('status_pemesanan', ['dikonfirmasi', 'berlangsung'])->count();
                        $totalRevenue = $equipment->pemesanan->where('status_pemesanan', 'selesai')->sum('total_harga');
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-primary fs-4">{{ $totalBooking }}</div>
                            <small class="text-muted">Total Booking</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-success fs-4">{{ $bookingSelesai }}</div>
                            <small class="text-muted">Selesai</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-warning fs-4">{{ $bookingAktif }}</div>
                            <small class="text-muted">Booking Aktif</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-info fs-5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                            <small class="text-muted">Total Revenue</small>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($equipment->pemesanan->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Booking Terbaru
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($equipment->pemesanan->take(5) as $booking)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $booking->user->nama_lengkap }}</h6>
                                    <p class="mb-1 small text-muted">
                                        {{ $booking->tanggal_mulai }} - {{ $booking->tanggal_selesai }}
                                    </p>
                                    <small class="fw-bold">{{ $booking->kode_booking }}</small>
                                </div>
                                <div class="text-end">
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
                                    <span class="badge {{ $statusClass }} mb-1">{{ ucfirst($booking->status_pemesanan) }}</span>
                                    <div class="small fw-bold">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
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

pre {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 0.9rem;
    line-height: 1.4;
}

.list-group-item {
    border-left: none;
    border-right: none;
}

.list-group-item:first-child {
    border-top: none;
}

.list-group-item:last-child {
    border-bottom: none;
}
</style>
@endpush