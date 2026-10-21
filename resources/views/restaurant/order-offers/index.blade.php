@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">

    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
        Order Offers
    </h1>

    <a href="/restaurant/order-offers/create"
        class="bg-black hover:bg-gray-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-semibold transition">
        Add Order Offer
    </a>

</div>

<div class="bg-white rounded-3xl shadow overflow-x-auto">

    <table class="w-full min-w-[650px]">

        <thead class="bg-gray-100">

            <tr>
                <th class="p-4 text-left">Title</th>
                <th class="p-4 text-left">Min Order</th>
                <th class="p-4 text-left">Discount</th>
                <th class="p-4 text-left">Start</th>
                <th class="p-4 text-left">End</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Action</th>
            </tr>

        </thead>

        <tbody>

            @forelse($offers as $offer)

                <tr class="border-b">

                    <td class="p-4">
                        {{ $offer->title }}
                    </td>

                    <td class="p-4">
                        £{{ number_format($offer->min_order_value, 2) }}
                    </td>

                    <td class="p-4">

                        @if($offer->value_type == 'percentage')
                            {{ $offer->value }}%
                        @else
                            £{{ $offer->value }}
                        @endif

                    </td>

                    <td class="p-4">
                        {{ \Carbon\Carbon::parse($offer->start_date)->format('d M Y') }}
                    </td>

                    <td class="p-4">
                        {{ \Carbon\Carbon::parse($offer->end_date)->format('d M Y') }}
                    </td>

                    <td class="p-4">

                        @if($offer->status == 'active')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">
                                Active
                            </span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full">
                                Inactive
                            </span>
                        @endif

                    </td>

                    <td class="p-4 flex gap-3">

                        <a href="/restaurant/order-offers/{{ $offer->id }}/edit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                            Edit
                        </a>

                        <form action="/restaurant/order-offers/{{ $offer->id }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete this offer?')"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="p-8 text-center">
                        No Order Offers Found
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection