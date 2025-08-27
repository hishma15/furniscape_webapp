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
        $admins = User::factory(1)->create([
            'role' => 'admin'
        ]);

        // Create 5 customers
        $customers = User::factory(5)->create([
            'role' => 'customer'
        ]);

        // Create 3 categories and assign random admin
        $categories = Category::factory(3)->create()->each(function ($category) use ($admins) {
            $category->admin_id = $admins->random()->id;
            $category->save();
        });

        // Create 10 products and assign category & admin
        $products = Product::factory(10)->create()->each(function ($product) use ($categories, $admins) {
            $product->category_id = $categories->random()->id;
            $product->admin_id = $admins->random()->id;
            $product->save();
        });

        // Create 10 consultations assigned to random customers and admin
        Consultation::factory(10)->create()->each(function ($consultation) use ($customers, $admins) {
            $consultation->customer_id = $customers->random()->id;
            $consultation->admin_id = $admins->random()->id;
            $consultation->save();
        });

        // Create 5 orders for random customers and assign admin
        Order::factory(5)->create()->each(function ($order) use ($customers, $admins) {
            $order->customer_id = $customers->random()->id;
            $order->admin_id = $admins->random()->id;
            $order->save();
        });

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
