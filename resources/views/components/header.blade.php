<header class="header-back">
    <!-- Top welcome /Profile bar -->
    <div class="bg-background-gray max-w-7xl mx-auto px-4 py-1 flex justify-between items-center">
        <div class="text-lg font-semibold text-black">
            @auth
                Welcome, {{ Auth::user()->name }}!
            @else
                Welcome to FurniScape!
            @endauth
        </div>

        <div class="flex md:flex-row flex-col gap-2">
            @auth
                <a href="#" class="bg-brown hover:bg-btn-hover-brown text-beige font-semibold py-2 px-4 mr-3 rounded transition">
                    My Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Logo & Navigation Grid -->
    <div class="container mx-auto grid grid-cols-3 grid-rows-2 gap-2 item-center relative">

        <!-- Logo -->
        <div class="row-span-2 flex item-center">
            <a href="#">
                <img src="{{ asset('images/logoPNG.png') }}" alt="FurniScape Logo" style="height: 120px;" class="w-auto">
            </a>
        </div>

        <!-- Navigation -->
        <nav class="col-span-1 flex justify-center items-center py-3.5">
            <ul id="navLinks" class="hidden md:flex flex-col md:flex-row md:space-x-8 md:static md:w-auto absolute top-20 right-4 w-72 bg-beige md:bg-transparent shadow-lg md:shadow-none rounded-md md:rounded-none p-4 md:p-0 space-y-4 md:space-y-0 z-30">
                <li><a href="{{ route('home') }}" class="hover:underline">HOME</a></li>
                <li class="relative group">
                    <a href="#" class="hover:underline flex items-center gap-1">
                        CATEGORIES <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <ul class="absolute left-0 mt-2 w-60 bg-beige border-brown-1 shadow-lg rounded-md text-black text-sm hidden group-hover:block md:group-hover:block z-40 group-focus-within:block">
                        @foreach ($categories as $category)
                            <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer z-40">
                                <a href="#">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('about') }}" class="hover:underline whitespace-nowrap">ABOUT US</a></li>
                <li><a href="{{ route('services') }}" class="hover:underline">SERVICES</a></li>
            </ul>

            <!-- Hamburger -->
            <button id="menuBar" class="md:hidden text-2xl absolute top-4 right-4">
                <i class="fa-solid fa-bars" id="menuIcon"></i>
            </button>
        </nav>

        <!-- Search bar -->
        <form action="#" method="GET" class="md:col-start-2 md:row-start-2 col-start-2 row-start-1 hidden justify-center items-center space-x-6" id="searchBar">
            <input type="search" name="search" placeholder="Search our furniture collection..." class="w-full px-4 py-2 border border-black rounded-full focus:outline-none focus:ring-2 focus:ring-black bg-background-gray">
            <button class="btn bg-black text-beige py-2 px-4 rounded-full font-montserrat font-light" type="submit">Search</button>
        </form>

        <!-- Icons -->
        <div class="col-start-3 row-start-2 flex justify-end items-center space-x-6 text-3xl">
            <a href="#" title="SEARCH FOR PRODUCTS" id="searchIcon"><i class="fa-solid fa-magnifying-glass"></i></a>
            <a href="#" title="MY CART"><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="{{ route('login') }}" title="LOGIN/ REGISTER"><i class="fa-solid fa-user"></i></a>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            const searchIcon = document.querySelector('#searchIcon');
            const searchBar = document.querySelector('#searchBar');
            const menuBar = document.querySelector('#menuBar');
            const navLinks = document.querySelector('#navLinks');
            const menuIcon = document.querySelector('#menuIcon');
            const categoryMenu = document.querySelector('.group > a');
            const dropdown = document.querySelector('.group ul');

            let isMenuOpen = false;

            if (searchIcon && searchBar){
                searchIcon.addEventListener('click',() => {
                    searchBar.classList.toggle('hidden');
                    searchBar.classList.toggle('flex');
                });
            }

            if (menuBar && navLinks){
                menuBar.addEventListener('click', () => {
                    isMenuOpen = !isMenuOpen;
                    navLinks.classList.toggle('hidden');
                    navLinks.classList.toggle('flex');

                    if(isMenuOpen){
                        menuIcon.classList.remove('fa-bars');
                        menuIcon.classList.add('fa-xmark');
                    } else {
                        menuIcon.classList.remove('fa-xmark');
                        menuIcon.classList.add('fa-bars');
                    }
                });
            }

            if (categoryMenu && dropdown) {
                categoryMenu.addEventListener('click', (e) => {
                    if (window.innerWidth < 768) {
                        e.preventDefault();
                        dropdown.classList.toggle('hidden');
                    }
                });
            }
        });
    </script>

</header>