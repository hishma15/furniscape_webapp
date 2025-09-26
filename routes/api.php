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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AdminLoginController;

// Sample test route (optional)
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});


// Routes
// Route::apiResource('products', ProductController::class);
// Route::apiResource('users', UserController::class);
// Route::apiResource('consultations', ConsultationController::class);
// Route::apiResource('payment', PaymentController::class);
// Route::apiResource('orders', OrderController::class);
// Route::apiResource('order-items', OrderItemController::class);
// Route::apiResource('categories', CategoryController::class);
// Route::apiResource('cart-items', CartItemController::class);
// Route::apiResource('carts', CartController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/admin/login', [AdminLoginController::class, 'store']);

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('consultations', ConsultationController::class);
    Route::apiResource('payment', PaymentController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order-items', OrderItemController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('cart-items', CartItemController::class);
    Route::apiResource('carts', CartController::class);

});

