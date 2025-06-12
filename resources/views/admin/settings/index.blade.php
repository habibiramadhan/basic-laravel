<!-- resources/views/admin/settings/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')
@section('page-subtitle', 'Kelola informasi website, kontak, dan bank')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Pengaturan Website:</strong> Perubahan di sini akan langsung terlihat di website customer dan footer/header.
            </div>
        </div>
    </div>
    
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-globe me-2"></i>Informasi Website
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="site_name" class="form-label">Nama Website <span class="text-danger">*</span></label>
                            <input type="text" name="site_name" id="site_name" 
                                   class="form-control @error('site_name') is-invalid @enderror"
                                   value="{{ old('site_name') ?? $settings['site_name']->value ?? '' }}" 
                                   placeholder="Ex: Sewa Alat Berat" required>
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="site_tagline" class="form-label">Tagline Website</label>
                            <input type="text" name="site_tagline" id="site_tagline" 
                                   class="form-control @error('site_tagline') is-invalid @enderror"
                                   value="{{ old('site_tagline') ?? $settings['site_tagline']->value ?? '' }}" 
                                   placeholder="Ex: Solusi Penyewaan Alat Berat Terpercaya">
                            @error('site_tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="hero_title" class="form-label">Judul Hero Homepage</label>
                            <input type="text" name="hero_title" id="hero_title" 
                                   class="form-control @error('hero_title') is-invalid @enderror"
                                   value="{{ old('hero_title') ?? $settings['hero_title']->value ?? '' }}" 
                                   placeholder="Ex: Sewa Alat Berat Berkualitas">
                            @error('hero_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="hero_subtitle" class="form-label">Subtitle Hero Homepage</label>
                            <textarea name="hero_subtitle" id="hero_subtitle" rows="3"
                                      class="form-control @error('hero_subtitle') is-invalid @enderror"
                                      placeholder="Ex: Dapatkan alat berat terbaik untuk proyek Anda...">{{ old('hero_subtitle') ?? $settings['hero_subtitle']->value ?? '' }}</textarea>
                            @error('hero_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label for="footer_copyright" class="form-label">Copyright Footer</label>
                            <input type="text" name="footer_copyright" id="footer_copyright" 
                                   class="form-control @error('footer_copyright') is-invalid @enderror"
                                   value="{{ old('footer_copyright') ?? $settings['footer_copyright']->value ?? '' }}" 
                                   placeholder="Ex: © 2025 Sewa Alat Berat. All rights reserved.">
                            @error('footer_copyright')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-address-book me-2"></i>Informasi Kontak
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" name="contact_phone" id="contact_phone" 
                                   class="form-control @error('contact_phone') is-invalid @enderror"
                                   value="{{ old('contact_phone') ?? $settings['contact_phone']->value ?? '' }}" 
                                   placeholder="Ex: +62 812-3456-7890">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Email Kontak</label>
                            <input type="email" name="contact_email" id="contact_email" 
                                   class="form-control @error('contact_email') is-invalid @enderror"
                                   value="{{ old('contact_email') ?? $settings['contact_email']->value ?? '' }}" 
                                   placeholder="Ex: info@sewalat.com">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp_number" id="whatsapp_number" 
                                   class="form-control @error('whatsapp_number') is-invalid @enderror"
                                   value="{{ old('whatsapp_number') ?? $settings['whatsapp_number']->value ?? '' }}" 
                                   placeholder="Ex: 628123456789 (tanpa +)">
                            @error('whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: 628123456789 (tanpa tanda + dan spasi)</div>
                        </div>
                        
                        <div class="mb-0">
                            <label for="contact_address" class="form-label">Alamat Lengkap</label>
                            <textarea name="contact_address" id="contact_address" rows="3"
                                      class="form-control @error('contact_address') is-invalid @enderror"
                                      placeholder="Ex: Jl. Raya Bogor No. 123, Jakarta Selatan">{{ old('contact_address') ?? $settings['contact_address']->value ?? '' }}</textarea>
                            @error('contact_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-university me-2"></i>Informasi Bank
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" name="bank_name" id="bank_name" 
                                   class="form-control @error('bank_name') is-invalid @enderror"
                                   value="{{ old('bank_name') ?? $settings['bank_name']->value ?? '' }}" 
                                   placeholder="Ex: Bank BCA" required>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="bank_account" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="bank_account" id="bank_account" 
                                   class="form-control @error('bank_account') is-invalid @enderror"
                                   value="{{ old('bank_account') ?? $settings['bank_account']->value ?? '' }}" 
                                   placeholder="Ex: 1234-5678-9012" required>
                            @error('bank_account')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label for="bank_holder" class="form-label">Atas Nama Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="bank_holder" id="bank_holder" 
                                   class="form-control @error('bank_holder') is-invalid @enderror"
                                   value="{{ old('bank_holder') ?? $settings['bank_holder']->value ?? '' }}" 
                                   placeholder="Ex: PT Sewa Alat Berat Indonesia" required>
                            @error('bank_holder')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>Informasi Operasional
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="operational_hours" class="form-label">Jam Operasional</label>
                            <input type="text" name="operational_hours" id="operational_hours" 
                                   class="form-control @error('operational_hours') is-invalid @enderror"
                                   value="{{ old('operational_hours') ?? $settings['operational_hours']->value ?? '' }}" 
                                   placeholder="Ex: Senin - Jumat: 08:00 - 17:00 WIB">
                            @error('operational_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label for="service_area" class="form-label">Area Layanan</label>
                            <input type="text" name="service_area" id="service_area" 
                                   class="form-control @error('service_area') is-invalid @enderror"
                                   value="{{ old('service_area') ?? $settings['service_area']->value ?? '' }}" 
                                   placeholder="Ex: Jakarta, Bogor, Depok, Tangerang, Bekasi">
                            @error('service_area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-warning btn-lg px-5">
                            <i class="fas fa-save me-2"></i>Simpan Semua Pengaturan
                        </button>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Perubahan akan langsung terlihat di website setelah disimpan
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto format WhatsApp number
    const whatsappInput = document.getElementById('whatsapp_number');
    if (whatsappInput) {
        whatsappInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            
            // Ensure it starts with 62
            if (value.length > 0 && !value.startsWith('62')) {
                if (value.startsWith('0')) {
                    value = '62' + value.substring(1);
                } else if (value.startsWith('8')) {
                    value = '62' + value;
                }
            }
            
            e.target.value = value;
        });
    }
    
    // Character counter for textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const maxLength = textarea.name === 'hero_subtitle' || textarea.name === 'contact_address' ? 500 : 255;
        
        const counter = document.createElement('div');
        counter.className = 'form-text text-end';
        counter.innerHTML = `<span id="${textarea.id}_count">0</span>/${maxLength} karakter`;
        textarea.parentNode.appendChild(counter);
        
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById(this.id + '_count').textContent = count;
            
            if (count > maxLength) {
                counter.classList.add('text-danger');
            } else {
                counter.classList.remove('text-danger');
            }
        });
        
        // Initial count
        textarea.dispatchEvent(new Event('input'));
    });
});
</script>
@endpush

@push('styles')
<style>
.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.card-header {
    border-bottom: 2px solid rgba(255,255,255,0.2);
}

.form-text {
    font-size: 0.8rem;
}
</style>
@endpush