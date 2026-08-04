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

                        <input @disabled(true) @readonly(true) type="email" name="email" value="{{ $restaurant->email }}"
                            class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Phone

                        </label>

                        <input type="text" name="phone" value="{{ $restaurant->phone }}"
                            class="w-full border p-4 rounded-xl">

                    </div>

                    <!-- Address Search Component -->
                    <div class="col-span-2 mt-2 bg-[#FFF7F3] p-6 rounded-2xl border border-[#FFEFE6]">
                        <label class="font-bold text-[#0D0D0D] block mb-2 flex items-center gap-2 text-base">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="2.2"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                            Search & Update Restaurant Address
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="leafletSearchInput"
                                value="{{ $restaurant->location }}"
                                placeholder="Type to search area, street name, postcode..."
                                class="w-full border border-[#F0E4D8] rounded-xl p-4 pr-10 focus:outline-none focus:ring-2 focus:ring-[#C25A2A] bg-white text-[#0D0D0D] shadow-sm"
                                autocomplete="off"
                            >
                            <div id="leafletSearchResults" class="absolute left-0 right-0 top-full bg-white border border-gray-200 rounded-xl mt-1 max-h-60 overflow-y-auto z-[9999] shadow-2xl hidden"></div>
                        </div>
                        {{-- <div id="restaurantMapContainer" class="mt-4 rounded-xl border border-[#F0E4D8] overflow-hidden shadow-inner" style="height: 240px;">
                            <div id="restaurantMap" style="width: 100%; height: 100%;"></div>
                        </div> --}}
                        <p class="text-xs text-[#C25A2A] mt-2 font-medium">💡 Search address above to fill details automatically.</p>
                    </div>

                    <div>

                        <label>City</label>

                        <input type="text"
                        name="city"
                        required
                        value="{{ $restaurant->city }}"
                        class="w-full border p-4 rounded-xl">

                    </div>
                    <div>

                        <label>State</label>

                        <input type="text"
                        name="state"
                        required
                        value="{{ $restaurant->state }}"
                        class="w-full border p-4 rounded-xl">

                    </div>
                    <div>

                        <label>Country</label>

                        <input type="text"
                        name="country"
                        required
                        value="{{ $restaurant->country }}"
                        class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label>Postal Code</label>

                        <input type="text"
                        name="postcode"
                        required
                        value="{{ $restaurant->postcode }}"
                        class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                           Address (Location)

                        </label>

                        <input type="text" name="location" value="{{ $restaurant->location }}"
                            class="w-full border p-4 rounded-xl">

                    </div>


                    <div>

                        <label class="font-bold block mb-2">

                            Latitude

                        </label>

                        <input type="text" name="latitude" id="latitude" value="{{ $restaurant->latitude }}"
                            class="w-full border p-4 rounded-xl">
                    </div>
                    <div>

                        <label class="font-bold block mb-2">

                            Longitude

                        </label>

                        <input type="text" name="longitude" id="longitude" value="{{ $restaurant->longitude }}"
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

                <div class="mt-6">
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

                <div class="mt-8 pt-6 border-t">
                    <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center gap-2">
                        🕒 Delivery Time Options
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-bold block mb-2 text-gray-700">
                                ⚡ As Soon As Possible (ASAP Delivery)
                            </label>
                            <select name="allow_asap" class="w-full border p-4 rounded-xl">
                                <option value="1" {{ ($restaurant->allow_asap ?? true) ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ !($restaurant->allow_asap ?? true) ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold block mb-2 text-gray-700">
                                📅 Schedule Delivery (Date & Time Selection)
                            </label>
                            <select name="allow_schedule" class="w-full border p-4 rounded-xl">
                                <option value="1" {{ ($restaurant->allow_schedule ?? true) ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ !($restaurant->allow_schedule ?? true) ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button class="bg-blue-500 text-white px-10 py-4 rounded-xl mt-8">

                    Update Profile

                </button>

            </form>

        </div>

        <!-- CHANGE PASSWORD CARD -->
        <div class="bg-white rounded-2xl shadow p-10 mt-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                🔒 Change Password
            </h2>

            <form method="POST" action="{{ route('restaurant.profile.change-password') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="font-bold block mb-2 text-gray-700">
                            Current Password
                        </label>
                        <input
                            type="password"
                            name="current_password"
                            required
                            placeholder="••••••••"
                            class="w-full border p-4 rounded-xl @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-bold block mb-2 text-gray-700">
                            New Password
                        </label>
                        <input
                            type="password"
                            name="new_password"
                            required
                            placeholder="Minimum 8 characters"
                            class="w-full border p-4 rounded-xl @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-bold block mb-2 text-gray-700">
                            Confirm New Password
                        </label>
                        <input
                            type="password"
                            name="new_password_confirmation"
                            required
                            placeholder="Re-enter new password"
                            class="w-full border p-4 rounded-xl">
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="bg-[#C25A2A] hover:bg-[#C25A2A]/90 text-white font-bold px-8 py-3.5 rounded-xl shadow transition">
                        Update Password
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
                        item.className = 'p-3 hover:bg-[#FFF7F3] cursor-pointer border-b border-gray-100 text-sm text-gray-800 font-medium transition';
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
</script>