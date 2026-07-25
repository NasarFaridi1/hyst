@extends('layouts.app')

@section('content')

    <div class="flex justify-between items-center mb-8">

    <h1 class="text-4xl font-bold">

        All Orders

    </h1>

    <a
        href="/restaurant/orders"
        class="bg-black text-white px-6 py-3 rounded-xl">

        Today's Orders

    </a>

</div>

<div class="bg-white rounded-2xl shadow p-5 mb-6">

    <form method="GET">

        <div class="flex gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search order ID, user, status..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3">

            <button
                type="submit"
                class="bg-black text-white px-6 py-3 rounded-xl">

                Search

            </button>

            @if(request('search'))
                <a href="{{ url()->current() }}"
                   class="bg-gray-500 text-white px-6 py-3 rounded-xl">

                    Reset

                </a>
            @endif

        </div>

    </form>

</div>

    <div class="bg-white rounded-2xl shadow overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-5 text-left">
                        Order ID
                    </th>

                    <th class="p-5 text-left">
                        User
                    </th>

                    <th class="p-5 text-left">
                        Amount
                    </th>

                    <th class="p-5 text-left">
                        Status
                    </th>
                    <th class="p-5 text-left">
                        View
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($orders as $order)

                    <tr class="border-t">

                        <td class="p-5">

                            #{{ $order->id }}

                        </td>

                        <td class="p-5">

                            {{ $order->user->name ?? '' }}

                        </td>

                        <td class="p-5">

                            £{{ $order->total_amount }}

                        </td>

                        <td class="p-5">

                            @if($order->status == 'pending')

                                <span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-sm font-semibold">

                                    Pending

                                </span>

                            @elseif($order->status == 'completed')

                                <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">

                                    Completed

                                </span>

                            @elseif($order->status == 'cancelled')

                                <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm font-semibold">

                                    Cancelled

                                </span>

                            @elseif($order->status == 'processing')

                                <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-semibold">

                                    Processing

                                </span>

                            @elseif($order->status == 'delivered')

                                <span class="bg-purple-100 text-purple-700 px-4 py-1 rounded-full text-sm font-semibold">

                                    Delivered

                                </span>

                            @else

                                <span class="bg-gray-100 text-gray-700 px-4 py-1 rounded-full text-sm font-semibold">

                                    {{ ucfirst($order->status) }}

                                </span>

                            @endif

                        </td>
                        <td class="p-5">

                            <a href="{{ route('restaurant.orders.show', $order->id) }}"
                                class="bg-black text-white px-4 py-2 rounded-lg text-sm">

                                View

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center py-20 text-gray-500">

                            No Orders Found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

<div class="mt-6">
    {{ $orders->links() }}
</div>

@endsection