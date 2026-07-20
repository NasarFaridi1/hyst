@extends('layouts.app')

@section('content')

    <h1 class="text-3xl font-bold mb-8">
        Edit Offer
    </h1>

    <form action="/restaurant/offers/{{ $offer->id }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-8 rounded-3xl shadow">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- TITLE --}}
            <div>

                <label class="block mb-2 font-semibold">
                    Title
                </label>

                <input type="text" name="title" value="{{ $offer->title }}"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

            </div>

            {{-- TYPE --}}
            <div>

                <label class="block mb-2 font-semibold">
                    Type
                </label>

                <select name="type"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

                    <option value="offer" {{ $offer->type == 'offer' ? 'selected' : '' }}>
                        Offer
                    </option>

                    <option value="discount" {{ $offer->type == 'discount' ? 'selected' : '' }}>
                        Discount
                    </option>

                </select>

            </div>

            {{-- PRODUCTS --}}
            <div class="md:col-span-2">

                <label class="block mb-3 font-semibold text-lg">
                    Select Products
                </label>

                <select id="products" name="products[]" multiple>

                    @foreach($products as $product)

                        <option value="{{ $product->id }}" {{ $offer->products->contains($product->id) ? 'selected' : '' }}>

                            {{ $product->name }} - £{{ $product->price }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- VALUE --}}
            <div>

                <label class="block mb-2 font-semibold">
                    Value
                </label>

                <input type="number" step="0.01" name="value" value="{{ $offer->value }}"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

            </div>

            {{-- VALUE TYPE --}}
            <div>

                <label class="block mb-2 font-semibold">
                    Value Type
                </label>

                <select name="value_type"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

                    <option value="percent" {{ $offer->value_type == 'percent' ? 'selected' : '' }}>
                        Percent
                    </option>

                    <option value="flat" {{ $offer->value_type == 'flat' ? 'selected' : '' }}>
                        Flat
                    </option>

                </select>

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Start Date
                </label>

                <input type="date" name="start_date"
                    value="{{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d') : '' }}"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    End Date
                </label>

                <input type="date" name="end_date"
                    value="{{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d') : '' }}"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

            </div>
            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">

                <label class="block mb-2 font-semibold">
                    Description
                </label>

                <textarea name="description" rows="5"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ $offer->description }}</textarea>

            </div>

            {{-- IMAGE --}}
            <div>

                <label class="block mb-2 font-semibold">
                    Image
                </label>

                <input type="file" name="image" class="w-full border rounded-xl p-3">

                @if($offer->image)

                    <img src="{{ asset('storage/' . $offer->image) }}"
                        class="w-32 h-32 object-cover rounded-2xl mt-4 border shadow">

                @endif

            </div>

            {{-- STATUS --}}
            <div>

                <label class="block mb-2 font-semibold">
                    Status
                </label>

                <select name="is_active"
                    class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-500">

                    <option value="1" {{ $offer->is_active ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0" {{ !$offer->is_active ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <button class="bg-black hover:bg-orange-600 transition text-white px-8 py-4 rounded-xl mt-8">

            Update Offer

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