import axios from "axios";

document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('admin_api_token');
    if (!token) {
        alert('No admin token found! Please login.');
        return;
    }
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    const modal = document.getElementById('categoryModal');
    const openCreateModalBtn = document.getElementById('openCreateModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    const form = document.getElementById('categoryForm');
    const modalTitle = document.getElementById('modalTitle');

    const categoryIdInput = document.getElementById('categoryId');
    const categoryNameInput = document.getElementById('categoryName');
    const categoryDescInput = document.getElementById('categoryDesc');
    const categoryImageInput = document.getElementById('categoryImage');
    const imagePreview = document.getElementById('imagePreview');

    const categoriesBody = document.getElementById('categoriesBody');
    const paginationContainer = document.getElementById('pagination');

    let editingCategoryId = null;
    let currentPage = 1;

    function openModal(edit = false, category = null) {
        modal.classList.remove('hidden');
        if (edit && category) {
            modalTitle.textContent = 'Edit Category';
            categoryIdInput.value = category.id ?? '';
            categoryNameInput.value = category.category_name ?? '';
            categoryDescInput.value = category.category_desc ?? '';
            // Show existing image preview if exists
            if (category.category_image) {
                imagePreview.innerHTML = `<img src="/storage/${category.category_image}" alt="Category Image" class="w-[100px] h-[100px] object-cover rounded" />`;
            } else {
                imagePreview.innerHTML = '';
            }
            editingCategoryId = category.id;
        } else {
            modalTitle.textContent = 'Create Category';
            form.reset();
            imagePreview.innerHTML = '';
            editingCategoryId = null;
            categoryIdInput.value = '';
        }
        // Clear file input always on open
        categoryImageInput.value = '';
    }

    function closeModal() {
        modal.classList.add('hidden');
        form.reset();
        imagePreview.innerHTML = '';
        editingCategoryId = null;
        categoryImageInput.value = '';
    }

    openCreateModalBtn.addEventListener('click', () => openModal(false));
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    categoryImageInput.addEventListener('change', () => {
        const file = categoryImageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="w-[100px] h-[100px] object-cover rounded" />`;
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.innerHTML = '';
        }
    });

    async function loadCategories(page = 1) {
        try {
            currentPage = page;
            const res = await axios.get(`/api/categories?page=${page}`);
            const categories = res.data.data;
            const meta = res.data.meta;

            categoriesBody.innerHTML = '';
            categories.forEach(category => {
                categoriesBody.innerHTML += `
                    <tr>
                        <td class="border px-4 py-2">${category.category_name}</td>
                        <td class="border px-4 py-2">${category.category_desc || ''}</td>
                        <td class="border px-4 py-2">
                            ${
                                category.category_image 
                                ? `<img src="/storage/${category.category_image}" alt="Category Image" class="w-[150px] h-[150px] object-cover rounded" />`
                                : 'No image'
                            }
                        </td>
                        <td class="border px-4 py-2 space-x-2 flex flex-row justify-between items-center">
                            <button data-id="${category.id}" class="edit-btn bg-brown text-beige px-3 py-1 rounded-full hover:bg-btn-hover-brown transition">Edit</button>
                            <button data-id="${category.id}" class="delete-btn text-red-600 border border-red-500 px-3 py-1 rounded-full hover:bg-red-500 hover:text-white transition">Delete</button>
                        </td>
                    </tr>
                `;
            });

            // Pagination buttons
            paginationContainer.innerHTML = '';
            for (let page = 1; page <= meta.last_page; page++) {
                const btn = document.createElement('button');
                btn.textContent = page;
                btn.className = `mx-1 px-3 py-1 rounded ${page === meta.current_page ? 'bg-brown text-white' : 'bg-gray-200'}`;
                btn.addEventListener('click', () => loadCategories(page));
                paginationContainer.appendChild(btn);
            }

            // Add event listeners for edit/delete buttons
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    try {
                        const catRes = await axios.get(`/api/categories/${id}`);
                        // Check if data is wrapped inside "data"
                        const categoryData = catRes.data.data ?? catRes.data;
                        openModal(true, categoryData);
                    } catch(err) {
                        alert('Failed to fetch category details.');
                        console.error(err);
                    }
                });
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    if (confirm('Are you sure you want to delete this category?')) {
                        try {
                            await axios.delete(`/api/categories/${id}`);
                            alert('Category deleted successfully.');
                            loadCategories(currentPage);
                        } catch (err) {
                            alert('Failed to delete category.');
                            console.error(err);
                        }
                    }
                });
            });

        } catch (error) {
            console.error(error);
            alert('Failed to load categories. Please check your server and API.');
        }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('category_name', categoryNameInput.value.trim());
        formData.append('category_desc', categoryDescInput.value.trim());

        if (categoryImageInput.files[0]) {
            formData.append('category_image', categoryImageInput.files[0]);
        }

        try {
            if (editingCategoryId) {
                // Update
                await axios.post(`/api/categories/${editingCategoryId}`, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                    params: { _method: 'PUT' }, // Laravel expects PUT, but formData needs to spoof
                });
                alert('Category updated successfully.');
            } else {
                // Create
                await axios.post('/api/categories', formData, { headers: { 'Content-Type': 'multipart/form-data' } });
                alert('Category created successfully.');
            }
            closeModal();
            loadCategories(currentPage);
        } catch (error) {
            if (error.response && error.response.data.errors) {
                let messages = Object.values(error.response.data.errors).flat().join('\n');
                alert('Validation failed:\n' + messages);
            } else if (error.response && error.response.data.message) {
                alert('Error: ' + error.response.data.message);
            } else {
                alert('Something went wrong.');
            }
            console.error(error);
        }
    });

    // Load first page on start
    loadCategories();
});