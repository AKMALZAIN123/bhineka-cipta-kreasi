@extends('layouts.app')

@section('title', 'Menunggu Pembayaran')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order-status.css') }}">
@endsection

@section('content')
<section class="order-status-section">
    <div class="container">
        <div class="status-card pending">
            <!-- Pending Icon -->
            <div class="status-icon-wrapper">
                <div class="status-icon pending-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <!-- Status Message -->
            <h1>Menunggu Pembayaran</h1>
            <p class="status-subtitle">Silakan selesaikan pembayaran Anda sebelum batas waktu berakhir</p>

            <!-- Countdown Timer -->
            <div class="countdown-timer">
                <div class="timer-label">Batas Waktu Pembayaran</div>
                <div class="timer-display" id="countdown">
                    <div class="timer-box">
                        <span id="hours">23</span>
                        <span class="timer-label-small">Jam</span>
                    </div>
                    <span class="timer-separator">:</span>
                    <div class="timer-box">
                        <span id="minutes">59</span>
                        <span class="timer-label-small">Menit</span>
                    </div>
                    <span class="timer-separator">:</span>
                    <div class="timer-box">
                        <span id="seconds">59</span>
                        <span class="timer-label-small">Detik</span>
                    </div>
                </div>
            </div>

            <!-- Order Info Card -->
            <div class="order-info-card">
                <div class="order-header">
                    <h3>Detail Pesanan</h3>
                </div>
                
                <div class="order-detail-row">
                    <span class="label">Nomor Pesanan</span>
                    <span class="value order-number">{{ $order->order_number ?? 'BCK-' . time() }}</span>
                </div>

                <div class="order-detail-row">
                    <span class="label">Total Pembayaran</span>
                    <span class="value price">{{ formatRupiah($order->total_amount ?? 0) }}</span>
                </div>

                <div class="order-detail-row">
                    <span class="label">Metode Pembayaran</span>
                    <span class="value">{{ strtoupper($order->payment_method ?? 'Transfer Bank') }}</span>
                </div>

                <div class="order-detail-row">
                    <span class="label">Status Pembayaran</span>
                    <span class="badge-pending">
                        <i class="fas fa-clock"></i>
                        Menunggu Pembayaran
                    </span>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if(isset($order->payment_method))
                <div class="payment-instruction">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Instruksi Pembayaran
                    </h3>
                    
                    @if(in_array($order->payment_method, ['bca', 'bni', 'bri', 'mandiri']))
                        <!-- Bank Transfer -->
                        <div class="instruction-card">
                            <div class="instruction-header">
                                <i class="fas fa-university"></i>
                                <span>Transfer ke Virtual Account</span>
                            </div>
                            <div class="instruction-body">
                                <div class="va-info">
                                    <span class="va-label">Bank</span>
                                    <span class="va-value">{{ strtoupper($order->payment_method) }}</span>
                                </div>
                                <div class="va-info">
                                    <span class="va-label">Nomor Virtual Account</span>
                                    <div class="va-number">
                                        <span class="va-value" id="vaNumber">{{ $order->va_number ?? '8012345678901234' }}</span>
                                        <button class="copy-btn" onclick="copyVA()">
                                            <i class="fas fa-copy"></i>
                                            Salin
                                        </button>
                                    </div>
                                </div>
                                <div class="va-info">
                                    <span class="va-label">Total Transfer</span>
                                    <span class="va-value price">{{ formatRupiah($order->total ?? 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="steps-payment">
                            <h4>Cara Pembayaran:</h4>
                            <ol>
                                <li>Buka aplikasi mobile banking atau ATM</li>
                                <li>Pilih menu Transfer / Virtual Account</li>
                                <li>Masukkan nomor Virtual Account di atas</li>
                                <li>Masukkan nominal sesuai total pembayaran</li>
                                <li>Konfirmasi dan selesaikan pembayaran</li>
                            </ol>
                        </div>

                    @elseif(in_array($order->payment_method, ['gopay', 'dana', 'ovo']))
                        <!-- E-Wallet -->
                        <div class="instruction-card">
                            <div class="instruction-header">
                                <i class="fas fa-wallet"></i>
                                <span>Bayar dengan {{ strtoupper($order->payment_method) }}</span>
                            </div>
                            <div class="instruction-body">
                                <p>Scan QR Code di bawah ini menggunakan aplikasi {{ strtoupper($order->payment_method) }}</p>
                                
                                @if(isset($order->qr_code_url))
                                    <div class="qr-code">
                                        <img src="{{ $order->qr_code_url }}" alt="QR Code">
                                    </div>
                                @else
                                    <div class="qr-placeholder">
                                        <i class="fas fa-qrcode"></i>
                                        <p>QR Code akan muncul setelah pesanan diproses</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    @elseif($order->payment_method == 'qris')
                        <!-- QRIS -->
                        <div class="instruction-card">
                            <div class="instruction-header">
                                <i class="fas fa-qrcode"></i>
                                <span>Bayar dengan QRIS</span>
                            </div>
                            <div class="instruction-body">
                                <p>Scan QR Code menggunakan aplikasi mobile banking atau e-wallet Anda</p>
                                
                                @if(isset($order->qr_code_url))
                                    <div class="qr-code">
                                        <img src="{{ $order->qr_code_url }}" alt="QRIS">
                                    </div>
                                @else
                                    <div class="qr-placeholder">
                                        <i class="fas fa-qrcode"></i>
                                        <p>QR Code akan muncul setelah pesanan diproses</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('home') }}" class="btn-primary">
                    <i class="fas fa-sync"></i>
                    Cek Status Pembayaran
                </a>
                <a href="{{ route('home') }}" class="btn-secondary">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Warning -->
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Pastikan Anda membayar sesuai dengan nominal yang tertera. Pembayaran dengan nominal berbeda tidak akan diproses.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Countdown Timer
let expiryTime = new Date().getTime() + (24 * 60 * 60 * 1000); // 24 hours from now

function updateCountdown() {
    const now = new Date().getTime();
    const distance = expiryTime - now;

    if (distance < 0) {
        document.getElementById('countdown').innerHTML = '<span style="color: #ef4444;">Waktu Habis</span>';
        return;
    }

    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
    document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
    document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
}

// Update countdown every second
setInterval(updateCountdown, 1000);
updateCountdown();

// Copy VA Number
function copyVA() {
    const vaNumber = document.getElementById('vaNumber').textContent;
    navigator.clipboard.writeText(vaNumber).then(() => {
        const btn = document.querySelector('.copy-btn');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin';
        btn.style.background = '#10b981';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.background = '';
        }, 2000);
    });
}
</script>
@endpush