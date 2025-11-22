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
                    <p class="result-count">Menampilkan <strong>48 produk</strong></p>
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
                <!-- Product 1 -->
                <div class="product-card" data-product-id="1">
                    <div class="product-badge">Terlaris</div>
                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i>
                    </button>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1611329857570-f02f340e7378?w=400" alt="Banner X">
                        <div class="product-overlay">
                            <button class="btn-quick-view" onclick="window.location.href='{{ route('detail') }}'">
                                <i class="fas fa-eye"></i>
                                Quick View
                            </button>
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
                <div class="product-card" data-product-id="3">
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
                <div class="product-card" data-product-id="4">
                    <div class="product-badge">Baru</div>
                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i>
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
                <div class="product-card" data-product-id="5">
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
                <div class="product-card" data-product-id="6">
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
                <div class="product-card" data-product-id="7">
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
                <div class="product-card" data-product-id="8">
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
                <div class="product-card" data-product-id="9">
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
    </section>    
    @endsection

    @push('scripts')
    <script src="{{ asset('js/produk.js') }}"></script>
    @endpush
