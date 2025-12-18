@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('css')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
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
            <span>Keranjang Belanja</span>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="cart-section">
    <div class="container">
        <div class="cart-header">
            <h1>Keranjang Belanja</h1>
            <p class="cart-count" id="cartCount">
                {{ $cart->cartItems->count() }} produk
            </p>
        </div>

        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="cart-items-section">
                <div id="cartItemsContainer">
                    @if($cart->cartItems->isEmpty())
                        <!-- Empty State -->
                        <div class="empty-cart" id="emptyCart">
                            <div class="empty-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h2>Keranjang Belanja Kosong</h2>
                            <p>Belum ada produk di keranjang Anda. Yuk mulai belanja sekarang!</p>
                            <a href="{{ route('produk.index') }}" class="btn-primary">
                                <i class="fas fa-shopping-bag"></i>
                                Mulai Belanja
                            </a>
                        </div>
                    @else
                        @foreach($cart->cartItems as $item)
                        <div class="cart-item">
                            <div class="item-image">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                            </div>
                            <div class="item-details">
                                <div class="item-header">
                                    <div class="item-info">
                                        <h3>{{ $item->product->name }}</h3>
                                        @if($item->product->category)
                                            <div class="item-variant">{{ $item->product->category }}</div>
                                        @endif
                                    </div>
                                    <!-- Tombol Hapus Item -->
                                    <form action="{{ route('cart.delete', $item->item_id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="item-delete" type="submit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                <div class="item-footer">
                                    <!-- Quantity Selector -->
                                    <form action="{{ route('cart.update', $item->item_id) }}" method="POST" style="display: flex; align-items: center; gap: .5rem;">
                                        @csrf
                                        @method('PUT')
                                        <button class="qty-btn" type="submit" name="action" value="decrease" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="qty-input" name="quantity" value="{{ $item->quantity }}" min="1" max="99" style="width: 50px;">
                                        <button class="qty-btn" type="submit" name="action" value="increase">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                    <div class="item-subtotal">
                                        <span class="item-subtotal-label">Subtotal</span>
                                        <span class="item-subtotal-value">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- Order Summary -->
            <div class="order-summary" id="orderSummary">
                <h3>Ringkasan Pesanan</h3>
                <div class="summary-row">
                    <span>Subtotal <span class="item-count" id="summaryItemCount">({{ $cart->cartItems->sum('quantity') }} produk)</span></span>
                    <span class="summary-value" id="summarySubtotal">
                        Rp {{ number_format($cart->cartItems->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>
                @php
                    $shipping = 15000;
                    $total = $cart->cartItems->sum('subtotal') + $shipping;
                @endphp
                <div class="summary-row">
                    <span>Biaya Pengiriman</span>
                    <span class="summary-value" id="summaryShipping">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-total">
                    <span>Total</span>
                    <span class="total-value" id="summaryTotal">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
                <a href="{{ route('checkout') }}" class="btn-checkout">
                    <i class="fas fa-credit-card"></i>
                    Lanjutkan ke Pembayaran
                </a>
                <a href="" class="btn-continue">
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