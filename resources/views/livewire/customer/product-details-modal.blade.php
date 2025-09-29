<div>
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-[450px] relative font-montserrat">

                {{-- ❌ Close Button --}}
                <button wire:click="closeModal" class="absolute top-2 right-4 text-brown text-2xl hover:text-btn-hover-brown">
                    &times;
                </button>

                {{-- 🖼️ Product Image --}}
                <img src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('images/default.jpg') }}"
                    alt="{{ $product->product_name }}"
                    class="w-full h-52 object-cover rounded-lg shadow" />

                {{-- 🪑 Product Info --}}
                <h2 class="text-2xl font-semibold text-brown mt-4">{{ $product->product_name }}</h2>
                <p class="text-lg text-gray-600 mt-1">LKR {{ number_format($product->price, 2) }}</p>
                <p class="mt-3 text-gray-700 text-sm">{{ $product->description ?? 'No description available.' }}</p>

                {{-- 🔢 Quantity Selector (Styled Like Cart) --}}
                <div class="mt-5">
                    <label class="block text-brown font-semibold mb-1">Quantity:</label>
                    <div class="flex items-center space-x-3">
                        <button wire:click="decreaseQuantity"
                                class="px-3 py-1 bg-brown rounded-full text-beige text-lg font-bold hover:bg-btn-hover-brown">-</button>
                        <span class="font-bold text-lg">{{ $quantity }}</span>
                        <button wire:click="increaseQuantity"
                                class="px-3 py-1 bg-brown rounded-full text-beige text-lg font-bold hover:bg-btn-hover-brown">+</button>
                    </div>
                    @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- ✅ Success Message --}}
                @if($successMessage)
                    <div class="mt-4 text-green-600 font-semibold text-sm">{{ $successMessage }}</div>
                @endif

                {{-- 🛒 Add to Cart Button --}}
                <button wire:click="addToCart"
                        class="mt-6 w-full bg-brown text-beige py-2 rounded-full text-center font-semibold hover:bg-btn-hover-brown transition-all">
                    Add to Cart
                </button>

            </div>
        </div>
    @endif
</div>
