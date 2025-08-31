<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Resources\PaymentResource;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all payments, with the associated order information
        $payments = Payment::with('order')->paginate(10);

        // Return a collection of payments as PaymentResource
        return PaymentResource::collection($payments);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|in:pending,completed,failed',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'order_id' => 'required|exists:orders,id',
        ]);

        // Create a new payment record using the validated data
        $payment = Payment::create($validated);

        // Return the created payment as a PaymentResource
        return new PaymentResource($payment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the payment by ID, including associated order data
        $payment = Payment::with('order')->findOrFail($id);

        // Return the payment as a PaymentResource
        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate only the payment_status field
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,completed,failed',
        ]);
        
        // Find the payment by its ID
        $payment = Payment::findOrFail($id);

        // Update the payment status
        $payment->update([
            'payment_status' => $validated['payment_status'],
        ]);

        // Return the updated payment as a response
        return new PaymentResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cannot delete a payment 
    }
}
