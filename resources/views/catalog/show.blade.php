<!-- resources/views/catalog/show.blade.php -->
@extends('layouts.app')

@section('title', $alat->nama_alat . ' - ' . setting('site_name'))

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item active">{{ $alat->nama_alat }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Equipment Image -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <img src="{{ $alat->foto_utama_url }}" 
                     class="card-img-top" 
                     style="height: 400px; object-fit: cover;"
                     alt="{{ $alat->nama_alat }}">
                <div class="card-body text-center">
                    <span class="badge bg-success fs-6">{{ ucfirst($alat->status) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Equipment Info -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h1 class="card-title">{{ $alat->nama_alat }}</h1>
                    <p class="text-muted mb-3">
                        <i class="fas fa-tag me-2"></i>{{ $alat->kategori->nama_kategori }} - {{ $alat->merk }}
                        @if($alat->model)
                            {{ $alat->model }}
                        @endif
                    </p>
                    
                    <!-- Pricing -->
                    <div class="pricing-card bg-warning p-4 rounded mb-4">
                        <div class="text-center">
                            <h2 class="text-dark mb-1">{{ $alat->harga_formatted }}</h2>
                            <p class="text-dark mb-0">per hari</p>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    @if($alat->deskripsi)
                        <div class="mb-4">
                            <h5>Deskripsi</h5>
                            <p>{{ $alat->deskripsi }}</p>
                        </div>
                    @endif
                    
                    <!-- Specifications -->
                    @if($alat->spesifikasi)
                        <div class="mb-4">
                            <h5>Spesifikasi</h5>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($alat->spesifikasi)) !!}
                            </div>
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        @auth
                            @if(auth()->user()->isCustomer())
                                <button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#bookingModal">
                                    <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login untuk Booking
                            </a>
                        @endauth
                        
                        <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Halo, saya tertarik dengan {{ $alat->nama_alat }}. Bisakah saya mendapat informasi lebih lanjut?" 
                           target="_blank" class="btn btn-success btn-lg">
                            <i class="fab fa-whatsapp me-2"></i>Konsultasi via WhatsApp
                        </a>
                        
                        <a href="tel:{{ setting('contact_phone') }}" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Telepon Langsung
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Equipment -->
    @if($relatedAlat->count() > 0)
        <div class="mt-5">
            <h3 class="mb-4">Alat Serupa</h3>
            <div class="row">
                @foreach($relatedAlat as $related)
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $related->foto_utama_url }}" 
                                 class="card-img-top" 
                                 style="height: 150px; object-fit: cover;"
                                 alt="{{ $related->nama_alat }}">
                            <div class="card-body">
                                <h6 class="card-title">{{ $related->nama_alat }}</h6>
                                <p class="text-warning fw-bold">{{ $related->harga_formatted }}/hari</p>
                                <a href="{{ route('catalog.show', $related->id) }}" class="btn btn-outline-warning btn-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Booking Modal -->
@auth
    @if(auth()->user()->isCustomer())
        <div class="modal fade" id="bookingModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Booking {{ $alat->nama_alat }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('customer.booking.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Lokasi Penggunaan</label>
                                <textarea class="form-control" name="lokasi_penggunaan" rows="3" 
                                          placeholder="Alamat lengkap lokasi proyek..." required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" name="catatan" rows="2" 
                                          placeholder="Catatan tambahan..."></textarea>
                            </div>
                            
                            <div class="alert alert-info">
                                <strong>Harga:</strong> {{ $alat->harga_formatted }} per hari<br>
                                <small>Total akan dihitung otomatis berdasarkan durasi sewa</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth
@endsection

@push('styles')
<style>
.pricing-card {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
}

.breadcrumb-item.active {
    color: #6c757d;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: #6c757d;
}
</style>
@endpush