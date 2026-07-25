@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">

            Edit Product

        </h1>

        <a href="{{ route('ambassador.products.index',$restaurant->id) }}"
            class="bg-gray-700 text-white px-5 py-3 rounded">

            Back

        </a>

    </div>

    <div class="bg-white shadow rounded-xl p-8">

        <form
            method="POST"
            enctype="multipart/form-data"
            action="{{ route('ambassador.products.update',[$restaurant->id,$product->id]) }}">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-5">

                <div>

                    <label class="font-semibold">

                        Category

                    </label>

                    <select
                        name="category_id"
                        class="w-full border rounded-lg p-3">

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ $product->category_id==$category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="font-semibold">

                        Product Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$product->name) }}"
                        class="w-full border rounded-lg p-3">

                </div>

                <div>

                    <label class="font-semibold">

                        Price

                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        value="{{ old('price',$product->price) }}"
                        class="w-full border rounded-lg p-3">

                </div>

                <div>

                    <label class="font-semibold">

                        Status

                    </label>

                    <select
                        name="status"
                        class="w-full border rounded-lg p-3">

                        <option value="1" {{ $product->status==1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ $product->status==0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

            <div class="mt-5">

                <label class="font-semibold">

                    Description

                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full border rounded-lg p-3">{{ old('description',$product->description) }}</textarea>

            </div>

            <div class="mt-5">

                <label class="font-semibold">

                    Current Image

                </label>

                <br>

                @if($product->image)

                    <img
                        src="{{ asset('storage/'.$product->image) }}"
                        class="w-24 h-24 rounded-lg object-cover mb-3">

                @endif

                <input
                    type="file"
                    name="image"
                    class="w-full border rounded-lg p-3">

            </div>

            <div class="mt-6">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg">

                    Update Product

                </button>

            </div>

        </form>

    </div>

</div>

@endsection