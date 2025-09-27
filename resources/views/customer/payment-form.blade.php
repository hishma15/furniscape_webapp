<x-app-layout>
    {{-- @livewire('customer.payment-form') --}}
    <livewire:customer.payment-form :order_id="$order_id" :amount="$amount" />
</x-app-layout>