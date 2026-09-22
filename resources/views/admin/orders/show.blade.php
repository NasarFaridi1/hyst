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

        <!-- Uber Direct Delivery Management Card -->
        <div class="bg-white rounded-2xl shadow p-8 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="bg-black text-white px-2 py-0.5 rounded text-xs font-black">UBER</span> Direct
                </h2>
                @if($order->uber_delivery_status)
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full capitalize">
                        {{ str_replace('_', ' ', $order->uber_delivery_status) }}
                    </span>
                @endif
            </div>

            @if($order->uber_delivery_id)
                <p class="text-xs text-gray-500 mb-2">
                    <strong>Delivery ID:</strong> <br><span class="font-mono text-gray-700 bg-gray-100 px-1 py-0.5 rounded text-xs">{{ $order->uber_delivery_id }}</span>
                </p>
                @if($order->uber_driver_name)
                    <p class="text-xs text-gray-600 mb-1"><strong>Courier:</strong> {{ $order->uber_driver_name }} ({{ $order->uber_driver_phone ?? 'N/A' }})</p>
                @endif
                <div class="mb-4 flex items-center justify-between gap-2">
                    @if($order->uber_tracking_url)
                        <a href="{{ $order->uber_tracking_url }}" target="_blank" class="inline-block text-xs text-blue-600 hover:underline font-semibold">
                            🔗 Live Courier Tracking ↗
                        </a>
                    @else
                        <span></span>
                    @endif
                    <form method="POST" action="{{ route('admin.orders.uber.refresh', $order->id) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs px-2.5 py-1 rounded-lg font-semibold border transition" title="Fetch latest status from Uber API">
                            🔄 Refresh
                        </button>
                    </form>
                </div>

                <!-- Actions: Update Dropoff Notes -->
                <form method="POST" action="{{ route('admin.orders.uber.update', $order->id) }}" class="mb-4 pt-3 border-t border-gray-100">
                    @csrf
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Update Dropoff Notes</label>
                    <div class="flex gap-2">
                        <input type="text" name="dropoff_notes" value="{{ $order->dropoff_notes }}" placeholder="e.g. Leave at front door" class="w-full text-xs border rounded-lg px-3 py-2">
                        <button type="submit" class="bg-black text-white text-xs font-medium px-3 py-2 rounded-lg hover:bg-gray-800">Save</button>
                    </div>
                </form>

                <!-- Actions: Request Refund -->
                <form method="POST" action="{{ route('admin.orders.uber.refund', $order->id) }}" onsubmit="return confirm('Submit refund request to Uber for this delivery?');" class="pt-3 border-t border-gray-100">
                    @csrf
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Uber Refund Request</label>
                    <div class="flex items-center gap-2">
                        <select name="reason" class="text-xs border rounded-lg p-2 w-full">
                            <option value="damaged_items">Damaged Items</option>
                            <option value="missing_items">Missing Items</option>
                            <option value="late_delivery">Late Delivery</option>
                        </select>
                        <button type="submit" class="bg-red-600 text-white text-xs px-3 py-2 rounded-lg font-medium hover:bg-red-700 whitespace-nowrap">
                            Refund
                        </button>
                    </div>
                </form>
            @else
                <p class="text-xs text-gray-500 italic mt-4">No active Uber delivery associated with this order.</p>
            @endif
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
                    @if(($order->order_type ?? '') === 'takeaway' && $order->hyst_charge > 3.99)
                    <tr>
                        <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Operation Charge</td>
                        <td class="p-4 font-bold text-gray-800">£3.99</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Handling Charge</td>
                        <td class="p-4 font-bold text-gray-800">£{{ number_format($order->hyst_charge - 3.99, 2) }}</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="3" class="p-4 text-right font-semibold text-gray-600">Operation Charge</td>
                        <td class="p-4 font-bold text-gray-800">£{{ number_format($order->hyst_charge, 2) }}</td>
                    </tr>
                    @endif
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