<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

use App\Livewire\Customer\PaymentForm;

use Illuminate\Http\Request;

Route::get('test', function () {
    
    // Fetch a category by ID and get its products  [find the products of category id 3]
    $category = App\Models\Category::find(3);
    // return $category->products;

    // Fetch a product by ID and get its category
    $product = App\Models\Product::find(1);
    // return $product->category;
    
    // Fetch consultation by ID and get customer and admin
    $consultation = App\Models\Consultation::find(1);
    // return $consultation->customer; //[get customer details of the consultation id 1]
    // return $consultation->admin;

    // Fetch an order by ID and get customer and admin
    $order = App\Models\Order::find(3);
    // return $order->customer;
    // return $order->admin;

     // Fetch a user (admin) and get categories/products/orders they manage
    $admin = App\Models\User::where('role', 'admin')->first();
    // return $admin->managedCategories;
    // return $admin->managedProducts;
    // return $admin->managedOrders;

    // Fetch a user (customer) and get their orders and consultations
    $customer = App\Models\User::where('role', 'customer')->first();
    // return $customer->orders;
    // return $customer->consultations;

});


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
        return view('about');
    })->name('about');

Route::get('/services', function () {
        return view('services');
    })->name('services');

// Route::get('/products', [ProductController::class, 'showProductPage'])->name('products');

Route::post('/customer-login', [AuthController::class, 'login'])->name('customer.login');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('consultations', [ConsultationController::class, 'createForm'])->name('customer.consultationForm');
    // Route::post('consultations', [ConsultationController::class, 'store'])->name('consultations.webstore');

    Route::get('/products', [ProductController::class, 'showProductPage'])->name('products');
    // Route::get('/products', [ProductController::class, 'index'])->name('products');

    Route::get('/cart', function () {
    return view('customer.mycart');})->name('cart');

    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');

    Route::get('/checkout', function () {
    return view('customer.checkout-page');})->name('customer.checkout');

    Route::get('/payment/{order_id}/{amount}', function ($order_id, $amount) {
    return view('customer.payment-form', compact('order_id', 'amount'));})->name('payment-form');

    Route::get('/order-success', function () {
    return view('customer.order-success');})->name('order-success');
});



// Admin Login Route
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store']);
});

// Admin Logout Route
Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout');

// Admin Dashboard Route
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//     Route::get('/admin/categories', function () {
//     return view('admin.manage-categories');})->name('admin.categories');

//     Route::get('/admin/products', function () {
//         return view('admin.manage-products');})->name('admin.products');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/categories', function () {
    return view('admin.manage-categories');})->name('admin.categories');

    Route::get('/admin/products', function () {
        return view('admin.manage-products');})->name('admin.products');

    Route::get('/admin/consultations', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403); // Forbidden
        }
        return view('admin.manage-consultation');
    })->name('admin.consultations'); 
});


// Route::middleware('auth')->post('/api/token', function (Request $request) {
//     $user = $request->user();

//     // Optionally delete old tokens
//     $user->tokens()->where('name', 'web_token')->delete();

//     $token = $user->createToken('web_token')->plainTextToken;

//     return response()->json(['token' => $token]);
// });
