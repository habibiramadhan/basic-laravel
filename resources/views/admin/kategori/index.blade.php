<!-- resources/views/admin/kategori/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Kategori Alat')
@section('page-title', 'Kategori Alat')
@section('page-subtitle', 'Manajemen kategori alat berat')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="d-flex gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari nama kategori atau deskripsi..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-warning" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                @if(request('search'))
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-warning">
                <i class="fas fa-plus me-2"></i>Tambah Kategori
            </a>
        </div>
    </div>
    
    @if($kategoris->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-warning">
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="25%">Nama Kategori</th>
                                <th width="40%">Deskripsi</th>
                                <th width="15%" class="text-center">Jumlah Alat</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoris as $kategori)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}</td>
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle p-2 me-3">
                                            <i class="fas fa-tags text-dark"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $kategori->nama_kategori }}</h6>
                                            <small class="text-muted">Dibuat {{ $kategori->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <p class="mb-0 text-muted">{{ $kategori->deskripsi ?: '-' }}</p>
                                </td>
                                
                                <td class="text-center">
                                    @if($kategori->alat_berat_count > 0)
                                        <span class="badge bg-info fs-6">{{ $kategori->alat_berat_count }} alat</span>
                                    @else
                                        <span class="badge bg-secondary">0 alat</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.kategori.show', $kategori) }}" 
                                           class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.kategori.edit', $kategori) }}" 
                                           class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        @if($kategori->alat_berat_count == 0)
                                            <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->nama_kategori }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary" 
                                                    title="Tidak dapat dihapus (masih ada alat)" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
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
            {{ $kategoris->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">
                        @if(request('search'))
                            Tidak ada kategori yang ditemukan
                        @else
                            Belum ada kategori alat
                        @endif
                    </h5>
                    <p class="text-muted">
                        @if(request('search'))
                            Coba kata kunci lain untuk pencarian
                        @else
                            Silakan tambah kategori alat terlebih dahulu
                        @endif
                    </p>
                    @if(!request('search'))
                        <a href="{{ route('admin.kategori.create') }}" class="btn btn-warning">
                            <i class="fas fa-plus me-2"></i>Tambah Kategori
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

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
    font-size: 0.8rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush