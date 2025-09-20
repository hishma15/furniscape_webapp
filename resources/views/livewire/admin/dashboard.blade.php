<div class="p-4 text-black">
        <h2 class="text-2xl font-lustria mb-4">Welcome back, {{ Auth::user()->name }}!</h2>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="admin-dashboard-card">
                <h3 class="admin-dashboard-card-title">TOTAL PRODUCTS</h3>
                <p class="text-2xl mt-2">{{ $productsCount }}</p>
            </div>

            <div class="admin-dashboard-card">
                <h3 class="admin-dashboard-card-title">TOTAL ORDERS</h3>
                <p class="text-2xl mt-2">{{ $ordersCount }}</p>
            </div>

            {{-- <div class="admin-dashboard-card">
                <h3 class="admin-dashboard-card-title">CONSULTATION</h3>
                <p class="text-2xl mt-2">{{ $consultationsCount }}</p>
            </div> --}}

            <div class="admin-dashboard-card">
                <h3 class="admin-dashboard-card-title">Consultation Status Breakdown</h3>
                <canvas id="statusChart" height="150"></canvas>
            </div>
        </div>

        <!-- Recent Orders -->
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

        

    </div>

    

{{-- Display pie chart on the dashbaord [shows the consultation status] using Chart.js --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
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
    });
</script>


