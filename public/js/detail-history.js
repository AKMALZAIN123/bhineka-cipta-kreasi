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

    // Update based on current status
    if (status === 'packaging') {
        document.getElementById('step-packaging').classList.add('active');
        document.getElementById('packaging-date').textContent = timeline.packaging || 'Sedang diproses';
    } 
    else if (status === 'onroad') {
        document.getElementById('step-packaging').classList.add('completed');
        document.getElementById('step-onroad').classList.add('active');
        document.getElementById('packaging-date').textContent = timeline.packaging;
        document.getElementById('onroad-date').textContent = timeline.onroad || 'Sedang dalam pengiriman';
    } 
    else if (status === 'delivered') {
        document.getElementById('step-packaging').classList.add('completed');
        document.getElementById('step-onroad').classList.add('completed');
        document.getElementById('step-delivered').classList.add('completed');
        document.getElementById('packaging-date').textContent = timeline.packaging;
        document.getElementById('onroad-date').textContent = timeline.onroad;
        document.getElementById('delivered-date').textContent = timeline.delivered;
    }
}

// ===== HELP BUTTON =====
document.querySelector('.help-button')?.addEventListener('click', function() {
    alert('Hubungi Customer Service:\n\nWhatsApp: 0812-3456-7890\nEmail: support@bhinekacipta.com\nTelepon: (0281) 6572506');
});

// ===== FETCH FROM API (Optional) =====
async function fetchOrderDetail(orderNumber) {
    try {
        // const response = await fetch(`/api/orders/${orderNumber}`, {
        //     headers: {
        //         'Authorization': 'Bearer ' + localStorage.getItem('token')
        //     }
        // });
        // const data = await response.json();
        // return data;
        
        return orderData;
    } catch (error) {
        console.error('Error fetching order detail:', error);
        return null;
    }
}

// ===== GET ORDER NUMBER FROM URL (Optional) =====
function getOrderNumberFromURL() {
    const params = new URLSearchParams(window.location.search);
    return params.get('order') || 'ORD-2024-001234';
}