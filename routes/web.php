<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [HomeController::class, 'produk'])->name('produk');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/detail', [HomeController::class, 'detail'])->name('detail');

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
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [HomeController::class, 'orders'])->name('orders');
    
    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});