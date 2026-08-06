@extends('front.layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --primary: #C25A2A;
        --primary-hover: #a84b20;
        --primary-light: #FFF5F0;
        --primary-border: #FAD7C8;
        --green: #10B981;
        --green-light: #F0FDF4;
        --green-border: #BBF7D0;
        --bg: #FAF9F6;
        --white: #ffffff;
        --border: #E5E7EB;
        --border-soft: #F3F4F6;
        --text: #0D0D0D;
        --muted: #6B7280;
        --label: #374151;
        --input-bg: #F9FAFB;
        --card-radius: 20px;
        --btn-radius: 12px;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--bg);
        color: var(--text);
    }

    .co-page {
        background: var(--bg);
        min-height: 100vh;
        padding: 12px 16px 60px;
    }

    /* ── HEADER & BREADCRUMB ── */
    .co-header {
        max-width: 1200px;
        margin: 0 auto 12px;
    }
    .co-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 8px;
    }
    .co-breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }
    .co-header h1 {
        font-size: clamp(20px, 3vw, 24px);
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.5px;
    }

    /* ── LAYOUT WRAPPER ── */
    .co-wrap {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 16px;
        align-items: start;
    }
    .co-left { display: flex; flex-direction: column; gap: 12px; }

    /* ── CARDS ── */
    .co-card {
        background: var(--white);
        border-radius: 14px;
        padding: 14px 18px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }
    .co-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .co-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .step-num {
        width: 24px;
        height: 24px;
        background: var(--primary);
        color: #fff;
        border-radius: 50%;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .step-meta {
        font-size: 13px;
        font-weight: 500;
        color: var(--muted);
    }

    /* ── ORDER ITEM ROW ── */
    .co-item {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-soft);
        align-items: flex-start;
    }
    .co-item:first-child { padding-top: 0; }
    .co-item:last-child { border-bottom: none; padding-bottom: 0; }

    .co-item-img {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--border-soft);
        background: #F3F4F6;
        flex-shrink: 0;
    }
    .co-item-body {
        flex: 1;
        min-width: 0;
    }
    .co-item-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        line-height: 1.2;
    }

    /* QTY CONTROL */
    .qty-controls {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }
    .qty-btn {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        transition: background 0.18s;
    }
    .qty-btn.minus { background: #F9FAFB; }
    .qty-btn.plus  { background: var(--primary); color: #fff; }
    .qty-btn.minus:hover { background: #E5E7EB; }
    .qty-btn.plus:hover  { background: var(--primary-hover); }
    .qty-num {
        min-width: 24px;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        color: var(--text);
        padding: 0 2px;
    }

    .co-remove-btn {
        color: #9CA3AF;
        font-size: 12px;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.18s;
    }
    .co-remove-btn:hover { color: #DC2626; }

    /* ── OPTION SELECTORS (ORDER TYPE) ── */
    .ot-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 10px;
    }

    .ot-label {
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 10px 12px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        position: relative;
    }
    .ot-label input[type=radio] { display: none; }
    .ot-label:hover { border-color: var(--primary-border); background: var(--primary-light); transform: translateY(-1px); }
    
    .ot-label.checked {
        border-color: var(--primary);
        background: linear-gradient(135deg, #FFF7F3 0%, #FFEFE6 100%);
        box-shadow: 0 0 0 2px var(--primary), 0 4px 12px rgba(194, 90, 42, 0.12);
    }
    .ot-label .selected-badge {
        display: none;
        margin-left: auto;
        background: var(--primary);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
    }
    .ot-label.checked .selected-badge { display: inline-block; }
    .ot-label.checked .ot-icon { background: #FFD8C9; }

    .ot-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #F3F4F6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .ot-title { font-size: 13px; font-weight: 700; color: var(--text); }
    .ot-sub   { font-size: 10px; color: var(--muted); margin-top: 1px; }

    .radio-dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #D1D5DB;
        margin-left: auto;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.18s;
    }
    .radio-dot::after {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #fff;
        display: none;
    }

    /* INPUT STYLES */
    .co-hidden { display: none !important; }
    .co-input-group { margin-bottom: 14px; }
    .co-input-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--label);
        margin-bottom: 6px;
    }
    .co-input, .co-textarea {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        color: var(--text);
        background: var(--input-bg);
        outline: none;
        transition: border-color 0.18s, background 0.18s;
    }
    .co-input:focus, .co-textarea:focus {
        border-color: var(--primary);
        background: var(--white);
    }
    .co-textarea { resize: none; height: 84px; }

    /* ── RIGHT COLUMN: SUMMARY ── */
    .co-right { position: sticky; top: 16px; }

    .co-summary {
        background: var(--white);
        border-radius: 14px;
        padding: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }
    .summary-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border-soft);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .summary-row .sr-label { color: #4B5563; font-weight: 500; }
    .summary-row .sr-value { font-weight: 700; color: var(--text); }
    .summary-row .sr-value.green { color: #16A34A; }

    .summary-divider {
        border: none;
        border-top: 1px dashed var(--border);
        margin: 8px 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background: #FAF9F6;
        border: 1px solid var(--border);
        border-radius: 10px;
        margin: 10px 0;
    }
    .summary-total-label { font-size: 14px; font-weight: 700; color: var(--text); }
    .summary-total-value {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary);
    }

    .co-place-btn {
        width: 100%;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 13px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.18s, transform 0.12s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(194, 90, 42, 0.3);
    }
    .co-place-btn:hover { background: var(--primary-hover); transform: translateY(-1px); }

    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin-top: 8px;
        font-size: 11px;
        color: var(--muted);
        font-weight: 500;
    }

    /* ── MOBILE STICKY FOOTER BAR ── */
    .mobile-footer {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: var(--white);
        border-top: 1px solid var(--border);
        padding: 12px 16px calc(12px + env(safe-area-inset-bottom));
        z-index: 9999;
        box-shadow: 0 -4px 25px rgba(0, 0, 0, 0.1);
    }
    .mobile-footer-inner {
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .mobile-footer-amount {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.1;
    }
    .mobile-footer-label { font-size: 11px; color: var(--muted); font-weight: 500; }
    .mobile-footer-btn {
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(194, 90, 42, 0.3);
    }

    /* ── RESPONSIVE STYLING ── */
    @media (max-width: 900px) {
        .co-wrap { grid-template-columns: 1fr; }
        .co-right { position: static; }
        .mobile-footer { display: block; }
        .co-page { padding-bottom: 120px; }
    }

    @media (max-width: 580px) {
        .co-page { padding: 16px 12px 120px; }
        .co-card { padding: 18px 14px; border-radius: 16px; }
        
        .co-item {
            grid-template-columns: 72px 1fr;
            gap: 12px;
        }
        .co-item-img { width: 72px; height: 72px; }
        .co-item-right {
            grid-column: 1 / -1;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding-top: 6px;
            border-top: 1px dashed var(--border-soft);
        }
        .subtotal-val { font-size: 16px; }
    }
</style>

<div class="co-page">

    <!-- BREADCRUMB & HEADER -->
    <div class="co-header">
        <div class="co-breadcrumb">
            <a href="/">Home</a> <span>/</span>
            <a href="{{ url('/restaurant/' . $restaurant->slug) }}">{{ $restaurant->name }}</a> <span>/</span>
            <span>Checkout</span>
        </div>
        <h1>Complete Your Order</h1>
    </div>

    <form method="POST" action="/place-order" id="checkoutForm">
        @csrf

        <div class="co-wrap">

            <!-- ══════════ LEFT COLUMN ══════════ -->
            <div class="co-left">

                <!-- ERRORS -->
                @if ($errors->any())
                <div style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626; padding:14px 18px; border-radius:14px; margin-bottom:16px; font-size:14px;">
                    <strong style="font-weight:700;">Please check the required fields:</strong>
                    <ul style="margin-top:6px; margin-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                <!-- RESTAURANT ADDRESS & 10 KM RADIUS BANNER -->
                <div class="co-card" style="background:#FAF7F2; border:1px solid #F0E4D8; margin-bottom:4px;">
                    <div style="display:flex; align-items:flex-start; gap:14px;">
                        <div style="width:42px; height:42px; border-radius:12px; background:#C25A2A; color:#fff; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; box-shadow:0 2px 8px rgba(194,90,42,0.25);">
                            🏪
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                                <div style="font-weight:800; font-size:16px; color:#111827; font-family:'Poppins',sans-serif;">{{ $restaurant->name }}</div>
                                <span style="background:#FFF5F0; border:1px solid #FAD7C8; color:#C25A2A; font-size:11.5px; font-weight:700; padding:4px 10px; border-radius:999px; display:inline-flex; align-items:center; gap:4px;">
                                    📍 Max 10 KM Radius Limit
                                </span>
                            </div>
                            <div style="font-size:13px; color:#4B5563; margin-top:4px; line-height:1.4;">
                                📍 {{ $restaurant->address ?? 'Main Address' }}@if($restaurant->city), {{ $restaurant->city }}@endif @if($restaurant->postcode), {{ $restaurant->postcode }}@endif, United Kingdom
                            </div>
                            <div style="font-size:12px; color:#6B7280; margin-top:6px; background:#fff; padding:6px 12px; border-radius:8px; border:1px solid #E5E7EB; display:inline-block;">
                                🇬🇧 Orders in the United Kingdom can only be booked within a <strong>10 KM radius</strong> of this restaurant.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── STEP 1: ORDER ITEMS ── -->
                <div class="co-card">
                    <div class="co-card-header">
                        <div class="co-card-title">
                            <span class="step-num">1</span>
                            <span>Order Items</span>
                        </div>
                        <span class="step-meta">
                            {{ count($cart) }} {{ Str::plural('item', count($cart)) }}
                        </span>
                    </div>

                    @forelse($cart as $cartKey => $item)
                    @php
                        $offer = $item['offer'];
                        $itemPrice = $item['base_price'] + ($item['addon_total'] ?? 0);
                        $subtotal = $item['subtotal'] ?? ($itemPrice * $item['quantity']);
                    @endphp

                    <div class="co-item" id="co-item-{{ $cartKey }}" data-key="{{ $cartKey }}">
                        <!-- ITEM IMAGE -->
                        <img src="{{ $item['image'] ? config('services.google_drive.image_url') . $item['image'] : asset('default.png') }}"
                             class="co-item-img"
                             alt="{{ $item['name'] }}"
                             loading="lazy">

                        <!-- ITEM BODY -->
                        <div class="co-item-body">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                                <div>
                                    <div class="co-item-name" title="{{ $item['name'] }}">{{ $item['name'] }}</div>
                                    @if(!empty($item['variant_name']))
                                        <div style="font-size:11px; color:#6B7280; font-weight:500;">
                                            Variant: {{ $item['variant_name'] }}
                                        </div>
                                    @endif
                                </div>
                                <a href="javascript:void(0)" class="co-remove-btn" data-action="remove" data-key="{{ $cartKey }}">Remove ✕</a>
                            </div>

                            @if(!empty($item['addons']))
                                @php
                                    $groupedAddons = collect($item['addons'])->groupBy('category_name');
                                @endphp
                                <div style="margin-top:4px;">
                                    @foreach($groupedAddons as $category => $addons)
                                        <div style="display:flex; flex-wrap:wrap; gap:4px; margin-top:2px;">
                                            @foreach($addons as $addon)
                                                <div style="display:inline-flex; align-items:center; gap:4px; background:#F9FAFB; border:1px solid #E5E7EB; border-radius:10px; padding:2px 6px; font-size:10px;">
                                                    <span style="width:4px; height:4px; border-radius:50%; background:#C25A2A;"></span>
                                                    <span>{{ $addon['addon_name'] }}</span>
                                                    <span style="color:#C25A2A; font-weight:700;">+£{{ number_format($addon['price'],2) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
                                <div class="qty-controls">
                                    <a href="javascript:void(0)" class="qty-btn minus" data-action="decrease" data-key="{{ $cartKey }}" aria-label="Decrease quantity">−</a>
                                    <span class="qty-num" id="qty-{{ $cartKey }}" aria-label="Quantity">{{ $item['quantity'] }}</span>
                                    <a href="javascript:void(0)" class="qty-btn plus" data-action="increase" data-key="{{ $cartKey }}" aria-label="Increase quantity">+</a>
                                </div>

                                <div style="text-align:right;">
                                    <span style="font-size:10px; color:#9CA3AF; display:block;">Subtotal</span>
                                    <span style="font-size:15px; font-weight:700; color:#111;" id="item-subtotal-{{ $cartKey }}">£{{ number_format($subtotal, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <div style="text-align:center; padding:40px 16px;">
                        <div style="font-size:40px; margin-bottom:10px;">🛒</div>
                        <h3 style="font-size:18px; font-weight:700; color:#111;">Your Cart is Empty</h3>
                        <p style="color:#6B7280; font-size:14px;">Add items to your cart to proceed with checkout.</p>
                    </div>
                    @endforelse
                </div>

                <!-- ── STEP 2: ORDER TYPE ── -->
                <div class="co-card">
                    <div class="co-card-title" style="margin-bottom:16px;">
                        <span class="step-num">2</span>
                        <span>How would you like your order?</span>
                    </div>

                    <div class="ot-grid">
                        @if($restaurant->dine_in)
                        <label class="ot-label" id="ot-dinein">
                            <input type="radio" name="order_type" value="dine_in">
                            <div class="ot-icon">🍽️</div>
                            <div>
                                <div class="ot-title">Dine In</div>
                                <div class="ot-sub">Eat at restaurant</div>
                            </div>
                            <span class="selected-badge">✓ Selected</span>
                        </label>
                        @endif

                        @if($restaurant->takeaway)
                        <label class="ot-label" id="ot-takeaway">
                            <input type="radio" name="order_type" value="takeaway">
                            <div class="ot-icon">🥡</div>
                            <div>
                                <div class="ot-title">Takeaway</div>
                                <div class="ot-sub">Pick up your order</div>
                            </div>
                            <span class="selected-badge">✓ Selected</span>
                        </label>
                        @endif

                        {{-- @if($restaurant->home_delivery)
                        <label class="ot-label checked" id="ot-delivery">
                            <input type="radio" name="order_type" value="delivery" checked>
                            <div class="ot-icon">🚚</div>
                            <div>
                                <div class="ot-title">Home Delivery</div>
                                <div class="ot-sub">Delivered to door</div>
                            </div>
                            <span class="selected-badge">✓ Selected</span>
                        </label>
                        @endif --}}
                        @php
                            $showDelivery = $restaurant->home_delivery &&
                                (
                                    !$restaurant->self_delivery ||
                                    $restaurant->deliveryCharges()->exists()
                                );
                        @endphp

                        @if($showDelivery)
                            <label class="ot-label checked" id="ot-delivery">
                                <input type="radio" name="order_type" value="delivery" checked>
                                <div class="ot-icon">🚚</div>
                                <div>
                                    <div class="ot-title">Home Delivery</div>
                                    <div class="ot-sub">Delivered to door</div>
                                </div>
                                <span class="selected-badge">✓ Selected</span>
                            </label>
                        @endif
                    </div>

                    <!-- DELIVERY ADDRESS INCLUSION -->
                    <div id="addressContainer">
                    @auth
                    
                        @include('front.address.index')
                      
                    @endauth
                    
                    </div>  
                </div>

                <!-- ── STEP 3: ORDER DESCRIPTION (OPTIONAL) ── -->
                <div class="co-card">
                    <div class="co-card-title" style="margin-bottom:16px;">
                        <span class="step-num">3</span>
                        <span>Order Notes <span style="font-size:12px;color:#6B7280;font-weight:500;">(Optional)</span></span>
                    </div>

                    <label
                        for="description"
                        style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;">
                        Special Instructions
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        maxlength="500"
                        placeholder="Example: No onions, extra spicy, ring the doorbell once, leave at the reception, etc."
                        style="width:100%;
                            border:1px solid #E5E7EB;
                            border-radius:12px;
                            padding:12px;
                            font-size:14px;
                            resize:vertical;
                            outline:none;
                            background:#fff;">{{ old('description') }}</textarea>

                    <div style="display:flex;justify-content:space-between;margin-top:6px;">
                        <small style="color:#6B7280;">
                            Add any notes for the restaurant or delivery partner.
                        </small>

                        <small id="description-count" style="color:#9CA3AF;">
                            0 / 500
                        </small>
                    </div>
                </div>

                <!-- Hidden Payment Method (Always Online) -->
                <input type="hidden" name="payment_method" value="online">
                <input type="hidden" name="amount" value="{{ $finalTotal }}">
                <input type="hidden" name="service_charge" value="{{ $serviceCharge }}">
                <input type="hidden" name="hyst_charge" value="{{ $hystCharge }}">

            </div>
            <!-- ══════════ END LEFT ══════════ -->


            <!-- ══════════ RIGHT COLUMN: SUMMARY ══════════ -->
            <div class="co-right">
                <div class="co-summary">
                    <div class="summary-title" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; padding-bottom:12px;">
                        <span>Order Summary</span>
                        <span style="font-size:12px; font-weight:600; color:var(--primary);">
                            {{ count($cart) }} {{ Str::plural('item', count($cart)) }}
                        </span>
                    </div>

                    <!-- ── LOYALTY REWARDS BANNER ── -->
                    @if(isset($activeLoyaltyReward) && $activeLoyaltyReward)
                        @php
                            $rewardValueText = $activeLoyaltyReward->reward_type === 'percentage' 
                                ? number_format($activeLoyaltyReward->reward_value, 0) . '% OFF' 
                                : '£' . number_format($activeLoyaltyReward->reward_value, 2) . ' OFF';
                            $loyaltyApplied = (isset($loyaltyDiscount) && $loyaltyDiscount > 0);
                        @endphp
                        <div style="background: {{ $loyaltyApplied ? '#ECFDF5' : '#FEF3C7' }}; border:1.5px solid {{ $loyaltyApplied ? '#10B981' : '#F59E0B' }}; border-radius:14px; padding:14px; margin-bottom:16px;">
                            <div style="font-size:13px; font-weight:700; color: {{ $loyaltyApplied ? '#065F46' : '#92400E' }}; display:flex; align-items:center; justify-content:space-between; gap:6px;">
                                <span>🎁 Active Loyalty Reward Available</span>
                                <span style="background: {{ $loyaltyApplied ? '#10B981' : '#F59E0B' }}; color:#fff; padding:2px 8px; border-radius:999px; font-size:11px; font-weight:800;">-{{ $rewardValueText }}</span>
                            </div>
                            <p style="font-size:12px; color: {{ $loyaltyApplied ? '#047857' : '#B45309' }}; margin:6px 0 0 0; line-height:1.4;">
                                @if($loyaltyApplied)
                                    You earned a {{ $rewardValueText }} reward from a previous qualifying order at {{ $restaurant->name }}. It has been automatically applied to this order!
                                @else
                                    You have a {{ $rewardValueText }} reward available! Since your subtotal is already fully covered by another offer discount, your reward remains saved in your account for your next order.
                                @endif
                            </p>
                            @if($loyaltyApplied)
                                <input type="hidden" name="loyalty_reward_id" value="{{ $activeLoyaltyReward->id }}">
                            @endif
                        </div>
                    @elseif(isset($loyaltyRule) && $loyaltyRule && $loyaltyRule->is_active)
                        @php
                            $ruleRewardText = $loyaltyRule->reward_type === 'percentage' 
                                ? number_format($loyaltyRule->reward_value, 0) . '% reward' 
                                : '£' . number_format($loyaltyRule->reward_value, 2) . ' reward';
                            $isQualifiedForReward = ($originalTotal >= $loyaltyRule->minimum_order_amount);
                        @endphp
                        <div id="loyaltyRuleBox"
                             data-min="{{ $loyaltyRule->minimum_order_amount }}"
                             data-reward="{{ $ruleRewardText }}"
                             style="background: {{ $isQualifiedForReward ? '#ECFDF5' : '#EFF6FF' }}; border: 1px solid {{ $isQualifiedForReward ? '#10B981' : '#3B82F6' }}; border-radius:14px; padding:12px 14px; margin-bottom:16px;">
                            <div id="loyaltyRuleTitle" style="font-size:12.5px; font-weight:700; color: {{ $isQualifiedForReward ? '#065F46' : '#1E40AF' }}; display:flex; align-items:center; gap:6px;">
                                <span>{{ $isQualifiedForReward ? '🎉 Congratulations! You have qualified for Loyalty Rewards.' : '⭐ Loyalty Rewards Opportunity' }}</span>
                            </div>
                            <p id="loyaltyRuleDesc" style="font-size:12px; color: {{ $isQualifiedForReward ? '#047857' : '#1D4ED8' }}; margin:4px 0 0 0; line-height:1.4;">
                                @if($isQualifiedForReward)
                                    Complete this order to earn a <strong>{{ $ruleRewardText }}</strong> for your next order!
                                @else
                                    Spend <strong>£{{ number_format($loyaltyRule->minimum_order_amount, 2) }}</strong> or more on this order to earn a <strong>{{ $ruleRewardText }}</strong> for your next order!
                                @endif
                            </p>
                        </div>
                    @endif

                    <!-- ── PROMOTIONS & COUPONS (UPPER SIDE) ── -->
                    <div style="background:#FAF9F6; border:1px solid var(--border); border-radius:14px; padding:14px; margin-bottom:16px;">
                        <div style="font-size:13px; font-weight:700; color:#374151; margin-bottom:10px; display:flex; align-items:center; gap:6px;">
                            <span>🏷️ Have a Coupon or Gift Card?</span>
                        </div>

                        <!-- Coupon Input -->
                        <div style="margin-bottom:10px;">
                            <div style="display:flex; gap:8px;">
                                <input type="text" id="coupon_code" class="co-input" placeholder="Coupon Code" style="text-transform:uppercase; padding:9px 12px; font-size:13px; background:#fff;">
                                <button type="button" id="applyCoupon" class="co-place-btn" style="width:90px; padding:9px 12px; font-size:12px; box-shadow:none;">
                                    Apply
                                </button>
                            </div>
                            <div id="couponMessage" style="margin-top:6px; font-size:12px; font-weight:600;"></div>
                        </div>

                        <!-- Gift Card Input -->
                        <div>
                            <div style="display:flex; gap:8px;">
                                <input type="text" id="gift_card_code" class="co-input" placeholder="Gift Card Code" style="text-transform:uppercase; padding:9px 12px; font-size:13px; background:#fff;">
                                <button type="button" id="applyGiftCard" class="co-place-btn" style="width:90px; padding:9px 12px; font-size:12px; background:#374151; box-shadow:none;">
                                    Apply
                                </button>
                            </div>
                            <div id="giftCardMessage" style="margin-top:6px; font-size:12px; font-weight:600;"></div>
                        </div>
                    </div>

                    @foreach($cart as $cartKey => $item)
                    @php
                        $itemPrice = $item['base_price'] + ($item['addon_total'] ?? 0);
                        $subtotal = $item['subtotal'] ?? ($itemPrice * $item['quantity']);
                    @endphp
                    <div class="summary-row" id="summary-item-{{ $cartKey }}" style="font-size:13px;">
                        <span class="sr-label" style="flex:1; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; padding-right:8px;">
                            {{ $item['name'] }} <span id="summary-qty-{{ $cartKey }}" style="color:#9CA3AF;">×{{ $item['quantity'] }}</span>
                        </span>
                        <span class="sr-value" id="summary-subtotal-{{ $cartKey }}">£{{ number_format($subtotal, 2) }}</span>
                    </div>
                    @endforeach

                    <hr class="summary-divider">

                    <!-- Breakdown Rows -->
                    <div class="summary-row">
                        <span class="sr-label">Cart Subtotal</span>
                        <span class="sr-value" id="cartSubtotalText">£{{ number_format($originalTotal, 2) }}</span>
                    </div>

                    @if(isset($discount) && $discount > 0)
                        <div class="summary-row">
                            <span class="sr-label" style="color:#C25A2A;">
                                🎉 Offer Discount
                                @if(isset($orderOffer) && $orderOffer)
                                    ({{ $orderOffer->title }})
                                @endif
                            </span>
                            <span class="sr-value green">
                                -£{{ number_format($discount, 2) }}
                            </span>
                        </div>
                    @endif

                    @if(isset($loyaltyDiscount) && $loyaltyDiscount > 0)
                        <div class="summary-row">
                            <span class="sr-label" style="color:#059669; font-weight:600;">
                                🎁 Loyalty Reward Discount
                            </span>
                            <span class="sr-value green" style="color:#059669; font-weight:700;">
                                -£{{ number_format($loyaltyDiscount, 2) }}
                            </span>
                        </div>
                    @endif

                    <div class="summary-row" id="couponRow" style="display:none;">
                        <span class="sr-label" style="color:#25D366;">
                            🏷️ Coupon Discount
                        </span>
                        <span class="sr-value green" id="couponDiscountText">
                            -£0.00
                        </span>
                    </div>

                    <div class="summary-row" id="giftCardRow" style="display:none;">
                        <span class="sr-label" style="color:#25D366;">
                            💳 Gift Card
                        </span>
                        <span class="sr-value green" id="giftCardDiscountText">
                            -£0.00
                        </span>
                    </div>

                    <div class="summary-row" id="deliveryChargeRow">
                        <span class="sr-label">Delivery Charge</span>
                        <span class="sr-value" id="deliveryChargeText">£0.00</span>
                    </div>

                    <div class="summary-row">
                        <span class="sr-label">Operation Charge</span>
                        <span class="sr-value" id="hystChargeText">£0.00</span>
                    </div>

                    <!-- Hidden Price State Inputs -->
                    <input type="hidden" id="raw_cart_subtotal" value="{{ $originalTotal }}">
                    <input type="hidden" id="offer_discount" value="{{ $discount }}">
                    <input type="hidden" id="loyalty_discount" value="{{ $loyaltyDiscount ?? 0 }}">
                    <input type="hidden" id="delivery_charge" name="delivery_charge" value="0">
                    <input type="hidden" id="hyst_charge" name="hyst_charge" value="0">
                    <input type="hidden" id="uber_quote_id" name="uber_quote_id" value="">
                    <input type="hidden" id="cartSubtotal" value="{{ max($originalTotal - $discount - ($loyaltyDiscount ?? 0), 0) }}">
                    <input type="hidden" id="couponIdHidden" name="coupon_id">
                    <input type="hidden" id="couponCodeHidden" name="coupon_code">
                    <input type="hidden" id="couponDiscountHidden" name="coupon_discount" value="0">
                    <input type="hidden" id="giftCardIdHidden" name="gift_card_id">
                    <input type="hidden" id="giftCardCodeHidden" name="gift_card_code">
                    <input type="hidden" id="giftCardAmountHidden" name="gift_card_amount" value="0">
                    <input type="hidden" name="is_scheduled" id="is_scheduled" value="0">

                    <input type="hidden" name="scheduled_for" id="scheduled_for">

                    <hr class="summary-divider">

                    <!-- Total Box -->
                    <div class="summary-total">
                        <span class="summary-total-label">Total to Pay</span>
                        <div class="summary-total-value" id="finalTotalText">
                            £{{ number_format($finalTotal, 2) }}
                        </div>
                    </div>

                    @if(isset($orderOffer) && $orderOffer)
                    <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:10px; padding:10px 14px; margin-bottom:16px; font-size:13px; font-weight:600; color:#15803D; display:flex; align-items:center; gap:6px;">
                        <span id="totalSavingText">🎉 You're saving £{{ number_format($orderOfferDiscount ?? 0, 2) }} on this order!</span>
                    </div>
                    @endif

                    <button type="submit" class="co-place-btn" form="checkoutForm">
                        <span>Place Order</span>
                    </button>

                    <div class="secure-note">
                        <span>SSL 256-Bit Encrypted & Secure Checkout</span>
                    </div>
                </div>
            </div>
            <!-- ══════════ END RIGHT ══════════ -->

        </div>
    </form>
</div>

<!-- ══════════ MOBILE STICKY BOTTOM BAR ══════════ -->
<div class="mobile-footer" id="mobileFooter">
    <div class="mobile-footer-inner">
        <div>
            <div class="mobile-footer-label">Total Amount</div>
            <div class="mobile-footer-amount" id="mobileFinalTotalText">
                £{{ number_format($finalTotal, 2) }}
            </div>
        </div>
        <button type="submit" class="mobile-footer-btn" form="checkoutForm">
            <span>Place Order</span>
        </button>
    </div>
</div>


<script>
    (function () {
        /* ── PLACE ORDER BUTTON VALIDATION ── */
        window.validateCheckoutPlaceOrderButton = function() {
            const orderTypeInput = document.querySelector('input[name="order_type"]:checked');
            const orderType = orderTypeInput ? orderTypeInput.value : 'delivery';
            const placeBtns = document.querySelectorAll('.co-place-btn, .mobile-footer-btn');

            // Dine In or Takeaway: No delivery address validation required
            if (orderType === 'dine_in' || orderType === 'takeaway') {
                placeBtns.forEach(btn => {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                    btn.style.cursor = 'pointer';
                });
                return true;
            }

            // Home Delivery: Validate delivery address deliverability
            const addressId = document.getElementById('address_id')?.value;
            const addressVal = document.getElementById('address')?.value;
            const quoteStatus = document.getElementById('uberQuoteStatus');
            const hasErrorDisplay = quoteStatus && quoteStatus.style.display !== 'none' && quoteStatus.classList.contains('uber-quote-error');

            let isValid = true;

            if (!addressId && !addressVal) {
                isValid = false;
            }

            if (hasErrorDisplay) {
                isValid = false;
            }

            if (isValid) {
                placeBtns.forEach(btn => {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                    btn.style.cursor = 'pointer';
                });
                return true;
            } else {
                placeBtns.forEach(btn => {
                    btn.disabled = true;
                    btn.style.opacity = '0.4';
                    btn.style.pointerEvents = 'none';
                    btn.style.cursor = 'not-allowed';
                });
                return false;
            }
        };

        const description = document.getElementById('description');
        const counter = document.getElementById('description-count');

        if (description) {

            const updateCounter = () => {
                counter.textContent = `${description.value.length} / 500`;
            };

            updateCounter();

            description.addEventListener('input', updateCounter);
        }

        /* ── ORDER TYPE RADIO HIGHLIGHT & SYNC ── */
        document.querySelectorAll('.ot-label').forEach(function(label) {
            label.addEventListener('click', function () {
                var radio = this.querySelector('input[type="radio"]');
                if (radio && !radio.checked) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });

        function updateScheduleUI(orderType) {
            const container = document.getElementById('deliveryScheduleContainer');
            if (!container) return;

            const cardTitle     = document.getElementById('scheduleCardTitle');
            const nowTitle      = document.getElementById('dtNowTitle');
            const nowSub        = document.getElementById('dtNowSub');
            const scheduleTitle = document.getElementById('dtScheduleTitle');
            const scheduleSub   = document.getElementById('dtScheduleSub');
            const dateLabel     = document.getElementById('scheduledDateLabel');
            const timeLabel     = document.getElementById('scheduledTimeLabel');

            if (orderType === 'delivery') {
                container.style.display = 'block';
                if (cardTitle)     cardTitle.textContent     = '🕒 Delivery Time';
                if (nowTitle)      nowTitle.textContent      = 'Deliver Now';
                if (nowSub)        nowSub.textContent        = 'Deliver immediately';
                if (scheduleTitle) scheduleTitle.textContent = 'Schedule Delivery';
                if (scheduleSub)   scheduleSub.textContent   = 'Choose date & time';
                if (dateLabel)     dateLabel.textContent     = 'Delivery Date';
                if (timeLabel)     timeLabel.textContent     = 'Delivery Time';
            } else if (orderType === 'takeaway') {
                container.style.display = 'block';
                if (cardTitle)     cardTitle.textContent     = '🕒 Takeaway Time';
                if (nowTitle)      nowTitle.textContent      = 'Takeaway Now';
                if (nowSub)        nowSub.textContent        = 'Pick up immediately';
                if (scheduleTitle) scheduleTitle.textContent = 'Schedule Takeaway';
                if (scheduleSub)   scheduleSub.textContent   = 'Choose date & time';
                if (dateLabel)     dateLabel.textContent     = 'Pick Up Date';
                if (timeLabel)     timeLabel.textContent     = 'Pick Up Time';
            } else {
                container.style.display = 'none';
            }
        }

        document.querySelectorAll('input[name="order_type"]').forEach(function(radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.ot-label').forEach(function(l) { l.classList.remove('checked'); });
                var label = this.closest('.ot-label');
                if (label) label.classList.add('checked');

                var df          = document.getElementById('deliveryFields');
                var deliveryRow = document.getElementById('deliveryChargeRow');
                var addr        = document.getElementById('address');
                var pin         = document.getElementById('postcode');

                if (this.value === 'delivery') {
                    if (df) df.classList.remove('co-hidden');
                    if (deliveryRow) deliveryRow.style.display = "flex";
                    
                    if (addr) addr.required = true;
                    if (pin)  pin.required  = true;

                    updateScheduleUI('delivery');

                    if (typeof window.fetchUberQuote === 'function') {
                        window.fetchUberQuote();
                    }

                } else if (this.value === 'takeaway') {

                    if (df) df.classList.add('co-hidden');
                    if (deliveryRow) deliveryRow.style.display = "none";
                    if (addr) addr.required = false;
                    if (pin) pin.required = false;

                    updateScheduleUI('takeaway');

                    // Clear selected address UI
                    document.querySelectorAll('.address-option-row').forEach(row => {
                        row.classList.remove('selected');
                    });

                    // Clear hidden address fields
                    document.getElementById('address_id').value = "";
                    document.getElementById('address').value = "";
                    document.getElementById('pincode').value = "";
                    document.getElementById('city').value = "";
                    document.getElementById('state').value = "";
                    document.getElementById('country').value = "";
                    document.getElementById('latitude').value = "";
                    document.getElementById('longitude').value = "";
                    document.getElementById('building_type').value = "";
                    document.getElementById('landmark').value = "";
                    document.getElementById('label').value = "";

                    // Clear delivery charge
                    document.getElementById("delivery_charge").value = 0;
                    document.getElementById("deliveryChargeText").innerHTML = "£0.00";
                    document.getElementById("uber_quote_id").value = "";

                    // Hide quote message
                    const quoteBox = document.getElementById("uberQuoteStatus");
                    if (quoteBox) {
                        quoteBox.style.display = "none";
                        quoteBox.innerHTML = "";
                    }

                } else {

                    if (df) df.classList.add('co-hidden');
                    if (deliveryRow) deliveryRow.style.display = "none";
                    if (addr) addr.required = false;
                    if (pin) pin.required = false;

                    updateScheduleUI('dine_in');

                    // Clear selected address UI
                    document.querySelectorAll('.address-option-row').forEach(row => {
                        row.classList.remove('selected');
                    });

                    // Clear hidden address fields
                    document.getElementById('address_id').value = "";
                    document.getElementById('address').value = "";
                    document.getElementById('pincode').value = "";
                    document.getElementById('city').value = "";
                    document.getElementById('state').value = "";
                    document.getElementById('country').value = "";
                    document.getElementById('latitude').value = "";
                    document.getElementById('longitude').value = "";
                    document.getElementById('building_type').value = "";
                    document.getElementById('landmark').value = "";
                    document.getElementById('label').value = "";

                    // Clear delivery charge
                    document.getElementById("delivery_charge").value = 0;
                    document.getElementById("deliveryChargeText").innerHTML = "£0.00";
                    document.getElementById("uber_quote_id").value = "";

                    // Hide quote message
                    const quoteBox = document.getElementById("uberQuoteStatus");
                    if (quoteBox) {
                        quoteBox.style.display = "none";
                        quoteBox.innerHTML = "";
                    }
                }

                updateGrandTotal();

                // Re-verify Gift Card if code is entered or applied
                const gcCodeVal = document.getElementById("gift_card_code")?.value?.trim() || document.getElementById("giftCardCodeHidden")?.value?.trim();
                if (gcCodeVal) {
                    const applyBtn = document.getElementById("applyGiftCard");
                    if (applyBtn) applyBtn.click();
                }
                window.validateCheckoutPlaceOrderButton();
            });
        });

       function updateDeliveryTimeUI() {

             document.querySelectorAll('input[name="delivery_time_type"]').forEach(r => {
                 const label = r.closest('.dt-label');
                 if (label) label.classList.toggle('checked', r.checked);
             });

             const scheduleRadio = document.querySelector(
                 'input[name="delivery_time_type"][value="schedule"]'
             );
             const isSchedule = scheduleRadio ? scheduleRadio.checked : false;

             const scheduleFields = document.getElementById('scheduleFields');
             if (scheduleFields) {
                 scheduleFields.classList.toggle('co-hidden', !isSchedule);
             }

             const dateElem = document.getElementById('scheduled_date');
             const timeElem = document.getElementById('scheduled_time');
             if (dateElem) dateElem.required = isSchedule;
             if (timeElem) timeElem.required = isSchedule;
        }

        document.querySelectorAll('input[name="delivery_time_type"]').forEach(radio => {
            radio.addEventListener('change', updateDeliveryTimeUI);
        });

        document.addEventListener('DOMContentLoaded', updateDeliveryTimeUI);

        document.addEventListener('DOMContentLoaded', function() {
            window.validateCheckoutPlaceOrderButton();
        });

        /* ── FORM SUBMISSION ROUTING (ALWAYS ONLINE) ── */
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            const orderType = document.querySelector('input[name="order_type"]:checked');

            if (!orderType) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Order Type Required',
                    text: 'Please select how you would like your order.',
                    confirmButtonColor: '#C25A2A'
                });
                return;
            }

            if (orderType.value === 'delivery') {
                const isValid = window.validateCheckoutPlaceOrderButton();
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Delivery Address Unavailable',
                        text: 'The selected delivery address is outside the delivery area or unavailable. Please choose a deliverable address or select Dine In / Takeaway.',
                        confirmButtonColor: '#C25A2A'
                    });
                    return;
                }
            }

            const typeElem = document.querySelector(
                'input[name="delivery_time_type"]:checked'
            );
            const type = typeElem ? typeElem.value : 'now';

            if (type === 'schedule') {

                document.getElementById('is_scheduled').value = 1;

                document.getElementById('scheduled_for').value =
                    document.getElementById('scheduled_date').value +
                    ' ' +
                    document.getElementById('scheduled_time').value +
                    ':00';

            } else {

                document.getElementById('is_scheduled').value = 0;
                document.getElementById('scheduled_for').value = '';

            }

            e.preventDefault();
            this.action = "{{ route('payment.pay') }}";
            this.submit();
        });

        @if(count($cart) === 0)
        var mf = document.getElementById('mobileFooter');
        if (mf) mf.style.display = 'none';
        @endif
    })();
</script>

<script>

    function updateTotalSaving() {
        const offer = parseFloat(document.getElementById('offer_discount')?.value || 0);
        const loyalty = parseFloat(document.getElementById('loyalty_discount')?.value || 0);
        const coupon = parseFloat(document.getElementById('couponDiscountHidden')?.value || 0);
        const gift = parseFloat(document.getElementById('giftCardAmountHidden')?.value || 0);

        const total = offer + loyalty + coupon + gift;

        const totalSavingElem = document.getElementById('totalSavingText');
        if (totalSavingElem) {
            totalSavingElem.textContent = `🎉 You're saving £${total.toFixed(2)} on this order!`;
        }
    }

    let couponDiscount = 0;

    document.getElementById('applyCoupon').onclick = function () {
        fetch("{{ route('coupon.apply') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                code: document.getElementById('coupon_code').value,
                restaurant_id: "{{ $restaurant->id }}",
                offer_discount: parseFloat(document.getElementById('offer_discount').value || 0)
            })
        })
        .then(r => r.json())
        .then(res => {
            if (!res.success) {
                couponDiscount = 0;
                document.getElementById('couponMessage').innerHTML = "<span style='color:#DC2626;'>" + res.message + "</span>";
                document.getElementById("couponRow").style.display = "none";
                document.getElementById("couponDiscountHidden").value = 0;
                updateGrandTotal();
                return;
            }

            couponDiscount = parseFloat(res.discount);
            document.getElementById('couponMessage').innerHTML = "<span style='color:#16A34A;'>✓ Coupon Applied Successfully</span>";
            document.getElementById("couponRow").style.display = "flex";
            document.getElementById("couponDiscountText").innerHTML = "-£" + couponDiscount.toFixed(2);
            document.getElementById("couponCodeHidden").value = res.coupon;
            document.getElementById("couponIdHidden").value = res.coupon_id;
            document.getElementById("couponDiscountHidden").value = couponDiscount;
            updateGrandTotal();
            updateTotalSaving();
        });
    };

    let giftCardDiscount = 0;

    document.getElementById("applyGiftCard").onclick = function () {
        const orderTypeInput = document.querySelector('input[name="order_type"]:checked');
        const currentOrderType = orderTypeInput ? orderTypeInput.value : 'delivery';
        const giftCardCode = document.getElementById("gift_card_code")?.value || '';

        if (!giftCardCode || giftCardCode.trim() === '') {
            document.getElementById("giftCardMessage").innerHTML = "<span style='color:#DC2626;'>Please enter a Gift Card code.</span>";
            return;
        }

        fetch("{{ route('gift-card.apply') }}", {
            method: "POST",
            headers: {
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":"{{ csrf_token() }}"
            },
            body: JSON.stringify({
                code: giftCardCode,
                order_type: currentOrderType,
                offer_discount: parseFloat(document.getElementById('offer_discount').value || 0),
                coupon_discount: couponDiscount
            })
        })
        .then(r=>r.json())
        .then(res=>{
            if(!res.success){
                giftCardDiscount = 0;
                document.getElementById("giftCardRow").style.display="none";
                document.getElementById("giftCardAmountHidden").value = 0;
                document.getElementById("giftCardIdHidden").value = "";
                document.getElementById("giftCardCodeHidden").value = "";
                document.getElementById("giftCardMessage").innerHTML = "<span style='color:#DC2626;'>"+res.message+"</span>";
                updateGrandTotal();
                return;
            }

            giftCardDiscount = parseFloat(res.discount);
            document.getElementById("giftCardMessage").innerHTML = "<span style='color:#16A34A;'>✓ Gift Card Applied Successfully</span>";
            document.getElementById("giftCardRow").style.display="flex";
            document.getElementById("giftCardDiscountText").innerHTML = "-£"+giftCardDiscount.toFixed(2);
            document.getElementById("giftCardIdHidden").value = res.gift_card_id;
            document.getElementById("giftCardCodeHidden").value = res.gift_card;
            document.getElementById("giftCardAmountHidden").value = giftCardDiscount;
            updateGrandTotal();
            updateTotalSaving();
        });
    };

    function updateLoyaltyRuleMessage() {
        const box = document.getElementById("loyaltyRuleBox");
        if (!box) return;

        const minAmount = parseFloat(box.dataset.min || 0);
        const rewardText = box.dataset.reward || "";
        const rawSubtotal = parseFloat(document.getElementById("raw_cart_subtotal")?.value || 0);

        const titleEl = document.getElementById("loyaltyRuleTitle");
        const descEl = document.getElementById("loyaltyRuleDesc");

        if (rawSubtotal >= minAmount) {
            box.style.background = "#ECFDF5";
            box.style.border = "1px solid #10B981";
            if (titleEl) {
                titleEl.style.color = "#065F46";
                titleEl.innerHTML = "<span>🎉 Congratulations! You have qualified for Loyalty Rewards.</span>";
            }
            if (descEl) {
                descEl.style.color = "#047857";
                descEl.innerHTML = "Complete this order to earn a <strong>" + rewardText + "</strong> for your next order!";
            }
        } else {
            box.style.background = "#EFF6FF";
            box.style.border = "1px solid #3B82F6";
            if (titleEl) {
                titleEl.style.color = "#1E40AF";
                titleEl.innerHTML = "<span>⭐ Loyalty Rewards Opportunity</span>";
            }
            if (descEl) {
                descEl.style.color = "#1D4ED8";
                descEl.innerHTML = "Spend <strong>£" + minAmount.toFixed(2) + "</strong> or more on this order to earn a <strong>" + rewardText + "</strong> for your next order!";
            }
        }
    }

    function updateGrandTotal() {
        let rawSubtotal = parseFloat(document.getElementById("raw_cart_subtotal").value || 0);
        let offerDiscount = parseFloat(document.getElementById("offer_discount").value || 0);
        let loyaltyDiscount = parseFloat(document.getElementById("loyalty_discount") ? document.getElementById("loyalty_discount").value : 0) || 0;
        let delivery = parseFloat(document.getElementById("delivery_charge").value || 0);

        updateLoyaltyRuleMessage();

        let subtotalAfterOffer = Math.max(rawSubtotal - offerDiscount, 0);
        let subtotalAfterLoyalty = Math.max(subtotalAfterOffer - loyaltyDiscount, 0);
        let subtotalAfterCoupon = Math.max(subtotalAfterLoyalty - couponDiscount, 0);
        let finalSubtotal = Math.max(subtotalAfterCoupon - giftCardDiscount, 0);

        let orderType = document.querySelector('input[name="order_type"]:checked');
        let isDelivery = false;

        if (orderType && orderType.value === 'delivery') {
            isDelivery = true;
        } else if (document.getElementById('ot-delivery') && document.getElementById('ot-delivery').classList.contains('checked')) {
            isDelivery = true;
        }

        let hyst = 0;
        if (finalSubtotal < 20) {
            hyst = 1.00;
        } else if (finalSubtotal < 50) {
            hyst = 2.00;
        } else if (finalSubtotal < 100) {
            hyst = 4.00;
        } else {
            hyst = 8.00;
        }

        let hystInput = document.getElementById("hyst_charge");
        if (hystInput) hystInput.value = hyst.toFixed(2);

        let hystText = document.getElementById("hystChargeText");
        if (hystText) hystText.innerHTML = "£" + hyst.toFixed(2);

        let total = finalSubtotal + delivery + hyst;

        if (document.getElementById("subtotalAfterOfferText")) {
            document.getElementById("subtotalAfterOfferText").innerHTML = "£" + subtotalAfterOffer.toFixed(2);
        }

        document.getElementById("finalTotalText").innerHTML = "£" + total.toFixed(2);
        if (document.getElementById("mobileFinalTotalText")) {
            document.getElementById("mobileFinalTotalText").innerHTML = "£" + total.toFixed(2);
        }

        if (document.querySelector("input[name='amount']")) {
            document.querySelector("input[name='amount']").value = total.toFixed(2);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        var checkedRadio = document.querySelector('input[name="order_type"]:checked');
        if (checkedRadio) {
            checkedRadio.dispatchEvent(new Event('change', { bubbles: true }));
        } else {
            var firstRadio = document.querySelector('input[name="order_type"]');
            if (firstRadio) {
                firstRadio.checked = true;
                firstRadio.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
        updateGrandTotal();
    });

    /* ── BACKGROUND AJAX QUANTITY & PRICE UPDATES ── */
    document.addEventListener('click', function(e) {
        let btn = e.target.closest('[data-action]');
        if (!btn) return;

        e.preventDefault();
        let action = btn.getAttribute('data-action');
        let key = btn.getAttribute('data-key');
        if (!action || !key) return;

        if (typeof window.showGlobalLoader === 'function') {
            let msg = action === 'remove' ? 'Removing Item...' : 'Updating Cart...';
            window.showGlobalLoader(msg, 'Please wait', 2000);
        }

        let url = '/cart/' + action + '/' + encodeURIComponent(key);

        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.5';

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
                let itemRow = document.getElementById('co-item-' + key);
                let summaryRow = document.getElementById('summary-item-' + key);
                if (itemRow) itemRow.remove();
                if (summaryRow) summaryRow.remove();
            } else {
                let qtyEl = document.getElementById('qty-' + key);
                let summaryQtyEl = document.getElementById('summary-qty-' + key);
                let itemSubtotalEl = document.getElementById('item-subtotal-' + key);
                let summarySubtotalEl = document.getElementById('summary-subtotal-' + key);

                if (qtyEl) qtyEl.textContent = res.quantity;
                if (summaryQtyEl) summaryQtyEl.textContent = '×' + res.quantity;
                if (itemSubtotalEl) itemSubtotalEl.textContent = '£' + res.item_subtotal;
                if (summarySubtotalEl) summarySubtotalEl.textContent = '£' + res.item_subtotal;
            }

            let rawSubtotalInput = document.getElementById('raw_cart_subtotal');
            if (rawSubtotalInput) rawSubtotalInput.value = res.original_total;

            let cartSubtotalText = document.getElementById('cartSubtotalText');
            if (cartSubtotalText) cartSubtotalText.textContent = '£' + parseFloat(res.original_total).toFixed(2);

            let currentCouponCode = document.getElementById('couponCodeHidden').value;
            if (currentCouponCode && document.getElementById('applyCoupon')) {
                document.getElementById('applyCoupon').click();
            }

            let currentGiftCardCode = document.getElementById('giftCardCodeHidden').value;
            if (currentGiftCardCode && document.getElementById('applyGiftCard')) {
                document.getElementById('applyGiftCard').click();
            }

            updateGrandTotal();

            document.querySelectorAll('.cart-count, #cartCountBadge').forEach(el => {
                el.textContent = res.cart_count;
            });
        })
        .catch(err => {
            btn.style.pointerEvents = '';
            btn.style.opacity = '';
        });
    });
</script>

@endsection