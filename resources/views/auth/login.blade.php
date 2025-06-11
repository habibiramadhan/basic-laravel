<!-- resources/views/auth/login.blade.php -->
<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>{{ setting('site_name', 'Sewa Alat Berat') }}</h4>
                        <p class="text-muted">Masuk ke akun Anda</p>
                    </div>
                    <div class="card-body">
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Username atau Email -->
                            <div class="mb-3">
                                <label for="login" class="form-label">Username atau Email</label>
                                <input id="login" 
                                       type="text" 
                                       name="login" 
                                       class="form-control @error('login') is-invalid @enderror" 
                                       value="{{ old('login') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="username"
                                       placeholder="Masukkan username atau email">
                                @error('login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="Masukkan password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="remember" 
                                       name="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        Lupa password?
                                    </a>
                                @endif

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-sign-in-alt"></i> Masuk
                                </button>
                            </div>
                        </form>

                        <hr>
                        
                        <div class="text-center">
                            <p class="mb-0">Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-decoration-none">
                                    Daftar sekarang
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Demo Accounts -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title">🎯 Demo Accounts</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Admin:</strong><br>
                                    Username: <code>Admin</code><br>
                                    Email: <code>admin@sewalat.com</code><br>
                                    Password: <code>admin123</code>
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Customer:</strong><br>
                                    Username: <code>Customer</code><br>
                                    Email: <code>customer@example.com</code><br>
                                    Password: <code>customer123</code>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>