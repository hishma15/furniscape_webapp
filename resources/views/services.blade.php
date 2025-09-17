<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Banner image -->
    <section class="overflow-hidden py-2">
        <img src=" {{ asset('images/servicesHeroImage.png') }} " alt="About Us Page Image" class="w-full max-w-none object-cover">
    </section>

    <section class="flex flex-col">
        <div class="flex justify-start">
            <img src="{{ asset('images/service1.png') }}" alt="SERVICE 01" class="w-1/2 h-auto">
        </div>
        <div class="flex justify-end">
            <img src="{{ asset('images/service2.png') }}" alt="SERVICE 02" class="w-1/2 h-auto">
        </div>
        <div class="flex justify-start">
            <img src="{{ asset('images/service3.png') }}" alt="SERVICE 03" class="w-1/2 h-auto">
        </div>
    </section>

    <!-- Book Cosultation section -->
    <section class="action-section">
        <img src="{{ asset('images/img3.jpg') }}" alt="Interior design consultation" class="action-img">
        <div class="action-div">
            <h1 class="heading-style">Need expert advice ?</h1>

            <p class="action-p">Talk to our design specialists and get personalized recommendations.</p>

            <a class="action-a" href="#">BOOK A COSULTATION</a>
        </div>
    </section>

</x-app-layout>