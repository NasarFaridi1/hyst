@extends('layouts.app')

@section('content')

{{-- Leaflet Map Assets (Free, No API Key Required) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    /* Ensure Leaflet stays beneath navigation dropdowns */
    .leaflet-pane {
        z-index: 10 !important;
    }
    .leaflet-top, .leaflet-bottom {
        z-index: 20 !important;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-700 mb-1">
                <span class="w-4 h-0.5 bg-emerald-600 inline-block rounded"></span>
                RESTAURANT DISPATCH • UBER DIRECT DELIVERY
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Create Direct Delivery
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                Pin customer destination on the map, build item list, calculate live Uber quote (+20% markup), and pay via Worldpay.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ url('/restaurant/orders') }}"
               class="bg-black hover:bg-gray-800 text-white font-semibold px-4 py-2.5 rounded-xl transition duration-150 inline-flex items-center gap-2 text-sm shadow">
                ← Back to Orders
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium flex items-center gap-2">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Restaurant Pickup Details Confirmation Banner --}}
    <div class="bg-emerald-50/60 border border-emerald-200/80 rounded-2xl p-4 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                    🏬
                </div>
                <div>
                    <div class="text-xs font-bold uppercase text-emerald-800 tracking-wide">Pickup Location (Your Restaurant)</div>
                    <div class="font-extrabold text-gray-900 text-sm sm:text-base">{{ $restaurant->name }}</div>
                    <div class="text-xs text-gray-600">
                        {{ $restaurant->address ?? 'Main Address' }}, {{ $restaurant->city ?? 'London' }} {{ $restaurant->postcode }} • Phone: {{ $restaurant->phone }}
                    </div>
                </div>
            </div>
            <div class="text-xs bg-white text-emerald-800 font-semibold px-3 py-1.5 rounded-lg border border-emerald-200 shadow-sm">
                Live Uber Direct Partner
            </div>
        </div>
    </div>

    <form id="directDeliveryForm" onsubmit="event.preventDefault(); submitDirectDelivery();">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- LEFT COLUMN: ITEMS SELECTION & FREE-TEXT BUILDER (6 Cols) --}}
            <div class="lg:col-span-6 flex flex-col gap-6">

                {{-- 1. Select from Existing Items --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2 font-bold text-gray-900 text-sm sm:text-base">
                            <span class="text-emerald-600">🍽️</span> 1. Select From Existing Menu Items
                        </div>
                        <span class="text-xs text-gray-400">Click to append to list</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Filter by Category</label>
                            <select id="categoryFilter" onchange="filterProductsByCategory()" class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Quick Select Item</label>
                            <select id="productQuickSelect" onchange="appendSelectedProduct(this)" class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                <option value="">-- Choose item to add --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-category="{{ $product->category_id }}"
                                            data-name="{{ $product->name }}" 
                                            data-price="{{ $product->price }}">
                                        {{ $product->name }} (£{{ number_format($product->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Popular/Quick Chips --}}
                    <div class="flex items-center gap-1.5 flex-wrap max-h-32 overflow-y-auto pt-1" id="productChips">
                        @foreach($products->take(12) as $prod)
                            <button type="button" 
                                    onclick="appendCustomItem('{{ addslashes($prod->name) }}', {{ (float) $prod->price }})"
                                    class="product-chip text-xs bg-gray-100 hover:bg-emerald-100 hover:text-emerald-800 text-gray-700 font-medium px-2.5 py-1.5 rounded-lg border border-gray-200 transition duration-150 flex items-center gap-1"
                                    data-category="{{ $prod->category_id }}">
                                <span>+</span> {{ $prod->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- 2. Multi-line Items Textarea & Manual Input --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex flex-col flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2 font-bold text-gray-900 text-sm sm:text-base">
                            <span class="text-emerald-600">📝</span> 2. Items List (Type & Edit Manually)
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="formatNumberedList()" class="text-xs text-emerald-700 hover:underline font-semibold">
                                Auto-Number
                            </button>
                            <span class="text-gray-300">|</span>
                            <button type="button" onclick="clearItemList()" class="text-xs text-red-600 hover:underline font-semibold">
                                Clear
                            </button>
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-500 mb-3">
                        You can freely type custom quantities, weights, or notes (e.g. <em>1) chicken tandoori</em>, <em>2) paw bhaji 2 kg with souce</em>).
                    </p>

                    <div class="relative flex-1">
                        <textarea id="items_text" 
                                  name="items_text" 
                                  rows="8" 
                                  required
                                  placeholder="1) chicken tandoory&#10;2) paw bhaji 2 kg with souce&#10;3) 2x extra butter naan" 
                                  class="w-full text-sm font-mono border border-gray-300 rounded-xl p-3.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition leading-relaxed"></textarea>
                    </div>

                    {{-- Estimated Food Value for Uber Manifest --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-700 mb-1">
                                Total Food Value (£)
                            </label>
                            <span class="text-[11px] text-gray-500 block">Required for Uber manifest package value</span>
                        </div>
                        <div>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm font-bold">£</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0.50" 
                                       id="order_value" 
                                       name="order_value" 
                                       value="20.00" 
                                       class="w-full pl-8 pr-3 py-2 text-sm font-bold border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: DESTINATION WITH INTERACTIVE MAP, LIVE QUOTE & WORLDPAY CHECKOUT (6 Cols) --}}
            <div class="lg:col-span-6 flex flex-col gap-6">

                {{-- 3. Customer Destination Address & Interactive Map (Matching Restaurant & User Profile) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center gap-2 font-bold text-gray-900 text-sm sm:text-base mb-3">
                        <span class="text-emerald-600">📍</span> 3. Customer Destination & Map Pinning
                    </div>

                    <div class="space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Customer / Recipient Name *</label>
                                <input type="text" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       required 
                                       placeholder="e.g. John Smith" 
                                       class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Customer Phone Number *</label>
                                <input type="tel" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       required 
                                       placeholder="e.g. 07123456789 or +447123456789" 
                                       class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            </div>
                        </div>

                        {{-- Leaflet Map Search & Interactive Pinning --}}
                        <div class="bg-orange-50/50 p-3.5 rounded-2xl border border-orange-100">
                            <label class="font-bold text-gray-800 block mb-1.5 flex items-center gap-2 text-xs">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="2.2"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                Search Destination Address on Map
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="leafletSearchInput"
                                    placeholder="Type UK street, building name, area, or postcode (e.g. TW3 1PA)..."
                                    class="w-full border border-gray-300 rounded-xl p-2.5 pr-10 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A] bg-white text-gray-800 shadow-sm"
                                    autocomplete="off"
                                >
                                <div id="leafletSearchResults" class="absolute left-0 right-0 top-full bg-white border border-gray-200 rounded-xl mt-1 max-h-60 overflow-y-auto z-[9999] shadow-xl hidden"></div>
                            </div>

                            <div id="destinationMapContainer" class="mt-2.5 rounded-xl border border-gray-200 overflow-hidden shadow-inner relative" style="height: 220px;">
                                <div id="destinationMap" style="width: 100%; height: 100%;"></div>
                            </div>
                            <p class="text-[11px] text-[#C25A2A] mt-1.5 font-medium">💡 Drag marker on map or search above to auto-pin exact coordinates.</p>
                        </div>

                        {{-- Address Fields --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Street Address (Full Address) *</label>
                            <input type="text" 
                                   id="address" 
                                   name="address" 
                                   required 
                                   placeholder="e.g. 15 Baker Street, Flat 4B" 
                                   class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">City / Town *</label>
                                <input type="text" 
                                       id="city" 
                                       name="city" 
                                       required 
                                       value="{{ $restaurant->city ?? 'London' }}" 
                                       class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Postcode *</label>
                                <input type="text" 
                                       id="postcode" 
                                       name="postcode" 
                                       required 
                                       placeholder="e.g. W1U 3BW" 
                                       class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none uppercase font-semibold" />
                            </div>
                        </div>

                        {{-- State and Country (Hidden or compact) --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">State / County</label>
                                <input type="text" 
                                       id="state" 
                                       name="state" 
                                       value="{{ $restaurant->state ?? 'Greater London' }}" 
                                       class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Country</label>
                                <input type="text" 
                                       id="country" 
                                       name="country" 
                                       value="United Kingdom" 
                                       class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            </div>
                        </div>

                        {{-- Latitude & Longitude Coordinates Box --}}
                        <div class="bg-gray-50 rounded-xl p-2.5 border border-gray-200 grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-0.5">
                                    📍 Latitude
                                </label>
                                <input type="text" 
                                       id="latitude" 
                                       name="latitude" 
                                       readonly
                                       placeholder="e.g. 51.5074000" 
                                       class="w-full text-xs font-mono font-bold bg-white border border-gray-300 rounded-lg px-2.5 py-1.5 text-gray-800 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-0.5">
                                    📍 Longitude
                                </label>
                                <input type="text" 
                                       id="longitude" 
                                       name="longitude" 
                                       readonly
                                       placeholder="e.g. -0.1278000" 
                                       class="w-full text-xs font-mono font-bold bg-white border border-gray-300 rounded-lg px-2.5 py-1.5 text-gray-800 focus:outline-none" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Dropoff Instructions / Notes</label>
                            <input type="text" 
                                   id="notes" 
                                   name="notes" 
                                   placeholder="e.g. Door ring, Flat 3B, leave with concierge" 
                                   class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Delivery Handover</label>
                            <select id="deliverable_action" name="deliverable_action" class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                <option value="deliverable_action_meet_at_door">Meet at door</option>
                                <option value="leave_at_door">Leave at door</option>
                            </select>
                        </div>
                    </div>

                    {{-- Get Quote Button --}}
                    <div class="mt-4">
                        <button type="button" 
                                id="btnFetchQuote"
                                onclick="fetchUberQuote()" 
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl shadow transition duration-150 flex items-center justify-center gap-2 text-sm">
                            <span id="quoteSpinner" class="hidden animate-spin">⏳</span>
                            <span>⚡ Calculate Uber Delivery Quote</span>
                        </button>
                    </div>
                </div>

                {{-- 4. Live Quote Breakdown & Worldpay Payment Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2 font-bold text-gray-900 text-sm sm:text-base">
                            <span class="text-emerald-600">💳</span> 4. Delivery Pricing & Payment
                        </div>
                        <span id="quoteTimerBadge" class="hidden text-xs bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full">
                            ⏱️ Valid for: <span id="timerCountdown">15:00</span>
                        </span>
                    </div>

                    {{-- State A: Before Quote --}}
                    <div id="noQuoteBox" class="text-center py-6 border-2 border-dashed border-gray-200 rounded-xl p-4">
                        <div class="text-2xl mb-1">🚚</div>
                        <p class="text-xs text-gray-500 font-medium">
                            Search or pin the destination on the map and click <strong>"Calculate Uber Delivery Quote"</strong> to get live pricing.
                        </p>
                    </div>

                    {{-- State B: Quote Error Alert --}}
                    <div id="quoteErrorBox" class="hidden bg-red-50 border border-red-200 text-red-700 p-3 rounded-xl text-xs font-medium mb-3">
                        <!-- Dynamic Error Text -->
                    </div>

                    {{-- State C: Active Quote Display Card --}}
                    <div id="quoteSummaryBox" class="hidden flex flex-col gap-3">
                        <div class="bg-gray-50 rounded-xl p-3 border border-gray-200 space-y-2 text-xs">
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Uber Direct Courier Fee:</span>
                                <span class="font-bold text-gray-900" id="dispUberFee">£0.00</span>
                            </div>

                            <div class="flex justify-between items-center text-gray-600">
                                <span>HYST Handling Fee (+20%):</span>
                                <span class="font-bold text-emerald-700" id="dispMarkupFee">+£0.00</span>
                            </div>

                            <div class="pt-2 border-t border-gray-200 flex justify-between items-center text-sm">
                                <span class="font-extrabold text-gray-900">Total Charged to Restaurant:</span>
                                <span class="font-extrabold text-lg text-emerald-800" id="dispTotalFee">£0.00</span>
                            </div>

                            <div class="text-[11px] text-gray-500 flex items-center justify-between pt-1">
                                <span>Estimated Courier ETA:</span>
                                <span class="font-semibold text-gray-700" id="dispEta">~25-35 mins</span>
                            </div>
                        </div>

                        {{-- Hidden inputs to store active quote details --}}
                        <input type="hidden" id="uber_quote_id" name="uber_quote_id" value="">
                        <input type="hidden" id="uber_base_fee" name="uber_base_fee" value="0.00">
                        <input type="hidden" id="total_delivery_charge" name="total_delivery_charge" value="0.00">

                        {{-- Worldpay Pay & Book Button --}}
                        <button type="submit" 
                                id="btnPayWorldpay"
                                class="w-full bg-[#C25A2A] hover:bg-[#A3451E] text-white font-extrabold py-3.5 px-4 rounded-xl shadow-md transition duration-150 flex items-center justify-center gap-2 text-sm sm:text-base">
                            <span id="paySpinner" class="hidden animate-spin">⏳</span>
                            <span>🔒 Pay <span id="btnPayAmount">£0.00</span> with Worldpay & Dispatch Uber</span>
                        </button>

                        <p class="text-[11px] text-gray-400 text-center">
                            Secured by Worldpay. Payment will be collected from your restaurant card and the Uber courier will be dispatched automatically.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    let activeQuote = null;
    let timerInterval = null;
    let map = null;
    let marker = null;

    document.addEventListener('DOMContentLoaded', function () {
        initDeliveryMap();
    });

    // Initialize Leaflet Map (Same as Restaurant & User Profile)
    function initDeliveryMap() {
        const defaultLat = parseFloat("{{ (float) ($restaurant->latitude ?: 51.5074) }}") || 51.5074;
        const defaultLng = parseFloat("{{ (float) ($restaurant->longitude ?: -0.1278) }}") || -0.1278;

        const mapElem = document.getElementById('destinationMap');
        if (!mapElem) return;

        map = L.map('destinationMap', {
            center: [defaultLat, defaultLng],
            zoom: 13,
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // Map Drag Event
        marker.on('dragend', function (e) {
            const coord = e.target.getLatLng();
            updateAddressFromCoords(coord.lat, coord.lng);
        });

        // Map Click Event
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            updateAddressFromCoords(e.latlng.lat, e.latlng.lng);
        });

        // Search Input with Debounce & Nominatim API
        const searchInput = document.getElementById('leafletSearchInput');
        const searchResults = document.getElementById('leafletSearchResults');
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
                            item.className = 'p-2.5 hover:bg-[#FFF7F3] cursor-pointer border-b border-gray-100 text-xs text-gray-800 font-medium transition';
                            item.textContent = r.display_name;
                            item.addEventListener('click', function () {
                                const lat = parseFloat(r.lat);
                                const lng = parseFloat(r.lon);

                                map.setView([lat, lng], 16);
                                marker.setLatLng([lat, lng]);

                                applyAddressDetails(r, lat, lng);
                                searchInput.value = r.display_name;
                                searchResults.classList.add('hidden');
                            });
                            searchResults.appendChild(item);
                        });
                        searchResults.classList.remove('hidden');
                    })
                    .catch(err => {
                        console.error('Nominatim search error:', err);
                    });
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        }
    }

    // Reverse Geocode using Nominatim
    function updateAddressFromCoords(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(7);
        document.getElementById('longitude').value = lng.toFixed(7);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`, {
            headers: { 'Accept-Language': 'en-GB' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data) return;
            applyAddressDetails(data, lat, lng);
            const searchInput = document.getElementById('leafletSearchInput');
            if (searchInput) searchInput.value = data.display_name || '';
        })
        .catch(err => console.error('Reverse geocode error:', err));
    }

    // Apply address attributes to form inputs
    function applyAddressDetails(data, lat, lng) {
        const a = data.address || {};
        const house = a.house_number || a.house_name || '';
        const road = a.road || a.pedestrian || a.suburb || a.neighbourhood || '';
        const street = [house, road].filter(Boolean).join(' ');
        const fullAddress = street || data.display_name || '';

        const city = a.city || a.town || a.village || a.county || '';
        const state = a.state || a.county || 'Greater London';
        const country = a.country || 'United Kingdom';
        const postcode = a.postcode || '';

        if (fullAddress) document.getElementById('address').value = fullAddress;
        if (city) document.getElementById('city').value = city;
        if (state) document.getElementById('state').value = state;
        if (country) document.getElementById('country').value = country;
        if (postcode) document.getElementById('postcode').value = postcode;
        if (lat) document.getElementById('latitude').value = lat.toFixed(7);
        if (lng) document.getElementById('longitude').value = lng.toFixed(7);
    }

    // Filter products when category changes
    function filterProductsByCategory() {
        const catId = document.getElementById('categoryFilter').value;
        const select = document.getElementById('productQuickSelect');
        const chips = document.querySelectorAll('.product-chip');

        for (let i = 0; i < select.options.length; i++) {
            const opt = select.options[i];
            if (!opt.value) continue;
            const optCat = opt.getAttribute('data-category');
            opt.style.display = (!catId || optCat === catId) ? '' : 'none';
        }
        select.value = '';

        chips.forEach(chip => {
            const chipCat = chip.getAttribute('data-category');
            chip.style.display = (!catId || chipCat === catId) ? 'inline-flex' : 'none';
        });
    }

    // Append product from dropdown
    function appendSelectedProduct(selectElem) {
        const opt = selectElem.options[selectElem.selectedIndex];
        if (!opt || !opt.value) return;

        const name = opt.getAttribute('data-name');
        const price = parseFloat(opt.getAttribute('data-price') || 0);

        appendCustomItem(name, price);
        selectElem.value = '';
    }

    // Append custom or selected item into textarea
    function appendCustomItem(itemName, price = 0) {
        const textarea = document.getElementById('items_text');
        let currentText = textarea.value.trim();

        const lines = currentText ? currentText.split('\n') : [];
        const nextNum = lines.length + 1;

        let newLine = `${nextNum}) ${itemName}`;
        if (price > 0) {
            newLine += ` (£${price.toFixed(2)})`;
        }

        textarea.value = currentText ? (currentText + '\n' + newLine) : newLine;

        if (price > 0) {
            const orderValElem = document.getElementById('order_value');
            let currentVal = parseFloat(orderValElem.value || 0);
            orderValElem.value = (currentVal + price).toFixed(2);
        }

        textarea.scrollTop = textarea.scrollHeight;
    }

    // Format numbered list
    function formatNumberedList() {
        const textarea = document.getElementById('items_text');
        const lines = textarea.value.split('\n');
        let newLines = [];
        let counter = 1;

        lines.forEach(line => {
            const trimmed = line.trim();
            if (trimmed.length > 0) {
                const clean = trimmed.replace(/^(\d+[\.\)\-:]|\*|-)\s*/, '');
                newLines.push(`${counter}) ${clean}`);
                counter++;
            }
        });

        textarea.value = newLines.join('\n');
    }

    // Clear item list
    function clearItemList() {
        if (confirm('Clear the entire item list?')) {
            document.getElementById('items_text').value = '';
            document.getElementById('order_value').value = '0.00';
        }
    }

    // Live Uber Delivery Quote AJAX
    async function fetchUberQuote() {
        const name = document.getElementById('customer_name').value.trim();
        const phone = document.getElementById('customer_phone').value.trim();
        const address = document.getElementById('address').value.trim();
        const city = document.getElementById('city').value.trim();
        const state = document.getElementById('state').value.trim();
        const country = document.getElementById('country').value.trim();
        const postcode = document.getElementById('postcode').value.trim();
        const latitude = document.getElementById('latitude').value.trim();
        const longitude = document.getElementById('longitude').value.trim();
        const orderValue = document.getElementById('order_value').value || 10.00;

        const errBox = document.getElementById('quoteErrorBox');
        errBox.classList.add('hidden');
        errBox.innerHTML = '';

        if (!name || !phone || !address || !postcode) {
            alert('Please fill in Customer Name, Phone, Address, and Postcode first.');
            return;
        }

        const btn = document.getElementById('btnFetchQuote');
        const spinner = document.getElementById('quoteSpinner');
        btn.disabled = true;
        spinner.classList.remove('hidden');

        try {
            const response = await fetch("{{ route('restaurant.orders.direct_delivery_quote') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    dropoff_name: name,
                    dropoff_phone: phone,
                    dropoff_address: address,
                    dropoff_city: city,
                    dropoff_state: state,
                    dropoff_country: country,
                    dropoff_postcode: postcode,
                    dropoff_latitude: latitude,
                    dropoff_longitude: longitude,
                    order_value: orderValue
                })
            });

            const data = await response.json();

            if (data.success) {
                activeQuote = data;
                displayQuote(data);
            } else {
                errBox.innerHTML = `⚠️ <strong>Quote Failed:</strong> ${data.message || 'Unable to get quote from Uber.'}`;
                errBox.classList.remove('hidden');
                document.getElementById('quoteSummaryBox').classList.add('hidden');
                document.getElementById('noQuoteBox').classList.remove('hidden');
            }
        } catch (e) {
            errBox.innerHTML = `⚠️ <strong>Connection Error:</strong> ${e.message}`;
            errBox.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            spinner.classList.add('hidden');
        }
    }

    // Display Quote Summary & Countdown Timer
    function displayQuote(quote) {
        document.getElementById('noQuoteBox').classList.add('hidden');
        document.getElementById('quoteSummaryBox').classList.remove('hidden');

        document.getElementById('dispUberFee').innerText = `£${quote.uber_fee}`;
        document.getElementById('dispMarkupFee').innerText = `+£${quote.markup_fee} (20%)`;
        document.getElementById('dispTotalFee').innerText = `£${quote.total_fee}`;
        document.getElementById('btnPayAmount').innerText = `£${quote.total_fee}`;

        if (quote.duration_min) {
            document.getElementById('dispEta').innerText = `~${quote.duration_min} minutes`;
        }

        // Hidden inputs
        document.getElementById('uber_quote_id').value = quote.quote_id;
        document.getElementById('uber_base_fee').value = quote.uber_fee;
        document.getElementById('total_delivery_charge').value = quote.total_fee;

        // Start Expiration Timer (15 min default if not given)
        startQuoteTimer(quote.expires_at);
    }

    function startQuoteTimer(expiresAt) {
        if (timerInterval) clearInterval(timerInterval);

        const badge = document.getElementById('quoteTimerBadge');
        const countdownSpan = document.getElementById('timerCountdown');
        badge.classList.remove('hidden');

        let targetTime = expiresAt ? new Date(expiresAt).getTime() : (Date.now() + 15 * 60 * 1000);

        timerInterval = setInterval(() => {
            const now = Date.now();
            const distance = targetTime - now;

            if (distance <= 0) {
                clearInterval(timerInterval);
                countdownSpan.innerText = 'Expired';
                badge.className = 'text-xs bg-red-100 text-red-800 font-bold px-2 py-0.5 rounded-full';
                alert('Uber delivery quote has expired. Please recalculate the quote.');
                activeQuote = null;
                document.getElementById('quoteSummaryBox').classList.add('hidden');
                document.getElementById('noQuoteBox').classList.remove('hidden');
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            countdownSpan.innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }, 1000);
    }

    // Submit Order & Worldpay Payment Checkout
    async function submitDirectDelivery() {
        const itemsText = document.getElementById('items_text').value.trim();
        const quoteId = document.getElementById('uber_quote_id').value;
        const totalDeliveryCharge = document.getElementById('total_delivery_charge').value;
        const uberBaseFee = document.getElementById('uber_base_fee').value;

        if (!itemsText) {
            alert('Please enter or select at least one item.');
            document.getElementById('items_text').focus();
            return;
        }

        if (!quoteId || !totalDeliveryCharge || parseFloat(totalDeliveryCharge) <= 0) {
            alert('Please calculate the Uber delivery quote before placing the delivery order.');
            fetchUberQuote();
            return;
        }

        const btn = document.getElementById('btnPayWorldpay');
        const spinner = document.getElementById('paySpinner');
        btn.disabled = true;
        spinner.classList.remove('hidden');

        const payload = {
            items_text: itemsText,
            order_value: document.getElementById('order_value').value || 0,
            customer_name: document.getElementById('customer_name').value.trim(),
            customer_phone: document.getElementById('customer_phone').value.trim(),
            address: document.getElementById('address').value.trim(),
            city: document.getElementById('city').value.trim(),
            state: document.getElementById('state').value.trim(),
            country: document.getElementById('country').value.trim(),
            postcode: document.getElementById('postcode').value.trim(),
            latitude: document.getElementById('latitude').value.trim(),
            longitude: document.getElementById('longitude').value.trim(),
            notes: document.getElementById('notes').value.trim(),
            deliverable_action: document.getElementById('deliverable_action').value,
            uber_quote_id: quoteId,
            uber_base_fee: uberBaseFee,
            total_delivery_charge: totalDeliveryCharge
        };

        try {
            const response = await fetch("{{ route('restaurant.orders.direct_delivery_store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.success && result.redirect_url) {
                // Redirect restaurant to Worldpay Hosted Payment Page
                window.location.href = result.redirect_url;
            } else {
                alert('Payment initiation failed: ' + (result.message || 'Please try again.'));
                btn.disabled = false;
                spinner.classList.add('hidden');
            }
        } catch (e) {
            alert('Error connecting to payment gateway: ' + e.message);
            btn.disabled = false;
            spinner.classList.add('hidden');
        }
    }
</script>

@endsection
