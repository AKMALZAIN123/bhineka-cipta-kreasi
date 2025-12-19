    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    @endsection

    @section('content')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Pesanan Saya</h1>
                <p>Pantau progres pesanan Anda</p>
            </div>

            <!-- Orders List -->
            <div class="orders-list">
                
                <!-- Order 1 -->
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <div class="order-id">ORD-2024-001234</div>
                            <div class="order-date">15 Desember 2024</div>
                        </div>
                        <div class="order-status">Pengerjaan 2-3 Hari</div>
                    </div>
                    
                    <div class="order-items">
                        <div class="order-item">
                            <img src="https://images.unsplash.com/photo-1611329857570-f02f340e7378?w=150&h=150&fit=crop" alt="Banner X Premium" class="item-img">
                            <div class="item-details">
                                <div class="item-name">Banner X Premium</div>
                                <div class="item-spec">Ukuran 160x60cm</div>
                            </div>
                            <div class="item-price">
                                <div class="item-qty">2x</div>
                                <div class="item-total">Rp 250.000</div>
                            </div>
                        </div>
                        
                        <div class="order-item">
                            <img src="https://images.unsplash.com/photo-1530435460869-d13625c69bbf?w=150&h=150&fit=crop" alt="Kartu Undangan" class="item-img">
                            <div class="item-details">
                                <div class="item-name">Kartu Undangan Custom</div>
                                <div class="item-spec">100 pcs, Hardcover</div>
                            </div>
                            <div class="item-price">
                                <div class="item-qty">1x</div>
                                <div class="item-total">Rp 350.000</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-amount">Rp 600.000</span>
                        </div>
                        <a href="{{ route('detail-history') }}" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>

                <!-- Order 2 -->
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <div class="order-id">ORD-2024-001232</div>
                            <div class="order-date">10 Desember 2024</div>
                        </div>
                        <div class="order-status">Pengerjaan 1-2 Hari</div>
                    </div>
                    
                    <div class="order-items">
                        <div class="order-item">
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=150&h=150&fit=crop" alt="Roll Up Banner" class="item-img">
                            <div class="item-details">
                                <div class="item-name">Roll Up Banner</div>
                                <div class="item-spec">85x200cm, Portable</div>
                            </div>
                            <div class="item-price">
                                <div class="item-qty">3x</div>
                                <div class="item-total">Rp 675.000</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-amount">Rp 675.000</span>
                        </div>
                        <a href="{{ route('detail-history') }}" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>

                <!-- Order 3 -->
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <div class="order-id">ORD-2024-001230</div>
                            <div class="order-date">5 Desember 2024</div>
                        </div>
                        <div class="order-status">Pengerjaan 3-4 Hari</div>
                    </div>
                    
                    <div class="order-items">
                        <div class="order-item">
                            <img src="https://images.unsplash.com/photo-1588282322673-c31965a75c3e?w=150&h=150&fit=crop" alt="Booth Promosi" class="item-img">
                            <div class="item-details">
                                <div class="item-name">Booth Promosi 3x3m</div>
                                <div class="item-spec">Tenda dengan custom print</div>
                            </div>
                            <div class="item-price">
                                <div class="item-qty">1x</div>
                                <div class="item-total">Rp 2.500.000</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-amount">Rp 2.500.000</span>
                        </div>
                        <a href="{{ route('detail-history') }}" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>

                <!-- Order 4 -->
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <div class="order-id">ORD-2024-001228</div>
                            <div class="order-date">1 Desember 2024</div>
                        </div>
                        <div class="order-status">Pengerjaan 2-3 Hari</div>
                    </div>
                    
                    <div class="order-items">
                        <div class="order-item">
                            <img src="https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=150&h=150&fit=crop" alt="Lanyard Custom" class="item-img">
                            <div class="item-details">
                                <div class="item-name">Lanyard Custom Logo</div>
                                <div class="item-spec">Print sublim, 50 pcs</div>
                            </div>
                            <div class="item-price">
                                <div class="item-qty">50x</div>
                                <div class="item-total">Rp 750.000</div>
                            </div>
                        </div>
                        
                        <div class="order-item">
                            <img src="https://images.unsplash.com/photo-1534452203293-494d7ddbf7e0?w=150&h=150&fit=crop" alt="Tumbler Custom" class="item-img">
                            <div class="item-details">
                                <div class="item-name">Tumbler Stainless Custom</div>
                                <div class="item-spec">500ml dengan logo</div>
                            </div>
                            <div class="item-price">
                                <div class="item-qty">20x</div>
                                <div class="item-total">Rp 1.500.000</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-amount">Rp 2.250.000</span>
                        </div>
                        <a href="{{ route('detail-history') }}" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>

            </div>

            <!-- Empty State (Uncomment jika tidak ada pesanan) -->
            <!-- 
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <h3>Belum Ada Pesanan</h3>
                <p>Pesanan yang Anda buat akan muncul di sini</p>
                <a href="{{ route('produk') }}" class="btn-primary">Mulai Belanja</a>
            </div>
            -->

        </div>
    </main>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/history.js') }}"></script>
    @endpush