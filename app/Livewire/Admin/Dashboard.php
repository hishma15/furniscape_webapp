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

    public $lowStockProducts = [];

    public $statusCounts = [];   //consultation status count
    public $orderStatusCounts = [];   //order status count

    public $productCategoryCounts = [];  // products according to the categories

    public function mount()
    {
        $this->productsCount = Product::count();
        $this->ordersCount = Order::count();
        $this->consultationsCount = Consultation::count();

        // Get low stock products (less than 5)
        $this->lowStockProducts = Product::where('no_of_stock', '<', 2)->get();

        // Group by order status  MY SQL
        $this->orderStatusCounts = Order::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

        // Group by category
        $this->productCategoryCounts = Product::select('categories.category_name as name', DB::raw('COUNT(products.id) as count'))
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->groupBy('categories.category_name')
        ->pluck('count', 'name')
        ->toArray();

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

        $recentOrders = Order::with('customer') // eager-load customer
        ->latest()
        ->take(5)
        ->get();

    return view('livewire.admin.dashboard', [
        'recentOrders' => $recentOrders,
    ]);
    }
}
