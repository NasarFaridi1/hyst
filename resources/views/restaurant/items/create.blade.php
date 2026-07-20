@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-2xl font-bold mb-6">
            Add Item
        </h2>

        <form method="POST"
        action="/restaurant/items"
        enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-2 gap-4">

                <input type="text"
                name="name"
                placeholder="Item Name"
                class="border p-3 rounded">

                <input type="text"
                name="unit"
                placeholder="Unit (KG/LTR)"
                class="border p-3 rounded">

                <input type="number"
                step="0.01"
                name="price"
                placeholder="Price"
                class="border p-3 rounded">

                <input type="number"
                name="quantity"
                placeholder="Quantity"
                class="border p-3 rounded">

            </div>

            <textarea
            name="description"
            placeholder="Description"
            class="border p-3 rounded w-full mt-4"></textarea>

            <input type="file"
            name="image"
            class="border p-3 rounded w-full mt-4">

            <button class="bg-blue-500 text-white px-6 py-3 rounded mt-5">

                Save Item

            </button>

        </form>

    </div>

</div>

@endsection