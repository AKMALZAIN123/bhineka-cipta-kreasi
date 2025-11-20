// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navLinks = document.getElementById('navLinks');

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Cart Variables
let cart = [];
const SHIPPING_COST = 15000;

// DOM Elements
const cartItemsContainer = document.getElementById('cartItemsContainer');
const emptyCart = document.getElementById('emptyCart');
const orderSummary = document.getElementById('orderSummary');
const cartCount = document.getElementById('cartCount');
const cartBadge = document.getElementById('cartBadge');
const summaryItemCount = document.getElementById('summaryItemCount');
const summarySubtotal = document.getElementById('summarySubtotal');
const summaryShipping = document.getElementById('summaryShipping');
const summaryTotal = document.getElementById('summaryTotal');
const btnCheckout = document.getElementById('btnCheckout');

// Modal
const deleteModal = document.getElementById('deleteModal');
const btnCancelDelete = document.getElementById('btnCancelDelete');
const btnConfirmDelete = document.getElementById('btnConfirmDelete');
let itemToDelete = null;

// Load cart from localStorage
function loadCart() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
    renderCart();
}

// Save cart to localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Format price
function formatPrice(price) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
}

// Calculate totals
function calculateTotals() {
    const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    const shipping = cart.length > 0 ? SHIPPING_COST : 0;
    const total = subtotal + shipping;
    
    return { subtotal, shipping, total };
}

// Update summary
function updateSummary() {
    const { subtotal, shipping, total } = calculateTotals();
    const itemCount = cart.reduce((count, item) => count + item.quantity, 0);
    
    summaryItemCount.textContent = `(${itemCount} produk)`;
    summarySubtotal.textContent = formatPrice(subtotal);
    summaryShipping.textContent = formatPrice(shipping);
    summaryTotal.textContent = formatPrice(total);
}

// Update cart count
function updateCartCount() {
    const itemCount = cart.reduce((count, item) => count + item.quantity, 0);
    cartCount.textContent = `${itemCount} produk`;
    cartBadge.textContent = itemCount;
}

// Render cart
function renderCart() {
    cartItemsContainer.innerHTML = '';
    const cartLayout = document.querySelector('.cart-layout');
    
    if (cart.length === 0) {
        // Show empty state
        emptyCart.style.display = 'flex';
        orderSummary.style.display = 'none';
        cartLayout.classList.add('empty-layout');
        updateCartCount();
        return;
    }
    
    // Hide empty state
    emptyCart.style.display = 'none';
    orderSummary.style.display = 'block';
    cartLayout.classList.remove('empty-layout');
    
    // Render each item
    cart.forEach((item, index) => {
        const cartItem = createCartItemElement(item, index);
        cartItemsContainer.appendChild(cartItem);
    });
    
    updateCartCount();
    updateSummary();
}

// Create cart item element
function createCartItemElement(item, index) {
    const div = document.createElement('div');
    div.className = 'cart-item';
    
    // Format variant info
    const variantText = item.variants 
        ? `${item.variants.size || ''}, ${item.variants.material || ''}`
        : 'Standard';
    
    div.innerHTML = `
        <div class="item-image">
            <img src="${item.image}" alt="${item.name}">
        </div>
        <div class="item-details">
            <div class="item-header">
                <div class="item-info">
                    <h3 data-index="${index}">${item.name}</h3>
                    <div class="item-variant">${variantText}</div>
                </div>
                <button class="item-delete" data-index="${index}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="item-price">${formatPrice(item.price)}</div>
            <div class="item-footer">
                <div class="quantity-selector">
                    <button class="qty-btn qty-minus" data-index="${index}">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" class="qty-input" value="${item.quantity}" min="1" max="${item.stock || 100}" data-index="${index}">
                    <button class="qty-btn qty-plus" data-index="${index}">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="item-subtotal">
                    <span class="item-subtotal-label">Subtotal</span>
                    <span class="item-subtotal-value">${formatPrice(item.price * item.quantity)}</span>
                </div>
            </div>
        </div>
    `;
    
    // Add event listeners
    const deleteBtn = div.querySelector('.item-delete');
    const minusBtn = div.querySelector('.qty-minus');
    const plusBtn = div.querySelector('.qty-plus');
    const qtyInput = div.querySelector('.qty-input');
    const itemTitle = div.querySelector('h3');
    const itemImage = div.querySelector('.item-image img');
    
    deleteBtn.addEventListener('click', () => showDeleteModal(index));
    minusBtn.addEventListener('click', () => decreaseQuantity(index));
    plusBtn.addEventListener('click', () => increaseQuantity(index));
    qtyInput.addEventListener('change', (e) => updateQuantity(index, parseInt(e.target.value)));
    itemTitle.addEventListener('click', () => goToProductDetail(item.id));
    itemImage.addEventListener('click', () => goToProductDetail(item.id));
    
    return div;
}

// Increase quantity
function increaseQuantity(index) {
    const item = cart[index];
    const maxStock = item.stock || 100;
    
    if (item.quantity < maxStock) {
        item.quantity++;
        saveCart();
        renderCart();
        showNotification('Jumlah produk diperbarui');
    } else {
        showNotification('Stok tidak mencukupi', 'error');
    }
}

// Decrease quantity
function decreaseQuantity(index) {
    const item = cart[index];
    
    if (item.quantity > 1) {
        item.quantity--;
        saveCart();
        renderCart();
        showNotification('Jumlah produk diperbarui');
    }
}

// Update quantity
function updateQuantity(index, newQuantity) {
    const item = cart[index];
    const maxStock = item.stock || 100;
    
    if (newQuantity < 1) {
        newQuantity = 1;
    } else if (newQuantity > maxStock) {
        newQuantity = maxStock;
        showNotification('Jumlah melebihi stok tersedia', 'error');
    }
    
    item.quantity = newQuantity;
    saveCart();
    renderCart();
}

// Show delete modal
function showDeleteModal(index) {
    itemToDelete = index;
    deleteModal.classList.add('active');
}

// Hide delete modal
function hideDeleteModal() {
    deleteModal.classList.remove('active');
    itemToDelete = null;
}

// Delete item
function deleteItem() {
    if (itemToDelete !== null) {
        const deletedItem = cart[itemToDelete];
        cart.splice(itemToDelete, 1);
        saveCart();
        renderCart();
        hideDeleteModal();
        showNotification(`${deletedItem.name} dihapus dari keranjang`, 'success');
    }
}

// Go to product detail
function goToProductDetail(productId) {
    window.location.href = `product-detail.html?id=${productId}`;
}

// Checkout
btnCheckout.addEventListener('click', () => {
    if (cart.length === 0) {
        showNotification('Keranjang masih kosong', 'error');
        return;
    }
    
    const { total } = calculateTotals();
    const minOrder = 50000;
    
    if (total < minOrder) {
        showNotification(`Minimum pemesanan ${formatPrice(minOrder)}`, 'error');
        return;
    }
    
    // Save summary to localStorage for checkout page
    const orderData = {
        items: cart,
        subtotal: calculateTotals().subtotal,
        shipping: SHIPPING_COST,
        total: calculateTotals().total
    };
    
    localStorage.setItem('checkoutData', JSON.stringify(orderData));
    
    // Redirect to checkout
    window.location.href = 'checkout.html';
});

// Modal events
btnCancelDelete.addEventListener('click', hideDeleteModal);
btnConfirmDelete.addEventListener('click', deleteItem);

// Close modal when clicking outside
deleteModal.addEventListener('click', (e) => {
    if (e.target === deleteModal) {
        hideDeleteModal();
    }
});

// Notification Function
function showNotification(message, type = 'info') {
    const existingNotif = document.querySelector('.notification');
    if (existingNotif) {
        existingNotif.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    let icon = 'fa-info-circle';
    let bgColor = '#2563eb';
    
    if (type === 'success') {
        icon = 'fa-check-circle';
        bgColor = '#10b981';
    } else if (type === 'error') {
        icon = 'fa-exclamation-circle';
        bgColor = '#ef4444';
    }
    
    notification.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;
    
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
        border-left: 4px solid ${bgColor};
    `;
    
    const notifIcon = notification.querySelector('i');
    notifIcon.style.color = bgColor;
    notifIcon.style.fontSize = '1.5rem';
    
    const notifText = notification.querySelector('span');
    notifText.style.color = '#1f2937';
    notifText.style.fontWeight = '500';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Initialize on page load
window.addEventListener('load', () => {
    loadCart();
    console.log('Cart page loaded');
});