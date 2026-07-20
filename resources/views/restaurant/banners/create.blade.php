@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto p-8">

    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-xl font-semibold mb-6">
            Add Banner
        </h2>

        <form method="POST"
            action="{{ route('restaurant.banners.store') }}"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-5">

                <label class="block mb-2">
                    Banner Image
                </label>

                <input
                    type="file"
                    name="image"
                    required
                    class="w-full border rounded-lg p-2">

            </div>

            <div class="mb-5">

                <label class="block mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border rounded-lg p-2">

                    <option value="1">Active</option>

                    <option value="0">Inactive</option>

                </select>

            </div>

            <button
                class="bg-blue-600 text-white px-5 py-2 rounded-lg">
                Save Banner
            </button>

        </form>

    </div>

</div>

@endsection