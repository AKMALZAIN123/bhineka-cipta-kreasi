// ===== INIT =====
document.addEventListener('DOMContentLoaded', function() {
    renderOrders();
});

// ===== FORMAT CURRENCY =====
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

// ===== VIEW ORDER DETAIL =====
function viewOrderDetail(orderNumber) {
    window.location.href = '/detail-history';
    // window.location.href = '/order/detail/' + orderNumber;
}

// Page load animation
window.addEventListener('load', () => {
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s';
        document.body.style.opacity = '1';
    }, 100);
});