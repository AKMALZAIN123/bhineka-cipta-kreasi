    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    @endsection

    @section('content')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Riwayat Pesanan</h1>
                <p>Pantau status pesanan Anda yang sedang dikerjakan</p>
            </div>

            <!-- Orders List -->
            <div id="ordersList" class="orders-container">
                <!-- Orders will be rendered here -->
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-content">
                    <i class="fas fa-box-open"></i>
                    <h3>Belum Ada Pesanan</h3>
                    <p>Mulai berbelanja dan pesanan Anda akan muncul di sini</p>
                    <a href="products.html" class="btn-primary">
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