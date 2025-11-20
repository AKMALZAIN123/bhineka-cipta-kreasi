    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <i class="fas fa-print"></i>
                    <span>Bhineka Cipta Kreasi</span>
                </div>
                
               <div class="nav-links" id="navLinks">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('produk') }}" class="{{ request()->routeIs('produk') ? 'active' : '' }}">Produk</a>
                    <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
                    <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a>
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