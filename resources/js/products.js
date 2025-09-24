import axios from "axios";

import { generateApiToken } from './auth';

const baseUrl = window.location.origin;

function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    const value = urlParams.get(param);

    // 
     return value === '' ? null : value;
}

function updateCategoryHeading(categoryId, categories) {
    const heading = document.getElementById('category-name');
    if (!categoryId) {
        heading.textContent = 'All Products';
        return;
    }

    const category = categories.find(cat => String(cat.id) === String(categoryId));
    heading.textContent = category ? category.category_name : 'All Products';
}


document.addEventListener('DOMContentLoaded', async () => {

    const isLoggedIn = document.body.dataset.loggedIn === 'true';

    if (isLoggedIn) {
        await generateApiToken();
    }

    const categoryFilter = document.getElementById('categoryFilter');
    const categories = JSON.parse(categoryFilter.dataset.categories);

    const selectedCategoryId = getQueryParam('category_id') || '';
    updateCategoryHeading(selectedCategoryId, categories);
    loadProducts(1, selectedCategoryId);

    if (categoryFilter) {
        categoryFilter.value = selectedCategoryId;
        categoryFilter.addEventListener('change', () => {
            const selected = categoryFilter.value;
            window.location.href = `/products?category_id=${selected}`;
        });
    }

});


function loadProducts(page = 1, categoryId = '') {
    const container = document.getElementById('product-container');
    const pagination = document.getElementById('pagination');

    const token = localStorage.getItem('api_token');
    console.log('Using token:', token);

    axios.get('/api/products', {
        params: {
            page: page,
            category_id: categoryId
        }
    }). then(response => {
        const products = response.data.data;
        const meta = response.data.meta;

        // Clearing existing
        container.innerHTML = '';
        if (products.length === 0) {
            container.innerHTML = `<p class="text-center tracking-wider text-2xl font-montserrat col-span-full text-gray-500">No products found.</p>`;
        } else {
            products.forEach(product => {
                container.innerHTML += generateProductsCard(product);
            });
        }

        renderPagination(meta, categoryId);
    }) .catch(error => {
        console.error('Failed to load products:', error);
        const container = document.getElementById('product-container');
        container.innerHTML = `<p class="text-center tracking-wider text-2xl font-montserrat col-span-full text-gray-500">Products Loading....</p>`;
    });

    
}



function generateProductsCard(product) {

    const imageUrl = product.product_image 
        ? `${baseUrl}/storage/${product.product_image}`  // "http://localhost:8000/products/yourimage.png"
        : `${baseUrl}/images/default.jpg`;  // fallback image

    return `
        <div class="product-div">
            <img src="${imageUrl}" alt="${product.product_name}" class="product-img">
            <h2 class="product-name">${product.product_name}</h2>
            <P class="product-price">LKR ${Number(product.price).toFixed(2)}</P>
            <div class="product-div-btn">
                <button class="product-view-btn">View Details</button>
                <a class="product-addtocart-btn" href=""><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
        </div>
    `;
}

// function renderPagination(meta, category_id = '') {
//     const pagination = document.getElementById('pagination');
//     pagination.innerHTML = '';

//     for (let page = 1; page <= meta.last_page; page++) {
//         const btn = document.createElement('button');
//         btn.textContent = page;
//         btn.className = `mx-1 px-3 py-1 rounded ${page === meta.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200'}`;
//         btn.addEventListener('click', () => loadProducts(page, categoryId));
//         pagination.appendChild(btn);
//     }

// }

function renderPagination(meta, categoryId = '') {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    for (let page = 1; page <= meta.last_page; page++) {
        const btn = document.createElement('button');
        btn.textContent = page;
        btn.className = `mx-1 px-3 py-1 rounded ${page === meta.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200'}`;
        btn.addEventListener('click', () => loadProducts(page, categoryId));
        pagination.appendChild(btn);
    }
}
