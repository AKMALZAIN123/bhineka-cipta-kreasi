<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/produk', [HomeController::class, 'produk'])->name('produk');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/regis', [HomeController::class, 'regis'])->name('regis');
Route::get('/detail', [HomeController::class, 'detail'])->name('detail');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');



