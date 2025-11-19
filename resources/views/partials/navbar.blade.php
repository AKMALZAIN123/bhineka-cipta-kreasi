    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <i class="fas fa-print"></i>
                    <span>Bhineka Cipta Kreasi</span>
                </div>
                
                <div class="nav-links" id="navLinks">
                    <a href="/" class="active">Beranda</a>
                    <a href="produk.html">Produk</a>
                    <a href="#collections">Koleksi</a>
                    <a href="#about">Tentang</a>
                    <a href="#contact">Kontak</a>
                </div>
                
                <div class="nav-actions">
                    <button class="icon-btn">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="icon-btn cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge">0</span>
                    </button>
                    <button class="icon-btn" >
                        <i class="fas fa-user" onclick="window.location.href='{{ route('login') }}'"></i>
                    </button>
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>