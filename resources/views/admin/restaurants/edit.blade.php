@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded shadow p-8">

    <h1 class="text-3xl font-bold mb-8">
        Edit Restaurant
    </h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 font-semibold">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
        action="{{ route('admin.restaurants.update',$restaurant->id) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- Login Credentials Card -->
        <div class="mb-8 bg-blue-50/70 p-6 rounded-2xl border border-blue-200">
            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                <svg width="22" height="22" fill="none" stroke="#2563EB" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"/></svg>
                Restaurant Admin Account Login Credentials
            </h3>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="font-semibold block mb-1">Login Email Address</label>
                    <input type="email"
                    name="email"
                    required
                    value="{{ old('email', $restaurant->email) }}"
                    class="w-full border border-gray-300 p-3 rounded-xl bg-white focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Changes the login email for this restaurant's admin user.</p>
                </div>

                <div>
                    <label class="font-semibold block mb-1">New Password <span class="text-xs font-normal text-gray-500">(Leave blank to keep current)</span></label>
                    <div class="relative">
                        <input type="password"
                        id="edit_restaurant_password"
                        name="password"
                        placeholder="Enter new password if changing"
                        class="w-full border border-gray-300 p-3 pr-12 rounded-xl bg-white focus:ring-2 focus:ring-blue-500"
                        autocomplete="new-password">
                        <button type="button" 
                                onclick="togglePasswordVisibility('edit_restaurant_password', 'edit_pw_eye_icon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none p-1.5"
                                title="Toggle password visibility">
                            <svg id="edit_pw_eye_icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Min 8 chars: uppercase, lowercase, number & special character (@$!%*?&).</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">

            <div>

                <label>Name</label>

                <input type="text"
                name="name"
                required
                value="{{ old('name', $restaurant->name) }}"
                class="w-full border p-3 rounded">

            </div>

            <div>

                <label>Phone</label>

                <input type="text"
                name="phone"
                required
                value="{{ old('phone', $restaurant->phone) }}"
                class="w-full border p-3 rounded">

            </div>

            <!-- Address Search Component -->
            <div class="col-span-2 mt-4 bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                <label class="font-bold text-gray-800 block mb-2 flex items-center gap-2 text-base">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                    Search & Update Restaurant Address
                </label>
                <div class="relative">
                    <input
                        type="text"
                        id="leafletSearchInput"
                        value="{{ $restaurant->location }}"
                        placeholder="Type to search area, street name, postcode..."
                        class="w-full border border-blue-200 rounded-xl p-4 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800 shadow-sm"
                        autocomplete="off"
                    >
                    <div id="leafletSearchResults" class="absolute left-0 right-0 top-full bg-white border border-gray-200 rounded-xl mt-1 max-h-60 overflow-y-auto z-[9999] shadow-2xl hidden"></div>
                </div>
                <div id="restaurantMapContainer" class="mt-4 rounded-xl border border-blue-200 overflow-hidden shadow-inner" style="height: 240px;">
                    <div id="restaurantMap" style="width: 100%; height: 100%;"></div>
                </div>
                <p class="text-xs text-blue-700 mt-2 font-medium">💡 Search address above to fill details automatically.</p>
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

                <label>Address (Location)</label>

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

        <!-- Dietary Categories -->
        <div class="mt-5">
            <label class="font-semibold block mb-2">
                Dietary Categories
            </label>
            @php
                $savedDietary = old('dietary_categories', $restaurant->dietary_categories ?? []);
            @endphp
            <div class="flex flex-wrap gap-4 p-4 border border-gray-300 rounded-xl bg-gray-50">
                <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-700">
                    <input type="checkbox" name="dietary_categories[]" value="halal" {{ in_array('halal', $savedDietary) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <span>🌙 Halal</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-700">
                    <input type="checkbox" name="dietary_categories[]" value="vegan" {{ in_array('vegan', $savedDietary) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <span>🌱 Vegan</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-700">
                    <input type="checkbox" name="dietary_categories[]" value="vegetarian" {{ (in_array('vegetarian', $savedDietary) || in_array('vegetable', $savedDietary)) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <span>🥗 Vegetarian</span>
                </label>
            </div>
            <small class="text-gray-500">Select any or all dietary categories served by this restaurant.</small>
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
            <a href="{{ file_exists(public_path($restaurant->hygiene_certificate)) ? asset($restaurant->hygiene_certificate) : asset('storage/'.$restaurant->hygiene_certificate) }}"
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

@endsection

{{-- Leaflet Assets & Auto-fill Script --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latInput = document.querySelector('[name="latitude"]');
    const lngInput = document.querySelector('[name="longitude"]');
    const locationInput = document.querySelector('[name="location"]');
    const cityInput = document.querySelector('[name="city"]');
    const stateInput = document.querySelector('[name="state"]');
    const countryInput = document.querySelector('[name="country"]');
    const postcodeInput = document.querySelector('[name="postcode"]');

    const searchInput = document.getElementById('leafletSearchInput');
    const searchResults = document.getElementById('leafletSearchResults');

    let defaultLat = parseFloat(latInput?.value) || 51.5074;
    let defaultLng = parseFloat(lngInput?.value) || -0.1278;

    const map = L.map('restaurantMap', {
        center: [defaultLat, defaultLng],
        zoom: (latInput?.value && lngInput?.value) ? 15 : 12,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    function updateAddressFromCoords(lat, lng) {
        if (latInput) latInput.value = lat.toFixed(7);
        if (lngInput) lngInput.value = lng.toFixed(7);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`, {
            headers: { 'Accept-Language': 'en-GB' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data) return;
            const a = data.address || {};
            const street = [a.house_number, a.road || a.pedestrian || a.suburb || a.neighbourhood].filter(Boolean).join(', ');
            const fullAddress = data.display_name || street || '';
            const city = a.city || a.town || a.village || a.county || '';
            const state = a.state || a.county || '';
            const country = a.country || 'United Kingdom';
            const postcode = a.postcode || '';

            if (locationInput) locationInput.value = fullAddress;
            if (cityInput) cityInput.value = city;
            if (stateInput) stateInput.value = state;
            if (countryInput) countryInput.value = country;
            if (postcodeInput) postcodeInput.value = postcode;
            if (searchInput) searchInput.value = fullAddress;
        })
        .catch(err => console.error('Reverse geocode error:', err));
    }

    marker.on('dragend', function (e) {
        const coord = e.target.getLatLng();
        updateAddressFromCoords(coord.lat, coord.lng);
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateAddressFromCoords(e.latlng.lat, e.latlng.lng);
    });

    let searchDebounce;
    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const q = e.target.value.trim();
            clearTimeout(searchDebounce);
            if (q.length < 3) {
                searchResults.classList.add('hidden');
                searchResults.innerHTML = '';
                return;
            }
            searchDebounce = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=6&countrycodes=gb&q=${encodeURIComponent(q)}`, {
                    headers: { 'Accept-Language': 'en-GB' }
                })
                .then(res => res.json())
                .then(results => {
                    searchResults.innerHTML = '';
                    if (!results || !results.length) {
                        searchResults.classList.add('hidden');
                        return;
                    }
                    results.forEach(r => {
                        const item = document.createElement('div');
                        item.className = 'p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 text-sm text-gray-800 font-medium transition';
                        item.textContent = r.display_name;
                        item.addEventListener('click', function () {
                            const lat = parseFloat(r.lat);
                            const lng = parseFloat(r.lon);

                            map.setView([lat, lng], 16);
                            marker.setLatLng([lat, lng]);

                            const a = r.address || {};
                            const street = [a.house_number, a.road || a.pedestrian || a.suburb || a.neighbourhood].filter(Boolean).join(', ');
                            const fullAddress = r.display_name || street || '';
                            const city = a.city || a.town || a.village || a.county || '';
                            const state = a.state || a.county || '';
                            const country = a.country || 'United Kingdom';
                            const postcode = a.postcode || '';

                            if (locationInput) locationInput.value = fullAddress;
                            if (cityInput) cityInput.value = city;
                            if (stateInput) stateInput.value = state;
                            if (countryInput) countryInput.value = country;
                            if (postcodeInput) postcodeInput.value = postcode;
                            if (latInput) latInput.value = lat.toFixed(7);
                            if (lngInput) lngInput.value = lng.toFixed(7);

                            searchInput.value = fullAddress;
                            searchResults.classList.add('hidden');
                        });
                        searchResults.appendChild(item);
                    });
                    searchResults.classList.remove('hidden');
                })
                .catch(err => console.error('Search error:', err));
            }, 350);
        });

        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }
});

function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!input) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        if (icon) {
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        }
    } else {
        input.type = 'password';
        if (icon) {
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }
}
</script>