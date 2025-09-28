import axios from "axios";

// axios.defaults.withCredentials = true;

// // Get the token from localStorage (or storage method)
const token = localStorage.getItem('admin_api_token');

if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
} else {
  console.warn('No auth token found, requests will be unauthenticated');
}

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('order-body');

    async function fetchOrders() {
        // const token = document.querySelector('meta[name="api-token"]').getAttribute('content');
        // const token = window.api_token;
        const response = await axios('/api/orders', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        const data = response.data;
        renderOrders(data.data);
        console.log("Token - ", token);
    }

    function renderOrders(orders) {
        tableBody.innerHTML = '';
        orders.forEach(order => {
            console.log("Order:", order); 
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
                        ${['pending','processing','shipped','cancelled', 'delivered'].map(status => 
                            `<option value="${status}" ${order.status === status ? 'selected' : ''}>${status}</option>`).join('')
                        }
                    </select>
                </td>
                <td class="border px-4 py-2">
                        <input type="date" value="${order.delivery_date || ''}" data-id="${order.id}" class="delivery-date" />
                </td>
                <td class="border px-4 py-2">
                    <details><summary> View Ordered Items</summary>
                        <ul>${order.order_items.map(item => `
                            <li>
                                ${(item.product?.product_name || 'Unknown Product')} x ${item.quantity} - $ ${item.price_at_purchase}
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

        addEventListener();
    }

    function addEventListener() {
        document.querySelectorAll('.update-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                try {
                    const id = this.dataset.id;
                    const status = document.querySelector(`.status-dropdown[data-id="${id}"]`).value; 
                    const deliveryDate = document.querySelector(`.delivery-date[data-id="${id}"]`).value;

                    // const token = document.querySelector('meta[name="api-token"]').getAttribute('content');
                    const token = localStorage.getItem('admin_api_token');
                    await axios(`/api/orders/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        },
                        data: { status, delivery_date: deliveryDate }
                    });


                    alert('Order updated!');
                }  catch (error) {
                    console.error('Update failed:', error.response?.data || error.message);
                    alert(`Update failed: ${error.response?.data?.message || error.message}`);
                } 
            });
        });
    }

    fetchOrders();
});

