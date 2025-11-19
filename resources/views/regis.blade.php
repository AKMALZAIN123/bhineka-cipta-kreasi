    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/regis.css') }}">
    @endsection

    @section('content')


<!-- Register Content -->
    <section class="register-section">
        <div class="register-container">
            <!-- Left Side - Branding -->
            <div class="register-left">
                <div class="brand-content">
                    <div class="brand-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h1>Bergabung Bersama Kami!</h1>
                    <p>Daftar sekarang dan nikmati berbagai keuntungan menjadi member Bhineka Cipta Kreasi</p>
                    
                    <div class="features">
                        <div class="feature-item">
                            <i class="fas fa-gift"></i>
                            <div>
                                <strong>Diskon Member</strong>
                                <span>Dapatkan harga khusus untuk semua produk</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-pencil-ruler"></i>
                            <div>
                                <strong>Desain Gratis</strong>
                                <span>Free design untuk order di atas 10m²</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Order History</strong>
                                <span>Lacak semua pesanan Anda dengan mudah</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shipping-fast"></i>
                            <div>
                                <strong>Prioritas Pengiriman</strong>
                                <span>Member mendapat prioritas produksi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="register-right">
                <div class="register-form-wrapper">
                    <div class="form-header">
                        <h2>Buat Akun Baru</h2>
                        <p>Sudah punya akun? <a href="login.html" class="link-primary">Masuk di sini</a></p>
                    </div>

                    <!-- Social Register -->
                    <div class="social-register">
                        <button class="social-btn google-btn">
                            <i class="fab fa-google"></i>
                            <span>Daftar dengan Google</span>
                        </button>
                        <button class="social-btn facebook-btn">
                            <i class="fab fa-facebook-f"></i>
                            <span>Daftar dengan Facebook</span>
                        </button>
                    </div>

                    <div class="divider">
                        <span>atau daftar dengan email</span>
                    </div>

                    <!-- Register Form -->
                    <form class="register-form" id="registerForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullName">
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap
                                </label>
                                <input 
                                    type="text" 
                                    id="fullName" 
                                    name="fullName" 
                                    placeholder="Masukkan nama lengkap"
                                    required
                                >
                                <span class="error-message" id="nameError"></span>
                            </div>
                        </div>

                        <div class="form-row">
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
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone"></i>
                                    Nomor Telepon
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    placeholder="08123456789"
                                    required
                                >
                                <span class="error-message" id="phoneError"></span>
                            </div>
                        </div>

                        <div class="form-row">
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
                                        placeholder="Minimal 6 karakter"
                                        required
                                    >
                                    <button type="button" class="toggle-password" id="togglePassword">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength" id="passwordStrength">
                                    <div class="strength-bar">
                                        <div class="strength-fill"></div>
                                    </div>
                                    <span class="strength-text"></span>
                                </div>
                                <span class="error-message" id="passwordError"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="confirmPassword">
                                    <i class="fas fa-lock"></i>
                                    Konfirmasi Password
                                </label>
                                <div class="password-input-wrapper">
                                    <input 
                                        type="password" 
                                        id="confirmPassword" 
                                        name="confirmPassword" 
                                        placeholder="Ketik ulang password"
                                        required
                                    >
                                    <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                <span class="error-message" id="confirmPasswordError"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                                <span class="checkbox-custom"></span>
                                <span>Saya setuju dengan <a href="#" class="link-primary">Syarat & Ketentuan</a> dan <a href="#" class="link-primary">Kebijakan Privasi</a></span>
                            </label>
                            <span class="error-message" id="termsError"></span>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="newsletter" name="newsletter">
                                <span class="checkbox-custom"></span>
                                <span>Saya ingin menerima promo dan penawaran menarik via email</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-primary btn-full" id="registerBtn">
                            <span class="btn-text">Daftar Sekarang</span>
                            <span class="btn-loader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>

                        <div class="form-footer">
                            <p>Sudah punya akun? <a href="login.html" class="link-primary">Masuk sekarang</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/regis.js') }}"></script>
    @endpush
