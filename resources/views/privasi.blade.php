@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/privasi.css') }}">
@endsection

@section('content')

    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-items">
                <a href="index.html">
                    <i class="fas fa-home"></i>
                    Beranda
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Kebijakan Privasi</span>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>Kebijakan Privasi</h1>
            <p>Terakhir diperbarui: 24 November 2025</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="content-layout">
                <!-- Sidebar Navigation -->
                <aside class="sidebar-nav">
                    <h3>Daftar Isi</h3>
                    <ul>
                        <li><a href="#pendahuluan" class="active">Pendahuluan</a></li>
                        <li><a href="#informasi">Informasi yang Kami Kumpulkan</a></li>
                        <li><a href="#penggunaan">Penggunaan Informasi</a></li>
                        <li><a href="#penyimpanan">Penyimpanan Data</a></li>
                        <li><a href="#keamanan">Keamanan Data</a></li>
                        <li><a href="#hak">Hak Pengguna</a></li>
                        <li><a href="#cookies">Cookies</a></li>
                        <li><a href="#perubahan">Perubahan Kebijakan</a></li>
                        <li><a href="#kontak-privacy">Hubungi Kami</a></li>
                    </ul>
                </aside>

                <!-- Main Content -->
                <div class="main-content">
                    <!-- Pendahuluan -->
                    <div class="content-block" id="pendahuluan">
                        <h2>1. Pendahuluan</h2>
                        <p>Selamat datang di Bhineka Cipta Kreasi. Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi yang Anda berikan kepada kami.</p>
                        <p>Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan layanan kami, baik melalui website, aplikasi, maupun layanan lainnya.</p>
                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            <p>Dengan menggunakan layanan kami, Anda menyetujui pengumpulan dan penggunaan informasi sesuai dengan kebijakan ini.</p>
                        </div>
                    </div>

                    <!-- Informasi yang Dikumpulkan -->
                    <div class="content-block" id="informasi">
                        <h2>2. Informasi yang Kami Kumpulkan</h2>
                        <p>Kami mengumpulkan beberapa jenis informasi untuk memberikan layanan terbaik kepada Anda:</p>
                        
                        <h3>2.1 Informasi Pribadi</h3>
                        <ul>
                            <li>Nama lengkap</li>
                            <li>Alamat email</li>
                            <li>Nomor telepon</li>
                            <li>Alamat pengiriman</li>
                            <li>Informasi pembayaran</li>
                        </ul>

                        <h3>2.2 Informasi Otomatis</h3>
                        <ul>
                            <li>Alamat IP</li>
                            <li>Jenis browser dan perangkat</li>
                            <li>Halaman yang dikunjungi</li>
                            <li>Waktu dan tanggal kunjungan</li>
                            <li>Lokasi geografis (jika diizinkan)</li>
                        </ul>

                        <h3>2.3 Informasi Transaksi</h3>
                        <ul>
                            <li>Riwayat pesanan</li>
                            <li>Detail produk yang dibeli</li>
                            <li>Jumlah pembayaran</li>
                            <li>Metode pembayaran</li>
                        </ul>
                    </div>

                    <!-- Penggunaan Informasi -->
                    <div class="content-block" id="penggunaan">
                        <h2>3. Penggunaan Informasi</h2>
                        <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                        
                        <div class="usage-grid">
                            <div class="usage-card">
                                <i class="fas fa-box"></i>
                                <h4>Pemrosesan Pesanan</h4>
                                <p>Memproses dan mengirimkan pesanan Anda dengan akurat</p>
                            </div>
                            <div class="usage-card">
                                <i class="fas fa-headset"></i>
                                <h4>Layanan Pelanggan</h4>
                                <p>Memberikan dukungan dan merespons pertanyaan Anda</p>
                            </div>
                            <div class="usage-card">
                                <i class="fas fa-envelope"></i>
                                <h4>Komunikasi</h4>
                                <p>Mengirim update pesanan dan informasi promosi</p>
                            </div>
                            <div class="usage-card">
                                <i class="fas fa-chart-line"></i>
                                <h4>Peningkatan Layanan</h4>
                                <p>Menganalisis dan meningkatkan kualitas layanan kami</p>
                            </div>
                        </div>
                    </div>

                    <!-- Penyimpanan Data -->
                    <div class="content-block" id="penyimpanan">
                        <h2>4. Penyimpanan Data</h2>
                        <p>Data pribadi Anda disimpan dengan ketentuan sebagai berikut:</p>
                        <ul>
                            <li>Data disimpan di server yang aman dan terenkripsi</li>
                            <li>Penyimpanan mengikuti standar keamanan industri</li>
                            <li>Data transaksi disimpan selama 5 tahun sesuai regulasi</li>
                            <li>Data akun aktif disimpan selama akun masih digunakan</li>
                            <li>Data dapat dihapus atas permintaan pengguna</li>
                        </ul>
                    </div>

                    <!-- Keamanan Data -->
                    <div class="content-block" id="keamanan">
                        <h2>5. Keamanan Data</h2>
                        <p>Kami menggunakan berbagai langkah keamanan untuk melindungi informasi Anda:</p>
                        
                        <div class="security-features">
                            <div class="security-item">
                                <i class="fas fa-lock"></i>
                                <div>
                                    <h4>Enkripsi SSL/TLS</h4>
                                    <p>Semua data ditransmisikan menggunakan enkripsi SSL/TLS</p>
                                </div>
                            </div>
                            <div class="security-item">
                                <i class="fas fa-database"></i>
                                <div>
                                    <h4>Database Aman</h4>
                                    <p>Database dilindungi dengan firewall dan akses terbatas</p>
                                </div>
                            </div>
                            <div class="security-item">
                                <i class="fas fa-user-shield"></i>
                                <div>
                                    <h4>Akses Terkontrol</h4>
                                    <p>Hanya staf tertentu yang memiliki akses ke data pribadi</p>
                                </div>
                            </div>
                            <div class="security-item">
                                <i class="fas fa-sync-alt"></i>
                                <div>
                                    <h4>Backup Rutin</h4>
                                    <p>Data di-backup secara berkala untuk mencegah kehilangan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hak Pengguna -->
                    <div class="content-block" id="hak">
                        <h2>6. Hak Pengguna</h2>
                        <p>Sebagai pengguna, Anda memiliki hak berikut:</p>
                        
                        <div class="rights-list">
                            <div class="right-item">
                                <span class="right-number">1</span>
                                <div>
                                    <h4>Hak Akses</h4>
                                    <p>Anda berhak mengakses dan mengetahui data pribadi yang kami simpan</p>
                                </div>
                            </div>
                            <div class="right-item">
                                <span class="right-number">2</span>
                                <div>
                                    <h4>Hak Koreksi</h4>
                                    <p>Anda dapat meminta pembaruan atau koreksi data yang tidak akurat</p>
                                </div>
                            </div>
                            <div class="right-item">
                                <span class="right-number">3</span>
                                <div>
                                    <h4>Hak Penghapusan</h4>
                                    <p>Anda dapat meminta penghapusan data pribadi Anda</p>
                                </div>
                            </div>
                            <div class="right-item">
                                <span class="right-number">4</span>
                                <div>
                                    <h4>Hak Portabilitas</h4>
                                    <p>Anda dapat meminta salinan data Anda dalam format yang mudah dibaca</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cookies -->
                    <div class="content-block" id="cookies">
                        <h2>7. Penggunaan Cookies</h2>
                        <p>Kami menggunakan cookies untuk meningkatkan pengalaman Anda:</p>
                        
                        <div class="cookies-info">
                            <div class="cookie-type">
                                <h4><i class="fas fa-cookie"></i> Cookies Esensial</h4>
                                <p>Diperlukan untuk fungsi dasar website seperti keranjang belanja dan login</p>
                            </div>
                            <div class="cookie-type">
                                <h4><i class="fas fa-chart-bar"></i> Cookies Analitik</h4>
                                <p>Membantu kami memahami bagaimana pengunjung menggunakan website</p>
                            </div>
                            <div class="cookie-type">
                                <h4><i class="fas fa-bullhorn"></i> Cookies Marketing</h4>
                                <p>Digunakan untuk menampilkan iklan yang relevan dengan minat Anda</p>
                            </div>
                        </div>
                        
                        <p>Anda dapat mengatur preferensi cookies melalui pengaturan browser Anda.</p>
                    </div>

                    <!-- Perubahan Kebijakan -->
                    <div class="content-block" id="perubahan">
                        <h2>8. Perubahan Kebijakan</h2>
                        <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu untuk mencerminkan perubahan dalam praktik kami atau karena alasan operasional, hukum, atau regulasi.</p>
                        <p>Perubahan signifikan akan kami informasikan melalui:</p>
                        <ul>
                            <li>Email ke alamat terdaftar Anda</li>
                            <li>Notifikasi di website</li>
                            <li>Pengumuman di halaman utama</li>
                        </ul>
                        <p>Kami sarankan Anda meninjau kebijakan ini secara berkala.</p>
                    </div>

                    <!-- Hubungi Kami -->
                    <div class="content-block" id="kontak-privacy">
                        <h2>9. Hubungi Kami</h2>
                        <p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini atau ingin menggunakan hak Anda, silakan hubungi kami:</p>
                        
                        <div class="contact-cards">
                            <div class="contact-card">
                                <i class="fas fa-envelope"></i>
                                <h4>Email</h4>
                                <p>purwokerto@karyasatria.com</p>
                            </div>
                            <div class="contact-card">
                                <i class="fas fa-phone"></i>
                                <h4>Telepon</h4>
                                <p>(0281) 6572506</p>
                            </div>
                            <div class="contact-card">
                                <i class="fas fa-map-marker-alt"></i>
                                <h4>Alamat</h4>
                                <p>Jl. Raya Prompong RT 04/04, Baturaden, Banyumas</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="cta-box">
                        <h3>Butuh Bantuan Lebih Lanjut?</h3>
                        <p>Tim kami siap membantu menjawab pertanyaan Anda</p>
                        <a href="kontak.html" class="btn-primary">
                            <i class="fas fa-comment-dots"></i>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
<script src="{{ asset('js/privasi.js') }}"></script>
@endpush