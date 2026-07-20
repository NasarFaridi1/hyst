@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow">

    <h1 class="text-3xl font-bold mb-6">
        Edit Marketing Banner
    </h1>

    <form action="{{ route('admin.marketing-banners.update',$banner->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Title</label>
            <input type="text"
                name="title"
                value="{{ $banner->title }}"
                class="w-full border p-3 rounded-lg">
        </div>
        <div class="mb-4">
            <label>Category</label>
            <select name="category_id"
                class="w-full border p-3 rounded-lg">

                <option value="">Select Category</option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ $banner->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-4">
            <label>Subtitle</label>
            <input type="text"
                name="subtitle"
                value="{{ $banner->subtitle }}"
                class="w-full border p-3 rounded-lg">
        </div>
        <div class="mb-4">
            <label>Email</label>
            <input type="text"
                name="email"
                value="{{ $banner->email }}"
                class="w-full border p-3 rounded-lg">
        </div>

        <div class="mb-4">
            <label>Phone</label>
            <input type="text"
                name="phone"
                value="{{ $banner->phone }}"
                class="w-full border p-3 rounded-lg">
        </div>

        <div class="mb-4">
            <label>Description</label>
            <textarea
                name="description"
                rows="5"
                class="w-full border p-3 rounded-lg">{{ $banner->description }}</textarea>
        </div>

        @if($banner->banner_image)
            <img
                src="{{ asset($banner->banner_image) }}"
                class="w-40 rounded-lg mb-4">
        @endif

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

                <option value="active"
                    {{ $banner->status == 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="inactive"
                    {{ $banner->status == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>
        </div>

        <button
            class="bg-green-500 text-white px-6 py-3 rounded-xl">
            Update Banner
        </button>

    </form>

</div>

@endsection