@extends('layouts.app')

@section('title', 'Produk')

@section('css')
<link rel="stylesheet" href="{{ asset('css/produk.css') }}">
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
                <span>Produk</span>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <div class="header-badge">
                    <i class="fas fa-box-open"></i>
                    <span>Katalog Produk</span>
                </div>
                <h1>Produk Unggulan Kami</h1>
                <p>Pilihan terbaik untuk kebutuhan percetakan dan periklanan bisnis Anda</p>
            </div>

            <!-- Toolbar -->
            <div class="products-toolbar">
                <div class="toolbar-left">
                    <!-- Search Result -->
                        @if(request('search'))
                            <p class="result-count">
                                Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                                {{ $products->total() }} produk ditemukan
                            </p>
                        @else
                            <p class="result-count">Menampilkan <strong>{{ $products->total() }} produk</strong></p>
                        @endif
                </div>
                <div class="toolbar-right">
                    <select class="sort-select" id="sortSelect">
                        <option value="default">Urutkan: Default</option>
                        <option value="popular">Paling Populer</option>
                        <option value="newest">Terbaru</option>
                        <option value="price-low">Harga: Rendah ke Tinggi</option>
                        <option value="price-high">Harga: Tinggi ke Rendah</option>
                        <option value="name-asc">Nama: A-Z</option>
                        <option value="name-desc">Nama: Z-A</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
                @forelse($products as $product)
                    <div class="product-card" data-product-id="{{ $product->product_id }}">
                        
                        @if($product->badge)
                            <div class="product-badge">{{ $product->badge }}</div>
                        @endif
                        
                        <button class="wishlist-btn">
                            <i class="far fa-heart"></i>
                        </button>

                        <div class="product-image">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            <div class="product-overlay">
                                <button class="btn-quick-view" onclick="window.location.href='{{ route('produk.detail', $product->product_id) }}'">
                                    <i class="fas fa-eye"></i>
                                    Quick View
                                </button>
                            </div>
                        </div>

                        <div class="product-info">
                            <div class="product-category">{{ $product->category }}</div>

                            <h3>{{ $product->name }}</h3>
                            <p class="product-desc">{{ $product->description }}</p>

                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(4.5)</span>
                            </div>

                            <div class="product-footer">
                                <span class="price">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                    @if($product->old_price)
                                        <span class="old-price">Rp {{ number_format($product->old_price, 0, ',', '.') }}</span>
                                    @endif
                                </span>

                                <form action="{{ route('cart.add') }}" method="POST" class="cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    <button type="submit" 
                                        class="btn-add-cart" 
                                        data-auth="{{ auth()->check() ? 'true' : 'false' }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    <p class="text-center">Belum ada produk tersedia.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>    
    @endsection

    @push('scripts')
    <script src="{{ asset('js/produk.js') }}"></script>
    @endpush
