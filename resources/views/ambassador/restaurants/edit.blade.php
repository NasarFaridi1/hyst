@extends('layouts.app')

@section('content')

<div class="bg-white rounded shadow p-8">

    <h1 class="text-3xl font-bold mb-8">

        Edit Restaurant

    </h1>

    <form method="POST"
        action="{{ route('ambassador.restaurants.update',$restaurant->id) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-5">

            <div>

                <label>Name</label>

                <input type="text"
                name="name"
                value="{{ $restaurant->name }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Email</label>

                <input type="email"
                name="email"
                value="{{ $restaurant->email }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Phone</label>

                <input type="text"
                name="phone"
                value="{{ $restaurant->phone }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>City</label>

                <input type="text"
                name="city"
                value="{{ $restaurant->city }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>State</label>

                <input type="text"
                name="state"
                value="{{ $restaurant->state }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>Country</label>

                <input type="text"
                name="country"
                value="{{ $restaurant->country }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Postal Code</label>

                <input type="text"
                name="postcode"
                value="{{ $restaurant->postcode }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Latitude</label>

                <input type="text"
                name="latitude"
                value="{{ $restaurant->latitude }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>Longitude</label>

                <input type="text"
                name="longitude"
                value="{{ $restaurant->longitude }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>Address</label>

                <input type="text"
                name="location"
                value="{{ $restaurant->location }}"
                class="w-full border p-3 rounded">

            </div>

            <div class="mt-5">

                <label>Status</label>

                <select
                    name="status"
                    class="w-full border p-3 rounded">

                    <option
                        value="1"
                        {{ $restaurant->status == 1 ? 'selected' : '' }}>
                        Active
                    </option>

                    <option
                        value="0"
                        {{ $restaurant->status == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <div>

            <label class="font-semibold block mb-2">

                Categories

            </label>

            <select
                name="category_ids[]"
                multiple
                class="w-full border border-gray-300 rounded-xl p-4">

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ in_array($category->id,$restaurant->category_ids ?? []) ? 'selected' : '' }}>

                        {{ $category->name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mt-5">

            <label>Description</label>

            <textarea
            name="description"
            rows="5"
            class="w-full border p-3 rounded">{{ $restaurant->description }}</textarea>

        </div>
        <div>
            <label>Hygiene Rating</label>

            <input
                type="number"
                name="hygiene_rating"
                step="0.1"
                min="0"
                max="5"
                value="{{ $restaurant->hygiene_rating }}"
                class="w-full border p-3 rounded">
        </div>

        

        <div class="mt-5">

            @if($restaurant->image)

            <img
            src="{{ asset('storage/'.$restaurant->image) }}"
            class="w-32 h-32 rounded object-cover mb-5">

            @endif

            <input type="file" name="image">

        </div>

        <div class="mt-5">

            <label class="block mb-2">
                Hygiene Certificate
            </label>

            @if($restaurant->hygiene_certificate)
                <div class="mb-3">
                    <a href="{{ asset('storage/'.$restaurant->hygiene_certificate) }}"
                    target="_blank"
                    class="text-blue-600 underline">
                        View Current Certificate
                    </a>
                </div>
            @endif

            <input
                type="file"
                name="hygiene_certificate"
                accept=".pdf,.jpg,.jpeg,.png"
                class="w-full border p-3 rounded">

        </div>

        

        <button
        class="bg-green-500 text-white px-8 py-3 rounded mt-5">

            Update Restaurant

        </button>

    </form>

</div>

@endsection