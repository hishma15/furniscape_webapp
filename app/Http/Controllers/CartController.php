<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartItem;
use App\Http\Resources\CartResource;

use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $carts = Cart::with(['user', 'cartItems'])->paginate(10);
        return CartResource::collection($carts);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'total' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::create($validated);
        return new CartResource($cart->load(['user', 'cartItems']));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $cart = Cart::with(['user', 'cartItems'])->findOrFail($id);
        return new CartResource($cart);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'total' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::findOrFail($id);
        $cart->update($validated);

        return new CartResource($cart->load(['user', 'cartItems']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully.'], 200);
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        // Get or create a cart for this user
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total' => 0] // default total
        );

        // Check if the product is already in the cart
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity and price if needed
            $cartItem->quantity += $request->quantity;
            $cartItem->price = $request->price; // or recalculate if needed
            $cartItem->save();
        } else {
            // Create new cart item
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        }

        // Optionally, update cart total here...

        return redirect()->back()->with('success', 'Product added to cart!');
    }



}
