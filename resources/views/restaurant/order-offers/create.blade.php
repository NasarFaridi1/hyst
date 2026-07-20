@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

<div class="flex items-center justify-between mb-8">

    <h1 class="text-3xl font-bold">
        Create Order Offer
    </h1>

    <a href="/restaurant/order-offers"
        class="bg-gray-200 px-5 py-3 rounded-xl">
        Back
    </a>

</div>

<div class="bg-white rounded-3xl shadow p-8">

    <form method="POST" action="/restaurant/order-offers">

        @csrf

        <div class="grid grid-cols-2 gap-6">

            <div>
                <label class="block mb-2 font-medium">
                    Title
                </label>

                <input type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full border p-3 rounded-xl"
                    required>
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Minimum Order Value
                </label>

                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                        £
                    </span>

                    <input type="number"
                        step="0.01"
                        name="min_order_value"
                        value="{{ old('min_order_value') }}"
                        class="w-full border p-3 pl-8 rounded-xl"
                        required>
                </div>
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Discount Value
                </label>

                <input type="number"
                    step="0.01"
                    name="value"
                    value="{{ old('value') }}"
                    class="w-full border p-3 rounded-xl"
                    required>
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Value Type
                </label>

                <select name="value_type"
                    class="w-full border p-3 rounded-xl"
                    required>

                    <option value="fixed">
                        Fixed Amount
                    </option>

                    <option value="percentage">
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
                    class="w-full border p-3 rounded-xl"
                    required>
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    End Date
                </label>

                <input type="datetime-local"
                    name="end_date"
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
                    class="w-full border p-3 rounded-xl">{{ old('description') }}</textarea>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Status
                </label>

                <select name="status"
                    class="w-full border p-3 rounded-xl">

                    <option value="active">
                        Active
                    </option>

                    <option value="inactive">
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <div class="mt-8">

            <button
                type="submit"
                class="bg-black text-white px-8 py-3 rounded-xl">

                Create Offer

            </button>

        </div>

    </form>

</div>


</div>

@endsection
