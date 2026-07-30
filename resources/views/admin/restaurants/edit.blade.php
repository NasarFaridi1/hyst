@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded shadow p-8">

    <h1 class="text-3xl font-bold mb-8">

        Edit Restaurant

    </h1>

    <form method="POST"
        action="{{ route('admin.restaurants.update',$restaurant->id) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-5">

            <div>

                <label>Name</label>

                <input type="text"
                name="name"
                required
                value="{{ $restaurant->name }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Email</label>

                <input type="email"
                name="email"
                required
                value="{{ $restaurant->email }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Phone</label>

                <input type="text"
                name="phone"
                required
                value="{{ $restaurant->phone }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>City</label>

                <input type="text"
                name="city"
                required
                value="{{ $restaurant->city }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>State</label>

                <input type="text"
                name="state"
                required
                value="{{ $restaurant->state }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>Country</label>

                <input type="text"
                name="country"
                required
                value="{{ $restaurant->country }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Postal Code</label>

                <input type="text"
                name="postcode"
                required
                value="{{ $restaurant->postcode }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Latitude</label>

                <input type="text"
                name="latitude"
                required
                value="{{ $restaurant->latitude }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>Longitude</label>

                <input type="text"
                name="longitude"
                required
                value="{{ $restaurant->longitude }}"
                class="w-full border p-3 rounded">

            </div>
            <div>

                <label>Address</label>

                <input type="text"
                name="location"
                required
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
                required
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
            required
            rows="5"
            class="w-full border p-3 rounded">{{ $restaurant->description }}</textarea>

        </div>
        <div>
            <label>Hygiene Rating</label>

            <input
                type="number"
                name="hygiene_rating"
                required
                step="0.1"
                min="0"
                max="5"
                value="{{ $restaurant->hygiene_rating }}"
                class="w-full border p-3 rounded">
        </div>

        <div>
            <label class="block mb-2 font-medium">Status</label>
            <select name="status" class="w-full border p-3 rounded">
                <option value="1" {{ (int)$restaurant->status === 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ (int)$restaurant->status === 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            @php
                $restUser = \App\Models\User::where('restaurant_id', $restaurant->id)
                    ->orWhere('email', $restaurant->email)
                    ->first();
            @endphp
            <label class="block mb-2 font-medium">Email Verification Status</label>
            <div class="flex items-center gap-3">
                @if($restUser && ($restUser->email_verified || $restUser->email_verified_at))
                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-semibold">
                        ✓ Verified
                    </span>
                @else
                    <span class="bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm font-semibold">
                        ✕ Unverified
                    </span>
                @endif
            </div>
        </div>

        
<div class="mt-5">

    @if($restaurant->image)
        <img
            src="{{ asset('storage/'.$restaurant->image) }}"
            class="w-32 h-32 rounded object-cover mb-5"
            id="image-preview">
    @endif

    <input
        type="file"
        id="image"
        name="image"
       
        accept=".jpg,.jpeg,.png,.webp"
        onchange="validateFileSize(this,'image-error',2)">

    <p id="image-error" class="text-red-500 text-sm mt-2"></p>

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
        id="hygiene_certificate"
        name="hygiene_certificate"
        
        accept=".pdf,.jpg,.jpeg,.png"
        class="w-full border p-3 rounded"
        onchange="validateFileSize(this,'certificate-error',2)">

    <p id="certificate-error" class="text-red-500 text-sm mt-2"></p>

</div>

<script>
function validateFileSize(input, errorId, maxSizeMB) {
    const error = document.getElementById(errorId);
    error.textContent = '';

    if (!input.files.length) return;

    const file = input.files[0];
    const maxSize = maxSizeMB * 1024 * 1024;

    if (file.size > maxSize) {
        error.textContent = `File size must not exceed ${maxSizeMB} MB.`;
        input.value = '';

        // Hide image preview if image input is cleared
        if (input.name === 'image') {
            const preview = document.getElementById('image-preview');
            if (preview) {
                preview.style.display = 'none';
            }
        }
    }
}
</script>

        

<div class="mt-8 border-t pt-6">
    <h3 class="text-xl font-bold mb-4">Payment Gateway Settings</h3>
    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="block mb-2 font-medium">Worldpay Business ID</label>
            <input type="text"
            name="worldpay_business_id"
            value="{{ old('worldpay_business_id', $restaurant->worldpay_business_id) }}"
            class="w-full border p-3 rounded"
            placeholder="example: 90809">
        </div>

        <div>
            <label class="block mb-2 font-medium">Worldpay Username</label>
            <input type="text"
            name="worldpay_username"
            value="{{ old('worldpay_username', $restaurant->worldpay_username) }}"
            class="w-full border p-3 rounded"
            placeholder="example: 90809.1">
        </div>

        <div>
            <label class="block mb-2 font-medium">Worldpay Password</label>
            <input type="text"
            name="worldpay_password"
            value="{{ old('worldpay_password', $restaurant->worldpay_password) }}"
            class="w-full border p-3 rounded"
            placeholder="example: dsgfdhdfhag51621gsdf">
        </div>
    </div>
</div>

        <button
        class="bg-green-500 text-white px-8 py-3 rounded mt-5">

            Update Restaurant

        </button>

    </form>

</div>

@endsection