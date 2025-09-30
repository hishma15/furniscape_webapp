{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}

@component('mail::message')
# Order Confirmation

Hi {{ $order->customer->name }},

Thank you for your order at FurniScape! Here are your order details:

**Order ID:** {{ $order->id }}  
**Order Date:** {{ $order->order_date->format('M d, Y') }}  
**Total Amount:** ${{ number_format($order->total_amount, 2) }}

@component('mail::table')
| Product       | Quantity | Price  |
| ------------- | -------- | ------ |
@foreach($order->orderItems as $item)
| {{ $item->product->product_name }} | {{ $item->quantity }} | ${{ number_format($item->price_at_purchase, 2) }} |
@endforeach
@endcomponent

We will notify you when your order is shipped.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

