<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Product;
use App\Models\Order;
use App\Models\Consultation;

class Dashboard extends Component
{

    public $productsCount;
    public $ordersCount;
    public $consultationsCount;

    public function mount()
    {
        $this->productsCount = Product::count();
        $this->ordersCount = Order::count();
        $this->consultationsCount = Consultation::count();
    }

    public function render()
    {
        // return view('livewire.admin.dashboard');

        $recentOrders = \App\Models\Order::with('customer') // eager-load customer
        ->latest()
        ->take(5)
        ->get();

    return view('livewire.admin.dashboard', [
        'recentOrders' => $recentOrders,
    ]);
    }
}
