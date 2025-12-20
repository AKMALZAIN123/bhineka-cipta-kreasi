@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('css')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
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

<section class="cart-section">
    <div class="container">
        <div class="cart-header">
            <h1>Keranjang Belanja</h1>
            <p class="cart-count" id="cartCount">{{ $cart->cartItems->count() }} produk</p>
        </div>

        <div class="cart-layout">
            <div class="cart-items-section">
                <div id="cartItemsContainer">

                    @if($cart->cartItems->isEmpty())
                        <div class="empty-cart" id="emptyCart">
                            <div class="empty-icon"><i class="fas fa-shopping-cart"></i></div>
                            <h2>Keranjang Belanja Kosong</h2>
                            <p>Belum ada produk di keranjang Anda. Yuk mulai belanja sekarang!</p>
                            <a href="{{ route('produk') }}" class="btn-primary">
                                <i class="fas fa-shopping-bag"></i>
                                Mulai Belanja
                            </a>
                        </div>
                    @else

                        @foreach($cart->cartItems as $item)
                        <div class="cart-item">
                            <div class="item-image">
                                <img src="{{ $item->product->image_url ? asset('storage/'.$item->product->image_url) : asset('img/default.png') }}"
                                     alt="{{ $item->product->name }}">
                            </div>

                            <div class="item-details">
                                <div class="item-header">
                                    <div class="item-info">
                                        <h3>{{ $item->product->name }}</h3>
                                        @if($item->product->category)
                                            <div class="item-variant">{{ $item->product->category }}</div>
                                        @endif
                                    </div>

                                    <form action="{{ route('cart.delete', $item->item_id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="item-delete" type="submit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="item-price">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </div>

                                <div class="item-footer">
                                    {{-- ✅ FORM QTY (SIMPLE) --}}
                                    <form action="{{ route('cart.update', $item->item_id) }}"
                                          method="POST"
                                          class="qty-form"
                                          style="display:flex;align-items:center;gap:.5rem;">
                                        @csrf
                                        @method('PATCH')

                                        <button class="qty-btn" type="submit" name="action" value="decrease" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <input type="number"
                                               class="qty-input"
                                               name="quantity"
                                               value="{{ $item->quantity }}"
                                               min="1"
                                               max="99"
                                               inputmode="numeric"
                                               style="width: 70px;">

                                        <button class="qty-btn" type="submit" name="action" value="increase">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>

                                    <div class="item-subtotal">
                                        <span class="item-subtotal-label">Subtotal</span>
                                        <span class="item-subtotal-value">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    @endif
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="order-summary" id="orderSummary">
                <h3>Ringkasan Pesanan</h3>

                @php
                    $subtotal = $cart->cartItems->sum(fn($i) => $i->product->price * $i->quantity);
                    $shipping = 15000;
                    $total = $subtotal + $shipping;
                    $qtyTotal = $cart->cartItems->sum('quantity');
                @endphp

                <div class="summary-row">
                    <span>Subtotal <span class="item-count" id="summaryItemCount">({{ $qtyTotal }} produk)</span></span>
                    <span class="summary-value" id="summarySubtotal">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>

                <div class="summary-row">
                    <span>Biaya Pengiriman</span>
                    <span class="summary-value" id="summaryShipping">
                        Rp {{ number_format($shipping, 0, ',', '.') }}
                    </span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-total">
                    <span>Total</span>
                    <span class="total-value" id="summaryTotal">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('checkout', ['mode' => 'cart']) }}" class="btn-checkout">
                    <i class="fas fa-credit-card"></i>
                    Lanjutkan ke Pembayaran
                </a>

                <a href="{{ route('produk') }}" class="btn-continue">
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
<script>
document.addEventListener('DOMContentLoaded', () => {
  // ✅ bikin input number bisa “live” submit ketika user selesai edit
  document.querySelectorAll('.qty-form').forEach((form) => {
    const input = form.querySelector('.qty-input');
    if (!input) return;

    // Enter = submit
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        form.submit();
      }
    });

    // Kalau user klik spinner ↑↓ atau berubah nilai: submit
    input.addEventListener('change', () => {
      // validasi ringan biar gak kosong / 0
      if (input.value === '' || Number(input.value) < 1) input.value = 1;
      if (Number(input.value) > 99) input.value = 99;
      form.submit();
    });

    // Kalau user selesai ketik lalu klik di luar: submit
    input.addEventListener('blur', () => {
      if (input.value === '' || Number(input.value) < 1) input.value = 1;
      if (Number(input.value) > 99) input.value = 99;
      form.submit();
    });
  });
});
</script>
@endpush
