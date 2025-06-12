<!-- resources/views/customer/booking/payment.blade.php -->
@extends('layouts.app')

@section('title', 'Pembayaran - ' . setting('site_name'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Booking Info -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Detail Booking</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Kode Booking:</td>
                                    <td>{{ $booking->kode_booking }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Alat:</td>
                                    <td>{{ $booking->alat->nama_alat }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal:</td>
                                    <td>{{ $booking->tanggal_mulai->format('d/m/Y') }} - {{ $booking->tanggal_selesai->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Durasi:</td>
                                    <td>{{ $booking->durasi_hari }} hari</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Harga per hari:</td>
                                    <td>{{ formatRupiah($booking->harga_per_hari) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Harga:</td>
                                    <td class="h5 text-warning">{{ $booking->total_harga_formatted }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td><span class="badge bg-warning">{{ ucfirst($booking->status_pemesanan) }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Methods -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pilih Metode Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Upload Transfer -->
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-upload text-primary fa-3x mb-3"></i>
                                    <h5>Upload Bukti Transfer</h5>
                                    <p class="text-muted">Transfer ke rekening kami dan upload bukti pembayaran</p>
                                    
                                    <div class="alert alert-info text-start">
                                        <strong>Informasi Transfer:</strong><br>
                                        <strong>{{ setting('bank_name', 'Bank BCA') }}</strong><br>
                                        {{ setting('bank_account', '1234-5678-9012') }}<br>
                                        a.n {{ setting('bank_holder', 'PT Sewa Alat Berat Indonesia') }}<br>
                                        <strong>Jumlah: {{ $booking->total_harga_formatted }}</strong>
                                    </div>
                                    
                                    <form action="{{ route('customer.payment.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Upload Bukti Transfer</label>
                                            <input type="file" class="form-control" name="bukti_transfer" 
                                                   accept="image/*" required>
                                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload me-2"></i>Upload Bukti
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Confirmation -->
                        <div class="col-md-6 mb-3">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <i class="fab fa-whatsapp text-success fa-3x mb-3"></i>
                                    <h5>Konfirmasi via WhatsApp</h5>
                                    <p class="text-muted">Chat langsung dengan admin untuk koordinasi pembayaran</p>
                                    
                                    <div class="alert alert-success">
                                        <strong>Cara WhatsApp:</strong><br>
                                        1. Klik tombol di bawah<br>
                                        2. Transfer sesuai nominal<br>
                                        3. Kirim bukti via chat<br>
                                        4. Admin akan konfirmasi
                                    </div>
                                    
                                    <form action="{{ route('customer.payment.whatsapp') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                        
                                        <button type="submit" class="btn btn-success">
                                            <i class="fab fa-whatsapp me-2"></i>Chat Admin Sekarang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection