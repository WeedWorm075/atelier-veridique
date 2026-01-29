<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CheckoutController;

// Home page (existing landing page)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Product pages
Route::prefix('products')->group(function () {
    Route::get('/artisan-satchel', [ProductController::class, 'showSatchel'])->name('products.satchel');
    Route::get('/satchel/personalize', [ProductController::class, 'personalize'])
    ->name('products.personalize');
});


// Reservation pages
Route::prefix('reservation')->group(function () {
    Route::get('/personalize', [ReservationController::class, 'personalize'])->name('reservation.personalize');
    Route::post('/personalize', [ReservationController::class, 'store'])->name('reservation.store');
});

// Checkout pages
Route::prefix('checkout')->group(function () {
    Route::get('/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});
