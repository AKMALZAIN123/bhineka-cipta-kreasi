@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.history.css') }}">
@endsection

@section('content')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Back Button -->
            <a href="{{ route('history') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Riwayat Pesanan
            </a>

            <!-- Order Header -->
            <div class="order-header-card">
                <div class="order-header-info">
                    <h1 id="orderNumber">ORD-2024-001234</h1>
                    <p id="orderDate">10 Desember 2024, 14:30 WIB</p>
                </div>
                <div class="order-total-badge">
                    <span>Total Pembayaran</span>
                    <h2 id="orderTotal">Rp 600.000</h2>
                </div>
            </div>

            <div class="content-grid">
                <!-- Left Column: Progress & Items -->
                <div class="left-column">
                    <!-- Progress Tracker -->
                    <div class="progress-card">
                        <h3>Status Pesanan</h3>
                        
                        <div class="progress-tracker">
                            <div class="progress-step completed" id="step-packaging">
                                <div class="step-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="step-content">
                                    <h4>Packaging</h4>
                                    <p id="packaging-date">10 Des 2024, 15:00</p>
                                </div>
                            </div>

                            <div class="progress-step active" id="step-onroad">
                                <div class="step-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="step-content">
                                    <h4>On The Road</h4>
                                    <p id="onroad-date">Sedang dalam pengiriman</p>
                                </div>
                            </div>

                            <div class="progress-step" id="step-delivered">
                                <div class="step-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="step-content">
                                    <h4>Delivered</h4>
                                    <p id="delivered-date">Estimasi 2-3 hari</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="items-card">
                        <h3>Detail Pesanan</h3>
                        <div id="orderItemsList" class="items-list">
                            <!-- Items will be rendered here -->
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
                                    <p class="info-value" id="recipientName">John Doe</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <p class="info-label">Telepon</p>
                                    <p class="info-value" id="recipientPhone">081234567890</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <p class="info-label">Alamat</p>
                                    <p class="info-value" id="recipientAddress">Jl. Sudirman No. 123, Jakarta Selatan, DKI Jakarta 12190</p>
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
                                <span id="subtotal">Rp 600.000</span>
                            </div>
                            <div class="summary-row">
                                <span>Biaya Pengiriman</span>
                                <span id="shippingCost">Gratis</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-row total">
                                <span>Total</span>
                                <span id="totalAmount">Rp 600.000</span>
                            </div>
                            <div class="payment-method">
                                <i class="fas fa-check-circle"></i>
                                <span>Dibayar via Midtrans</span>
                            </div>
                        </div>
                    </div>

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
<script src="{{ asset('js/detail.history.js') }}"></script>
@endpush