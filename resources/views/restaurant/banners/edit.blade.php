@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto p-8">

    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-xl font-semibold mb-6">
            Edit Banner
        </h2>

        <form method="POST"
            action="{{ route('restaurant.banners.update',$banner->id) }}"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-5">

                <img
                    src="{{ asset($banner->image) }}"
                    class="w-full h-48 rounded-lg object-cover mb-4">

                <label class="block mb-2">
                    Change Banner
                </label>

                <input
                    type="file"
                    name="image"
                    class="w-full border rounded-lg p-2">

            </div>

            <div class="mb-5">

                <label class="block mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border rounded-lg p-2">

                    <option value="1" {{ $banner->status ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0" {{ !$banner->status ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

            <button
                class="bg-blue-600 text-white px-5 py-2 rounded-lg">
                Update Banner
            </button>

        </form>

    </div>

</div>

@endsection