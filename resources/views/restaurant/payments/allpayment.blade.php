@extends('layouts.app')

@section('content')

<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-4 sm:p-8 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">

            All Payments

        </h1>

        <a
            href="/restaurant/payments"
            class="bg-black hover:bg-gray-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-semibold transition">

            Today's Payments

        </a>

    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[650px]">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-5 text-left">
                    Order ID
                </th>

                <th class="p-5 text-left">
                    Customer
                </th>

                <th class="p-5 text-left">
                    Payment Type
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

            </tr>

        </thead>

        <tbody>

            @forelse($payments as $payment)

            <tr class="border-t">

                <td class="p-5">

                    #{{ $payment->order_id }}

                </td>

                <td class="p-5">

                    {{ $payment->order->user->name ?? '-' }}

                </td>

                <td class="p-5">

                    {{ $payment->payment_method }}

                </td>

                <td class="p-5 font-bold text-green-600">

                    £{{ $payment->amount }}

                </td>

                <td class="p-5">

                    @if($payment->payment_status == 'paid')

                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold">

                            Paid

                        </span>

                    @else

                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold">

                            Pending

                        </span>

                    @endif

                </td>

                <td class="p-5">

                    {{ $payment->created_at->format('d M Y') }}

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                class="text-center py-20 text-gray-500">

                    No Payments Found

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    </div>

</div>

@endsection