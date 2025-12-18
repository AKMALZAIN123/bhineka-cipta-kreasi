@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-items">
            <a href="{{ url('/') }}">
                <i class="fas fa-home"></i>
                Beranda
            </a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('produk') }}">Produk</a>
            <i class="fas fa-chevron-right"></i>
            <span id="productName">{{ $product->name }}</span>
        </div>
    </div>
</section>

<!-- Product Detail -->
<section class="product-detail-section">
    <div class="container">
        <div class="product-detail-grid">

            <!-- Left Side - Image Gallery -->
            <div class="product-gallery">
                <div class="main-image">
                    <button class="wishlist-btn" id="wishlistBtn">
                        <i class="far fa-heart"></i>
                    </button>

                    @if($product->badge)
                        <div class="product-badge">{{ $product->badge }}</div>
                    @endif

                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="mainImage">

                    <button class="zoom-btn" id="zoomBtn">
                        <i class="fas fa-search-plus"></i>
                    </button>
                </div>

                <div class="thumbnail-gallery">
                    <!-- Thumbnail utama sebagai contoh -->
                    <div class="thumbnail active">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                    <!-- Jika punya multiple image galeri, tinggal loop di sini -->
                </div>
            </div>

            <!-- Right Side - Product Info -->
            <div class="product-info-section">
                <div class="product-category">{{ $product->category }}</div>
                <h1 class="product-title">{{ $product->name }}</h1>

                <div class="product-rating-section">
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="rating-number">4.5</span>
                    </div>
                    <div class="rating-divider">|</div>
                    <div class="rating-reviews">
                        <i class="far fa-comment"></i>
                        <span>127 Ulasan</span>
                    </div>
                    <div class="rating-divider">|</div>
                    <div class="rating-sold">
                        <i class="fas fa-box"></i>
                        <span>{{ $product->sold ?? 0 }} Terjual</span>
                    </div>
                </div>

                <div class="product-price-section">
                    <div class="price-main" id="priceDisplay">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    @if($product->old_price)
                    <div class="price-info">
                        <span class="discount-badge">-{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%</span>
                        <span class="price-old">Rp {{ number_format($product->old_price, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>

                <div class="product-description">
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Quantity - di luar form, terintegrasi via attribute 'form' -->
                <div class="variant-group">
                    <label class="variant-label">
                        <i class="fas fa-boxes"></i>
                        Jumlah
                    </label>
                    <div class="quantity-selector">
                        <button class="qty-btn" id="qtyMinus"><i class="fas fa-minus"></i></button>
                        <input type="number"
                            class="qty-input"
                            id="qtyInput"
                            name="quantity"
                            value="1"
                            min="1"
                            max="{{ $product->stock ?? 100 }}"
                            form="cartForm">
                        <button class="qty-btn" id="qtyPlus"><i class="fas fa-plus"></i></button>
                        <span class="stock-info">Stok: <strong>{{ $product->stock ?? 0 }}</strong></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="product-actions">
                    <form action="{{ route('cart.add') }}"
                        method="POST"
                        class="cart-form"
                        id="cartForm"> <!-- beri ID agar attribute form di atas bisa referensi ke sini -->
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <button type="submit"
                                class="btn-add-cart"
                                id="btnAddCart"
                                data-auth="{{ auth()->check() ? 'true' : 'false' }}">
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </form>
                    <button class="btn-buy-now" id="btnBuyNow">
                        <i class="fas fa-bolt"></i> Beli Sekarang
                    </button>
                </div>

                <!-- Product Features -->
                <div class="product-features">
                    <div class="feature-item">
                        <i class="fas fa-truck"></i>
                        <div>
                            <strong>Gratis Ongkir</strong>
                            <span>Minimal belanja Rp 500.000</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <strong>Garansi Kualitas</strong>
                            <span>100% uang kembali jika cacat</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Proses Cepat</strong>
                            <span>2-3 hari kerja</span>
                        </div>
                    </div>
                </div>

                <!-- Share -->
                <div class="product-share">
                    <span>Bagikan:</span>
                    <div class="share-buttons">
                        <button class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></button>
                        <button class="share-btn facebook"><i class="fab fa-facebook-f"></i></button>
                        <button class="share-btn twitter"><i class="fab fa-twitter"></i></button>
                        <button class="share-btn link"><i class="fas fa-link"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-tabs-section">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="description">
                    <i class="fas fa-align-left"></i> Deskripsi
                </button>
                <button class="tab-btn" data-tab="specifications">
                    <i class="fas fa-list-ul"></i> Spesifikasi
                </button>
                <button class="tab-btn" data-tab="reviews">
                    <i class="fas fa-star"></i> Ulasan (127)
                </button>
                <button class="tab-btn" data-tab="custom">
                    <i class="fas fa-edit"></i> Custom Order
                </button>
            </div>

            <div class="tabs-content">
                <!-- Description Tab -->
                <div class="tab-content active" id="description">
                    <h3>Deskripsi Produk</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Specifications Tab -->
                <div class="tab-content" id="specifications">
                    <h3>Spesifikasi</h3>
                    <p>Tambahkan tabel spesifikasi berdasarkan database jika nanti dibuat.</p>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-content" id="reviews">
                    <h3>Ulasan Pelanggan</h3>
                    <p>Review pelanggan akan ditampilkan di sini.</p>
                </div>

                <!-- Custom Order Tab -->
                <div class="tab-content" id="custom">
                    <h3>Custom Order</h3>
                    <p class="custom-intro">Hubungi kami untuk request ukuran khusus.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/detail.js') }}"></script>
@endpush
