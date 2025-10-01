<x-admin-layout>
    <div id="notification" class="hidden p-3 rounded mt-4"></div>
    
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

    @vite('resources/js/admin-consultation.js')

</x-admin-layout>
