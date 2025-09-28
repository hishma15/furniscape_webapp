<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-black text-center font-lustria">MANAGE ORDERS</h1>
    </x-slot>

    <div class="p-4 bg-beige/80 rounded-lg shadow-lg max-w-7xl m-2">
        <div class="overflow-x-auto max-h-[600px]">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">Customer</th>
                        <th class="border px-4 py-2">Address</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Payment Status</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Delivery Date</th>
                        <th class="border px-4 py-2">View Items</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="order-body">
                    <tr><td colspan="8" class="text-center">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    @vite('resources/js/admin-order.js')
</x-admin-layout>
