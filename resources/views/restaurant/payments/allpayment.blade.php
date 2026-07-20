@extends('layouts.app')

@section('content')

<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-8 border-b flex justify-between items-center">

        <h1 class="text-4xl font-bold">

            All Payments

        </h1>

        <a
            href="/restaurant/payments"
            class="bg-black text-white px-6 py-3 rounded-xl">

            Today's Payments

        </a>

    </div>

    <table class="w-full">

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

@endsection