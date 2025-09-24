<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use App\Models\Payment;
// use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Consultation;
use App\Models\Category;
// use App\Models\CartItem;
// use App\Models\Cart;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create 1 admin
        // $admins = User::factory(1)->create([
        //     'role' => 'admin'
        // ]);
        // Create only one admin user with fixed ID
        $this->call(AdminSeeder::class);

        // 2. Get the single admin
        $admin = User::where('email', 'furniscapestore@gmail.com')->first();

        // // Create 5 customers
        // $customers = User::factory(5)->create([
        //     'role' => 'customer'
        // ]);

        // // 4. Create categories and assign the admin
        // $categories = Category::factory(3)->create()->each(function ($category) use ($admin) {
        //     $category->admin_id = $admin->id;
        //     $category->save();
        // });

        // // 5. Create products and assign random category & admin
        // Product::factory(10)->create()->each(function ($product) use ($categories, $admin) {
        //     $product->category_id = $categories->random()->id;
        //     $product->admin_id = $admin->id;
        //     $product->save();
        // });

        // // 6. Create consultations (random customers, single admin)
        // Consultation::factory(10)->create()->each(function ($consultation) use ($customers, $admin) {
        //     $consultation->customer_id = $customers->random()->id;
        //     $consultation->admin_id = $admin->id;
        //     $consultation->save();
        // });

        // // 7. Create orders (random customers, single admin)
        // Order::factory(5)->create()->each(function ($order) use ($customers, $admin) {
        //     $order->customer_id = $customers->random()->id;
        //     $order->admin_id = $admin->id;
        //     $order->save();
        // });

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
