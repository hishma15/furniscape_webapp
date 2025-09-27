<?php

namespace App\Livewire\Customer;

use App\Models\Cart;
use App\Models\Order;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class CheckoutPage extends Component
{

    public $home_no, $street, $city, $delivery_date;

    public function rules() 
    {
        return [
            'home_no' => 'required',
            'street' => 'required',
            'city' => 'required',
        ];
    }

    public function submit() 
    {
        $this->validate();

        $cart = Cart::with('cartItems.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            session()->flash('error', 'Cart is Empty');
            return;
        }

        $order = Order::create([
            'total_amount' => $cart->total,
            'order_date' => now(),
            'delivery_date' => null,   //admin will update this
            'home_no' => $this->home_no,
            'street' => $this->street,
            'city' => $this->city,
            'status' => 'pending',
            'customer_id' => Auth::id(),
        ]);

        foreach ($cart->cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price_at_purchase' => $item->price,
            ]);
        }

        session(['order_id' => $order->id]);

        $cart->cartItems()->delete();
        $cart->delete();

        return redirect()->route('payment');

    }

    public function render()
    {
        return view('livewire.customer.checkout-page');
    }
}
