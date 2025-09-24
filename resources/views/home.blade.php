<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <!-- Banner image -->
    <section class="relative overflow-hidden py-2">
        <img src="{{ asset('images/bannerImage.png') }}" alt="Landing Page Image" class="w-full max-w-none object-cover">
        <!-- CTA Button -->
        <div class="absolute inset-0 flex items-center justify-center z-10">
            <a href="{{ route('products') }}" class="bg-white text-black font-montserrat font-semibold md:py-4 md:px-10 md:mr-6 md:mt-0 mt-4 py-2 px-2 mr-4 2xl:py-6 2xl:px-18 2xl:mr-10 rounded-lg md:text-xl text-sm shadow-lg border-2 border-black hover:bg-beige">BUY NOW</a>
        </div>
    </section>

    <!-- Categories -->
    <section id="categories">
        <h1 class="heading-style">SHOP OUR FURNITURE COLLECTION</h1>
        <div class="flex overflow-x-auto space-x-8 p-5">
            @foreach ($categories as $category)
                <div class="home-category">
                    {{-- <a href="{{ route('category.products', $category->id) }}">
                        <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->category_name }}" class="home-category-img">
                    </a>
                    <a href="{{ route('category.products', $category->id) }}" class="home-category-name">
                        {{ $category->category_name }}
                    </a> --}}
                    <a href="#">
                        <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->category_name }}" class="home-category-img">
                    </a>
                    <a href="#" class="home-category-name">
                        {{ $category->category_name }}
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- signup section -->
    <section class="action-section">
        <img src="{{ asset('images/happyCustomerCheckIn.jpg') }}" alt="Happy cutomer" class="action-img">
        <div class="action-div">
            <h1 class="heading-style">Don't have an account ?</h1>

            <p class="action-p">Join now and enjoy exclusive deals, faster checkout and order tracking</p>

            <a class="action-a" href="{{ route('register') }}">SIGN UP</a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section>
        <h1 class="heading-style">OUR FEATURED PRODUCTS</h1>
        <div class="flex overflow-x-auto space-x-8 p-5">
            @foreach ($featuredProducts as $product)
                <div class="product-div">
                    <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="product-img">
                    <h2 class="product-name">{{ $product->product_name }}</h2>
                    <p class="product-price">$ {{ number_format($product->price, 2) }}</p>
                    <div class="product-div-btn">
                        {{-- <a href="{{ route('product.show', $product->id) }}" class="product-view-btn">View Details</a>
                        <a href="{{ route('cart.add', $product->id) }}" class="product-addtocart-btn">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a> --}}
                        <a href="#" class="product-view-btn">View Details</a>
                        <a href="#" class="product-addtocart-btn">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- FurniScape advantage section -->
    <section class="furniscape-advantage">
        <h1 class="heading-style">THE FURNISCAPE ADVANTAGE</h1>
        <div class="flex flex-wrap justify-center items-center space-x-6 p-5">
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-truck"></i>
                <p>FAST DELIVERY</p>
            </div>
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-building-user"></i>
                <p>24/7 SUPPORT</p>
            </div>
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-award"></i>
                <p>PREMIUM QUALITY</p>
            </div>
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-infinity"></i>
                <p>ENDLESS CHOICE</p>
            </div>
        </div>
    </section>

    {{-- <section class="action-section">
        <img src="{{ asset('images/img3.jpg') }}" alt="Interior design consultation" class="action-img">
        <div class="action-div">
            <h1 class="heading-style">Need expert advice?</h1>
            <p class="action-p">Talk to our design specialists and get personalized recommendations.</p>
            <a class="action-a" href="{{ route('consultation.form') }}">BOOK A CONSULTATION</a>
        </div>
    </section> --}}

    <!-- banner section -->
    <section>
        <img src="{{ asset('images/furniturebanner2.png') }}" alt="Furniscape Banner" class="w-full h-40">
    </section>


</x-app-layout>