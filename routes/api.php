<?php
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// API routes
Route::get('products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('products/{product}', [ProductController::class, 'show']);

Route::put('products/{product}', [ProductController::class, 'update']);


Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::post('pay/order', [PaymentController::class, 'payByStripe']);
