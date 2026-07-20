@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="bg-white p-8 rounded-2xl shadow-lg">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h2 class="text-3xl font-bold text-gray-800">
                    Edit Item
                </h2>

                <p class="text-gray-500 mt-1">
                    Update restaurant raw material details
                </p>

            </div>

            <a href="/restaurant/items"
            class="bg-gray-800 text-white px-5 py-2 rounded-lg hover:bg-black transition">

                Back

            </a>

        </div>

        <form method="POST"
        action="/restaurant/items/{{ $item->id }}"
        enctype="multipart/form-data">

            @csrf

            @method('PUT')

            <div class="grid grid-cols-2 gap-6">

                <!-- ITEM NAME -->

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">

                        Item Name

                    </label>

                    <input type="text"
                    name="name"
                    value="{{ $item->name }}"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- UNIT -->

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">

                        Unit

                    </label>

                    <input type="text"
                    name="unit"
                    value="{{ $item->unit }}"
                    placeholder="KG / LTR / PCS"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- PRICE -->

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">

                        Price

                    </label>

                    <input type="number"
                    step="0.01"
                    name="price"
                    value="{{ $item->price }}"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- QUANTITY -->

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">

                        Quantity

                    </label>

                    <input type="number"
                    name="quantity"
                    value="{{ $item->quantity }}"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

            </div>

            <!-- DESCRIPTION -->

            <div class="mt-6">

                <label class="block mb-2 font-semibold text-gray-700">

                    Description

                </label>

                <textarea
                name="description"
                rows="5"
                class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $item->description }}</textarea>

            </div>

            <!-- IMAGE -->

            <div class="mt-6">

                <label class="block mb-2 font-semibold text-gray-700">

                    Item Image

                </label>

                <input type="file"
                name="image"
                class="w-full border border-gray-300 rounded-xl p-4">

            </div>

            <!-- OLD IMAGE -->

            @if($item->image)

            <div class="mt-6">

                <p class="font-semibold text-gray-700 mb-3">

                    Current Image

                </p>

                <img src="{{ asset('storage/'.$item->image) }}"
                class="w-32 h-32 object-cover rounded-xl border">

            </div>

            @endif

            <!-- STATUS -->

            <div class="mt-6">

                <label class="block mb-2 font-semibold text-gray-700">

                    Status

                </label>

                <select
                name="status"
                class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="1"
                    {{ $item->status == 1 ? 'selected' : '' }}>

                        Active

                    </option>

                    <option value="0"
                    {{ $item->status == 0 ? 'selected' : '' }}>

                        Inactive

                    </option>

                </select>

            </div>

            <!-- BUTTON -->

            <div class="mt-8">

                <button
                class="bg-blue-600 hover:bg-blue-700 transition text-white px-8 py-4 rounded-xl font-semibold">

                    Update Item

                </button>

            </div>

        </form>

    </div>

</div>

@endsection