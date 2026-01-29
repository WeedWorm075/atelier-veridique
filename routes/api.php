<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

Route::middleware('api')->group(function () {
    // Calculate order total
    Route::post('/calculate-total', [OrderController::class, 'calculateTotal']);
    
    // Validate payment
    Route::post('/validate-payment', [OrderController::class, 'validatePayment']);
    
    // Get order status
    Route::get('/order-status/{orderNumber}', [OrderController::class, 'getStatus']);

    Route::post('/checkout', function () {
        // Handle checkout logic
    });
    
    Route::get('/products', function () {
        // Return products JSON
    });
});