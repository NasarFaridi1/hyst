@extends('layouts.app')

@section('title', 'Delivery Charges')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Delivery Charges</h2>
            <p class="text-sm text-gray-500">
                Manage delivery charge slabs for your restaurant.
            </p>
        </div>

        <a href="{{ route('restaurant.delivery-charges.create') }}"
           class="inline-flex items-center px-4 py-2 bg-[#C25A2A] hover:bg-blue-700 text-white rounded-lg shadow transition">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Add Delivery Charge
        </a>
    </div>

    

    <!-- Table -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            #
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            From Distance (Miles)
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            To Distance (Miles)
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Delivery Charge (£)
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Free Delivery Min Order (£)
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($charges as $key => $charge)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $key + 1 }}
                            </td>

                            <td class="px-6 py-4">
                                {{ number_format($charge->from_distance, 2) }} Miles
                            </td>

                            <td class="px-6 py-4">
                                {{ number_format($charge->to_distance, 2) }} Miles
                            </td>

                            <td class="px-6 py-4 font-semibold text-green-600">
                                £{{ number_format($charge->delivery_charge, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($charge->free_delivery_min_order)
                                    <span class="font-semibold text-green-600">
                                        £{{ number_format($charge->free_delivery_min_order, 2) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Not Available</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ route('restaurant.delivery-charges.edit',$charge->id) }}"
                                       class="px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('restaurant.delivery-charges.destroy',$charge->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this delivery charge?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm">
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">

                                <div class="flex flex-col items-center">

                                    <i data-lucide="truck" class="w-10 h-10 text-gray-300 mb-3"></i>

                                    <p class="text-lg font-medium">
                                        No delivery charges found
                                    </p>

                                    <p class="text-sm text-gray-400 mb-4">
                                        Add your first delivery charge slab.
                                    </p>

                                    <a href="{{ route('restaurant.delivery-charges.create') }}"
                                       class="px-4 py-2 rounded-lg bg-[#C25A2A] hover:bg-blue-700 text-white">
                                        Add Delivery Charge
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection