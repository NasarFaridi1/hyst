@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h2 class="text-3xl font-bold mb-6">

        Add Category

    </h2>

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('ambassador.categories.store',$restaurant->id) }}">

        @csrf

        <div class="mb-4">

            <label>Name</label>

            <input
                type="text"
                name="name"
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

                    <option value="{{ $parent->id }}">

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
                class="w-full border rounded p-3">

        </div>

        <div class="mb-4">

            <label>Image</label>

            <input
                type="file"
                name="image"
                class="w-full border rounded p-3">

        </div>

        <button
            class="bg-blue-600 text-white px-8 py-3 rounded">

            Save Category

        </button>

    </form>

</div>

@endsection