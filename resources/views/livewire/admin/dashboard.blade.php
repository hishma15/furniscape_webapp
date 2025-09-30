<div class="text-black">
        {{-- <h2 class="text-2xl font-lustria mb-4">Welcome back, {{ Auth::user()->name }}!</h2> --}}

        <div class="flex gap-4 mb-3">
            <button onclick="showSection('summary')" class="bg-brown text-white px-4 py-2 rounded" id="btn-summary">
                Summary
            </button>
            <button onclick="showSection('details')" class="bg-brown text-white px-4 py-2 rounded" id="btn-details">
                Details
            </button>
        </div>

        <!-- Summary Cards -->
        <div id="summary-section">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="admin-dashboard-card">
                    <h3 class="admin-dashboard-card-title">TOTAL PRODUCTS</h3>
                    <p class="text-2xl mt-2">{{ $productsCount }}</p>
                    <canvas id="productCategoryChart" height="150"></canvas>
                </div>

                <div class="admin-dashboard-card">
                    <h3 class="admin-dashboard-card-title">TOTAL ORDERS</h3>
                    <p class="text-2xl mt-2">{{ $ordersCount }}</p>
                    <canvas id="orderStatusChart" height="150"></canvas>
                </div>

                <div class="admin-dashboard-card">
                    <h3 class="admin-dashboard-card-title">Consultation Status Breakdown</h3>
                    <p class="text-2xl mt-2">{{ $consultationsCount }}</p>
                    <canvas id="statusChart" height="150"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders + Low stock message -->
        <div id="details-section" class="hidden">
            <div class="admin-dashboard-card">
                <h3 class="admin-dashboard-card-title">RECENT ORDERS</h3>
                <table class="w-full table-auto text-left">
                    <thead>
                        <tr class="text-sm text-gray-600 border-b">
                            <th class="py-2">Order ID</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                        <tr class="border-b">
                            <td class="py-2">#{{ $order->id }}</td>
                            <td class="py-2">{{ $order->customer->name ?? 'N/A' }}</td>
                            <td class="py-2">{{ $order->status }}</td>
                            <td class="py-2">${{ $order->total_amount }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 text-center text-gray-500">No recent orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="admin-dashboard-card mt-6">
                <h3 class="admin-dashboard-card-title">LOW STOCK ITEMS</h3>

                <table class="w-full table-auto text-left">
                    <thead>
                        <tr class="text-sm text-gray-600 border-b">
                            <th class="py-2">Product</th>
                            <th class="py-2">Stock Left</th>
                            <th class="py-2">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowStockProducts as $product)
                            <tr class="border-b">
                                <td class="py-2">{{ $product->product_name }}</td>
                                <td class="py-2 text-red-600 font-semibold">{{ $product->no_of_stock }}</td>
                                <td class="py-2">${{ number_format($product->price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-2 text-center text-gray-500">All products are sufficiently stocked.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

{{-- Display pie chart on the dashbaord [shows the consultation status] using Chart.js --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ConsultationStatus pie chart
        // To get the <canvas> element in HTML with ID =statusChart
        const ctx = document.getElementById('statusChart').getContext('2d');

        const data = {
            // Sets the labels on pie chart [pending, confirmed, completed, cancelled] -NOT PRE-ASSIGNED
            labels: @json(array_keys($statusCounts)),
            
            datasets: [{
                label: 'Consultation',
                
                //Provides actual data values for chart
                data: @json(array_values($statusCounts)),
                backgroundColor: [
                    '#f87171', // red for cancelled
                    '#fbbf24', // yellow for pending
                    '#34d399', // green for confirmed
                    '#60a5fa', // blue for completed
                ],
                borderWidth: 1
            }]
        };

        // Creates and renders a new pie chart using the data
        new Chart(ctx, {
            type: 'pie',
            data: data
        });


        // Order Statu Pie Chart
        const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
        const orderData = {
            labels: @json(array_keys($orderStatusCounts)),
            datasets: [{
                label: 'Orders',
                data: @json(array_values($orderStatusCounts)),
                backgroundColor: [
                    '#38bdf8', // sky blue
                    '#34d399', // green
                    '#fbbf24', // yellow
                    '#ef4444', // red
                    '#a78bfa', // purple
                ],
                borderWidth: 1
            }]
        };
        new Chart(orderCtx, { type: 'pie', data: orderData });

        // Product Chart according to the category
        const productCtx = document.getElementById('productCategoryChart').getContext('2d');
        const productCategoryData = {
            labels: @json(array_keys($productCategoryCounts)),
            datasets: [{
                label: 'Products by Category',
                data: @json(array_values($productCategoryCounts)),
                backgroundColor: [
                    '#4ade80', // green
                    '#60a5fa', // blue
                    '#facc15', // yellow
                    '#f472b6', // pink
                    '#a78bfa', // purple
                    '#f87171', // red
                    '#34d399', // teal
                ],
                borderWidth: 1
            }]
        };
        new Chart(productCtx, {
            type: 'pie',
            data: productCategoryData
        });

    });
</script>

<script>
    function showSection(section) {
        const summary = document.getElementById('summary-section');
        const details = document.getElementById('details-section');

        if (section === 'summary') {
            summary.classList.remove('hidden');
            details.classList.add('hidden');
        } else {
            summary.classList.add('hidden');
            details.classList.remove('hidden');
        }

        // Optional: Update button styles to show active tab
        document.getElementById('btn-summary').classList.toggle('bg-brown', section === 'summary');
        document.getElementById('btn-summary').classList.toggle('bg-gray-400', section !== 'summary');

        document.getElementById('btn-details').classList.toggle('bg-brown', section === 'details');
        document.getElementById('btn-details').classList.toggle('bg-gray-400', section !== 'details');
    }
</script>



