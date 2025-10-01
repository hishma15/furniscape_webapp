<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Http\Resources\OrderResource;

use PDF; //TO DOWLOAD INVOICE pdf

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Load orders with related models: customer, admin, payment, orderItems
        $orders = Order::with(['customer', 'admin', 'payment', 'orderItems.product'])->paginate(10);
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'home_no' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'admin_id' => 'nullable|exists:users,id',
            'customer_id' => 'nullable|exists:users,id',
        ]);

        $order = Order::create($validated);

        // Return resource
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $order = Order::with(['customer', 'admin', 'payment', 'orderItems.product'])->findOrFail($id);
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'total_amount' => 'sometimes|numeric|min:0',
            'order_date' => 'sometimes|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'home_no' => 'sometimes|string|max:255',
            'street' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'admin_id' => 'sometimes|exists:users,id',
            'customer_id' => 'sometimes|exists:users,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.'], 200);
    }

    public function downloadInvoice($orderId)
    {
        $order = Order::with('orderItems.product', 'customer')->findOrFail($orderId);

        $pdf = PDF::loadView('customer.order-invoice', compact('order'));

        // Download the PDF file
        return $pdf->download('invoice_order_'.$order->id.'.pdf');
    }

}
