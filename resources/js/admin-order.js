import axios from "axios";

// Set token from localStorage
const token = localStorage.getItem('admin_api_token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
} else {
    console.warn('No auth token found, requests will be unauthenticated');
}

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('order-body');

    // GET orders with pagination
    async function fetchOrders(page = 1) {
        try {
            const response = await axios.get(`/api/orders?page=${page}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = response.data;
            renderOrders(data.data);
            renderPagination(data.meta);

        } catch (error) {
            console.error("Failed to fetch orders:", error);
            tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-red-500">Failed to load orders</td></tr>`;
        }
    }

    function renderOrders(orders) {
        tableBody.innerHTML = '';
        orders.forEach(order => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-4 py-2">${order.id}</td>
                <td class="border px-4 py-2">${order.customer.name}</td>
                <td class="border px-4 py-2">${order.home_no}, ${order.street}, ${order.city}</td>
                <td class="border px-4 py-2">${order.total_amount}</td>
                <td class="border px-4 py-2">
                    ${order.payment?.status || 'unpaid'} <br>
                    <small>${order.payment?.payment_method || ''}</small>
                </td>
                <td class="border px-4 py-2">
                    <select data-id=${order.id} class="status-dropdown"> 
                        ${['pending','processing','shipped','cancelled','delivered'].map(status => 
                            `<option value="${status}" ${order.status === status ? 'selected' : ''}>${status}</option>`
                        ).join('')}
                    </select>
                </td>
                <td class="border px-4 py-2">
                    <input type="date" value="${order.delivery_date || ''}" data-id="${order.id}" class="delivery-date" />
                </td>
                <td class="border px-4 py-2">
                    <details><summary>View Ordered Items</summary>
                        <ul>${order.order_items.map(item => `
                            <li>
                                ${(item.product?.product_name || 'Unknown Product')} x ${item.quantity} - $${item.price_at_purchase}
                            </li>
                        `).join('')}</ul>
                    </details>
                </td>
                <td class="border px-4 py-2">
                    <button data-id="${order.id}" class="update-btn bg-brown text-white px-4 py-2 rounded">Update</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        addEventListeners();
    }

    //  PUT to update order
    function addEventListeners() {
        document.querySelectorAll('.update-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = this.dataset.id;
                const status = document.querySelector(`.status-dropdown[data-id="${id}"]`).value;
                const deliveryDate = document.querySelector(`.delivery-date[data-id="${id}"]`).value;

                try {
                    await axios.put(`/api/orders/${id}`, {
                        status,
                        delivery_date: deliveryDate
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    // alert('Order updated!');
                    showNotification('Order updated successfully.', 'success');
                    fetchOrders(); // Optionally refresh the data

                } catch (error) {
                    console.error('Update failed:', error.response?.data || error.message);
                    alert(`Update failed: ${error.response?.data?.message || error.message}`);
                }
            });
        });
    }

    //  Pagination rendering
    function renderPagination(meta) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        for (let page = 1; page <= meta.last_page; page++) {
            const btn = document.createElement('button');
            btn.textContent = page;
            btn.className = `mx-1 px-3 py-1 rounded ${page === meta.current_page ? 'bg-brown text-white' : 'bg-gray-200 hover:bg-gray-300'}`;
            btn.addEventListener('click', () => {
                fetchOrders(page); // works now
            });
            pagination.appendChild(btn);
        }
    }

    // Initial load
    fetchOrders();
});
