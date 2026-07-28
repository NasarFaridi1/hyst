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

        <a href="{{ route('admin.restaurants.index') }}"
        class="bg-gray-800 hover:bg-black text-white px-6 py-3 rounded-xl">

            Back

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow p-10">

        <form method="POST"
        action="{{ route('admin.restaurants.store') }}"
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
                    required
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
                    required
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
                    required
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
                    required
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
                    required
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
                    required
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
                    required
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
                    required
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
                    required
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
                    required
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
                    required
                    class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            </div>

            <div class="mt-4">

                <label class="font-semibold block mb-2">

                    Categories

                </label>

                <select
                    name="category_ids[]"
                    required
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
                required
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
                    id="image"
                    name="image"
                    required
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-xl p-4">

                <p id="image-error" class="text-red-500 text-sm mt-1"></p>
            </div>

            <script>
            document.getElementById('image').addEventListener('change', function () {
                const file = this.files[0];
                const error = document.getElementById('image-error');

                error.textContent = '';

                if (file && file.size > 2 * 1024 * 1024) { // 2 MB
                    error.textContent = 'Image size must not exceed 2 MB.';
                    this.value = '';
                }
            });
            </script>

            <div class="mt-4">
                <label class="font-semibold block mb-2">
                    Hygiene Rating
                </label>

                <input
                    type="number"
                    name="hygiene_rating"
                    required
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
                    id="hygiene_certificate"
                    name="hygiene_certificate"
                    required
                    accept=".jpg,.jpeg,.png"
                    class="w-full border border-gray-300 rounded-xl p-4">

                <p id="certificate-error" class="text-red-500 text-sm mt-1"></p>
            </div>

            <script>
            document.getElementById('hygiene_certificate').addEventListener('change', function () {
                const file = this.files[0];
                const error = document.getElementById('certificate-error');

                error.textContent = '';

                if (file && file.size > 2 * 1024 * 1024) { // 2 MB
                    error.textContent = 'File size must not exceed 2 MB.';
                    this.value = '';
                }
            });
            </script>

            <!-- Status -->

            <div class="mt-4">

                <label class="font-semibold block mb-2">

                    Status

                </label>

                <select
                name="status"
                class="w-full border border-gray-300 rounded-xl p-4">

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>

                </select>

            </div>

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