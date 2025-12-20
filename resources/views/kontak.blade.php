    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">
    @endsection

    @section('content')

<!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Hubungi Kami</h1>
                <p>Kami siap membantu kebutuhan media luar ruang Anda</p>
            </div>
        </div>
    </section>

    <!-- Opening Statement -->
    <section class="opening-section">
        <div class="container">
            <div class="opening-content">
                <div class="section-badge">
                    <i class="fas fa-envelope"></i>
                    Contact Us
                </div>
                <h2>Bhineka Cipta Kreasi – Cabang Purwokerto</h2>
                <p class="lead-text">
                    Kami selalu siap membantu Anda dalam kebutuhan media luar ruang (OOH). 
                    Jangan ragu untuk menghubungi kami melalui kontak di bawah ini, baik untuk 
                    konsultasi, pertanyaan, atau permintaan penawaran.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="contact-cards-section">
        <div class="container">
            <div class="contact-cards-grid">
                <div class="contact-card">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Alamat Kami</h3>
                    <p>Jl. Raya Prompong RT 04/04 Kutasari</p>
                    <p>Kec. Baturaden, Kab. Banyumas</p>
                    <p>Jawa Tengah</p>
                    <a href="https://karyasatria.com" target="_blank" class="card-link">
                        Lihat di Maps <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="contact-card">
                    <div class="card-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Telepon</h3>
                    <p class="contact-value">(0281) 6572506</p>
                    <p class="contact-desc">Hubungi kami untuk informasi lebih lanjut</p>
                    <a href="tel:02816572506" class="card-link">
                        Telepon Sekarang <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="contact-card">
                    <div class="card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p class="contact-value">purwokerto@karyasatria.com</p>
                    <p class="contact-desc">Kirim email untuk penawaran atau pertanyaan</p>
                    <a href="mailto:purwokerto@karyasatria.com" class="card-link">
                        Kirim Email <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="contact-card">
                    <div class="card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Jam Operasional</h3>
                    <div class="hours-list">
                        <div class="hour-item">
                            <span class="day">Senin - Jumat</span>
                            <span class="time open">08.00 - 17.00</span>
                        </div>
                        <div class="hour-item">
                            <span class="day">Sabtu</span>
                            <span class="time open">08.00 - 12.00</span>
                        </div>
                        <div class="hour-item">
                            <span class="day">Minggu & Libur</span>
                            <span class="time closed">Tutup</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-content">
                <h2>Lokasi Kami</h2>
                <p class="map-subtitle">Kunjungi kantor kami di Purwokerto</p>
                <div class="map-container">
                    <iframe 
                        src="https://karyasatria.com" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
                <div class="map-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Klik peta untuk melihat rute ke lokasi kami</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <div class="cta-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2>Butuh Bantuan Segera?</h2>
                <p>
                    Kami siap membantu kebutuhan advertising Anda dari konsultasi, perencanaan, 
                    hingga pemasangan. Hubungi kami sekarang dan dapatkan solusi media luar ruang 
                    yang tepat untuk bisnis Anda!
                </p>
                <a href="https://wa.me/6282314027509" target="_blank" class="btn-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </section>
    
    @endsection

    @push('scripts')
    <script src="{{ asset('js/kontak.js') }}"></script>
    @endpush