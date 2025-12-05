@extends('layouts.app')

@section('title', 'Checkout')

@section('css')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')

<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-items">
            <a href="{{ route('home') }}">
                <i class="fas fa-home"></i>
                Beranda
            </a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('cart') }}">Keranjang</a>
            <i class="fas fa-chevron-right"></i>
            <span>Checkout</span>
        </div>
    </div>
</section>

<!-- Checkout Section -->
<section class="checkout-section">
    <div class="container">
        <div class="checkout-header">
            <h1>Checkout</h1>
            <p>Lengkapi informasi pesanan Anda</p>
        </div>

        <div class="checkout-layout">
            <!-- Left Side - Form -->
            <div class="checkout-form">
                <!-- Contact Information -->
                <div class="form-section" id="contactSection">
                    <h2>
                        <i class="fas fa-user"></i>
                        Informasi Kontak
                    </h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nama Lengkap *</label>
                            <input type="text" id="name" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon *</label>
                            <input type="tel" id="phone" placeholder="081234567890" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="email">Email *</label>
                            <input type="email" id="email" placeholder="john@example.com" required>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="form-section">
                    <h2>
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat Pengiriman
                    </h2>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="address">Alamat Lengkap *</label>
                            <textarea id="address" rows="3" placeholder="Jl. Raya Prompong RT 04/04" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="district">Kecamatan *</label>
                            <input type="text" id="district" placeholder="Baturaden" required>
                        </div>
                        <div class="form-group">
                            <label for="city">Kabupaten/Kota *</label>
                            <input type="text" id="city" placeholder="Banyumas" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Provinsi *</label>
                            <input type="text" id="province" placeholder="Jawa Tengah" required>
                        </div>
                        <div class="form-group">
                            <label for="postalCode">Kode Pos *</label>
                            <input type="text" id="postalCode" placeholder="53151" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="notes">Catatan Alamat (Opsional)</label>
                            <input type="text" id="notes" placeholder="Patokan/landmark (contoh: dekat masjid)">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="form-section">
                    <h2>
                        <i class="fas fa-credit-card"></i>
                        Metode Pembayaran
                    </h2>
                    
                    <div class="payment-category">
                        <h3 class="payment-category-title">
                            <i class="fas fa-university"></i>
                            Transfer Bank
                        </h3>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment" value="bca" checked>
                                <div class="payment-card">
                                    <div class="payment-icon bank-bca">
                                        <span>BCA</span>
                                    </div>
                                    <div class="payment-info">
                                        <h4>Bank BCA</h4>
                                        <p>Bank Central Asia</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment" value="bni">
                                <div class="payment-card">
                                    <div class="payment-icon bank-bni">
                                        <span>BNI</span>
                                    </div>
                                    <div class="payment-info">
                                        <h4>Bank BNI</h4>
                                        <p>Bank Negara Indonesia</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment" value="bri">
                                <div class="payment-card">
                                    <div class="payment-icon bank-bri">
                                        <span>BRI</span>
                                    </div>
                                    <div class="payment-info">
                                        <h4>Bank BRI</h4>
                                        <p>Bank Rakyat Indonesia</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment" value="mandiri">
                                <div class="payment-card">
                                    <div class="payment-icon bank-mandiri">
                                        <span>Mandiri</span>
                                    </div>
                                    <div class="payment-info">
                                        <h4>Bank Mandiri</h4>
                                        <p>Bank Mandiri Indonesia</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="payment-category">
                        <h3 class="payment-category-title">
                            <i class="fas fa-wallet"></i>
                            E-Wallet
                        </h3>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment" value="gopay">
                                <div class="payment-card">
                                    <div class="payment-icon ewallet-gopay">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="payment-info">
                                        <h4>GoPay</h4>
                                        <p>Digital wallet Gojek</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment" value="dana">
                                <div class="payment-card">
                                    <div class="payment-icon ewallet-dana">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="payment-info">
                                        <h4>DANA</h4>
                                        <p>Digital wallet DANA</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment" value="ovo">
                                <div class="payment-card">
                                    <div class="payment-icon ewallet-ovo">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="payment-info">
                                        <h4>OVO</h4>
                                        <p>Digital wallet OVO</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment" value="qris">
                                <div class="payment-card">
                                    <div class="payment-icon ewallet-qris">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <div class="payment-info">
                                        <h4>QRIS</h4>
                                        <p>Scan QR untuk bayar</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="form-section">
                    <h2>
                        <i class="fas fa-comment"></i>
                        Catatan Pesanan (Opsional)
                    </h2>
                    <div class="form-group">
                        <textarea id="orderNotes" rows="4" placeholder="Contoh: Tolong kirim pada pagi hari, atau hubungi sebelum mengirim"></textarea>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="terms-section">
                    <div class="form-checkbox">
                        <input type="checkbox" id="agreeTerms" required>
                        <label for="agreeTerms">
                            Saya setuju dengan <a href="{{ route('terms') }}" target="_blank">Syarat & Ketentuan</a>
                        </label>
                    </div>
                </div>

                <!-- Submit Button (Mobile) -->
                <button class="btn-submit mobile-submit" id="btnSubmitMobile">
                    <i class="fas fa-lock"></i>
                    Bayar Sekarang
                </button>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="order-summary">
                <h2>Ringkasan Pesanan</h2>

                <!-- Products List -->
                <div class="summary-products" id="summaryProducts">
                    <!-- Will be populated by JS -->
                </div>

                <div class="summary-divider"></div>

                <!-- Price Details -->
                <div class="summary-details">
                    <div class="summary-row">
                        <span>Subtotal <span class="item-count" id="itemCount">(0 produk)</span></span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman</span>
                        <span id="shipping">Rp 10.000</span>
                    </div>
                </div>

                <div class="summary-divider"></div>

                <!-- Total -->
                <div class="summary-total">
                    <span>Total Pembayaran</span>
                    <span class="total-price" id="totalPrice">Rp 0</span>
                </div>

                <!-- Delivery Info -->
                <div class="delivery-info">
                    <i class="fas fa-truck"></i>
                    <div>
                        <strong>Estimasi Pengiriman</strong>
                        <p>2-3 hari kerja (bisa lebih cepat atau lambat)</p>
                    </div>
                </div>

                <!-- Security Badge -->
                <div class="security-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Transaksi Aman & Terpercaya</span>
                </div>

                <!-- Submit Button (Desktop) -->
                <button class="btn-submit" id="btnSubmit">
                    <i class="fas fa-lock"></i>
                    Bayar Sekarang
                </button>

                <a href="{{ route('cart') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Error Modal Component -->
<x-error-modal />

@endsection

@push('scripts')
<!-- Midtrans Snap Script -->
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
// CSRF Token untuk Laravel
const csrfToken = '{{ csrf_token() }}';
const checkoutUrl = '{{ route("checkout.process") }}';
const successUrl = '{{ route("order.success") }}';
const pendingUrl = '{{ route("order.pending") }}';
</script>

<script src="{{ asset('js/checkout.js') }}"></script>
@endpush