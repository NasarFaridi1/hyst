@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-6">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Edit Coupon
        </h2>

        <a href="{{ route('restaurant.coupons.index') }}"
           class="inline-flex items-center px-4 py-2 bg-[#C25A2A] hover:bg-[#A54A1F] text-white rounded-lg transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200">

        <div class="p-6">

            <form action="{{ route('restaurant.coupons.update', $coupon->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Coupon Code --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Coupon Code
                        </label>

                        <input
                            type="text"
                            name="code"
                            value="{{ old('code', $coupon->code) }}"
                            style="text-transform: uppercase"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('code') border-red-500 @enderror">

                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $coupon->title) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('title') border-red-500 @enderror">

                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">{{ old('description', $coupon->description) }}</textarea>
                    </div>

                    {{-- Discount Type --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Discount Type
                        </label>

                        <select
                            name="type"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('type') border-red-500 @enderror">

                            <option value="">Select Type</option>

                            <option value="percentage"
                                {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>
                                Percentage (%)
                            </option>

                            <option value="fixed"
                                {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>
                                Fixed (£)
                            </option>

                        </select>

                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Coupon Category / Purpose --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Coupon Category
                        </label>

                        <select
                            name="coupon_type"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('coupon_type') border-red-500 @enderror">

                            <option value="normal"
                                {{ old('coupon_type', $coupon->coupon_type ?? 'normal') == 'normal' ? 'selected' : '' }}>
                                Normal Coupon (General)
                            </option>

                            <option value="loyalty_reward"
                                {{ old('coupon_type', $coupon->coupon_type) == 'loyalty_reward' ? 'selected' : '' }}>
                                Loyalty & Reward Campaign
                            </option>

                        </select>

                        @error('coupon_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Discount Value --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Discount Value
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="value"
                            value="{{ old('value', $coupon->value) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('value') border-red-500 @enderror">

                        @error('value')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Minimum Order --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Minimum Order Amount
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="min_order_amount"
                            value="{{ old('min_order_amount', $coupon->min_order_amount) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Maximum Discount --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Maximum Discount
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="max_discount"
                            value="{{ old('max_discount', $coupon->max_discount) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Usage Limit --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Usage Limit
                        </label>

                        <input
                            type="number"
                            name="usage_limit"
                            value="{{ old('usage_limit', $coupon->usage_limit) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Per User Limit --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Per User Limit
                        </label>

                        <input
                            type="number"
                            name="per_user_limit"
                            value="{{ old('per_user_limit', $coupon->per_user_limit) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Start Date --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Start Date
                        </label>

                        <input
                            type="datetime-local"
                            name="starts_at"
                            value="{{ old('starts_at', optional($coupon->starts_at)->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Expiry Date --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Expiry Date
                        </label>

                        <input
                            type="datetime-local"
                            name="expires_at"
                            value="{{ old('expires_at', optional($coupon->expires_at)->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Status --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">

                            <option value="1" {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                <div class="mt-8">

                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-3 bg-[#C25A2A] hover:bg-[#A54A1F] text-white font-medium rounded-lg transition">

                        <i class="fas fa-save mr-2"></i>

                        Update Coupon

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection