<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CartItem;
use App\Http\Resources\CartItemResource;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cartItems = CartItem::with(['cart', 'product'])->paginate(10);
        return CartItemResource::collection($cartItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $cartItem = CartItem::create($validated);
        return new CartItemResource($cartItem->load(['cart', 'product']));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $cartItem = CartItem::with(['cart', 'product'])->findOrFail($id);
        return new CartItemResource($cartItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update($validated);

        return new CartItemResource($cartItem->load(['cart', 'product']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Cart item deleted successfully.'], 200);
    }
}
