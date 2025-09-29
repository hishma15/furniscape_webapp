<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;


class ProductSearch extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $categoryId = '';

    public $categories;

    protected $queryString = ['searchTerm', 'categoryId'];

    public function mount($initialSearchTerm = null, $category_id = null)
    {
        $this->searchTerm = $initialSearchTerm ?? '';
        $this->categoryId = $category_id ?? '';
        $this->categories = Category::all();
    }   

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function search()
    {
        // RREDIRECTS TO PRODUCTS PAGE WUTH THE SEARCH QUERY
        return redirect()->route('products', [
            'search' => $this->searchTerm,
            'category_id' => $this->categoryId,
        ]);
        
    }

    
    public function render()
    {
        $query = Product::with(['category', 'admin']);

        if ($this->searchTerm) {
            $query->where('product_name', 'like', '%' . $this->searchTerm . '%');
        }

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        $products = $query->paginate(10);

        // Ensure categories is available
        $categories = $this->categories;

        // find the currently selected category
        $category = $this->categories->firstWhere('id', (int) $this->categoryId);

        return view('livewire.customer.product-search', [
            'products' => $products,
            'category' => $category,
            'categories' => $categories,
        ]);
    }

    public function openProductModal($productId)
{
    $this->dispatch('openModal', $productId);
}

}
