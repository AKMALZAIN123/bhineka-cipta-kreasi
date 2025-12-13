    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    @endsection

    @section('content')

<!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="header-text">
                    <h1>Riwayat Pesanan</h1>
                    <p>Kelola dan pantau semua pesanan Anda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Summary Cards -->
            <div class="summary-cards" id="summaryCards">
                <div class="summary-card">
                    <div class="summary-icon" style="background: #dbeafe;">
                        <i class="fas fa-clock" style="color: #2563eb;"></i>
                    </div>
                    <div class="summary-info">
                        <h3 id="pendingCount">0</h3>
                        <p>Menunggu Pembayaran</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon" style="background: #fef3c7;">
                        <i class="fas fa-cog" style="color: #f59e0b;"></i>
                    </div>
                    <div class="summary-info">
                        <h3 id="processCount">0</h3>
                        <p>Sedang Diproses</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon" style="background: #d1fae5;">
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                    </div>
                    <div class="summary-info">
                        <h3 id="completedCount">0</h3>
                        <p>Pesanan Selesai</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon" style="background: #e5e7eb;">
                        <i class="fas fa-box" style="color: #6b7280;"></i>
                    </div>
                    <div class="summary-info">
                        <h3 id="totalCount">0</h3>
                        <p>Total Pesanan</p>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="orders-section">
                <div class="section-header">
                    <h2>Daftar Pesanan</h2>
                </div>

                <!-- Order List -->
                <div id="ordersList" class="orders-list">
                    <!-- Orders will be rendered here -->
                </div>

                <!-- Empty State -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>Belum Ada Pesanan</h3>
                    <p>Anda belum memiliki riwayat pesanan</p>
                    <a href="products.html" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        Mulai Belanja
                    </a>
                </div>
            </div>
        </div>
    </main>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/history.js') }}"></script>
    @endpush