@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.history.css') }}">
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
            <div class="order-header-box">
                <div class="order-info">
                    <h1>ORD-2024-001234</h1>
                    <p>Dipesan pada 15 Desember 2024, 14:30</p>
                </div>
                <div class="order-price">
                    <span class="price-label">Total Pembayaran</span>
                    <span class="price-amount">Rp 600.000</span>
                </div>
            </div>

            <!-- Progress Tracker -->
            <div class="progress-section">
                <h2>Status Pesanan</h2>
                <div class="progress-tracker">
                    
                    <!-- Step 1: Packaging (Active) -->
                    <div class="progress-step active">
                        <div class="step-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="step-content">
                            <h3>Pengerjaan</h3>
                            <p>Pesanan sedang dikerjakan</p>
                            <span class="step-time">15 Des 2024, 15:00</span>
                        </div>
                    </div>

                    <!-- Connector Line -->
                    <div class="progress-line"></div>

                    <!-- Step 2: On The Road (Upcoming) -->
                    <div class="progress-step upcoming">
                        <div class="step-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="step-content">
                            <h3>Dalam Pengiriman</h3>
                            <p>Dikirim dengan truk perusahaan</p>
                            <span class="step-time">Estimasi: 17 Des 2024</span>
                        </div>
                    </div>

                    <!-- Connector Line -->
                    <div class="progress-line"></div>

                    <!-- Step 3: Delivered (Upcoming) -->
                    <div class="progress-step upcoming">
                        <div class="step-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="step-content">
                            <h3>Selesai</h3>
                            <p>Pesanan telah sampai</p>
                            <span class="step-time">-</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Order Items -->
            <div class="items-section">
                <h2>Produk Dipesan</h2>
                
                <div class="item-list">
                    <div class="item-card">
                        <img src="https://images.unsplash.com/photo-1611329857570-f02f340e7378?w=150&h=150&fit=crop" alt="Banner X Premium" class="item-img">
                        <div class="item-info">
                            <h3>Banner X Premium</h3>
                            <p>Ukuran 160x60cm, Material Premium</p>
                            <div class="item-meta">
                                <span>Jumlah: 2</span>
                                <span class="item-price">Rp 250.000</span>
                            </div>
                        </div>
                    </div>

                    <div class="item-card">
                        <img src="https://images.unsplash.com/photo-1530435460869-d13625c69bbf?w=150&h=150&fit=crop" alt="Kartu Undangan" class="item-img">
                        <div class="item-info">
                            <h3>Kartu Undangan Custom</h3>
                            <p>100 pcs, Hardcover dengan emboss</p>
                            <div class="item-meta">
                                <span>Jumlah: 1</span>
                                <span class="item-price">Rp 350.000</span>
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

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="info-content">
                        <h3>Metode Pembayaran</h3>
                        <p>Transfer Bank BCA<br>Status: <span class="badge-paid">Lunas</span></p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-content">
                        <h3>Kontak</h3>
                        <p>+62 812 3456 7890<br>customer@email.com</p>
                    </div>
                </div>
            </div>

            <!-- Total Summary -->
            <div class="summary-box">
                <div class="summary-row">
                    <span>Subtotal Produk</span>
                    <span>Rp 600.000</span>
                </div>
                <div class="summary-row">
                    <span>Biaya Pengiriman</span>
                    <span>Gratis</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp 600.000</span>
                </div>
            </div>

        </div>
    </main>

@endsection

@push('scripts')
<script src="{{ asset('js/detail.history.js') }}"></script>
@endpush