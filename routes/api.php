<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CartController;

// Sample test route (optional)
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});

// Routes
Route::apiResource('products', ProductController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('consultations', ConsultationController::class);
Route::apiResource('payment', PaymentController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('cart-items', CartItemController::class);
Route::apiResource('carts', CartController::class);
