<!-- resources/views/admin/equipment/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Alat Berat')
@section('page-title', 'Kelola Alat Berat')
@section('page-subtitle', 'Manajemen data alat berat')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="d-flex gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari nama alat atau merk..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-warning" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <select name="kategori" class="form-select" style="max-width: 200px;">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                
                <select name="status" class="form-select" style="max-width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                
                @if(request()->hasAny(['search', 'kategori', 'status']))
                    <a href="{{ route('admin.equipment.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.equipment.create') }}" class="btn btn-warning">
                <i class="fas fa-plus me-2"></i>Tambah Alat Berat
            </a>
        </div>
    </div>
    
    @if($alat->count() > 0)
        <div class="row">
            @foreach($alat as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="position-relative">
                        <img src="{{ $item->foto_utama_url }}" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;"
                             alt="{{ $item->nama_alat }}">
                        
                        <div class="position-absolute top-0 end-0 m-2">
                            @php
                                $statusClass = match($item->status) {
                                    'tersedia' => 'bg-success',
                                    'disewa' => 'bg-warning text-dark',
                                    'maintenance' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0 fw-bold">{{ $item->nama_alat }}</h6>
                            <div class="dropdown">
                                <button class="btn btn-link btn-sm p-0" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.equipment.show', $item) }}">
                                            <i class="fas fa-eye me-2"></i>Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.equipment.edit', $item) }}">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.equipment.destroy', $item) }}" 
                                              onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted">{{ $item->kategori->nama_kategori }}</small>
                            <div class="fw-bold text-muted">{{ $item->merk }} {{ $item->model }}</div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold text-warning fs-5">{{ $item->harga_formatted }}/hari</div>
                            
                            <div class="btn-group btn-group-sm">
                                <select class="form-select form-select-sm status-select" 
                                        data-id="{{ $item->id }}" 
                                        style="width: auto;">
                                    <option value="tersedia" {{ $item->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="disewa" {{ $item->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                    <option value="maintenance" {{ $item->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>
                        </div>
                        
                        @if($item->deskripsi)
                            <p class="card-text mt-2 small text-muted">
                                {{ Str::limit($item->deskripsi, 100) }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $alat->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-truck fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data alat berat</h5>
                    <p class="text-muted">Silakan tambah alat berat terlebih dahulu</p>
                    <a href="{{ route('admin.equipment.create') }}" class="btn btn-warning">
                        <i class="fas fa-plus me-2"></i>Tambah Alat Berat
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const status = this.value;
            
            fetch(`/admin/equipment/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.value = this.defaultValue;
            });
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.status-select {
    border: none;
    background: transparent;
    font-size: 0.8rem;
    padding: 0.25rem;
}

.status-select:focus {
    box-shadow: 0 0 0 0.1rem rgba(255, 193, 7, 0.25);
}

.card-img-top {
    border-radius: 0.375rem 0.375rem 0 0;
}

.badge {
    font-size: 0.7rem;
}
</style>
@endpush