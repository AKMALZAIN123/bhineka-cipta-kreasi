@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail-history.css') }}">
@endsection

@section('content')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            
            <!-- Back Button -->
            <a href="history.html" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Pesanan
            </a>

            <!-- Order Header -->
            <div class="order-header-card">
                <div class="order-header-info">
                    <h1 id="orderNumber">Order #{{ $order->order_id }}</h1>
                    <p id="orderDate">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div class="order-total-badge">
                    <span>Total Pembayaran</span>
                    <h2 id="orderTotal">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h2>
                </div>
            </div>

            <div class="content-grid">
                <!-- Left Column: Progress & Items -->
                <div class="left-column">
                    <!-- Progress Tracker -->
                    <div class="progress-card">
                        <h3>Status Pesanan</h3>
                        
                        <div class="progress-tracker">
                            <div class="progress-step {{ in_array($order->status, ['packing', 'onroad', 'delivered']) ? 'completed' : '' }}" id="step-packaging">
                                <div class="step-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="step-content">
                                    <h4>Packaging</h4>
                                    <p id="packaging-date">
                                        @if(in_array($order->status, ['packing', 'onroad', 'delivered']))
                                            {{ $order->updated_at->format('d M Y, H:i') }}
                                        @else
                                            Menunggu diproses
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="progress-step {{ in_array($order->status, ['onroad', 'delivered']) ? 'completed' : '' }} {{ $order->status === 'onroad' ? 'active' : '' }}" id="step-onroad">
                                <div class="step-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="step-content">
                                    <h4>On The Road</h4>
                                    <p id="onroad-date">
                                        @if($order->status === 'onroad')
                                            Sedang dalam pengiriman
                                        @elseif($order->status === 'delivered')
                                            Telah dikirim
                                        @else
                                            Belum dikirim
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="progress-step {{ $order->status === 'delivered' ? 'completed active' : '' }}" id="step-delivered">
                                <div class="step-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="step-content">
                                    <h4>Delivered</h4>
                                    <p id="delivered-date">
                                        @if($order->status === 'delivered')
                                            Pesanan selesai
                                        @else
                                            Estimasi 2-3 hari
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="items-card">
                        <h3>Detail Pesanan</h3>
                        <div id="orderItemsList" class="items-list">
                            @foreach($order->orderItems as $item)
                                <div class="item-row">
                                    <img src="{{ asset('storage/' . $item->product->image_url) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="item-image">
                                    <div class="item-details">
                                        <div class="item-name">{{ $item->product->name }}</div>
                                        <div class="item-specs">{{ $item->product->description ?? 'Produk berkualitas' }}</div>
                                    </div>
                                    <div class="item-price-info">
                                        <div class="item-qty">{{ $item->quantity }}x</div>
                                        <div class="item-price">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

                <!-- Right Column: Summary -->
                <div class="right-column">
                    <!-- Shipping Info -->
                    <div class="info-card">
                        <h3>Informasi Pengiriman</h3>
                        <div class="info-content">
                            <div class="info-item">
                                <i class="fas fa-user"></i>
                                <div>
                                    <p class="info-label">Penerima</p>
                                    <p class="info-value" id="recipientName">{{ $order->nama_lengkap }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <p class="info-label">Telepon</p>
                                    <p class="info-value" id="recipientPhone">{{ $order->nomor_telepon }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <p class="info-label">Alamat</p>
                                    <p class="info-value" id="recipientAddress">
                                        {{ $order->alamat_lengkap }}, 
                                        {{ $order->kecamatan }}, 
                                        {{ $order->kabupaten_kota }}, 
                                        {{ $order->provinsi }} 
                                        {{ $order->kode_pos }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="info-card">
                        <h3>Ringkasan Pembayaran</h3>
                        <div class="payment-summary">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span id="subtotal">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Biaya Pengiriman</span>
                                <span id="shippingCost">Rp 10.000</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-row total">
                                <span>Total</span>
                                <span id="totalAmount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="payment-method">
                                @if($order->payment && $order->payment->status === 'success')
                                    <i class="fas fa-check-circle"></i>
                                    <span>Dibayar via {{ ucfirst($order->payment->method) }}</span>
                                @elseif($order->payment && $order->payment->status === 'pending')
                                    <i class="fas fa-clock"></i>
                                    <span>Menunggu Pembayaran</span>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                    <span>Belum Dibayar</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Alamat Pengiriman</h3>
                        <p>Jl. Sudirman No. 123, Purwokerto<br>Banyumas, Jawa Tengah 53111</p>
                    </div>
                </div>

                    @if($order->payment && $order->payment->status === 'pending')
                        <button class="btn-primary btn-pay" data-snap-token="{{ $order->payment->snap_token }}" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-credit-card"></i>
                            Bayar Sekarang
                        </button>
                    @endif

                    <!-- Help Button -->
                    <button class="help-button">
                        <i class="fas fa-headset"></i>
                        Butuh Bantuan?
                    </button>
                </div>
            </div>

        </div>
    </main>

@endsection

@push('scripts')
<!-- Midtrans Snap Script -->
<script type="text/javascript"
    src="https://app{{ config('midtrans.is_production') ? '' : '.sandbox' }}.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingModal = document.getElementById('loadingModal');
    
    // Handle payment button click
    document.querySelector('.btn-pay')?.addEventListener('click', function() {
        const snapToken = this.getAttribute('data-snap-token');
        const orderId = this.getAttribute('data-order-id');
        
        // Show loading
        loadingModal.style.display = 'flex';
        
        // Trigger Midtrans Snap
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Success:', result);
                loadingModal.style.display = 'none';
                window.location.href = "{{ route('order.success') }}?order_id=" + orderId;
            },
            onPending: function(result) {
                console.log('Pending:', result);
                loadingModal.style.display = 'none';
                window.location.href = "{{ route('order.pending') }}?order_id=" + orderId;
            },
            onError: function(result) {
                console.log('Error:', result);
                loadingModal.style.display = 'none';
                window.location.href = "{{ route('order.error') }}?order_id=" + orderId;
            },
            onClose: function() {
                console.log('Payment popup closed');
                loadingModal.style.display = 'none';
                // Redirect ke halaman pending jika user menutup popup
                window.location.href = "{{ route('order.pending') }}?order_id=" + orderId;
            }
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
</style>

<script src="{{ asset('js/detail-history.js') }}"></script>
@endpush