@extends('layouts.app')

@section('content')

<style>
    body { font-family: 'Poppins', sans-serif; }
    .hyst-page { background: #F5F0E8; min-height: 100vh; padding: 2rem 1.5rem; }
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.75rem; gap:1rem; flex-wrap:wrap; }
    .page-title { font-size:22px; font-weight:800; color:#0D0D0D; margin:0 0 3px; letter-spacing:-0.3px; }
    .page-sub { font-size:13px; color:#999; margin:0; }
    .btn-back { display:inline-flex; align-items:center; gap:7px; background:#fff; color:#555; font-family:'Poppins',sans-serif; font-size:13.5px; font-weight:600; border:1.5px solid #EBE5DE; border-radius:12px; padding:10px 18px; cursor:pointer; text-decoration:none; transition:border-color 0.16s,color 0.16s; }
    .btn-back:hover { border-color:#C25A2A; color:#C25A2A; }

    .hyst-card { background:#fff; border-radius:20px; box-shadow:0 4px 30px rgba(194,90,42,0.09),0 1px 4px rgba(0,0,0,0.05); overflow:hidden; }

    .card-head { padding:1.4rem 1.75rem; border-bottom:1.5px solid #F0EAE2; display:flex; align-items:center; gap:12px; }
    .card-head-icon { width:38px; height:38px; background:#FDF0E8; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#C25A2A; flex-shrink:0; }
    .card-head-title { font-size:15px; font-weight:700; color:#0D0D0D; margin:0; }
    .card-head-sub { font-size:12px; color:#AAA; margin:2px 0 0; }

    .card-body { padding:1.75rem; }

    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }

    .field-label { font-size:11px; font-weight:700; color:#555; letter-spacing:0.07em; text-transform:uppercase; }

    .field-wrap { position:relative; }
    .field-icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#C25A2A; pointer-events:none; display:flex; align-items:center; }
    .field-icon-top { position:absolute; left:13px; top:14px; color:#C25A2A; pointer-events:none; display:flex; align-items:center; }

    .field-input, .field-select {
        width:100%; border:1.5px solid #EBE5DE;
        padding:12px 14px 12px 40px; border-radius:12px;
        font-family:'Poppins',sans-serif; font-size:14px;
        color:#0D0D0D; background:#FDFAF7; outline:none;
        box-sizing:border-box; transition:border-color 0.18s,background 0.18s;
        -webkit-appearance:none; appearance:none;
    }
    .field-input::placeholder { color:#BFBAB3; }
    .field-input:focus, .field-select:focus { border-color:#C25A2A; background:#fff; }

    .field-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23C25A2A' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 13px center;
        padding-right:36px;
    }

    select.field-select[multiple] {
        background-image:none; padding:12px 14px 12px 40px; min-height:140px;
    }
    select.field-select[multiple] option { padding:7px 6px; border-radius:6px; }
    select.field-select[multiple] option:checked { background:#FDF0E8; color:#C25A2A; }

    .field-textarea {
        width:100%; border:1.5px solid #EBE5DE;
        padding:12px 14px 12px 40px; border-radius:12px;
        font-family:'Poppins',sans-serif; font-size:14px;
        color:#0D0D0D; background:#FDFAF7; outline:none;
        box-sizing:border-box; resize:vertical; min-height:110px;
        transition:border-color 0.18s,background 0.18s;
    }
    .field-textarea::placeholder { color:#BFBAB3; }
    .field-textarea:focus { border-color:#C25A2A; background:#fff; }

    .file-zone {
        border:1.5px dashed #D8CECC; border-radius:12px;
        padding:1.1rem 1.25rem; background:#FDFAF7;
        transition:border-color 0.18s,background 0.18s;
        display:flex; align-items:center; gap:10px; cursor:pointer;
        position:relative;
    }
    .file-zone:hover { border-color:#C25A2A; background:#FDF8F5; }
    .file-zone input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
    .file-zone-icon { width:36px; height:36px; background:#F5F0E8; border-radius:9px; display:flex; align-items:center; justify-content:center; color:#C25A2A; flex-shrink:0; }
    .file-zone-text { font-size:13px; color:#AAA; font-weight:500; line-height:1.4; }
    .file-zone-text span { color:#C25A2A; font-weight:700; }
    .file-zone-text small { display:block; font-size:11px; color:#CCC; }

    .form-divider { height:1.5px; background:#F0EAE2; grid-column:1/-1; margin:0.25rem 0; }
    .form-section-label { grid-column:1/-1; font-size:12px; font-weight:700; color:#C25A2A; letter-spacing:0.06em; text-transform:uppercase; margin:0.4rem 0 -0.4rem; }

    .form-footer { padding:1.25rem 1.75rem; border-top:1.5px solid #F0EAE2; display:flex; align-items:center; justify-content:flex-end; gap:12px; }

    .btn-submit { display:inline-flex; align-items:center; gap:8px; background:#C25A2A; color:#fff; font-family:'Poppins',sans-serif; font-size:14px; font-weight:700; border:none; border-radius:12px; padding:13px 28px; cursor:pointer; transition:background 0.16s,transform 0.12s; }
    .btn-submit:hover { background:#A84B22; transform:scale(1.01); }

    .btn-cancel { display:inline-flex; align-items:center; gap:7px; background:#F5F0E8; color:#888; font-family:'Poppins',sans-serif; font-size:13.5px; font-weight:600; border:1.5px solid #EBE5DE; border-radius:12px; padding:12px 20px; cursor:pointer; text-decoration:none; transition:border-color 0.16s,color 0.16s; }
    .btn-cancel:hover { border-color:#C25A2A; color:#C25A2A; }

    .field-hint { font-size:11px; color:#BBB; margin-top:2px; }
</style>

<div class="hyst-page">
<div class="max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Add Restaurant</h1>
            <p class="page-sub">Create a new restaurant</p>
        </div>
        <a href="{{ route('ambassador.restaurants.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back
        </a>
    </div>

    <div class="hyst-card">

        <div class="card-head">
            <div class="card-head-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/><path d="M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/></svg>
            </div>
            <div>
                <p class="card-head-title">Restaurant Details</p>
                <p class="card-head-sub">Fill in the information below to add a new restaurant</p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('ambassador.restaurants.store') }}">
            @csrf

            <div class="card-body">
                <div class="form-grid">

                    {{-- Restaurant Name --}}
                    <div class="form-group">
                        <label class="field-label">Restaurant Name</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/></svg>
                            </span>
                            <input type="text" required name="name" value="{{ old('name') }}" placeholder="Enter restaurant name" class="field-input">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="field-label">Email</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
                            </span>
                            <input type="email" required name="email" value="{{ old('email') }}" placeholder="Enter email" class="field-input">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="field-label">Password <span style="color:#E24B4A;">*</span></label>
                        <div class="field-wrap" style="position:relative;">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <input type="password" required name="password" id="ambassador_restaurant_password" placeholder="e.g. HystPass123!" class="field-input @error('password') field-error @enderror" style="padding-right:44px;">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('ambassador_restaurant_password', 'pw_eye_icon_amb')"
                                    style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#AAA; padding:0; display:flex; align-items:center;"
                                    title="Toggle password visibility">
                                <svg id="pw_eye_icon_amb" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p style="color:#E24B4A; font-size:12px; font-weight:600; margin-top:4px;">⚠️ {{ $message }}</p>
                        @enderror
                        <div style="margin-top:8px; padding:10px 12px; background:#FFF8F3; border:1px solid #FBE3D5; border-radius:10px; font-size:11.5px; color:#555;">
                            <p style="font-weight:700; color:#C25A2A; margin-bottom:4px;">🔒 Password Requirements:</p>
                            <ul style="list-style-type:disc; padding-left:16px; margin:0; line-height:1.5; color:#666;">
                                <li>Minimum 8 characters long</li>
                                <li>At least 1 uppercase letter (A–Z)</li>
                                <li>At least 1 lowercase letter (a–z)</li>
                                <li>At least 1 number (0–9)</li>
                                <li>At least 1 special character (@$!%*?& or symbols)</li>
                            </ul>
                            <p style="margin-top:6px; color:#C25A2A; font-weight:600;">
                                💡 Example Password: <code style="background:#fff; padding:2px 6px; border-radius:4px; border:1px solid #F0D0C0; font-family:monospace; color:#333;">HystPass123!</code>
                            </p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="form-group">
                        <label class="field-label">Phone</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.68 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.32 1.85.55 2.81.68A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <input type="text" required name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" class="field-input">
                        </div>
                    </div>

                    <!-- Address Search Component -->
                    <div class="form-group full" style="background:#F4F6F8; padding:20px; border-radius:14px; border:1px solid #E2E8F0;">
                        <label class="field-label" style="color:#1E293B; font-weight:700; font-size:15px; margin-bottom:10px;">
                            Search & Select Restaurant Address
                        </label>
                        <div class="field-wrap" style="position:relative;">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                            </span>
                            <input
                                type="text"
                                id="leafletSearchInput"
                                placeholder="Type address, area or postcode to search..."
                                class="field-input"
                                style="background:#fff;"
                                autocomplete="off"
                            >
                            <div id="leafletSearchResults" class="absolute left-0 right-0 top-full bg-white border border-gray-200 rounded-xl mt-1 max-h-60 overflow-y-auto z-[9999] shadow-2xl hidden" style="position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid #CBD5E1; border-radius:10px; z-index:99; display:none; max-height:220px; overflow-y:auto; box-shadow:0 10px 25px rgba(0,0,0,0.15);"></div>
                        </div>
                        <div id="restaurantMapContainer" style="margin-top:14px; border-radius:12px; border:1px solid #CBD5E1; overflow:hidden; height:220px;">
                            <div id="restaurantMap" style="width:100%; height:100%;"></div>
                        </div>
                        <p class="field-hint" style="color:#2563EB; font-weight:600; margin-top:8px;">💡 Search address above to fill details automatically</p>
                    </div>

                    {{-- City --}}
                    <div class="form-group">
                        <label class="field-label">City</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M9 8h1M9 12h1M9 16h1M14 8h1M14 12h1M14 16h1"/><path d="M5 21V5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v16"/><path d="M13 21v-9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v9"/></svg>
                            </span>
                            <input type="text" required name="city" value="{{ old('city') }}" placeholder="Enter city" class="field-input">
                        </div>
                    </div>

                    {{-- State --}}
                    <div class="form-group">
                        <label class="field-label">State</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 6v16l7-4 8 4 7-4V2l-7 4-8-4-7 4z"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                            </span>
                            <input type="text" required name="state" value="{{ old('state') }}" placeholder="Enter state" class="field-input">
                        </div>
                    </div>

                    {{-- Country --}}
                    <div class="form-group">
                        <label class="field-label">Country</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            </span>
                            <input type="text" required name="country" value="{{ old('country') }}" placeholder="Enter country" class="field-input">
                        </div>
                    </div>

                    {{-- Longitude --}}
                    <div class="form-group">
                        <label class="field-label">Longitude</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="2" x2="12" y2="22"/></svg>
                            </span>
                            <input type="text" required name="longitude" value="{{ old('longitude') }}" placeholder="Enter longitude" class="field-input">
                        </div>
                    </div>

                    {{-- Latitude --}}
                    <div class="form-group">
                        <label class="field-label">Latitude</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
                            </span>
                            <input type="text" required  name="latitude" value="{{ old('latitude') }}" placeholder="Enter latitude" class="field-input">
                        </div>
                    </div>

                    {{-- Postal Code --}}
                    <div class="form-group">
                        <label class="field-label">Postal Code</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </span>
                            <input type="text" required name="postcode" value="{{ old('postcode') }}" placeholder="Enter postal code" class="field-input">
                        </div>
                    </div>

                    {{-- Hygiene Rating --}}
                    <div class="form-group">
                        <label class="field-label">Hygiene Rating</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </span>
                            <input type="number" required step="0.1" min="0" max="5" name="hygiene_rating" value="{{ old('hygiene_rating') }}" placeholder="0.0 - 5.0" class="field-input">
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    {{-- Address --}}
                    <div class="form-group full">
                        <label class="field-label">Address</label>
                        <div class="field-wrap">
                            <span class="field-icon-top">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <textarea name="location" required rows="3" placeholder="Enter address" class="field-textarea">{{ old('location') }}</textarea>
                        </div>
                    </div>

                    {{-- Categories --}}
                    <div class="form-group full">
                        <label class="field-label">Categories</label>
                        <div class="field-wrap">
                            <span class="field-icon-top">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                            </span>
                            <select name="category_ids[]" required multiple class="field-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="field-hint">Hold Ctrl (Windows) / Cmd (Mac) to select multiple.</p>
                    </div>

                    {{-- Dietary Categories --}}
                    <div class="form-group full">
                        <label class="field-label">Dietary Categories</label>
                        <div style="display:flex; flex-wrap:wrap; gap:16px; padding:14px 16px; border:1.5px solid #EBE5DE; border-radius:12px; background:#FDFAF7;">
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px; font-weight:600; color:#0D0D0D;">
                                <input type="checkbox" name="dietary_categories[]" value="halal" {{ in_array('halal', old('dietary_categories', [])) ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#C25A2A;">
                                <span>🌙 Halal</span>
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px; font-weight:600; color:#0D0D0D;">
                                <input type="checkbox" name="dietary_categories[]" value="vegan" {{ in_array('vegan', old('dietary_categories', [])) ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#C25A2A;">
                                <span>🌱 Vegan</span>
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px; font-weight:600; color:#0D0D0D;">
                                <input type="checkbox" name="dietary_categories[]" value="vegetarian" {{ (in_array('vegetarian', old('dietary_categories', [])) || in_array('vegetable', old('dietary_categories', []))) ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#C25A2A;">
                                <span>🥗 Vegetarian</span>
                            </label>
                        </div>
                        <p class="field-hint">Select any or all dietary options served by this restaurant.</p>
                    </div>

                    {{-- Description --}}
                    <div class="form-group full">
                        <label class="field-label">Description</label>
                        <div class="field-wrap">
                            <span class="field-icon-top">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                            </span>
                            <textarea name="description" required rows="5" placeholder="Restaurant description…" class="field-textarea">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    {{-- Restaurant Image --}}
                    {{-- Restaurant Image --}}
                    <div class="form-group full">
                        <label class="field-label">Restaurant Image</label>
                        <label class="file-zone">
                            <input
                                type="file"
                                id="image"
                                name="image"
                                required
                                accept="image/*"
                                onchange="validateFileSize(this, 'image-error', 2); previewFile(this, 'img-preview-create');">

                            <div class="file-zone-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>

                            <div class="file-zone-text">
                                <span>Choose file</span> or drag &amp; drop here
                                <small>PNG, JPG, WEBP — max 2MB</small>
                            </div>

                            <img id="img-preview-create"
                                src=""
                                alt=""
                                style="display:none;width:56px;height:56px;border-radius:10px;object-fit:cover;border:1.5px solid #EBE5DE;margin-left:auto;flex-shrink:0;">
                        </label>

                        <small id="image-error" style="color: red; "></small>
                    </div>

                    {{-- Hygiene Certificate --}}
                    <div class="form-group full">
                        <label class="field-label">Hygiene Certificate</label>

                        <label class="file-zone">
                            <input
                                type="file"
                                id="hygiene_certificate"
                                name="hygiene_certificate"
                                required
                                accept=".pdf,.jpg,.jpeg,.png"
                                onchange="validateFileSize(this, 'certificate-error', 2);previewFile(this, 'img-preview-create2');">

                            <div class="file-zone-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>

                            <div class="file-zone-text">
                                <span>Choose file</span> or drag &amp; drop here
                                <small>PDF, JPG, PNG — max 2MB</small>
                            </div>
                            <img id="img-preview-create2"
                                src=""
                                alt=""
                                style="display:none;width:56px;height:56px;border-radius:10px;object-fit:cover;border:1.5px solid #EBE5DE;margin-left:auto;flex-shrink:0;">
                        </label>

                        <small id="certificate-error" style="color: red;"></small>
                    </div>

                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('ambassador.restaurants.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Save Restaurant
                </button>
            </div>

        </form>
    </div>
</div>
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

        // Hide preview if image was cleared
        if (input.name === 'image') {
            const preview = document.getElementById('img-preview-create');
            if (preview) {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    }
}
</script>

<script>
function previewFile(input, previewId) {
    var preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

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
                searchResults.style.display = 'none';
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
                        searchResults.style.display = 'none';
                        return;
                    }
                    results.forEach(r => {
                        const item = document.createElement('div');
                        item.style.padding = '10px 14px';
                        item.style.cursor = 'pointer';
                        item.style.borderBottom = '1px solid #F1F5F9';
                        item.style.fontSize = '13px';
                        item.style.color = '#334155';
                        item.textContent = r.display_name;
                        item.addEventListener('mouseenter', () => item.style.background = '#F8FAFC');
                        item.addEventListener('mouseleave', () => item.style.background = '#fff');
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
                            searchResults.style.display = 'none';
                        });
                        searchResults.appendChild(item);
                    });
                    searchResults.style.display = 'block';
                })
                .catch(err => console.error('Search error:', err));
            }, 350);
        });

        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
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
            icon.innerHTML = '<path d="M1.5 12s4-8 10.5-8 10.5 8 10.5 8-4 8-10.5 8S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/>';
        }
    }
}
</script>