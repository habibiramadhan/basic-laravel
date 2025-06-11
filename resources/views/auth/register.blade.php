<!-- resources/views/auth/register.blade.php -->
<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>{{ setting('site_name', 'Sewa Alat Berat') }}</h4>
                        <p class="text-muted">Daftar akun baru</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <!-- Username -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Username *</label>
                                    <input id="name" 
                                           type="text" 
                                           name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autofocus 
                                           autocomplete="username"
                                           placeholder="Username untuk login">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Username akan digunakan untuk login</small>
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap *</label>
                                    <input id="nama_lengkap" 
                                           type="text" 
                                           name="nama_lengkap" 
                                           class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                           value="{{ old('nama_lengkap') }}" 
                                           required 
                                           autocomplete="name"
                                           placeholder="Nama lengkap sesuai KTP">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input id="email" 
                                           type="email" 
                                           name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email"
                                           placeholder="email@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- No Telepon -->
                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon" class="form-label">No. Telepon *</label>
                                    <input id="no_telepon" 
                                           type="text" 
                                           name="no_telepon" 
                                           class="form-control @error('no_telepon') is-invalid @enderror" 
                                           value="{{ old('no_telepon') }}" 
                                           required 
                                           autocomplete="tel"
                                           placeholder="+62812-3456-7890">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap *</label>
                                <textarea id="alamat" 
                                          name="alamat" 
                                          class="form-control @error('alamat') is-invalid @enderror" 
                                          rows="3" 
                                          required 
                                          autocomplete="address"
                                          placeholder="Alamat lengkap termasuk kota dan kode pos">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password *</label>
                                    <input id="password" 
                                           type="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Minimal 8 karakter">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
                                    <input id="password_confirmation" 
                                           type="password" 
                                           name="password_confirmation" 
                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Ulangi password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="mb-3">
                                <div class="alert alert-info">
                                    <small>
                                        <i class="fa fa-info-circle"></i>
                                        Dengan mendaftar, Anda menyetujui syarat dan ketentuan yang berlaku. 
                                        Akun yang dibuat akan memiliki role <strong>Customer</strong> secara otomatis.
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a class="text-decoration-none" href="{{ route('login') }}">
                                    Sudah punya akun? Masuk
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-user-plus"></i> Daftar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>