<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Product;
use App\Models\Order;
use App\Models\Consultation;

use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{

    public $productsCount;
    public $ordersCount;
    public $consultationsCount;

    public $statusCounts = [];

    public function mount()
    {
        $this->productsCount = Product::count();
        $this->ordersCount = Order::count();
        $this->consultationsCount = Consultation::count();

        // MongoDB aggregation - group by status
        $result = Consultation::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$status',
                        'count' => ['$sum' => 1]
                    ] 
                ]
            ]);
        });

        // Format for chart use
        foreach ($result as $item) {
            $this->statusCounts[$item->_id] = $item->count;
        }

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
