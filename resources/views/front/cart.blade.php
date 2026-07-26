@extends('front.layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

    .cart-page {
        background: #FAF7F2;
        min-height: 100vh;
        padding: 40px 16px 100px;
    }

    .cart-wrap {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px 1fr 360px;
        gap: 24px;
        align-items: start;
    }

    /* ── Eyebrow + Title ── */
    .cart-eyebrow {
        color: #C25A2A;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .cart-title {
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.4px;
        color: #0D0D0D;
        margin: 0 0 4px;
    }
    .cart-subtitle {
        color: #6B7280;
        font-size: 14px;
        margin-bottom: 24px;
    }

    /* ── Main card ── */
    .cart-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid #F0F0EC;
        box-shadow: 0 2px 10px rgba(13,13,13,0.03);
        padding: 8px 24px;
    }

    /* ── Cart item ── */
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 16px;
        padding: 20px 0;
        border-bottom: 1px solid #F0F0EC;
        transition: background .15s;
    }
    .cart-item:last-of-type { border-bottom: none; }

    .cart-item-img-wrap {
        position: relative;
        flex-shrink: 0;
    }
    .cart-item-img {
        width: 84px; height: 84px;
        border-radius: 16px;
        object-fit: cover;
        border: 1px solid #F0F0EC;
    }

    /* veg/non-veg indicator dot on image */
    .product-type-badge {
        position: absolute;
        top: -6px;
        left: -6px;
        width: 18px; height: 18px;
        border-radius: 4px;
        background: #fff;
        border: 1.5px solid #16A34A;
        display: flex; align-items: center; justify-content: center;
    }
    .product-type-badge.nonveg { border-color: #C0392B; }
    .product-type-badge.bev { border-color: #C25A2A; }
    .product-type-badge .dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #16A34A;
    }
    .product-type-badge.nonveg .dot { background: #C0392B; }
    .product-type-badge.bev .dot { background: #C25A2A; }

    .cart-item-name {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #0D0D0D;
        margin-bottom: 4px;
        letter-spacing: -.2px;
    }
    .cart-item-variant {
        font-size: 12.5px;
        color: #9CA3AF;
        font-weight: 500;
        margin-bottom: 10px;
    }

    /* qty stepper — matches design system tokens */
    .qty-row {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid #F0F0EC;
        border-radius: 12px;
        overflow: hidden;
        width: fit-content;
        background: #fff;
    }
    .qty-btn {
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        font-size: 17px; font-weight: 700;
        transition: background .15s, color .15s;
    }
    .qty-btn.minus { background: #F5F5F0; color: #0D0D0D; }
    .qty-btn.minus:hover { background: #ECEAE3; }
    .qty-btn.plus  { background: #C25A2A; color: #fff; }
    .qty-btn.plus:hover  { background: #c42d0b; }
    .qty-num {
        min-width: 38px;
        text-align: center;
        font-size: 14px; font-weight: 700;
        color: #0D0D0D;
        height: 32px; line-height: 32px;
        background: #fff;
    }

    .cart-item-price {
        font-family: 'Poppins', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: #C25A2A;
        white-space: nowrap;
        text-align: right;
    }
    .cart-item-each {
        font-size: 12px;
        color: #9CA3AF;
        margin-top: 2px;
    }
    .cart-remove {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 10px;
        color: #9CA3AF;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: color .15s;
    }
    .cart-remove:hover { color: #C0392B; }
    .cart-remove svg { width: 12px; height: 12px; }

    /* ── Order summary sidebar (sticky) ── */
    .summary-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid #F0F0EC;
        box-shadow: 0 2px 10px rgba(13,13,13,0.03);
        padding: 28px;
        position: sticky;
        top: 90px;
    }
    .summary-title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #0D0D0D;
        margin-bottom: 18px;
        letter-spacing: -.2px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        font-size: 14px;
        color: #6B7280;
    }
    .summary-row span:last-child {
        font-weight: 600;
        color: #0D0D0D;
    }
    .summary-row.discount span:last-child { color: #16A34A; }

    .summary-divider {
        border-top: 1px dashed #E5E7EB;
        margin: 14px 0;
    }

    .summary-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 4px;
    }
    .summary-total-label {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #0D0D0D;
    }
    .summary-total-value {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #C25A2A;
        letter-spacing: -.3px;
    }

    .zero-commission-strip {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #FAF7F2;
        border: 1px solid #F0E4D8;
        border-radius: 14px;
        padding: 12px 14px;
        margin: 18px 0;
    }
    .zero-commission-strip svg { flex-shrink: 0; color: #C25A2A; width: 20px; height: 20px; }
    .zero-commission-strip p {
        font-size: 12px;
        color: #6B7280;
        line-height: 1.4;
        margin: 0;
    }
    .zero-commission-strip strong { color: #0D0D0D; }

    .btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #C25A2A;
        color: #fff;
        border-radius: 14px;
        padding: 16px 20px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        width: 100%;
        border: none;
        cursor: pointer;
        transition: background .2s, transform .15s;
        margin-top: 4px;
    }
    .btn-primary:hover { background: #c42d0b; transform: translateY(-1px); color: #fff; }
    .btn-primary svg { width: 18px; height: 18px; }

    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 11.5px;
        color: #9CA3AF;
        margin-top: 14px;
    }
    .secure-note svg { width: 13px; height: 13px; }

    /* ── Empty state ── */
    .cart-empty {
        text-align: center;
        padding: 70px 20px;
    }
    .cart-empty-icon-wrap {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: #FAF7F2;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
    .cart-empty-icon-wrap svg { width: 36px; height: 36px; color: #C25A2A; }
    .cart-empty h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 20px; font-weight: 700; color: #0D0D0D; margin-bottom: 6px;
    }
    .cart-empty p { color: #9CA3AF; font-size: 14px; margin-bottom: 22px; }
    .cart-empty .btn-black {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0D0D0D;
        color: #fff;
        border-radius: 12px;
        padding: 13px 26px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s;
    }
    .cart-empty .btn-black:hover { background: #2a2a2a; color: #fff; }

    .mob-page-title {
        display: none;
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0D0D0D;
        margin-bottom: 18px;
        letter-spacing: -.3px;
    }

    @media(max-width: 1100px) {
        .cart-wrap { grid-template-columns: 240px 1fr; }
        .summary-card { grid-column: 1 / -1; position: static; }
    }
    @media(max-width: 900px) {
        .cart-wrap { grid-template-columns: 1fr; }
    }
    @media(max-width: 640px) {
        .cart-page { padding: 20px 14px 100px; }
        .mob-page-title { display: block; }
        .cart-title { display: none; }
        .cart-subtitle { display: none; }
        .cart-card { padding: 6px 16px; }
        .cart-item { flex-wrap: wrap; }
        .cart-item-img { width: 68px; height: 68px; }
        .summary-card { padding: 20px; }
    }
</style>



<div class="cart-page">
    <div class="cart-wrap">

        {{-- SIDEBAR --}}
        
        <div>
            @auth
            @include('front.layouts.user-sidebar')
            @endauth
        </div>
        

        {{-- CONTENT --}}
        <div>
            <div class="mob-page-title">My Cart</div>

            <div class="cart-eyebrow" style="display:none;" id="desktopEyebrow">
                <i data-lucide="shopping-bag" style="width:14px;height:14px;"></i>
                YOUR ORDER
            </div>

            <div class="cart-card">

                {{-- @php $total = 0; @endphp --}}
                @php
                $subtotal = 0;
                $delivery = 0;
                @endphp

                

                @if(count($cart) > 0)
                    <h1 class="cart-title" style="padding-top:20px;">My Cart</h1>
                    <p class="cart-subtitle">{{ count($cart) }} {{ count($cart) == 1 ? 'item' : 'items' }} in your cart, ready when you are.</p>
                @endif

                @forelse($cart as $cartKey => $item)
                    {{-- @php $total += $item['price'] * $item['quantity']; @endphp --}}
                    @php
                    $itemTotal = ($item['base_price'] + ($item['addon_total'] ?? 0))
                                * $item['quantity'];

                    $subtotal += $itemTotal;
                    @endphp

                    <div class="cart-item" id="cart-item-row-{{ $cartKey }}">
                        <div style="display:flex; align-items:start; gap:14px; flex:1; min-width:0;">
                            <div class="cart-item-img-wrap">
                                <img
                                    src="{{ $item['image'] ? config('services.google_drive.image_url') . $item['image'] : asset('default.png') }}"
                                    class="cart-item-img" alt="{{ $item['name'] }}">
                                @if(isset($item['product_type']))
                                    <span class="product-type-badge {{ $item['product_type'] == 'non-veg' ? 'nonveg' : ($item['product_type'] == 'beverage' ? 'bev' : '') }}">
                                        <span class="dot"></span>
                                    </span>
                                @endif
                            </div>
                            <div style="flex:1; min-width:0;">
                                <div class="cart-item-name">{{ $item['name'] }}</div>
                                {{-- @if(!empty($item['variant_name']))
                                    <div class="cart-item-variant">{{ $item['variant_name'] }}</div>
                                @endif --}}

                                @if(!empty($item['variant_name']))
                                    <span style="
                                        display:block;
                                        font-size:13px;
                                        color:#6B7280;
                                        margin-top:3px;
                                        font-weight:500;
                                    ">
                                        {{ $item['variant_name'] }}
                                    </span>
                                @endif

                                @if(!empty($item['addons']))

                                    @php
                                        $groupedAddons = collect($item['addons'])->groupBy('category_name');
                                    @endphp

                                    <div style="margin:14px 0 16px;">

                                        @foreach($groupedAddons as $category => $addons)

                                            <div style="
                                                font-size:13px;
                                                font-weight:700;
                                                color:#111827;
                                                margin-bottom:8px;
                                                margin-top:10px;
                                            ">
                                                {{ $category }}
                                            </div>

                                            <div style="
                                                display:flex;
                                                flex-wrap:wrap;
                                                gap:8px;
                                            ">

                                                @foreach($addons as $addon)

                                                    <div style="
                                                        display:flex;
                                                        align-items:center;
                                                        justify-content:space-between;
                                                        gap:12px;
                                                        background:#FAFAFA;
                                                        border:1px solid #E5E7EB;
                                                        border-radius:999px;
                                                        padding:7px 8px 7px 12px;
                                                    ">

                                                        <div style="
                                                            display:flex;
                                                            align-items:center;
                                                            gap:6px;
                                                        ">

                                                            <span style="
                                                                width:8px;
                                                                height:8px;
                                                                border-radius:50%;
                                                                background:#C25A2A;
                                                                display:inline-block;
                                                            "></span>

                                                            <span style="
                                                                font-size:13px;
                                                                font-weight:600;
                                                                color:#222;
                                                            ">
                                                                {{ $addon['addon_name'] }}
                                                            </span>

                                                            <span style="
                                                                font-size:12px;
                                                                color:#C25A2A;
                                                                font-weight:700;
                                                            ">
                                                                +£{{ number_format($addon['price'],2) }}
                                                            </span>

                                                        </div>

                                                        <a href="{{ route('cart.removeAddon',[$cartKey,$addon['id']]) }}"
                                                        title="Remove Addon"
                                                        style="
                                                                width:20px;
                                                                height:20px;
                                                                border-radius:50%;
                                                                background:#FFE7E7;
                                                                color:#DC2626;
                                                                display:flex;
                                                                align-items:center;
                                                                justify-content:center;
                                                                text-decoration:none;
                                                                font-size:12px;
                                                                font-weight:bold;
                                                                transition:.2s;
                                                                flex-shrink:0;
                                                        "
                                                        onmouseover="this.style.background='#DC2626';this.style.color='#fff';"
                                                        onmouseout="this.style.background='#FFE7E7';this.style.color='#DC2626';">

                                                            ✕

                                                        </a>

                                                    </div>

                                                @endforeach

                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                               
                                <div class="qty-row">
                                    <a href="{{ url('/cart/decrease/'.$cartKey) }}" class="qty-btn minus" data-cart-action="decrease" data-cart-key="{{ $cartKey }}">−</a>
                                    <span class="qty-num" id="qty-val-{{ $cartKey }}">{{ $item['quantity'] }}</span>
                                    <a href="{{ url('/cart/increase/'.$cartKey) }}" class="qty-btn plus" data-cart-action="increase" data-cart-key="{{ $cartKey }}">+</a>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:right; flex-shrink:0;">
                            {{-- <div class="cart-item-price">£{{ number_format($item['price'] * $item['quantity'], 2) }}</div> --}}
                            <div class="cart-item-price" id="item-subtotal-val-{{ $cartKey }}">
                                £{{ number_format($itemTotal,2) }}
                            </div>
                            <div class="cart-item-each">
                                £{{ number_format($item['base_price'] + ($item['addon_total'] ?? 0),2) }} each
                            </div>
                            <a href="{{ url('/cart/remove/'.$cartKey) }}" class="cart-remove" data-cart-action="remove" data-cart-key="{{ $cartKey }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M18 6L6 18M6 6l12 12"/></svg>
                                Remove
                            </a>
                        </div>
                    </div>

                @empty
                    <div class="cart-empty">
                        <div class="cart-empty-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                            </svg>
                        </div>
                        <h3>Your cart is empty</h3>
                        <p>Add some delicious items to get started!</p>
                        <a href="/" class="btn-black">
                            <i data-lucide="utensils" style="width:16px;height:16px;"></i>
                            Browse Restaurants
                        </a>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- ORDER SUMMARY --}}
        @if(count($cart) > 0)
        <div>
            <div class="summary-card">
                <div class="summary-title">Order Summary</div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="summary-subtotal-val">£{{ number_format($subtotal,2) }}</span>
                </div>
                

                <div class="summary-divider"></div>

                <div class="summary-total-row">
                    <span class="summary-total-label">Total</span>
                    <span class="summary-total-value" id="summary-total-val">
                        £{{ number_format($subtotal + $delivery,2) }}
                    </span>
                </div>

                <div class="zero-commission-strip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p><strong>Commission.</strong> Your full payment supports the restaurant directly — no hidden cuts.</p>
                </div>

                @auth
                <a href="/checkout" class="btn-primary">
                    Proceed to Checkout
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                @else
                <a href="/login?redirect=/checkout" class="btn-primary">
                    Proceed to Checkout
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                {{-- <button class="btn-primary" onclick="openGuestModal()">
                    Proceed to Checkout
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button> --}}
                @endauth

                <div class="secure-note">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Secure checkout
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<div id="guestModal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:99999;align-items:center;justify-content:center;padding:20px;">

    <div style="
        width:560px;
        height:90vh;
        overflow-y:scroll;
        max-width:100%;
        background:#fff;
        border-radius:24px;
        padding:32px;
        position:relative;
        box-shadow:0 20px 60px rgba(0,0,0,.18);">

        <button type="button"
                onclick="closeGuestModal()"
                style="
                    position:absolute;
                    right:18px;
                    top:18px;
                    width:36px;
                    height:36px;
                    border:none;
                    border-radius:50%;
                    background:#F5F5F5;
                    cursor:pointer;
                    font-size:18px;">
            ✕
        </button>

        <div style="font-size:28px;font-weight:700;color:#111;font-family:Poppins;">
            Guest Checkout
        </div>

        <p style="margin:8px 0 28px;color:#6B7280;font-size:14px;">
            Enter your delivery information to continue.
        </p>

        <form method="POST" action="{{ route('guest.checkout.store') }}">
            @csrf

            <div style="display:grid;gap:16px;">

                <input type="text"
                       name="guest_name"
                       placeholder="Full Name"
                       required
                       class="guest-input">

                <input type="email"
                       name="guest_email"
                       placeholder="Email Address"
                       required
                       class="guest-input">

                <input type="text"
                       name="guest_phone"
                       placeholder="Phone Number"
                       required
                       class="guest-input">

                <input type="text"
                       name="address"
                       placeholder="Street Address"
                       required
                       class="guest-input">
                <input type="text"
                       name="country"
                       placeholder="Country"
                       required
                       class="guest-input">

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

                    <input type="text"
                           name="city"
                           placeholder="City"
                           required
                           class="guest-input">

                    <input type="text"
                           name="state"
                           placeholder="State"
                           required
                           class="guest-input">

                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

                    <input type="text"
                           name="latitude"
                           placeholder="Latitude"
                           required
                           class="guest-input">

                    <input type="text"
                           name="longitude"
                           placeholder="Longitude"
                           required
                           class="guest-input">

                </div>

                <input type="text"
                       name="postcode"
                       placeholder="Postcode"
                       required
                       class="guest-input">

            </div>

            <div style="display:flex;gap:16px;margin-top:30px;">

                <button type="button"
                        onclick="closeGuestModal()"
                        style="
                            width:140px;
                            height:54px;
                            border:none;
                            border-radius:14px;
                            background:#111;
                            color:#fff;
                            font-weight:600;
                            cursor:pointer;">
                    Cancel
                </button>

                <button type="submit"
                        style="
                            flex:1;
                            height:54px;
                            border:none;
                            border-radius:14px;
                            background:#C25A2A;
                            color:#fff;
                            font-weight:700;
                            cursor:pointer;">
                    Continue →
                </button>

            </div>

        </form>

    </div>

</div>

<style>
    .guest-input{
        width:100%;
        height:52px;
        border:1px solid #E5E7EB;
        border-radius:14px;
        padding:0 18px;
        font-size:15px;
        font-family:'DM Sans',sans-serif;
        transition:.2s;
        outline:none;
        background:#fff;
    }

    .guest-input:focus{
        border-color:#C25A2A;
        box-shadow:0 0 0 3px rgba(194,90,42,.12);
    }

    .guest-input::placeholder{
        color:#9CA3AF;
    }

    @media(max-width:600px){

        #guestModal > div{
            padding:24px;
        }

        #guestModal form > div:nth-child(2){
            grid-template-columns:1fr !important;
        }

    }

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        let btn = e.target.closest('[data-cart-action]');
        if (!btn) return;

        e.preventDefault();
        let action = btn.getAttribute('data-cart-action');
        let key = btn.getAttribute('data-cart-key');
        if (!action || !key) return;

        if (typeof window.showGlobalLoader === 'function') {
            let msg = action === 'remove' ? 'Removing Item...' : 'Updating Cart...';
            window.showGlobalLoader(msg, 'Please wait', 2000);
        }

        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.5';

        let url = '/cart/' + action + '/' + encodeURIComponent(key);

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(res => {
            btn.style.pointerEvents = '';
            btn.style.opacity = '';

            if (typeof window.hideGlobalLoader === 'function') {
                window.hideGlobalLoader();
            }

            if (!res.success) return;

            if (res.cart_empty) {
                window.location.reload();
                return;
            }

            if (action === 'remove' || res.quantity === 0) {
                let row = document.getElementById('cart-item-row-' + key);
                if (row) row.remove();
            } else {
                let qtyEl = document.getElementById('qty-val-' + key);
                if (qtyEl) qtyEl.textContent = res.quantity;

                let itemSubtotalEl = document.getElementById('item-subtotal-val-' + key);
                if (itemSubtotalEl) itemSubtotalEl.textContent = '£' + res.item_subtotal;
            }

            let subtotalEl = document.getElementById('summary-subtotal-val');
            if (subtotalEl) subtotalEl.textContent = '£' + res.original_total;

            let totalEl = document.getElementById('summary-total-val');
            if (totalEl) totalEl.textContent = '£' + res.original_total;

            let headerCount = document.getElementById('cartCount');
            if (headerCount) headerCount.textContent = res.cart_count;
        })
        .catch(err => {
            btn.style.pointerEvents = '';
            btn.style.opacity = '';
            if (typeof window.hideGlobalLoader === 'function') {
                window.hideGlobalLoader();
            }
        });
    });
});

if (window.lucide) { lucide.createIcons(); }
</script>

@endsection