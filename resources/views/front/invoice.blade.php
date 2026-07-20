@extends('layouts.app')

@section('content')

<style>

@media print {

    .no-print {
        display:none !important;
    }

    body {
        background:white !important;
    }

}

</style>


@if(auth()->id() != $order->user_id)

<div class="min-h-[70vh] flex items-center justify-center px-4">

    <div class="max-w-md w-full bg-white shadow-xl rounded-2xl p-10 text-center">

        <div class="w-20 h-20 mx-auto rounded-full bg-red-100 flex items-center justify-center mb-6">
            <i data-lucide="shield-alert" class="w-10 h-10 text-red-600"></i>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-3">
            Access Denied
        </h1>

        <p class="text-gray-600 leading-7 mb-8">
            You are not authorized to access this invoice.
            Please ensure you are logged in with the correct account.
        </p>

        <a href="/"
            class="inline-flex items-center gap-2 bg-[#C25A2A] hover:bg-[#a94d23] text-white px-6 py-3 rounded-xl font-semibold transition">

            <i data-lucide="home"></i>

            Go to Home

        </a>

    </div>

</div>

<script>
    lucide.createIcons();
</script>

@php
    return;
@endphp

@endif

<div class="max-w-6xl mx-auto p-3 sm:p-5 lg:p-8">

    <div class="mb-5 no-print">
        <a href="/my-orders/{{ $order->id }}"
            class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-lg">
            <i data-lucide="arrow-left"></i>
            Back to Order
        </a>
    </div>

    <div class="bg-white rounded-xl lg:rounded-2xl shadow-lg overflow-hidden">

        <!-- Header -->
        <div class="bg-[#C25A2A] text-white p-5 md:p-8">

            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <!-- Left -->
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold">
                        HYST
                    </h1>

                    <p class="text-sm md:text-base">
                        Customer Invoice
                    </p>
                </div>

                <!-- Center -->
                <div class="text-center">

                    @if(!empty($order->restaurant->image))
                        <img
                            src="{{ asset('storage/'.$order->restaurant->image) }}"
                            alt="{{ $order->restaurant->name }}"
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover mx-auto mb-2 border-2 border-white">
                    @endif

                    <h3 class="font-bold text-lg md:text-xl break-words">
                        {{ $order->restaurant->name }}
                    </h3>

                </div>

                <!-- Right -->
                <div class="text-center md:text-right">

                    <h2 class="text-2xl font-bold">
                        Invoice
                    </h2>

                    <p class="text-lg">
                        {{ $order->invoice->invoice_number ?? 'N/A' }}
                    </p>

                </div>

            </div>

        </div>

        <div class="p-4 md:p-8">

            <!-- Cards -->

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">

                <!-- Customer -->

                <div class="bg-gray-50 rounded-xl p-5">

                    <h3 class="font-bold text-lg mb-4">
                        Customer Details
                    </h3>

                    <p class="break-words">
                        <strong>Name:</strong>
                        {{ $order->user->name }}
                    </p>

                    <p class="break-words">
                        <strong>Phone:</strong>
                        {{ $order->phone }}
                    </p>

                    <p class="break-words">
                        <strong>Address:</strong>
                        {{ $order->address }}
                    </p>

                    <p class="break-words">
                        <strong>Postcode:</strong>
                        {{ $order->pincode }}
                    </p>

                </div>

                <!-- Restaurant -->

                <div class="bg-gray-50 rounded-xl p-5">

                    <h3 class="font-bold text-lg mb-4">
                        Restaurant Details
                    </h3>

                    <p class="break-words">
                        <strong>Name:</strong>
                        {{ $order->restaurant->name }}
                    </p>

                    <p class="break-words">
                        <strong>Phone:</strong>
                        {{ $order->restaurant->phone }}
                    </p>

                    <p class="break-words">
                        <strong>Location:</strong>
                        {{ $order->restaurant->location }}
                    </p>

                </div>

                <!-- Invoice -->

                <div class="bg-gray-50 rounded-xl p-5">

                    <h3 class="font-bold text-lg mb-4">
                        Invoice Details
                    </h3>

                    <p>
                        <strong>Invoice:</strong>
                        {{ $order->invoice->invoice_number }}
                    </p>

                    <p>
                        <strong>Order ID:</strong>
                        #{{ $order->id }}
                    </p>

                    <p>
                        <strong>Date:</strong>
                        {{ optional($order->invoice->invoice_date)->format('d M Y h:i A') }}
                    </p>

                    <p>
                        <strong>Payment:</strong>
                        {{ $order->payment_method }}
                    </p>

                    <p>
                        <strong>Status:</strong>
                        {{ ucfirst($order->status) }}
                    </p>

                </div>

            </div>

            <!-- Products -->

            <div class="overflow-x-auto rounded-xl border">

                <table class="min-w-full">

                    <thead>

                    <tr class="bg-gray-100">

                        <th class="px-4 py-3 text-left">
                            Product
                        </th>

                        <th class="px-4 py-3 text-center">
                            Qty
                        </th>

                        <th class="px-4 py-3 text-center">
                            Price
                        </th>

                        <th class="px-4 py-3 text-center">
                            Total
                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($order->items as $item)

                        <tr class="border-t">

                            <td class="px-4 py-3 break-words">
                                {{ $item->product->name ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->quantity }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                £{{ number_format($item->price,2) }}
                            </td>

                            <td class="px-4 py-3 text-center font-semibold">
                                £{{ number_format($item->total,2) }}
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            <!-- Totals -->

            <div class="mt-8 flex justify-end">

                <div class="w-full md:w-96">

                    <div class="flex justify-between py-2">
                        <span>Subtotal</span>
                        <span>£{{ number_format($order->invoice->subtotal,2) }}</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span>Discount</span>
                        <span>-£{{ number_format($order->invoice->discount,2) }}</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span>Service Charge</span>
                        <span>£{{ number_format($order->service_charge,2) }}</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span>Delivery Charge</span>
                        <span>£{{ number_format($order->delivery_charge,2) }}</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span>HYST Charge</span>
                        <span>£{{ number_format($order->hyst_charge,2) }}</span>
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between text-xl md:text-2xl font-bold text-orange-600">

                        <span>Total</span>

                        <span>
                            £{{ number_format($order->total_amount,2) }}
                        </span>

                    </div>

                </div>

            </div>

            <!-- Footer -->

            <div class="mt-10 pt-8 border-t text-center">

                <h3 class="font-bold text-lg md:text-2xl text-orange-600 mb-2">
                    Thank You For Ordering With HYST
                </h3>

                <p class="text-gray-600">
                    This invoice serves as proof of purchase.
                </p>

                <p class="text-gray-500 mt-2">
                    Invoice Generated On:
                    {{ now()->format('d M Y h:i A') }}
                </p>

            </div>

            <!-- Buttons -->

            <div class="mt-8 flex flex-col sm:flex-row gap-4 no-print">

                <button
                    onclick="window.print()"
                    class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg">

                    Print / Save PDF

                </button>

                <a
                    href="{{ route('restaurant.orders.show',$order->id) }}"
                    class="w-full sm:w-auto text-center bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg">

                    Back

                </a>

            </div>

        </div>

    </div>

</div>

@endsection