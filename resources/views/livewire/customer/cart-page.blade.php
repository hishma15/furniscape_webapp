<div>
    <h1 class="heading-style"> My Cart! </h1>

    @forelse($cartItems as $item)
        <div class="flex justify-between items-center border-b py-2">
            <div>
                <p>{{ $item->product->product_name }}</p>
                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
            </div>
            <div>
                <p>LKR {{ number_format($item->total, 2) }}</p>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Your cart is empty.</p>
    @endforelse
</div>
