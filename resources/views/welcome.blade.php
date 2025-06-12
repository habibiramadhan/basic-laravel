<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('title', setting('site_name', 'Sewa Alat Berat') . ' - ' . setting('site_tagline', 'Solusi Terpercaya'))

@section('content')
<!-- Hero Section -->
<section class="hero bg-gradient position-relative overflow-hidden">
    <div class="hero-bg position-absolute w-100 h-100" 
         style="background: linear-gradient(135deg, #2C3E50 0%, #34495E 50%, #FFC107 100%); opacity: 0.9;"></div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center min-vh-100 py-5">
            <div class="col-lg-6 text-white fade-in">
                <h1 class="display-3 fw-bold mb-4">
                    {{ setting('hero_title', 'Sewa Alat Berat Berkualitas') }}
                </h1>
                <p class="lead mb-4 fs-5">
                    {{ setting('hero_subtitle', 'Dapatkan alat berat terbaik untuk proyek Anda dengan layanan terpercaya dan harga kompetitif. Melayani seluruh wilayah Jabodetabek dengan tim profesional.') }}
                </p>
                
                <div class="hero-buttons mb-4">
                    <a href="{{ route('catalog.index') }}" class="btn btn-warning btn-lg me-3 mb-2">
                        <i class="fas fa-truck me-2"></i>Lihat Katalog Alat
                    </a>
                    <a href="https://wa.me/{{ setting('whatsapp_number', '628123456789') }}" 
                       target="_blank" class="btn btn-outline-light btn-lg mb-2">
                        <i class="fab fa-whatsapp me-2"></i>Konsultasi Gratis
                    </a>
                </div>
                
                <div class="hero-features">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="feature-item text-center">
                                <i class="fas fa-shield-alt text-warning fs-3 mb-2"></i>
                                <h6>Terpercaya</h6>
                                <small>Alat berkualitas tinggi</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-item text-center">
                                <i class="fas fa-clock text-warning fs-3 mb-2"></i>
                                <h6>24/7 Support</h6>
                                <small>Layanan pelanggan</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-item text-center">
                                <i class="fas fa-shipping-fast text-warning fs-3 mb-2"></i>
                                <h6>Pengiriman Cepat</h6>
                                <small>Area Jabodetabek</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 fade-in">
                <div class="hero-image text-center">
                    <img src="/images/hero-excavator.png" alt="Alat Berat" 
                         class="img-fluid" style="max-height: 500px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="floating-elements position-absolute w-100 h-100" style="z-index: 1;">
        <div class="floating-icon" style="top: 20%; left: 10%; animation: float 3s ease-in-out infinite;">
            <i class="fas fa-hard-hat text-warning opacity-25 fs-4"></i>
        </div>
        <div class="floating-icon" style="top: 60%; right: 15%; animation: float 4s ease-in-out infinite reverse;">
            <i class="fas fa-cogs text-warning opacity-25 fs-5"></i>
        </div>
        <div class="floating-icon" style="top: 80%; left: 20%; animation: float 5s ease-in-out infinite;">
            <i class="fas fa-tools text-warning opacity-25 fs-3"></i>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-5 bg-warning text-dark">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="stat-item">
                    <h2 class="fw-bold mb-1">50+</h2>
                    <p class="mb-0">Alat Berat Tersedia</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="stat-item">
                    <h2 class="fw-bold mb-1">1000+</h2>
                    <p class="mb-0">Proyek Selesai</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="stat-item">
                    <h2 class="fw-bold mb-1">24/7</h2>
                    <p class="mb-0">Customer Support</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="stat-item">
                    <h2 class="fw-bold mb-1">5+</h2>
                    <p class="mb-0">Tahun Pengalaman</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section py-5" id="layanan">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 fade-in">
                <h2 class="display-6 fw-bold">Kategori Alat Berat</h2>
                <p class="lead text-muted">Berbagai jenis alat berat untuk kebutuhan konstruksi Anda</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="service-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="service-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-truck text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Excavator</h5>
                        <p class="text-muted">Alat berat untuk penggalian dan pemindahan tanah dengan berbagai ukuran tersedia.</p>
                        <a href="{{ route('catalog.index', ['kategori' => 'excavator']) }}" class="btn btn-outline-warning">Lihat Detail</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="service-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="service-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-tractor text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Bulldozer</h5>
                        <p class="text-muted">Alat berat untuk mendorong dan meratakan tanah dengan kekuatan maksimal.</p>
                        <a href="{{ route('catalog.index', ['kategori' => 'bulldozer']) }}" class="btn btn-outline-warning">Lihat Detail</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="service-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="service-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-warehouse text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Wheel Loader</h5>
                        <p class="text-muted">Alat berat untuk memuat dan memindahkan material secara efisien.</p>
                        <a href="{{ route('catalog.index', ['kategori' => 'wheel-loader']) }}" class="btn btn-outline-warning">Lihat Detail</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="service-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="service-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-hammer text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Crane</h5>
                        <p class="text-muted">Alat angkat untuk konstruksi bangunan tinggi dengan kapasitas besar.</p>
                        <a href="{{ route('catalog.index', ['kategori' => 'crane']) }}" class="btn btn-outline-warning">Lihat Detail</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="service-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="service-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-shipping-fast text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Dump Truck</h5>
                        <p class="text-muted">Kendaraan untuk mengangkut material dalam jumlah besar.</p>
                        <a href="{{ route('catalog.index', ['kategori' => 'dump-truck']) }}" class="btn btn-outline-warning">Lihat Detail</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="service-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="service-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-road text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Compactor</h5>
                        <p class="text-muted">Alat untuk memadatkan tanah dan aspal dengan hasil maksimal.</p>
                        <a href="{{ route('catalog.index', ['kategori' => 'compactor']) }}" class="btn btn-outline-warning">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 fade-in">
            <a href="{{ route('catalog.index') }}" class="btn btn-warning btn-lg">
                <i class="fas fa-eye me-2"></i>Lihat Semua Alat
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section py-5 bg-light" id="tentang">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 fade-in">
                <img src="/images/about-construction.jpg" alt="Tentang Kami" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6 fade-in">
                <h2 class="display-6 fw-bold mb-4">Mengapa Memilih Kami?</h2>
                <p class="lead mb-4">{{ setting('site_name', 'Sewa Alat Berat') }} adalah partner terpercaya untuk kebutuhan alat berat konstruksi Anda.</p>
                
                <div class="why-choose-us">
                    <div class="feature-item d-flex align-items-start mb-3">
                        <div class="feature-icon bg-warning rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; min-width: 50px;">
                            <i class="fas fa-certificate text-dark"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Alat Berkualitas Tinggi</h6>
                            <p class="text-muted mb-0">Semua alat berat kami terawat dengan baik dan siap operasional.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item d-flex align-items-start mb-3">
                        <div class="feature-icon bg-warning rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; min-width: 50px;">
                            <i class="fas fa-clock text-dark"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Layanan 24/7</h6>
                            <p class="text-muted mb-0">Tim support kami siap membantu Anda kapan saja dibutuhkan.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item d-flex align-items-start mb-3">
                        <div class="feature-icon bg-warning rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; min-width: 50px;">
                            <i class="fas fa-money-bill-wave text-dark"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Harga Kompetitif</h6>
                            <p class="text-muted mb-0">Dapatkan harga terbaik untuk sewa alat berat berkualitas.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item d-flex align-items-start">
                        <div class="feature-icon bg-warning rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; min-width: 50px;">
                            <i class="fas fa-map-marker-alt text-dark"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Jangkauan Luas</h6>
                            <p class="text-muted mb-0">Melayani seluruh area {{ setting('service_area', 'Jabodetabek') }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5" id="kontak">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 fade-in">
                <h2 class="display-6 fw-bold">Hubungi Kami</h2>
                <p class="lead text-muted">Siap membantu kebutuhan alat berat proyek Anda</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4 fade-in">
                <div class="contact-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="contact-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-phone text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Telepon</h5>
                        <p class="text-muted">{{ setting('contact_phone', '+62 812-3456-7890') }}</p>
                        <a href="tel:{{ setting('contact_phone', '+62 812-3456-7890') }}" class="btn btn-outline-warning">
                            <i class="fas fa-phone me-1"></i>Hubungi Sekarang
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="contact-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="contact-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fab fa-whatsapp text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">WhatsApp</h5>
                        <p class="text-muted">Chat langsung dengan tim kami</p>
                        <a href="https://wa.me/{{ setting('whatsapp_number', '628123456789') }}" 
                           target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp me-1"></i>Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="contact-card card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="contact-icon bg-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-envelope text-dark fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Email</h5>
                        <p class="text-muted">{{ setting('contact_email', 'info@sewalat.com') }}</p>
                        <a href="mailto:{{ setting('contact_email', 'info@sewalat.com') }}" class="btn btn-outline-warning">
                            <i class="fas fa-envelope me-1"></i>Kirim Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 bg-dark text-white position-relative overflow-hidden">
    <div class="cta-bg position-absolute w-100 h-100" 
         style="background: linear-gradient(135deg, #2C3E50 0%, #FFC107 100%); opacity: 0.9;"></div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row text-center">
            <div class="col-12 fade-in">
                <h2 class="display-5 fw-bold mb-4">Siap Memulai Proyek Anda?</h2>
                <p class="lead mb-4">Dapatkan alat berat berkualitas untuk kesuksesan proyek konstruksi Anda</p>
                <div class="cta-buttons">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg me-3 mb-2">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-light btn-lg mb-2">
                            <i class="fas fa-truck me-2"></i>Lihat Katalog
                        </a>
                    @else
                        <a href="{{ route('catalog.index') }}" class="btn btn-warning btn-lg me-3 mb-2">
                            <i class="fas fa-truck me-2"></i>Mulai Booking
                        </a>
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" 
                           class="btn btn-outline-light btn-lg mb-2">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.hero {
    min-height: 100vh;
    position: relative;
}

.service-card, .contact-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.service-card:hover, .contact-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.stat-item h2 {
    font-size: 3rem;
}

.feature-item .feature-icon {
    transition: transform 0.3s ease;
}

.feature-item:hover .feature-icon {
    transform: scale(1.1);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.floating-icon {
    position: absolute;
    pointer-events: none;
}

@media (max-width: 768px) {
    .hero .display-3 {
        font-size: 2.5rem;
    }
    
    .stat-item h2 {
        font-size: 2rem;
    }
    
    .floating-elements {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add counter animation for stats
    const stats = document.querySelectorAll('.stat-item h2');
    
    const animateCounter = (element) => {
        const target = parseInt(element.textContent.replace(/\D/g, ''));
        const suffix = element.textContent.replace(/\d/g, '');
        let current = 0;
        const increment = target / 50;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + suffix;
        }, 50);
    };
    
    // Animate stats when they come into view
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const stat = entry.target.querySelector('h2');
                animateCounter(stat);
                statsObserver.unobserve(entry.target);
            }
        });
    });
    
    document.querySelectorAll('.stat-item').forEach(stat => {
        statsObserver.observe(stat);
    });
});
</script>
@endpush