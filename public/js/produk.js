// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navLinks = document.getElementById('navLinks');

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Search Bar Toggle
const searchToggle = document.querySelector('.search-toggle');
const searchBarWrapper = document.getElementById('searchBarWrapper');
const searchClose = document.getElementById('searchClose');
const searchInput = document.getElementById('searchInput');

searchToggle.addEventListener('click', () => {
    searchBarWrapper.classList.add('active');
    searchInput.focus();
});

searchClose.addEventListener('click', () => {
    searchBarWrapper.classList.remove('active');
    searchInput.value = '';
});

// Search functionality
searchInput.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    // TODO: Implement actual search filter
    console.log('Searching for:', searchTerm);
});

// Filter Sidebar Toggle (Mobile)
const btnFilterMobile = document.getElementById('btnFilterMobile');
const filterSidebar = document.getElementById('filterSidebar');
const filterClose = document.getElementById('filterClose');

btnFilterMobile.addEventListener('click', () => {
    filterSidebar.classList.add('active');
});

filterClose.addEventListener('click', () => {
    filterSidebar.classList.remove('active');
});

// Close filter when clicking outside
document.addEventListener('click', (e) => {
    if (filterSidebar.classList.contains('active') && 
        !filterSidebar.contains(e.target) && 
        !btnFilterMobile.contains(e.target)) {
        filterSidebar.classList.remove('active');
    }
});

// View Toggle (Grid/List)
const viewBtns = document.querySelectorAll('.view-btn');
const productsGrid = document.getElementById('productsGrid');

viewBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        viewBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        const view = btn.getAttribute('data-view');
        if (view === 'list') {
            productsGrid.style.gridTemplateColumns = '1fr';
        } else {
            productsGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(260px, 1fr))';
        }
    });
});

// Sort Select
const sortSelect = document.getElementById('sortSelect');
sortSelect.addEventListener('change', (e) => {
    const sortValue = e.target.value;
    // TODO: Implement actual sorting
    console.log('Sorting by:', sortValue);
    showNotification(`Produk diurutkan berdasarkan: ${e.target.options[e.target.selectedIndex].text}`);
});

// Wishlist Toggle
const wishlistBtns = document.querySelectorAll('.wishlist-btn');
wishlistBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        btn.classList.toggle('active');
        const icon = btn.querySelector('i');
        if (btn.classList.contains('active')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            showNotification('Ditambahkan ke wishlist', 'success');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            showNotification('Dihapus dari wishlist');
        }
    });
});

// Add to Cart
const addToCartBtns = document.querySelectorAll('.btn-add-cart');
const cartBadge = document.querySelector('.cart-badge');
let cartCount = parseInt(cartBadge.textContent) || 0;

addToCartBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        cartCount++;
        cartBadge.textContent = cartCount;
        
        // Visual feedback
        btn.style.transform = 'scale(0.9)';
        setTimeout(() => {
            btn.style.transform = 'scale(1.1)';
        }, 100);
        setTimeout(() => {
            btn.style.transform = 'scale(1)';
        }, 200);
        
        showNotification('Produk ditambahkan ke keranjang!', 'success');
    });
});

// Quick View
const quickViewBtns = document.querySelectorAll('.btn-quick-view');
quickViewBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        
        // Get product ID from parent card
        const productCard = btn.closest('.product-card');
        const productId = productCard.getAttribute('data-product-id');
        
        // Navigate to product detail
        window.location.href = `detail.html?id=${productId}`;
    });
});

// Product Card Click (Navigate to detail)
const productCards = document.querySelectorAll('.product-card');
productCards.forEach(card => {
    card.addEventListener('click', (e) => {
        // Jangan redirect jika klik button wishlist atau add to cart
        if (e.target.closest('.wishlist-btn') || 
            e.target.closest('.btn-add-cart') ||
            e.target.closest('.btn-quick-view')) {
            return;
        }
        
        // Get product ID from data attribute
        const productId = card.getAttribute('data-product-id');
        
        // Navigate to product detail with ID
        window.location.href = `detail.html?id=${productId}`;
    });
});

// Filter Options
const filterOptions = document.querySelectorAll('.filter-option input');
filterOptions.forEach(input => {
    input.addEventListener('change', () => {
        applyFilters();
    });
});

// Reset Filter
const btnReset = document.getElementById('btnReset');
btnReset.addEventListener('click', () => {
    // Reset all checkboxes and radios
    filterOptions.forEach(input => {
        if (input.type === 'checkbox') {
            input.checked = input.value === 'all';
        } else if (input.type === 'radio') {
            input.checked = input.value === 'all';
        }
    });
    
    applyFilters();
    showNotification('Filter direset');
});

// Apply Filters Function
function applyFilters() {
    const selectedCategories = [];
    const selectedPrice = document.querySelector('input[name="price"]:checked').value;
    const selectedMaterials = [];
    
    // Get selected categories
    document.querySelectorAll('input[name="category"]:checked').forEach(input => {
        if (input.value !== 'all') {
            selectedCategories.push(input.value);
        }
    });
    
    // Get selected materials
    document.querySelectorAll('input[name="material"]:checked').forEach(input => {
        selectedMaterials.push(input.value);
    });
    
    console.log('Filters applied:', {
        categories: selectedCategories,
        price: selectedPrice,
        materials: selectedMaterials
    });
    
    // TODO: Implement actual filtering logic
    // This would typically call an API or filter the products array
    
    showNotification('Filter diterapkan');
}

// Pagination
const pageBtns = document.querySelectorAll('.page-btn');
pageBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        if (!btn.disabled && !btn.querySelector('i')) {
            pageBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            // TODO: Load products for selected page
            const pageNumber = btn.textContent;
            console.log('Loading page:', pageNumber);
        }
    });
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

// Load products from localStorage or API
window.addEventListener('load', () => {
    // Check cart count from localStorage
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        const cart = JSON.parse(savedCart);
        cartCount = cart.length;
        cartBadge.textContent = cartCount;
    }
    
    // TODO: Load products from API
    console.log('Products page loaded');
});