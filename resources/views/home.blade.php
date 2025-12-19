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
    <section class="categories" id="categories">
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
<<<<<<< HEAD
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
=======
                    <a href="{{ route('produk.detail', $product->product_id) }}" class="product-card-link">
                        <div class="product-card">
                            @if($product->badge)
                                <div class="product-badge">{{ $product->badge }}</div>
                            @endif
                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </div>
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
                                    <form action="{{ route('cart.add') }}" method="POST" class="cart-form" onClick="event.stopPropagation();">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="add-to-cart" data-auth="{{ auth()->check() ? 'true' : 'false' }}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
>>>>>>> d3c860f317827aa15c217290a289660d70dd0819
                            </div>
                        </div>
                    </a>
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

    <!-- How to Order Section -->
    <section class="how-to-order" id="cara-pesan">
        <div class="container">
            <div class="section-header">
                <h2>Cara Pemesanan</h2>
                <p>Proses pemesanan mudah dan cepat, dari konsultasi hingga produk sampai ke tangan Anda</p>
            </div>
            
            <div class="order-steps">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Pilih Produk</h3>
                    <p>Pilih produk dari katalog atau sampaikan kebutuhan khusus Anda</p>
                </div>
                
                <div class="step-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
                
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-ruler-combined"></i>
                    </div>
                    <h3>Masukkan Desain & Pilih Ukuran</h3>
                    <p>Upload desain Anda dan pilih ukuran yang sesuai kebutuhan</p>
                </div>
                
                <div class="step-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
                
                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h3>Konfirmasi & Bayar</h3>
                    <p>Setujui pesanan dan lakukan pembayaran dengan mudah</p>
                </div>
                
                <div class="step-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
                
                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3>Produksi</h3>
                    <p>Produk diproduksi dengan kualitas terbaik dan cepat</p>
                </div>
                
                <div class="step-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
                
                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Pengiriman</h3>
                    <p>Produk dikirim atau ambil langsung di tempat kami</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Portfolio -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="section-header">
                <h2>Galeri Hasil Karya</h2>
                <p>Lihat portofolio hasil cetakan berkualitas yang telah kami kerjakan</p>
            </div>
            
            <div class="gallery-grid">
                <!-- Banner & Spanduk 1 -->
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/banner.png') }}" alt="Banner Event">
                    </div>
                    <div class="gallery-caption">
                        <h4>Banner Event Outdoor</h4>
                        <p>Banner outdoor 3x2 meter</p>
                    </div>
                </div>
                
                <!-- Banner & Spanduk 2 -->
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/grandopening.jpeg') }}" alt="Spanduk Promosi">
                    </div>
                    <div class="gallery-caption">
                        <h4>Spanduk Grand Opening</h4>
                        <p>Spanduk flexi 5x1 meter</p>
                    </div>
                </div>
                
                <!-- Kartu Undangan 1 -->
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/wedding.jpeg') }}" alt="Kartu Undangan Wedding">
                    </div>
                    <div class="gallery-caption">
                        <h4>Undangan Pernikahan Hardcover</h4>
                        <p>Hardcover dengan emboss gold</p>
                    </div>
                </div>
                
                <!-- Kartu Undangan 2 -->
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/card-custom.jpeg') }}" alt="Kartu Undangan Premium">
                    </div>
                    <div class="gallery-caption">
                        <h4>Undangan Custom</h4>
                        <p>Art carton dengan foil printing</p>
                    </div>
                </div>
                
                <!-- Lanyard & ID Card 1 -->
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/lanyard.jpeg') }}" alt="Lanyard Custom">
                    </div>
                    <div class="gallery-caption">
                        <h4>Lanyard Custom</h4>
                        <p>Print sublim dengan logo perusahaan</p>
                    </div>
                </div>
                
                <!-- Lanyard & ID Card 2 -->
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/idcard.jpeg') }}" alt="ID Card">
                    </div>
                    <div class="gallery-caption">
                        <h4>ID Card Event</h4>
                        <p>PVC card dengan print full color</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    @endpush