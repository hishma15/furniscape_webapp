<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OrderItem;
use App\Http\Resources\OrderItemResource;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orderItems = OrderItem::with(['order', 'product'])->paginate(10);
        return OrderItemResource::collection($orderItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price_at_purchase' => 'required|numeric|min:0',
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $orderItem = OrderItem::create($validated);
        return new OrderItemResource($orderItem);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);
        return new OrderItemResource($orderItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price_at_purchase' => 'required|numeric|min:0',
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($validated);

        return new OrderItemResource($orderItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json(['message' => 'Order item deleted successfully.'], 200);
    }
}
