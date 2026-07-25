@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold">

                Add Restaurant

            </h1>

            <p class="text-gray-500 mt-2">

                Create new restaurant

            </p>

        </div>

        <a href="{{ route('ambassador.restaurants.index') }}"
        class="bg-gray-800 hover:bg-black text-white px-6 py-3 rounded-xl">

            Back

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow p-10">

        <form method="POST"
        action="{{ route('ambassador.restaurants.store') }}"
        enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-2 gap-4">

                <!-- Restaurant Name -->

                <div>

                    <label class="font-semibold block mb-2">

                        Restaurant Name

                    </label>

                    <input
                    type="text"
                    name="name"
                    placeholder="Enter restaurant name"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- Email -->

                <div>

                    <label class="font-semibold block mb-2">

                        Email

                    </label>

                    <input
                    type="email"
                    name="email"
                    placeholder="Enter email"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>
                <div class="">

                    <label class="font-semibold block mb-2">

                        Password

                    </label>

                    <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- Phone -->

                <div class="">

                    <label class="font-semibold block mb-2">

                        Phone

                    </label>

                    <input
                    type="text"
                    name="phone"
                    placeholder="Enter phone number"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- City -->

                <div class="">

                    <label class="font-semibold block mb-2">

                        City

                    </label>

                    <input
                    type="text"
                    name="city"
                    placeholder="Enter city"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- state -->

                <div class="">

                    <label class="font-semibold block mb-2">

                        State

                    </label>

                    <input
                    type="text"
                    name="state"
                    placeholder="Enter state"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>


                <!-- Country -->

                <div class="">

                    <label class="font-semibold block mb-2">

                        Country

                    </label>

                    <input
                    type="text"
                    name="country"
                    placeholder="Enter country"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>


                <!-- longitude -->

                <div class="">

                    <label class="font-semibold block mb-2">

                        longitude

                    </label>

                    <input
                    type="text"
                    name="longitude"
                    placeholder="Enter longitude"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- latitude -->

                <div class="">

                    <label class="font-semibold block mb-2">

                        Latitude

                    </label>

                    <input
                    type="text"
                    name="latitude"
                    placeholder="Enter latitude"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>


                <!-- Postal Code -->

                <div class="">

                    <label class="font-semibold block mb-2">

                        Postal Code

                    </label>

                    <input
                    type="text"
                    name="postcode"
                    placeholder="Enter Postal Code"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>




                

            </div>

            <!-- Address -->
            <div class="mt-4">
                <label class="font-semibold block mb-2">
                    Address
                </label>

                <textarea
                    name="location"
                    rows="4"
                    placeholder="Enter address"
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            </div>

            <div class="mt-4">

                <label class="font-semibold block mb-2">

                    Categories

                </label>

                <select
                    name="category_ids[]"
                    multiple
                    class="w-full border border-gray-300 rounded-xl p-4">

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}">

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

                <small class="text-gray-500">
                    Hold Ctrl (Windows) / Cmd (Mac) to select multiple.
                </small>

            </div>

            <!-- Description -->

            <div class="mt-4">

                <label class="font-semibold block mb-2">

                    Description

                </label>

                <textarea
                name="description"
                rows="5"
                placeholder="Restaurant description..."
                class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

            </div>

            <!-- Image -->

            <div class="mt-4">

                <label class="font-semibold block mb-2">

                    Restaurant Image

                </label>

                <input
                type="file"
                name="image"
                class="w-full border border-gray-300 rounded-xl p-4">

            </div>

            <div class="mt-4">
                <label class="font-semibold block mb-2">
                    Hygiene Rating
                </label>

                <input
                    type="number"
                    name="hygiene_rating"
                    step="0.1"
                    min="0"
                    max="5"
                    class="w-full border border-gray-300 rounded-xl p-4">
            </div>

            <div class="mt-4">
                <label class="font-semibold block mb-2">
                    Hygiene Certificate
                </label>

                <input
                    type="file"
                    name="hygiene_certificate"
                    accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full border border-gray-300 rounded-xl p-4">
            </div>

            <!-- Status -->

           

            <!-- Submit -->

            <div class="mt-6">

                <button
                class="bg-blue-500 hover:bg-blue-600 text-white px-10 py-4 rounded-xl text-lg">

                    Save Restaurant

                </button>

            </div>

        </form>

    </div>

</div>



@endsection