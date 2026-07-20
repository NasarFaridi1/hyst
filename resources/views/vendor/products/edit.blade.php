@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between items-center mb-8">

        <h1 class="text-4xl font-bold">

            Edit Product

        </h1>

        <a href="{{ route('vendor.products.index') }}"
        class="bg-black text-white px-6 py-3 rounded-xl">

            Back

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow p-10">

        <form
        method="POST"
        action="{{ route('vendor.products.update', $product->id) }}"
        enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">

                <div>

                    <label class="font-bold block mb-2">

                        Product Name

                    </label>

                    <input
                    type="text"
                    name="name"
                    value="{{ $product->name }}"
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

                        <option
                        value="{{ $category->id }}"
                        {{ $product->category_id == $category->id ? 'selected' : '' }}>

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
                    value="{{ $product->price }}"
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

                <img
                {{-- src="{{ asset('storage/'.$product->image) }}" --}}
                src="{{ $product->image ? config('services.google_drive.image_url') . $product->image : asset('default.png') }}"
                class="w-40 h-40 rounded-xl object-cover">

            </div>

            <div class="mt-6">

                <label class="font-bold block mb-2">

                    Description

                </label>

                <textarea
                name="description"
                rows="5"
                class="w-full border p-4 rounded-xl">{{ $product->description }}</textarea>

            </div>

            <button
            class="bg-blue-500 hover:bg-blue-600 text-white px-10 py-4 rounded-xl mt-8">

                Update Product

            </button>

        </form>

    </div>

</div>

@endsection