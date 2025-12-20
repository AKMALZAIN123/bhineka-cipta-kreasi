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
            @if(($mode ?? 'cart') === 'cart')
                <a href="{{ route('cart') }}">Keranjang</a>
            @else
                <a href="{{ route('produk') }}">Produk</a>
            @endif
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

        <!-- Alert Messages -->
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="mode" value="{{ $mode ?? 'cart' }}">
            <div class="checkout-layout">
                <!-- Left Side - Form -->
                <div class="checkout-form">
                    <!-- Contact Information -->
                    <div class="form-section">
                        <h2>
                            <i class="fas fa-user"></i>
                            Informasi Kontak
                        </h2>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="name">Nama Lengkap *</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="John Doe" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Nomor Telepon *</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" inputmode="numeric"  pattern="[0-9]{8,15}" maxlength="15" placeholder="081234567890" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="john@example.com" required>
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
                                <textarea id="address" name="address" rows="3" placeholder="Jl. Raya Prompong RT 04/04" required>{{ old('address') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="district">Kecamatan *</label>
                                <input type="text" id="district" name="district" value="{{ old('district') }}" placeholder="Baturaden" required>
                            </div>
                            <div class="form-group">
                                <label for="city">Kabupaten/Kota *</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" placeholder="Banyumas" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Provinsi *</label>
                                <input type="text" id="province" name="province" value="{{ old('province') }}" placeholder="Jawa Tengah" required>
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Kode Pos *</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" placeholder="53151" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="address_notes">Catatan Alamat (Opsional)</label>
                                <input type="text" id="address_notes" name="address_notes" value="{{ old('address_notes') }}" placeholder="Patokan/landmark (contoh: dekat masjid)">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-section">
                        <h2>
                            <i class="fas fa-credit-card"></i>
                            Metode Pembayaran
                        </h2>
                        <div class="payment-info-box">
                            <i class="fas fa-info-circle"></i>
                            <p>Anda akan diarahkan ke halaman pembayaran untuk memilih metode pembayaran (Transfer Bank, E-Wallet, Kartu Kredit, dll)</p>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="form-section">
                        <h2>
                            <i class="fas fa-comment"></i>
                            Catatan Pesanan (Opsional)
                        </h2>
                        <div class="form-group">
                            <textarea id="order_notes" name="order_notes" rows="4" placeholder="Contoh: Tolong kirim pada pagi hari, atau hubungi sebelum mengirim">{{ old('order_notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="terms-section">
                        <div class="form-checkbox">
                            <input type="checkbox" id="agreeTerms" required>
                            <label for="agreeTerms">
                                Saya setuju dengan <a href="#" target="_blank">Syarat & Ketentuan</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button (Mobile) -->
                    <button type="submit" class="btn-submit mobile-submit" id="btnSubmitMobile">
                        <i class="fas fa-lock"></i>
                        Proses Pembayaran
                    </button>
                </div>

                <!-- Right Side - Order Summary -->
                <div class="order-summary">
                    <h2>Ringkasan Pesanan</h2>

                    <!-- Products List -->
                    <div class="summary-products">
                        @if(($mode ?? 'cart') === 'buy_now')
                            <div class="summary-product-item">
                                <div class="item-image">
                                <img src="{{ $product->image_url ? asset('storage/'.$product->image_url) : asset('img/default.png') }}" alt="{{ $product->name }}">
                                </div>
                                <div class="product-info">
                                    <h4>{{ $product->name }}</h4>
                                    <p>{{ $quantity }} x Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="product-price">
                                    Rp {{ number_format($product->price * $quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        @else
                            @foreach($cart->cartItems as $item)
                                <div class="summary-product-item">
                                    <div class="item-image">
                                        <img src="{{ $item->product->image_url ? asset('storage/' . $item->product->image_url) : asset('img/default.png') }}" alt="{{ $item->product->name }}">
                                    </div>
                                    <div class="product-info">
                                        <h4>{{ $item->product->name }}</h4>
                                        <p>{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="product-price">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="summary-divider"></div>

                    <!-- Price Details -->
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>
                                Subtotal
                                <span class="item-count">
                                    @if(($mode ?? 'cart') === 'buy_now')
                                        (1 produk)
                                    @else
                                        ({{ $cart->cartItems->count() }} produk)
                                    @endif
                                </span>
                            </span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Pengiriman</span>
                            <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="summary-divider"></div>

                    <!-- Total -->
                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Delivery Info -->
                    <div class="delivery-info">
                        <i class="fas fa-truck"></i>
                        <div>
                            <strong>Estimasi Pengiriman</strong>
                            <p>2-3 hari kerja</p>
                        </div>
                    </div>

                    <!-- Security Badge -->
                    <div class="security-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Transaksi Aman & Terpercaya</span>
                    </div>

                    <!-- Submit Button (Desktop) -->
                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <i class="fas fa-lock"></i>
                        Proses Pembayaran
                    </button>

                    <a href="{{ ($mode ?? 'cart') === 'buy_now' ? route('produk') : route('cart') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Loading Modal -->
<div id="loadingModal" class="loading-modal" style="display: none;">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <p>Memproses pesanan Anda...</p>
    </div>
</div>

@endsection

@push('scripts')
<!-- Midtrans Snap Script -->
<script type="text/javascript"
    src="https://app{{ config('midtrans.is_production') ? '' : '.sandbox' }}.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkoutForm');
    const loadingModal = document.getElementById('loadingModal');
    const agreeTerms = document.getElementById('agreeTerms');

    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validasi terms
        if (!agreeTerms.checked) {
            alert('Anda harus menyetujui Syarat & Ketentuan untuk melanjutkan');
            return false;
        }

        // Show loading
        loadingModal.style.display = 'flex';

        // Ambil form data
        const formData = new FormData(checkoutForm);

        // Submit form via AJAX
        fetch(checkoutForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading
            loadingModal.style.display = 'none';

            if (data.success) {
                // Jika ada snap token, lakukan pembayaran
                if (data.snap_token) {
                    // Trigger Midtrans Snap
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Success:', result);
                            // Redirect ke halaman success
                            window.location.href = "{{ route('order.success') }}?order_id=" + data.order_id;
                        },
                        onPending: function(result) {
                            console.log('Pending:', result);
                            // Redirect ke halaman pending
                            window.location.href = "{{ route('order.pending') }}?order_id=" + data.order_id;
                        },
                        onError: function(result) {
                            console.log('Error:', result);
                            // Redirect ke halaman error
                            window.location.href = "{{ route('order.error') }}?order_id=" + data.order_id;
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                            // Redirect ke halaman pending jika user menutup popup
                            window.location.href = "{{ route('order.pending') }}?order_id=" + data.order_id;
                        }
                    });
                } else {
                    alert('Gagal generate payment token');
                }
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses pesanan');
            }
        })
        .catch(error => {
            loadingModal.style.display = 'none';
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });
});
</script>

<style>
.loading-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-content {
    background: white;
    padding: 40px;
    border-radius: 10px;
    text-align: center;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-content p {
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 500;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.payment-info-box {
    background: #e8f4fd;
    border: 2px solid #2196f3;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.payment-info-box i {
    font-size: 30px;
    color: #2196f3;
    flex-shrink: 0;
}

.payment-info-box p {
    margin: 0;
    color: #333;
    font-size: 15px;
    line-height: 1.6;
}
</style>
@endpush