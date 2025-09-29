<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductDetailsModal extends Component
{
    public $showModal = false;
    public $productId;
    public $product;
    public $quantity = 1;
    public $successMessage = '';

    protected $listeners = ['openModal'];

    protected $rules = [
        'quantity' => 'required|integer|min:1',
    ];

    public function openModal($productId)
    {
        $this->resetValidation();
        $this->productId = $productId;
        $this->product = Product::findOrFail($productId);
        $this->quantity = 1;
        $this->successMessage = '';
        $this->showModal = true;
        
    }

    public function addToCart()
{
    $this->validate();

    $user = Auth::user();
    if (!$user) {
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Please login to add to cart.'
        ]);
        return;
    }

    $cart = Cart::firstOrCreate(
        ['user_id' => $user->id],
        ['total' => 0]
    );

    $cartItem = $cart->cartItems()->where('product_id', $this->product->id)->first();

    if ($cartItem) {
        $cartItem->quantity += $this->quantity;
        $cartItem->price = $this->product->price;
        $cartItem->save();
    } else {
        $cart->cartItems()->create([
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
            'price' => $this->product->price,
        ]);
    }

    // $this->successMessage = 'Product added to cart!';
    // session()->flash('success', 'Product added to cart!');

    $this->dispatch('notify-success', [
    'message' => 'Product added to cart!'
]);

    $this->dispatch('cartUpdated');

    $this->showModal = false;
    $this->reset('productId', 'product', 'quantity');
}


    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.customer.product-details-modal');
    }
}
