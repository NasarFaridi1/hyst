@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-10">

    <div>

        <h1 class="text-4xl font-bold">

            Orders

        </h1>

        <p class="text-gray-500 mt-2">

            Manage all restaurant orders

        </p>

    </div>

</div>

<div class="flex justify-between items-center mb-6">

    <form method="GET" action="{{ route('admin.orders.index') }}">
        <div class="flex gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search order, user, restaurant..."
                class="border border-gray-300 rounded-lg px-4 py-2 w-80 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg">
                Search
            </button>

            @if(request('search'))
                <a href="{{ route('admin.orders.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
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
                    Restaurant
                </th>

                <th class="p-5 text-left">
                    Amount
                </th>

                <th class="p-5 text-left">
                    Status
                </th>

                <th class="p-5 text-left">
                    Date
                </th>

                <th class="p-5 text-left">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>


            @forelse($orders as $order)

                <tr class="border-t hover:bg-gray-50">

                    <td class="p-5 font-bold">

                        #{{ $order->id }}

                    </td>

                    <td class="p-5">

                        {{ $order->user->name ?? '' }}

                    </td>

                    <td class="p-5">

                        {{ $order->restaurant->name ?? '' }}

                    </td>

                    <td class="p-5 font-bold">

                        £{{ $order->total_amount }}

                    </td>

                    <td class="p-5">

                        @if($order->status == 'pending')

                        <span
                        class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full">

                            Pending

                        </span>

                        @elseif($order->status == 'completed')

                        <span
                        class="bg-green-100 text-green-700 px-4 py-1 rounded-full">

                            Completed

                        </span>

                        @else

                        <span
                        class="bg-red-100 text-red-700 px-4 py-1 rounded-full">

                            Cancelled

                        </span>

                        @endif

                    </td>

                    <td class="p-5">

                        {{ $order->created_at->format('d M Y') }}

                    </td>

                    <td class="p-5">

                        <a href="{{ route('admin.orders.show',$order->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg">

                            View

                        </a>

                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center p-8 text-gray-500">
                        No orders found.
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