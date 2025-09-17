<div>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="openCreateModal" class="bg-brown text-beige font-bold py-2 px-6 rounded-full mb-6 hover:bg-btn-hover-brown transition">
        Create Product
    </button>

    <div class="overflow-x-auto max-h-[400px] bg-beige/80 rounded-lg shadow-lg p-4">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Stock</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Featured</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td class="border px-4 py-2">{{ $product->product_name }}</td>
                    <td class="border px-4 py-2">{{ $product->no_of_stock }}</td>
                    <td class="border px-4 py-2">${{ number_format($product->price, 2) }}</td>
                    <td class="border px-4 py-2">{{ $product->category->category_name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $product->description }}</td>
                    <td class="border px-4 py-2">
                        <img src="{{ asset('storage/' . $product->product_image) }}" class="w-[150px] h-[150px] object-cover rounded" />
                    </td>
                    <td class="border px-4 py-2">
                        @if($product->is_featured)
                            <span class="text-green-600 font-semibold">Yes</span>
                        @else
                            <span class="text-gray-500">No</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2 space-x-2 flex flex-row justify-between items-center">
                        <button wire:click="openEditModal({{ $product->id }})" class="bg-brown text-beige px-3 py-1 rounded-full hover:bg-btn-hover-brown transition">
                            Edit
                        </button>
                        <button wire:click="delete({{ $product->id }})" class="text-red-600 border border-red-500 px-3 py-1 rounded-full hover:bg-red-500 hover:text-white transition"
                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-beige/80 rounded-lg p-8 max-w-3xl shadow-lg relative">
            <h2 class="text-2xl font-lustria font-bold mb-6 text-center">
                {{ $editMode ? 'Edit Product' : 'Create Product' }}
            </h2>

            <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}" enctype="multipart/form-data" class="space-y-6">

                {{-- Product Name --}}
                <input type="text" wire:model.defer="product_name" placeholder="Product Name" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brown" />
                
                    {{-- Description --}}
                <textarea wire:model.defer="description" placeholder="Product Description"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brown"></textarea>
                
                <div class="flex gap-4">
                    {{-- Type DropDown--}}
                    <select wire:model.defer="type" required
                        class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-brown">
                        <option value="">Select Type</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Home Decor">Home Decor</option>
                        <option value="Other">Other</option>
                    </select>

                    {{-- Category Dropdown --}}
                    <select type="text" wire:model.defer="category_id" required 
                        class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-brown">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category) 
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Stock & Price --}}
                <div class="flex gap-4">
                    <input type="number" wire:model.defer="no_of_stock" placeholder="Stock" min="0" required
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-brown" />
                    <input type="number" step="0.01" wire:model.defer="price" placeholder="Price" required
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-brown" />
                </div>
                    
                {{-- Image Upload --}}
                <input type="file" wire:model="product_image" class="w-full border border-gray-300 rounded px-4 py-2" />
                @if ($product_image)
                    {{-- When a new image is uploaded --}}
                    <div class="mt-2">
                        <img src="{{ $product_image->temporaryUrl() }}" class="w-[100px] h-[100px] object-cover rounded">
                    </div>
                @elseif ($existing_image)
                    {{-- When editing and no new image is uploaded --}}
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $existing_image) }}" class="w-[100px] h-[100px] object-cover rounded">
                    </div>
                @endif

                {{-- Featured Toggle --}}
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model.defer="is_featured" class="form-checkbox h-5 w-5 text-brown">
                    <span class="text-sm text-gray-700">Mark as Featured Product</span>
                </label>

                <div class="flex justify-end gap-4">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-300 rounded-full px-6 py-2 hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-brown text-beige rounded-full px-6 py-2 hover:bg-btn-hover-brown transition">
                        {{ $editMode ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>

            <button wire:click="$set('showModal', false)"
                class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-3xl font-bold cursor-pointer">&times;</button>
        </div>
    </div>
    @endif
</div>
