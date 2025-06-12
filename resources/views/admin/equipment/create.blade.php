<!-- resources/views/admin/equipment/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Tambah Alat Berat')
@section('page-title', 'Tambah Alat Berat')
@section('page-subtitle', 'Menambahkan data alat berat baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Form Tambah Alat Berat
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.equipment.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kategori_id" class="form-label">Kategori Alat <span class="text-danger">*</span></label>
                                <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nama_alat" class="form-label">Nama Alat <span class="text-danger">*</span></label>
                                <input type="text" name="nama_alat" id="nama_alat" 
                                       class="form-control @error('nama_alat') is-invalid @enderror" 
                                       value="{{ old('nama_alat') }}" 
                                       placeholder="Ex: Excavator PC200" required>
                                @error('nama_alat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="merk" class="form-label">Merk <span class="text-danger">*</span></label>
                                <input type="text" name="merk" id="merk" 
                                       class="form-control @error('merk') is-invalid @enderror" 
                                       value="{{ old('merk') }}" 
                                       placeholder="Ex: Komatsu" required>
                                @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" name="model" id="model" 
                                       class="form-control @error('model') is-invalid @enderror" 
                                       value="{{ old('model') }}" 
                                       placeholder="Ex: PC200-8">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga_per_hari" class="form-label">Harga per Hari <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_per_hari" id="harga_per_hari" 
                                           class="form-control @error('harga_per_hari') is-invalid @enderror" 
                                           value="{{ old('harga_per_hari') }}" 
                                           placeholder="2000000" required>
                                </div>
                                @error('harga_per_hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="foto_utama" class="form-label">Foto Alat</label>
                            <input type="file" name="foto_utama" id="foto_utama" 
                                   class="form-control @error('foto_utama') is-invalid @enderror"
                                   accept="image/*">
                            <div class="form-text">Upload foto dengan format JPG, PNG. Maksimal 2MB.</div>
                            @error('foto_utama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div id="preview" class="mt-2" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="spesifikasi" class="form-label">Spesifikasi</label>
                            <textarea name="spesifikasi" id="spesifikasi" rows="4" 
                                      class="form-control @error('spesifikasi') is-invalid @enderror"
                                      placeholder="Deskripsi spesifikasi teknis alat...">{{ old('spesifikasi') }}</textarea>
                            @error('spesifikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      placeholder="Deskripsi singkat tentang alat...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('foto_utama');
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('preview-img');
    
    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });
    
    const hargaInput = document.getElementById('harga_per_hari');
    hargaInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
});
</script>
@endpush