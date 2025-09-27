<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(session('api_token'))
    <p>Your API Token: {{ session('api_token') }}</p>
@else
    <p>No token found in session.</p>
@endif

    {{-- <p>Token in session: {{ session('api_token') ?? 'No token' }}</p> --}}


    {{-- Category Name --}}
    <h1 class="heading-style" id="category-name"></h1>


<div class="px-6 py-2">
        <label for="categoryFilter" class="font-semibold mr-2">Filter by Category:</label>
        <select id="categoryFilter" class="border border-gray-300 rounded px-3 py-2" 
                data-categories='@json($categories)'>
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Product Lists --}}
    <section id="product-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6">
        {{-- JS will load the poducts --}}
    </section>

    {{-- Pagination --}}
    <div id="pagination" class="flex justify-center mt-6"></div>

    {{-- @vite('resources/js/products.js') --}}
</x-app-layout>

