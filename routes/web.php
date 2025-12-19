<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartWebController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [HomeController::class, 'produk'])->name('produk');
Route::get('/produk/{id}', [HomeController::class, 'detail'])->name('produk.detail');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/detail', [HomeController::class, 'detail'])->name('detail');
Route::get('/privasi', [HomeController::class, 'privasi'])->name('privasi');
Route::get('/syarat', [HomeController::class, 'syarat'])->name('syarat');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::get('/history', [HomeController::class, 'history'])->name('history');
Route::get('/detail-history', [HomeController::class, 'detail-history'])->name('detail history');

// Authentication pages (Blade) - untuk guest
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('regis'); 
    })->name('register.form');
    
    Route::get('/login', function () {
        return view('login');
    })->name('login.form');
    
    // Form POST - gunakan controller dari Breeze
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

// Protected pages - untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
    Route::post('/cart/add', [CartWebController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartWebController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartWebController::class, 'delete'])->name('cart.delete');
    
    // Checkout & Order routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/order/success', [OrderController::class, 'orderSuccess'])->name('order.success');
    Route::get('/order/pending', [OrderController::class, 'orderPending'])->name('order.pending');
    Route::get('/order/error', [OrderController::class, 'orderError'])->name('order.error');
    
    // Order history & detail
    Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    Route::get('/order/{orderId}', [OrderController::class, 'orderDetail'])->name('order.detail');

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Payment status check (authenticated)
Route::middleware('auth')->get('/payment/status/{orderId}', [PaymentController::class, 'checkStatus'])->name('payment.status');