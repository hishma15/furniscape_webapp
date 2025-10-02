<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-black text-center font-lustria">MANAGE USERS</h1>
    </x-slot>

    <div class="ml-2 p-4 bg-beige/80 rounded-lg shadow-lg max-w-7xl m-2">

        @if (session('success'))
            <div class="text-green-700 bg-green-100 font-semibold p-2">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="text-red-700 bg-red-100 font-semibold p-2">{{ session('error') }}</div>
        @endif

        <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Phone</th>
                        <th class="border px-4 py-2">Address</th>
                        <th class="border px-4 py-2">Role</th>
                        <th class="border px-4 py-2">Orders</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    {{-- Rows will be injected by JS --}}
                </tbody>
            </table>
        </div>

        <div id="pagination" class="mt-4 flex justify-center space-x-2">
            {{-- Pagination buttons will be injected here --}}
        </div>
    </div>    

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            const token = localStorage.getItem('admin_api_token');
            if (!token) {
                alert('No admin token found! Please login.');
                return;
            }
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            

            loadUsers();
        });

        let currentPage = 1;

        function loadUsers(page = 1) {
            currentPage = page;
            axios.get(`/api/users?page=${page}`)
                .then(response => {
                    const resData = response.data;
                    const users = resData.data || resData;
                    const meta = resData.meta || {};

                    const tbody = document.getElementById('users-table-body');
                    tbody.innerHTML = '';

                    users.forEach(user => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="border px-4 py-2">${user.id}</td>
                            <td class="border px-4 py-2">${user.email}</td>
                            <td class="border px-4 py-2">${user.name || ''}</td>
                            <td class="border px-4 py-2">${user.phone_no || ''}</td>
                            <td class="border px-4 py-2">${user.address || ''}</td>
                            <td class="border px-4 py-2 capitalize">${user.role}</td>
                            <td class="border px-4 py-2">${user.orders_count || 0}</td>
                            <td class="border px-4 py-2">
                                <button 
                                    onclick="deleteUser(${user.id})" 
                                    class="text-red-600 px-4 py-2 rounded-full font-semibold border-red-500 border-2 hover:bg-red-500 hover:text-white">
                                    Delete
                                </button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });

                    renderPagination(meta);
                })
                .catch(error => {
                    alert('Failed to fetch users');
                    console.error(error);
                });
        }

        function renderPagination(meta) {
            const paginationContainer = document.getElementById('pagination');
            paginationContainer.innerHTML = '';

            if (!meta || meta.last_page <= 1) return; // No pagination needed

            for (let page = 1; page <= meta.last_page; page++) {
                const btn = document.createElement('button');
                btn.textContent = page;
                btn.className = `mx-1 px-3 py-1 rounded ${page === meta.current_page ? 'bg-brown text-white' : 'bg-gray-200 hover:bg-gray-400'}`;
                if (page !== meta.current_page) {
                    btn.addEventListener('click', () => loadUsers(page));
                } else {
                    btn.disabled = true;
                }
                paginationContainer.appendChild(btn);
            }
        }

        function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user?')) return;

            axios.delete(`/api/users/${userId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                alert(response.data.message || 'User Deleted');
                loadUsers(currentPage);  // Reload current page after delete
            })
            .catch(error => {
                if (error.response && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert('Something went wrong.');
                }
            });
        }
    </script>

</x-admin-layout>
