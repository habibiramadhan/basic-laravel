<!-- resources/views/admin/booking/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
@section('page-subtitle', 'Informasi lengkap pemesanan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>{{ $booking->kode_booking }}
                    </h5>
                    <div>
                        <span class="badge {{ $booking->status_badge }} fs-6">{{ ucfirst($booking->status_pemesanan) }}</span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-user me-2"></i>Informasi Customer
                            </h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">Nama:</td>
                                    <td>{{ $booking->user->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">No. Telepon:</td>
                                    <td>
                                        {{ $booking->user->no_telepon }}
                                        <a href="{{ route('admin.booking.whatsapp', $booking) }}" 
                                           class="btn btn-success btn-sm ms-2" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>{{ $booking->user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Alamat:</td>
                                    <td>{{ $booking->user->alamat ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-truck me-2"></i>Informasi Alat
                            </h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">Nama Alat:</td>
                                    <td>{{ $booking->alat->nama_alat }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kategori:</td>
                                    <td>{{ $booking->alat->kategori->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Merk:</td>
                                    <td>{{ $booking->alat->merk }} {{ $booking->alat->model }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status Alat:</td>
                                    <td>
                                        @php
                                            $statusClass = match($booking->alat->status) {
                                                'tersedia' => 'bg-success',
                                                'disewa' => 'bg-warning text-dark',
                                                'maintenance' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($booking->alat->status) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>Detail Booking
                            </h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">Tanggal Mulai:</td>
                                    <td>{{ $booking->tanggal_mulai->format('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Selesai:</td>
                                    <td>{{ $booking->tanggal_selesai->format('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Durasi:</td>
                                    <td>{{ $booking->durasi_hari }} hari</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Lokasi:</td>
                                    <td>{{ $booking->lokasi_penggunaan }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-money-bill me-2"></i>Rincian Biaya
                            </h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">Harga per Hari:</td>
                                    <td>Rp {{ number_format($booking->harga_per_hari, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Durasi:</td>
                                    <td>{{ $booking->durasi_hari }} hari</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold text-warning fs-5">Total Harga:</td>
                                    <td class="fw-bold text-warning fs-5">{{ $booking->total_harga_formatted }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($booking->catatan)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-2">
                                <i class="fas fa-sticky-note me-2"></i>Catatan
                            </h6>
                            <div class="bg-light p-3 rounded">
                                {{ $booking->catatan }}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Tanggal Booking:</small>
                                    <div class="fw-bold">{{ $booking->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Terakhir Update:</small>
                                    <div class="fw-bold">{{ $booking->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i>Aksi Booking
                    </h6>
                </div>
                <div class="card-body">
                    @if($booking->status_pemesanan == 'pending')
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('admin.booking.status', $booking) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_pemesanan" value="dikonfirmasi">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-2"></i>Konfirmasi Booking
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.booking.status', $booking) }}" 
                                  onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_pemesanan" value="dibatalkan">
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-times me-2"></i>Batalkan Booking
                                </button>
                            </form>
                        </div>
                    @elseif($booking->status_pemesanan == 'dikonfirmasi')
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('admin.booking.status', $booking) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_pemesanan" value="berlangsung">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-play me-2"></i>Mulai Penyewaan
                                </button>
                            </form>
                        </div>
                    @elseif($booking->status_pemesanan == 'berlangsung')
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('admin.booking.status', $booking) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_pemesanan" value="selesai">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-flag-checkered me-2"></i>Selesaikan Booking
                                </button>
                            </form>
                        </div>
                    @endif
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.booking.whatsapp', $booking) }}" 
                           class="btn btn-success" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp Customer
                        </a>
                        
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                        
                        @if(in_array($booking->status_pemesanan, ['pending', 'dibatalkan']))
                            <form method="POST" action="{{ route('admin.booking.destroy', $booking) }}" 
                                  onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-2"></i>Hapus Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($booking->pembayaran->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>Riwayat Pembayaran
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($booking->pembayaran as $payment)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        {{ $payment->metode_pembayaran == 'upload_transfer' ? 'Upload Transfer' : 'WhatsApp Konfirmasi' }}
                                    </h6>
                                    <p class="mb-1 small">
                                        Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $payment->created_at->format('d/m/Y H:i') }}
                                    </small>
                                    @if($payment->catatan)
                                        <div class="small text-muted mt-1">{{ $payment->catatan }}</div>
                                    @endif
                                </div>
                                <div class="text-end">
                                    @php
                                        $statusClass = match($payment->status_bayar) {
                                            'pending' => 'bg-warning text-dark',
                                            'verified' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($payment->status_bayar) }}
                                    </span>
                                    
                                    @if($payment->bukti_transfer)
                                        <div class="mt-1">
                                            <a href="{{ Storage::url($payment->bukti_transfer) }}" 
                                               target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-image"></i> Lihat Bukti
                                            </a>
                                        </div>
                                    @endif
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

.badge {
    font-size: 0.75rem;
}
</style>
@endpush