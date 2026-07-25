@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h2 class="text-3xl font-bold mb-6">

        Edit Category

    </h2>

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('ambassador.categories.update',[$restaurant->id,$category->id]) }}">

        @csrf
        @method('PUT')

        <div class="mb-4">

            <label>Name</label>

            <input
                type="text"
                name="name"
                value="{{ old('name',$category->name) }}"
                class="w-full border rounded p-3">

        </div>

        <div class="mb-4">

            <label>Parent Category</label>

            <select
                name="parent_id"
                class="w-full border rounded p-3">

                <option value="">

                    Main Category

                </option>

                @foreach($parents as $parent)

                    <option
                        value="{{ $parent->id }}"
                        {{ $category->parent_id==$parent->id ? 'selected' : '' }}>

                        {{ $parent->name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-4">

            <label>Display Order</label>

            <input
                type="number"
                name="display_order"
                value="{{ old('display_order',$category->display_order) }}"
                class="w-full border rounded p-3">

        </div>

        <div class="mb-4">

            <label>Current Image</label>

            <br>

            @if($category->image)

                <img
                    src="{{ asset('storage/'.$category->image) }}"
                    class="w-24 h-24 rounded object-cover mb-3">

            @endif

            <input
                type="file"
                name="image"
                class="w-full border rounded p-3">

        </div>

        <button
            class="bg-blue-600 text-white px-8 py-3 rounded">

            Update Category

        </button>

    </form>

</div>

@endsection