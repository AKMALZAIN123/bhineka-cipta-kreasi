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

// ===== FETCH FROM API (Optional) =====
async function fetchOrdersFromAPI() {
    try {
        // Fetch only paid orders
        // const response = await fetch('/api/orders?status=paid', {
        //     headers: {
        //         'Authorization': 'Bearer ' + localStorage.getItem('token')
        //     }
        // });
        // const data = await response.json();
        // return data.orders;
        
        return orders;
    } catch (error) {
        console.error('Error fetching orders:', error);
        return [];
    }
}