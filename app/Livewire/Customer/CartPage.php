<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{

    public $cart;

    protected $listeners = ['cartUpdated' => 'loadCart' ];

    public function mount() 
    {
        $this->loadCart();
    }

    public function loadCart() 
    {
        $this->cart = Auth::user()->cart()->with('cartItems.product')->first();
    }

    public function render()
    {
        return view('livewire.customer.cart-page');
    }

    public function addToCart($productId)
    {
        $cart = Auth::user()->cart()->firstOrCreate();
        $cartItem = $cart->cartItems()->updateOrCreate(
            ['product_id' => $productId],
            ['quantity' => \DB::raw('quantity + 1')]
        );

        $this->loadCart(); // reload cart data
    }

    public function increaseQuantity($itemId)
    {
        $item =$this->cart->cartItems->find($itemId);
        if ($item) {
            $item->quantity++;
            $item->save();
            $this->updateCartTotal();
        }
    }

    public function decreaseQuantity($itemId)
    {
        $item = $this->cart->cartItems->find($itemId);
        if ($item && $item->quantity > 1) {
            $item->quantity--;
            $item->save();
            $this->updateCartTotal();
        }
    }

    public function removeItem($itemId)
    {
        $item = $this->cart->cartItems->find($itemId);
        if ($item) {
            $item->delete();
            $this->updateCartTotal();
        }
    }
    
    private function updateCartTotal()
    {
        $this->cart->total = $this->cart->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $this->cart->save();

        // $this->refreshCart();
        // $this->dispatchBrowserEvent('cart-updated');
    }




}
