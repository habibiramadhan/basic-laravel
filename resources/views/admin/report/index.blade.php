<!-- resources/views/admin/report/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('page-subtitle', 'Generate berbagai laporan sistem')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Generate Laporan:</strong> Pilih jenis laporan, tentukan periode, dan download dalam format PDF atau lihat di browser.
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Laporan Booking
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Laporan data booking berdasarkan periode dan status tertentu.</p>
                    
                    <form method="POST" action="{{ route('admin.report.booking') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="booking_start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="booking_start_date" 
                                       class="form-control" value="{{ date('Y-m-01') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="booking_end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="booking_end_date" 
                                       class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="booking_status" class="form-label">Status (Opsional)</label>
                            <select name="status" id="booking_status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="dikonfirmasi">Dikonfirmasi</option>
                                <option value="berlangsung">Berlangsung</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="format" value="view" class="btn btn-warning">
                                <i class="fas fa-eye me-2"></i>Lihat Laporan
                            </button>
                            <button type="submit" name="format" value="pdf" class="btn btn-outline-warning">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-truck me-2"></i>Laporan Performa Alat
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Laporan performa dan utilisasi alat berat berdasarkan periode.</p>
                    
                    <form method="POST" action="{{ route('admin.report.equipment') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="equipment_start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="equipment_start_date" 
                                       class="form-control" value="{{ date('Y-m-01') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="equipment_end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="equipment_end_date" 
                                       class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="format" value="view" class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>Lihat Laporan
                            </button>
                            <button type="submit" name="format" value="pdf" class="btn btn-outline-info">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>Laporan Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Laporan pembayaran berdasarkan metode dan status verifikasi.</p>
                    
                    <form method="POST" action="{{ route('admin.report.payment') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="payment_start_date" 
                                       class="form-control" value="{{ date('Y-m-01') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="payment_end_date" 
                                       class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_metode" class="form-label">Metode (Opsional)</label>
                                <select name="metode" id="payment_metode" class="form-select">
                                    <option value="">Semua Metode</option>
                                    <option value="upload_transfer">Upload Transfer</option>
                                    <option value="whatsapp_confirm">WhatsApp</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_status" class="form-label">Status (Opsional)</label>
                                <select name="status" id="payment_status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="format" value="view" class="btn btn-success">
                                <i class="fas fa-eye me-2"></i>Lihat Laporan
                            </button>
                            <button type="submit" name="format" value="pdf" class="btn btn-outline-success">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Laporan Customer
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Laporan aktivitas customer dan analisis loyalitas.</p>
                    
                    <form method="POST" action="{{ route('admin.report.customer') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="customer_start_date" 
                                       class="form-control" value="{{ date('Y-m-01') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="customer_end_date" 
                                       class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="format" value="view" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Lihat Laporan
                            </button>
                            <button type="submit" name="format" value="pdf" class="btn btn-outline-primary">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>Tips Laporan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="fw-bold">Laporan Booking</h6>
                            <ul class="small text-muted">
                                <li>Analisis tren booking</li>
                                <li>Status booking per periode</li>
                                <li>Revenue tracking</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6 class="fw-bold">Performa Alat</h6>
                            <ul class="small text-muted">
                                <li>Utilisasi alat berat</li>
                                <li>Alat paling populer</li>
                                <li>Revenue per alat</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6 class="fw-bold">Pembayaran</h6>
                            <ul class="small text-muted">
                                <li>Metode pembayaran</li>
                                <li>Status verifikasi</li>
                                <li>Analisis cashflow</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6 class="fw-bold">Customer</h6>
                            <ul class="small text-muted">
                                <li>Customer aktif</li>
                                <li>Loyalitas customer</li>
                                <li>Customer value</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set max date to today for all date inputs
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        input.setAttribute('max', today);
    });
    
    // Validate date ranges
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const startDate = form.querySelector('[name="start_date"]').value;
            const endDate = form.querySelector('[name="end_date"]').value;
            
            if (new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                return false;
            }
        });
    });
});
</script>
@endpush