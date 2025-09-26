<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class CartPage extends Component
{

    public $cartItems;

    public function mount() 
    {
        $this->loadCart();
    }

    public function loadCart() 
    {
        $this->cartItems = auth()->user()
            ->cart()
            ->with('cartItems.product')
            ->first()
            ->cartItems ?? [];
    }

    public function render()
    {
        return view('livewire.customer.cart-page');
    }

    protected $listeners = ['cartUpdated' => 'loadCart'];

}
