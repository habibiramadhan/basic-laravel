<!-- resources/views/admin/kategori/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')
@section('page-subtitle', 'Informasi lengkap kategori alat berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>{{ $kategori->nama_kategori }}
                    </h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-sm btn-dark">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle dropdown-toggle-split" 
                                data-bs-toggle="dropdown">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.kategori.index') }}">
                                    <i class="fas fa-list me-2"></i>Kembali ke Daftar
                                </a>
                            </li>
                            @if($kategori->alatBerat()->count() == 0)
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}" 
                                          onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->nama_kategori }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-2"></i>Hapus Kategori
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-bold">Nama:</td>
                            <td>{{ $kategori->nama_kategori }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Deskripsi:</td>
                            <td>{{ $kategori->deskripsi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total Alat:</td>
                            <td>
                                <span class="badge bg-primary">{{ $kategori->alatBerat()->count() }} alat</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Alat Tersedia:</td>
                            <td>
                                <span class="badge bg-success">{{ $kategori->alatTersedia()->count() }} alat</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Alat Disewa:</td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $kategori->alatBerat()->where('status', 'disewa')->count() }} alat</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Maintenance:</td>
                            <td>
                                <span class="badge bg-danger">{{ $kategori->alatBerat()->where('status', 'maintenance')->count() }} alat</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dibuat:</td>
                            <td>{{ $kategori->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Update Terakhir:</td>
                            <td>{{ $kategori->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if($kategori->alatBerat()->count() == 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-plus-circle fa-3x text-warning mb-3"></i>
                        <h6>Belum Ada Alat</h6>
                        <p class="text-muted small">Kategori ini belum memiliki alat berat</p>
                        <a href="{{ route('admin.equipment.create') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Alat
                        </a>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-lg-8">
            @if($kategori->alatBerat()->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-truck me-2"></i>Daftar Alat dalam Kategori
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($kategori->alatBerat as $alat)
                            <div class="col-md-6 mb-3">
                                <div class="card border h-100">
                                    <div class="position-relative">
                                        <img src="{{ $alat->foto_utama_url }}" 
                                             class="card-img-top" 
                                             style="height: 150px; object-fit: cover;"
                                             alt="{{ $alat->nama_alat }}">
                                        
                                        <div class="position-absolute top-0 end-0 m-2">
                                            @php
                                                $statusClass = match($alat->status) {
                                                    'tersedia' => 'bg-success',
                                                    'disewa' => 'bg-warning text-dark',
                                                    'maintenance' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($alat->status) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-1">{{ $alat->nama_alat }}</h6>
                                        <p class="text-muted small mb-2">{{ $alat->merk }} {{ $alat->model }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="fw-bold text-warning">{{ $alat->harga_formatted }}/hari</div>
                                            <a href="{{ route('admin.equipment.show', $alat) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        
                                        @if($alat->deskripsi)
                                            <p class="card-text mt-2 small text-muted">
                                                {{ Str::limit($alat->deskripsi, 80) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.equipment.index', ['kategori' => $kategori->id]) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Lihat Semua Alat Kategori Ini
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-truck fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Alat</h5>
                        <p class="text-muted">Kategori "{{ $kategori->nama_kategori }}" belum memiliki alat berat</p>
                        <a href="{{ route('admin.equipment.create') }}" class="btn btn-warning">
                            <i class="fas fa-plus me-2"></i>Tambah Alat Pertama
                        </a>
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

.card-img-top {
    border-radius: 0.375rem 0.375rem 0 0;
}

.badge {
    font-size: 0.7rem;
}

.card.border {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card.border:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
</style>
@endpush