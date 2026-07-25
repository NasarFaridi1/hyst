@extends('front.layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --red: #E63946;
        --red-dark: #c42d0b;
        --green: #10B981;
        --green-dark: #059669;
        --bg: rgba(245, 240, 232, 0.95);
        --white: #fff;
        --border: #E8E6E0;
        --border-soft: #F0EEE9;
        --text: #111;
        --muted: #9CA3AF;
        --label: #374151;
        --input-bg: #FAFAF8;
        --card-radius: 20px;
        --btn-radius: 14px;
    }

    .co-page {
        background: var(--bg);
        min-height: 100vh;
        /* font-family: 'DM Sans', sans-serif; */
        padding: 32px 16px 80px;
    }

    /* ── HEADER ── */
    .co-header {
        max-width: 1200px;
        margin: 0 auto 28px;
    }
    .co-header h1 {
        /* font-family: 'Syne', sans-serif; */
        font-size: clamp(24px, 5vw, 34px);
        font-weight: 700;
        color: var(--text);
        line-height: 1.1;
    }
    .co-header p {
        color: var(--muted);
        font-size: 14px;
        margin-top: 4px;
    }
    .co-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    .co-breadcrumb a {
        color: var(--red);
        text-decoration: none;
        font-weight: 600;
    }

    /* ── LAYOUT ── */
    .co-wrap {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 24px;
        align-items: start;
    }
    .co-left { display: flex; flex-direction: column; gap: 18px; }

    /* ── CARD ── */
    .co-card {
        background: var(--white);
        border-radius: var(--card-radius);
        padding: 24px;
        border: 1px solid var(--border);
    }
    .co-card-title {
        /* font-family: 'Syne', sans-serif; */
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .step-num {
        width: 26px; height: 26px;
        background: var(--red);
        color: #fff;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .step-meta {
        margin-left: auto;
        font-size: 13px;
        font-weight: 500;
        color: var(--muted);
        /* font-family: 'DM Sans', sans-serif; */
    }

    /* ── ORDER ITEMS ── */
    .co-item {
        display: grid;
        grid-template-columns: 96px 1fr auto;
        gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid var(--border-soft);
        align-items: start;
    }
    .co-item:last-child { border-bottom: none; padding-bottom: 0; }
    .co-item:first-child { padding-top: 0; }

    .co-item-img {
        width: 96px; height: 96px;
        border-radius: 14px;
        object-fit: cover;
        border: 1px solid var(--border-soft);
        display: block;
    }

    .co-item-body { min-width: 0; }
    .co-item-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .co-item-badges {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        margin-bottom: 8px;
    }
    .badge {
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid;
    }
    .badge-offer   { background: #FFF0EC; color: var(--red);     border-color: #FECACA; }
    .badge-disc    { background: #F0FDF4; color: #16A34A;        border-color: #BBF7D0; }
    .badge-save    { background: #FFFBEB; color: #B45309;        border-color: #FDE68A; }

    .price-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    .price-normal { color: var(--red); font-size: 17px; font-weight: 700; }
    .price-old    { color: var(--muted); text-decoration: line-through; font-size: 13px; }

    /* QTY */
    .qty-controls {
        display: flex;
        align-items: center;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        width: fit-content;
    }
    .qty-btn {
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        font-size: 17px;
        font-weight: 700;
        transition: background 0.18s;
        color: var(--text);
        user-select: none;
        -webkit-tap-highlight-color: transparent;
    }
    .qty-btn.minus { background: rgba(245, 240, 232, 0.95); }
    .qty-btn.plus  { background: var(--red); color: #fff; }
    .qty-btn.minus:hover { background: var(--border); }
    .qty-btn.plus:hover  { background: var(--red-dark); }
    .qty-num {
        min-width: 36px;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        border-left: 1px solid var(--border);
        border-right: 1px solid var(--border);
        height: 32px;
        line-height: 32px;
    }

    /* RIGHT SIDE OF ITEM */
    .co-item-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
        gap: 32px;
        min-width: 80px;
    }
    .subtotal-block { text-align: right; }
    .subtotal-label { font-size: 11px; color: var(--muted); font-weight: 500; }
    .subtotal-val   { font-size: 19px; font-weight: 700; color: var(--text); line-height: 1.2; }
    .co-remove-btn {
        color: var(--muted);
        font-size: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.18s;
        white-space: nowrap;
    }
    .co-remove-btn:hover { color: var(--red); }

    /* ── ORDER TYPE ── */
    .ot-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .ot-label {
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 16px;
        cursor: pointer;
        transition: border-color 0.18s, background 0.18s;
        display: flex;
        align-items: center;
        gap: 12px;
        -webkit-tap-highlight-color: transparent;
    }
    .ot-label:hover  { border-color: var(--red); background: #FFF5F5; }
    .ot-label.checked { border-color: var(--red); background: #FFF5F5; }
    .ot-label input[type=radio] { display: none; }

    .ot-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        background: var(--bg);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        transition: background 0.18s;
    }
    .ot-label.checked .ot-icon { background: #FECACA; }
    .ot-title { font-size: 14px; font-weight: 700; color: var(--text); }
    .ot-sub   { font-size: 11px; color: var(--muted); margin-top: 1px; }

    .radio-dot {
        width: 18px; height: 18px;
        border-radius: 50%;
        border: 2px solid #D1D5DB;
        margin-left: auto;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.18s;
    }
    .ot-label.checked .radio-dot { border-color: var(--red); background: var(--red); }
    .radio-dot::after {
        content: '';
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #fff;
        display: none;
    }
    .ot-label.checked .radio-dot::after { display: block; }

    /* DELIVERY FIELDS */
    .co-hidden { display: none !important; }
    .delivery-fields {
        margin-top: 22px;
        padding-top: 22px;
        border-top: 1px solid var(--border-soft);
    }
    .section-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--label);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 14px;
    }

    .co-input-group { margin-bottom: 14px; }
    .co-input-group:last-child { margin-bottom: 0; }
    .co-input-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--label);
        margin-bottom: 7px;
    }
    .co-input, .co-textarea {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 13px 16px;
        font-size: 14px;
        /* font-family: 'DM Sans', sans-serif; */
        color: var(--text);
        background: var(--input-bg);
        outline: none;
        transition: border-color 0.18s, background 0.18s;
        -webkit-appearance: none;
    }
    .co-input:focus, .co-textarea:focus {
        border-color: var(--red);
        background: var(--white);
    }
    .co-textarea { resize: none; height: 88px; }

    /* ── PAYMENT ── */
    .pm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .pm-label {
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.18s;
        display: flex;
        align-items: center;
        gap: 12px;
        -webkit-tap-highlight-color: transparent;
    }
    .pm-label input[type=radio] { display: none; }
    .pm-label:hover   { border-color: var(--green); background: #F0FDF4; }
    .pm-label.checked { border-color: var(--green); background: #F0FDF4; }
    .pm-label.checked .pm-radio-dot { border-color: var(--green); background: var(--green); }
    .pm-label.checked .pm-radio-dot::after { display: block; }
    .pm-label.checked .pm-icon { background: #D1FAE5; }

    .pm-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        background: var(--bg);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        transition: background 0.18s;
    }
    .pm-title { font-size: 14px; font-weight: 700; color: var(--text); }
    .pm-sub   { font-size: 11px; color: var(--muted); margin-top: 1px; }

    .pm-radio-dot {
        width: 18px; height: 18px;
        border-radius: 50%;
        border: 2px solid #D1D5DB;
        margin-left: auto;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.18s;
    }
    .pm-radio-dot::after {
        content: '';
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #fff;
        display: none;
    }

    /* ── RIGHT: SUMMARY ── */
    .co-right { position: sticky; top: 20px; }

    .co-summary {
        background: var(--white);
        border-radius: var(--card-radius);
        padding: 24px;
        border: 1px solid var(--border);
    }

    .summary-title {
        /* font-family: 'Syne', sans-serif; */
        font-size: 19px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-soft);
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 13px;
        gap: 8px;
    }
    .summary-item .si-name {
        color: var(--label);
        flex: 1;
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .summary-item .si-qty { color: var(--muted); font-weight: 400; }
    .summary-item .si-price { font-weight: 700; color: var(--text); flex-shrink: 0; }

    .summary-divider {
        border: none;
        border-top: 1px dashed var(--border);
        margin: 14px 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .summary-row .sr-label { color: #6B7280; font-weight: 500; }
    .summary-row .sr-value { font-weight: 700; color: var(--text); }
    .summary-row .sr-value.green { color: #16A34A; }
    .summary-row .sr-value.free  { color: var(--green); }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        background: var(--bg);
        border-radius: 12px;
        margin: 16px 0 18px;
    }
    .summary-total-label { font-size: 15px; font-weight: 700; color: var(--text); }
    .summary-total-value {
        /* font-family: 'Syne', sans-serif; */
        font-size: 26px;
        font-weight:7800;
        color: var(--red);
    }

    .saving-banner {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #15803D;
    }

    .co-place-btn {
        width: 100%;
        background: var(--red);
        color: #fff;
        border: none;
        border-radius: var(--btn-radius);
        padding: 17px;
        /* font-family: 'Syne', sans-serif; */
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.18s, transform 0.12s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }
    .co-place-btn:hover  { background: var(--red-dark); transform: translateY(-1px); }
    .co-place-btn:active { transform: translateY(0); }

    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin-top: 12px;
        font-size: 12px;
        color: var(--muted);
        font-weight: 500;
    }

    /* ── ERRORS ── */
    .co-errors {
        background: #FEF2F2;
        border: 1.5px solid #FECACA;
        color: #DC2626;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 16px;
        font-size: 14px;
    }
    .co-errors ul { margin-left: 18px; }
    .co-errors li { margin-bottom: 4px; }

    /* ── EMPTY ── */
    .co-empty {
        text-align: center;
        padding: 48px 16px;
    }
    .co-empty-icon { font-size: 48px; margin-bottom: 14px; }
    .co-empty h3 {
        /* font-family: 'Syne', sans-serif; */
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 6px;
    }
    .co-empty p { color: var(--muted); font-size: 14px; }

    /* ── MOBILE STICKY FOOTER ── */
    .mobile-footer {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: var(--white);
        border-top: 1px solid var(--border);
        padding: 12px 16px calc(12px + env(safe-area-inset-bottom));
        z-index: 100;
        box-shadow: 0 -4px 20px rgba(0,0,0,.08);
    }
    .mobile-footer-inner {
        max-width: 500px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .mobile-footer-total { flex: 1; }
    .mobile-footer-label { font-size: 11px; color: var(--muted); font-weight: 500; }
    .mobile-footer-amount {
        /* font-family: 'Syne', sans-serif; */
        font-size: 22px;
        font-weight: 700;
        color: var(--red);
        line-height: 1.1;
    }
    .mobile-footer-btn {
        background: var(--red);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px 22px;
        /* font-family: 'Syne', sans-serif; */
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex; align-items: center; gap: 8px;
        transition: background 0.18s;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
        white-space: nowrap;
    }
    .mobile-footer-btn:hover { background: var(--red-dark); }

    /* ── RESPONSIVE BREAKPOINTS ── */

    /* Tablet / medium */
    @media (max-width: 900px) {
        .co-wrap    { grid-template-columns: 1fr; }
        .co-right   { position: static; }
                  /* Summary shown in sticky footer on mobile */
        .mobile-footer { display: block; }
        .co-page    { padding-bottom: 120px; }   /* Make room for sticky footer */
        
    }

    /* Small tablet */
    @media (max-width: 640px) {
        .co-page  { padding: 16px 12px 120px; }
        .co-card  { padding: 18px 16px; }
        .co-header { margin-bottom: 20px; }
    }

    /* Phone */
    @media (max-width: 480px) {
        .ot-grid,
        .pm-grid { grid-template-columns: 1fr; }

        .co-item {
            grid-template-columns: 80px 1fr;
            grid-template-rows: auto auto;
        }
        .co-item-img  { width: 80px; height: 80px; }
        .co-item-right {
            grid-column: 1 / -1;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding-top: 4px;
        }
        .subtotal-block { text-align: left; }
        .subtotal-val   { font-size: 17px; }

        .co-item-name  { font-size: 14px; }
        .price-normal  { font-size: 15px; }

        .ot-label, .pm-label { padding: 14px; }
        .ot-icon, .pm-icon   { width: 38px; height: 38px; font-size: 18px; }
        .ot-title, .pm-title { font-size: 13px; }
        .ot-sub, .pm-sub     { font-size: 11px; }
    }

    /* Very small (320px) */
    @media (max-width: 360px) {
        .co-item { grid-template-columns: 72px 1fr; }
        .co-item-img { width: 72px; height: 72px; }
        .co-card-title { font-size: 15px; }
        .mobile-footer-btn { padding: 13px 16px; font-size: 14px; }
    }
</style>

<div class="co-page">

    <!-- HEADER -->
    <div class="co-header">
        
        <h1>Checkout</h1>
    </div>

    <form method="POST" action="/place-order" id="checkoutForm">
        @csrf

        <div class="co-wrap">

            <!-- ══════════ LEFT ══════════ -->
            <div class="co-left">

                <!-- ERRORS -->
                @if ($errors->any())
                <div class="co-errors">
                    <strong style="font-weight:700;">Please fix the following:</strong>
                    <ul style="margin-top:8px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <input
                type="hidden"
                name="restaurant_id"
                value="{{ $restaurant->id }}">

                <!-- ── STEP 1: ORDER ITEMS ── -->
                <div class="co-card">
                    <div class="co-card-title">
                        <span class="step-num">1</span>
                        Order Items
                        <span class="step-meta">
                            {{ count($cart) }} {{ Str::plural('item', count($cart)) }}
                        </span>
                    </div>

                    @forelse($cart as $cartKey => $item)
                    @php
                        $offer    = $item['offer'];
                        // $subtotal = $item['subtotal'] ?? ($item['price'] * $item['quantity']);
                        $itemPrice = $item['base_price'] + ($item['addon_total'] ?? 0);

                        $subtotal = $item['subtotal'] ?? ($itemPrice * $item['quantity']);
                    @endphp

                    <div class="co-item">
                        <!-- IMAGE -->
                        <img 
                        {{-- src="{{ asset('storage/'.$item['image']) }}" --}}
                            src="{{ $item['image'] ? config('services.google_drive.image_url') . $item['image'] : asset('default.png') }}"

                             class="co-item-img"
                             alt="{{ $item['name'] }}"
                             loading="lazy">

                        <!-- BODY -->
                        <div class="co-item-body">
                            <div class="co-item-name" title="{{ $item['name'] }}">
                                {{ $item['name'] }}
                                @if(!empty($item['variant_name']))
                                    <div style="font-size:12px;color:#6B7280;">
                                        Variant: {{ $item['variant_name'] }}
                                    </div>
                                @endif
                            </div>

                            @if(!empty($item['addons']))

                                @php
                                    $groupedAddons = collect($item['addons'])->groupBy('category_name');
                                @endphp

                                <div style="margin-top:10px;">

                                    @foreach($groupedAddons as $category => $addons)

                                        <div style="
                                            font-size:12px;
                                            font-weight:700;
                                            color:#555;
                                            margin-bottom:6px;
                                        ">
                                            {{ $category }}
                                        </div>

                                        <div style="
                                            display:flex;
                                            flex-wrap:wrap;
                                            gap:8px;
                                            margin-bottom:10px;
                                        ">

                                            @foreach($addons as $addon)

                                                <div style="
                                                    display:flex;
                                                    align-items:center;
                                                    gap:6px;
                                                    background:#FAFAFA;
                                                    border:1px solid #E5E7EB;
                                                    border-radius:999px;
                                                    padding:6px 10px;
                                                    font-size:12px;
                                                ">

                                                    <span style="
                                                        width:7px;
                                                        height:7px;
                                                        border-radius:50%;
                                                        background:#C25A2A;
                                                    "></span>

                                                    <span>{{ $addon['addon_name'] }}</span>

                                                    <span style="
                                                        color:#C25A2A;
                                                        font-weight:700;
                                                    ">
                                                        +£{{ number_format($addon['price'],2) }}
                                                    </span>

                                                </div>

                                            @endforeach

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                            @if($offer)
                            <div class="co-item-badges">
                                @if($offer->type === 'discount')
                                    <span class="badge badge-disc">🏷️ DISCOUNT</span>
                                @else
                                    <span class="badge badge-offer">🎁 OFFER</span>
                                @endif
                                <span class="badge badge-save">
                                    @if($offer->value_type === 'percent')
                                        {{ $offer->value }}% OFF
                                    @else
                                        £{{ $offer->value }} OFF
                                    @endif
                                </span>
                            </div>
                            @endif

                            <div class="price-row">
                                @if($offer)
                                    {{-- Final price hidden per original; uncomment if needed --}}
                                    {{-- <span class="price-normal">£{{ number_format($item['final_price'], 2) }}</span> --}}
                                @else
                                    {{-- <span class="price-normal">£{{ number_format($item['price'], 2) }}</span> --}}
                                    <div class="price-row">
                                        <span class="price-normal">
                                            £{{ number_format($itemPrice, 2) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- QTY CONTROLS -->
                            <div class="qty-controls">
                                <a href="{{ url('/cart/decrease/'.$cartKey) }}" class="qty-btn minus" aria-label="Decrease quantity">−</a>
                                <span class="qty-num" aria-label="Quantity">{{ $item['quantity'] }}</span>
                                <a href="{{ url('/cart/increase/'.$cartKey) }}" class="qty-btn plus" aria-label="Increase quantity">+</a>
                            </div>
                        </div>

                        <!-- RIGHT: SUBTOTAL + REMOVE -->
                        <div class="co-item-right">
                            <div class="subtotal-block">
                                <div class="subtotal-label">Subtotal</div>
                                <div class="subtotal-val">£{{ number_format($subtotal, 2) }}</div>
                            </div>
                            <a href="{{ url('/cart/remove/'.$cartKey) }}" class="co-remove-btn">Remove ✕</a>
                        </div>
                    </div>

                    @empty
                    <div class="co-empty">
                        <div class="co-empty-icon">🛒</div>
                        <h3>Cart is Empty</h3>
                        <p>Add some items to proceed with checkout.</p>
                    </div>
                    @endforelse
                </div>

                <!-- ── STEP 2: ORDER TYPE ── -->
                <div class="co-card">
                    <div class="co-card-title">
                        <span class="step-num">2</span>
                        How would you like your order?
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
                            <div class="radio-dot"></div>
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
                                <div class="radio-dot"></div>
                            </label>
                        @endif

                        @if($restaurant->home_delivery)
                        <label class="ot-label" id="ot-delivery">
                            <input type="radio" name="order_type" value="delivery">
                            <div class="ot-icon">🚚</div>
                            <div>
                                <div class="ot-title">Home Delivery</div>
                                <div class="ot-sub">Delivered to door</div>
                            </div>
                            <div class="radio-dot"></div>
                        </label>
                        @endif
                    </div>

                    <!-- DELIVERY FIELDS -->
                    
                        @auth
                        @include('front.address.index')
                        @endauth


                   
                </div>

                <!-- ── STEP 3: PAYMENT ── -->
                <div class="co-card">
                    {{-- <div class="co-card-title">
                        <span class="step-num">3</span>
                        Payment Method
                    </div> --}}

                    <div class="pm-grid">
                        @if($paymentEnabled)
                            <label class="pm-label" id="pm-online">
                                <input type="radio" name="payment_method"  value="online" required>
                                <input
                                    type="hidden"
                                    name="restaurant_id"
                                    value="{{ $restaurant->id }}">


                                <input type="hidden" name="amount" value="{{ $finalTotal }}">

                                <input type="hidden" name="service_charge" value="{{ $serviceCharge }}">

                                {{-- <input type="hidden" name="delivery_charge" value="{{ $deliveryCharge }}"> --}}

                                <input type="hidden" name="hyst_charge" value="{{ $hystCharge }}">

                                <div class="pm-icon">💳</div>
                                <div>
                                    <div class="pm-title">Online Payment</div>
                                    <div class="pm-sub">UPI / Card / Wallet</div>
                                </div>
                                <div class="pm-radio-dot"></div>
                            </label>
                        @else

                            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-xl">
                                Online payment is currently unavailable for this restaurant.
                            </div>

                        @endif

                        {{-- <label class="pm-label" id="pm-cod">
                            <input type="radio" name="payment_method" value="Cash On Delivery" required>
                            <div class="pm-icon">💵</div>
                            <div>
                                <div class="pm-title">Cash on Delivery</div>
                                <div class="pm-sub">Pay after delivery</div>
                            </div>
                            <div class="pm-radio-dot"></div>
                        </label> --}}
                    </div>

                    <!-- PHONE (COD only) -->
                    <div id="phoneField" class="co-hidden" style="margin-top:18px; padding-top:18px; border-top:1px solid var(--border-soft);">
                        <div class="co-input-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="co-input"
                                placeholder="e.g. +44 7700 900000"
                                inputmode="tel"
                                autocomplete="tel">
                        </div>
                    </div>
                </div>

            </div>
            <!-- ══════════ END LEFT ══════════ -->

            <!-- ══════════ RIGHT: SUMMARY (desktop only) ══════════ -->
            <div class="co-right">
                @if(isset($orderOffer) && $orderOffer)

                <div style="
                    background:#FFF0EC;
                    border:1px solid #FAD7C8;
                    border-radius:14px;
                    padding:14px;
                    margin-bottom:16px;
                ">

                    

                    <div style="
                        font-size:15px;
                        font-weight:700;
                        color:#111;
                    ">
                        {{ $orderOffer->title }}
                    </div>

                    <div style="
                        margin-top:6px;
                        color:#6B7280;
                        font-size:13px;
                    ">
                        {{ $orderOffer->description }}
                    </div>

                </div>

                @endif
                <div class="co-summary">

                    <div class="co-card mb-4">

                        <div class="co-card-title">
                            <span class="step-num">🎁</span>
                            Apply Coupon
                        </div>

                        <div style="display:flex;gap:10px;">
                            <input
                                type="text"
                                id="coupon_code"
                                class="co-input"
                                placeholder="Enter coupon code">

                            <button
                                type="button"
                                id="applyCoupon"
                                class="co-place-btn"
                                style="width:160px;padding:12px;">
                                Apply
                            </button>
                        </div>

                        <div id="couponMessage" style="margin-top:12px;"></div>

                    </div>
                    <div class="co-card mb-4">

                        <div class="co-card-title">
                            <span class="step-num">🎁</span>
                            Apply Gift Card
                        </div>

                        <div style="display:flex;gap:10px;">

                            <input
                                type="text"
                                id="gift_card_code"
                                class="co-input"
                                placeholder="Enter Gift Card Code">

                            <button
                                type="button"
                                id="applyGiftCard"
                                class="co-place-btn"
                                style="width:160px;padding:12px;">

                                Apply

                            </button>

                        </div>

                        <div id="giftCardMessage" style="margin-top:12px;"></div>

                    </div>
                    <div class="summary-title">Order Summary</div>

                    @foreach($cart as $item)

                    @php
                        $itemPrice = $item['base_price'] + ($item['addon_total'] ?? 0);

                        $subtotal = $item['subtotal']
                            ?? ($itemPrice * $item['quantity']);
                    @endphp

                    <div class="summary-item">

                        <div>

                            <div class="si-name">
                                {{ $item['name'] }}
                                <span class="si-qty">× {{ $item['quantity'] }}</span>
                            </div>

                            @if(!empty($item['variant_name']))
                                <div style="font-size:12px;color:#777;">
                                    {{ $item['variant_name'] }}
                                </div>
                            @endif

                            @if(!empty($item['addons']))
                                @foreach($item['addons'] as $addon)

                                    <div style="
                                        font-size:12px;
                                        color:#777;
                                        margin-top:2px;
                                        padding-left:10px;
                                    ">
                                        • {{ $addon['addon_name'] }}
                                        (+£{{ number_format($addon['price'],2) }})
                                    </div>

                                @endforeach
                            @endif

                        </div>

                        <span class="si-price">
                            £{{ number_format($subtotal,2) }}
                        </span>

                    </div>

                    @endforeach

                    <hr class="summary-divider">

                    <div class="summary-row">
                        <span class="sr-label">Cart Subtotal</span>
                        <span class="sr-value">£{{ number_format($originalTotal, 2) }}</span>
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

                        <div class="summary-row" id="subtotalAfterOfferRow">
                            <span class="sr-label" style="font-weight:600; color:#374151;">Subtotal After Offer</span>
                            <span class="sr-value" id="subtotalAfterOfferText" style="font-weight:600; color:#374151;">
                                £{{ number_format(max($originalTotal - $discount, 0), 2) }}
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
                        <span class="sr-value" id="deliveryChargeText">
                            £0.00
                        </span>
                    </div>

                    <div class="summary-row">
                        <span class="sr-label">Operation Charge</span>
                        <span class="sr-value" id="hystChargeText">
                            £0.00
                        </span>
                    </div>

                    <input type="hidden" id="raw_cart_subtotal" value="{{ $originalTotal }}">
                    <input type="hidden" id="offer_discount" value="{{ $discount }}">
                    <input type="hidden" id="delivery_charge" name="delivery_charge" value="0">
                    <input type="hidden" id="hyst_charge" name="hyst_charge" value="0">
                    <input type="hidden" id="uber_quote_id" name="uber_quote_id" value="">
                    <input type="hidden" id="cartSubtotal" value="{{ max($originalTotal - $discount, 0) }}">
                    <input type="hidden" id="couponIdHidden" name="coupon_id">
                    <input type="hidden" id="couponCodeHidden" name="coupon_code">
                    <input type="hidden" id="couponDiscountHidden" name="coupon_discount" value="0">
                    <input type="hidden" id="giftCardIdHidden" name="gift_card_id">
                    <input type="hidden" id="giftCardCodeHidden" name="gift_card_code">
                    <input type="hidden" id="giftCardAmountHidden" name="gift_card_amount" value="0">

                    <hr class="summary-divider">
                    

                    <div class="summary-total">
                        <span class="summary-total-label">Total to Pay</span>
                        {{-- <span class="summary-total-value">£{{ number_format($finalTotal, 2) }}</span> --}}
                        <div
                            class="summary-total-value"
                            id="finalTotalText"
                        >
                            £{{ number_format($finalTotal,2) }}
                        </div>
                    </div>

                    @if(isset($orderOffer) && $orderOffer)
                    <div class="saving-banner">
                        🎉 You're saving £{{ number_format($orderOfferDiscount ?? 0, 2) }} on this order!
                    </div>
                    @endif
                    

                    <button type="submit" class="co-place-btn" form="checkoutForm">
                        Place Order
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>

                    <div class="secure-note">🔒 Secure &amp; encrypted checkout</div>
                </div>
            </div>

        </div>
    </form>

</div>

<!-- ══════════ MOBILE STICKY FOOTER ══════════ -->
<div class="mobile-footer" id="mobileFooter">
    <div class="mobile-footer-inner">
        <div class="mobile-footer-total">
            <div class="mobile-footer-label">Total to Pay</div>
            <div
                class="mobile-footer-amount"
                id="mobileFinalTotalText"
            >£{{ number_format($finalTotal, 2) }}</div>
        </div>
        <button type="submit" form="checkoutForm" class="mobile-footer-btn">
            Place Order
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </button>
    </div>
</div>

<script>
    (function () {
        /* ── ORDER TYPE ── */
        document.querySelectorAll('input[name="order_type"]').forEach(function(radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.ot-label').forEach(function(l) { l.classList.remove('checked'); });
                this.closest('.ot-label').classList.add('checked');

                var df   = document.getElementById('deliveryFields');
                var addr = document.getElementById('address');
                var pin  = document.getElementById('pincode');
                var deliveryRow = document.getElementById('deliveryChargeRow');

                if (this.value === 'delivery') {
                    df.classList.remove('co-hidden');
                    deliveryRow.style.display = "flex";
                    addr.required = true;
                    pin.required  = true;
                } else {
                    df.classList.add('co-hidden');
                    deliveryRow.style.display = "none";
                    addr.required = false;
                    pin.required  = false;
                }
            });
        });

        /* ── PAYMENT METHOD ── */
        document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.pm-label').forEach(function(l) { l.classList.remove('checked'); });
                this.closest('.pm-label').classList.add('checked');

                var pf    = document.getElementById('phoneField');
                var phone = document.getElementById('phone');

                if (this.value === 'Cash On Delivery') {
                    pf.classList.remove('co-hidden');
                    phone.required = true;
                } else {
                    pf.classList.add('co-hidden');
                    phone.required = false;
                }
            });
        });

        /* ── FORM SUBMIT: route based on payment ── */
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {

            const orderType = document.querySelector('input[name="order_type"]:checked');
            const uberQuoteId = document.getElementById('uber_quote_id').value;

            if (!orderType) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Order Type Required',
                    text: 'Please select an order type.',
                    confirmButtonColor: '#E63946',
                    confirmButtonText: 'OK'
                });

                return;
            }

            if (orderType.value === 'delivery' && !uberQuoteId && !document.getElementById('address').value) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Delivery Address Required',
                    text: 'Please select or add a valid delivery address.',
                    confirmButtonColor: '#E63946',
                    confirmButtonText: 'OK'
                });

                return;
            }

            var pm = document.querySelector('input[name="payment_method"]:checked');
            if (pm && pm.value === 'online') {
                e.preventDefault();
                this.action = "{{ route('payment.pay') }}";
                this.submit();
            } else {
                this.action = '/place-order';
            }
        });

        // Select Online Payment by default
        const defaultPayment = document.querySelector(
            'input[name="payment_method"][value="online"]'
        );

        if (defaultPayment) {
            defaultPayment.checked = true;
            defaultPayment.dispatchEvent(new Event('change'));
        }

        /* ── HIDE MOBILE FOOTER when no cart items ── */
        @if(count($cart) === 0)
        var mf = document.getElementById('mobileFooter');
        if (mf) mf.style.display = 'none';
        @endif
    })();
</script>

<script>

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
                document.getElementById('couponMessage').innerHTML =
                    "<span style='color:red'>" + res.message + "</span>";
                document.getElementById("couponRow").style.display = "none";
                document.getElementById("couponDiscountHidden").value = 0;
                updateGrandTotal();
                return;
            }

            couponDiscount = parseFloat(res.discount);
            document.getElementById('couponMessage').innerHTML =
                "<span style='color:green'>Coupon Applied Successfully</span>";
            document.getElementById("couponRow").style.display = "flex";
            document.getElementById("couponDiscountText").innerHTML =
                "-£" + couponDiscount.toFixed(2);
            document.getElementById("couponCodeHidden").value = res.coupon;
            document.getElementById("couponIdHidden").value = res.coupon_id;
            document.getElementById("couponDiscountHidden").value = couponDiscount;
            updateGrandTotal();
        });
    };

    let giftCardDiscount = 0;

    document.getElementById("applyGiftCard").onclick = function () {
        fetch("{{ route('gift-card.apply') }}", {
            method: "POST",
            headers: {
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":"{{ csrf_token() }}"
            },
            body: JSON.stringify({
                code: document.getElementById("gift_card_code").value,
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
                document.getElementById("giftCardMessage").innerHTML =
                    "<span style='color:red'>"+res.message+"</span>";
                updateGrandTotal();
                return;
            }

            giftCardDiscount = parseFloat(res.discount);
            document.getElementById("giftCardMessage").innerHTML =
                "<span style='color:green'>Gift Card Applied Successfully</span>";
            document.getElementById("giftCardRow").style.display="flex";
            document.getElementById("giftCardDiscountText").innerHTML =
                "-£"+giftCardDiscount.toFixed(2);
            document.getElementById("giftCardIdHidden").value = res.gift_card_id;
            document.getElementById("giftCardCodeHidden").value = res.gift_card;
            document.getElementById("giftCardAmountHidden").value = giftCardDiscount;
            updateGrandTotal();
        });
    };

    function updateGrandTotal() {
        let rawSubtotal = parseFloat(document.getElementById("raw_cart_subtotal").value || 0);
        let offerDiscount = parseFloat(document.getElementById("offer_discount").value || 0);
        let delivery = parseFloat(document.getElementById("delivery_charge").value || 0);
        let hyst = parseFloat(document.getElementById("hyst_charge").value || 0);

        let subtotalAfterOffer = Math.max(rawSubtotal - offerDiscount, 0);
        let subtotalAfterCoupon = Math.max(subtotalAfterOffer - couponDiscount, 0);
        let finalSubtotal = Math.max(subtotalAfterCoupon - giftCardDiscount, 0);

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

</script>



@endsection