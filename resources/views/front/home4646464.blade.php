@extends('front.layouts.app')
@section('content')

    <!-- ══════════════════════════════════════
         HERO SECTION
    ══════════════════════════════════════ -->
    <section style="position:relative; background:#0D0D0D; color:#fff; overflow:hidden;">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070"
            style="width:100%; height:520px; object-fit:cover; opacity:0.3; display:block;">
        <div
            style="position:absolute; inset:0;  display:flex; align-items:center;">
            <div style="max-width:1280px; margin:0 auto; padding:0 24px; width:100%;">
                <div style="max-width:600px;">

                    <div
                        style="display:inline-flex; align-items:center; gap:8px; background:rgba(232,55,14,0.18); border:1px solid rgba(232,55,14,0.4); padding:7px 16px; border-radius:999px; margin-bottom:22px;">
                        <i data-lucide="zap" style="width:14px; height:14px; color:#fff; flex-shrink:0;"></i>
                        <span
                            style="font-size:14px; font-weight:600; color:#fff; font-family:'Poppins',sans-serif; letter-spacing:.04em;">Zero Commission Platform</span>
                    </div>

                    <h1 class="hero-title"
                        style="font-family:'Poppins',sans-serif; font-size:48px; font-weight:800; line-height:1.15; margin:0 0 18px; letter-spacing:-.5px;">
                        Delicious Food<br><span style="color:#C25A2A;">Delivered</span> To<br>Your Door
                    </h1>

                    <p
                        style="font-size:16px; color:#D1D5DB; line-height:1.8; margin:0 0 32px; max-width:460px; font-weight:400;">
                        Explore premium restaurants, tasty meals, and amazing offers near you.
                    </p>

                    <div class="hero-cta" style="display:flex; gap:12px; flex-wrap:wrap;">
                        <a href="/restaurants" class="btn-primary"
                            style="padding:14px 28px; font-size:15px; display:flex; align-items:center; gap:8px; text-decoration:none; letter-spacing:.02em;">
                            <i data-lucide="shopping-bag" style="width:17px; height:17px;"></i> Order Now
                        </a>
                        {{-- <a href="#categories"
                            style="padding:14px 28px; font-size:15px; font-family:'Poppins',sans-serif; font-weight:600; border:2px solid rgba(255,255,255,0.25); border-radius:12px; color:#fff; text-decoration:none; display:flex; align-items:center; gap:8px; transition:border-color .18s; letter-spacing:.02em;"
                            onmouseover="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onmouseout="this.style.borderColor='rgba(255,255,255,0.25)'">
                            <i data-lucide="grid-2x2" style="width:17px; height:17px;"></i> Explore Menu
                        </a> --}}
                    </div>

                    <!-- STATS -->
                    <div class="hero-stats" style="display:flex; gap:36px; margin-top:44px; flex-wrap:wrap;">
                        <div>
                            <p style="font-family:'Poppins',sans-serif; font-size:28px; font-weight:800; margin:0;">500+</p>
                            <p style="font-size:12px; color:#9CA3AF; margin:4px 0 0; font-weight:500;">Menu Items</p>
                        </div>
                        <div style="width:1px; background:rgba(255,255,255,0.15);"></div>
                        <div>
                            <p style="font-family:'Poppins',sans-serif; font-size:28px; font-weight:800; margin:0;">4.9★</p>
                            <p style="font-size:12px; color:#9CA3AF; margin:4px 0 0; font-weight:500;">Avg Rating</p>
                        </div>
                        <div style="width:1px; background:rgba(255,255,255,0.15);"></div>
                        <div>
                            <p style="font-family:'Poppins',sans-serif; font-size:28px; font-weight:800; margin:0;">10K+</p>
                            <p style="font-size:12px; color:#9CA3AF; margin:4px 0 0; font-weight:500;">Happy Customers</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    

    <!-- ══════════════════════════════════════
         QR CODE SECTION
    ══════════════════════════════════════ -->
    {{-- <section style="padding:80px 0; background:rgba(245, 240, 232, 0.95);">
        <div style="max-width:1280px; margin:auto; padding:0 24px;">
            <div class="qr-wrapper" style="display:grid; grid-template-columns:1.2fr 0.8fr; gap:56px; align-items:center;">

                <!-- LEFT -->
                <div>
                    <span
                        style="background:#FFE7E0; color:#C25A2A; padding:7px 18px; border-radius:50px; font-size:12px; font-weight:700; display:inline-block; margin-bottom:18px; font-family:'Poppins',sans-serif; letter-spacing:.04em;">
                        Scan & Order
                    </span>
                    <h2 class="qr-title section-title"
                        style="font-size:38px; line-height:1.2; font-weight:800; margin-bottom:18px; font-family:'Poppins',sans-serif; color:#111827; letter-spacing:-.5px;">
                        Scan QR Code<br>For Restaurant Menu
                    </h2>
                    <p style="color:#6B7280; font-size:16px; line-height:1.8; margin-bottom:32px; max-width:500px;">
                        Explore delicious meals, discover restaurants, and order food instantly by scanning the QR code.
                    </p>
                    <div style="display:flex; gap:20px; flex-wrap:wrap;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div
                                style="width:46px; height:46px; background:#C25A2A; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i data-lucide="utensils" style="width:20px; height:20px; color:#fff;"></i>
                            </div>
                            <div>
                                <h4 style="margin:0; font-size:15px; font-weight:700;">Premium Restaurants</h4>
                                <p style="margin:0; color:#6B7280; font-size:13px;">Top quality food</p>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div
                                style="width:46px; height:46px; background:#111827; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i data-lucide="clock-3" style="width:20px; height:20px; color:#fff;"></i>
                            </div>
                            <div>
                                <h4 style="margin:0; font-size:15px; font-weight:700;">Fast Ordering</h4>
                                <p style="margin:0; color:#6B7280; font-size:13px;">Instant menu access</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT QR CARD -->
                <div style="display:flex; justify-content:center;">
                    <div
                        style="background:#fff; padding:36px; border-radius:28px; box-shadow:0 20px 60px rgba(0,0,0,.09); text-align:center; border:1px solid #F1F1F1; max-width:340px; width:100%;">
                        <div
                            style="width:88px; height:88px; background:#FFF2EE; border-radius:22px; margin:0 auto 22px; display:flex; align-items:center; justify-content:center;">
                            <i data-lucide="qr-code" style="width:42px; height:42px; color:#C25A2A;"></i>
                        </div>
                        <h3
                            style="font-size:24px; font-weight:800; margin-bottom:8px; font-family:'Poppins',sans-serif; color:#0D0D0D;">
                            Scan Me</h3>
                        <p style="color:#6B7280; font-size:14px; margin-bottom:24px;">Open restaurant menu instantly</p>
                        <div
                            style="background:#FAFAF8; padding:18px; border-radius:18px; display:inline-block; border:1px solid #F0F0EC;">
                            {!! $qrCode !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}

    @include('front.restaurants')

    <!-- ══════════════════════════════════════
         CATEGORIES
    ══════════════════════════════════════ -->
    <!-- <section id="categories" style="max-width:1280px; margin:0 auto; padding:80px 24px;">
        <div
            style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:36px; flex-wrap:wrap; gap:12px;">
            <div>
                <p
                    style="color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; letter-spacing:.1em; text-transform:uppercase; margin:0 0 6px;">
                    Browse</p>
                <h2 class="section-title"
                    style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; margin:0; letter-spacing:-.4px;">
                    Food Categories</h2>
            </div>
            <p style="color:#6B7280; font-size:14px; margin:0;">Choose your favorite category</p>
        </div>

        <div class="categories-grid" style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px;">
            @foreach($categories as $category)
                <a href="/category/{{ $category->id }}"
                    style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.06); text-decoration:none; transition:all .22s; display:flex; align-items:center; justify-content:center; padding:20px 16px; border:1px solid #F0F0EC;"
                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,.12)'; this.style.borderColor='#C25A2A';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,.06)'; this.style.borderColor='#F0F0EC';">
                    <h3
                        style="font-family:'Poppins',sans-serif; font-weight:700; font-size:15px; margin:0; color:#0D0D0D; text-align:center;">
                        {{ $category->name }}
                    </h3>
                </a>
            @endforeach
        </div>
    </section> -->

    <!-- ══════════════════════════════════════
         FEATURED PRODUCTS
    ══════════════════════════════════════ -->
    <!-- <section id="products" style="background:#fff; padding:80px 0;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div
                style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:36px; flex-wrap:wrap; gap:12px;">
                <div>
                    <p
                        style="color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; letter-spacing:.1em; text-transform:uppercase; margin:0 0 6px;">
                        Today's Pick</p>
                    <h2 class="section-title"
                        style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; margin:0; letter-spacing:-.4px;">
                        Featured Products</h2>
                </div>
                <p style="color:#6B7280; font-size:14px; margin:0;">Most popular dishes today</p>
            </div>

            <div class="products-grid" style="display:grid; grid-template-columns:repeat(4,1fr); gap:22px;">
                @foreach($products as $product)
                        <div style="background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,.07); border:1px solid #F0F0EC; transition:all .22s;"
                            onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,.12)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 16px rgba(0,0,0,.07)'">

                            <div style="position:relative; overflow:hidden;">
                                <img  src="{{ $product->image
                    ? asset('storage/' . $product->image)
                    : asset('default.png') }}"
                                    style="width:100%; height:210px; object-fit:cover; transition:transform .5s; display:block;"
                                    onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                <div style="position:absolute; top:12px; left:12px;" class="badge-primary">
                                    <span style="display:flex; align-items:center; gap:4px; font-size:11px;">
                                        <i data-lucide="star" style="width:11px; height:11px; fill:#fff;"></i> Featured
                                    </span>
                                </div>
                            </div>

                            <div style="padding:18px;">
                                <div
                                    style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px; gap:8px;">
                                    <h3
                                        style="font-family:'Poppins',sans-serif; font-weight:700; font-size:16px; margin:0; line-height:1.35; color:#0D0D0D;">
                                        {{ $product->name }}
                                    </h3>
                                    <span
                                        style="font-family:'Poppins',sans-serif; font-size:18px; font-weight:800; color:#C25A2A; white-space:nowrap;">
                                        £{{ $product->price }}
                                    </span>
                                </div>
                                <p style="color:#6B7280; font-size:13px; line-height:1.6; margin:0 0 16px;">
                                      {{ Str::limit(strip_tags($product->description), 80) }}
                                </p>
                                <div style="display:flex; gap:8px;">
                                    <a href="/product/{{ $product->id }}" class="btn-black"
                                        style="flex:1; text-align:center; padding:10px 0; font-size:13px; text-decoration:none;">View</a>
                                    <form method="POST" action="/cart/add" style="flex:1;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="current_url" value="{{ url()->current() }}">
                                        <button class="btn-primary"
                                            style="width:100%; padding:10px 0; font-size:13px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                                            <i data-lucide="shopping-cart" style="width:14px; height:14px;"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </section> -->

    <!-- ══════════════════════════════════════
         OFFER SECTION
    ══════════════════════════════════════ -->
    <section style="background:#0D0D0D; padding:80px 0; color:#fff;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div class="offer-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;">

                <div>
                    <div
                        style="display:inline-flex; align-items:center; gap:8px; background:rgba(232,55,14,0.15); border:1px solid rgba(232,55,14,0.3); padding:7px 16px; border-radius:999px; margin-bottom:22px;">
                        <i data-lucide="tag" style="width:14px; height:14px; color:#fff;"></i>
                        <span
                            style="font-size:12px; font-weight:700; color:#fff; font-family:'Poppins',sans-serif; letter-spacing:.05em;">Unlimited Offer</span>
                    </div>
                    <h2 class="offer-title"
                        style="font-family:'Poppins',sans-serif; font-size:48px; font-weight:800; line-height:1.2; margin:0 0 18px; letter-spacing:-.5px;">
                        Get <span style="color:#C25A2A;">Discount</span><br>On Your First Order
                    </h2>
                    <p style="color:#D1D5DB; font-size:16px; line-height:1.8; margin:0 0 32px; max-width:420px;">
                        Enjoy premium dishes from top restaurants. Fresh food, fast delivery, best experience guaranteed.
                    </p>
                    <a href="/restaurants" class="btn-primary"
                        style="padding:14px 30px; font-size:15px; display:inline-flex; align-items:center; gap:9px; text-decoration:none;">
                        <i data-lucide="shopping-bag" style="width:17px; height:17px;"></i> Order Food Now
                    </a>
                </div>

                <div class="offer-img" style="position:relative;">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=2081"
                        style="width:100%; border-radius:22px; box-shadow:0 24px 60px rgba(232,55,14,0.2); display:block;">
                    <div
                        style="position:absolute; top:-16px; right:-16px; width:76px; height:76px; border-radius:50%; background:#C25A2A; display:flex; flex-direction:column; align-items:center; justify-content:center; font-family:'Poppins',sans-serif; font-weight:800; color:#fff; font-size:14px; line-height:1.2; text-align:center; box-shadow:0 8px 24px rgba(232,55,14,.5);">
                        30%<br><span style="font-size:10px; font-weight:600;">OFF</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════
         WHY CHOOSE US
    ══════════════════════════════════════ -->
    <section style="max-width:1280px; margin:0 auto; padding:80px 24px; background:rgba(245, 240, 232, 0.95);">
        <div style="text-align:center; margin-bottom:52px;">
            <p
                style="color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; letter-spacing:.1em; text-transform:uppercase; margin:0 0 8px;">
                Our Promise</p>
            <h2 class="section-title"
                style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; margin:0 0 10px; letter-spacing:-.4px;">
                Why Choose Us</h2>
            <p style="color:#6B7280; font-size:15px; margin:0;">Best quality food and delivery service</p>
        </div>

        <div class="features-grid" style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px;">
            @php
                $features = [
                    ['icon' => 'leaf', 'title' => 'Fresh Food', 'desc' => 'High quality fresh ingredients sourced daily from local farms.', 'color' => '#16A34A'],
                    ['icon' => 'truck', 'title' => 'Fast Delivery', 'desc' => 'Quick and safe delivery right at your doorstep in 30 minutes.', 'color' => '#2563EB'],
                    ['icon' => 'shield-check', 'title' => 'Secure Payment', 'desc' => '100% secure online payment with end-to-end encryption.', 'color' => '#7C3AED'],
                    ['icon' => 'star', 'title' => 'Best Quality', 'desc' => 'Premium taste with excellent 5-star customer service always.', 'color' => '#C25A2A'],
                ];
            @endphp
            @foreach($features as $f)
                <div class="card"
                    style="padding:30px 22px; text-align:center; transition:transform .22s; border:1px solid #F0F0EC;"
                    onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="width:58px; height:58px; background:{{ $f['color'] }}18; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
                        <i data-lucide="{{ $f['icon'] }}" style="width:26px; height:26px; color:{{ $f['color'] }};"></i>
                    </div>
                    <h3
                        style="font-family:'Poppins',sans-serif; font-size:17px; font-weight:700; margin:0 0 10px; color:#0D0D0D;">
                        {{ $f['title'] }}</h3>
                    <p style="color:#6B7280; font-size:13px; line-height:1.7; margin:0;">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
    

{{-- <button onclick="testNotification()">
    Test Notification Permission
</button>

<script>
    async function testNotification() {

        alert("Notification API: " + ('Notification' in window));

        if (!('Notification' in window)) {
            alert("Notifications not supported");
            return;
        }

        const permission = await Notification.requestPermission();

        alert("Permission: " + permission);

        alert(
            "Standalone: " +
            window.matchMedia('(display-mode: standalone)').matches
        );
    }
</script> --}}
@endsection