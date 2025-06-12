<!-- resources/views/admin/payment/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', 'Informasi lengkap pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>Payment #{{ $payment->id }}
                    </h5>
                    <div>
                        <span class="badge {{ $payment->status_badge }} fs-6">{{ ucfirst($payment->status_bayar) }}</span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-receipt me-2"></i>Informasi Pembayaran
                            </h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">ID Payment:</td>
                                    <td>#{{ $payment->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kode Booking:</td>
                                    <td>
                                        <a href="{{ route('admin.booking.show', $payment->pemesanan) }}" 
                                           class="text-decoration-none fw-bold">
                                            {{ $payment->pemesanan->kode_booking }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Metode:</td>
                                    <td>
                                        @if($payment->metode_pembayaran == 'upload_transfer')
                                            <span class="badge bg-primary">
                                                <i class="fas fa-upload"></i> Upload Transfer
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fab fa-whatsapp"></i> WhatsApp Konfirmasi
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jumlah Bayar:</td>
                                    <td class="fw-bold text-warning fs-5">{{ $payment->jumlah_bayar_formatted }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Bayar:</td>
                                    <td>{{ $payment->tanggal_bayar->format('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Dibuat:</td>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-user me-2"></i>Informasi Customer
                            </h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">Nama:</td>
                                    <td>{{ $payment->pemesanan->user->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">No. Telepon:</td>
                                    <td>{{ $payment->pemesanan->user->no_telepon }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>{{ $payment->pemesanan->user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Alat:</td>
                                    <td>{{ $payment->pemesanan->alat->nama_alat }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kategori:</td>
                                    <td>{{ $payment->pemesanan->alat->kategori->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Periode:</td>
                                    <td>
                                        {{ $payment->pemesanan->tanggal_mulai->format('d/m/Y') }} - 
                                        {{ $payment->pemesanan->tanggal_selesai->format('d/m/Y') }}
                                        <small class="text-muted">({{ $payment->pemesanan->durasi_hari }} hari)</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($payment->verified_at || $payment->catatan)
                    <hr>
                    <div class="row">
                        @if($payment->verified_at)
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-check-circle me-2"></i>Informasi Verifikasi
                            </h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%" class="fw-bold">Diverifikasi oleh:</td>
                                    <td>{{ $payment->verified_by }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Verifikasi:</td>
                                    <td>{{ $payment->verified_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        @endif
                        
                        @if($payment->catatan)
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-sticky-note me-2"></i>Catatan
                            </h6>
                            <div class="bg-light p-3 rounded">
                                {{ $payment->catatan }}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    @if($payment->bukti_transfer)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-image me-2"></i>Bukti Transfer
                            </h6>
                            <div class="text-center">
                                <img src="{{ $payment->bukti_transfer_url }}" 
                                     alt="Bukti Transfer" 
                                     class="img-fluid rounded shadow"
                                     style="max-height: 400px; cursor: pointer;"
                                     onclick="showImageModal('{{ $payment->bukti_transfer_url }}')">
                                <div class="mt-2">
                                    <a href="{{ $payment->bukti_transfer_url }}" 
                                       target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-2"></i>Buka di Tab Baru
                                    </a>
                                </div>
                            </div>
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
                        <i class="fas fa-tasks me-2"></i>Aksi Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    @if($payment->status_bayar == 'pending')
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('admin.payment.verify', $payment) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-2"></i>Verifikasi Pembayaran
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-danger w-100" 
                                    onclick="showRejectModal()">
                                <i class="fas fa-times me-2"></i>Tolak Pembayaran
                            </button>
                        </div>
                        
                        <hr>
                        
                        <div class="small text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Pembayaran ini menunggu verifikasi admin
                        </div>
                    @elseif($payment->status_bayar == 'verified')
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            Pembayaran sudah diverifikasi
                        </div>
                        
                        <div class="small text-muted">
                            Diverifikasi oleh <strong>{{ $payment->verified_by }}</strong> 
                            pada {{ $payment->verified_at->format('d/m/Y H:i') }}
                        </div>
                    @elseif($payment->status_bayar == 'rejected')
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-times-circle me-2"></i>
                            Pembayaran ditolak
                        </div>
                        
                        @if($payment->catatan)
                            <div class="small">
                                <strong>Alasan:</strong> {{ $payment->catatan }}
                            </div>
                        @endif
                        
                        <hr>
                        
                        <div class="d-grid">
                            <form method="POST" action="{{ route('admin.payment.status', $payment) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_bayar" value="pending">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-undo me-2"></i>Kembalikan ke Pending
                                </button>
                            </form>
                        </div>
                    @endif
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.booking.show', $payment->pemesanan) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-calendar-check me-2"></i>Lihat Booking
                        </a>
                        
                        <a href="{{ route('admin.payment.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                        
                        @if($payment->status_bayar != 'verified')
                            <form method="POST" action="{{ route('admin.payment.destroy', $payment) }}" 
                                  onsubmit="return confirm('Yakin ingin menghapus data pembayaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-2"></i>Hapus Pembayaran
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <small class="text-muted">Status Booking:</small>
                            <div>
                                <span class="badge {{ $payment->pemesanan->status_badge }}">
                                    {{ ucfirst($payment->pemesanan->status_pemesanan) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <small class="text-muted">Total Harga Booking:</small>
                            <div class="fw-bold">{{ $payment->pemesanan->total_harga_formatted }}</div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Selisih Pembayaran:</small>
                            <div class="fw-bold">
                                @php
                                    $selisih = $payment->jumlah_bayar - $payment->pemesanan->total_harga;
                                @endphp
                                @if($selisih == 0)
                                    <span class="text-success">Sesuai</span>
                                @elseif($selisih > 0)
                                    <span class="text-info">+Rp {{ number_format($selisih, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-warning">-Rp {{ number_format(abs($selisih), 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Bukti Transfer" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.payment.verify', $payment) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="action" value="reject">
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3" 
                                  placeholder="Berikan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function showRejectModal() {
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush

@push('styles')
<style>
.table-borderless td {
    padding: 0.5rem 0;
}

.badge {
    font-size: 0.75rem;
}

#modalImage {
    max-height: 70vh;
    object-fit: contain;
}
</style>
@endpush