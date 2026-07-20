@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow">

    <h1 class="text-3xl font-bold mb-6">
        Add Marketing Banner
    </h1>

    <form action="{{ route('admin.marketing-banners.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="mb-4">
            <label>Title</label>
            <input type="text"
                name="title"
                class="w-full border p-3 rounded-lg">
        </div>

        <div class="mb-4">
            <label>Category</label>
            <select name="category_id"
                class="w-full border p-3  rounded-lg">

                <option value="">Select Category</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-4">
            <label>Subtitle</label>
            <input type="text"
                name="subtitle"
                class="w-full border p-3 rounded-lg">
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="text"
                name="email"
                class="w-full border p-3 rounded-lg">
        </div>

        <div class="mb-4">
            <label>Phone</label>
            <input type="text"
                name="phone"
                class="w-full border p-3 rounded-lg">
        </div>

        <div class="mb-4">
            <label>Description</label>
            <textarea
                name="description"
                rows="5"
                class="w-full border p-3 rounded-lg"></textarea>
        </div>

        <div class="mb-4">
            <label>Banner Image</label>
            <input type="file"
                name="banner_image"
                class="w-full border p-3 rounded-lg">
        </div>

        <div class="mb-4">
            <label>Status</label>

            <select name="status"
                class="w-full border p-3 rounded-lg">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <button
            class="bg-blue-500 text-white px-6 py-3 rounded-xl">
            Save Banner
        </button>

    </form>

</div>

@endsection