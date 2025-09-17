<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    //
    public function index()
    {
        // To fetch the featured products to show in home page
        // $featuredProducts = Product::where('is_featured', true)->take(6)->get();
        $featuredProducts = Product::where('is_featured', true)->get();

        // To fetch Recently added products 
        $latestProducts = Product::latest()->take(12)->get();

        // All categories
        $categories = Category::all();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
    
}
