@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block mt-1 w-full h-1/2 rounded-full border border-gray-300 focus:border-brown focus:ring focus:ring-brown/50']) !!}>
