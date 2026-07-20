@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto">

        <h1 class="text-4xl font-bold mb-8">

            Restaurant Profile

        </h1>

        <div class="bg-white rounded-2xl shadow p-10">

            <form method="POST" action="/restaurant/profile/update" enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-2 gap-6">

                    <div>

                        <label class="font-bold block mb-2">

                            Name

                        </label>

                        <input type="text" name="name" value="{{ $restaurant->name }}" class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Email

                        </label>

                        <input type="email" name="email" value="{{ $restaurant->email }}"
                            class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Phone

                        </label>

                        <input type="text" name="phone" value="{{ $restaurant->phone }}"
                            class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Location

                        </label>

                        <input type="text" name="location" value="{{ $restaurant->location }}"
                            class="w-full border p-4 rounded-xl">

                    </div>
                    <div>

                        <label class="font-bold block mb-2">

                            Latitude

                        </label>

                        <input type="number" name="latitude" id="latitude" step="any" value="{{ $restaurant->latitude }}"
                            class="w-full border p-4 rounded-xl">
                    </div>
                    <div>

                        <label class="font-bold block mb-2">

                            Longitude

                        </label>

                        <input type="number" name="longitude" id="longitude" step="any" value="{{ $restaurant->longitude }}"
                            class="w-full border p-4 rounded-xl">
                    </div>

                </div>


                <div class="grid grid-cols-2 gap-6 mt-6">

                    <div>
                        <label class="font-bold block mb-2">
                            Hygiene Rating
                        </label>

                        <input
                            type="number"
                            name="hygiene_rating"
                            step="0.1"
                            min="0"
                            max="5"
                            value="{{ old('hygiene_rating', $restaurant->hygiene_rating) }}"
                            class="w-full border p-4 rounded-xl">
                    </div>

                    <div>
                        <label class="font-bold block mb-2">
                            Hygiene Certificate
                        </label>

                       @if($restaurant->hygiene_certificate)
                            <a href="{{ asset($restaurant->hygiene_certificate) }}" class="text-blue-600 text-sm underline" target="_blank">
                                View Current Certificate
                            </a>
                        @endif

                        <input
                            type="file"
                            name="hygiene_certificate"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full border p-4 rounded-xl">
                    </div>

                </div>

                <div class="mt-6">

                    <label class="font-bold block mb-2">

                        Description

                    </label>

                    <textarea name="description" rows="5"
                        class="w-full border p-4 rounded-xl">{{ $restaurant->description }}</textarea>

                </div>

                

                    <div class="mt-6">
                        <label class="font-bold block mb-3">
                            Working Days
                        </label>

                        @php
                            $selectedDays = old(
                                'working_days',
                                $restaurant->working_days ? explode(',', $restaurant->working_days) : []
                            );
                        @endphp

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                            @foreach([
                                'Monday',
                                'Tuesday',
                                'Wednesday',
                                'Thursday',
                                'Friday',
                                'Saturday',
                                'Sunday'
                            ] as $day)

                                <label class="flex items-center gap-2 border rounded-lg p-3 cursor-pointer hover:bg-gray-50">

                                    <input
                                        type="checkbox"
                                        name="working_days[]"
                                        value="{{ $day }}"
                                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600">

                                    <span>{{ $day }}</span>

                                </label>

                            @endforeach

                        </div>
                    </div>
                <div class="grid grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="font-bold block mb-2">
                            Opening Time
                        </label>

                        <input
                            type="time"
                            name="opening_time"
                            value="{{ old('opening_time', $restaurant->opening_time) }}"
                            class="w-full border p-4 rounded-xl">
                    </div>

                    <div>
                        <label class="font-bold block mb-2">
                            Closing Time
                        </label>

                        <input
                            type="time"
                            name="closing_time"
                            value="{{ old('closing_time', $restaurant->closing_time) }}"
                            class="w-full border p-4 rounded-xl">
                    </div>

                </div>

                <div class="mt-6">

                    @if($restaurant->image)

                        <img src="{{ asset('storage/' . $restaurant->image) }}" class="w-32 h-32 rounded-xl object-cover mb-5">

                    @endif

                    <input type="file" name="image" class="w-full border p-4 rounded-xl">

                </div>

                <div>
                    <label class="font-bold block mb-2">
                        Delivery Methods
                    </label>

                <label class="font-bold block mb-2">
                    Dine In
                </label>

                <select
                    name="dine_in"
                    class="w-full border p-4 rounded-xl">

                    <option
                        value="1"
                        {{ $restaurant->dine_in ? 'selected' : '' }}>
                        Enable
                    </option>

                    <option
                        value="0"
                        {{ !$restaurant->dine_in ? 'selected' : '' }}>
                        Disable
                    </option>

                </select>

            </div>

            <div>

                <label class="font-bold block mb-2">
                    Home Delivery
                </label>

                <select
                    name="home_delivery"
                    class="w-full border p-4 rounded-xl">

                    <option
                        value="1"
                        {{ $restaurant->home_delivery ? 'selected' : '' }}>
                        Enable
                    </option>

                    <option
                        value="0"
                        {{ !$restaurant->home_delivery ? 'selected' : '' }}>
                        Disable
                    </option>

                </select>

            </div>

                <button class="bg-blue-500 text-white px-10 py-4 rounded-xl mt-8">

                    Update Profile

                </button>

            </form>

        </div>

    </div>

    <script>

        const locationInput = document.querySelector('[name="location"]');

        locationInput.addEventListener('change', async function () {

            const address = this.value;

            const apiKey = "YOUR_GOOGLE_MAP_API_KEY";

            const url =
                `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=${apiKey}`;

            const response = await fetch(url);

            const data = await response.json();

            if (data.results.length > 0) {

                const location = data.results[0].geometry.location;

                document.getElementById('latitude').value = location.lat;

                document.getElementById('longitude').value = location.lng;
            }
        });

    </script>

@endsection