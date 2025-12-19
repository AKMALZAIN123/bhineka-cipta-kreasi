@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order-status.css') }}">
@endsection

@section('content')
<section class="order-status-section">
    <div class="container">
        <div class="status-card success">
            <!-- Success Icon -->
            <div class="status-icon-wrapper">
                <div class="status-icon success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <!-- Status Message -->
            <h1>Pembayaran Berhasil!</h1>
            <p class="status-subtitle">Terima kasih atas pembelian Anda di Bhineka Cipta Kreasi</p>

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
                    <span class="label">Tanggal</span>
                    <span class="value">{{ $order->created_at->format('d M Y, H:i') ?? date('d M Y, H:i') }}</span>
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
                    <span class="badge-success">
                        <i class="fas fa-check-circle"></i>
                        Lunas
                    </span>
                </div>
            </div>

            <!-- What's Next Section -->
            <div class="whats-next">
                <h3>
                    <i class="fas fa-info-circle"></i>
                    Apa Selanjutnya?
                </h3>
                <div class="steps">
                    <div class="step">
                        <div class="step-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <p>Kami akan mengirim konfirmasi pesanan ke email Anda</p>
                    </div>
                    <div class="step">
                        <div class="step-icon">
                            <i class="fas fa-print"></i>
                        </div>
                        <p>Pesanan Anda akan segera diproses oleh tim produksi kami</p>
                    </div>
                    <div class="step">
                        <div class="step-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <p>Produk akan dikirim sesuai alamat yang Anda berikan</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('home') }}" class="btn-primary">
                    <i class="fas fa-map-marker-alt"></i>
                    Lacak Pesanan
                </a>
                <a href="{{ route('home') }}" class="btn-secondary">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Customer Service -->
            <div class="customer-service-info">
                <p>Butuh bantuan? Hubungi customer service kami</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="whatsapp-link">
                    <i class="fab fa-whatsapp"></i>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Confetti animation on page load (optional)
document.addEventListener('DOMContentLoaded', function() {
    // Add success animation
    const icon = document.querySelector('.success-icon');
    if (icon) {
        setTimeout(() => {
            icon.style.animation = 'scaleIn 0.5s ease-out';
        }, 200);
    }
});
</script>
@endpush