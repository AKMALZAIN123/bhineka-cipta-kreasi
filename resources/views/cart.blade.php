@extends('layouts.app')

@section('title', 'Produk')

@section('css')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')

    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-items">
                <a href="{{ route('home') }}"`>
                    <i class="fas fa-home"></i>
                    Beranda
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Keranjang Belanja</span>
            </div>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            <div class="cart-header">
                <h1>Keranjang Belanja</h1>
                <p class="cart-count" id="cartCount">0 produk</p>
            </div>

            <div class="cart-layout">
                <!-- Cart Items -->
                <div class="cart-items-section">
                    <!-- Cart items will be inserted here by JavaScript -->
                    <div id="cartItemsContainer"></div>

                    <!-- Empty State -->
                    <div class="empty-cart" id="emptyCart" style="display: none;">
                        <div class="empty-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h2>Keranjang Belanja Kosong</h2>
                        <p>Belum ada produk di keranjang Anda. Yuk mulai belanja sekarang!</p>
                        <a href="products.html" class="btn-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Mulai Belanja
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary" id="orderSummary">
                    <h3>Ringkasan Pesanan</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal <span class="item-count" id="summaryItemCount">(0 produk)</span></span>
                        <span class="summary-value" id="summarySubtotal">Rp 0</span>
                    </div>

                    <div class="summary-row">
                        <span>Biaya Pengiriman</span>
                        <span class="summary-value" id="summaryShipping">Rp 0</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span class="total-value" id="summaryTotal">Rp 0</span>
                    </div>

                    <button class="btn-checkout" id="btnCheckout">
                        <i class="fas fa-credit-card"></i>
                        Lanjutkan ke Pembayaran
                    </button>

                    <a href="products.html" class="btn-continue">
                        <i class="fas fa-arrow-left"></i>
                        Lanjut Belanja
                    </a>

                    <div class="summary-info">
                        <i class="fas fa-shield-alt"></i>
                        <span>Transaksi aman dan terpercaya</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
    @endpush
