<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;

use App\Models\Category;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function showProductPage(Request $request)
{
    $categories = Category::all();
    return view('products', compact('categories'));
}


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve all prpducts, with the associated category and admin information
        // $products = Product::with(['category', 'admin'])->paginate(10);
        // return ProductResource::collection($products);

        $query = Product::with(['category', 'admin']);

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);
        return ProductResource::collection($products);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'no_of_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
            'product_image' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'admin_id' => 'required|exists:users,id',
        ]);

        $product = Product::create($validated);
        return new ProductResource($product);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::with(['category', 'admin'])->findOrFail($id);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'no_of_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
            'product_image' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'admin_id' => 'required|exists:users,id',
        ]);

        $product = Product::findOrFail($id);

        $product->update($validated);
        return new ProductResource($product);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }
}
