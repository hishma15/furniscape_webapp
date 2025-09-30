<div class="mt-8">
    <div class="flex space-x-4 mb-6">
        <button wire:click="setTab('orders')" class="px-4 py-2 rounded {{ $activeTab === 'orders' ? 'bg-indigo-600 text-white' : 'bg-gray-200' }}">
            My Orders
        </button>
        <button wire:click="setTab('consultations')" class="px-4 py-2 rounded {{ $activeTab === 'consultations' ? 'bg-indigo-600 text-white' : 'bg-gray-200' }}">
            My Consultations
        </button>
    </div>

    @if ($activeTab === 'orders')
        <h2 class="heading-style mb-4">MY ORDERS</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Delivery Date</th>
                        <th class="border px-4 py-2">Items</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="border px-4 py-2">{{ $order->id }}</td>
                            <td class="border px-4 py-2">$ {{ number_format($order->total_amount) }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                            <td class="border px-4 py-2">{{ $order->delivery_date }}</td>
                            <td class="border px-4 py-2">
                                <details>
                                    <summary class="cursor-pointer hover:underline">View Items</summary>
                                    <table class="mt-2 w-full border text-sm">
                                        <thead>
                                            <tr>
                                                <th class="border px-2 py-1">Product</th>
                                                <th class="border px-2 py-1">Quantity</th>
                                                <th class="border px-2 py-1">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td class="border px-2 py-1">{{ $item->product->product_name }}</td>
                                                    <td class="border px-2 py-1">{{ $item->quantity }}</td>
                                                    <td class="border px-2 py-1">LKR {{ number_format($item->price) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </details>
                            </td>
                            <td class="border px-4 py-2">
                                @if ($order->status === 'pending')
                                    <button wire:click="deleteOrder({{ $order->id }})" class="text-red-600 text-xl" onclick="return confirm('Delete this order?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if ($activeTab === 'consultations')
        <h2 class="heading-style mb-4">MY CONSULTATIONS</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Time</th>
                        <th class="border px-4 py-2">Mode</th>
                        <th class="border px-4 py-2">Topic</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($consultations as $c)
                        <tr>
                            <td class="border px-4 py-2">{{ $c->_id }}</td>
                            <td class="border px-4 py-2">{{ $c->prefered_date }}</td>
                            <td class="border px-4 py-2">{{ $c->prefered_time }}</td>
                            <td class="border px-4 py-2">{{ $c->mode }}</td>
                            <td class="border px-4 py-2">{{ $c->topic }}</td>
                            <td class="border px-4 py-2">{{ $c->description }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($c->status) }}</td>
                            <td class="border px-4 py-2">
                                @if ($c->status === 'pending')
                                    <button 
                                        wire:click.prevent="deleteConsultation('{{ $c->_id }}')" 
                                        onclick="return confirm('Delete this consultation?')"
                                        class="text-red-600 text-xl"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4">No consultations found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>

