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
            <div class="products-layout">
                <!-- Sidebar Filter -->
                <aside class="filter-sidebar" id="filterSidebar">
                    <div class="filter-header">
                        <h3>
                            <i class="fas fa-filter"></i>
                            Filter Produk
                        </h3>
                        <button class="filter-close" id="filterClose">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">Kategori</h4>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="checkbox" name="category" value="all" checked>
                                <span>Semua Produk</span>
                                <span class="count">(48)</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="category" value="banner">
                                <span>Banner & Spanduk</span>
                                <span class="count">(12)</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="category" value="invitation">
                                <span>Kartu Undangan</span>
                                <span class="count">(8)</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="category" value="lanyard">
                                <span>Lanyard & ID Card</span>
                                <span class="count">(6)</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="category" value="booth">
                                <span>Booth & Tenda</span>
                                <span class="count">(5)</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="category" value="merchandise">
                                <span>Merchandise</span>
                                <span class="count">(10)</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="category" value="digital">
                                <span>Media Digital</span>
                                <span class="count">(7)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">Harga</h4>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="radio" name="price" value="all" checked>
                                <span>Semua Harga</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="price" value="0-100000">
                                <span>< Rp 100.000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="price" value="100000-500000">
                                <span>Rp 100.000 - Rp 500.000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="price" value="500000-1000000">
                                <span>Rp 500.000 - Rp 1.000.000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="price" value="1000000-">
                                <span>> Rp 1.000.000</span>
                            </label>
                        </div>
                    </div>

                    <!-- Material Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">Bahan</h4>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="checkbox" name="material" value="flexi">
                                <span>Flexi Korea</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="material" value="vinyl">
                                <span>Vinyl</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="material" value="albatros">
                                <span>Albatros</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" name="material" value="stainless">
                                <span>Stainless Steel</span>
                            </label>
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <button class="btn-reset" id="btnReset">
                        <i class="fas fa-redo"></i>
                        Reset Filter
                    </button>
                </aside>

                <!-- Products Content -->
                <div class="products-content">
                    <!-- Toolbar -->
                    <div class="products-toolbar">
                        <div class="toolbar-left">
                            <button class="btn-filter-mobile" id="btnFilterMobile">
                                <i class="fas fa-filter"></i>
                                Filter
                            </button>
                            <p class="result-count">Menampilkan <strong>48 produk</strong></p>
                        </div>
                        <div class="toolbar-right">
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="grid">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="view-btn" data-view="list">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
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
                        <!-- Product 1 -->
                        <div class="product-card" data-product-id="1">
                            <div class="product-badge">Terlaris</div>
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1611329857570-f02f340e7378?w=400" alt="Banner X">
                                <div class="product-overlay">
                                    <a href="{{ route('detail') }}" class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </a>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Banner & Spanduk</div>
                                <h3>Banner X Premium</h3>
                                <p class="product-desc">Ukuran 160x60cm, Material Premium</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(4.5)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 125.000</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="product-card" data-product-id="2">
                            <div class="product-badge sale">Promo</div>
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1530435460869-d13625c69bbf?w=400" alt="Kartu Undangan">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Kartu Undangan</div>
                                <h3>Kartu Undangan Custom</h3>
                                <p class="product-desc">Desain custom, cetak 100 pcs</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>(5.0)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 299.000 <span class="old-price">Rp 350.000</span></span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="product-card">
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=400" alt="Lanyard">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Lanyard & ID Card</div>
                                <h3>Lanyard Custom Logo</h3>
                                <p class="product-desc">Print sublim, minimal order 50 pcs</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span>(4.0)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 15.000/pcs</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="product-card">
                            <div class="product-badge">Baru</div>
                            <button class="wishlist-btn active">
                                <i class="fas fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1534452203293-494d7ddbf7e0?w=400" alt="Tumbler">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Merchandise</div>
                                <h3>Tumbler Stainless Custom</h3>
                                <p class="product-desc">500ml dengan logo perusahaan</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(4.7)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 75.000</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="product-card">
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1588282322673-c31965a75c3e?w=400" alt="Booth">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Booth & Tenda</div>
                                <h3>Booth Promosi 3x3m</h3>
                                <p class="product-desc">Tenda promosi dengan custom print</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>(5.0)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 2.500.000</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 6 -->
                        <div class="product-card">
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400" alt="Roll Up">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Banner & Spanduk</div>
                                <h3>Roll Up Banner</h3>
                                <p class="product-desc">85x200cm, portable dan praktis</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span>(4.2)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 225.000</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 7 -->
                        <div class="product-card">
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1609921212029-bb5a28e60960?w=400" alt="Spanduk">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Banner & Spanduk</div>
                                <h3>Spanduk Flexi Korea</h3>
                                <p class="product-desc">Custom ukuran, material premium</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(4.6)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 35.000/m²</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 8 -->
                        <div class="product-card">
                            <div class="product-badge">Populer</div>
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=400" alt="Sticker">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Merchandise</div>
                                <h3>Sticker Vinyl Cut</h3>
                                <p class="product-desc">Custom design, tahan lama</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>(4.9)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 25.000/m²</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 9 -->
                        <div class="product-card">
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=400" alt="Mug">
                                <div class="product-overlay">
                                    <button class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">Merchandise</div>
                                <h3>Mug Custom Print</h3>
                                <p class="product-desc">Keramik berkualitas, cetak sublim</p>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span>(4.3)</span>
                                </div>
                                <div class="product-footer">
                                    <span class="price">Rp 35.000/pcs</span>
                                    <button class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <button class="page-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
                        <span class="page-dots">...</span>
                        <button class="page-btn">10</button>
                        <button class="page-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection

    @push('scripts')
    <script src="{{ asset('js/produk.js') }}"></script>
    @endpush
