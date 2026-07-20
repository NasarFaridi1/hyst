@extends('front.layouts.app')

@section('content')

    <style>
        * {
            box-sizing: border-box;
        }

        /* ---- OFFER SLIDER ---- */
        .res-offer-slider-wrap {
            overflow: hidden;
        }

        .res-offer-track {
            display: flex;
            gap: 16px;
            transition: transform 0.4s cubic-bezier(.4, 0, .2, 1);
            will-change: transform;
        }

        .res-offer-slide {
            min-width: calc(33.333% - 11px);
            flex-shrink: 0;
        }

        .res-offer-card {
            border-radius: 16px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            height: 110px;
            position: relative;
            overflow: hidden;
        }

        .res-offer-card.type-offer {
            background: #FFF7ED;
            border: 1.5px solid #FED7AA;
        }

        .res-offer-card.type-discount {
            background: #F0FDF4;
            border: 1.5px solid #BBF7D0;
        }

        .res-offer-icon {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .type-offer .res-offer-icon {
            background: #FFEDD5;
        }

        .type-discount .res-offer-icon {
            background: #DCFCE7;
        }

        .res-slide-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #E5E7EB;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .res-slide-btn:hover {
            background: #C25A2A;
            border-color: #C25A2A;
            color: #fff;
        }

        .res-dots {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 12px;
        }

        .res-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #D1D5DB;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .res-dot.active {
            background: #C25A2A;
            width: 20px;
            border-radius: 4px;
        }

        /* ---- PRODUCT GRID ---- */
        .res-products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .badge-primary {
            background: #C25A2A;
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .btn-black {
            display: block;
            background: #111827;
            color: #fff;
            padding: 10px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: background 0.2s;
            cursor: pointer;
            text-align: center;
        }

        .btn-black:hover {
            background: #374151;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #C25A2A;
            color: #fff;
            padding: 10px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .btn-primary:hover {
            background: #c42d0b;
        }

        @media(max-width:900px) {
            .res-products-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .res-offer-slide {
                min-width: calc(50% - 8px);
            }
        }

        @media(max-width:560px) {
            .res-products-grid {
                grid-template-columns: 1fr !important;
            }

            .res-offer-slide {
                min-width: 100%;
            }
        }


        .info-tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .details-link {
            font-size: 12px;
            color: #C25A2A;
            font-weight: 600;
            border-bottom: 1px dotted #C25A2A;
            line-height: 1;
            white-space: nowrap;
        }

        .details-link:hover {
            color: #a6481f;
            border-bottom-color: #a6481f;
        }

        .tooltip-content {
            position: absolute;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%);
            width: 260px;
            max-width: calc(100vw - 20px);

            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 12px;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);

            z-index: 99999;
            display: none;
            text-align: left;
        }

        .info-tooltip:hover .tooltip-content {
            display: block;
        }

        .tooltip-content h6 {
            margin: 0 0 4px;
            font-size: 12px;
            font-weight: 700;
            color: #111827;
        }

        .tooltip-content p {
            margin: 0 0 8px;
            font-size: 12px;
            color: #6B7280;
            line-height: 1.4;
        }

        .tooltip-content p:last-child {
            margin-bottom: 0;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .tooltip-content {
                width: 220px;
                left: 0;
                bottom: 32px;
                transform: none;
            }

            .details-link {
                font-size: 11px;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .tooltip-content {
                width: 200px;
                left: -20px;
                bottom: 32px;
            }
        }
    </style>


@php
    $isAdmin = auth()->check() &&
        in_array(auth()->user()->role, ['super_admin', 'restaurant_admin']);
    
@endphp

        {{-- bottom bar --}}
        <div>
            @include('front.layouts.bottombars')
        </div>
        
    {{-- ======== RESTAURANT HEADER ======== --}}
    <section
        style="background:linear-gradient(135deg,#0D0D0D 0%,#1a1a1a 100%); padding:44px 0; border-bottom:3px solid #C25A2A;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
                <div
                    style="width:68px; height:68px; background:#C25A2A; border-radius:18px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="32" height="32" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7" />
                    </svg>
                </div>
                <div>
                    <p
                        style="color:#C25A2A; font-weight:700; font-size:11px; letter-spacing:.12em; text-transform:uppercase; margin:0 0 4px;">
                        Restaurant</p>
                    <h1
                        style="font-size:30px; font-weight:800; color:#fff; margin:0; letter-spacing:-.4px; font-family:'Poppins',sans-serif;">
                        {{ $restaurant->name }}
                    </h1>
                    <p style="color:#9CA3AF; font-size:13px; margin:6px 0 0;">
                        📍 {{ $restaurant->location }}

                        &nbsp;·&nbsp;

                        ⭐ {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }} Rated

                        ({{ $restaurant->reviews->count() }} Reviews)
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== OFFER & DISCOUNT SLIDER SECTION ======== --}}
    @if(isset($offers) && $offers->count())
        <section style="background:#fff; padding:30px 0; border-bottom:1px solid #F0F0EC;">
            <div style="max-width:1280px; margin:0 auto; padding:0 24px;">

                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                    <div>
                        <p
                            style="color:#C25A2A; font-size:11px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; margin:0 0 3px;">
                            Deals for You</p>
                        <h2 style="font-size:20px; font-weight:800; color:#0D0D0D; margin:0; font-family:'Poppins',sans-serif;">
                            Offers &amp; Discounts
                        </h2>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <button class="res-slide-btn" onclick="resSliderPrev()">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button class="res-slide-btn" onclick="resSliderNext()">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="res-offer-slider-wrap">
                    <div class="res-offer-track" id="resOfferTrack">

                        @foreach($offers as $offer)
                            <div class="res-offer-slide">
                                <div class="res-offer-card {{ $offer->type === 'discount' ? 'type-discount' : 'type-offer' }}">

                                    @if($offer->image)
                                        <img src="{{ asset('storage/' . $offer->image) }}"
                                            style="width:54px; height:54px; border-radius:12px; object-fit:cover; flex-shrink:0;">
                                    @else
                                        <div class="res-offer-icon">
                                            @if($offer->type === 'discount')
                                                <svg width="26" height="26" fill="none" stroke="#16A34A" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <circle cx="9" cy="9" r="2" />
                                                    <circle cx="15" cy="15" r="2" />
                                                    <path d="M5 20L20 5" />
                                                </svg>
                                            @else
                                                <svg width="26" height="26" fill="none" stroke="#EA580C" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path d="M20 12V22H4V12" />
                                                    <path d="M22 7H2v5h20V7z" />
                                                    <path d="M12 22V7" />
                                                    <path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z" />
                                                    <path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z" />
                                                </svg>
                                            @endif
                                        </div>
                                    @endif

                                    <div style="flex:1; min-width:0;">
                                        <div style="display:flex; align-items:center; gap:6px; margin-bottom:5px;">
                                            <span
                                                style="font-size:10px; font-weight:700; padding:3px 8px; border-radius:10px;
                                                                                                {{ $offer->type === 'discount' ? 'background:#DCFCE7; color:#15803D;' : 'background:#FFEDD5; color:#C2410C;' }}">
                                                {{ strtoupper($offer->type) }}
                                            </span>
                                        </div>
                                        <h3
                                            style="font-size:15px; font-weight:700; margin:0 0 3px; color:#111827; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ $offer->title }}
                                        </h3>
                                        @if($offer->description)
                                            <p
                                                style="font-size:12px; color:#6B7280; margin:0 0 7px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                                {{ $offer->description }}
                                            </p>
                                        @endif
                                        <span
                                            style="font-size:14px; font-weight:800;
                                                                                            {{ $offer->type === 'discount' ? 'color:#16A34A;' : 'color:#E63946;' }}">
                                            @if($offer->value_type === 'percent')
                                                {{ $offer->value }}% OFF
                                            @else
                                                £{{ $offer->value }} OFF
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="res-dots" id="resDots"></div>
            </div>
        </section>
    @endif

    

    {{-- ======== MENU SECTION ======== --}}
    <section style="background:rgba(245, 240, 232, 0.95); padding:40px 0 80px;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">

            {{-- Category Filter Tabs --}}
            <div
                style="display:flex; gap:10px; overflow-x:auto; margin-bottom:36px; padding-bottom:4px; scrollbar-width:none;">
                @php $activeCat = request()->segment(3); @endphp

                <a href="{{ url('/restaurant/' . $restaurant->slug) }}"
                    style="padding:10px 22px; border-radius:40px; text-decoration:none; white-space:nowrap; font-weight:600; font-size:13px; font-family:'Poppins',sans-serif; transition:all .2s; flex-shrink:0;
                                        {{ !$activeCat ? 'background:#C25A2A; color:#fff; box-shadow:0 4px 14px rgba(232,55,14,.35);' : 'background:#fff; color:#374151; border:1.5px solid #E5E7EB;' }}">
                    All
                </a>

                @foreach($categories as $cat)
                    <a href="{{ url('/restaurant/' . $restaurant->slug . '/' . $cat->slug) }}"
                        style="padding:10px 22px; border-radius:40px; text-decoration:none; white-space:nowrap; font-weight:600; font-size:13px; font-family:'Poppins',sans-serif; transition:all .2s; flex-shrink:0;
                                                            {{ $activeCat === $cat->slug ? 'background:#C25A2A; color:#fff; box-shadow:0 4px 14px rgba(232,55,14,.35);' : 'background:#fff; color:#374151; border:1.5px solid #E5E7EB;' }}"
                        @if($activeCat !== $cat->slug)
                            onmouseover="this.style.background='#FFF0EC'; this.style.borderColor='#C25A2A'; this.style.color='#C25A2A';"
                            onmouseout="this.style.background='#fff'; this.style.borderColor='#E5E7EB'; this.style.color='#374151';"
                        @endif>
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Section Label --}}
            <div
                style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:10px;">
                <div>
                    <p
                        style="color:#C25A2A; font-weight:700; font-size:11px; letter-spacing:.1em; text-transform:uppercase; margin:0 0 5px;">
                        Today's Pick</p>
                    <h2 style="font-size:26px; font-weight:800; margin:0; color:#0D0D0D; font-family:'Poppins',sans-serif;">
                        {{ $activeCat ? ($categories->firstWhere('slug', $activeCat)->name ?? 'Menu') : 'All Items' }}
                    </h2>
                </div>
                <span
                    style="background:#F0F0EC; padding:6px 16px; border-radius:999px; font-size:13px; font-weight:600; color:#6B7280;">
                    {{ $products->count() }} {{ Str::plural('item', $products->count()) }}
                </span>
            </div>

            @if($eligibleOffer)

            <div style="
                background:#fff;
                border:1px solid #F0F0EC;
                border-left:5px solid #C25A2A;
                border-radius:20px;
                padding:22px;
                margin-bottom:28px;
                box-shadow:0 4px 16px rgba(0,0,0,.05);
            ">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:20px;
                    flex-wrap:wrap;
                ">

                    <div>

                        <p style="
                            color:#C25A2A;
                            font-size:11px;
                            font-weight:700;
                            letter-spacing:.12em;
                            text-transform:uppercase;
                            margin:0 0 6px;
                        ">
                            Exclusive Offer
                        </p>

                        <h3 style="
                            font-size:22px;
                            font-weight:800;
                            color:#0D0D0D;
                            margin:0;
                            font-family:'Poppins',sans-serif;
                        ">
                            🎉 {{ $eligibleOffer->title }}
                        </h3>

                        @if($eligibleOffer->description)
                            <p style="
                                color:#6B7280;
                                margin:8px 0 0;
                                font-size:14px;
                                line-height:1.6;
                            ">
                                {{ $eligibleOffer->description }}
                            </p>
                        @endif

                        <div style="
                            margin-top:10px;
                            display:flex;
                            gap:10px;
                            flex-wrap:wrap;
                        ">

                            <span style="
                                background:#FFF0EC;
                                color:#C25A2A;
                                padding:6px 12px;
                                border-radius:999px;
                                font-size:12px;
                                font-weight:700;
                            ">
                                Min Order £{{ number_format($eligibleOffer->min_order_value, 2) }}
                            </span>

                            <span style="
                                background:#F3F4F6;
                                color:#374151;
                                padding:6px 12px;
                                border-radius:999px;
                                font-size:12px;
                                font-weight:600;
                            ">
                                Valid Until
                                {{ \Carbon\Carbon::parse($eligibleOffer->end_date)->format('d M Y') }}
                            </span>

                        </div>

                    </div>

                    <div style="
                        background:#C25A2A;
                        color:#fff;
                        border-radius:18px;
                        padding:18px 24px;
                        text-align:center;
                        min-width:150px;
                    ">

                        <div style="
                            font-size:12px;
                            font-weight:600;
                            opacity:.9;
                            margin-bottom:4px;
                        ">
                            YOU SAVE
                        </div>

                        <div style="
                            font-size:30px;
                            font-weight:800;
                            line-height:1;
                        ">
                            @if($eligibleOffer->value_type == 'percentage')
                                {{ rtrim(rtrim($eligibleOffer->value,'0'),'.') }}%
                            @else
                                £{{ rtrim(rtrim($eligibleOffer->value,'0'),'.') }}
                            @endif
                        </div>

                        <div style="
                            font-size:13px;
                            margin-top:5px;
                            opacity:.9;
                        ">
                            OFF
                        </div>

                    </div>

                </div>

            </div>

            @endif

            {{-- Products Grid --}}
            <div class="res-products-grid">

                @forelse($products as $product)
                    <div style="background:#fff; border-radius:20px; overflow:visible; box-shadow:0 2px 16px rgba(0,0,0,.07); border:1px solid #F0F0EC; transition:all .22s;"
                        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,.12)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 16px rgba(0,0,0,.07)'">

                        <div style="position:relative; overflow:hidden;">
                            <img 
                            {{-- src="{{ $product->image ? asset('storage/' . $product->image) : asset('default.png') }}" --}}
                                src="{{ config('services.google_drive.image_url') . $product->image }}"
                                style="width:100%; height:200px; object-fit:cover; display:block; transition:transform .5s;"
                                onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">

                            <div style="position:absolute; top:12px; left:12px;">
                                <span class="badge-primary"> Featured</span>
                            </div>

                            <div
                                style="position:absolute; top:12px; right:12px; background:rgba(255,255,255,0.95); border-radius:999px; padding:4px 12px;">
                                <span style="font-size:14px; font-weight:800; color:#C25A2A;">£{{ $product->price }}</span>
                            </div>

                            {{-- If product has an active offer/discount --}}
                            {{-- @if(isset($product->activeOffer) && $product->activeOffer)
                                <div
                                    style="position:absolute; bottom:12px; left:12px; background:{{ $product->activeOffer->type === 'discount' ? '#16A34A' : '#E63946' }}; color:#fff; padding:4px 10px; border-radius:12px; font-size:11px; font-weight:700;">
                                    {{ $product->activeOffer->type === 'discount' ? '🏷️' : '🎁' }}
                                    @if($product->activeOffer->value_type === 'percent')
                                        {{ $product->activeOffer->value }}% OFF
                                    @else
                                        £{{ $product->activeOffer->value }} OFF
                                    @endif
                                </div>
                            @endif --}}
                        </div>


                        <div style="padding:16px;">
                            <h3
                                style="font-weight:700; font-size:15px; margin:0 0 6px; line-height:1.3; color:#0D0D0D; font-family:'Poppins',sans-serif;">
                                {{ $product->name }}
                            </h3>
                            
                            <p style="color:#6B7280; font-size:13px; line-height:1.55; margin:0 0 14px;">
                                <!-- {{ Str::limit($product->description, 70) }} -->
                                {{ Str::limit(strip_tags($product->description), 80) }}

                            </p>
                            <div style="display:flex; gap:8px; justify-content:space-between; text-align:center; margin-top:2px; margin-bottom:8px;">
                                <div class="info-tooltip">
                                    <span class="details-link">Allergy & Dietary</span>

                                        <div class="tooltip-content">
                                            <h6>Allergy Information</h6>

                                            @if($product->allergies->count())
                                                <ul style="margin:0;padding-left:18px;list-style:disc;">
                                                    @foreach($product->allergies as $allergy)
                                                        <li style="font-size:12px;line-height:1.5;">
                                                            {{ $allergy->allergy }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p style="font-size:12px;">May contain common allergens.</p>
                                            @endif

                                            <h6 style="margin-top:10px;">Dietary Information</h6>

                                            @if($product->dietaries->count())
                                                <ul style="margin:0;padding-left:18px;list-style:disc;">
                                                    @foreach($product->dietaries as $dietary)
                                                        <li style="font-size:12px;line-height:1.5;">
                                                            {{ $dietary->dietary }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p style="font-size:12px;">
                                                    @if($product->product_type == 'veg')
                                                        🟢 Vegetarian
                                                    @elseif($product->product_type == 'non_veg')
                                                        🔴 Non Vegetarian
                                                    @else
                                                        🥤 Beverage
                                                    @endif
                                                </p>
                                            @endif
                                        </div>
                                </div>
                                @php
                                    $arImage = $product->image_3d
                                        ? asset('storage/' . $product->image_3d)
                                        : config('services.google_drive.image_url') . $product->image;
                                @endphp
                                {{-- <a href="{{ url('/product/' . $product->id) }}">
                                    <div class="info-tooltip">
                                        <span class="details-link">Details</span>
                                    </div>
                                </a> --}}
                                <a href="javascript:void(0)" onclick="openAR('{{ $arImage }}')">
                                    <div class="info-tooltip">
                                        <span class="details-link">3D View</span>
                                    </div>
                                </a>
                            </div>
                            {{-- <div style="display:flex; gap:8px;">
                                <a href="javascript:void(0)" class="btn-black"
                                    onclick="openAR('{{ asset('storage/' . $product->image) }}')" style="flex:1;">
                                    3D View
                                </a>
                                <!-- <form method="POST" action="/cart/add" style="flex:1;"> -->
                                <form class="addCartForm" style="flex:1;">
                                    @csrf

                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <button class="btn-primary" type="submit">

                                        Add

                                    </button>
                                </form>
                            </div> --}}
                           
                            <div style="display:flex; gap:8px; align-items:center;">

                                <a href="{{ url('/product/' . $product->id) }}"
                                    class="btn-black"
                                    {{-- onclick="openAR('{{ asset('storage/' . ($product->image_3d ?: $product->image)) }}')" --}}
                                    {{-- onclick="openAR('{{ $arImage }}')" --}}
                                    style="flex:1;">
                                    Details
                                </a>

                                {{-- <form class="addCartForm"
                                    style="flex:1;"
                                    data-product="{{ $product->id }}"> --}}
                                @if(!$isAdmin)    
                                @auth
                                    <form class="addCartForm"
                                        style="flex:1;"
                                        data-product="{{ $product->id }}"
                                        data-variants='@json($product->variants)'
                                        data-qty="{{ session('cart')[$product->id]['quantity'] ?? 0 }}">    

                                        @csrf

                                        <input type="hidden"
                                            name="product_id"
                                            value="{{ $product->id }}">
                                        <input
                                            type="hidden"
                                            name="variant_id"
                                            class="variantId">    

                                        <input type="hidden"
                                            name="quantity"
                                            value="1"
                                            class="qtyInput">

                                        {{-- ADD BUTTON --}}
                                        <button class="btn-primary addBtn"
                                            type="submit">

                                            Add

                                        </button>

                                        {{-- QUANTITY BOX --}}
                                        <div class="qtyBox"
                                            style="
                                                display:none;
                                                align-items:center;
                                                overflow:hidden;
                                                border-radius:14px;
                                                border:1px solid #E5E7EB;
                                                height:42px;
                                            ">

                                            <button type="button"
                                                class="qtyMinus"
                                                style="
                                                    width:42px;
                                                    height:42px;
                                                    border:none;
                                                    background:#F5F5F0;
                                                    font-size:22px;
                                                    font-weight:700;
                                                    cursor:pointer;
                                                ">
                                                −
                                            </button>

                                            <div class="qtyValue"
                                                style="
                                                    width:48px;
                                                    text-align:center;
                                                    font-weight:700;
                                                    font-size:15px;
                                                    background:#fff;
                                                ">
                                                1
                                            </div>

                                            <button type="button"
                                                class="qtyPlus"
                                                style="
                                                    width:42px;
                                                    height:42px;
                                                    border:none;
                                                    background:#E63946;
                                                    color:#fff;
                                                    font-size:22px;
                                                    font-weight:700;
                                                    cursor:pointer;
                                                ">
                                                +
                                            </button>

                                        </div>

                                    </form>
                                @else
                                @php
                                    session(['login_redirect' => request()->getRequestUri()]);
                                @endphp

                                    <a href="{{ route('login') }}"
                                        class="btn-primary"
                                        style="
                                            flex:1;
                                            display:flex;
                                            justify-content:center;
                                            align-items:center;
                                            text-decoration:none;
                                        ">

                                        Add

                                    </a>

                                @endauth
                                @endif

                            </div>
                        </div>
                    </div>

                @empty
                    <div
                        style="grid-column:1/-1; text-align:center; padding:80px 20px; background:#fff; border-radius:20px; border:1px solid #F0F0EC;">
                        <div
                            style="width:80px; height:80px; background:#FFF0EC; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                            <svg width="36" height="36" fill="none" stroke="#C25A2A" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                                <path d="M12 22V12M3.27 6.96L12 12.01l8.73-5.05" />
                            </svg>
                        </div>
                        <h3 style="font-size:20px; font-weight:700; margin-bottom:8px; color:#0D0D0D;">No Products Found</h3>
                        <p style="color:#6B7280; font-size:14px; margin:0 0 20px;">This category has no products right now.</p>
                        <a href="{{ url('/restaurant/' . $restaurant->slug) }}" class="btn-primary"
                            style="display:inline-flex; width:auto; padding:12px 24px; text-decoration:none;">
                            ← View All Items
                        </a>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    <div id="variantModal"
        style="display:none;
                position:fixed;
                inset:0;
                background:rgba(0,0,0,.6);
                z-index:999999;">

        <div style="
            background:white;
            width:400px;
            max-width:95%;
            margin:80px auto;
            border-radius:20px;
            padding:20px;">

            <h3>Select Variant</h3>

            <div id="variantOptions"></div>

            <div style="display:flex;gap:10px;margin-top:20px">

                <button
                    onclick="closeVariantModal()"
                    class="btn-black">
                    Cancel
                </button>

                <button
                    onclick="confirmVariant()"
                    class="btn-primary">
                    Add To Cart
                </button>

            </div>

        </div>

    </div>

    {{-- ======== AR / 3D MODAL ======== --}}
    <div id="arModal" style="display:none; position:fixed; inset:0; background:#000; z-index:999999;">
        <span onclick="closeAR()"
            style="position:fixed; top:15px; left:15px; z-index:99999; background:#fff; color:rgba(0,0,0,0.7); width:42px; height:42px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:20px;">✖</span>
        <video id="camera" autoplay playsinline
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"></video>
        <div
            style="position:relative; z-index:10; width:100%; height:100%; display:flex; flex-direction:column; justify-content:center; align-items:center;">
            <div style="width:min(80vw,350px); height:min(80vw,350px); perspective:1000px;">
                <div id="pizza"
                    style="width:100%; height:100%; background-size:contain; background-repeat:no-repeat; background-position:center; transform-style:preserve-3d; transition:transform .2s ease; cursor:grab;">
                </div>
            </div>
            <p
                style="color:#fff; margin-top:15px; font-size:14px; background:rgba(0,0,0,0.6); padding:8px 14px; border-radius:30px;">
                Drag to rotate</p>
        </div>
    </div>

    <div id="favoriteModal"
        class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">

        <div class="bg-white rounded-3xl p-8 max-w-md w-full">

            <h2 class="text-2xl font-bold mb-3">
                ⭐ Add Restaurant To Favorites
            </h2>

            <p class="mb-6">
                Do you want to add this restaurant to your favorites?
            </p>

            <div class="flex gap-3">

                <button
                    onclick="saveFavorite()"
                    class="flex-1 bg-black text-white py-3 rounded-xl">
                    Yes
                </button>

                <button
                    onclick="closeFavoritePopup()"
                    class="flex-1 border py-3 rounded-xl">
                    No
                </button>

            </div>

        </div>

    </div>

    <script>
        /* ---- AR ---- */
        const video = document.getElementById('camera');
        const pizza = document.getElementById('pizza');
        let rotY = 0, dragging = false, startX = 0;

        async function openAR(img) {
            document.getElementById('arModal').style.display = 'block';
            pizza.style.backgroundImage = `url('${img}')`;
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
                video.srcObject = stream;
            } catch (e) { alert('Please allow camera access'); }
        }
        function closeAR() {
            document.getElementById('arModal').style.display = 'none';
            if (video.srcObject) video.srcObject.getTracks().forEach(t => t.stop());
        }
        pizza.addEventListener('mousedown', e => { dragging = true; startX = e.clientX; });
        document.addEventListener('mouseup', () => dragging = false);
        document.addEventListener('mousemove', e => {
            if (!dragging) return;
            rotY += (e.clientX - startX) * 0.7;
            pizza.style.transform = `rotateY(${rotY}deg)`;
            startX = e.clientX;
        });
        pizza.addEventListener('touchstart', e => { dragging = true; startX = e.touches[0].clientX; });
        pizza.addEventListener('touchend', () => dragging = false);
        pizza.addEventListener('touchmove', e => {
            if (!dragging) return;
            rotY += (e.touches[0].clientX - startX) * 0.7;
            pizza.style.transform = `rotateY(${rotY}deg)`;
            startX = e.touches[0].clientX;
        });

        /* ---- OFFER SLIDER ---- */
        const resTrack = document.getElementById('resOfferTrack');
        const resDots = document.getElementById('resDots');

        if (resTrack) {
            const slides = resTrack.querySelectorAll('.res-offer-slide');
            let cur = 0;
            const total = slides.length;

            const spv = () => window.innerWidth <= 560 ? 1 : window.innerWidth <= 900 ? 2 : 3;
            const max = () => Math.max(0, total - spv());

            function buildDots() {
                if (!resDots) return;
                resDots.innerHTML = '';
                for (let i = 0; i <= max(); i++) {
                    const d = document.createElement('button');
                    d.className = 'res-dot' + (i === cur ? ' active' : '');
                    d.onclick = () => goTo(i);
                    resDots.appendChild(d);
                }
            }

            function goTo(idx) {
                cur = Math.max(0, Math.min(idx, max()));
                const w = slides[0].offsetWidth + 16;
                resTrack.style.transform = `translateX(-${cur * w}px)`;
                buildDots();
            }

            window.resSliderNext = () => goTo(cur + 1);
            window.resSliderPrev = () => goTo(cur - 1);

            buildDots();
            window.addEventListener('resize', () => goTo(Math.min(cur, max())));
            setInterval(() => goTo(cur >= max() ? 0 : cur + 1), 3500);
        }
    </script>
    {{-- <script>

        document
            .querySelectorAll(
                '.addCartForm'
            )

            .forEach(form => {

                form.addEventListener(

                    'submit',

                    async function (e) {

                        e.preventDefault();

                        const fd =
                            new FormData(form);

                        try {

                            const res =
                                await fetch(

                                    '/cart/add',

                                    {

                                        method: 'POST',

                                        headers: {

                                            'X-CSRF-TOKEN':

                                                document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]'
                                                    ).content,

                                            'Accept':
                                                'application/json'

                                        },

                                        body: fd

                                    }

                                );


                            // LOGIN EXPIRED / NOT LOGIN

                            if (

                                res.status === 401

                            ) {

                                showToast(
                                    'Please login first'
                                );

                                setTimeout(() => {

                                    window.location.href =
                                        '/login';

                                }, 1000);

                                return;

                            }


                            const data =
                                await res.json();


                            // CONTROLLER REDIRECT

                            if (

                                data.redirect

                            ) {

                                showToast(
                                    data.message
                                );

                                setTimeout(() => {

                                    window.location.href =
                                        data.redirect;

                                }, 1000);

                                return;

                            }


                            // SUCCESS

                            if (

                                data.success

                            ) {

                                const cartCount =
                                    document.getElementById(
                                        'cartCount'
                                    );

                                if (cartCount) {

                                    cartCount.innerHTML =
                                        data.count;

                                }

                                const mobile =
                                    document.getElementById(
                                        'mobileCartCount'
                                    );

                                if (mobile) {

                                    mobile.innerHTML =
                                        data.count;

                                }

                                showToast(
                                    data.message
                                );

                            }

                        } catch (err) {

                            console.log(err);

                            showToast(
                                'Something went wrong'
                            );

                        }

                    });

            });


        function showToast(msg) {

            const div =
                document.createElement(
                    'div'
                );

            div.innerHTML =
                msg;

            div.style = `

            position:fixed;
            top:20px;
            right:20px;

            background:#16A34A;

            color:#fff;

            padding:14px 22px;

            border-radius:12px;

            font-weight:700;

            z-index:999999;

            `;

            document.body.appendChild(
                div
            );

            setTimeout(() => {

                div.remove();

            }, 2000);

        }

    </script> --}}
    <script>
        let activeForm = null;

        document.querySelectorAll('.addCartForm').forEach(form => {

            const addBtn   = form.querySelector('.addBtn');
            const qtyBox   = form.querySelector('.qtyBox');
            const qtyValue = form.querySelector('.qtyValue');

            const productId =
                form.querySelector('[name="product_id"]').value;

            // REAL SESSION QTY
            let qty = parseInt(
                form.dataset.qty || 0
            );

            // SHOW EXISTING QTY
            if(qty > 0){

                addBtn.style.display = 'none';

                qtyBox.style.display = 'flex';

                qtyValue.innerText = qty;

            }

            // ADD
            // form.addEventListener('submit', async function(e){

            //     e.preventDefault();

            //     const fd = new FormData(form);

            //     try{

            //         const res = await fetch('/cart/add', {

            //             method:'POST',

            //             headers:{
            //                 'X-CSRF-TOKEN':
            //                 document.querySelector('meta[name="csrf-token"]').content,

            //                 'Accept':'application/json'
                            
            //             },

            //             body:fd

            //         });

            //         const data = await res.json();

            //         if(data.success){

            //             qty = 1;

            //             form.dataset.qty = qty;

            //             addBtn.style.display = 'none';

            //             qtyBox.style.display = 'flex';

            //             qtyValue.innerText = qty;

            //             updateCounts(data.count);
            //             setTimeout(() => {

            //                 maybeShowFavoritePopup();

            //             }, 500);

            //         }

            //     }catch(err){

            //         console.log(err);

            //     }

            // });


            form.addEventListener('submit', function(e){

                e.preventDefault();

                const variants =
                    JSON.parse(
                        form.dataset.variants || '[]'
                    );

                // no variants
                if(variants.length == 0){

                    if(variants.length){

                        form.querySelector('.variantId').value =
                            variants[0].id;
                    }

                    submitCart(form);

                    return;
                }

                activeForm = form;

                let html = '';

                variants.forEach(v => {

                    html += `
                        <label
                            style="
                            display:flex;
                            justify-content:space-between;
                            border:1px solid #ddd;
                            padding:12px;
                            margin-bottom:10px;
                            border-radius:10px;
                            cursor:pointer;
                        ">
                            <span>${v.name}</span>

                            <span>£${v.price}</span>

                            <input
                                type="radio"
                                name="variantSelect"
                                value="${v.id}">
                        </label>
                    `;
                });

                document.getElementById(
                    'variantOptions'
                ).innerHTML = html;

                document.getElementById(
                    'variantModal'
                ).style.display = 'block';

            });


            // PLUS
            form.querySelector('.qtyPlus')
            .addEventListener('click', async () => {

                try{

                    await fetch(
                        `/cart/increase/${productId}`
                    );

                    qty++;

                    form.dataset.qty = qty;

                    qtyValue.innerText = qty;

                    updateCountFromPage();

                }catch(err){

                    console.log(err);

                }

            });


            // MINUS
            form.querySelector('.qtyMinus')
            .addEventListener('click', async () => {

                try{

                    if(qty > 1){

                        await fetch(
                            `/cart/decrease/${productId}`
                        );

                        qty--;

                        form.dataset.qty = qty;

                        qtyValue.innerText = qty;

                    }else{

                        await fetch(
                            `/cart/remove/${productId}`
                        );

                        qty = 0;

                        form.dataset.qty = qty;

                        qtyBox.style.display = 'none';

                        addBtn.style.display = 'flex';

                    }

                    updateCountFromPage();

                }catch(err){

                    console.log(err);

                }

            });

        });

        function closeVariantModal()
        {
            document
                .getElementById('variantModal')
                .style.display = 'none';
        }

        function confirmVariant()
        {
            const selected =
                document.querySelector(
                    'input[name="variantSelect"]:checked'
                );

            if(!selected){

                alert(
                    'Please select a variant'
                );

                return;
            }

            activeForm
                .querySelector('.variantId')
                .value =
                selected.value;

            closeVariantModal();

            submitCart(activeForm);
        }

        async function submitCart(form)
        {
            const fd =
                new FormData(form);

            try{

                const res =
                    await fetch(
                        '/cart/add',
                        {
                            method:'POST',

                            headers:{
                                'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content,

                                'Accept':
                                'application/json'
                            },

                            body:fd
                        }
                    );

                const data =
                    await res.json();

                if(data.success){

                    const addBtn =
                        form.querySelector('.addBtn');

                    const qtyBox =
                        form.querySelector('.qtyBox');

                    const qtyValue =
                        form.querySelector('.qtyValue');

                    addBtn.style.display='none';

                    qtyBox.style.display='flex';

                    qtyValue.innerText='1';

                    form.dataset.qty = 1;

                    updateCounts(
                        data.count
                    );
                }

            }catch(err){

                console.log(err);

            }
        }


        // UPDATE COUNT
        function updateCountFromPage(){

            fetch('/cart-count')

            .then(res => res.json())

            .then(data => {

                updateCounts(data.count);

            });

        }


        function updateCounts(count){

            const cartCount =
                document.getElementById('cartCount');

            if(cartCount){

                cartCount.innerHTML = count;

            }

            const mobile =
                document.getElementById('mobileCartCount');

            if(mobile){

                mobile.innerHTML = count;

            }

        }

        function maybeShowFavoritePopup()
        {
            if(window.isFavorite){
                return;
            }

            const key =
                'favorite_popup_' + window.restaurantId;

            if(localStorage.getItem(key)){
                return;
            }

            document
                .getElementById('favoriteModal')
                .classList.remove('hidden');

            document
                .getElementById('favoriteModal')
                .classList.add('flex');

            localStorage.setItem(key, 'shown');
        }

        function closeFavoritePopup()
        {
            document
                .getElementById('favoriteModal')
                .classList.remove('flex');

            document
                .getElementById('favoriteModal')
                .classList.add('hidden');
        }

        function saveFavorite()
        {
            fetch(
                `/restaurant/${window.restaurantId}/favorite`,
                {
                    method:'POST',
                    headers:{
                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,

                        'Accept':'application/json'
                    }
                }
            )
            .then(res => res.json())
            .then(data => {

                window.isFavorite = true;

                closeFavoritePopup();

            });
        }

    </script>
    <script>
        window.restaurantId = @json($restaurant->id);

        window.isFavorite = @json(
            auth()->check()
                ? \App\Models\RestaurantFavorite::where(
                    'restaurant_id',
                    $restaurant->id
                )->where(
                    'user_id',
                    auth()->id()
                )->exists()
                : false
        );
    </script>
@endsection