### Admin Sidebar Navigation
```html
<!-- resources/views/layouts/admin-sidebar.blade.php -->
<div class="sidebar bg-dark text-white">
    <div class="sidebar-header p-3">
        <h4>{{ setting('site_name', 'Admin Panel') }}</h4>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                    <i class="fa fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.equipment# Sistem Sewa Alat Berat - Laravel (SIMPLE)

Aplikasi web sederhana untuk penyewaan alat berat dengan booking online dan koordinasi manual via WhatsApp.

## Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade + Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Koordinasi**: WhatsApp/Telepon

## Prinsip SIMPLE

❌ **TIDAK ADA**: GPS tracking, QR code, foto kondisi, sistem rumit  
✅ **FOKUS PADA**: Booking online, payment upload, admin konfirmasi, koordinasi manual

## Installation

```bash
# Clone & install
git clone https://github.com/username/sewa-alat-berat.git
cd sewa-alat-berat
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed
php artisan storage:link

# Start development
npm run dev
php artisan serve
```

## Default Login

- **Admin**: admin@sewalat.com / admin123
- **Customer**: customer@example.com / customer123

## Flow System (SIMPLE)

### 👤 Customer Flow
```
Login → Pilih Alat → Booking → PILIH METODE BAYAR:
├── OPSI 1: Upload Bukti Transfer → Admin Verifikasi → Konfirmasi
└── OPSI 2: WhatsApp Admin → Chat Langsung → Admin Update Manual
→ Pakai Alat → Hubungi Admin "Selesai" → DONE
```

### 👨‍💼 Admin Flow  
```
Login → Lihat Booking → Kelola Pembayaran:
├── Upload Transfer: Cek Bukti → Approve/Reject
└── WhatsApp: Terima Chat → Update Status Manual
→ Customer Hubungi "Selesai" → Update Status → DONE
```

## Status Sederhana

### Status Alat
- **TERSEDIA**: Bisa disewa
- **DISEWA**: Sedang dipakai customer
- **MAINTENANCE**: Sedang diperbaiki

### Status Booking
- **PENDING**: Baru booking, belum bayar
- **DIKONFIRMASI**: Sudah bayar, siap kirim alat
- **BERLANGSUNG**: Alat sedang dipakai (opsional)
- **SELESAI**: Sewa selesai, alat dikembalikan

## Database Schema (Simple)

```sql
-- Users (Admin & Customer)
users: id, username, email, password, nama_lengkap, no_telepon, alamat, role

-- Kategori Alat
kategori_alat: id, nama_kategori, deskripsi, icon

-- Alat Berat
alat_berat: id, kategori_id, nama_alat, merk, harga_per_hari, foto_utama, status

-- Booking
pemesanan: id, kode_booking, user_id, alat_id, tanggal_mulai, tanggal_selesai, 
           total_harga, lokasi_penggunaan, status_pemesanan, contact_admin

-- Payment (2 Metode)
pembayaran: id, pemesanan_id, metode_pembayaran, bukti_transfer, jumlah_bayar, 
            status_bayar, catatan, verified_by

-- Website Settings (Admin Customizable)
website_settings: id, key, value, type, description

-- Metode Payment: 'upload_transfer', 'whatsapp_confirm'
```

## Fitur Utama

### 👤 Customer Features
- ✅ **Browse Equipment**: Katalog alat dengan filter kategori
- ✅ **Booking Online**: Form booking dengan kalkulasi harga otomatis
- ✅ **2 Metode Payment**: Upload bukti transfer ATAU WhatsApp konfirmasi
- ✅ **Booking History**: Riwayat semua booking
- ✅ **WhatsApp Contact**: Button hubungi admin langsung

### 👨‍💼 Admin Features
- ✅ **Dashboard Simple**: Overview booking hari ini
- ✅ **Manage Equipment**: CRUD alat berat
- ✅ **Dual Payment Verify**: Handle upload transfer & WhatsApp konfirmasi
- ✅ **Update Status**: Tandai booking selesai
- ✅ **Website Settings**: Customize nama web, footer, kontak info
- ✅ **Simple Reports**: Booking harian/bulanan

## Website Settings (Admin Customizable)

Admin dapat mengubah pengaturan website melalui dashboard tanpa perlu edit code:

### Settings Yang Bisa Diubah
- **Website Info**: Nama website, tagline, deskripsi
- **Contact Info**: Alamat, nomor telepon, email, WhatsApp
- **Bank Info**: Nama bank, nomor rekening, atas nama
- **Footer Info**: Copyright, social media links
- **Homepage**: Hero text, about us section
- **Operational**: Jam operasional, area layanan

### Database Structure
```sql
-- Tabel website_settings
CREATE TABLE website_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(100) UNIQUE NOT NULL,
    value TEXT,
    type ENUM('text', 'textarea', 'email', 'phone', 'url') DEFAULT 'text',
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO website_settings (key, value, type, description) VALUES
('site_name', 'Sewa Alat Berat', 'text', 'Nama Website'),
('site_tagline', 'Solusi Penyewaan Alat Berat Terpercaya', 'text', 'Tagline Website'),
('contact_phone', '+62 812-3456-7890', 'phone', 'Nomor Telepon'),
('contact_email', 'info@sewalat.com', 'email', 'Email Kontak'),
('contact_address', 'Jl. Raya Bogor No. 123, Jakarta', 'textarea', 'Alamat Lengkap'),
('whatsapp_number', '628123456789', 'phone', 'Nomor WhatsApp'),
('bank_name', 'Bank BCA', 'text', 'Nama Bank'),
('bank_account', '1234-5678-9012', 'text', 'Nomor Rekening'),
('bank_holder', 'PT Sewa Alat Berat Indonesia', 'text', 'Atas Nama Rekening'),
('footer_copyright', '© 2025 Sewa Alat Berat. All rights reserved.', 'text', 'Copyright Footer'),
('hero_title', 'Sewa Alat Berat Berkualitas', 'text', 'Judul Hero Homepage'),
('hero_subtitle', 'Dapatkan alat berat terbaik untuk proyek Anda', 'textarea', 'Subjudul Hero');
```

## Metode Pembayaran (2 Pilihan)
```
Customer booking → Pilih "Upload Bukti Transfer" → Upload foto bukti 
→ Admin cek di dashboard → Approve/Reject → Update status booking
```

### OPSI 2: WhatsApp Konfirmasi  
```
Customer booking → Pilih "WhatsApp Konfirmasi" → Klik tombol WA 
→ Chat admin langsung → Admin update status manual di dashboard
```

### Keuntungan Dual Method
- **Fleksibilitas**: Customer pilih sesuai preferensi
- **Tech-Savvy**: Upload untuk yang suka online
- **Personal Touch**: WhatsApp untuk yang suka chat langsung
- **Admin Control**: Semua metode terpusat di dashboard admin

## Koordinasi Manual (Simple)

### Pembayaran (2 Metode)
```
METODE 1: Admin verifikasi upload transfer di dashboard
METODE 2: Admin terima chat WA → update payment status manual
```
```
Admin konfirmasi booking → Telepon/WhatsApp customer 
→ Koordinasi waktu & lokasi pengiriman → Kirim alat
```

### Pengembalian Alat
```
Customer selesai pakai → WhatsApp admin "Alat sudah selesai"
→ Admin pickup alat → Update status "SELESAI" di sistem
```

### Contact Points
- **WhatsApp Admin**: +62 812-3456-7890
- **Button "Hubungi Admin"** di setiap booking customer
- **Direct call** dari dashboard admin

## Project Structure (Simple)

```
app/
├── Http/Controllers/
│   ├── HomeController.php           # Homepage
│   ├── Customer/
│   │   ├── DashboardController.php  # Customer dashboard
│   │   ├── CatalogController.php    # Browse equipment
│   │   └── BookingController.php    # Create booking & upload payment
│   └── Admin/
│       ├── DashboardController.php  # Admin dashboard
│       ├── EquipmentController.php  # CRUD alat
│       ├── BookingController.php    # Manage bookings
│       ├── PaymentController.php    # Verify payments
│       └── SettingsController.php   # Website settings
├── Models/
│   ├── User.php
│   ├── AlatBerat.php
│   ├── Pemesanan.php
│   ├── Pembayaran.php
│   └── WebsiteSetting.php        # Website settings model
└── Middleware/
    └── AdminMiddleware.php

resources/views/
├── layouts/
│   ├── app.blade.php      # Main layout
│   └── admin.blade.php    # Admin layout
├── customer/
│   ├── dashboard.blade.php
│   ├── catalog.blade.php
│   └── booking.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── equipment.blade.php
│   ├── bookings.blade.php
│   ├── payments.blade.php
│   └── settings.blade.php    # Website settings
└── welcome.blade.php      # Homepage
```

## Routes (Simple)

```php
// Public
Route::get('/', [HomeController::class, 'index']);
Route::get('/catalog', [CatalogController::class, 'index']);

// Customer (after login)
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index']);
    Route::get('/catalog', [CatalogController::class, 'customer']);
    Route::resource('booking', BookingController::class);
    Route::post('/payment', [BookingController::class, 'uploadPayment']);
});

// Admin (after login)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::resource('equipment', EquipmentController::class);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/verify-payment/{id}', [PaymentController::class, 'verify']);
    Route::post('/complete-booking/{id}', [BookingController::class, 'complete']);
});
```

## Blade Templates (Simple)

### Admin Website Settings
```html
<!-- resources/views/admin/settings.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Pengaturan Website</h2>
    
    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <!-- Website Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fa fa-globe"></i> Informasi Website</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Website</label>
                            <input type="text" class="form-control" name="site_name" 
                                   value="{{ setting('site_name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tagline</label>
                            <input type="text" class="form-control" name="site_tagline" 
                                   value="{{ setting('site_tagline') }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Hero Homepage</label>
                    <input type="text" class="form-control" name="hero_title" 
                           value="{{ setting('hero_title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Subtitle Hero</label>
                    <textarea class="form-control" name="hero_subtitle" rows="3">{{ setting('hero_subtitle') }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Contact Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fa fa-phone"></i> Informasi Kontak</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="contact_phone" 
                                   value="{{ setting('contact_phone') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_email" 
                                   value="{{ setting('contact_email') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">WhatsApp (628xxxxx)</label>
                            <input type="text" class="form-control" name="whatsapp_number" 
                                   value="{{ setting('whatsapp_number') }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" name="contact_address" rows="3">{{ setting('contact_address') }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Bank Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fa fa-credit-card"></i> Informasi Bank</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" name="bank_name" 
                                   value="{{ setting('bank_name') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" name="bank_account" 
                                   value="{{ setting('bank_account') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" class="form-control" name="bank_holder" 
                                   value="{{ setting('bank_holder') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fa fa-footer"></i> Footer Website</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Copyright Text</label>
                    <input type="text" class="form-control" name="footer_copyright" 
                           value="{{ setting('footer_copyright') }}">
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
```
```html
<!-- resources/views/customer/payment-method.blade.php -->
<div class="container">
    <h2>Pilih Metode Pembayaran</h2>
    
    <div class="row">
        <!-- OPSI 1: Upload Transfer -->
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fa fa-upload fa-3x text-primary mb-3"></i>
                    <h5>Upload Bukti Transfer</h5>
                    <p>Transfer ke rekening kami dan upload bukti</p>
                    <form action="{{ route('customer.payment.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="metode" value="upload_transfer">
                        
                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Transfer</label>
                            <input type="file" class="form-control" name="bukti_transfer" accept="image/*,application/pdf" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-upload"></i> Upload Bukti
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- OPSI 2: WhatsApp -->
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fab fa-whatsapp fa-3x text-success mb-3"></i>
                    <h5>Konfirmasi via WhatsApp</h5>
                    <p>Chat langsung dengan admin untuk koordinasi pembayaran</p>
                    
                    <form action="{{ route('customer.payment.whatsapp') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="metode" value="whatsapp_confirm">
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fab fa-whatsapp"></i> Chat Admin Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Info Transfer -->
    <div class="alert alert-info mt-4">
        <strong>Informasi Transfer:</strong><br>
        Bank BCA: 1234-5678-9012<br>
        A.n: PT Sewa Alat Berat Indonesia<br>
        <strong>Total Pembayaran: Rp {{ number_format($booking->total_harga) }}</strong><br>
        <small>Kode Booking: {{ $booking->kode_booking }}</small>
    </div>
</div>
@endsection
```
```html
<!-- resources/views/customer/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard Customer</h2>
    
    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $totalBooking }}</h3>
                    <p>Total Booking</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Current Bookings -->
    <div class="card">
        <div class="card-header">
            <h5>Booking Aktif</h5>
        </div>
        <div class="card-body">
            @foreach($activeBookings as $booking)
            <div class="d-flex justify-content-between">
                <div>
                    <strong>{{ $booking->alat->nama_alat }}</strong><br>
                    <small>{{ $booking->tanggal_mulai }} - {{ $booking->tanggal_selesai }}</small>
                </div>
                <div>
                    <span class="badge bg-primary">{{ $booking->status_pemesanan }}</span>
                    <a href="https://wa.me/628123456789" class="btn btn-sm btn-success">
                        <i class="fa fa-whatsapp"></i> Hubungi Admin
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
```

### Dynamic Footer Template
```html
<!-- resources/views/layouts/footer.blade.php -->
<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-md-4 mb-4">
                <h5>{{ setting('site_name') }}</h5>
                <p class="text-muted">{{ setting('site_tagline') }}</p>
                <p><small>{{ setting('footer_copyright') }}</small></p>
            </div>
            
            <!-- Contact Info -->
            <div class="col-md-4 mb-4">
                <h5>Kontak Kami</h5>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa fa-map-marker-alt me-2"></i>
                    <span>{{ setting('contact_address') }}</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa fa-phone me-2"></i>
                    <span>{{ setting('contact_phone') }}</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa fa-envelope me-2"></i>
                    <span>{{ setting('contact_email') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fab fa-whatsapp me-2"></i>
                    <a href="https://wa.me/{{ setting('whatsapp_number') }}" class="text-success">
                        Chat WhatsApp
                    </a>
                </div>
            </div>
            
            <!-- Bank Info -->
            <div class="col-md-4 mb-4">
                <h5>Informasi Transfer</h5>
                <div class="border p-3 rounded bg-light text-dark">
                    <strong>{{ setting('bank_name') }}</strong><br>
                    <span>{{ setting('bank_account') }}</span><br>
                    <small>a.n {{ setting('bank_holder') }}</small>
                </div>
            </div>
        </div>
        
        <hr class="border-secondary">
        
        <!-- Quick Links -->
        <div class="row">
            <div class="col-md-6">
                <h6>Menu Cepat</h6>
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a><br>
                        <a href="{{ route('catalog') }}" class="text-muted text-decoration-none">Katalog Alat</a><br>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none">Login</a><br>
                        <a href="{{ route('register') }}" class="text-muted text-decoration-none">Daftar</a><br>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h6>Jam Operasional</h6>
                <p class="text-muted mb-0">Senin - Jumat: 08:00 - 17:00 WIB</p>
                <p class="text-muted">Sabtu: 08:00 - 15:00 WIB</p>
            </div>
        </div>
    </div>
</footer>
```
```html
<!-- resources/views/admin/payments.blade.php -->
<div class="container">
    <h2>Kelola Pembayaran</h2>
    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Customer</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->pemesanan->kode_booking }}</td>
                        <td>{{ $payment->pemesanan->user->nama_lengkap }}</td>
                        <td>
                            @if($payment->metode_pembayaran == 'upload_transfer')
                                <span class="badge bg-primary">
                                    <i class="fa fa-upload"></i> Upload Transfer
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($payment->jumlah_bayar) }}</td>
                        <td>
                            @if($payment->status_bayar == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($payment->status_bayar == 'verified')
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->status_bayar == 'pending')
                                <!-- Untuk Upload Transfer -->
                                @if($payment->metode_pembayaran == 'upload_transfer' && $payment->bukti_transfer)
                                    <button class="btn btn-sm btn-info" onclick="viewProof('{{ Storage::url($payment->bukti_transfer) }}')">
                                        <i class="fa fa-eye"></i> Lihat Bukti
                                    </button>
                                @endif
                                
                                <!-- Action Buttons -->
                                <form method="POST" action="{{ route('admin.payment.verify', $payment->id) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.payment.verify', $payment->id) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </form>
                            @else
                                <small class="text-muted">
                                    {{ $payment->verified_at ? $payment->verified_at->format('d/m/Y H:i') : '-' }}
                                    <br>by {{ $payment->verified_by }}
                                </small>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal untuk lihat bukti transfer -->
<div class="modal fade" id="proofModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="proofImage" src="" class="img-fluid" alt="Bukti Transfer">
            </div>
        </div>
    </div>
</div>

<script>
function viewProof(imageUrl) {
    document.getElementById('proofImage').src = imageUrl;
    new bootstrap.Modal(document.getElementById('proofModal')).show();
}
</script>
@endsection
```
```html
<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Dashboard Admin</h2>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $pendingBookings }}</h3>
                    <p>Booking Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $pendingPayments }}</h3>
                    <p>Payment Pending</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Bookings -->
    <div class="card">
        <div class="card-header">
            <h5>Booking Terbaru</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    @foreach($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->kode_booking }}</td>
                        <td>{{ $booking->user->nama_lengkap }}</td>
                        <td>{{ $booking->alat->nama_alat }}</td>
                        <td>
                            <span class="badge bg-warning">{{ $booking->status_pemesanan }}</span>
                        </td>
                        <td>
                            @if($booking->status_pemesanan == 'berlangsung')
                            <button class="btn btn-sm btn-success" onclick="completeBooking({{ $booking->id }})">
                                Tandai Selesai
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
```

## Key Laravel Features

### Website Settings System
- **Dynamic Content**: Footer, header, contact info dapat diubah admin
- **Cache Integration**: Settings di-cache untuk performa optimal
- **Helper Function**: `setting('key', 'default')` untuk akses mudah
- **Type Validation**: Text, textarea, email, phone validation
- **Admin Interface**: Form user-friendly untuk update settings

### Multi-Payment System
- **Dual Method**: Upload transfer & WhatsApp confirmation
- **File Management**: Secure file upload dengan validation
- **Admin Verification**: Unified dashboard untuk kedua metode
- **Dynamic Bank Info**: Info bank bisa diubah di settings

### Simple Architecture
- **Clean Models**: Eloquent relationships yang jelas
- **Controller Logic**: Simple CRUD dengan business logic
- **Blade Components**: Reusable UI components
- **Middleware Protection**: Role-based access control

### Website Settings Controller & Model
```php
// app/Models/WebsiteSetting.php
class WebsiteSetting extends Model
{
    protected $table = 'website_settings';
    
    protected $fillable = ['key', 'value', 'type', 'description'];
    
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
    
    public static function getAll()
    {
        return static::pluck('value', 'key');
    }
}

// app/Http/Controllers/Admin/SettingsController.php
class SettingsController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::getAll();
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
        ]);
        
        // Update all settings
        foreach ($request->except(['_token']) as $key => $value) {
            WebsiteSetting::set($key, $value);
        }
        
        // Clear cache if using cache
        Cache::forget('website_settings');
        
        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}

// Helper function - app/helpers.php atau Service Provider
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            return WebsiteSetting::get($key, $default);
        });
    }
}

// Middleware untuk share settings ke semua view
// app/Http/Middleware/ShareWebsiteSettings.php
class ShareWebsiteSettings
{
    public function handle(Request $request, Closure $next)
    {
        $settings = Cache::remember('website_settings', 3600, function () {
            return WebsiteSetting::getAll();
        });
        
        View::share('websiteSettings', $settings);
        
        return $next($request);
    }
}
```
```php
// app/Http/Controllers/Customer/PaymentController.php
class PaymentController extends Controller
{
    public function uploadTransfer(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:pemesanan,id',
            'bukti_transfer' => 'required|image|max:2048', // Max 2MB
        ]);
        
        $booking = Pemesanan::findOrFail($request->booking_id);
        
        // Upload file
        $path = $request->file('bukti_transfer')->store('payments', 'public');
        
        // Create payment record
        Pembayaran::create([
            'pemesanan_id' => $booking->id,
            'metode_pembayaran' => 'upload_transfer',
            'bukti_transfer' => $path,
            'jumlah_bayar' => $booking->total_harga,
            'tanggal_bayar' => now(),
            'status_bayar' => 'pending'
        ]);
        
        return redirect()->route('customer.dashboard')
            ->with('success', 'Bukti transfer berhasil diupload. Menunggu verifikasi admin.');
    }
    
    public function whatsappConfirm(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:pemesanan,id',
        ]);
        
        $booking = Pemesanan::findOrFail($request->booking_id);
        
        // Create payment record for WhatsApp method
        Pembayaran::create([
            'pemesanan_id' => $booking->id,
            'metode_pembayaran' => 'whatsapp_confirm',
            'jumlah_bayar' => $booking->total_harga,
            'tanggal_bayar' => now(),
            'status_bayar' => 'pending',
            'catatan' => 'Menunggu konfirmasi via WhatsApp'
        ]);
        
        // Generate WhatsApp link with booking details
        $message = "Halo Admin, saya ingin konfirmasi pembayaran untuk:\n\n";
        $message .= "Kode Booking: {$booking->kode_booking}\n";
        $message .= "Alat: {$booking->alat->nama_alat}\n";
        $message .= "Total: Rp " . number_format($booking->total_harga) . "\n";
        $message .= "Periode: {$booking->tanggal_mulai} sampai {$booking->tanggal_selesai}\n\n";
        $message .= "Saya sudah transfer pembayaran. Mohon dikonfirmasi. Terima kasih.";
        
        $waNumber = '628123456789'; // Admin WhatsApp number
        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
        
        return redirect()->away($waLink);
    }
}

// app/Http/Controllers/Admin/PaymentController.php
class PaymentController extends Controller
{
    public function verify(Request $request, $paymentId)
    {
        $payment = Pembayaran::findOrFail($paymentId);
        $action = $request->action;
        
        if ($action == 'approve') {
            $payment->update([
                'status_bayar' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->user()->nama_lengkap
            ]);
            
            // Update booking status
            $payment->pemesanan->update(['status_pemesanan' => 'dikonfirmasi']);
            
            $message = 'Pembayaran berhasil diverifikasi';
        } else {
            $payment->update([
                'status_bayar' => 'rejected',
                'catatan' => $request->catatan ?? 'Ditolak oleh admin'
            ]);
            
            $message = 'Pembayaran ditolak';
        }
        
        return redirect()->back()->with('success', $message);
    }
}
```
```php
// app/Models/Pemesanan.php
class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function alat()
    {
        return $this->belongsTo(AlatBerat::class, 'alat_id');
    }
    
    // Generate booking code
    public static function generateKodeBooking()
    {
        return 'SWA' . date('Ymd') . str_pad(static::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);
    }
}
```

### Homepage with Dynamic Content
```php
<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Hero Section with Dynamic Content -->
<section class="hero bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">{{ setting('hero_title', 'Sewa Alat Berat Berkualitas') }}</h1>
                <p class="lead">{{ setting('hero_subtitle', 'Dapatkan alat berat terbaik untuk proyek Anda dengan layanan terpercaya dan harga kompetitif.') }}</p>
                <div class="mt-4">
                    <a href="{{ route('catalog') }}" class="btn btn-light btn-lg me-3">
                        <i class="fa fa-search"></i> Lihat Katalog
                    </a>
                    <a href="https://wa.me/{{ setting('whatsapp_number') }}" class="btn btn-success btn-lg">
                        <i class="fab fa-whatsapp"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="/assets/img/hero-equipment.jpg" alt="Alat Berat" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Quick Contact Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa fa-phone fa-2x text-primary mb-3"></i>
                        <h5>Telepon</h5>
                        <p class="text-muted">{{ setting('contact_phone') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fab fa-whatsapp fa-2x text-success mb-3"></i>
                        <h5>WhatsApp</h5>
                        <a href="https://wa.me/{{ setting('whatsapp_number') }}" class="btn btn-success btn-sm">
                            Chat Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fa fa-envelope fa-2x text-info mb-3"></i>
                        <h5>Email</h5>
                        <p class="text-muted">{{ setting('contact_email') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Equipment -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Alat Berat Pilihan</h2>
        <div class="row">
            @foreach($featuredEquipment as $equipment)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $equipment->foto_utama ? Storage::url($equipment->foto_utama) : '/assets/img/no-image.jpg' }}" 
                         class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $equipment->nama_alat }}</h5>
                        <p class="text-muted">{{ $equipment->merk }} {{ $equipment->model }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary">Rp {{ number_format($equipment->harga_per_hari) }}/hari</span>
                            <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-primary btn-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">
                Lihat Semua Alat <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endsection
```
```php
// app/Models/Pembayaran.php
class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'pemesanan_id',
        'metode_pembayaran',
        'bukti_transfer',
        'jumlah_bayar',
        'tanggal_bayar',
        'status_bayar',
        'catatan',
        'verified_at',
        'verified_by'
    ];
    
    protected $casts = [
        'tanggal_bayar' => 'date',
        'verified_at' => 'datetime',
        'jumlah_bayar' => 'decimal:2'
    ];
    
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
    
    public function isUploadMethod()
    {
        return $this->metode_pembayaran === 'upload_transfer';
    }
    
    public function isWhatsappMethod()
    {
        return $this->metode_pembayaran === 'whatsapp_confirm';
    }
    
    public function getBuktiTransferUrlAttribute()
    {
        return $this->bukti_transfer ? Storage::url($this->bukti_transfer) : null;
    }
}
```
```php
// app/Http/Controllers/Admin/BookingController.php
public function complete(Request $request, $id)
{
    $booking = Pemesanan::findOrFail($id);
    
    // Update status booking
    $booking->update(['status_pemesanan' => 'selesai']);
    
    // Update status alat jadi tersedia
    $booking->alat->update(['status' => 'tersedia']);
    
    return redirect()->back()->with('success', 'Booking berhasil diselesaikan');
}
```

## Deployment (Simple)

```bash
# Production setup
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Set .env production
APP_ENV=production
APP_DEBUG=false
```

## Best Practices

### Security
- ✅ Laravel built-in CSRF protection
- ✅ SQL injection protection via Eloquent
- ✅ File upload validation
- ✅ Role-based access control

### Performance
- ✅ Database indexing pada foreign keys
- ✅ Eager loading untuk relasi
- ✅ Cache config untuk production
- ✅ Image optimization untuk foto alat

### User Experience
- ✅ Responsive design dengan Bootstrap 5
- ✅ Loading states untuk form submissions
- ✅ Clear error messages
- ✅ WhatsApp direct contact buttons

## Support

**Admin Contact:**
- WhatsApp: +62 812-3456-7890
- Email: admin@sewalat.com

**Development:**
- Framework: Laravel 10.x
- UI Framework: Bootstrap 5
- Database: MySQL

---

**FILOSOFI**: Sistem yang SIMPLE tapi EFEKTIF. Fokus pada booking online, sisanya koordinasi manual untuk fleksibilitas maksimal.