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
        <div class="orders-container">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-number">Order #{{ $order->order_id }}</div>
                            <div class="order-date">
                                <i class="far fa-calendar"></i>
                                {{ $order->order_date->format('d M Y') }}
                            </div>
                        </div>
                        <div class="status-badge">
                            @if($order->status === 'pending')
                                <i class="fas fa-clock"></i>
                            @elseif($order->status === 'paid')
                                <i class="fas fa-credit-card"></i>
                            @elseif($order->status === 'processing')
                                <i class="fas fa-cog fa-spin"></i>
                            @elseif($order->status === 'completed')
                                <i class="fas fa-check-circle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                            {{ ucfirst($order->status) }}
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->orderItems as $item)
                            <div class="order-item">
                                <img src="{{ asset('storage/' . $item->product->image_url) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="item-image">
                                <div class="item-info">
                                    <div class="item-name">{{ $item->product->name }}</div>
                                    <div class="item-details">
                                        <span class="item-quantity">{{ $item->quantity }}x</span>
                                        <span class="item-price">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-footer">
                        <div class="order-total-section">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="order-action">
                            @if($order->payment && $order->payment->status === 'pending')
                                <button class="btn-primary btn-pay" data-snap-token="{{ $order->payment->snap_token }}" data-order-id="{{ $order->order_id }}">
                                    <i class="fas fa-credit-card"></i>
                                    Bayar Sekarang
                                </button>
                            @endif
                            <a href="{{ route('history.detail', $order->order_id) }}" class="btn-outline">
                                <i class="fas fa-eye"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="pagination-wrapper">
                {{ $orders->links() }}
            </div>
        @endif

        <!-- Empty State -->
        <div class="empty-state" id="emptyState" style="display: {{ $orders->count() > 0 ? 'none' : 'block' }};">
            <div class="empty-content">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Pesanan</h3>
                <p>Mulai berbelanja dan pesanan Anda akan muncul di sini</p>
                <a href="{{ route('produk') }}" class="btn-primary">
                    <i class="fas fa-shopping-cart"></i>
                    Mulai Belanja
                </a>
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
    </div>
</main>

<div id="loadingModal" class="loading-modal" style="display:none;">
  <div class="loading-content">
    <div class="loading-spinner"></div>
    <p>Memproses pembayaran...</p>
  </div>
</div>

@endsection

@push('scripts')
<!-- Midtrans Snap Script -->
<script type="text/javascript"
    src="https://app{{ config('midtrans.is_production') ? '' : '.sandbox' }}.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingModal = document.getElementById('loadingModal');
    
    // Handle payment button clicks
    document.querySelectorAll('.btn-pay').forEach(button => {
        button.addEventListener('click', function() {
            const snapToken = this.getAttribute('data-snap-token');
            const orderId = this.getAttribute('data-order-id');
            
            // Show loading
            loadingModal.style.display = 'flex';
            
            // Trigger Midtrans Snap
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('Success:', result);
                    loadingModal.style.display = 'none';
                    window.location.href = "{{ route('order.success') }}?order_id=" + orderId;
                },
                onPending: function(result) {
                    console.log('Pending:', result);
                    loadingModal.style.display = 'none';
                    window.location.href = "{{ route('order.pending') }}?order_id=" + orderId;
                },
                onError: function(result) {
                    console.log('Error:', result);
                    loadingModal.style.display = 'none';
                    window.location.href = "{{ route('order.error') }}?order_id=" + orderId;
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    loadingModal.style.display = 'none';
                    // Redirect ke halaman pending jika user menutup popup
                    window.location.href = "{{ route('order.pending') }}?order_id=" + orderId;
                }
            });
        });
    });
});
</script>

<style>
.loading-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-content {
    background: white;
    padding: 40px;
    border-radius: 10px;
    text-align: center;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-content p {
    font-size: 16px;
    color: #333;
    font-weight: 600;
}
</style>

<script src="{{ asset('js/history.js') }}"></script>
@endpush