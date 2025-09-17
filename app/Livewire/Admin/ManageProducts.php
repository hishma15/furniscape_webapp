<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ManageProducts extends Component
{

    use WithFileUploads, WithPagination;

    public $product_id;
    public $product_name;
    public $no_of_stock;
    public $price;
    public $type;
    public $product_image;
    public $description;
    public $is_featured =false;
    public $category_id;
    
    public $existing_image;

    public $showModal = false;
    public $editMode = false;

    public function openCreateModal() 
    {
        $this->resetInputFields();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->product_name = $product->product_name;
        $this->no_of_stock = $product->no_of_stock;
        $this->price = $product->price;
        $this->type = $product->type;
        // $this->product_image = $product->product_image;
        $this->description = $product->description;
        $this->is_featured = $product->is_featured ? true :false;
        $this->category_id = $product->category_id;
        
        $this->existing_image = $product->product_image;

        $this->editMode = true;
        $this->showModal = true;

    }

    public function resetInputFields() 
    {
        $this->product_id = null;
        $this->product_name = '';
        $this->no_of_stock = '';
        $this->price = '';
        $this->type = '';
        $this->product_image = null;
        $this->description = '';
        $this->is_featured = false;
        $this->category_id = null;

        $this->existing_image = null;
    }

    public function store()
    {
        $validated = $this->validate([
            'product_name' => 'required|string|max:255',
            'no_of_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
            'product_image' => 'required|image|max:1024',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $imagePath = $this->product_image->store('products', 'public');

        Product::create(array_merge(
            $validated,   //Spread operator - passing validated data to the create method)
            [
            'product_image' =>$imagePath,
            'admin_id' => auth()->id(),
            ]
        ));

        session()->flash('message', 'product created successfully.');

        $this->showModal = false;
        $this->resetInputFields();
    }

    public function update() 
    {
        $validated = $this->validate([
            'product_name' => 'required|string|max:255',
            'no_of_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
            'product_image' => 'nullable|image|max:1024',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::findOrFail($this->product_id);

        if ($this->product_image) {
            Storage::disk('public')->delete($product->product_image);
            $imagePath = $this->product_image->store('products', 'public');
        } else {
            $imagePath = $product->product_image;
        }

        $product->update(array_merge(
            $validated,
            [
            'product_image' => $imagePath,
            ]
        ));
        
        session()->flash('message', 'Product updated Successfully');
        $this->showModal = false;
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'product Deleted.');  
    }

    public function render()
    {
        return view('livewire.admin.manage-products', [
            'products' => Product::with('category')->orderBy('created_at', 'desc')->paginate(10),
            'categories' => Category::all()
        ]);
    }
}
