@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

<div class="flex items-center justify-between mb-8">

    <h1 class="text-3xl font-bold">
        Edit Order Offer
    </h1>

    <a href="/restaurant/order-offers"
        class="bg-gray-200 px-5 py-3 rounded-xl">
        Back
    </a>

</div>

<div class="bg-white rounded-3xl shadow p-8">

    <form method="POST"
        action="/restaurant/order-offers/{{ $offer->id }}">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">

            <div>

                <label class="block mb-2 font-medium">
                    Title
                </label>

                <input type="text"
                    name="title"
                    value="{{ old('title', $offer->title) }}"
                    class="w-full border p-3 rounded-xl"
                    required>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Minimum Order Value
                </label>

                <input type="number"
                    step="0.01"
                    name="min_order_value"
                    value="{{ old('min_order_value', $offer->min_order_value) }}"
                    class="w-full border p-3 rounded-xl"
                    required>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Discount Value
                </label>

                <input type="number"
                    step="0.01"
                    name="value"
                    value="{{ old('value', $offer->value) }}"
                    class="w-full border p-3 rounded-xl"
                    required>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Value Type
                </label>

                <select name="value_type"
                    class="w-full border p-3 rounded-xl">

                    <option value="fixed"
                        {{ $offer->value_type == 'fixed' ? 'selected' : '' }}>
                        Fixed Amount
                    </option>

                    <option value="percentage"
                        {{ $offer->value_type == 'percentage' ? 'selected' : '' }}>
                        Percentage
                    </option>

                </select>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Start Date
                </label>

                <input type="datetime-local"
                    name="start_date"
                    value="{{ \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d\TH:i') }}"
                    class="w-full border p-3 rounded-xl"
                    required>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    End Date
                </label>

                <input type="datetime-local"
                    name="end_date"
                    value="{{ \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d\TH:i') }}"
                    class="w-full border p-3 rounded-xl"
                    required>

            </div>

            <div class="col-span-2">

                <label class="block mb-2 font-medium">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full border p-3 rounded-xl">{{ old('description', $offer->description) }}</textarea>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Status
                </label>

                <select name="status"
                    class="w-full border p-3 rounded-xl">

                    <option value="active"
                        {{ $offer->status == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ $offer->status == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <div class="mt-8">

            <button
                type="submit"
                class="bg-black text-white px-8 py-3 rounded-xl">

                Update Offer

            </button>

        </div>

    </form>

</div>


</div>

@endsection
