<style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

        /* ===== MOBILE NAV BAR (bottom, visible <768px) ===== */
        .mob-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #fff;
            border-top: 1px solid #F0EEE9;
            z-index: 9999;
            padding: 6px 0 calc(6px + env(safe-area-inset-bottom));
            box-shadow: 0 -4px 20px rgba(0,0,0,.07);
        }
        .mob-nav-inner {
            display: flex;
            justify-content: space-around;
            align-items: stretch;
        }
        .mob-nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            padding: 6px 4px;
            text-decoration: none;
            color: #9CA3AF;
            font-family: 'DM Sans', sans-serif;
            font-size: 10px;
            font-weight: 600;
            border-radius: 12px;
            transition: color .2s;
            cursor: pointer;
            background: none;
            border: none;
        }
        .mob-nav-item svg { width: 22px; height: 22px; stroke: currentColor; stroke-width: 1.8; fill: none; }
        .mob-nav-item.active { color: #E63946; }
        .mob-nav-item .mob-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: #E63946;
            display: none;
        }
        .mob-nav-item.active .mob-dot { display: block; }

        /* ===== DESKTOP SIDEBAR ===== */
        .desk-sidebar {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #E8E6E0;
            padding: 24px 20px;
            position: sticky;
            top: 90px;
            font-family: 'DM Sans', sans-serif;
        }
        .ds-avatar {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: #E63946;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800; font-size: 24px; color: #fff;
            margin: 0 auto;
        }
        .ds-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700; font-size: 17px;
            color: #111; text-align: center;
            margin: 12px 0 4px;
        }
        .ds-email { font-size: 13px; color: #9CA3AF; text-align: center; }
        .ds-role {
            display: inline-block;
            margin: 10px auto 0;
            background: #FFF5F3; color: #E63946;
            font-size: 11px; font-weight: 700;
            padding: 4px 14px; border-radius: 999px;
            text-transform: capitalize;
        }
        .ds-divider { border: none; border-top: 1px solid #F0EEE9; margin: 18px 0; }
        .ds-link {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px;
            border-radius: 14px;
            text-decoration: none;
            color: #6B7280;
            font-size: 14px; font-weight: 600;
            transition: all .18s;
            margin-bottom: 2px;
        }
        .ds-link svg { width: 17px; height: 17px; stroke: currentColor; stroke-width: 1.8; fill: none; flex-shrink: 0; }
        .ds-link:hover { background: #FFF5F3; color: #E63946; }
        .ds-link.active { background: #FFF5F3; color: #E63946; }
        .ds-logout {
            width: 100%; background: none; border: none; cursor: pointer;
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px; border-radius: 14px;
            color: #E63946; font-size: 14px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            transition: background .18s;
            margin-top: 2px;
        }
        .ds-logout svg { width: 17px; height: 17px; stroke: currentColor; stroke-width: 1.8; fill: none; flex-shrink: 0; }
        .ds-logout:hover { background: #FFF5F3; }

        @media(max-width: 767px) {
            .desk-sidebar { display: none; }
            .mob-nav { display: block; }
        }
</style>

@php

    $favoriteCount = auth()->check()
        ? \App\Models\RestaurantFavorite::where(
            'user_id',
            auth()->id()
        )->count()
        : 0;
    $cartCount = collect(session('cart', []))->sum('quantity');

@endphp


{{-- ===== MOBILE BOTTOM NAV ===== --}}
<div class="mob-nav">
    <div class="mob-nav-inner">
        <a href="/" class="mob-nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Home
            <span class="mob-dot"></span>
        </a>
        
        <a href="/cart" class="mob-nav-item {{ request()->is('cart') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 001.98 1.61h9.72a2 2 0 001.95-1.56L23 6H6"/>
            </svg>

            Cart

            <span id="bottomBarCartCount" class="cart-count-badge" style="
                background:#C25A2A;
                color:#fff;
                padding:2px 8px;
                border-radius:20px;
                font-size:11px;
                margin-left:5px;
                display: {{ $cartCount > 0 ? 'inline-flex' : 'none' }};
            ">
                {{ $cartCount }}
            </span>

            <span class="mob-dot"></span>
        </a>

    </div>
</div>