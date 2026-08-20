@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-10">

        <div>

            <h1 class="text-4xl font-bold">

                Order Details

            </h1>

            <p class="text-gray-500 mt-2">

                Order #{{ $order->id }}

            </p>

        </div>

        <a href="/admin/orders"
        class="bg-black text-white px-6 py-3 rounded-xl">

            Back

        </a>

    </div>





    <div class="grid grid-cols-3 gap-8">

        <div class="bg-white rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold mb-5">

                Customer Info

            </h2>

            <p class="mb-3">

                <strong>Name:</strong>
                {{ $order->user->name ?? 'N/A' }}

            </p>

            <p class="mb-3">

                <strong>Email:</strong>
                {{ $order->user->email ?? 'N/A' }}

            </p>

        </div>





        <div class="bg-white rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold mb-5">

                Restaurant

            </h2>

            <p class="mb-3">

                <strong>Name:</strong>
                {{ $order->restaurant->name ?? 'N/A' }}

            </p>

            <p class="mb-3">

                <strong>Order Type:</strong>
                <span class="capitalize font-semibold text-purple-700">{{ str_replace('_', ' ', $order->order_type) }}</span>

            </p>

        </div>

        @if($order->order_type === 'table_book')
        <div class="bg-purple-50 border border-purple-200 rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold text-purple-900 mb-5">

                🪑 Table Reservation

            </h2>

            <p class="mb-2 text-sm text-purple-900">
                <strong>Date:</strong> {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->format('d M Y') : 'N/A' }}
            </p>

            <p class="mb-2 text-sm text-purple-900">
                <strong>Time:</strong> {{ $order->booking_time ? \Carbon\Carbon::parse($order->booking_time)->format('h:i A') : 'N/A' }}
            </p>

            <p class="mb-2 text-sm text-purple-900">
                <strong>Guests:</strong> {{ $order->number_of_people ?? 'N/A' }} Persons
            </p>

            <p class="text-sm text-purple-900">
                <strong>Occasion:</strong> <span class="bg-purple-200 text-purple-800 px-3 py-1 rounded-lg text-xs font-bold">🎉 {{ $order->occasion ?? 'N/A' }}</span>
            </p>

        </div>
        @endif



		
		


        <div class="bg-white rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold mb-5">

                Update Status

            </h2>

            <form method="POST"
            action="{{ route('admin.orders.status',$order->id) }}">

                @csrf

                <select
                name="status"
                class="w-full border rounded-xl p-4">

                    <option
                    value="pending"
                    {{ $order->status == 'pending' ? 'selected' : '' }}>

                        Pending

                    </option>

                    <option
                    value="completed"
                    {{ $order->status == 'completed' ? 'selected' : '' }}>

                        Completed

                    </option>

                    <option
                    value="cancelled"
                    {{ $order->status == 'cancelled' ? 'selected' : '' }}>

                        Cancelled

                    </option>

                </select>

                <button
                class="bg-blue-500 text-white px-8 py-3 rounded-xl mt-5">

                    Update

                </button>

            </form>

        </div>

    </div>

	

	
	



    <div class="bg-white rounded-2xl shadow mt-10 overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-5 text-left">
                        Product
                    </th>

                    <th class="p-5 text-left">
                        Price
                    </th>

                    <th class="p-5 text-left">
                        Qty
                    </th>

                    <th class="p-5 text-left">
                        Total
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($order->items as $item)

                <tr class="border-t">

                    <td class="p-5">

                        {{ $item->product->name ?? '' }}

                    </td>

                    <td class="p-5">

                        £{{ $item->price }}

                    </td>

                    <td class="p-5">

                        {{ $item->quantity }}

                    </td>

                    <td class="p-5 font-bold">

                        £{{ $item->total }}

                    </td>

                </tr>

                @endforeach

            </tbody>

            <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                @php
                    $subtotal = $order->items->sum('total');
                @endphp
                <tr>
                    <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Subtotal</td>
                    <td class="p-4 font-bold text-gray-800">£{{ number_format($subtotal, 2) }}</td>
                </tr>
                @if($order->delivery_charge > 0)
                <tr>
                    <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Delivery Fee</td>
                    <td class="p-4 font-bold text-gray-800">£{{ number_format($order->delivery_charge, 2) }}</td>
                </tr>
                @endif
                @if($order->hyst_charge > 0)
                <tr>
                    <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Hyst Charge</td>
                    <td class="p-4 font-bold text-gray-800">£{{ number_format($order->hyst_charge, 2) }}</td>
                </tr>
                @endif
                @if(($order->offer_discount ?? 0) > 0)
                <tr>
                    <td colspan="3" class="p-4 text-right font-semibold text-orange-600">
                        🎉 Offer Discount
                        @if(!empty($order->offer_title))
                            <span class="text-xs text-amber-700">({{ $order->offer_title }})</span>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-red-600">-£{{ number_format($order->offer_discount, 2) }}</td>
                </tr>
                @endif
                @if($order->coupon_discount > 0)
                <tr>
                    <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Coupon Discount</td>
                    <td class="p-4 font-bold text-red-600">-£{{ number_format($order->coupon_discount, 2) }}</td>
                </tr>
                @endif
                @if($order->gift_card_amount > 0)
                <tr>
                    <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Gift Card</td>
                    <td class="p-4 font-bold text-red-600">-£{{ number_format($order->gift_card_amount, 2) }}</td>
                </tr>
                @endif
                @if(($order->loyalty_discount ?? 0) > 0)
                <tr>
                    <td colspan="3" class="p-4 text-right font-semibold text-amber-700">🎁 Loyalty Reward Discount</td>
                    <td class="p-4 font-bold text-red-600">-£{{ number_format($order->loyalty_discount, 2) }}</td>
                </tr>
                @endif
                <tr class="bg-gray-100 text-lg">
                    <td colspan="3" class="p-5 text-right font-extrabold text-gray-900">Order Total</td>
                    <td class="p-5 font-extrabold text-orange-600">£{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>

        </table>

    </div>

</div>

@endsection