<div>
    <h2 class="heading-style">PAYMENT INFORMATION</h2>

    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="processPayment" class="space-y-6">

        <div class="bg-beige p-5 m-3 space-y-6 max-w-3xl mx-auto">
            <h3 class="text-black font-montserrat tracking-wider text-lg">SELECT PAYMENT METHOD</h3>

            <!-- Payment Method Dropdown -->
            <div class="flex items-center space-x-4">
                <x-label for="payment_method" class="w-40">Payment Method:</x-label>
                <select wire:model="payment_method" id="payment_method"
                    class="w-full rounded-full border border-gray-300 focus:border-brown focus:ring focus:ring-brown/50">
                    <option value="">-- Choose --</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            @error('payment_method') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <!-- Credit Card Fields (conditionally shown) -->
            @if($payment_method === 'credit_card')
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <x-label for="card_number" class="w-40">Card Number:</x-label>
                        <x-input type="text" id="card_number" wire:model.defer="card_number" placeholder="1234 5678 9012 3456" />
                    </div>
                    @error('card_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <div class="flex items-center space-x-4">
                        <x-label for="expiry_date" class="w-40">Expiry Date:</x-label>
                        <x-input type="text" id="expiry_date" wire:model.defer="expiry_date" placeholder="MM/YY" />
                    </div>
                    @error('expiry_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <div class="flex items-center space-x-4">
                        <x-label for="cvv" class="w-40">CVV:</x-label>
                        <x-input type="text" id="cvv" wire:model.defer="cvv" placeholder="123" />
                    </div>
                    @error('cvv') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
            @endif

            <!-- Payment Amount (readonly) -->
            <div class="flex items-center space-x-4">
                <x-label for="amount" class="w-40">Amount:</x-label>
                <x-input type="text" id="amount" wire:model="amount" readonly />
            </div>

            <!-- Payment Instructions for non-card methods -->
            @if($payment_method === 'paypal')
                <p class="text-sm text-gray-700 mt-4">
                    Please send payment to <strong>paypal@example.com</strong>. You will receive a confirmation email once your payment is verified.
                </p>
            @elseif($payment_method === 'bank_transfer')
                <p class="text-sm text-gray-700 mt-4">
                    Transfer the amount to the following account:<br>
                    <strong>Bank:</strong> XYZ Bank<br>
                    <strong>Account No:</strong> 123456789<br>
                    <strong>IFSC:</strong> XYZB0001234<br>
                    Include your Order ID in the reference.
                </p>
            @endif

            <!-- Submit Button -->
            <div class="pt-4">
                <x-button>Confirm Payment</x-button>
            </div>
        </div>
    </form>
</div>

