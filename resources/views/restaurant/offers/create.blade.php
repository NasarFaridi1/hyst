@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-8">
    Create Offer
</h1>

<form
    action="/restaurant/offers"
    method="POST"
    enctype="multipart/form-data"
    class="bg-white p-8 rounded-3xl shadow">

    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block mb-2 font-semibold">
                Title
            </label>

            <input
                type="text"
                name="title"
                class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <div>
            <label class="block mb-2 font-semibold">
                Type
            </label>

            <select
                name="type"
                class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

                <option value="offer">Offer</option>
                <option value="discount">Discount</option>

            </select>
        </div>

        {{-- PRODUCTS --}}
        <div class="md:col-span-2">

            <label class="block mb-3 font-semibold text-lg">
                Select Products
            </label>

            <select
                id="products"
                name="products[]"
                multiple>

                @foreach($products as $product)

                    <option value="{{ $product->id }}">
                        {{ $product->name }} - £{{ $product->price }}
                    </option>

                @endforeach

            </select>

        </div>

        <div>
            <label class="block mb-2 font-semibold">
                Value
            </label>

            <input
                type="number"
                step="0.01"
                name="value"
                class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <div>
            <label class="block mb-2 font-semibold">
                Value Type
            </label>

            <select
                name="value_type"
                class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

                <option value="percent">Percent</option>
                <option value="flat">Flat</option>

            </select>
        </div>

        <div>
            <label class="block mb-2 font-semibold">
                Start Date
            </label>

            <input
                type="date"
                name="start_date"
                class="w-full border rounded-xl p-3">
        </div>

        <div>
            <label class="block mb-2 font-semibold">
                End Date
            </label>

            <input
                type="date"
                name="end_date"
                class="w-full border rounded-xl p-3">
        </div>

        <div class="md:col-span-2">
            <label class="block mb-2 font-semibold">
                Description
            </label>

            <textarea
                name="description"
                rows="5"
                class="w-full border rounded-xl p-3"></textarea>
        </div>

        <div>
            <label class="block mb-2 font-semibold">
                Image
            </label>

            <input
                type="file"
                name="image"
                class="w-full border rounded-xl p-3">
        </div>

        <div>
            <label class="block mb-2 font-semibold">
                Status
            </label>

            <select
                name="is_active"
                class="w-full border rounded-xl p-3">

                <option value="1">Active</option>
                <option value="0">Inactive</option>

            </select>
        </div>

    </div>

    <button
        class="bg-black text-white px-8 py-4 rounded-xl mt-8 hover:bg-orange-600 transition">

        Save Offer

    </button>

</form>

{{-- TOM SELECT --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {

        new TomSelect("#products", {
            plugins: ['remove_button'],
            create: false,
            persist: false,
            maxItems: null,
            placeholder: "Search & Select Products",
            hideSelected: true,
            closeAfterSelect: false,
        });

    });
</script>

@endsection