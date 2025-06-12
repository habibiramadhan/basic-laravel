<!-- resources/views/customer/booking/show.blade.php -->
@extends('layouts.app')

@section('title', 'Detail Booking ' . $booking->kode_booking . ' - ' . setting('site_name'))

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.booking.index') }}">Booking</a></li>
            <li class="breadcrumb-item active">{{ $booking->kode_booking }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Booking Details -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Detail Booking: {{ $booking->kode_booking }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6>Informasi Alat</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Nama Alat:</td>
                                    <td>{{ $booking->alat->nama_alat }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Merk/Model:</td>
                                    <td>{{ $booking->alat->merk }} {{ $booking->alat->model }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kategori:</td>
                                    <td>{{ $booking->alat->kategori->nama_kategori }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Informasi Sewa</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Tanggal Mulai:</td>
                                    <td>{{ $booking->tanggal_mulai->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Selesai:</td>
                                    <td>{{ $booking->tanggal_selesai->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Durasi:</td>
                                    <td>{{ $booking->durasi_hari }} hari</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6>Lokasi Penggunaan</h6>
                            <p class="border rounded p-3 bg-light">{{ $booking->lokasi_penggunaan }}</p>
                        </div>
                        
                        @if($booking->catatan)
                            <div class="col-12 mb-3">
                                <h6>Catatan</h6>
                                <p class="border rounded p-3 bg-light">{{ $booking->catatan }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Status Booking</h6>
                            <span class="badge {{ $booking->status_badge }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $booking->status_pemesanan)) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6>Tanggal Booking</h6>
                            <p>{{ $booking->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pricing & Payment -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Rincian Harga</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>Harga per hari:</td>
                            <td class="text-end">{{ formatRupiah($booking->harga_per_hari) }}</td>
                        </tr>
                        <tr>
                            <td>Durasi:</td>
                            <td class="text-end">{{ $booking->durasi_hari }} hari</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold">Total:</td>
                            <td class="text-end fw-bold text-warning h5">{{ $booking->total_harga_formatted }}</td>
                        </tr>
                    </table>
                    
                    <div class="d-grid gap-2 mt-3">
                        @if($booking->status_pemesanan == 'pending' && $booking->pembayaran->count() == 0)
                            <a href="{{ route('customer.booking.payment', $booking->id) }}" 
                               class="btn btn-warning">
                                <i class="fas fa-credit-card me-2"></i>Lakukan Pembayaran
                            </a>
                        @endif
                        
                        <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Halo admin, saya ingin menanyakan booking dengan kode {{ $booking->kode_booking }}" 
                           target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Admin
                        </a>
                        
                        <a href="{{ route('customer.booking.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payment History -->
    @if($booking->pembayaran->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Riwayat Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Metode</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->pembayaran as $payment)
                                        <tr>
                                            <td>{{ $payment->tanggal_bayar->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($payment->metode_pembayaran == 'upload_transfer')
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-upload"></i> Upload Transfer
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $payment->jumlah_bayar_formatted }}</td>
                                            <td>
                                                <span class="badge {{ $payment->status_badge }}">
                                                    {{ ucfirst($payment->status_bayar) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($payment->catatan)
                                                    {{ $payment->catatan }}
                                                @endif
                                                @if($payment->verified_at)
                                                    <br><small class="text-muted">
                                                        Diverifikasi: {{ $payment->verified_at->format('d/m/Y H:i') }}
                                                        @if($payment->verified_by)
                                                            oleh {{ $payment->verified_by }}
                                                        @endif
                                                    </small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection