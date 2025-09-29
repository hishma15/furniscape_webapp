<div>
    <div class="m-4">
        {{-- CATEGORY + SEARCH BAR (only for fallback, not header) --}}
        <label for="categoryFilter" class="font-semibold mr-2">Filter by Category:</label>
        <select id="categoryFilter" class="border border-gray-300 rounded px-3 py-2" onchange="window.location.href = '/products?category_id=' + this.value;">
            <option value="" {{ $categoryId == '' ? 'selected' : '' }}>All Categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
            @endforeach
        </select>
    </div>

    <h1 class="heading-style" id="category-name">
        @if ($searchTerm)
            Showing results for "{{ $searchTerm }}"
        @elseif ($category)
            {{ $category->category_name }}
        @else
            All Products
        @endif
    </h1>


    {{-- Product Grid --}}
    @if($products->count())
        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6">
            @foreach($products as $product)
                <div class="product-div">
                    <img src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('images/default.jpg') }}"
                        alt="{{ $product->product_name }}" class="product-img">
                    <h2 class="product-name">{{ $product->product_name }}</h2>
                    <p class="product-price">LKR {{ number_format($product->price, 2) }}</p>

                    <div class="product-div-btn">
                        {{-- <button class="product-view-btn" >View Details</button> --}}
                        <button wire:click="openProductModal({{ $product->id }})" class="product-view-btn">View Details</button>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="product-addtocart-btn">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </section>

        {{-- Pagination --}}
        <div class="flex justify-center mt-6">
            {{ $products->links() }}
        </div>
    @else
        <p class="text-center tracking-wider m-10 text-2xl font-montserrat col-span-full text-gray-500 px-6">
            No products found.
        </p>
    @endif
</div>
