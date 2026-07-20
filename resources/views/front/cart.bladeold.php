@extends('front.layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

.cart-page {
    background: rgba(245, 240, 232, 0.95);
    min-height: 100vh;
    padding: 32px 16px 100px;
    /* font-family: 'DM Sans', sans-serif; */
}
.cart-wrap {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    align-items: start;
}
.cart-card {
    background: #fff;
    border-radius: 24px;
    border: 1px solid #E8E6E0;
    padding: 28px 28px;
}
.cart-title {
    /* font-family: 'Syne', sans-serif; */
    font-size: 28px;
    font-weight: 700;
    color: #111;
    margin: 0 0 24px;
}

/* cart item */
.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 18px 0;
    border-bottom: 1px solid #F0EEE9;
}
.cart-item:last-of-type { border-bottom: none; }
.cart-item-img {
    width: 80px; height: 80px;
    border-radius: 16px;
    object-fit: cover;
    flex-shrink: 0;
    border: 1px solid #F0EEE9;
}
.cart-item-name {
    /* font-family: 'Syne', sans-serif; */
    font-size: 16px;
    font-weight: 700;
    color: #111;
    margin-bottom: 10px;
}
.qty-row {
    display: flex;
    align-items: center;
    gap: 0;
    border: 1.5px solid #E8E6E0;
    border-radius: 12px;
    overflow: hidden;
    width: fit-content;
}
.qty-btn {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    font-size: 18px; font-weight: 700;
    color: #111;
    transition: background .15s;
}
.qty-btn.minus { background: rgba(245, 240, 232, 0.95); }
.qty-btn.plus  { background: #E63946; color: #fff; }
.qty-btn.minus:hover { background: #E8E6E0; }
.qty-btn.plus:hover  { background: #c42d0b; }
.qty-num {
    min-width: 36px;
    text-align: center;
    font-size: 14px; font-weight: 700;
    color: #111;
    border-left: 1px solid #E8E6E0;
    border-right: 1px solid #E8E6E0;
    height: 32px; line-height: 32px;
}
.cart-item-price {
    /* font-family: 'Syne', sans-serif; */
    font-size: 17px;
    font-weight: 700;
    color: #E63946;
    white-space: nowrap;
    text-align: right;
}
.cart-remove {
    display: inline-block;
    margin-top: 8px;
    color: #9CA3AF;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: color .15s;
}
.cart-remove:hover { color: #E63946; }

/* total row */
.cart-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0 0;
    margin-top: 8px;
    border-top: 2px dashed #E8E6E0;
}
.cart-total-label {
    /* font-family: 'Syne', sans-serif; */
    font-size: 20px;
    font-weight: 700;
    color: #111;
}
.cart-total-value {
    /* font-family: 'Syne', sans-serif; */
    font-size: 26px;
    font-weight: 700;
    color: #E63946;
}
.checkout-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #E63946;
    color: #fff;
    border-radius: 14px;
    padding: 16px 32px;
    /* font-family: 'Syne', sans-serif; */
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    margin-top: 20px;
    transition: background .2s, transform .15s;
}
.checkout-btn:hover { background: #c42d0b; transform: translateY(-1px); }

/* empty */
.cart-empty {
    text-align: center;
    padding: 60px 20px;
}
.cart-empty-icon { font-size: 56px; margin-bottom: 16px; }
.cart-empty h3 {
    /* font-family: 'Syne', sans-serif; */
    font-size: 20px; font-weight: 700; color: #111; margin-bottom: 6px;
}
.cart-empty p { color: #9CA3AF; font-size: 14px; }

.mob-page-title {
    display: none;
    /* font-family: 'Syne', sans-serif; */
    font-size: 26px;
    font-weight: 700;
    color: #111;
    margin-bottom: 18px;
}

@media(max-width: 900px) { .cart-wrap { grid-template-columns: 1fr; } }
@media(max-width: 640px) {
    .cart-page { padding: 20px 14px 100px; }
    .mob-page-title { display: block; }
    .cart-card { padding: 20px 16px; }
    .cart-title { font-size: 22px; }
    .cart-item { flex-wrap: wrap; }
    .cart-item-img { width: 68px; height: 68px; }
    .checkout-btn { width: 100%; justify-content: center; }
}
</style>

<div class="cart-page">
    <div class="cart-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- CONTENT --}}
        <div>
            <div class="mob-page-title">My Cart</div>

            <div class="cart-card">
                <h1 class="cart-title">My Cart</h1>

                @php $total = 0; @endphp

                @forelse($cart as $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp

                    <div class="cart-item">
                        <div style="display:flex; align-items:center; gap:14px; flex:1; min-width:0;">
                            <img 
                            {{-- src="{{ asset('storage/' . $item['image']) }}"  --}}
                            src="{{ $item['image'] ? config('services.google_drive.image_url') . $item['image'] : asset('default.png') }}"
                            class="cart-item-img" alt="{{ $item['name'] }}">
                            <div style="flex:1; min-width:0;">
                                <div class="cart-item-name">
                                    {{ $item['name'] }}
                                    @if(!empty($item['variant_name']))
                                        <div style="font-size:13px;color:#6B7280;font-weight:500;">
                                            {{ $item['variant_name'] }}
                                        </div>
                                    @endif

                                </div>
                                <div class="qty-row">
                                    <a href="/cart/decrease/{{ $item['id'] }}" class="qty-btn minus">−</a>
                                    <span class="qty-num">{{ $item['quantity'] }}</span>
                                    <a href="/cart/increase/{{ $item['id'] }}" class="qty-btn plus">+</a>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:right; flex-shrink:0;">
                            <div class="cart-item-price">£{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                            <div style="font-size:12px; color:#9CA3AF; margin-top:2px;">£{{ number_format($item['price'],2) }} each</div>
                            <a href="/cart/remove/{{ $item['id'] }}" class="cart-remove">Remove ✕</a>
                        </div>
                    </div>

                @empty
                    <div class="cart-empty">
                        <div class="cart-empty-icon">🛒</div>
                        <h3>Cart is Empty</h3>
                        <p>Add some delicious items to get started!</p>
                    </div>
                @endforelse

                @if(count($cart) > 0)
                    <div class="cart-total-row">
                        <span class="cart-total-label">Total</span>
                        <span class="cart-total-value">£{{ number_format($total, 2) }}</span>
                    </div>
                    <a href="/checkout" class="checkout-btn">
                        Checkout
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection