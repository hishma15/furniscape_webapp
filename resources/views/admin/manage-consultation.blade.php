<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-black text-center font-lustria">MANAGE CONSULTATION</h1>
    </x-slot>

    <div class="p-4 bg-beige/80 rounded-lg shadow-lg max-w-6xl m-2">
        <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Consultation ID</th>
                        <th class="border px-4 py-2">Topic</th>
                        <th class="border px-4 py-2">User ID</th>
                        <th class="border px-4 py-2">Mode</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Preferred Date</th>
                        <th class="border px-4 py-2">Preferred Time</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="consultation-body">
                    <tr>
                        <td colspan="9" class="text-center">Loading....</td>
                    </tr>
                </tbody>
            </table>
            <div id="pagination" class="flex justify-center mt-4"></div>
        </div>
    </div>

    {{-- <script>
        const token = localStorage.getItem('api_token');

        document.addEventListener('DOMContentLoaded', function () {
            axios.get('/api/consultations', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                const consultations = response.data.data;
                const tbody = document.getElementById('consultation-body');
                tbody.innerHTML = '';

                consultations.forEach((item, index) => {
                    tbody.innerHTML += `
                        <tr>
                            <td class="border px-4 py-2">${index + 1}</td>
                            <td class="border px-4 py-2">${item.topic}</td>
                            <td class="border px-4 py-2">${item.customer.name}</td>
                            <td class="border px-4 py-2">${item.mode}</td>
                            <td class="border px-4 py-2">${item.description}</td>
                            <td class="border px-4 py-2">${item.prefered_date}</td>
                            <td class="border px-4 py-2">${item.prefered_time}</td>
                            <td class="border px-4 py-2">${item.status}</td>
                            <td class="border px-4 py-2">
                                ${getActions(item)}
                            </td>
                        </tr>
                    `;
                });
            }).catch(error => {
                console.error(error);
                alert('Failed to load consultations.');
            });
        });

        function getActions(item) {
            const currentStatus = item.status;
            const id = item.id;

            let buttons = '';

            if (currentStatus === 'pending') {
                buttons += `<button onclick="updateStatus('${id}', 'confirmed')" class="bg-blue-500 text-white px-2 py-1 rounded mr-1">Confirm</button>`;
                buttons += `<button onclick="updateStatus('${id}', 'cancelled')" class="bg-red-500 text-white px-2 py-1 rounded">Cancel</button>`;
            } else if (currentStatus === 'confirmed') {
                buttons += `<button onclick="updateStatus('${id}', 'completed')" class="bg-green-600 text-white px-2 py-1 rounded">Mark Completed</button>`;
            }

            return buttons;
        }

        function updateStatus(id, newStatus) {
            const token = localStorage.getItem('api_token');

            axios.put(`/api/consultations/${id}`, {
                status: newStatus
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            .then(res => {
                alert('Status updated!');
                location.reload();
            })
            .catch(err => {
                console.error(err);
                alert('Failed to update status.');
            });
        }
    </script> --}}

    {{-- Include JS --}}
    @vite('resources/js/consultation.js')

</x-admin-layout>
