<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ManageCategories extends Component
{
    use WithFileUploads, WithPagination;

    public $showModal = false;
    public $category_id;
    public $category_name;
    public $category_desc;
    public $category_image;

    public $editMode = false;

    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->category_name = $category->category_name;
        $this->category_desc = $category->category_desc;
        // handle image upload logic separately
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function resetInputFields()
    {
        $this->category_id = null;
        $this->category_name = '';
        $this->category_desc = '';
        $this->category_image = null;
    }

    public function store()
    {
        $validatedData = $this->validate([
            'category_name' => 'required|string|max:255',
            'category_desc' => 'nullable|string',
            'category_image' => 'required|image|max:1024', // max 1MB for example
        ]);

        // Handle image upload
        $imagePath = $this->category_image->store('categories', 'public');

        Category::create([
            'category_name' => $this->category_name,
            'category_desc' => $this->category_desc,
            'category_image' => $imagePath,
            'admin_id' => auth()->id(),
        ]);

        $this->showModal = false;
        session()->flash('message', 'Category created successfully.');
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedData = $this->validate([
            'category_name' => 'required|string|max:255',
            'category_desc' => 'nullable|string',
            'category_image' => 'nullable|image|max:1024',
        ]);

        $category = Category::findOrFail($this->category_id);

        if ($this->category_image) {
            // Delete old image if you want (optional)
            Storage::disk('public')->delete($category->category_image);

            $imagePath = $this->category_image->store('categories', 'public');
        } else {
            $imagePath = $category->category_image;
        }

        $category->update([
            'category_name' => $this->category_name,
            'category_desc' => $this->category_desc,
            'category_image' => $imagePath,
        ]);

        $this->showModal = false;
        session()->flash('message', 'Category updated successfully.');
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-categories', [
            'categories' => Category::orderBy('created_at', 'desc')->paginate(10),
        ])->layout('components.admin-layout');
    //      return view('livewire.admin.manage-categories', [
    //     'categories' => Category::orderBy('created_at', 'desc')->paginate(10),
    // ]);
        
    }
}
