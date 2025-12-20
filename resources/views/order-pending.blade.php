@extends('layouts.app')

@section('title', 'Menunggu Pembayaran')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order-status.css') }}">
@endsection

@section('content')
<section class="order-status-section">
    <div class="container">
        <div class="status-card pending">
            <!-- Pending Icon -->
            <div class="status-icon-wrapper">
                <div class="status-icon pending-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <!-- Status Message -->
            <h1>Menunggu Pembayaran</h1>
            <p class="status-subtitle">Silakan selesaikan pembayaran Anda sebelum batas waktu berakhir</p>

            <!-- Countdown Timer -->
            <div class="countdown-timer">
                <div class="timer-label">Batas Waktu Pembayaran</div>
                <div class="timer-display" id="countdown">
                    <div class="timer-box">
                        <span id="hours">23</span>
                        <span class="timer-label-small">Jam</span>
                    </div>
                    <span class="timer-separator">:</span>
                    <div class="timer-box">
                        <span id="minutes">59</span>
                        <span class="timer-label-small">Menit</span>
                    </div>
                    <span class="timer-separator">:</span>
                    <div class="timer-box">
                        <span id="seconds">59</span>
                        <span class="timer-label-small">Detik</span>
                    </div>
                </div>
            </div>

            <!-- Order Info Card -->
            <div class="order-info-card">
                <div class="order-header">
                    <h3>Detail Pesanan</h3>
                </div>

                <div class="order-detail-row">
                    <span class="label">Nomor Pesanan</span>
                    <span class="value order-number">{{ $order->order_number ?? 'BCK-' . time() }}</span>
                </div>

                <div class="order-detail-row">
                    <span class="label">Total Pembayaran</span>
                    <span class="value price">{{ formatRupiah($order->total_amount ?? 0) }}</span>
                </div>

                <div class="order-detail-row">
                    <span class="label">Metode Pembayaran</span>
                    <span class="value">{{ strtoupper($order->payment_method ?? 'Transfer Bank') }}</span>
                </div>

                <div class="order-detail-row">
                    <span class="label">Status Pembayaran</span>
                    <span class="badge-pending" id="badgeStatus">
                        <i class="fas fa-clock"></i>
                        Menunggu Pembayaran
                    </span>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if(isset($order->payment_method))
                <div class="payment-instruction">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Instruksi Pembayaran
                    </h3>

                    @if(in_array($order->payment_method, ['bca', 'bni', 'bri', 'mandiri']))
                        <div class="instruction-card">
                            <div class="instruction-header">
                                <i class="fas fa-university"></i>
                                <span>Transfer ke Virtual Account</span>
                            </div>
                            <div class="instruction-body">
                                <div class="va-info">
                                    <span class="va-label">Bank</span>
                                    <span class="va-value">{{ strtoupper($order->payment_method) }}</span>
                                </div>
                                <div class="va-info">
                                    <span class="va-label">Nomor Virtual Account</span>
                                    <div class="va-number">
                                        <span class="va-value" id="vaNumber">{{ $order->va_number ?? '8012345678901234' }}</span>
                                        <button type="button" class="copy-btn" id="btnCopyVA">
                                            <i class="fas fa-copy"></i>
                                            Salin
                                        </button>
                                    </div>
                                </div>
                                <div class="va-info">
                                    <span class="va-label">Total Transfer</span>
                                    <span class="va-value price">{{ formatRupiah($order->total_amount ?? 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="steps-payment">
                            <h4>Cara Pembayaran:</h4>
                            <ol>
                                <li>Buka aplikasi mobile banking atau ATM</li>
                                <li>Pilih menu Transfer / Virtual Account</li>
                                <li>Masukkan nomor Virtual Account di atas</li>
                                <li>Masukkan nominal sesuai total pembayaran</li>
                                <li>Konfirmasi dan selesaikan pembayaran</li>
                            </ol>
                        </div>

                    @elseif(in_array($order->payment_method, ['gopay', 'dana', 'ovo']))
                        <div class="instruction-card">
                            <div class="instruction-header">
                                <i class="fas fa-wallet"></i>
                                <span>Bayar dengan {{ strtoupper($order->payment_method) }}</span>
                            </div>
                            <div class="instruction-body">
                                <p>Scan QR Code di bawah ini menggunakan aplikasi {{ strtoupper($order->payment_method) }}</p>

                                @if(isset($order->qr_code_url))
                                    <div class="qr-code">
                                        <img src="{{ $order->qr_code_url }}" alt="QR Code">
                                    </div>
                                @else
                                    <div class="qr-placeholder">
                                        <i class="fas fa-qrcode"></i>
                                        <p>QR Code akan muncul setelah pesanan diproses</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    @elseif($order->payment_method == 'qris')
                        <div class="instruction-card">
                            <div class="instruction-header">
                                <i class="fas fa-qrcode"></i>
                                <span>Bayar dengan QRIS</span>
                            </div>
                            <div class="instruction-body">
                                <p>Scan QR Code menggunakan aplikasi mobile banking atau e-wallet Anda</p>

                                @if(isset($order->qr_code_url))
                                    <div class="qr-code">
                                        <img src="{{ $order->qr_code_url }}" alt="QRIS">
                                    </div>
                                @else
                                    <div class="qr-placeholder">
                                        <i class="fas fa-qrcode"></i>
                                        <p>QR Code akan muncul setelah pesanan diproses</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="#" class="btn-primary" id="btnCheckStatus">
                    <i class="fas fa-sync"></i>
                    Cek Status Pembayaran
                </a>
                <a href="{{ route('home') }}" class="btn-secondary">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Warning -->
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Pastikan Anda membayar sesuai dengan nominal yang tertera. Pembayaran dengan nominal berbeda tidak akan diproses.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
  // ====== CONFIG ======
  const orderId  = "{{ $order->order_id }}";
  const checkUrl = "{{ route('order.check-status', $order->order_id) }}";
  const successUrl = "{{ route('order.success') }}?order_id=" + orderId;
  const errorUrl   = "{{ route('order.error') }}?order_id=" + orderId;

  console.log('ORDER PENDING SCRIPT LOADED', { orderId, checkUrl });

  // ====== COUNTDOWN ======
  // kalau kamu punya expiry_time dari midtrans, lebih bagus kirim dari backend.
  let expiryTime = Date.now() + (24 * 60 * 60 * 1000);

  function updateCountdown() {
    const distance = expiryTime - Date.now();
    const countdownEl = document.getElementById('countdown');

    if (!countdownEl) return;

    if (distance <= 0) {
      countdownEl.innerHTML = '<span style="color:#ef4444;font-weight:bold">Waktu Habis</span>';
      return;
    }

    const hours   = Math.floor((distance / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((distance / (1000 * 60)) % 60);
    const seconds = Math.floor((distance / 1000) % 60);

    const hEl = document.getElementById('hours');
    const mEl = document.getElementById('minutes');
    const sEl = document.getElementById('seconds');

    if (hEl) hEl.textContent = String(hours).padStart(2, '0');
    if (mEl) mEl.textContent = String(minutes).padStart(2, '0');
    if (sEl) sEl.textContent = String(seconds).padStart(2, '0');
  }

  setInterval(updateCountdown, 1000);
  updateCountdown();

  // ====== COPY VA ======
  const btnCopy = document.getElementById('btnCopyVA');
  if (btnCopy) {
    btnCopy.addEventListener('click', () => {
      const vaEl = document.getElementById('vaNumber');
      if (!vaEl) return;

      const va = vaEl.textContent.trim();
      navigator.clipboard.writeText(va).then(() => {
        const original = btnCopy.innerHTML;
        btnCopy.innerHTML = '<i class="fas fa-check"></i> Tersalin';
        btnCopy.style.background = '#10b981';

        setTimeout(() => {
          btnCopy.innerHTML = original;
          btnCopy.style.background = '';
        }, 2000);
      });
    });
  }

  // ====== CORE: CHECK STATUS & REDIRECT ======
  async function checkAndRedirect() {
    try {
      const res = await fetch(checkUrl, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin',
        cache: 'no-store'
      });

      // kalau kena redirect/login, res.ok mungkin true tapi content html → json error
      const contentType = res.headers.get('content-type') || '';
      if (!contentType.includes('application/json')) {
        console.warn('check-status not JSON, maybe redirected?', { status: res.status, contentType });
        return;
      }

      const data = await res.json();
      console.log('Polling result:', data);

      const st = data.status; // pending / paid / cancelled / failed

      if (st === 'paid') {
        window.location.replace(successUrl);
        return;
      }

      if (['cancelled', 'failed'].includes(st)) {
        window.location.replace(errorUrl);
        return;
      }

      // kalau masih pending, do nothing
    } catch (err) {
      console.error('Polling error:', err);
    }
  }

  // ====== AUTO POLLING every 5s ======
  const polling = setInterval(checkAndRedirect, 5000);
  // langsung cek sekali saat halaman dibuka (biar tidak nunggu 5 detik)
  checkAndRedirect();

  // ====== BUTTON "CEK STATUS" ======
  const btnCheck = document.getElementById('btnCheckStatus');
  if (btnCheck) {
    btnCheck.addEventListener('click', async (e) => {
      e.preventDefault();

      // UX: ubah teks jadi loading sebentar
      const original = btnCheck.innerHTML;
      btnCheck.innerHTML = '<i class="fas fa-sync fa-spin"></i> Mengecek...';

      await checkAndRedirect();

      // kalau belum redirect (masih pending), balikin lagi
      setTimeout(() => {
        btnCheck.innerHTML = original;
      }, 500);
    });
  }
})();
</script>
@endpush