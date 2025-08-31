<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Http\Resources\CartResource;

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
}
