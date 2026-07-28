@extends('layouts.app')

@section('title', 'Edit Delivery Charge')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Edit Delivery Charge
            </h2>
            <p class="text-sm text-gray-500">
                Update the delivery charge slab.
            </p>
        </div>

        <a href="{{ route('restaurant.delivery-charges.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200">

        <form action="{{ route('restaurant.delivery-charges.update', $deliveryCharge->id) }}"
              method="POST"
              class="p-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- From Distance -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        From Distance (Miles)
                    </label>

                    <input
                        type="number"
                        name="from_distance"
                        step="0.01"
                        min="0"
                        value="{{ old('from_distance', $deliveryCharge->from_distance) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('from_distance') border-red-500 @enderror"
                        required>

                    @error('from_distance')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- To Distance -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        To Distance (Miles)
                    </label>

                    <input
                        type="number"
                        name="to_distance"
                        step="0.01"
                        min="0"
                        value="{{ old('to_distance', $deliveryCharge->to_distance) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('to_distance') border-red-500 @enderror"
                        required>

                    @error('to_distance')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Delivery Charge -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Delivery Charge (£)
                    </label>

                    <input
                        type="number"
                        name="delivery_charge"
                        step="0.01"
                        min="0"
                        value="{{ old('delivery_charge', $deliveryCharge->delivery_charge) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('delivery_charge') border-red-500 @enderror"
                        required>

                    @error('delivery_charge')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Free Delivery Min Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Free Delivery Min Order (£)
                    </label>

                    <input
                        type="number"
                        name="free_delivery_min_order"
                        step="0.01"
                        min="0"
                        value="{{ old('free_delivery_min_order', $deliveryCharge->free_delivery_min_order) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('free_delivery_min_order') border-red-500 @enderror">

                    @error('free_delivery_min_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Leave empty if free delivery is not available for this distance slab.
                    </p>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('restaurant.delivery-charges.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-[#C25A2A] hover:bg-green-700 text-white rounded-lg transition">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Update Delivery Charge
                </button>

            </div>

        </form>

    </div>

</div>
@endsection