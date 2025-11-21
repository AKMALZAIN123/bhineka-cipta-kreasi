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
                        <i class="fas fa-shopping-cart" onclick="window.location.href='{{ route('cart') }}'"></i>
                        <span class="cart-badge">0</span>
                    </button>

                    @guest
                        {{-- User belum login --}}
                        <button class="icon-btn">
                            <i class="fas fa-user" onclick="window.location.href='{{ route('login.form') }}'"></i>
                        </button>
                    @endguest

                    @auth
                        {{-- User sudah login --}}
                        <div class="user-dropdown">
                            <button class="icon-btn dropdown-toggle" id="userDropdownBtn">
                                <i class="fas fa-user"></i>
                            </button>

                            <div class="dropdown-menu" id="userDropdownMenu">
                                <p class="dropdown-user-name">
                                    Halo, <strong>{{ Auth::user()->name }}</strong>
                                </p>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item logout-btn">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

            </div>
        </div>
    </nav>