<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdPrint Pro - Advertising & Printing Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <!-- Desktop: Full Name -->
                <div class="hidden md:block text-xl font-semibold tracking-wider text-[#a0826d]">
                    BHINEKA<span class="font-light"> CIPTA KREASI</span>
                </div>

                <!-- Mobile: Singkatan -->
                <div class="md:hidden text-[#a0826d]">
                    <div class="text-xl font-bold tracking-widest">BCK</div>
                    <div class="text-[9px] font-light tracking-wide -mt-0.5">BHINEKA CIPTA KREASI</div>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-[#a0826d] transition">BERANDA</a>
                    <a href="#services" class="text-gray-700 hover:text-[#a0826d] transition">LAYANAN</a>
                    <a href="#portfolio" class="text-gray-700 hover:text-[#a0826d] transition">PORTFOLIO</a>
                    <a href="#contact" class="text-gray-700 hover:text-[#a0826d] transition">KONTAK</a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700" id="mobileMenuBtn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="mobile-menu md:hidden mt-4" id="mobileMenu">
                <div class="flex flex-col space-y-3">
                    <a href="#home" class="text-gray-700 hover:text-[#a0826d] transition py-2">BERANDA</a>
                    <a href="#services" class="text-gray-700 hover:text-[#a0826d] transition py-2">LAYANAN</a>
                    <a href="#portfolio" class="text-gray-700 hover:text-[#a0826d] transition py-2">PORTFOLIO</a>
                    <a href="#contact" class="text-gray-700 hover:text-[#a0826d] transition py-2">KONTAK</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative h-screen flex items-center justify-center mt-16">
        <div class="absolute inset-0 bg-gray-300">
            <!-- Placeholder for hero image -->
            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                <img src="{{ asset('images/hero.png') }}" alt="Hero Image" class="w-full h-full object-cover">
            </div>
        </div>
        <div class="hero-overlay absolute inset-0"></div>
        <div class="relative z-10 text-center text-white px-6 fade-in">
            <h1 class="text-5xl md:text-7xl font-light mb-6 tracking-wider">
                TRANSFORMASI VISUAL<br>
                <span class="font-semibold">UNTUK BISNIS ANDA</span>
            </h1>
            <p class="text-lg md:text-xl mb-8 font-light max-w-2xl mx-auto">
                Solusi lengkap advertising dan printing untuk mengangkat brand Anda ke level selanjutnya
            </p>
            <a href="#contact" class="btn-primary inline-block px-8 py-4 text-white font-medium tracking-wide">
                REQUEST PENAWARAN
            </a>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="section-title text-sm mb-4">LAYANAN KAMI</h2>
                <h3 class="text-4xl md:text-5xl font-light text-gray-800">
                    Solusi <span class="font-semibold">Komprehensif</span>
                </h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Service Card 1 -->
                <div class="service-card bg-white rounded-lg shadow-md">
                    <div class="h-64 bg-gray-200 overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-blue-200 to-blue-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">services/printing.jpg</p>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800">PERCETAKAN</h4>
                        <p class="text-gray-600 text-sm">Banner, Undangan, Lanyard, Sticker & lebih banyak lagi</p>
                    </div>
                </div>
                
                <!-- Service Card 2 -->
                <div class="service-card bg-white rounded-lg shadow-md">
                    <div class="h-64 bg-gray-200 overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-green-200 to-green-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">services/promotional.jpg</p>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800">ALAT PERAGA</h4>
                        <p class="text-gray-600 text-sm">Booth, Tenda Promosi, X-Banner, Roll Banner</p>
                    </div>
                </div>
                
                <!-- Service Card 3 -->
                <div class="service-card bg-white rounded-lg shadow-md">
                    <div class="h-64 bg-gray-200 overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-purple-200 to-purple-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">services/merchandise.jpg</p>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800">MERCHANDISE</h4>
                        <p class="text-gray-600 text-sm">Botol Logo, Tumbler, Tote Bag, Custom Apparel</p>
                    </div>
                </div>
                
                <!-- Service Card 4 -->
                <div class="service-card bg-white rounded-lg shadow-md">
                    <div class="h-64 bg-gray-200 overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-orange-200 to-orange-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">services/outdoor.jpg</p>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800">MEDIA OUTDOOR</h4>
                        <p class="text-gray-600 text-sm">Baliho, Videotron, Neon Sign, Signboard</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="py-24 bg-[#f5f5f0]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="section-title text-sm mb-4">PORTFOLIO KAMI</h2>
                <h3 class="text-4xl md:text-5xl font-light text-gray-800">
                    Karya <span class="font-semibold">Terpilih</span>
                </h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Portfolio Item 1 -->
                <div class="portfolio-item bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-80 bg-gray-200">
                        <div class="w-full h-full bg-gradient-to-br from-red-200 to-red-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">portfolio/project-1.jpg</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 text-center">Event Booth Design</p>
                    </div>
                </div>
                
                <!-- Portfolio Item 2 -->
                <div class="portfolio-item bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-80 bg-gray-200">
                        <div class="w-full h-full bg-gradient-to-br from-blue-200 to-blue-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">portfolio/project-2.jpg</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 text-center">Corporate Branding</p>
                    </div>
                </div>
                
                <!-- Portfolio Item 3 -->
                <div class="portfolio-item bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-80 bg-gray-200">
                        <div class="w-full h-full bg-gradient-to-br from-yellow-200 to-yellow-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">portfolio/project-3.jpg</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 text-center">Billboard Campaign</p>
                    </div>
                </div>
                
                <!-- Portfolio Item 4 -->
                <div class="portfolio-item bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-80 bg-gray-200">
                        <div class="w-full h-full bg-gradient-to-br from-green-200 to-green-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">portfolio/project-4.jpg</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 text-center">Product Packaging</p>
                    </div>
                </div>
                
                <!-- Portfolio Item 5 -->
                <div class="portfolio-item bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-80 bg-gray-200">
                        <div class="w-full h-full bg-gradient-to-br from-purple-200 to-purple-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">portfolio/project-5.jpg</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 text-center">Exhibition Stand</p>
                    </div>
                </div>
                
                <!-- Portfolio Item 6 -->
                <div class="portfolio-item bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-80 bg-gray-200">
                        <div class="w-full h-full bg-gradient-to-br from-pink-200 to-pink-300 flex items-center justify-center">
                            <p class="text-gray-600 text-xs">portfolio/project-6.jpg</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 text-center">Merchandise Collection</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="btn-primary inline-block px-8 py-3 text-white font-medium tracking-wide">
                    LIHAT SEMUA PROJECT
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-[#a0826d]">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h2 class="text-4xl md:text-5xl font-light text-white mb-6">
                Siap Memulai <span class="font-semibold">Proyek Anda?</span>
            </h2>
            <p class="text-white text-lg mb-8 font-light">
                Hubungi kami untuk konsultasi gratis dan dapatkan penawaran terbaik
            </p>
            <a href="#contact" class="inline-block bg-white text-[#a0826d] px-10 py-4 font-semibold tracking-wide hover:shadow-2xl transition">
                HUBUNGI KAMI
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-[#2a2a2a] text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Company Info -->
                <div>
                    <h3 class="text-2xl font-semibold mb-4">ADPRINT<span class="font-light">PRO</span></h3>
                    <p class="text-gray-400 mb-4">
                        Solusi terpercaya untuk kebutuhan advertising dan printing berkualitas tinggi.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">QUICK LINKS</h4>
                    <ul class="space-y-2">
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Layanan</a></li>
                        <li><a href="#portfolio" class="text-gray-400 hover:text-white transition">Portfolio</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">KONTAK</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>📍 Jakarta, Indonesia</li>
                        <li>📞 +62 812 3456 7890</li>
                        <li>✉️ info@adprintpro.com</li>
                    </ul>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="hover:text-[#a0826d] transition">Instagram</a>
                        <a href="#" class="hover:text-[#a0826d] transition">Facebook</a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-500">
                <p>&copy; 2024 AdPrintPro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/6281234567890" target="_blank" class="whatsapp-float">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>