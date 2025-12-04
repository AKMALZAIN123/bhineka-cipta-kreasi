    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <div class="footer-logo">
                        <a href="{{ route('home') }}" class="logologo">
                            <img src="{{ asset('images/logo_footer.png') }}" alt="Bhineka Cipta Kreasi Logo" class="logo-img">
                        </a>
                    </div>
                    <p>Solusi terpercaya untuk semua kebutuhan percetakan dan periklanan Anda sejak 20+ tahun.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h4>Produk Kami</h4>
                    <ul>
                        <li><a href="{{ route('home') }}#categories">Banner & Spanduk</a></li>
                        <li><a href="{{ route('home') }}#categories">Kartu Undangan</a></li>
                        <li><a href="{{ route('home') }}#categories">Lanyard & ID Card</a></li>
                        <li><a href="{{ route('produk') }}">Lihat Semua Produk</a></li>
                        <li><a href="{{ route('home') }}#gallery">Galeri Hasil Karya</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#cara-pesan">Cara Pemesanan</a></li>
                        <li><a href="{{ route('syarat') }}">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('privasi') }}">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Hubungi Kami</h4>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>(0281) 6572506</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>purwokerto@karyasatria.com</span>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Raya Prompong RT 04/04, Baturaden</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Senin - Sabtu: 08.00 - 17.00</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Bhineka Cipta Kreasi. All Rights Reserved.</p>
            </div>
        </div>
    </footer>