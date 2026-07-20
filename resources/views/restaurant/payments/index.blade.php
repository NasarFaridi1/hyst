@extends('layouts.app')

@section('content')


<div class="p-8 mb-6 bg-white rounded-3xl shadow overflow-hidden">

        <h2 class="text-2xl font-bold mb-6">
            Payment Gateway Settings
        </h2>

        <form method="POST"
            action="{{ route('restaurant.payment.settings.update') }}">

            @csrf

            <div class="grid grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 font-medium">
                        Member ID
                    </label>

                    <input
                        type="text"
                        name="transactworld_member_id"
                        value="{{ $restaurant->transactworld_member_id }}"
                        class="w-full border rounded-xl p-4">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Account ID
                    </label>

                    <input
                        type="text"
                        name="transactworld_account_id"
                        value="{{ $restaurant->transactworld_account_id }}"
                        class="w-full border rounded-xl p-4">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Terminal ID
                    </label>

                    <input
                        type="text"
                        name="transactworld_terminal_id"
                        value="{{ $restaurant->transactworld_terminal_id }}"
                        class="w-full border rounded-xl p-4">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Checksum Key
                    </label>

                    <input
                        type="text"
                        name="transactworld_checksum_key"
                        value="{{ $restaurant->transactworld_checksum_key }}"
                        class="w-full border rounded-xl p-4">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Mode
                    </label>

                    <select
                        name="transactworld_mode"
                        class="w-full border rounded-xl p-4">

                        <option
                            value="test"
                            {{ $restaurant->transactworld_mode == 'test' ? 'selected' : '' }}>
                            Test
                        </option>

                        <option
                            value="live"
                            {{ $restaurant->transactworld_mode == 'live' ? 'selected' : '' }}>
                            Live
                        </option>

                    </select>
                </div>

            </div>

            <button
                type="submit"
                class="mt-6 bg-green-600 text-white px-8 py-3 rounded-xl">

                Save Settings

            </button>

        </form>

    </div>

<div class="bg-white rounded-3xl shadow overflow-hidden">

    

    <div class="p-8 border-b">

        <div class="flex justify-between items-center">

                <h1 class="text-4xl font-bold">

                    Today's Payments

                </h1>

            <a
                href="/restaurant/all-payments"
                class="bg-black text-white px-6 py-3 rounded-xl">

                View All Payments

            </a>

        </div>

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