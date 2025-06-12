<!-- resources/views/profile/edit.blade.php -->
@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('title', 'Edit Profile')

@if(auth()->user()->isAdmin())
    @section('page-title', 'Edit Profile')
    @section('page-subtitle', 'Kelola informasi akun admin')
@else
    @section('content-header')
        <div class="bg-warning text-dark py-4 mb-4">
            <div class="container">
                <h2 class="mb-0">Edit Profile</h2>
                <p class="mb-0">Kelola informasi akun Anda</p>
            </div>
        </div>
    @endsection
@endif

@section('content')
<div class="container{{ auth()->user()->isAdmin() ? '-fluid' : '' }}">
    
    @if(!auth()->user()->isAdmin())
        @yield('content-header')
    @endif
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Informasi Profile
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') ?? $user->name }}" 
                                       placeholder="Username untuk login" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" 
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') ?? $user->email }}" 
                                       placeholder="Email aktif" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror"
                                       value="{{ old('nama_lengkap') ?? $user->nama_lengkap }}" 
                                       placeholder="Nama lengkap sesuai KTP" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="no_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="no_telepon" id="no_telepon" 
                                       class="form-control @error('no_telepon') is-invalid @enderror"
                                       value="{{ old('no_telepon') ?? $user->no_telepon }}" 
                                       placeholder="08xx-xxxx-xxxx" required>
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" rows="3" 
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      placeholder="Alamat lengkap tempat tinggal" required>{{ old('alamat') ?? $user->alamat }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" 
                                   value="{{ $user->isAdmin() ? 'Administrator' : 'Customer' }}" readonly>
                            <div class="form-text">Role tidak dapat diubah</div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ $user->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lock me-2"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Masukkan password saat ini" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Password baru minimal 8 karakter" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control"
                                       placeholder="Ulangi password baru" required>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-warning rounded-circle p-3 d-inline-block">
                            <i class="fas fa-user fa-2x text-dark"></i>
                        </div>
                    </div>
                    
                    <table class="table table-borderless small">
                        <tr>
                            <td width="40%" class="fw-bold">Nama:</td>
                            <td>{{ $user->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Username:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Role:</td>
                            <td>
                                <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-success' }}">
                                    {{ $user->isAdmin() ? 'Administrator' : 'Customer' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Bergabung:</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Update Terakhir:</td>
                            <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if(!$user->isAdmin())
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Booking
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $userStats = [
                            'total_booking' => $user->pemesanan()->count(),
                            'booking_selesai' => $user->pemesanan()->where('status_pemesanan', 'selesai')->count(),
                            'booking_aktif' => $user->pemesanan()->whereIn('status_pemesanan', ['dikonfirmasi', 'berlangsung'])->count(),
                            'total_spent' => $user->pemesanan()->where('status_pemesanan', 'selesai')->sum('total_harga')
                        ];
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-6 mb-2">
                            <div class="fw-bold text-primary">{{ $userStats['total_booking'] }}</div>
                            <small class="text-muted">Total Booking</small>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="fw-bold text-success">{{ $userStats['booking_selesai'] }}</div>
                            <small class="text-muted">Selesai</small>
                        </div>
                        <div class="col-12">
                            <div class="fw-bold text-warning">Rp {{ number_format($userStats['total_spent'], 0, ',', '.') }}</div>
                            <small class="text-muted">Total Spent</small>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Phone number formatting
    const phoneInput = document.getElementById('no_telepon');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        
        // Format: 08xx-xxxx-xxxx
        if (value.length > 4 && value.length <= 8) {
            value = value.substr(0, 4) + '-' + value.substr(4);
        } else if (value.length > 8) {
            value = value.substr(0, 4) + '-' + value.substr(4, 4) + '-' + value.substr(8, 4);
        }
        
        e.target.value = value;
    });
    
    // Password match validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Password tidak cocok');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
});
</script>
@endpush

@push('styles')
<style>
.table-borderless td {
    padding: 0.25rem 0;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endpush