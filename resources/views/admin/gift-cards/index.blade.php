@extends('layouts.app')

@section('title', 'Gift Cards')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Gift Cards
            </h1>

            <p class="text-gray-500 mt-1">
                Manage Hyst Gift Cards
            </p>
        </div>

        <a href="{{ route('admin.gift-cards.create') }}"
           class="inline-flex items-center px-5 py-3 bg-[#C25A2A] text-white rounded-xl hover:bg-[#C25A2A]/80 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 mr-2"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Add Gift Card

        </a>

    </div>

    

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-100">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Code</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Title</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Amount</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Balance</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Expiry</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Order Type</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>

                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">
                        Action
                    </th>

                </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                @forelse($giftCards as $giftCard)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">

                            {{ $loop->iteration + (($giftCards->currentPage()-1) * $giftCards->perPage()) }}

                        </td>

                        <td class="px-6 py-4">

                            <span class="font-semibold text-indigo-600">

                                {{ $giftCard->code }}

                            </span>

                        </td>

                        <td class="px-6 py-4">

                            {{ $giftCard->title }}

                        </td>

                        <td class="px-6 py-4">

                            £{{ number_format($giftCard->amount,2) }}

                        </td>

                        <td class="px-6 py-4 font-semibold text-green-600">

                            £{{ number_format($giftCard->balance,2) }}

                        </td>

                        <td class="px-6 py-4">

                            {{ optional($giftCard->expires_at)->format('d M Y') ?? '-' }}

                        </td>

                        <td class="px-6 py-4">
                            @php
                                $typeLabels = [
                                    'all' => 'All Types',
                                    'delivery' => 'Delivery Only',
                                    'dine_in' => 'Dine-In Only',
                                    'takeaway' => 'Takeaway Only'
                                ];
                                $typeBadgeClasses = [
                                    'all' => 'bg-blue-100 text-blue-700',
                                    'delivery' => 'bg-orange-100 text-orange-700',
                                    'dine_in' => 'bg-purple-100 text-purple-700',
                                    'takeaway' => 'bg-teal-100 text-teal-700'
                                ];
                                $cardType = $giftCard->applicable_type ?? 'all';
                            @endphp
                            <span class="px-3 py-1 {{ $typeBadgeClasses[$cardType] ?? 'bg-gray-100 text-gray-700' }} rounded-full text-xs font-medium">
                                {{ $typeLabels[$cardType] ?? 'All Types' }}
                            </span>
                        </td>

                        <td class="px-6 py-4">

                            @if($giftCard->status == 'active')

                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">

                                    Active

                                </span>

                            @else

                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">

                                    Inactive

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.gift-cards.edit',$giftCard->id) }}"
                                   class="px-4 py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500">

                                    Edit

                                </a>

                                <form action="{{ route('admin.gift-cards.destroy',$giftCard->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Delete this gift card?')"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center py-10 text-gray-500">

                            No Gift Cards Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        @if($giftCards->hasPages())

            <div class="p-6 border-t">

                {{ $giftCards->links() }}

            </div>

        @endif

    </div>

</div>

@endsection