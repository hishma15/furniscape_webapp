<?php

namespace App\Livewire\Customer;

use App\Models\Cart;
use App\Models\Order;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class CheckoutPage extends Component
{

    public $home_no, $street, $city;

    public $delivery_fee = 10; //fixed delivery price
    public $tax_rate = 0.10; //10%

    public $name, $email, $phone_no;

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_no = $user->phone_no; 

        $this->cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();
    }

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

        $totalAmount = $this->total;   // including subtotal + tax + delivery

        $order = Order::create([
            'total_amount' => $totalAmount,
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

         // Redirect to payment form with order_id and amount
        return redirect()->route('payment-form', [
            'order_id' => $order->id,
            'amount' => $order->total_amount 
        ]);

    }

    public function render()
    {
        return view('livewire.customer.checkout-page', [
            'cart' => $this->cart,
            'subtotal' => $this->subtotal,
            'delivery_fee' => $this->delivery_fee,
            'taxAmount' => $this->taxAmount,
            'total' => $this->total,
        ]);

    }

    public function getSubtotalProperty() 
    {
        $cart = Cart::with('cartItems')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return 0;
        }

        return $cart->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getTaxAmountProperty()
    {
        return $this->subtotal * $this->tax_rate;
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->delivery_fee + $this->taxAmount;
    }

}
