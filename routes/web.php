<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// Home page (existing landing page)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Product pages
Route::prefix('products')->group(function () {
    Route::get('/artisan-satchel', [ProductController::class, 'showSatchel'])->name('products.satchel');
});

// Reservation pages
Route::prefix('reservation')->group(function () {
    Route::get('/personalize', [ReservationController::class, 'personalize'])->name('reservation.personalize');
    Route::post('/personalize', [ReservationController::class, 'store'])->name('reservation.store');
});

// Checkout pages
Route::prefix('checkout')->group(function () {
    // Display confirmation page (GET)
    Route::get('/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    // Process customization form (POST)
    Route::post('/customization', [CheckoutController::class, 'storeCustomization'])->name('checkout.customization.store');
    // Process final checkout (POST)
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');
    Route::post('orders/{order}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])
        ->name('orders.update-payment-status');
    Route::get('orders-statistics', [OrderController::class, 'statistics'])
        ->name('orders.statistics');
});