@extends('front.layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

    .profile-page {
        background: #FAF7F2;
        min-height: 100vh;
        padding: 40px 16px 100px;
    }

    .profile-wrap {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
        align-items: start;
    }

    .profile-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid #F0F0EC;
        box-shadow: 0 2px 10px rgba(13,13,13,0.03);
        padding: 36px 32px;
    }

    /* ── Header with avatar ── */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 32px;
        padding-bottom: 28px;
        border-bottom: 1px solid #F0F0EC;
    }
    .profile-avatar {
        width: 64px; height: 64px;
        border-radius: 16px;
        background: #FAF7F2;
        border: 1.5px solid #F0E4D8;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .profile-avatar svg { width: 30px; height: 30px; color: #C25A2A; }

    .profile-eyebrow {
        color: #C25A2A;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .profile-title {
        font-family: 'Poppins', sans-serif;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -.4px;
        color: #0D0D0D;
        margin: 0 0 2px;
    }
    .profile-subtitle {
        color: #6B7280;
        font-size: 13.5px;
    }

    /* ── Form ── */
    .p-label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
        letter-spacing: .03em;
        text-transform: uppercase;
    }
    .p-input-wrap { position: relative; }
    .p-input-wrap svg {
        position: absolute;
        left: 16px; top: 50%;
        transform: translateY(-50%);
        width: 17px; height: 17px;
        color: #9CA3AF;
        pointer-events: none;
    }
    .p-input {
        width: 100%;
        border: 1.5px solid #F0F0EC;
        border-radius: 14px;
        padding: 14px 16px 14px 44px;
        font-size: 14.5px;
        font-family: 'DM Sans', sans-serif;
        color: #0D0D0D;
        background: #FAFAF8;
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
        box-sizing: border-box;
    }
    .p-input:focus {
        border-color: #C25A2A;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(194,90,42,.10);
    }
    .p-input:disabled {
        color: #9CA3AF;
        cursor: not-allowed;
    }
    .p-hint {
        font-size: 11.5px;
        color: #9CA3AF;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .p-hint svg { width: 12px; height: 12px; flex-shrink: 0; }

    .p-group { margin-bottom: 22px; }
    .p-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }

    .p-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: #C25A2A;
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 15px 32px;
        font-family: 'Poppins', sans-serif;
        font-size: 14.5px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .15s;
        margin-top: 6px;
    }
    .p-btn:hover { background: #c42d0b; transform: translateY(-1px); }
    .p-btn svg { width: 16px; height: 16px; }

    .p-success {
        background: #ECFDF5;
        border: 1px solid #BBF7D0;
        color: #065F46;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-size: 13.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .p-success svg { width: 18px; height: 18px; flex-shrink: 0; color: #16A34A; }

    .mob-page-title {
        display: none;
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0D0D0D;
        margin-bottom: 18px;
        letter-spacing: -.3px;
    }

    @media(max-width: 900px) {
        .profile-wrap { grid-template-columns: 1fr; }
    }
    @media(max-width: 640px) {
        .profile-page { padding: 20px 14px 100px; }
        .mob-page-title { display: block; }
        .profile-card { padding: 24px 18px; }
        .profile-header { flex-wrap: wrap; }
        .profile-title { font-size: 22px; }
        .p-grid { grid-template-columns: 1fr; gap: 0; }
        .p-btn { width: 100%; justify-content: center; padding: 16px; }
    }
</style>

<div class="profile-page">
    <div class="profile-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- CONTENT --}}
        <div>
            <div class="mob-page-title">My Profile</div>

            <div class="profile-card">

                <div class="profile-header">
                    <div class="profile-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="profile-eyebrow">Account Settings</div>
                        <h1 class="profile-title">My Profile</h1>
                        <p class="profile-subtitle">Manage your personal details</p>
                    </div>
                </div>

                @if(session('success'))
                <div class="p-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="/profile/update">
                    @csrf

                    <div class="p-grid">
                        <div class="p-group">
                            <label class="p-label">Full Name</label>
                            <div class="p-input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="p-input" required>
                            </div>
                        </div>
                        <div class="p-group">
                            <label class="p-label">Email Address</label>
                            <div class="p-input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <input type="email" readonly disabled name="email" value="{{ auth()->user()->email }}" class="p-input" required>
                            </div>
                            <div class="p-hint">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 16v-4m0-4h.01"/>
                                </svg>
                                Email can't be changed for security reasons
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="p-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Update Profile
                    </button>
                </form>
            </div>

            {{--
                ============================================================
                PROFILE - MY ADDRESSES SECTION
                ------------------------------------------------------------
                Drop this into your profile page (see notes at the bottom for
                where/how). It gives the user:

                1) A list of all saved addresses (default shown first,
                    and visually marked / auto-highlighted).
                2) "Add New Address" -> Building type step -> Map + details
                    step -> POSTs to addresses.store.
                3) "Edit" on any address -> same map + details step,
                    pre-filled -> PUTs to addresses.update.
                4) "Delete" on any address -> DELETEs to addresses.destroy
                    (with confirmation).
                5) "Set as default" on any non-default address -> POSTs to
                    addresses.default.

                Requirements on the parent layout / controller:
                - <meta name="csrf-token" content="{{ csrf_token() }}"> in <head>
                    (front.layouts.app already needs this for the checkout page,
                    so it's very likely already present)
                - Pass $addresses to the profile view: the authenticated
                    user's saved addresses (id, label, building_type, address,
                    city, state, postcode, country, latitude, longitude,
                    landmark, is_default), ordered with default first / latest
                    first (your UserAddressController@index already does this:
                    ->orderByDesc('is_default')->latest())
                - Routes already in your routes file:
                    addresses.index, addresses.store, addresses.update,
                    addresses.destroy, addresses.default
                ============================================================
            --}}

            <div class="profile-card addr-card">

                <div class="profile-header addr-header">
                    <div class="profile-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/>
                            <circle cx="12" cy="10" r="2.6"/>
                        </svg>
                    </div>
                    <div>
                        <div class="profile-eyebrow">Delivery</div>
                        <h1 class="profile-title">My Addresses</h1>
                        <p class="profile-subtitle">Manage the addresses we deliver to</p>
                    </div>
                </div>

                <div id="addrSuccessBox" class="p-success" style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span id="addrSuccessText"></span>
                </div>

                <div id="savedAddressesList" class="addr-list">
                    @forelse($addresses ?? [] as $addr)
                        <div class="addr-row {{ $addr->is_default ? 'is-default' : '' }}"
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

                            <span class="addr-row-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="1.6">
                                    <path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/>
                                    <circle cx="12" cy="10" r="2.4"/>
                                </svg>
                            </span>

                            <span class="addr-row-body">
                                <span class="addr-row-title">
                                    {{ $addr->label ?: $addr->building_type ?: 'Address' }}
                                    @if($addr->is_default)
                                        <span class="addr-default-badge">Default</span>
                                    @endif
                                </span>
                                <span class="addr-row-line">{{ $addr->address }}, {{ $addr->city }}, {{ $addr->postcode }}</span>
                            </span>

                            <span class="addr-row-actions">
                                @if(!$addr->is_default)
                                    <button type="button" class="addr-action-btn addr-set-default" title="Set as default">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 17.3l-6.2 3.6 1.6-7-5.4-4.7 7.1-.6L12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7z"/></svg>
                                    </button>
                                @endif
                                <button type="button" class="addr-action-btn addr-edit" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <button type="button" class="addr-action-btn addr-delete" title="Delete">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg>
                                </button>
                            </span>
                        </div>
                    @empty
                        <div class="addr-empty" id="noSavedAddresses">No saved addresses yet. Add one below.</div>
                    @endforelse
                </div>

                <button type="button" id="addAddressBtn" class="addr-add-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Add New Address
                </button>
            </div>

            {{-- ============================ STEP 1 : CHOOSE BUILDING ============================ --}}
            <div class="co-modal-overlay" id="buildingTypeModal">
                <div class="co-modal co-modal-sheet">
                    <button type="button" class="co-modal-close" data-close="buildingTypeModal">&times;</button>
                    <h3 class="co-modal-title">Choose your building</h3>
                    <p class="co-modal-subtitle">Let us know your building type for more accurate deliveries</p>

                    <div class="building-type-list">
                        <button type="button" class="building-type-row" data-building="House">
                            <span class="building-type-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 11l9-7 9 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 10v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <span class="building-type-label">House</span>
                            <span class="building-type-chevron">&rsaquo;</span>
                        </button>
                        <button type="button" class="building-type-row" data-building="Flat">
                            <span class="building-type-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="5" y="3" width="14" height="18" rx="1" stroke="currentColor" stroke-width="1.6"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></span>
                            <span class="building-type-label">Flat</span>
                            <span class="building-type-chevron">&rsaquo;</span>
                        </button>
                        <button type="button" class="building-type-row" data-building="Office">
                            <span class="building-type-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="13" rx="1" stroke="currentColor" stroke-width="1.6"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <span class="building-type-label">Office</span>
                            <span class="building-type-chevron">&rsaquo;</span>
                        </button>
                        <button type="button" class="building-type-row" data-building="Hotel">
                            <span class="building-type-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-5 9 5v12" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <span class="building-type-label">Hotel</span>
                            <span class="building-type-chevron">&rsaquo;</span>
                        </button>
                        <button type="button" class="building-type-row" data-building="Other">
                            <span class="building-type-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="10" r="2.4" stroke="currentColor" stroke-width="1.6"/></svg></span>
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
                    <h3 class="co-modal-title" id="addressModalTitle">Address info</h3>

                    <div class="co-input-group" style="margin-top:6px;">
                        <input type="text" id="mapSearchInput" class="co-input" placeholder="Search for area, street name...">
                        <div id="mapSearchResults" class="map-search-results"></div>
                    </div>

                    <div class="map-wrapper">
                        <div id="addressMap"></div>
                        <div class="map-center-pin">
                            <svg width="30" height="42" viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z" fill="#C25A2A"/><circle cx="12" cy="10" r="2.6" fill="#fff"/></svg>
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

                    <div class="co-input-group" style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" id="isDefaultCheckbox" style="width:16px;height:16px;">
                        <label for="isDefaultCheckbox" style="margin:0;text-transform:none;font-weight:600;font-size:13px;color:#374151;">Set as default address</label>
                    </div>

                    <div class="co-modal-footer">
                        <button type="button" class="co-btn-secondary" id="mapBackBtn">Back</button>
                        <button type="button" class="co-btn-primary" id="saveAddressBtn">Save</button>
                    </div>
                </div>
            </div>




        </div>
        
    </div>
</div>

{{-- Leaflet (free, no API key) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    /* ---- addresses card ---- */
    .addr-card { margin-top: 24px; }
    .addr-header { margin-bottom: 24px; padding-bottom: 20px; }

    .addr-list { display:flex; flex-direction:column; gap:10px; margin-bottom:18px; }
    .addr-empty { font-size:13px; color:#9CA3AF; padding:10px 2px; }

    .addr-row {
        display:flex; align-items:flex-start; gap:12px;
        padding:14px 16px; border:1.5px solid #F0F0EC; border-radius:14px;
        background:#FAFAF8; transition:border-color .15s ease, background .15s ease;
    }
    .addr-row.is-default { border-color:#F0E4D8; background:#FDF6F0; }
    .addr-row-icon { flex:0 0 auto; margin-top:1px; }
    .addr-row-body { flex:1 1 auto; min-width:0; }
    .addr-row-title {
        font-family:'Poppins',sans-serif; font-weight:700; font-size:13.5px; color:#0D0D0D;
        display:flex; align-items:center; gap:8px; flex-wrap:wrap;
    }
    .addr-default-badge {
        font-size:10px; font-weight:700; color:#C25A2A; background:#F5E3D6;
        padding:2px 8px; border-radius:10px; letter-spacing:.03em; text-transform:uppercase;
    }
    .addr-row-line { font-size:13px; color:#6B7280; margin-top:3px; display:block; }

    .addr-row-actions { flex:0 0 auto; display:flex; gap:6px; }
    .addr-action-btn {
        width:32px; height:32px; border-radius:9px; border:1px solid #F0F0EC; background:#fff;
        display:flex; align-items:center; justify-content:center; color:#6B7280; cursor:pointer;
        transition:background .15s ease, color .15s ease, border-color .15s ease;
    }
    .addr-action-btn:hover { background:#FAF7F2; border-color:#F0E4D8; color:#C25A2A; }
    .addr-action-btn.addr-delete:hover { color:#DC2626; border-color:#FCA5A5; background:#FEF2F2; }

    .addr-add-btn {
        display:flex; align-items:center; gap:8px; width:100%; justify-content:center;
        padding:14px 16px; border:1.5px dashed #F0E4D8; border-radius:14px;
        background:#FDF6F0; color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:13.5px;
        cursor:pointer; transition:background .15s ease;
    }
    .addr-add-btn:hover { background:#F5E3D6; }

    /* ---- modal shell ---- */
    .co-modal-overlay{
        display:none;position:fixed;inset:0;background:rgba(13,13,13,.5);
        align-items:flex-end;justify-content:center;z-index:1000;
    }
    .co-modal-overlay.open{display:flex;}
    .co-modal{
        background:#fff;width:100%;max-width:480px;border-radius:20px 20px 0 0;
        padding:24px 20px calc(20px + env(safe-area-inset-bottom));
        position:relative;max-height:92vh;overflow-y:auto;
        font-family:'DM Sans',sans-serif;
    }
    @media (min-width:560px){
        .co-modal-overlay{align-items:center;}
        .co-modal{border-radius:20px;}
    }
    .co-modal-close{
        position:absolute;top:16px;right:16px;background:none;border:none;
        font-size:22px;line-height:1;cursor:pointer;color:#333;
    }
    .co-modal-title{font-family:'Poppins',sans-serif;font-size:21px;font-weight:800;margin:0 0 4px;color:#0D0D0D;}
    .co-modal-subtitle{font-size:13px;color:#6B7280;margin:0 0 18px;}
    .co-modal-footer{display:flex;justify-content:flex-end;gap:10px;margin-top:18px;}
    .co-btn-secondary{
        padding:12px 18px;border-radius:10px;border:1px solid #F0F0EC;background:#fff;
        font-weight:600;font-size:13.5px;cursor:pointer;color:#374151;
    }
    .co-btn-primary{
        padding:12px 22px;border-radius:10px;border:none;background:#C25A2A;color:#fff;
        font-weight:700;font-size:13.5px;cursor:pointer;
    }
    .co-btn-primary:hover { background:#a94a20; }
    .co-btn-primary:disabled{opacity:.5;cursor:not-allowed;}

    .building-type-list{display:flex;flex-direction:column;gap:10px;}
    .building-type-row{
        display:flex;align-items:center;gap:14px;width:100%;
        padding:14px 16px;border:1.5px solid #F0F0EC;border-radius:14px;background:#fff;
        cursor:pointer;text-align:left;font-size:14.5px;font-weight:600;color:#0D0D0D;
        transition:border-color .15s ease,background .15s ease;
    }
    .building-type-row:hover,.building-type-row.selected{border-color:#C25A2A;background:#FDF6F0;}
    .building-type-icon{flex:0 0 auto;display:flex;color:#C25A2A;}
    .building-type-label{flex:1 1 auto;}
    .building-type-chevron{color:#D1D5DB;font-size:20px;}

    .co-modal-wide{max-width:520px;}
    .co-input-group{margin-bottom:14px;position:relative;}
    .co-input-group label{display:block;font-size:11.5px;font-weight:700;color:#374151;margin-bottom:6px;letter-spacing:.03em;text-transform:uppercase;}
    .co-input{
        width:100%;padding:12px 14px;border:1.5px solid #F0F0EC;border-radius:10px;
        font-size:14px;box-sizing:border-box;font-family:'DM Sans',sans-serif;background:#FAFAF8;
    }
    .co-input:focus{outline:none;border-color:#C25A2A;background:#fff;}
    select.co-input{background:#FAFAF8;}

    .map-search-results{
        position:absolute;left:0;right:0;top:100%;background:#fff;border:1px solid #F0F0EC;
        border-radius:10px;margin-top:4px;max-height:220px;overflow-y:auto;z-index:20;
        box-shadow:0 6px 18px rgba(0,0,0,.12);display:none;
    }
    .map-search-results.open{display:block;}
    .map-search-result-item{padding:10px 14px;font-size:13px;cursor:pointer;border-bottom:1px solid #F5F5F0;}
    .map-search-result-item:last-child{border-bottom:none;}
    .map-search-result-item:hover{background:#FAF7F2;}

    .map-wrapper{position:relative;width:100%;height:220px;border-radius:12px;overflow:hidden;margin-bottom:10px;border:1px solid #F0F0EC;}
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
    .resolved-address{font-size:13px;color:#374151;margin-bottom:16px;line-height:1.4;}

    .label-chip-row{display:flex;gap:8px;}
    .label-chip{
        padding:8px 16px;border:1.5px solid #F0F0EC;border-radius:20px;background:#fff;
        font-size:13px;font-weight:600;cursor:pointer;color:#374151;
    }
    .label-chip.selected{background:#C25A2A;color:#fff;border-color:#C25A2A;}
</style>

<script>
    (function () {
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const STORE_URL  = "{{ route('addresses.store') }}";
        // e.g. /addresses/__ID__  -> swap __ID__ at call time for update/destroy/default
        const UPDATE_URL_TEMPLATE  = "{{ route('addresses.update', ['id' => '__ID__']) }}";
        const DELETE_URL_TEMPLATE  = "{{ route('addresses.destroy', ['id' => '__ID__']) }}";
        const DEFAULT_URL_TEMPLATE = "{{ route('addresses.default', ['id' => '__ID__']) }}";
        const UK_BOUNDS = [[49.5, -8.7], [61.0, 2.1]];

        let map, moveDebounce, searchDebounce;
        let selectedBuildingType = '';
        let selectedLabel = '';
        let resolvedAddress = null; // { address, city, state, postcode, country, lat, lng }
        let editingId = null; // null = creating new, otherwise editing this address id

        const $ = (id) => document.getElementById(id);
        const buildingModal  = $('buildingTypeModal');
        const addressModal   = $('addressModal');
        const addressesList  = $('savedAddressesList');

        function openModal(el)  { el.classList.add('open'); }
        function closeModal(el) { el.classList.remove('open'); }

        document.querySelectorAll('[data-close]').forEach(btn => {
            btn.addEventListener('click', () => closeModal($(btn.dataset.close)));
        });

        function showSuccess(msg) {
            const box = $('addrSuccessBox');
            $('addrSuccessText').textContent = msg;
            box.style.display = 'flex';
            clearTimeout(showSuccess._t);
            showSuccess._t = setTimeout(() => { box.style.display = 'none'; }, 3500);
        }

        function resetForm() {
            editingId = null;
            selectedBuildingType = '';
            selectedLabel = '';
            resolvedAddress = null;
            $('additionalDetails').value = '';
            $('postcodeInput').value = '';
            $('isDefaultCheckbox').checked = false;
            document.querySelectorAll('.label-chip').forEach(c => c.classList.remove('selected'));
            document.querySelectorAll('.building-type-row').forEach(r => r.classList.remove('selected'));
        }

        // ---------- entry point: add new ----------
        $('addAddressBtn').addEventListener('click', () => {
            resetForm();
            $('addressModalTitle').textContent = 'Address info';
            openModal(buildingModal);
        });

        // ---------- wire up existing rows ----------
        function wireAddressRow(row) {
            row.querySelector('.addr-edit')?.addEventListener('click', (e) => {
                e.stopPropagation();
                startEdit(row);
            });
            row.querySelector('.addr-delete')?.addEventListener('click', (e) => {
                e.stopPropagation();
                deleteAddress(row);
            });
            row.querySelector('.addr-set-default')?.addEventListener('click', (e) => {
                e.stopPropagation();
                setDefaultAddress(row);
            });
        }
        document.querySelectorAll('.addr-row').forEach(wireAddressRow);

        // ---------- edit ----------
        function startEdit(row) {
            resetForm();
            editingId = row.dataset.id;
            selectedBuildingType = row.dataset.building || 'Other';
            selectedLabel = row.dataset.label || '';
            resolvedAddress = {
                address: row.dataset.address || '',
                city: row.dataset.city || '',
                state: row.dataset.state || '',
                postcode: row.dataset.postcode || '',
                country: row.dataset.country || 'United Kingdom',
                lat: parseFloat(row.dataset.lat) || 51.5074,
                lng: parseFloat(row.dataset.lng) || -0.1278
            };

            $('addressModalTitle').textContent = 'Edit address';
            $('buildingTypeSelect').value = selectedBuildingType;
            $('additionalDetails').value = row.dataset.landmark || '';
            $('postcodeInput').value = row.dataset.postcode || '';
            $('isDefaultCheckbox').checked = row.classList.contains('is-default');

            document.querySelectorAll('.label-chip').forEach(c => {
                c.classList.toggle('selected', c.dataset.label === selectedLabel);
            });

            openModal(addressModal);
            initMapIfNeeded();
            setTimeout(() => {
                if (map && resolvedAddress) {
                    map.setView([resolvedAddress.lat, resolvedAddress.lng], 16);
                    $('resolvedAddressLine').textContent =
                        `${resolvedAddress.address}, ${resolvedAddress.city}, ${resolvedAddress.postcode}`;
                }
            }, 120);
        }

        // ---------- delete ----------
        async function deleteAddress(row) {
            if (!confirm('Delete this address?')) return;
            const id = row.dataset.id;
            const url = DELETE_URL_TEMPLATE.replace('__ID__', id);
            try {
                const res = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                const data = await res.json();
                if (!res.ok || !data.success) throw new Error(data.message || 'Could not delete address.');

                row.remove();
                if (!addressesList.querySelector('.addr-row')) {
                    addressesList.innerHTML = '<div class="addr-empty" id="noSavedAddresses">No saved addresses yet. Add one below.</div>';
                }
                showSuccess(data.message || 'Address deleted successfully.');
            } catch (err) {
                alert(err.message || 'Something went wrong while deleting the address.');
            }
        }

        // ---------- set default ----------
        async function setDefaultAddress(row) {
            const id = row.dataset.id;
            const url = DEFAULT_URL_TEMPLATE.replace('__ID__', id);
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                const data = await res.json();
                if (!res.ok || !data.success) throw new Error(data.message || 'Could not update default address.');

                document.querySelectorAll('.addr-row').forEach(r => {
                    const isThisOne = r === row;
                    r.classList.toggle('is-default', isThisOne);
                    refreshRowBadge(r, isThisOne);
                    refreshRowActions(r, isThisOne);
                });
                // move the new default to the top
                addressesList.prepend(row);
                showSuccess(data.message || 'Default address updated.');
            } catch (err) {
                alert(err.message || 'Something went wrong while setting the default address.');
            }
        }

        function refreshRowBadge(row, isDefault) {
            const title = row.querySelector('.addr-row-title');
            let badge = title.querySelector('.addr-default-badge');
            if (isDefault && !badge) {
                badge = document.createElement('span');
                badge.className = 'addr-default-badge';
                badge.textContent = 'Default';
                title.appendChild(badge);
            } else if (!isDefault && badge) {
                badge.remove();
            }
        }

        function refreshRowActions(row, isDefault) {
            const actions = row.querySelector('.addr-row-actions');
            let btn = actions.querySelector('.addr-set-default');
            if (isDefault && btn) {
                btn.remove();
            } else if (!isDefault && !btn) {
                btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'addr-action-btn addr-set-default';
                btn.title = 'Set as default';
                btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 17.3l-6.2 3.6 1.6-7-5.4-4.7 7.1-.6L12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7z"/></svg>';
                btn.addEventListener('click', (e) => { e.stopPropagation(); setDefaultAddress(row); });
                actions.prepend(btn);
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
                    center: resolvedAddress ? [resolvedAddress.lat, resolvedAddress.lng] : [51.5074, -0.1278],
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

                if (!editingId) reverseGeocodeCenter();
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
            if (!editingId) openModal(buildingModal);
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
                is_default: $('isDefaultCheckbox').checked
            };

            const btn = $('saveAddressBtn');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const isEdit = !!editingId;
            const url = isEdit ? UPDATE_URL_TEMPLATE.replace('__ID__', editingId) : STORE_URL;

            try {
                const res = await fetch(url, {
                    method: isEdit ? 'PUT' : 'POST',
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

                if (isEdit) {
                    updateRowInList(data.data);
                } else {
                    addAddressToList(data.data);
                }

                closeModal(addressModal);
                showSuccess(data.message || (isEdit ? 'Address updated successfully.' : 'Address added successfully.'));
            } catch (err) {
                alert(err.message || 'Something went wrong while saving the address.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Save';
            }
        }

        function buildRowHTML(addr) {
            return `
                <span class="addr-row-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="1.6"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.4"/></svg>
                </span>
                <span class="addr-row-body">
                    <span class="addr-row-title">${addr.label || addr.building_type || 'Address'}${addr.is_default ? '<span class="addr-default-badge">Default</span>' : ''}</span>
                    <span class="addr-row-line">${addr.address}, ${addr.city}, ${addr.postcode}</span>
                </span>
                <span class="addr-row-actions">
                    ${!addr.is_default ? `<button type="button" class="addr-action-btn addr-set-default" title="Set as default"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 17.3l-6.2 3.6 1.6-7-5.4-4.7 7.1-.6L12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7z"/></svg></button>` : ''}
                    <button type="button" class="addr-action-btn addr-edit" title="Edit"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                    <button type="button" class="addr-action-btn addr-delete" title="Delete"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg></button>
                </span>
            `;
        }

        function fillRowDataset(row, addr) {
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
        }

        // Adds a freshly-created address to the top of the list (auto "latest selected").
        function addAddressToList(addr) {
            $('noSavedAddresses')?.remove();

            if (addr.is_default) {
                document.querySelectorAll('.addr-row').forEach(r => {
                    r.classList.remove('is-default');
                    refreshRowBadge(r, false);
                    refreshRowActions(r, false);
                });
            }

            const row = document.createElement('div');
            row.className = 'addr-row' + (addr.is_default ? ' is-default' : '');
            fillRowDataset(row, addr);
            row.innerHTML = buildRowHTML(addr);

            addressesList.prepend(row);
            wireAddressRow(row);
            return row;
        }

        // Updates an existing row in place after an edit.
        function updateRowInList(addr) {
            const row = addressesList.querySelector(`.addr-row[data-id="${addr.id}"]`);
            if (!row) { addAddressToList(addr); return; }

            if (addr.is_default) {
                document.querySelectorAll('.addr-row').forEach(r => {
                    r.classList.remove('is-default');
                    refreshRowBadge(r, false);
                    refreshRowActions(r, false);
                });
            }

            row.className = 'addr-row' + (addr.is_default ? ' is-default' : '');
            fillRowDataset(row, addr);
            row.innerHTML = buildRowHTML(addr);
            wireAddressRow(row);

            if (addr.is_default) addressesList.prepend(row);
        }
    })();
</script>
@endsection