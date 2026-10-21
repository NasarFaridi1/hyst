@extends('layouts.app')

@section('content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">

    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">

        All Complained Orders

    </h1>

    <a
        href="/restaurant/complaint"
        class="bg-black hover:bg-gray-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-semibold transition">

        Complaint's Orders

    </a>

</div>

<div class="bg-white rounded-2xl shadow p-4 sm:p-5 mb-6">

    <form method="GET">

        <div class="flex flex-col sm:flex-row gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search order ID, user, status..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#C25A2A] text-sm">

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-xl font-semibold text-sm flex-1 sm:flex-initial text-center transition">

                    Search

                </button>

                @if(request('search'))
                    <a href="{{ url()->current() }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold text-sm flex-1 sm:flex-initial text-center transition">

                        Reset

                    </a>
                @endif
            </div>

        </div>

    </form>

</div>

    <div class="bg-white rounded-2xl shadow overflow-x-auto">

        <table class="w-full min-w-[650px]">

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

                            <a href="{{ route('restaurant.complaint.show', $order->id) }}"
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