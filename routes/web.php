<?php

use Illuminate\Support\Facades\Route;


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


Route::get('/', function () {
    return view('welcome');
});
