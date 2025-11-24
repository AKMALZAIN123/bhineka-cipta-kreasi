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
            <a href="{{ route('produk') }}" class="btn-primary">
                Lihat Produk
                <i class="fas fa-arrow-right"></i>
            </a>
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
                    <p>Berbagai ukuran dan bahan berkualitas tinggi untuk promosi Anda</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Kartu Undangan</h3>
                    <p>Desain custom dan cetak premium untuk acara spesial Anda</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h3>Lanyard & ID Card</h3>
                    <p>Untuk event, kantor, dan keperluan identifikasi profesional</p>
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
                @foreach ($products as $product)
                <div class="product-card">
                    @if($product->badge)
                        <div class="product-badge">{{ $product->badge }}</div>
                    @endif

                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i>
                    </button>

                    <a href="{{ route('produk.detail', $product->product_id) }}">
                        <div class="product-image">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        </div>
                     </a>
                        <div class="product-info">
                            <h3>{{ $product->name }}</h3>
                            <p class="product-desc">{{ $product->description }}</p>

                            <div class="product-footer">
                                <span class="price">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}

                                    @if ($product->old_price)
                                        <span class="old-price">Rp {{ number_format($product->old_price, 0, ',', '.') }}</span>
                                    @endif
                                </span>
                                
                                <form action="{{ route('cart.add') }}" method="POST" class="cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    <button type="button" 
                                        class="add-to-cart" 
                                        data-auth="{{ auth()->check() ? 'true' : 'false' }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                   
                </div>
                @endforeach

            </div>

            
            <div class="text-center">
                <a href="{{ route('produk') }}" class="btn-secondary">Lihat Semua Produk</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-us">
        <div class="container">
            <div class="section-header">
                <h2>Mengapa Memilih Kami</h2>
                <p>Komitmen kami untuk memberikan layanan terbaik bagi pelanggan</p>
            </div>
            
            <div class="why-us-grid">
                <div class="why-us-card">
                    <div class="why-us-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Kualitas Terjamin</h3>
                    <p>Material premium dan hasil cetak berkualitas tinggi untuk setiap produk</p>
                </div>
                
                <div class="why-us-card">
                    <div class="why-us-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Proses Cepat</h3>
                    <p>Pengerjaan efisien dengan waktu produksi yang tepat waktu</p>
                </div>
                
                <div class="why-us-card">
                    <div class="why-us-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Layanan 24/7</h3>
                    <p>Tim customer service siap membantu Anda kapan saja</p>
                </div>
                
                <div class="why-us-card">
                    <div class="why-us-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3>Harga Kompetitif</h3>
                    <p>Harga terjangkau tanpa mengurangi kualitas produk</p>
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

    @endsection

    @push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    @endpush