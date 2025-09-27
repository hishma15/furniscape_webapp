<div>

    <h2 class="heading-style">COMPLETE YOUR PURCHASE</h2>

    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">

        <section class="flex flex-col md:flex-row gap-4 p-4">
            <div class="md:w-1/2 space-y-4">

                <!-- PERSONAL DETAILS -->
                <div class="bg-beige p-5 m-3 space-y-4">
                    <h3 class="text-black font-montserrat tracking-wider text-lg">CONTACT DETAILS</h3>

                    <!-- Name -->
                    <div class="flex items-center space-x-4">
                        <x-label for="name" class="w-32">Name:</x-label>
                        <x-input type="text" name="name" id="name" wire:model="name" readonly />
                    </div>

                    <!-- Email -->
                    <div class="flex items-center space-x-4">
                        <x-label for="email" class="w-32 text-black">Email:</x-label>
                        <x-input type="email" name="email" id="email" wire:model="email" readonly />
                    </div>

                    <!-- Phone -->
                    <div class="flex items-center space-x-4">
                        <x-label for="phone_no" class="w-32 text-black">Phone No:</x-label>
                        <x-input type="text" name="phone_no" id="phone_no" wire:model="phone_no" readonly />
                    </div>
                </div>  

                <!-- SHIPPING DETAILS -->
                <div class="bg-beige p-5 m-3 space-y-4">
                    <h3 class="text-black font-montserrat tracking-wider text-lg">SHIPPING ADDRESS</h3>

                    <div class="flex items-center space-x-4">
                        <x-label for="home_no" class="w-32 text-sm text-black">Home No:</x-label>
                        <x-input type="text" id="home_no" wire:model.defer="home_no" class="@error('home_no') @enderror" placeholder="Enter your home number" required/>
                         @error('home_no') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror   
                    </div>

                    <div class="flex items-center space-x-4">
                        <x-label for="street" class="w-32">Street:</x-label>
                        <x-input type="text" id="street" wire:model.defer="street" class="@error('street') @enderror" placeholder="Enter your street" required/>
                        @error('street') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-4">
                        <x-label for="city" class="w-32">City:</x-label>
                        <x-input type="text" id="city" wire:model.defer="city" class="@error('city') @enderror" placeholder="Enter your city" required/>
                        @error('city') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="bg-black text-beige font-montserrat p-5 m-3 md:w-1/2">
                <h3 class="text-beige font-bold text-center text-lg mb-4">Order Summary</h3>

                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="border-b border-beige">
                            <th class="py-2">Product</th>
                            <th>Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-beige">
                        @foreach($cart->cartItems as $item)
                        <tr>
                            <td>{{ $item->product->product_name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="mt-4 text-end border-t border-beige">
                        <tr class="border-t border-white">
                            <td colspan="3" class="pt-4 font-medium">Subtotal</td>
                            <td class="pt-4 text-right">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-2 font-medium">Delivery Charge</td>
                            <td class="py-2 text-right">${{ number_format($delivery_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-2 font-medium">Tax (10%)</td>
                            <td class="py-2 text-right">${{ number_format($taxAmount, 2) }}</td>
                        </tr>
                        <tr class="font-bold border-t border-beige">
                            <td colspan="3" class="pt-4 text-lg">Total</td>
                            <td class="pt-4 text-lg text-right">${{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>    


        <div class="m-5">
            <x-button>
                Place Order & Proceed to Payment
            </x-button>
        </div>
        
    </form>
</div>
