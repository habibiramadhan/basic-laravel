<!-- resources/views/admin/payment/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')
@section('page-title', 'Kelola Pembayaran')
@section('page-subtitle', 'Verifikasi dan manajemen pembayaran')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-credit-card fa-2x mb-2"></i>
                    <h4 class="mb-0 fw-bold">{{ $stats['total'] }}</h4>
                    <small>Total Payment</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h4 class="mb-0 fw-bold">{{ $stats['pending'] }}</h4>
                    <small>Pending</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4 class="mb-0 fw-bold">{{ $stats['verified'] }}</h4>
                    <small>Verified</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-danger text-white">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x mb-2"></i>
                    <h4 class="mb-0 fw-bold">{{ $stats['rejected'] }}</h4>
                    <small>Rejected</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-upload fa-2x mb-2"></i>
                    <h4 class="mb-0 fw-bold">{{ $stats['upload_transfer'] }}</h4>
                    <small>Upload Transfer</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body text-center">
                    <i class="fab fa-whatsapp fa-2x mb-2"></i>
                    <h4 class="mb-0 fw-bold">{{ $stats['whatsapp_confirm'] }}</h4>
                    <small>WhatsApp</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <div class="input-group" style="min-width: 250px;">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari kode booking atau customer..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-warning" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <select name="status" class="form-select" style="max-width: 130px;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                
                <select name="metode" class="form-select" style="max-width: 150px;">
                    <option value="">Semua Metode</option>
                    <option value="upload_transfer" {{ request('metode') == 'upload_transfer' ? 'selected' : '' }}>Upload Transfer</option>
                    <option value="whatsapp_confirm" {{ request('metode') == 'whatsapp_confirm' ? 'selected' : '' }}>WhatsApp</option>
                </select>
                
                <input type="date" name="tanggal" class="form-control" 
                       value="{{ request('tanggal') }}" style="max-width: 150px;">
                
                @if(request()->hasAny(['search', 'status', 'metode', 'tanggal']))
                    <a href="{{ route('admin.payment.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-cogs me-2"></i>Bulk Action
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button type="button" class="dropdown-item" onclick="showBulkModal('verify')">
                            <i class="fas fa-check me-2 text-success"></i>Verifikasi Terpilih
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item" onclick="showBulkModal('reject')">
                            <i class="fas fa-times me-2 text-danger"></i>Tolak Terpilih
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button type="button" class="dropdown-item text-danger" onclick="showBulkModal('delete')">
                            <i class="fas fa-trash me-2"></i>Hapus Terpilih
                        </button>
                    </li>
                </ul>
            </div>
            
            <a href="{{ route('admin.payment.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
               class="btn btn-success">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
        </div>
    </div>
    
    @if($payments->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-warning">
                            <tr>
                                <th width="3%">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th width="12%">Booking</th>
                                <th width="15%">Customer</th>
                                <th width="10%">Metode</th>
                                <th width="12%">Jumlah</th>
                                <th width="10%">Status</th>
                                <th width="12%">Tanggal</th>
                                <th width="15%">Verifikasi</th>
                                <th width="11%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input payment-checkbox" 
                                           value="{{ $payment->id }}">
                                </td>
                                
                                <td>
                                    <div class="fw-bold">{{ $payment->pemesanan->kode_booking }}</div>
                                    <small class="text-muted">{{ $payment->pemesanan->alat->nama_alat }}</small>
                                </td>
                                
                                <td>
                                    <div class="fw-bold">{{ $payment->pemesanan->user->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $payment->pemesanan->user->no_telepon }}</small>
                                </td>
                                
                                <td>
                                    @if($payment->metode_pembayaran == 'upload_transfer')
                                        <span class="badge bg-primary">
                                            <i class="fas fa-upload"></i> Upload
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="fw-bold text-warning">{{ $payment->jumlah_bayar_formatted }}</td>
                                
                                <td>
                                    <span class="badge {{ $payment->status_badge }}">
                                        {{ ucfirst($payment->status_bayar) }}
                                    </span>
                                </td>
                                
                                <td>
                                    <div>{{ $payment->tanggal_bayar->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $payment->created_at->format('H:i') }}</small>
                                </td>
                                
                                <td>
                                    @if($payment->verified_at)
                                        <div class="small">
                                            <i class="fas fa-user text-success"></i> {{ $payment->verified_by }}
                                        </div>
                                        <small class="text-muted">{{ $payment->verified_at->format('d/m/Y H:i') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.payment.show', $payment) }}" 
                                           class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($payment->status_bayar == 'pending')
                                            <div class="dropdown">
                                                <button class="btn btn-outline-warning dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown" title="Verifikasi">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.payment.verify', $payment) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check me-2 text-success"></i>Verifikasi
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item" 
                                                                onclick="showRejectModal({{ $payment->id }})">
                                                            <i class="fas fa-times me-2 text-danger"></i>Tolak
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        @if($payment->bukti_transfer)
                                            <a href="{{ $payment->bukti_transfer_url }}" 
                                               target="_blank" class="btn btn-outline-primary" title="Lihat Bukti">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        @endif
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
            {{ $payments->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">
                        @if(request()->hasAny(['search', 'status', 'metode', 'tanggal']))
                            Tidak ada pembayaran yang ditemukan
                        @else
                            Belum ada pembayaran
                        @endif
                    </h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'status', 'metode', 'tanggal']))
                            Coba ubah filter pencarian
                        @else
                            Pembayaran customer akan muncul di sini
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkForm" method="POST" action="{{ route('admin.payment.bulk') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="action" id="bulkAction">
                    <div id="selectedPayments"></div>
                    
                    <div class="mb-3" id="catatanField" style="display: none;">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3" 
                                  placeholder="Berikan catatan untuk aksi ini..."></textarea>
                    </div>
                    
                    <div id="bulkMessage"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" id="bulkSubmitBtn"></button>
                </div>
            </form>
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
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="action" value="reject">
                    <div class="mb-3">
                        <label for="rejectCatatan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="catatan" id="rejectCatatan" class="form-control" rows="3" 
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
document.addEventListener('DOMContentLoaded', function() {
    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.payment-checkbox');
    
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.payment-checkbox:checked').length;
            selectAll.checked = checkedCount === checkboxes.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        });
    });
});

function showBulkModal(action) {
    const selected = document.querySelectorAll('.payment-checkbox:checked');
    
    if (selected.length === 0) {
        alert('Silakan pilih pembayaran terlebih dahulu');
        return;
    }
    
    const modal = document.getElementById('bulkModal');
    const title = document.getElementById('bulkModalTitle');
    const actionInput = document.getElementById('bulkAction');
    const selectedPayments = document.getElementById('selectedPayments');
    const message = document.getElementById('bulkMessage');
    const submitBtn = document.getElementById('bulkSubmitBtn');
    const catatanField = document.getElementById('catatanField');
    
    actionInput.value = action;
    
    // Clear previous selections
    selectedPayments.innerHTML = '';
    
    // Add hidden inputs for selected payments
    selected.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'payment_ids[]';
        input.value = checkbox.value;
        selectedPayments.appendChild(input);
    });
    
    // Configure modal based on action
    if (action === 'verify') {
        title.textContent = 'Verifikasi Pembayaran';
        message.innerHTML = `<div class="alert alert-info">Anda akan memverifikasi <strong>${selected.length}</strong> pembayaran terpilih.</div>`;
        submitBtn.textContent = 'Verifikasi';
        submitBtn.className = 'btn btn-success';
        catatanField.style.display = 'block';
    } else if (action === 'reject') {
        title.textContent = 'Tolak Pembayaran';
        message.innerHTML = `<div class="alert alert-warning">Anda akan menolak <strong>${selected.length}</strong> pembayaran terpilih.</div>`;
        submitBtn.textContent = 'Tolak';
        submitBtn.className = 'btn btn-danger';
        catatanField.style.display = 'block';
    } else if (action === 'delete') {
        title.textContent = 'Hapus Pembayaran';
        message.innerHTML = `<div class="alert alert-danger">Anda akan menghapus <strong>${selected.length}</strong> pembayaran terpilih. Aksi ini tidak dapat dibatalkan!</div>`;
        submitBtn.textContent = 'Hapus';
        submitBtn.className = 'btn btn-danger';
        catatanField.style.display = 'none';
    }
    
    new bootstrap.Modal(modal).show();
}

function showRejectModal(paymentId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    
    form.action = `/admin/payment/${paymentId}/verify`;
    
    new bootstrap.Modal(modal).show();
}
</script>
@endpush

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

.form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

.dropdown-item:hover {
    background-color: rgba(255, 193, 7, 0.1);
}
</style>
@endpush