<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-brown text-2xl font-montserrat text-beige font-bold py-2 px-7 rounded-full mx-auto block mb-4 cursor-pointer hover:bg-btn-hover-brown']) }}>
    {{ $slot }}
</button>
