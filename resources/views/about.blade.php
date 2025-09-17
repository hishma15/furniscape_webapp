<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Banner image -->
    <section class="relative overflow-hidden py-2">
        <img src="{{ asset('images/aboutusPageBanner.png') }}" alt="About Us Page Image" class="w-full max-w-none object-cover">
        <div class="absolute md:bottom-15 md:right-30 right-5 bottom-5 flex items-end justify-end p-4 md:p-6">
            <a href="#" class="bg-brown text-center text-beige font-montserrat px-6 py-3 rounded-full shadow-md hover:bg-btnHoverBrown transition inline-block whitespace-nowrap">EXPLORE OUR SERVICES</a>
        </div>

    </section>

    <!-- FurniScape Story -->
    <h1 class="heading-style">OUR STORY</h1>
    <div class="bg-beige mt-5 flex md:flex-row flex-col md:h-56mb-7 p-4">
        <p class="md:w-1/2 text-justify font-montserrat p-5 tracking-wider flex items-center">FurniScape started with a simple idea: every home should feel personal and reflect the people living in it.
        What began as a small project in a garage — selecting and selling quality furniture to friends and family — has now grown into a full online store for stylish, affordable home décor and furniture.
        We saw that most big stores offered the same designs with little personality. We wanted to change that — by curating furniture collections that feel warm, modern, and truly made for everyday living.
        Today, FurniScape continues to help people create homes they love, with pieces that combine comfort, quality, and style.</p>
        <img src="{{ asset('images/storeImage11.jpg') }}" alt="Store Image" class="md:w-1/2 ">
    </div>
    
    <!-- FurniScape mission -->
    <h1 class="heading-style">OUR MISSION</h1>
    <div class="bg-beige mt-5 flex md:flex-row flex-col md:h-[22rem] items-center justify-between p-4">
        <Video controls class="md:w-1/2">
            <Source src=" {{ asset('videos/furnitureStoreVideo.mp4') }}" type="video/mp4"></Source>
        </Video>
        <div class="md:w-1/2 text-left font-montserrat p-5 tracking-wider flex flex-col justify-center space-y-3">
            <p># Crafting quality, lasting furniture made with care.</p>
            <br>
            <p># Providing expert advice to help customers make confident choices.</p>
            <br>
            <p># Ensuring accessibility and elegance for every space, every budget</p>
        </div>
    </div>  

    <!-- FurniScape Gallery -->
    <h1 class="heading-style">FURNISCAPE GALLERY</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-5 mt-5">
        <!-- Large Image: Spans 2 cols and 2 rows on sm and up -->
        <img src="{{ asset('images/img1.jpg') }}" alt="Image 01"
            class="h-full w-full image-gallery-animation md:col-span-2 md:row-span-2" />

        <!-- Wide Image -->
        <img src="{{ asset('images/img2.jpg') }}" alt="Image 02"
            class="h-60 w-full image-gallery-animation md:col-start-3 md:col-end-5 md:row-start-1" />

        <!-- Small Image 1 -->
        <img src="{{ asset('images/img3.jpg') }}" alt="Image 03"
            class="h-60 w-full image-gallery-animation md:col-start-3 md:row-start-2" />

        <!-- Small Image 2 -->
        <img src="{{ asset('images/img4.jpg') }}" alt="Image 04"
            class="h-60 w-full image-gallery-animation md:col-start-4 md:row-start-2" />
    </div>

</x-app-layout>