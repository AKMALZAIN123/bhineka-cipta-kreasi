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
                        <option value="default" {{ request('sort') == 'default' || !request('sort') ? 'selected' : '' }}>
                            Urutkan: Default
                        </option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                            Paling Populer
                        </option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                            Terbaru
                        </option>
                        <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>
                            Harga: Rendah ke Tinggi
                        </option>
                        <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>
                            Harga: Tinggi ke Rendah
                        </option>
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>
                            Nama: A-Z
                        </option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>
                            Nama: Z-A
                        </option>
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
                            <img src="{{ $product->image_url ? asset('storage/'.$product->image_url) : asset('img/default.png') }}" alt="{{ $product->name }}">
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
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>    
    @endsection

    @push('scripts')
    <script>
        sortSelect.addEventListener('change', (e) => {
            const sortValue = e.target.value;
            const searchValue = document.getElementById('searchInput')?.value || '';
            
            // Show loading indicator
            showNotification('Mengurutkan produk...', 'info');
            
            // Build URL with parameters
            const params = new URLSearchParams();
            if (sortValue !== 'default') params.set('sort', sortValue);
            if (searchValue) params.set('search', searchValue);
            
            // Fetch sorted products
            fetch(`/produk?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Parse and update products grid
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newGrid = doc.getElementById('productsGrid');
                
                if (newGrid) {
                    document.getElementById('productsGrid').innerHTML = newGrid.innerHTML;
                    showNotification(`Produk diurutkan berdasarkan: ${e.target.options[e.target.selectedIndex].text}`, 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mengurutkan produk', 'error');
            });
        });
    </script>
    <script src="{{ asset('js/produk.js') }}"></script>
    @endpush
