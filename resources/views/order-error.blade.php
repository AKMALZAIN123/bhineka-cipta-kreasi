<div id="errorModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-icon error">
            <i class="fas fa-times-circle"></i>
        </div>
        <h3>Pembayaran Gagal</h3>
        <p id="errorMessage">Terjadi kesalahan saat memproses pembayaran</p>
        <div class="modal-buttons">
            <button onclick="closeErrorModal()" class="btn-secondary">Tutup</button>
            <button onclick="retryPayment()" class="btn-primary">Coba Lagi</button>
        </div>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

.modal-content {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    text-align: center;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-icon {
    margin-bottom: 1.5rem;
}

.modal-icon.error i {
    font-size: 5rem;
    color: #ef4444;
}

.modal-content h3 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    color: #1f2937;
}

.modal-content p {
    color: #6b7280;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.modal-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.modal-buttons button {
    padding: 0.9rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    font-size: 1rem;
}

.modal-buttons .btn-secondary {
    background: white;
    color: #2563eb;
    border: 2px solid #2563eb;
}

.modal-buttons .btn-secondary:hover {
    background: #2563eb;
    color: white;
}

.modal-buttons .btn-primary {
    background: #f59e0b;
    color: white;
}

.modal-buttons .btn-primary:hover {
    background: #d97706;
}
</style>

<script>
function closeErrorModal() {
    document.getElementById('errorModal').style.display = 'none';
}

function retryPayment() {
    closeErrorModal();
    // Trigger checkout lagi
    document.getElementById('btnSubmit').click();
}
</script>