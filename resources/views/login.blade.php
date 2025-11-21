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
                        <button class="social-btn google-btn">
                            <i class="fab fa-google"></i>
                            <span>Masuk dengan Google</span>
                        </button>
                        <button class="social-btn facebook-btn">
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
                                required
                            >
                            <span class="error-message" id="emailError"></span>
                        </div>

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
                                    required
                                >
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <span class="error-message" id="passwordError"></span>
                        </div>

                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" id="remember" name="remember">
                                <span class="checkbox-custom"></span>
                                <span>Ingat saya</span>
                            </label>
                            <a href="forgot-password.html" class="link-primary">Lupa Password?</a>
                        </div>

                        <button type="submit" class="btn-primary btn-full" id="loginBtn">
                            <span class="btn-text">Masuk</span>
                            <span class="btn-loader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>

                        <div class="form-footer">
                            <p>Belum punya akun? <a href="{{ route('register.form') }}" class="link-primary">Daftar sekarang</a></p>
                        </div>
                    </form>

                    <!-- Demo Account Info -->
                    <div class="demo-info">
                        <i class="fas fa-info-circle"></i>
                        <span>Demo: email@demo.com / password: demo123</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    @endpush