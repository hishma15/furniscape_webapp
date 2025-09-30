<x-admin-layout>
<div class="container mx-auto p-6">

    <x-slot name="header">
        <h1 class="text-3xl font-bold text-black text-center font-lustria">MANAGE CATEGORIES</h1>
    </x-slot>

    <button id="openCreateModal" class="bg-brown text-beige font-bold py-2 px-6 rounded-full mb-6 hover:bg-btn-hover-brown transition">
        Create Category
    </button>

    <div class="overflow-x-auto max-h-[400px] bg-beige/80 rounded-lg shadow-lg p-4">
        <table class="w-full table-auto border-collapse border border-gray-300" id="categoriesTable">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="categoriesBody">
                <!-- Filled by JS -->
            </tbody>
        </table>
        <div id="pagination" class="mt-4 flex justify-center"></div>
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-beige/80 rounded-lg p-8 max-w-3xl shadow-lg relative w-full">
            <h2 id="modalTitle" class="text-2xl font-lustria font-bold mb-6 text-center">Create Category</h2>

            <form id="categoryForm" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" id="categoryId" />
                <input type="text" id="categoryName" placeholder="Category Name" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brown" />
                <textarea id="categoryDesc" placeholder="Category Description"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brown"></textarea>
                <input type="file" id="categoryImage" class="w-full border border-gray-300 rounded px-4 py-2" accept="image/*" />
                <div id="imagePreview" class="mt-2"></div>

                <div class="flex justify-end gap-4">
                    <button type="button" id="cancelBtn"
                        class="bg-gray-300 rounded-full px-6 py-2 hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit" id="saveBtn"
                        class="bg-brown text-beige rounded-full px-6 py-2 hover:bg-btn-hover-brown transition">
                        Save
                    </button>
                </div>
            </form>

            <button id="closeModalBtn"
                class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-3xl font-bold cursor-pointer">&times;</button>
        </div>
    </div>

</div>

@vite('resources/js/admin-categories.js')

</x-admin-layout>

    {{-- <x-slot name="header">
        <h1 class="text-3xl font-bold text-black text-center font-lustria">MANAGE CATEGORIES</h1>
    </x-slot>

    @livewire('admin.manage-categories') --}}

