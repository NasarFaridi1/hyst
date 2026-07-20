@extends('layouts.app')

@section('content')

<div class="p-10">

    <div class="bg-white shadow rounded p-6 max-w-2xl">

        <h1 class="text-2xl font-bold mb-6">
            Add Vendor
        </h1>

        <form method="POST"
        action="{{ route('admin.vendor.store') }}">

            @csrf

            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Name
                </label>

                <input type="text"
                name="name"
                class="w-full border rounded px-4 py-3"
                placeholder="Enter vendor name"
                required>

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Email
                </label>

                <input type="email"
                name="email"
                class="w-full border rounded px-4 py-3"
                placeholder="Enter email"
                required>

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Password
                </label>

                <input type="password"
                name="password"
                class="w-full border rounded px-4 py-3"
                placeholder="Enter password"
                required>

            </div>

            <button
            class="bg-green-500 text-white px-6 py-3 rounded">

                Save Vendor

            </button>

        </form>

    </div>

</div>

@endsection