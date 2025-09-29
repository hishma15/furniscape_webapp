<x-app-layout>

<section class="bg-brown w-full h-screen flex flex-col justify-center px-16 py-12 text-center gap-8 items-start">

    <h2 class="text-3xl font-lustria font-bold mb-6 w-full">
        🎉 Your Order has been placed!
    </h2>

    <p class="text-2xl font-montserrat tracking-wider mb-6 w-full">
        Thank you for shopping with FurniScape!
    </p>

    <a href="{{ route('home') }}" class="bg-beige py-5 px-5 rounded-full font-montserrat font-bold text-black hover:bg-gray-200 transition duration-300 w-auto mx-auto">
        BACK TO HOME
    </a>

    <a href="{{ route('order.invoice', $order_id) }}" 
       class="mt-6 bg-green-600 py-5 px-5 rounded-full font-montserrat font-bold text-white hover:bg-green-700 transition duration-300 w-auto mx-auto">
       Download Invoice PDF
    </a>

</section>


</x-app-layout>
