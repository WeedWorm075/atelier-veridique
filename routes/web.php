<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Product page
Route::get('/', function () {
    return view('landing_page');
})->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::view('/products/satchel', 'ethical_product_page')->name('products.satchel');
Route::view('/products/personalize', 'reservation_personalization')->name('products.personalize');
Route::view('/checkout', 'checkout_confirmation')->name('checkout');

// Optional: Dynamic routes for future features
Route::get('/products/{id}', function ($id) {
    // You can add product controller logic here
})->name('products.show');

// Reservation flow
Route::get('/reservations/personalization', [ReservationController::class, 'personalization'])
    ->name('reservations.personalization');
Route::post('/reservations/update', [ReservationController::class, 'updatePersonalization'])
    ->name('reservations.update');

// Checkout flow
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])
    ->name('checkout.confirmation');

// Admin routes (protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});
