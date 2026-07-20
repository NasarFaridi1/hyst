@extends('layouts.app')

@section('content')

<div class="p-10">

    <div class="bg-white shadow rounded p-6 max-w-2xl">

        <h1 class="text-2xl font-bold mb-6">
            Edit Vendor
        </h1>

        <form method="POST"
        action="{{ route('admin.vendor.update',$vendor->id) }}">

            @csrf
            @method('PUT')

            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Name
                </label>

                <input type="text"
                name="name"
                value="{{ $vendor->name }}"
                class="w-full border rounded px-4 py-3"
                required>

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Email
                </label>

                <input type="email"
                name="email"
                value="{{ $vendor->email }}"
                class="w-full border rounded px-4 py-3"
                required>

            </div>

            <button
            class="bg-blue-500 text-white px-6 py-3 rounded">

                Update Vendor

            </button>

        </form>

    </div>

</div>

@endsection