// ===== INIT =====
document.addEventListener('DOMContentLoaded', function() {
    loadOrderData();
    updateProgressTracker();
});

// ===== FORMAT CURRENCY =====
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

// ===== LOAD ORDER DATA =====
function loadOrderData() {
    // Header
    document.getElementById('orderNumber').textContent = orderData.orderNumber;
    document.getElementById('orderDate').textContent = orderData.date;
    document.getElementById('orderTotal').textContent = formatCurrency(orderData.payment.total);

    // Items
    renderOrderItems();

    // Shipping Info
    document.getElementById('recipientName').textContent = orderData.shipping.recipient;
    document.getElementById('recipientPhone').textContent = orderData.shipping.phone;
    document.getElementById('recipientAddress').textContent = orderData.shipping.address;

    // Payment Summary
    document.getElementById('subtotal').textContent = formatCurrency(orderData.payment.subtotal);
    document.getElementById('shippingCost').textContent = orderData.payment.shippingCost === 0 ? 'Gratis' : formatCurrency(orderData.payment.shippingCost);
    document.getElementById('totalAmount').textContent = formatCurrency(orderData.payment.total);
}

// ===== UPDATE PROGRESS TRACKER =====
function updateProgressTracker() {
    const status = orderData.status;
    const timeline = orderData.timeline;

    // Reset all steps
    const allSteps = document.querySelectorAll('.progress-step');
    allSteps.forEach(step => {
        step.classList.remove('completed', 'active');
    });
}

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Page load animation
window.addEventListener('load', () => {
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s';
        document.body.style.opacity = '1';
    }, 100);
});