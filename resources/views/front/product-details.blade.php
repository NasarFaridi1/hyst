@extends('front.layouts.app')

@section('content')

@php
    $isAdmin = auth()->check() &&
        in_array(auth()->user()->role, ['super_admin', 'restaurant_admin']);
    
@endphp

    <section style="background:#F5F5F0; padding:60px 0 80px;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">

            <div class="product-detail-grid"
                style="display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:start;">

                <div>
                    <div
                        style="border-radius:24px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.12); position:relative; background:#fff;">
                        <img 
                            {{-- src="{{ $product->image
                                ? asset('storage/' . $product->image)
                                : asset('default.png') }}" --}}
                            src="{{ $product->image ? config('services.google_drive.image_url') . $product->image :asset('default.png') }}"

                            style="width:100%; aspect-ratio:4/3; object-fit:cover; display:block; transition:transform .6s;"
                            onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                        <div style="position:absolute; top:16px; left:16px;" class="badge-primary">
                            <span style="display:flex; align-items:center; gap:5px; font-size:12px; padding:4px 2px;">
                                <i data-lucide="star" style="width:12px; height:12px; fill:#fff;"></i> Featured
                            </span>
                        </div>
                    </div>

                    <!-- QUICK INFO CHIPS -->
                    {{-- <div style="display:flex; gap:10px; margin-top:18px; flex-wrap:wrap;">
                        <div
                            style="display:flex; align-items:center; gap:8px; background:#fff; padding:10px 16px; border-radius:12px; border:1px solid #F0F0EC; flex:1; min-width:120px;">
                            <i data-lucide="clock" style="width:16px; height:16px; color:#C25A2A; flex-shrink:0;"></i>
                            <div>
                                <p
                                    style="font-size:10px; color:#9CA3AF; margin:0; font-weight:500; text-transform:uppercase; letter-spacing:.05em;">
                                    Delivery</p>
                                <p style="font-size:13px; font-weight:700; margin:0; font-family:'Poppins',sans-serif;">30
                                    min</p>
                            </div>
                        </div>
                        <div
                            style="display:flex; align-items:center; gap:8px; background:#fff; padding:10px 16px; border-radius:12px; border:1px solid #F0F0EC; flex:1; min-width:120px;">
                            <i data-lucide="star"
                                style="width:16px; height:16px; color:#FBBF24; fill:#FBBF24; flex-shrink:0;"></i>
                            <div>
                                <p
                                    style="font-size:10px; color:#9CA3AF; margin:0; font-weight:500; text-transform:uppercase; letter-spacing:.05em;">
                                    Rating</p>
                                <p style="font-size:13px; font-weight:700; margin:0; font-family:'Poppins',sans-serif;">4.9
                                    / 5</p>
                            </div>
                        </div>
                        <div
                            style="display:flex; align-items:center; gap:8px; background:#fff; padding:10px 16px; border-radius:12px; border:1px solid #F0F0EC; flex:1; min-width:120px;">
                            <i data-lucide="leaf" style="width:16px; height:16px; color:#16A34A; flex-shrink:0;"></i>
                            <div>
                                <p
                                    style="font-size:10px; color:#9CA3AF; margin:0; font-weight:500; text-transform:uppercase; letter-spacing:.05em;">
                                    Quality</p>
                                <p style="font-size:13px; font-weight:700; margin:0; font-family:'Poppins',sans-serif;">
                                    Fresh</p>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div>

                    <!-- CATEGORY & PRODUCT TYPE TAGS -->
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:18px; flex-wrap:wrap;">
                        @if($product->category)
                            <div
                                style="display:inline-flex; align-items:center; gap:6px; background:#FFF0EC; border:1px solid rgba(232,55,14,0.2); padding:6px 14px; border-radius:999px;">
                                <i data-lucide="tag" style="width:12px; height:12px; color:#C25A2A;"></i>
                                <span
                                    style="font-size:12px; font-weight:600; color:#C25A2A; font-family:'Poppins',sans-serif;">{{ $product->category->name }}</span>
                            </div>
                        @endif

                        @if(($product->product_type ?? 'veg') === 'veg')
                            <div style="display:inline-flex; align-items:center; gap:6px; background:#ECFDF5; border:1px solid #A7F3D0; padding:6px 14px; border-radius:999px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#059669; display:inline-block;"></span>
                                <span style="font-size:12px; font-weight:700; color:#047857; font-family:'Poppins',sans-serif;">Vegetarian (Veg)</span>
                            </div>
                        @else
                            <div style="display:inline-flex; align-items:center; gap:6px; background:#FFF1F2; border:1px solid #FECDD3; padding:6px 14px; border-radius:999px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#DC2626; display:inline-block;"></span>
                                <span style="font-size:12px; font-weight:700; color:#B91C1C; font-family:'Poppins',sans-serif;">Non-Vegetarian (Non-Veg)</span>
                            </div>
                        @endif
                    </div>

                    <h1
                        style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; color:#0D0D0D; margin:0 0 14px; line-height:1.2; letter-spacing:-.5px;">
                        {{ $product->name }}
                    </h1>

                    <div style="
                        display:flex;
                        flex-wrap:wrap;
                        gap:12px;
                        align-items:center;
                        margin-bottom:18px;
                    ">

                        {{-- Restaurant Name --}}
                        <div style="
                            background:#F9FAFB;
                            border:1px solid #E5E7EB;
                            padding:8px 14px;
                            border-radius:999px;
                            font-size:14px;
                            font-weight:700;
                            color:#111827;
                        ">
                            🏪 {{ $product->restaurant->name }}
                        </div>

                        {{-- Review Rating --}}
                        <div style="
                            background:#FFF7ED;
                            border:1px solid #FED7AA;
                            padding:8px 14px;
                            border-radius:999px;
                            font-size:14px;
                            font-weight:700;
                            color:#C2410C;
                        ">
                            ⭐ {{ number_format($product->restaurant->reviews->avg('rating') ?? 0, 1) }}
                            ({{ $product->restaurant->reviews->count() }} Reviews)
                        </div>

                        {{-- Hygiene Rating --}}
                        @if($product->restaurant->hygiene_rating)
                            <div style="
                                background:#ECFDF5;
                                border:1px solid #BBF7D0;
                                padding:8px 14px;
                                border-radius:999px;
                                font-size:14px;
                                font-weight:700;
                                color:#166534;
                            ">
                                🛡 Hygiene {{ number_format($product->restaurant->hygiene_rating,1) }}/5
                            </div>
                        @endif

                        {{-- Certified --}}
                        @if($product->restaurant->hygiene_certificate)
                            <div style="
                                background:#DCFCE7;
                                border:1px solid #86EFAC;
                                padding:8px 14px;
                                border-radius:999px;
                                font-size:14px;
                                font-weight:700;
                                color:#166534;
                            ">
                                ✓ Certified
                            </div>
                        @endif

                    </div>

                    @if($product->variants->count())

                        <div style="margin-bottom:24px;">

                            <h4 style="
                                font-size:14px;
                                font-weight:700;
                                margin-bottom:12px;
                                color:#111827;
                            ">
                                Select Size
                            </h4>

                            <div style="
                                display:grid;
                                grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
                                gap:12px;
                            ">

                                @foreach($product->variants as $variant)

                                    <label style="
                                        display:flex;
                                        align-items:center;
                                        justify-content:space-between;
                                        padding:14px 18px;
                                        border:1px solid #E5E7EB;
                                        border-radius:999px;
                                        cursor:pointer;
                                        background:#fff;
                                        transition:.2s;
                                    ">

                                        <div style="
                                            display:flex;
                                            align-items:center;
                                            gap:10px;
                                        ">

                                            <input
                                                type="radio"
                                                name="variantSelect"
                                                value="{{ $variant->id }}"
                                                data-price="{{ $variant->price }}"
                                                style="
                                                    width:18px;
                                                    height:18px;
                                                    accent-color:#2563EB;
                                                    cursor:pointer;
                                                ">

                                            <span style="
                                                font-size:15px;
                                                font-weight:600;
                                                color:#111827;
                                            ">
                                                {{ $variant->name }}
                                            </span>

                                        </div>

                                        <span style="
                                            font-size:15px;
                                            font-weight:700;
                                            color:#111827;
                                        ">
                                            £{{ number_format($variant->price,2) }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>

                    @endif

                    <!-- PRICE -->
                    <div style="display:flex; align-items:baseline; gap:10px; margin-bottom:24px;">
                        <span
                            style="font-family:'Poppins',sans-serif; font-size:42px; font-weight:800; color:#C25A2A; line-height:1;">
                            £{{ $product->price }}
                        </span>
                        <span style="font-size:14px; color:#9CA3AF; font-weight:500;">per serving</span>
                    </div>

                    

                    <!-- DIVIDER -->
                    <div style="height:1px; background:#F0F0EC; margin-bottom:24px;"></div>

                    <!-- DESCRIPTION -->
                    <div style="margin-bottom:32px;">
                        <h3
                            style="font-family:'Poppins',sans-serif; font-size:15px; font-weight:700; color:#0D0D0D; margin:0 0 12px;">
                            About this dish</h3>
                        <p style="color:#6B7280; font-size:15px; line-height:1.85; margin:0;">
                            <!-- {{ $product->description }} -->
                            {!! nl2br(e($product->description)) !!}
                        </p>
                    </div>

                    <!-- WHY CHOOSE BADGES -->
                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:36px;">

                        {{-- Allergy Information --}}
                        {{-- <div
                            style="display:flex; align-items:center; gap:12px; background:#F9FAFB; padding:12px 16px; border-radius:12px; border:1px solid #F0F0EC;">

                            <div
                                style="width:34px; height:34px; background:#FEF3C7; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i data-lucide="alert-triangle"
                                    style="width:16px; height:16px; color:#D97706;"></i>
                            </div>

                            <div>
                                <p style="font-size:13px; font-weight:700; margin:0; font-family:'Poppins',sans-serif;">
                                    Allergy Information
                                </p>

                                <p style="font-size:12px; color:#6B7280; margin:2px 0 0;">
                                    {{ $product->allergy ?: 'No allergy information available.' }}
                                </p>
                            </div>
                        </div> --}}

                        {{-- Dietary Information --}}
                        {{-- <div
                            style="display:flex; align-items:center; gap:12px; background:#F9FAFB; padding:12px 16px; border-radius:12px; border:1px solid #F0F0EC;">

                            <div
                                style="width:34px; height:34px; background:#DCFCE7; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i data-lucide="leaf"
                                    style="width:16px; height:16px; color:#16A34A;"></i>
                            </div>

                            <div>
                                <p style="font-size:13px; font-weight:700; margin:0; font-family:'Poppins',sans-serif;">
                                    Dietary Information
                                </p>

                                <p style="font-size:12px; color:#6B7280; margin:2px 0 0;">
                                    {{ $product->dietary ?: 'No dietary information available.' }}
                                </p>
                            </div>
                        </div> --}}

                        {{-- Allergy Information --}}
                        <div style="display:flex; align-items:flex-start; gap:12px; background:#F9FAFB; padding:12px 16px; border-radius:12px; border:1px solid #F0F0EC;">

                            <div style="width:34px; height:34px; background:#FEF3C7; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i data-lucide="alert-triangle" style="width:16px; height:16px; color:#D97706;"></i>
                            </div>

                            <div>
                                <p style="font-size:13px; font-weight:700; margin:0; font-family:'Poppins',sans-serif;">
                                    Allergy Information
                                </p>

                                @if($product->allergies->count())
                                    <ul style="margin:6px 0 0; padding-left:18px; list-style-type:disc;">
                                        @foreach($product->allergies as $allergy)
                                            <li style="font-size:12px; color:#6B7280; line-height:1.5;">
                                                {{ $allergy->allergy }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p style="font-size:12px; color:#6B7280; margin:4px 0 0;">
                                        No allergy information available.
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Dietary Information --}}
                        <div style="display:flex; align-items:flex-start; gap:12px; background:#F9FAFB; padding:12px 16px; border-radius:12px; border:1px solid #F0F0EC;">

                            <div style="width:34px; height:34px; background:#DCFCE7; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i data-lucide="leaf" style="width:16px; height:16px; color:#16A34A;"></i>
                            </div>

                            <div>
                                <p style="font-size:13px; font-weight:700; margin:0; font-family:'Poppins',sans-serif;">
                                    Dietary Information
                                </p>

                                @if($product->dietaries->count())
                                    <ul style="margin:6px 0 0; padding-left:18px; list-style-type:disc;">
                                        @foreach($product->dietaries as $dietary)
                                            <li style="font-size:12px; color:#6B7280; line-height:1.5;">
                                                {{ $dietary->dietary }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p style="font-size:12px; color:#6B7280; margin:4px 0 0;">
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

                    </div>

                    <!-- ADD TO CART FORM -->
                    {{-- <form method="POST" action="/cart/add">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="current_url" value="{{ url()->current() }}">

                        <div style="display:flex; gap:12px; flex-wrap:wrap;">
                            <button class="btn-primary" type="submit"
                                style="flex:2; padding:16px 24px; font-size:16px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; letter-spacing:.02em; min-width:180px;">
                                <i data-lucide="shopping-cart" style="width:18px; height:18px;"></i>
                                Add To Cart
                            </button>
                            <a href="javascript:history.back()"
                                style="flex:1; padding:16px 20px; font-size:15px; font-family:'Poppins',sans-serif; font-weight:600; border:2px solid #E5E7EB; border-radius:12px; color:#374151; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; transition:all .18s; min-width:100px;"
                                onmouseover="this.style.borderColor='#0D0D0D'; this.style.background='#0D0D0D'; this.style.color='#fff';"
                                onmouseout="this.style.borderColor='#E5E7EB'; this.style.background='transparent'; this.style.color='#374151';">
                                <i data-lucide="arrow-left" style="width:16px; height:16px;"></i> Back
                            </a>
                        </div>
                    </form> --}}
                    
                    @if(!$isAdmin)
                        @auth

                        <form class="addCartForm"
                            data-product="{{ $product->id }}"
                            data-variants='@json($product->variants)'
                            data-qty="{{ session('cart')[$product->id]['quantity'] ?? 0 }}">

                            @csrf

                            <input type="hidden"
                                name="product_id"
                                value="{{ $product->id }}">
                            <input type="hidden"
                                name="variant_id"
                                class="variantId">

                            <input type="hidden"
                                name="quantity"
                                value="1"
                                class="qtyInput">

                            <div style="display:flex; gap:12px; flex-wrap:wrap;">

                                {{-- ADD BUTTON --}}
                                <button class="btn-primary addBtn"
                                    type="submit"
                                    style="flex:2;  min-width:180px;">
                                    <i data-lucide="shopping-cart"></i>
                                    Add To Cart
                                </button>

                                {{-- QUANTITY BOX --}}
                                <div class="qtyBox"
                                    style="
                                        display:none;
                                        align-items:center;
                                        overflow:hidden;
                                        border-radius:14px;
                                        border:1px solid #E5E7EB;
                                        height:54px;
                                    ">

                                    <button type="button"
                                        class="qtyMinus"
                                        style="
                                            width:54px;
                                            height:54px;
                                            border:none;
                                            background:#F5F5F0;
                                            font-size:24px;
                                            cursor:pointer;
                                        ">
                                        −
                                    </button>

                                    <div class="qtyValue"
                                        style="
                                            width:60px;
                                            text-align:center;
                                            font-weight:700;
                                            font-size:16px;
                                        ">
                                        1
                                    </div>

                                    <button type="button"
                                        class="qtyPlus"
                                        style="
                                            width:54px;
                                            height:54px;
                                            border:none;
                                            background:#E63946;
                                            color:#fff;
                                            font-size:24px;
                                            cursor:pointer;
                                        ">
                                        +
                                    </button>

                                </div>

                                <a href="javascript:history.back()"
                                    style="flex:1;"
                                    class="btn-black ">
                                    Back
                                </a>

                            </div>

                        </form>

                        @else
                        @php
                            session(['login_redirect' => request()->getRequestUri()]);
                        @endphp
                        <a href="{{ route('login') }}"
                            class="btn-primary">
                            Add To Cart
                        </a>

                        @endauth
                    @endif

                    {{-- REVIEWS --}}

                   

                </div>
            </div>
            @if($reviews->count())

                        <section style="
                            margin-top:70px;
                            background:#fff;
                            border-radius:28px;
                            padding:40px;
                            box-shadow:0 10px 40px rgba(0,0,0,.05);
                            ">

                            <h2 style="
                                font-size:30px;
                                font-weight:800;
                                margin-bottom:35px;
                                color:#111827;
                            ">

                                                Customer Reviews

                                            </h2>

                            <div style="
                                display:grid;
                                gap:24px;
                            ">

                                               <div style="
                                                    display:grid;
                                                    grid-template-columns:repeat(3,1fr);
                                                    gap:24px;
                                                " class="review-grid">

                                                    @foreach($reviews as $review)

                                                        <div style="
                                                            border:1px solid #F3F4F6;
                                                            border-radius:20px;
                                                            padding:24px;
                                                            background:#fff;
                                                            box-shadow:0 4px 20px rgba(0,0,0,.04);
                                                        ">

                                                            <div style="
                                                                display:flex;
                                                                justify-content:space-between;
                                                                gap:20px;
                                                                flex-wrap:wrap;
                                                                margin-bottom:14px;
                                                            ">

                                                                <div>

                                                                    <h3 style="
                                                                        margin:0 0 8px;
                                                                        font-size:18px;
                                                                        font-weight:700;
                                                                    ">

                                                                        {{ $review->user->name }}

                                                                    </h3>

                                                                    <div style="
                                                                        color:#F59E0B;
                                                                        font-size:22px;
                                                                    ">

                                                                        @for($i = 1; $i <= $review->rating; $i++)

                                                                            ★

                                                                        @endfor

                                                                    </div>

                                                                </div>

                                                                <div style="
                                                                    color:#9CA3AF;
                                                                    font-size:13px;
                                                                ">

                                                                    {{ $review->created_at->format('d M Y') }}

                                                                </div>

                                                            </div>

                                                            <p style="
                                                                color:#4B5563;
                                                                line-height:1.8;
                                                                margin:0;
                                                                font-size:15px;
                                                            ">

                                                                {{ $review->review }}

                                                            </p>

                                                        </div>

                                                    @endforeach

                                                </div>

                                            </div>

                        </section>

            @endif
        </div>
        
    </section>

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

    <style>
        @media(max-width:900px) {
            .product-detail-grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
        }

        .btn-black {
            display: block;
            background: #111827;
            color: #fff;
            padding: 16px 24px;
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
            padding: 16px 24px;
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
        
    </style>

    <script>
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
            form.addEventListener('submit', async function(e){

                e.preventDefault();

                const selectedVariant =
                    document.querySelector(
                        'input[name="variantSelect"]:checked'
                    );

                if(selectedVariant){

                    form.querySelector('.variantId').value =
                        selectedVariant.value;
                }

                const fd = new FormData(form);

                try{

                    const res = await fetch('/cart/add', {

                        method:'POST',

                        headers:{
                            'X-CSRF-TOKEN':
                            document.querySelector('meta[name="csrf-token"]').content,

                            'Accept':'application/json'
                            
                        },

                        body:fd

                    });

                    const data = await res.json();

                    if(data.success){

                        qty = 1;

                        form.dataset.qty = qty;

                        addBtn.style.display = 'none';

                        qtyBox.style.display = 'flex';

                        qtyValue.innerText = qty;

                        updateCounts(data.count);
                        setTimeout(() => {

                            maybeShowFavoritePopup();

                        }, 500);

                    }

                }catch(err){

                    console.log(err);

                }

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
        window.restaurantId = @json($product->restaurant_id);

        window.isFavorite = @json(
            auth()->check()
                ? \App\Models\RestaurantFavorite::where(
                    'restaurant_id',
                    $product->restaurant_id
                )->where(
                    'user_id',
                    auth()->id()
                )->exists()
                : false
        );
    </script>

@endsection