<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-black text-center font-lustria">MANAGE ORDERS</h1>
    </x-slot>

        <div class="overflow-x-auto overflow-y-auto max-h-[600px] bg-beige/80 rounded-lg shadow-lg p-4">

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

        <div id="pagination" class="flex justify-center mt-4"></div>

        </div>

    @vite('resources/js/admin-order.js')

</x-admin-layout>
