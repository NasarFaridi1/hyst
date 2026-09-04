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
                <!-- Password -->
                <div>
                    <label class="font-semibold block mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="admin_restaurant_password"
                            required
                            placeholder="e.g. HystPass123!"
                            class="w-full border border-gray-300 rounded-xl p-4 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        <button type="button" 
                                onclick="togglePasswordVisibility('admin_restaurant_password', 'pw_eye_icon_admin')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                                title="Toggle password visibility">
                            <svg id="pw_eye_icon_admin" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs font-bold mt-1.5 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                    <div class="mt-2.5 p-3.5 bg-blue-50/60 border border-blue-100 rounded-xl text-xs text-gray-700">
                        <p class="font-bold text-gray-800 mb-1 flex items-center gap-1">
                            <span>🔒</span> Password Requirements:
                        </p>
                        <ul class="list-disc list-inside space-y-0.5 text-gray-600">
                            <li>Minimum 8 characters</li>
                            <li>At least 1 uppercase letter (A-Z)</li>
                            <li>At least 1 lowercase letter (a-z)</li>
                            <li>At least 1 number (0-9)</li>
                            <li>At least 1 special character (@$!%*?& or symbols)</li>
                        </ul>
                        <p class="mt-2 text-blue-700 font-semibold">
                            💡 Example Password: <code class="bg-white px-2 py-0.5 rounded border border-blue-200 text-blue-900 font-mono">HystPass123!</code>
                        </p>
                    </div>
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

                <!-- Address Search Component -->
                <div class="col-span-2 mt-4 bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                    <label class="font-bold text-gray-800 block mb-2 flex items-center gap-2 text-base">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        Search & Select Restaurant Address
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="leafletSearchInput"
                            placeholder="Type to search area, street name, postcode..."
                            class="w-full border border-blue-200 rounded-xl p-4 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800 shadow-sm"
                            autocomplete="off"
                        >
                        <div id="leafletSearchResults" class="absolute  left-0 right-0 top-full bg-white border border-gray-200 rounded-xl mt-1 max-h-60 overflow-y-auto z-[9999] shadow-2xl hidden"></div>
                    </div>
                    <div id="restaurantMapContainer" class="mt-4 rounded-xl border border-blue-200 overflow-hidden shadow-inner" style="height: 240px;">
                        <div id="restaurantMap" style="width: 100%; height: 100%;"></div>
                    </div>
                    <p class="text-xs text-blue-700 mt-2 font-medium">💡 Search address above to fill details automatically.</p>
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

                        Longitude

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

            <!-- Address (Location) -->
            <div class="mt-4">
                <label class="font-semibold block mb-2">
                    Address (Location)
                </label>

                <textarea
                    name="location"
                    rows="3"
                    placeholder="Full address text will be auto-filled here"
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

            </div>

            <!-- Dietary Categories -->
            <div class="mt-4">
                <label class="font-semibold block mb-2">
                    Dietary Categories
                </label>
                <div class="flex flex-wrap gap-4 p-4 border border-gray-300 rounded-xl bg-gray-50">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-700">
                        <input type="checkbox" name="dietary_categories[]" value="halal" {{ in_array('halal', old('dietary_categories', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                        <span>🌙 Halal</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-700">
                        <input type="checkbox" name="dietary_categories[]" value="vegan" {{ in_array('vegan', old('dietary_categories', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                        <span>🌱 Vegan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-700">
                        <input type="checkbox" name="dietary_categories[]" value="vegetarian" {{ (in_array('vegetarian', old('dietary_categories', [])) || in_array('vegetable', old('dietary_categories', []))) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                        <span>🥗 Vegetarian</span>
                    </label>
                </div>
                <small class="text-gray-500">Select any or all dietary categories served by this restaurant.</small>
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

            <!-- Payment Gateway Settings -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-bold mb-4">Payment Gateway Settings</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold block mb-2">Worldpay Business ID</label>
                        <input
                            type="text"
                            name="worldpay_business_id"
                            value="{{ old('worldpay_business_id') }}"
                            placeholder="example: 90809"
                            class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="font-semibold block mb-2">Worldpay Username</label>
                        <input
                            type="text"
                            name="worldpay_username"
                            value="{{ old('worldpay_username') }}"
                            placeholder="example: 90809.1"
                            class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="font-semibold block mb-2">Worldpay Password</label>
                        <input
                            type="text"
                            name="worldpay_password"
                            value="{{ old('worldpay_password') }}"
                            placeholder="example: dsgfdhdfhag51621gsdf"
                            class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
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