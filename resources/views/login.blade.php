@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<!-- Login Content -->
<section class="login-section">
    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="login-left">
            <div class="brand-content">
                <div class="brand-icon">
                    <i class="fas fa-print"></i>
                </div>
                <h1>Selamat Datang Kembali!</h1>
                <p>Masuk untuk mengakses layanan percetakan dan periklanan terbaik untuk bisnis Anda</p>
                
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Desain Gratis untuk Order Besar</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Tracking Order Real-time</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Harga Khusus Member</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>History Pemesanan Tersimpan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-form-wrapper">
                <div class="form-header">
                    <h2>Masuk ke Akun Anda</h2>
                    <p>Belum punya akun? <a href="{{ route('register.form') }}" class="link-primary">Daftar Sekarang</a></p>
                </div>

                <!-- Social Login -->
                <div class="social-login">
                    <button class="social-btn google-btn" type="button">
                        <i class="fab fa-google"></i>
                        <span>Masuk dengan Google</span>
                    </button>
                    <button class="social-btn facebook-btn" type="button">
                        <i class="fab fa-facebook-f"></i>
                        <span>Masuk dengan Facebook</span>
                    </button>
                </div>

                <div class="divider">
                    <span>atau masuk dengan email</span>
                </div>

                <!-- Login Form -->
                <form class="login-form" id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="nama@email.com"
                            value="{{ old('email') }}"
                            class="@error('email') is-invalid @enderror"
                            data-backend-error="{{ $errors->first('email') }}"
                        >
                        <span class="error-message"></span>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Masukkan password Anda"
                                class="@error('password') is-invalid @enderror"
                                data-backend-error="{{ $errors->first('password') }}"
                            >
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        <span class="error-message"></span>
                    </div>

                    <!-- Form Options -->
                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkbox-custom"></span>
                            <span>Ingat saya</span>
                        </label>
                        <a href="" class="link-primary">Lupa Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary btn-full" id="loginBtn">
                        <span class="btn-text">Masuk</span>
                        <span class="btn-loader" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>    
                    </button>

                    <!-- Form Footer -->
                    <div class="form-footer">
                        <p>Belum punya akun? <a href="{{ route('register.form') }}" class="link-primary">Daftar sekarang</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/login.js') }}"></script>
@endpush