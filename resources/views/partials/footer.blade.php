<!-- resources/views/partials/footer.blade.php -->
<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="text-warning mb-3">
                        <i class="fas fa-hard-hat me-2"></i>{{ setting('site_name', 'Sewa Alat Berat') }}
                    </h5>
                    <p class="text-muted">{{ setting('site_tagline', 'Solusi Penyewaan Alat Berat Terpercaya') }}</p>
                    
                    <div class="contact-info">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-warning me-3"></i>
                            <span>{{ setting('contact_address', 'Jl. Raya Bogor No. 123, Jakarta Selatan') }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-phone text-warning me-3"></i>
                            <span>{{ setting('contact_phone', '+62 812-3456-7890') }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-envelope text-warning me-3"></i>
                            <span>{{ setting('contact_email', 'info@sewalat.com') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <div class="footer-section">
                    <h6 class="text-warning mb-3">Menu Cepat</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="text-muted text-decoration-none">Katalog Alat</a></li>
                        <li><a href="#tentang" class="text-muted text-decoration-none">Tentang Kami</a></li>
                        <li><a href="#kontak" class="text-muted text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Services -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-section">
                    <h6 class="text-warning mb-3">Layanan</h6>
                    <ul class="list-unstyled footer-links">
                        <li><span class="text-muted">Sewa Excavator</span></li>
                        <li><span class="text-muted">Sewa Bulldozer</span></li>
                        <li><span class="text-muted">Sewa Crane</span></li>
                        <li><span class="text-muted">Sewa Dump Truck</span></li>
                        <li><span class="text-muted">Sewa Wheel Loader</span></li>
                    </ul>
                </div>
            </div>
            
            <!-- Business Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-section">
                    <h6 class="text-warning mb-3">Informasi</h6>
                    
                    <!-- Operating Hours -->
                    <div class="info-item mb-3">
                        <h6 class="small fw-bold mb-1">Jam Operasional</h6>
                        <p class="text-muted small mb-0">{{ setting('operational_hours', 'Senin - Jumat: 08:00 - 17:00 WIB') }}</p>
                    </div>
                    
                    <!-- Service Area -->
                    <div class="info-item mb-3">
                        <h6 class="small fw-bold mb-1">Area Layanan</h6>
                        <p class="text-muted small mb-0">{{ setting('service_area', 'Jakarta, Bogor, Depok, Tangerang, Bekasi') }}</p>
                    </div>
                    
                    <!-- Bank Info -->
                    <div class="info-item">
                        <h6 class="small fw-bold mb-1">Pembayaran Transfer</h6>
                        <div class="text-muted small">
                            <div><strong>{{ setting('bank_name', 'Bank BCA') }}</strong></div>
                            <div>{{ setting('bank_account', '1234-5678-9012') }}</div>
                            <div class="small">a.n {{ setting('bank_holder', 'PT Sewa Alat Berat Indonesia') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Social Media & WhatsApp -->
        <div class="row border-top border-secondary pt-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3">Hubungi Kami:</span>
                    <a href="https://wa.me/{{ setting('whatsapp_number', '628123456789') }}" 
                       target="_blank" class="btn btn-success btn-sm me-2">
                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                    </a>
                    <a href="tel:{{ setting('contact_phone', '+62 812-3456-7890') }}" 
                       class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-phone me-1"></i>Telepon
                    </a>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                @guest
                    <div class="auth-links">
                        <span class="text-muted me-2">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-warning text-decoration-none me-3">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Daftar Sekarang</a>
                    </div>
                @else
                    <div class="user-info">
                        <span class="text-muted">Selamat datang, </span>
                        <span class="text-warning fw-bold">{{ auth()->user()->nama_lengkap }}</span>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning btn-sm ms-2">Admin Panel</a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-warning btn-sm ms-2">Dashboard</a>
                        @endif
                    </div>
                @endguest
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="row border-top border-secondary pt-3 mt-3">
            <div class="col-12 text-center">
                <p class="text-muted mb-0">
                    {{ setting('footer_copyright', '© 2025 Sewa Alat Berat. All rights reserved.') }}
                </p>
                <small class="text-muted">
                    Made with <i class="fas fa-heart text-danger"></i> for Indonesian Construction Industry
                </small>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-links li {
    margin-bottom: 8px;
}

.footer-links a:hover {
    color: #ffc107 !important;
    text-decoration: underline !important;
}

.footer-section h5, .footer-section h6 {
    position: relative;
}

.footer-section h5::after, .footer-section h6::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 30px;
    height: 2px;
    background-color: #ffc107;
}

.contact-info .fas {
    width: 20px;
    text-align: center;
}

.info-item {
    border-left: 3px solid #ffc107;
    padding-left: 10px;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.btn-outline-warning:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
}

@media (max-width: 768px) {
    .text-md-end {
        text-align: start !important;
        margin-top: 20px;
    }
    
    .auth-links, .user-info {
        text-align: center !important;
    }
}
</style>