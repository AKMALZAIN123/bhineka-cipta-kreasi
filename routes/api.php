<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;

require __DIR__.'/auth.php';

// Product routes (public)
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/search', [ProductController::class, 'search']); 
    Route::get('/filter', [ProductController::class, 'filter']); 
    Route::get('/{id}', [ProductController::class, 'show']); 
});

// middleware protected routes
Route::middleware('auth:sanctum')->group(function () {
    
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']); 
        Route::post('/add', [CartController::class, 'add']); 
        Route::put('/update/{itemId}', [CartController::class, 'update']);
        Route::delete('/remove/{itemId}', [CartController::class, 'remove']); 
        Route::delete('/clear', [CartController::class, 'clear']); 
    });
    
    // Order routes
    Route::prefix('orders')->group(function () {
        Route::post('/checkout', [OrderController::class, 'checkout']); 
        Route::get('/', [OrderController::class, 'history']); 
        Route::get('/{orderId}', [OrderController::class, 'detail']); 
        Route::post('/{orderId}/cancel', [OrderController::class, 'cancel']); 
    });
});