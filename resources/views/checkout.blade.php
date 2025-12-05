    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    @endsection

    @section('content')

        <!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-items">
                <a href="index.html">
                    <i class="fas fa-home"></i>
                    Beranda
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="cart.html">Keranjang</a>
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
                    <!-- Saved Address (if exists) -->
                    <div class="saved-address-section" id="savedAddressSection" style="display: none;">
                        <h2>Alamat Tersimpan</h2>
                        <div class="saved-address-card">
                            <div class="address-info" id="savedAddressInfo">
                                <!-- Will be populated by JS -->
                            </div>
                            <div class="address-actions">
                                <button class="btn-use-address" id="btnUseSaved">
                                    <i class="fas fa-check"></i>
                                    Gunakan Alamat Ini
                                </button>
                                <button class="btn-edit-address" id="btnEditAddress">
                                    <i class="fas fa-edit"></i>
                                    Edit Alamat
                                </button>
                            </div>
                        </div>
                        <button class="btn-new-address" id="btnNewAddress">
                            <i class="fas fa-plus"></i>
                            Gunakan Alamat Baru
                        </button>
                    </div>

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

                        <div class="form-checkbox">
                            <input type="checkbox" id="saveAddress">
                            <label for="saveAddress">Simpan alamat ini untuk pemesanan selanjutnya</label>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-section">
                        <h2>
                            <i class="fas fa-credit-card"></i>
                            Metode Pembayaran
                        </h2>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment" value="transfer" checked>
                                <div class="payment-card">
                                    <div class="payment-icon">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="payment-info">
                                        <h4>Transfer Bank</h4>
                                        <p>BCA, Mandiri, BNI, BRI</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment" value="ewallet">
                                <div class="payment-card">
                                    <div class="payment-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="payment-info">
                                        <h4>E-Wallet</h4>
                                        <p>OVO, GoPay, DANA</p>
                                    </div>
                                    <i class="fas fa-check-circle check-icon"></i>
                                </div>
                            </label>
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
                                Saya setuju dengan <a href="terms.html" target="_blank">Syarat & Ketentuan</a>
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

                    <a href="cart.html" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </section>


    @endsection

    @push('scripts')
    <script src="{{ asset('js/checkout.js') }}"></script>
    @endpush