    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @endsection

    @section('content')

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Bhineka Cipta Kreasi</h1>
            <p class="hero-subtitle">
                Wujudkan Brand Impian Anda dengan Layanan Percetakan & Periklanan Profesional. 
                Dari Banner, Kartu Undangan, hingga Media Promosi Berkualitas Tinggi.
            </p>
            <button class="btn-primary">
                Lihat Produk
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="categories">
        <div class="container">
            <div class="section-header">
                <h2>Layanan Kami</h2>
                <p>Berbagai solusi percetakan dan periklanan untuk kebutuhan bisnis Anda</p>
            </div>
            
            <div class="category-grid">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h3>Banner & Spanduk</h3>
                    <p>Berbagai ukuran dan bahan berkualitas</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Kartu Undangan</h3>
                    <p>Desain custom dan cetak premium</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h3>Lanyard & ID Card</h3>
                    <p>Untuk event dan keperluan kantor</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3>Booth & Tenda</h3>
                    <p>Alat peraga promosi profesional</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-mug-hot"></i>
                    </div>
                    <h3>Merchandise</h3>
                    <p>Botol minum, tumbler, dan aksesoris</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-tv"></i>
                    </div>
                    <h3>Media Digital</h3>
                    <p>Videotron dan baliho digital</p>
                </div>
            </div>
        </div>
    </section>

    <!-- New Products -->
    <section class="products">
        <div class="container">
            <div class="section-header">
                <h2>Produk Terbaru</h2>
                <p>Temukan produk terbaru dengan kualitas terbaik dan harga terjangkau</p>
            </div>
            
            <div class="product-grid">
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-badge">Baru</div>
                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i>
                    </button>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1611329857570-f02f340e7378?w=400" alt="Banner X">
                    </div>
                    <div class="product-info">
                        <h3>Banner X Premium</h3>
                        <p class="product-desc">Ukuran 160x60cm, Material Premium</p>
                        <div class="product-footer">
                            <span class="price">Rp 125.000</span>
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <div class="product-badge">Populer</div>
                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i>
                    </button>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1530435460869-d13625c69bbf?w=400" alt="Kartu Undangan">
                    </div>
                    <div class="product-info">
                        <h3>Kartu Undangan Custom</h3>
                        <p class="product-desc">Desain custom, cetak 100 pcs</p>
                        <div class="product-footer">
                            <span class="price">Rp 350.000</span>
                            <button class="add-to-cart">
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
                    </div>
                    <div class="product-info">
                        <h3>Lanyard Custom Logo</h3>
                        <p class="product-desc">Print sublim, minimal order 50 pcs</p>
                        <div class="product-footer">
                            <span class="price">Rp 15.000</span>
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card">
                    <div class="product-badge sale">Promo</div>
                    <button class="wishlist-btn active">
                        <i class="fas fa-heart"></i>
                    </button>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1534452203293-494d7ddbf7e0?w=400" alt="Tumbler">
                    </div>
                    <div class="product-info">
                        <h3>Tumbler Stainless Custom</h3>
                        <p class="product-desc">500ml dengan logo perusahaan</p>
                        <div class="product-footer">
                            <span class="price">Rp 75.000 <span class="old-price">Rp 95.000</span></span>
                            <button class="add-to-cart">
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
                    </div>
                    <div class="product-info">
                        <h3>Booth Promosi 3x3m</h3>
                        <p class="product-desc">Tenda promosi dengan custom print</p>
                        <div class="product-footer">
                            <span class="price">Rp 2.500.000</span>
                            <button class="add-to-cart">
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
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400" alt="Banner Roll Up">
                    </div>
                    <div class="product-info">
                        <h3>Roll Up Banner</h3>
                        <p class="product-desc">85x200cm, portable dan praktis</p>
                        <div class="product-footer">
                            <span class="price">Rp 225.000</span>
                            <button class="add-to-cart">
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
                    </div>
                    <div class="product-info">
                        <h3>Spanduk Flexi Korea</h3>
                        <p class="product-desc">Custom ukuran, material premium</p>
                        <div class="product-footer">
                            <span class="price">Rp 35.000/m²</span>
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="product-card">
                    <div class="product-badge">Terlaris</div>
                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i>
                    </button>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=400" alt="Sticker">
                    </div>
                    <div class="product-info">
                        <h3>Sticker Vinyl Cut</h3>
                        <p class="product-desc">Custom design, tahan lama</p>
                        <div class="product-footer">
                            <span class="price">Rp 25.000/m²</span>
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <button class="btn-secondary">Lihat Semua Produk</button>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="promo-section">
        <div class="container">
            <div class="promo-grid">
                <div class="promo-image">
                    <img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=600" alt="Promo">
                </div>
                <div class="promo-content">
                    <h2>Dapatkan Penawaran Spesial!</h2>
                    <p>Desain gratis untuk pemesanan banner dan spanduk di atas 10m². Promo terbatas hanya bulan ini!</p>
                    <ul class="promo-features">
                        <li><i class="fas fa-check"></i> Desain gratis oleh tim profesional</li>
                        <li><i class="fas fa-check"></i> Revisi unlimited hingga puas</li>
                        <li><i class="fas fa-check"></i> Cetak berkualitas tinggi</li>
                        <li><i class="fas fa-check"></i> Pengiriman cepat</li>
                    </ul>
                    <button class="btn-primary">
                        Dapatkan Promo
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Collections -->
    <section class="collections" id="collections">
        <div class="container">
            <div class="section-header">
                <h2>Koleksi Unggulan</h2>
                <p>Jelajahi kategori produk pilihan untuk kebutuhan promosi dan event Anda</p>
            </div>
            
            <div class="collection-grid">
                <div class="collection-card large">
                    <img src="https://images.unsplash.com/photo-1596079890744-c1a0462d0975?w=600" alt="Percetakan">
                    <div class="collection-overlay">
                        <h3>Percetakan</h3>
                        <p>Banner, Spanduk, Brosur & Lebih</p>
                        <button class="btn-outline">Jelajahi</button>
                    </div>
                </div>
                
                <div class="collection-card">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400" alt="Event">
                    <div class="collection-overlay">
                        <h3>Alat Event</h3>
                        <p>Booth, Tenda & Backdrop</p>
                        <button class="btn-outline">Jelajahi</button>
                    </div>
                </div>
                
                <div class="collection-card">
                    <img src="https://images.unsplash.com/photo-1556656793-08538906a9f8?w=400" alt="Merchandise">
                    <div class="collection-overlay">
                        <h3>Merchandise</h3>
                        <p>Custom Branding Products</p>
                        <button class="btn-outline">Jelajahi</button>
                    </div>
                </div>
                
                <div class="collection-card">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400" alt="Digital">
                    <div class="collection-overlay">
                        <h3>Media Digital</h3>
                        <p>Videotron & Baliho</p>
                        <button class="btn-outline">Jelajahi</button>
                    </div>
                </div>
                
                <div class="collection-card large">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600" alt="Corporate">
                    <div class="collection-overlay">
                        <h3>Corporate</h3>
                        <p>Solusi Lengkap untuk Bisnis</p>
                        <button class="btn-outline">Jelajahi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <h2>Dapatkan Penawaran Eksklusif</h2>
                <p>Daftarkan email Anda dan dapatkan info promo, tips branding, dan penawaran spesial langsung ke inbox Anda</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Masukkan email Anda" required>
                    <button type="submit" class="btn-primary">Berlangganan</button>
                </form>
            </div>
        </div>
    </section>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    @endpush