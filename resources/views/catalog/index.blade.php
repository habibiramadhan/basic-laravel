<!-- resources/views/catalog/index.blade.php -->
@extends('layouts.app')

@section('title', 'Katalog Alat Berat - ' . setting('site_name'))

@section('content')
<div class="bg-warning py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-dark mb-0">Katalog Alat Berat</h1>
                <p class="text-dark mb-0">Temukan alat berat yang Anda butuhkan</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter</h5>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <form method="GET" action="{{ route('catalog.index') }}">
                        <div class="mb-3">
                            <label class="form-label">Cari Alat</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama alat atau merk...">
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->nama_kategori }}" 
                                            {{ request('kategori') == $kategori->nama_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Sort -->
                        <div class="mb-3">
                            <label class="form-label">Urutkan</label>
                            <select class="form-select" name="sort">
                                <option value="nama_alat" {{ request('sort') == 'nama_alat' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="harga_per_hari" {{ request('sort') == 'harga_per_hari' ? 'selected' : '' }}>Harga Terendah</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                        
                        @if(request()->hasAny(['search', 'kategori', 'sort']))
                            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Reset Filter
                            </a>
                        @endif
                    </form>
                </div>
            </div>
            
            <!-- Category Quick Links -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">Kategori Populer</h6>
                </div>
                <div class="card-body p-2">
                    @foreach($kategoris as $kategori)
                        <a href="{{ route('catalog.index', ['kategori' => $kategori->nama_kategori]) }}" 
                           class="btn btn-outline-dark btn-sm w-100 mb-1 text-start">
                            <i class="fas fa-truck me-2"></i>{{ $kategori->nama_kategori }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Equipment Grid -->
        <div class="col-lg-9">
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5>{{ $alat->total() }} Alat Ditemukan</h5>
                    @if(request('search'))
                        <small class="text-muted">Hasil pencarian untuk: "{{ request('search') }}"</small>
                    @endif
                </div>
                <div>
                    <a href="https://wa.me/{{ setting('whatsapp_number') }}" 
                       target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp me-2"></i>Bantuan Pemilihan
                    </a>
                </div>
            </div>
            
            @if($alat->count() > 0)
                <div class="row">
                    @foreach($alat as $item)
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm equipment-card">
                                <div class="position-relative">
                                    <img src="{{ $item->foto_utama_url }}" 
                                         class="card-img-top" 
                                         style="height: 200px; object-fit: cover;"
                                         alt="{{ $item->nama_alat }}">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-success">Tersedia</span>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">{{ $item->nama_alat }}</h6>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-tag me-1"></i>{{ $item->kategori->nama_kategori }} - {{ $item->merk }}
                                    </p>
                                    
                                    <div class="price-section mb-3">
                                        <div class="h5 text-warning mb-0">{{ $item->harga_formatted }}</div>
                                        <small class="text-muted">per hari</small>
                                    </div>
                                    
                                    @if($item->deskripsi)
                                        <p class="card-text small text-muted">
                                            {{ Str::limit($item->deskripsi, 80) }}
                                        </p>
                                    @endif
                                </div>
                                
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('catalog.show', $item->id) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-eye me-2"></i>Lihat Detail
                                        </a>
                                        <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Halo, saya tertarik dengan {{ $item->nama_alat }}" 
                                           target="_blank" class="btn btn-outline-success btn-sm">
                                            <i class="fab fa-whatsapp me-1"></i>Tanya via WA
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $alat->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4>Alat Tidak Ditemukan</h4>
                    <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-warning">
                        <i class="fas fa-refresh me-2"></i>Lihat Semua Alat
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.equipment-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.equipment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.price-section {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    padding: 10px;
    border-radius: 8px;
    text-align: center;
}
</style>
@endpush