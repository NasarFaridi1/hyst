@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow">

    <h1 class="text-3xl font-bold mb-8">
        Add Category
    </h1>

    <form method="POST"
    action="{{ route('admin.marketing-banner-categories.store') }}">

        @csrf

        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Name
            </label>

            <input
            type="text"
            name="name"
            class="w-full border rounded-xl px-4 py-3"
            required>

        </div>

        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Description
            </label>

            <textarea
            name="description"
            rows="4"
            class="w-full border rounded-xl px-4 py-3"></textarea>

        </div>

        <div class="mb-6">

            <label class="block mb-2 font-semibold">
                Status
            </label>

            <select
            name="status"
            class="w-full border rounded-xl px-4 py-3">

                <option value="1">
                    Active
                </option>

                <option value="0">
                    Inactive
                </option>

            </select>

        </div>

        <button
        class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-xl">

            Save Category

        </button>

    </form>

</div>

@endsection