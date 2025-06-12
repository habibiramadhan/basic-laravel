<!-- resources/views/admin/kategori/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')
@section('page-subtitle', 'Menambahkan kategori alat berat baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Form Tambah Kategori
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.kategori.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_kategori" id="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   value="{{ old('nama_kategori') }}" 
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
                                      placeholder="Jelaskan secara singkat tentang kategori alat ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 500 karakter</div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>Tips Kategori
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold mb-2">Contoh Kategori Populer:</h6>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-secondary">Excavator</span>
                                <span class="badge bg-secondary">Bulldozer</span>
                                <span class="badge bg-secondary">Wheel Loader</span>
                                <span class="badge bg-secondary">Crane</span>
                                <span class="badge bg-secondary">Dump Truck</span>
                                <span class="badge bg-secondary">Compactor</span>
                                <span class="badge bg-secondary">Grader</span>
                                <span class="badge bg-secondary">Forklift</span>
                            </div>
                            
                            <h6 class="fw-bold mb-2">Panduan Penamaan:</h6>
                            <ul class="small text-muted">
                                <li>Gunakan nama yang umum dan mudah dipahami</li>
                                <li>Hindari singkatan yang tidak jelas</li>
                                <li>Satu kata atau frasa pendek lebih baik</li>
                                <li>Pastikan nama belum ada sebelumnya</li>
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