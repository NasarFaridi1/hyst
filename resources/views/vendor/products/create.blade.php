@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between mb-8">

        <h1 class="text-4xl font-bold">

            Add Product

        </h1>

        <a href="{{ route('vendor.products.index') }}"
        class="bg-black text-white px-6 py-3 rounded-xl">

            Back

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow p-10">

        <form method="POST"
        action="{{ route('vendor.products.store') }}"
        enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-2 gap-6">

                <div>

                    <label class="font-bold block mb-2">

                        Product Name

                    </label>

                    <input
                    type="text"
                    name="name"
                    class="w-full border p-4 rounded-xl">

                </div>

                <div>

                    <label class="font-bold block mb-2">

                        Category

                    </label>

                    <select
                    name="category_id"
                    class="w-full border p-4 rounded-xl">

                        @foreach($categories as $category)

                        <option value="{{ $category->id }}">

                            {{ $category->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="font-bold block mb-2">

                        Price

                    </label>

                    <input
                    type="number"
                    name="price"
                    class="w-full border p-4 rounded-xl">

                </div>

                <div>

                    <label class="font-bold block mb-2">

                        Product Image

                    </label>

                    <input
                    type="file"
                    name="image"
                    class="w-full border p-4 rounded-xl">

                </div>

            </div>

            <div class="mt-6">

                <label class="font-bold block mb-2">

                    Description

                </label>

                <textarea
                name="description"
                rows="5"
                class="w-full border p-4 rounded-xl"></textarea>

            </div>

            <button
            class="bg-blue-500 text-white px-10 py-4 rounded-xl mt-8">

                Save Product

            </button>

        </form>

    </div>

</div>

@endsection