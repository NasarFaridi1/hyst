{{--
    ============================================================
    ADDRESS SELECTION + INSTANT UBER QUOTE COMPONENT
    ------------------------------------------------------------
    Flow:
      1) All of the user's saved addresses are rendered as a
         selectable list (server-side, via $addresses).
      2) Clicking a saved address selects it, fills the hidden
         checkout fields, and immediately POSTs to
         checkout.uber.quote to fetch a live delivery quote.
         The response (or error) is shown right below the list.
      3) "Add Delivery Address" still opens the Building ->
         Map modal flow. On save, the new address is (a) POSTed
         to addresses.store, (b) prepended to the visible list,
         (c) auto-selected, which triggers the quote call too.

    Requirements on the parent layout / controller:
      - <meta name="csrf-token" content="{{ csrf_token() }}"> in <head>
      - Pass $addresses (the authenticated user's saved addresses,
        each with: id, label, building_type, address, city, state,
        postcode, country, latitude, longitude, landmark, is_default)
      - Pass $restaurant (or at least $restaurant->id) to this view,
        since the Uber quote endpoint needs restaurant_id. It is read
        from the data-restaurant-id attribute on #deliveryFields below.
      - routes: addresses.store, checkout.uber.quote

    NOTE ON THE QUOTE RESPONSE SHAPE:
      The renderQuote() JS function below guesses common field names
      (fee / delivery_fee / amount, currency, duration / dropoff_eta).
      Adjust that function to match whatever UberService::quote()
      actually returns in $quote (dumped as `data` in the JSON).
    ============================================================
--}}

<div id="deliveryFields" class="delivery-fields co-hidden" data-restaurant-id="{{ $restaurant->id ?? '' }}">
    <div class="section-label">Delivery Details</div>

    {{-- ---------- Saved addresses list ---------- --}}
    <div id="savedAddressesList" class="saved-addresses-list">
        @forelse($addresses ?? [] as $addr)
            <button type="button"
                class="address-option-row"
                data-id="{{ $addr->id }}"
                data-label="{{ $addr->label }}"
                data-building="{{ $addr->building_type }}"
                data-address="{{ $addr->address }}"
                data-city="{{ $addr->city }}"
                data-state="{{ $addr->state }}"
                data-postcode="{{ $addr->postcode }}"
                data-country="{{ $addr->country }}"
                data-lat="{{ $addr->latitude }}"
                data-lng="{{ $addr->longitude }}"
                data-landmark="{{ $addr->landmark }}">
                <span class="address-option-radio"></span>
                <span class="address-option-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z" stroke="#111" stroke-width="1.6"/><circle cx="12" cy="10" r="2.4" stroke="#111" stroke-width="1.6"/></svg>
                </span>
                <span class="address-option-body">
                    <span class="address-option-title">
                        {{ $addr->label ?: $addr->building_type ?: 'Address' }}
                        @if($addr->is_default ?? false)
                            <span class="address-option-default-badge">Default</span>
                        @endif
                    </span>
                    <span class="address-option-line">{{ $addr->address }}, {{ $addr->city }}, {{ $addr->postcode }}</span>
                </span>
                
                <a
                    href="{{ route('profile') }}"
                    class="address-edit-btn"
                    onclick="event.stopPropagation();"
                    title="Edit Address">

                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M4 20h4l10.5-10.5a2.1 2.1 0 0 0-4-4L4 16v4z"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>

                </a>
                    
                    
            </button>
        @empty
            <div class="no-saved-addresses" id="noSavedAddresses">No saved addresses yet. Add one below.</div>
        @endforelse
    </div>

    <button type="button" id="addAddressBtn" class="co-btn-add-address">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        Add Delivery Address
    </button>

    {{-- ---------- Live Uber quote result / error ---------- --}}
    <div id="uberQuoteStatus" class="uber-quote-status" style="display:none;"></div>

    {{-- These are the fields that actually get submitted with the checkout form --}}
        <input type="hidden" id="address_id"    name="address_id">
        <input type="hidden" id="address"       name="address">
        <input type="hidden" id="pincode"       name="postcode">
        <input type="hidden" id="city"          name="city">
        <input type="hidden" id="state"         name="state">
        <input type="hidden" id="country"       name="country" value="United Kingdom">
        <input type="hidden" id="latitude"      name="latitude">
        <input type="hidden" id="longitude"     name="longitude">
        <input type="hidden" id="building_type" name="building_type">
        <input type="hidden" id="landmark"      name="landmark">
        <input type="hidden" id="label"         name="label">
    </div>

{{-- ============================ STEP 1 : CHOOSE BUILDING ============================ --}}
<div class="co-modal-overlay" id="buildingTypeModal">
    <div class="co-modal co-modal-sheet">
        <button type="button" class="co-modal-close" data-close="buildingTypeModal">&times;</button>
        <h3 class="co-modal-title">Choose your building</h3>
        <p class="co-modal-subtitle">Let us know your building type for more accurate deliveries</p>

        <div class="building-type-list">
            <button type="button" class="building-type-row" data-building="House">
                <span class="building-type-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 11l9-7 9 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 10v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-9" stroke="currentColor" stroke-width="1.6"/></svg>
                </span>
                <span class="building-type-label">House</span>
                <span class="building-type-chevron">&rsaquo;</span>
            </button>
            <button type="button" class="building-type-row" data-building="Flat">
                <span class="building-type-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="5" y="3" width="14" height="18" rx="1" stroke="currentColor" stroke-width="1.6"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                </span>
                <span class="building-type-label">Flat</span>
                <span class="building-type-chevron">&rsaquo;</span>
            </button>
            <button type="button" class="building-type-row" data-building="Office">
                <span class="building-type-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="13" rx="1" stroke="currentColor" stroke-width="1.6"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="1.6"/></svg>
                </span>
                <span class="building-type-label">Office</span>
                <span class="building-type-chevron">&rsaquo;</span>
            </button>
            <button type="button" class="building-type-row" data-building="Hotel">
                <span class="building-type-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-5 9 5v12" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6"/></svg>
                </span>
                <span class="building-type-label">Hotel</span>
                <span class="building-type-chevron">&rsaquo;</span>
            </button>
            <button type="button" class="building-type-row" data-building="Other">
                <span class="building-type-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="10" r="2.4" stroke="currentColor" stroke-width="1.6"/></svg>
                </span>
                <span class="building-type-label">Other</span>
                <span class="building-type-chevron">&rsaquo;</span>
            </button>
        </div>

        <div class="co-modal-footer">
            <button type="button" class="co-btn-secondary" data-close="buildingTypeModal">Back</button>
            <button type="button" class="co-btn-secondary" id="skipBuildingBtn">Skip</button>
        </div>
    </div>
</div>

{{-- ============================ STEP 2 : MAP + ADDRESS INFO ============================ --}}
<div class="co-modal-overlay" id="addressModal">
    <div class="co-modal co-modal-sheet co-modal-wide">
        <button type="button" class="co-modal-close" data-close="addressModal">&times;</button>
        <h3 class="co-modal-title">Address info</h3>

        <div class="co-input-group" style="margin-top:6px;">
            <input type="text" id="mapSearchInput" class="co-input" placeholder="Search for area, street name...">
            <div id="mapSearchResults" class="map-search-results"></div>
        </div>

        <div class="map-wrapper">
            <div id="addressMap"></div>
            <div class="map-center-pin">
                <svg width="30" height="42" viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z" fill="#111"/><circle cx="12" cy="10" r="2.6" fill="#fff"/></svg>
            </div>
            <div class="map-adjust-pin-label">Adjust pin</div>
        </div>

        <div class="resolved-address" id="resolvedAddressLine">Move the map to select a location</div>

        <div class="co-input-group">
            <label for="buildingTypeSelect">Building type</label>
            <select id="buildingTypeSelect" class="co-input">
                <option value="House">House</option>
                <option value="Flat">Flat</option>
                <option value="Office">Office</option>
                <option value="Hotel">Hotel</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="co-input-group">
            <label for="additionalDetails">Additional details</label>
            <input type="text" id="additionalDetails" class="co-input" placeholder="Flat / house number, floor, landmark...">
        </div>

        <div class="co-input-group">
            <label for="postcodeInput">Postcode</label>
            <input type="text" id="postcodeInput" class="co-input" placeholder="e.g. SW1A 1AA" autocomplete="postal-code">
        </div>

        <div class="co-input-group">
            <label>Save as</label>
            <div class="label-chip-row">
                <button type="button" class="label-chip" data-label="Home">Home</button>
                <button type="button" class="label-chip" data-label="Work">Work</button>
                <button type="button" class="label-chip" data-label="Other">Other</button>
            </div>
        </div>

        <div class="co-modal-footer">
            <button type="button" class="co-btn-secondary" id="mapBackBtn">Back</button>
            <button type="button" class="co-btn-primary" id="saveAddressBtn">Save</button>
        </div>
    </div>
</div>

{{-- Leaflet (free, no API key) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    .delivery-fields{margin:12px 0;}
    .co-hidden{display:none !important;}

    .co-btn-add-address{
        display:flex;align-items:center;gap:8px;width:100%;
        padding:14px 16px;border:1px dashed #c9c9c9;border-radius:12px;
        background:#fafafa;color:#111;font-weight:600;font-size:14px;
        cursor:pointer;transition:background .15s ease;
    }
    .co-btn-add-address:hover{background:#f0f0f0;}

    /* ---- saved addresses list ---- */
    .saved-addresses-list{display:flex;flex-direction:column;gap:10px;margin-bottom:10px;}
    .no-saved-addresses{font-size:13px;color:#777;padding:8px 2px;}
    .address-option-row{
        display:flex;align-items:flex-start;gap:12px;width:100%;text-align:left;
        padding:14px;border:1px solid #e5e5e5;border-radius:12px;background:#fff;
        cursor:pointer;transition:border-color .15s ease,background .15s ease;
    }
    .address-option-row:hover{border-color:#999;}
    .address-option-row.selected{border-color:#111;background:#fafafa;}
    .address-option-radio{
        flex:0 0 auto;width:18px;height:18px;margin-top:2px;border-radius:50%;
        border:2px solid #bbb;position:relative;
    }
    .address-option-row.selected .address-option-radio{border-color:#111;}
    .address-option-row.selected .address-option-radio::after{
        content:'';position:absolute;inset:3px;border-radius:50%;background:#111;
    }
    .address-option-icon{flex:0 0 auto;margin-top:1px;}
    .address-option-body{flex:1 1 auto;min-width:0;}
    .address-option-title{font-weight:700;font-size:13px;display:flex;align-items:center;gap:8px;}
    .address-option-default-badge{
        font-size:10px;font-weight:700;color:#111;background:#eee;padding:2px 8px;border-radius:10px;
    }
    .address-option-line{font-size:13px;color:#666;margin-top:2px;}

    /* ---- uber quote status ---- */
    .uber-quote-status{
        margin:10px 0;padding:12px 14px;border-radius:10px;font-size:13px;line-height:1.5;
    }
    .uber-quote-loading{background:#f5f5f5;color:#555;}
    .uber-quote-success{background:#eefaf0;color:#155724;border:1px solid #cdecd3;}
    .uber-quote-error{background:#fdecea;color:#a12b23;border:1px solid #f6cbc6;}
    .uber-quote-row{margin:2px 0;}

    .selected-address-card{
        display:flex;align-items:center;gap:12px;
        padding:14px;border:1px solid #e5e5e5;border-radius:12px;margin-bottom:10px;
    }

    /* ---- modal shell ---- */
    .co-modal-overlay{
        display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);
        align-items:flex-end;justify-content:center;z-index:1000;
    }
    .co-modal-overlay.open{display:flex;}
    .co-modal{
        background:#fff;width:100%;max-width:480px;border-radius:20px 20px 0 0;
        padding:24px 20px calc(20px + env(safe-area-inset-bottom));
        position:relative;max-height:92vh;overflow-y:auto;
    }
    @media (min-width:560px){
        .co-modal-overlay{align-items:center;}
        .co-modal{border-radius:20px;}
    }
    .co-modal-close{
        position:absolute;top:16px;right:16px;background:none;border:none;
        font-size:22px;line-height:1;cursor:pointer;color:#333;
    }
    .co-modal-title{font-size:22px;font-weight:800;margin:0 0 4px;}
    .co-modal-subtitle{font-size:13px;color:#666;margin:0 0 18px;}
    .co-modal-footer{display:flex;justify-content:flex-end;gap:10px;margin-top:18px;}
    .co-btn-secondary{
        padding:12px 18px;border-radius:10px;border:1px solid #ddd;background:#fff;
        font-weight:600;font-size:14px;cursor:pointer;
    }
    .co-btn-primary{
        padding:12px 22px;border-radius:10px;border:none;background:#111;color:#fff;
        font-weight:700;font-size:14px;cursor:pointer;
    }
    .co-btn-primary:disabled{opacity:.5;cursor:not-allowed;}

    /* ---- step 1: building list ---- */
    .building-type-list{display:flex;flex-direction:column;gap:10px;}
    .building-type-row{
        display:flex;align-items:center;gap:14px;width:100%;
        padding:14px 16px;border:1px solid #e5e5e5;border-radius:12px;background:#fff;
        cursor:pointer;text-align:left;font-size:15px;font-weight:600;color:#111;
        transition:border-color .15s ease,background .15s ease;
    }
    .building-type-row:hover,.building-type-row.selected{border-color:#111;background:#fafafa;}
    .building-type-icon{flex:0 0 auto;display:flex;color:#111;}
    .building-type-label{flex:1 1 auto;}
    .building-type-chevron{color:#999;font-size:20px;}

    /* ---- step 2: map ---- */
    .co-modal-wide{max-width:520px;}
    .co-input-group{margin-bottom:14px;position:relative;}
    .co-input-group label{display:block;font-size:12px;font-weight:700;color:#555;margin-bottom:6px;}
    .co-input{
        width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:10px;
        font-size:14px;box-sizing:border-box;
    }
    .co-input:focus,.co-textarea:focus{outline:none;border-color:#111;}
    select.co-input{background:#fff;}

    .map-search-results{
        position:absolute;left:0;right:0;top:100%;background:#fff;border:1px solid #e5e5e5;
        border-radius:10px;margin-top:4px;max-height:220px;overflow-y:auto;z-index:999;
        box-shadow:0 6px 18px rgba(0,0,0,.12);display:none;
    }
    .map-search-results.open{display:block;}
    .map-search-result-item{padding:10px 14px;font-size:13px;cursor:pointer;border-bottom:1px solid #f0f0f0;}
    .map-search-result-item:last-child{border-bottom:none;}
    .map-search-result-item:hover{background:#f7f7f7;}

    .map-wrapper{position:relative;width:100%;height:220px;border-radius:12px;overflow:hidden;margin-bottom:10px;border:1px solid #e5e5e5;}
    .map-wrapper {
        display: none !important;
    }
    #addressMap{width:100%;height:100%;}
    .map-center-pin{
        position:absolute;left:50%;top:50%;transform:translate(-50%,-100%);
        pointer-events:none;z-index:500;filter:drop-shadow(0 2px 3px rgba(0,0,0,.35));
    }
    .map-adjust-pin-label{
        position:absolute;left:50%;bottom:10px;transform:translateX(-50%);
        background:#fff;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;
        box-shadow:0 2px 6px rgba(0,0,0,.18);pointer-events:none;
    }
    .resolved-address{font-size:13px;color:#333;margin-bottom:16px;line-height:1.4;}

    .label-chip-row{display:flex;gap:8px;}
    .label-chip{
        padding:8px 16px;border:1px solid #ddd;border-radius:20px;background:#fff;
        font-size:13px;font-weight:600;cursor:pointer;
    }
    .label-chip.selected{background:#111;color:#fff;border-color:#111;}
</style>

<script>
    (function () {
        const CSRF_TOKEN     = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const STORE_URL      = "{{ route('addresses.store') }}";
        const UBER_QUOTE_URL = "{{ route('checkout.uber.quote') }}";
        const UK_BOUNDS      = [[49.5, -8.7], [61.0, 2.1]]; // rough UK bounding box for map + search bias

        let map, moveDebounce, searchDebounce;
        let selectedBuildingType = '';
        let selectedLabel = '';
        let resolvedAddress = null; // { address, city, state, postcode, country, lat, lng }

        const $ = (id) => document.getElementById(id);
        const buildingModal   = $('buildingTypeModal');
        const addressModal    = $('addressModal');
        const deliveryFields  = $('deliveryFields');
        const addressesList   = $('savedAddressesList');

        function openModal(el)  { el.classList.add('open'); }
        function closeModal(el) { el.classList.remove('open'); }

        document.querySelectorAll('[data-close]').forEach(btn => {
            btn.addEventListener('click', () => closeModal($(btn.dataset.close)));
        });

        // ---------- entry points ----------
        $('addAddressBtn').addEventListener('click', () => openModal(buildingModal));

        // ---------- saved address selection ----------
        function wireAddressRow(row) {
            row.addEventListener('click', () => selectAddress(row));
        }
        document.querySelectorAll('.address-option-row').forEach(wireAddressRow);

        function selectAddress(row) {
            document.querySelectorAll('.address-option-row').forEach(r => r.classList.remove('selected'));
            row.classList.add('selected');

            $('address_id').value    = row.dataset.id || '';
            $('address').value       = row.dataset.address || '';
            $('pincode').value       = row.dataset.postcode || '';
            $('city').value          = row.dataset.city || '';
            $('state').value         = row.dataset.state || '';
            $('country').value       = row.dataset.country || 'United Kingdom';
            $('latitude').value      = row.dataset.lat || '';
            $('longitude').value     = row.dataset.lng || '';
            $('building_type').value = row.dataset.building || '';
            $('landmark').value      = row.dataset.landmark || '';
            $('label').value         = row.dataset.label || '';

            // fetchUberQuote();
            // Only fetch Uber quote when Self Delivery is disabled
            const selfDelivery = "{{ $restaurant->self_delivery }}";

            if (selfDelivery != 1) {
                fetchUberQuote();
            }
        }

        // Auto-select if there's exactly one saved address already.
        (function autoSelectIfSingle() {
            const rows = document.querySelectorAll('.address-option-row');
            if (rows.length === 1) selectAddress(rows[0]);
        })();

        // ---------- instant Uber quote ----------
        async function fetchUberQuote() {
            const box = $('uberQuoteStatus');
            const restaurantId = "{{ $restaurant->id }}";

            if (!restaurantId) {
                box.style.display = 'block';
                box.className = 'uber-quote-status uber-quote-error';
                box.textContent = 'Restaurant could not be identified, so a delivery quote cannot be fetched.';
                return;
            }

            box.style.display = 'block';
            box.className = 'uber-quote-status uber-quote-loading';
            box.textContent = 'Checking delivery availability...';

            try {
                const res = await fetch(UBER_QUOTE_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ restaurant_id: restaurantId,finalTotal: "{{ $finalTotal }}", selectedAddress_id: $('address_id').value })
                });
                
                const data = await res.json();

                if (!res.ok || !data.success) {
                    throw new Error(data.message || 'Could not fetch a delivery quote.');
                }

                // Uber returned an error even though API request succeeded
                if (data.data?.kind === 'error') {
                    document.getElementById('uber_quote_id').value = '';
                    document.getElementById('delivery_charge').value = 0;
                    throw new Error(
                        data.data.metadata?.details ||
                        data.data.message ||
                        'Delivery is unavailable for this address.'
                    );
                }

                
                

                if (data.success) {

                    console.log('Uber quote response:', data.data);

                    // const fee = (data.data.fee ?? 0) / 100;

                    // Hidden input
                    // document.getElementById('delivery_charge').value = fee;

                    // // Delivery charge text
                    // document.getElementById('deliveryChargeText').textContent =
                    //     '£' + fee.toFixed(2);
                    
                    const delivery = (data.data.fee ?? 0) / 100;

                    // Save quote id
                    document.getElementById('uber_quote_id').value = data.data.id;

                    document.getElementById('delivery_charge').value = delivery;

                    updateCheckoutTotal(delivery);

                    // Update total if you have one
                    // updateCheckoutTotal();
                }

                box.className = 'uber-quote-status uber-quote-success';
                box.innerHTML = renderQuote(data.data);
                document.dispatchEvent(new CustomEvent('address:quote', { detail: data.data }));
            } catch (err) {
                box.className = 'uber-quote-status uber-quote-error';
                box.textContent = err.message || 'Something went wrong while fetching the delivery quote.';
            }
        }

        // NOTE: adjust these field names to match whatever UberService::quote()
        // actually returns. Common Uber Direct quote fields are guessed here.
        function renderQuote(q) {
            const fee      = q.fee ?? q.delivery_fee ?? q.amount;
            const currency = q.currency ?? q.currency_code ?? 'GBP';
            const eta      = q.duration ?? q.dropoff_eta ?? q.estimated_delivery_time;

            let html = '<div class="uber-quote-row"><strong>Delivery available</strong></div>';
            if (fee !== undefined && fee !== null) {
                const amount = typeof fee === 'number' ? (fee / 100).toFixed(2) : fee;
                html += `<div class="uber-quote-row">Delivery fee: ${currency} ${amount}</div>`;
            }
            if (eta) html += `<div class="uber-quote-row">Estimated time: ${eta}</div>`;
            return html;
        }

        function updateCheckoutTotal(deliveryCharge = null) {

            const foodTotal = parseFloat(
                document.getElementById('cartSubtotal').value
            );

            if (deliveryCharge === null) {
                deliveryCharge = parseFloat(
                    document.getElementById('delivery_charge').value || 0
                );
            }

            let hystCharge = 0;

            if (foodTotal < 20) {
                hystCharge = 1;
            }
            else if (foodTotal < 50) {
                hystCharge = 2;
            }
            else if (foodTotal < 100) {
                hystCharge = 4;
            }
            else {
                hystCharge = 8;
            }

            const grandTotal =
                foodTotal +
                deliveryCharge +
                hystCharge;

            document.getElementById('deliveryChargeText').innerHTML =
                '£' + deliveryCharge.toFixed(2);

            document.getElementById('hystChargeText').innerHTML =
                '£' + hystCharge.toFixed(2);

            document.getElementById('finalTotalText').innerHTML =
                '£' + grandTotal.toFixed(2);

            document.getElementById('mobileFinalTotalText').innerHTML =
                '£' + grandTotal.toFixed(2);

            document.getElementById('hyst_charge').value =
                hystCharge.toFixed(2);

            document.getElementById('delivery_charge').value =
                deliveryCharge.toFixed(2);

            const amountInput = document.querySelector('input[name="amount"]');

            if (amountInput) {
                amountInput.value = grandTotal.toFixed(2);
            }
        }

        // ---------- STEP 1: building type ----------
        document.querySelectorAll('.building-type-row').forEach(row => {
            row.addEventListener('click', () => {
                document.querySelectorAll('.building-type-row').forEach(r => r.classList.remove('selected'));
                row.classList.add('selected');
                selectedBuildingType = row.dataset.building;
                $('buildingTypeSelect').value = selectedBuildingType;
                closeModal(buildingModal);
                openModal(addressModal);
                initMapIfNeeded();
            });
        });

        $('skipBuildingBtn').addEventListener('click', () => {
            selectedBuildingType = '';
            closeModal(buildingModal);
            openModal(addressModal);
            initMapIfNeeded();
        });

        // ---------- STEP 2: map ----------
        function initMapIfNeeded() {
            setTimeout(() => {
                if (map) { map.invalidateSize(); return; }

                map = L.map('addressMap', {
                    center: [51.5074, -0.1278], // London default
                    zoom: 12,
                    zoomControl: false,
                    maxBounds: UK_BOUNDS,
                    maxBoundsViscosity: 0.6
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                map.on('moveend', () => {
                    clearTimeout(moveDebounce);
                    moveDebounce = setTimeout(reverseGeocodeCenter, 400);
                });

                reverseGeocodeCenter();
            }, 50);
        }

        async function reverseGeocodeCenter() {
            const center = map.getCenter();
            $('resolvedAddressLine').textContent = 'Locating address...';
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${center.lat}&lon=${center.lng}&addressdetails=1`, {
                    headers: { 'Accept-Language': 'en-GB' }
                });
                const data = await res.json();
                const a = data.address || {};
                resolvedAddress = {
                    address: [a.house_number, a.road || a.pedestrian || a.neighbourhood].filter(Boolean).join(', ') || data.display_name,
                    city: a.city || a.town || a.village || a.county || '',
                    state: a.state || a.county || '',
                    postcode: a.postcode || '',
                    country: a.country || 'United Kingdom',
                    lat: center.lat,
                    lng: center.lng
                };
                $('resolvedAddressLine').textContent = data.display_name || `${resolvedAddress.address}`;
                if (resolvedAddress.postcode) $('postcodeInput').value = resolvedAddress.postcode;
            } catch (e) {
                $('resolvedAddressLine').textContent = 'Could not resolve this location, adjust the pin and try again.';
            }
        }

        // ---------- search ----------
        $('mapSearchInput').addEventListener('input', (e) => {
            const q = e.target.value.trim();
            clearTimeout(searchDebounce);
            if (q.length < 3) { $('mapSearchResults').classList.remove('open'); return; }
            searchDebounce = setTimeout(() => runSearch(q), 350);
        });

        async function runSearch(q) {
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=6&countrycodes=gb&q=${encodeURIComponent(q)}`, {
                    headers: { 'Accept-Language': 'en-GB' }
                });
                const results = await res.json();
                const box = $('mapSearchResults');
                box.innerHTML = '';
                if (!results.length) { box.classList.remove('open'); return; }

                results.forEach(r => {
                    const item = document.createElement('div');
                    item.className = 'map-search-result-item';
                    item.textContent = r.display_name;
                    item.addEventListener('click', () => {
                        map.setView([r.lat, r.lon], 16);
                        $('mapSearchInput').value = r.display_name;
                        box.classList.remove('open');
                    });
                    box.appendChild(item);
                });
                box.classList.add('open');
            } catch (e) { /* silently ignore search errors */ }
        }

        // ---------- label chips ----------
        document.querySelectorAll('.label-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                document.querySelectorAll('.label-chip').forEach(c => c.classList.remove('selected'));
                chip.classList.add('selected');
                selectedLabel = chip.dataset.label;
            });
        });

        $('buildingTypeSelect').addEventListener('change', (e) => {
            selectedBuildingType = e.target.value;
        });

        // ---------- back / save ----------
        $('mapBackBtn').addEventListener('click', () => {
            closeModal(addressModal);
            openModal(buildingModal);
        });

        $('saveAddressBtn').addEventListener('click', saveAddress);

        async function saveAddress() {
            if (!resolvedAddress || !resolvedAddress.address) {
                alert('Please adjust the pin to a valid location first.');
                return;
            }
            const postcode = $('postcodeInput').value.trim();
            if (!postcode) {
                alert('Please enter a postcode.');
                return;
            }

            const payload = {
                label: selectedLabel || null,
                building_type: selectedBuildingType || 'Other',
                address: resolvedAddress.address,
                landmark: $('additionalDetails').value.trim() || null,
                city: resolvedAddress.city || 'N/A',
                state: resolvedAddress.state || null,
                country: resolvedAddress.country || 'United Kingdom',
                postcode: postcode,
                latitude: resolvedAddress.lat,
                longitude: resolvedAddress.lng,
                is_default: true
            };

            const btn = $('saveAddressBtn');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            try {
                const res = await fetch(STORE_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (!res.ok || !data.success) {
                    throw new Error(data.message || 'Could not save address.');
                }

                const row = addAddressToList(data.data);
                closeModal(addressModal);
                selectAddress(row); // auto-select the new address, fires the Uber quote call
                document.dispatchEvent(new CustomEvent('address:saved', { detail: data.data }));
            } catch (err) {
                alert(err.message || 'Something went wrong while saving the address.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Save';
            }
        }

        // Builds a new address row from the API response, prepends it to the
        // list, wires up its click handler, and returns the element.
        function addAddressToList(addr) {
            $('noSavedAddresses')?.remove();

            const row = document.createElement('button');
            row.type = 'button';
            row.className = 'address-option-row';
            row.dataset.id = addr.id;
            row.dataset.label = addr.label || '';
            row.dataset.building = addr.building_type || '';
            row.dataset.address = addr.address || '';
            row.dataset.city = addr.city || '';
            row.dataset.state = addr.state || '';
            row.dataset.postcode = addr.postcode || '';
            row.dataset.country = addr.country || '';
            row.dataset.lat = addr.latitude || '';
            row.dataset.lng = addr.longitude || '';
            row.dataset.landmark = addr.landmark || '';

            row.innerHTML = `
                <span class="address-option-radio"></span>
                <span class="address-option-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z" stroke="#111" stroke-width="1.6"/><circle cx="12" cy="10" r="2.4" stroke="#111" stroke-width="1.6"/></svg>
                </span>
                <span class="address-option-body">
                    <span class="address-option-title">${addr.label || addr.building_type || 'Address'}</span>
                    <span class="address-option-line">${addr.address}, ${addr.city}, ${addr.postcode}</span>
                </span>
            `;

            addressesList.prepend(row);
            wireAddressRow(row);
            return row;
        }

        function deleteAddress(event, button) {

            event.stopPropagation();

            if (!confirm("Delete this address?")) {
                return;
            }

            const id = button.dataset.id;

            fetch(`/addresses/${id}`, {

                method: "DELETE",

                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }

            })
            .then(res => res.json())
            .then(res => {

                if (!res.success) {
                    alert(res.message || "Unable to delete address.");
                    return;
                }

                // remove address row
                button.closest(".address-option-row").remove();

                // if no addresses remain
                if (!document.querySelector(".address-option-row")) {

                    document.getElementById("savedAddressesList").innerHTML =
                        '<div class="no-saved-addresses">No saved addresses yet. Add one below.</div>';

                }

            })
            .catch(() => {
                alert("Something went wrong.");
            });

        }
    })();
</script>