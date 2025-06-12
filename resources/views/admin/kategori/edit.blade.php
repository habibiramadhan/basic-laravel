<!-- resources/views/admin/kategori/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Mengedit kategori alat berat')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Form Edit Kategori
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_kategori" id="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   value="{{ old('nama_kategori') ?? $kategori->nama_kategori }}" 
                                   placeholder="Contoh: Excavator, Bulldozer, Crane..." 
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" 
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      placeholder="Jelaskan secara singkat tentang kategori alat ini...">{{ old('deskripsi') ?? $kategori->deskripsi }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 500 karakter</div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Update
                            </button>
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('admin.kategori.show', $kategori) }}" class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-info"></i>Informasi Kategori
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Dibuat:</small>
                            <div class="fw-bold">{{ $kategori->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Terakhir Update:</small>
                            <div class="fw-bold">{{ $kategori->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Total Alat:</small>
                            <div class="fw-bold text-primary">{{ $kategori->alatBerat()->count() }} alat</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Alat Tersedia:</small>
                            <div class="fw-bold text-success">{{ $kategori->alatTersedia()->count() }} alat</div>
                        </div>
                    </div>
                    
                    @if($kategori->alatBerat()->count() > 0)
                        <div class="mt-3">
                            <small class="text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Kategori ini memiliki {{ $kategori->alatBerat()->count() }} alat berat. 
                                Mengubah nama kategori akan mempengaruhi semua alat dalam kategori ini.
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deskripsiInput = document.getElementById('deskripsi');
    
    deskripsiInput.addEventListener('input', function() {
        const maxLength = 500;
        const currentLength = this.value.length;
        
        if (currentLength > maxLength) {
            this.value = this.value.substring(0, maxLength);
        }
    });
});
</script>
@endpush