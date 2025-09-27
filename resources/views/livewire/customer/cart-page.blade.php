<div>
    <h2 class="heading-style">YOUR SHOPPING CART</h2>

    <section class="m-10">
        @if($cart && $cart->cartItems->count())
            <table class="text-center border-collapse w-full">
                <thead class="bg-brown text-beige">
                    <tr>
                        <th class="py-2">PRODUCT</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->cartItems as $item)
                        <tr class="border-b">
                            {{-- <td class="py-2">{{ $item->product->product_name }}</td> --}}
                            <td>
                                <div class="flex flex-col">
                                    <img src="{{ asset('storage/' . $item->product->product_image) }}" alt="{{ $item->product->product_name  }}" class="w-36 h-36 object-contain rounded-lg">
                                    <span>{{ $item->product->product_name }}</span>
                                </div>
                            </td>
                            <td>${{ $item->price }}</td>
                            <td class="py-2">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="decreaseQuantity({{ $item->id }})" class="px-2 bg-brown rounded-full font-bold text-beige hover:cursor-pointer">-</button>
                                    <span>{{ $item->quantity }}</span>
                                    <button wire:click="increaseQuantity({{ $item->id }})" class="px-2 bg-brown rounded-full font-bold text-beige hover:cursor-pointer">+</button>
                                </div>
                            </td>

                            <td>${{ $item->quantity * $item->price }}</td>
                            <td>
                                <button wire:click="removeItem({{ $item->id }})" class="text-red-600 text-xl"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-bold p-4">TOTAL: </td>
                        <td colspan="2" class="font-bold p-4">$ {{ $cart->total  }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right p-4">
                            <a href="#" class="bg-brown font-montserrat font-semibold text-beige p-4 rounded-full cursor-pointer hover:bg-btn-hover-brown">PROCEED TO CHECKOUT</a>
                        </td>
                    </tr>
                </tfoot>
            </table>

        @else
            <img src="{{ asset('images/emptycart.jpg') }}" alt="Empty cart image" class="mx-auto">
            <p class="text-center text-gray-600 text-lg font-montserrat tracking-wider">Your cart is empty. Go back and add some furniture!</p>
        @endif 
    </section>

    
{{-- 
    <script>
        window.addEventListener('cart-updated', () => {
            Livewire.emit('cartUpdated');
        });

    </script> --}}
</div>
