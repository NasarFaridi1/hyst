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

@endphp

{{-- ===== DESKTOP SIDEBAR ===== --}}
<div class="desk-sidebar">
    <div style="text-align:center;">
        <div class="ds-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div class="ds-name">{{ auth()->user()->name }}</div>
        <div class="ds-email">{{ auth()->user()->email }}</div>
        <div style="text-align:center;"><span class="ds-role">{{ auth()->user()->role }}</span></div>
    </div>
    <hr class="ds-divider">
    <nav>
        <a href="/dashboard" class="ds-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="/profile" class="ds-link {{ request()->is('profile') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            My Profile
        </a>
        <a href="/my-orders" class="ds-link {{ request()->is('my-orders*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M3 6h2l3.5 9h9L21 6H8"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
            My Orders
        </a>
        <a href="/transactions" class="ds-link {{ request()->is('transactions') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
            My Transactions
        </a>
        <a href="/cart" class="ds-link {{ request()->is('cart') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.98 1.61h9.72a2 2 0 001.95-1.56L23 6H6"/></svg>
            Cart
        </a>
        <a href="{{ route('favorite.restaurants') }}"
        class="ds-link {{ request()->routeIs('favorite.restaurants') ? 'active' : '' }}">

            <svg viewBox="0 0 24 24">
                <path d="M12 21s-7-4.35-10-9a6 6 0 0110-7 6 6 0 0110 7c-3 4.65-10 9-10 9z"/>
            </svg>

            Favorite Restaurants

            @if($favoriteCount > 0)
                <span style="
                    margin-left:auto;
                    background:#E63946;
                    color:#fff;
                    font-size:11px;
                    font-weight:700;
                    padding:2px 8px;
                    border-radius:999px;
                ">
                    {{ $favoriteCount }}
                </span>
            @endif

        </a>
        <hr class="ds-divider" style="margin:10px 0;">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="ds-logout">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>
    </nav>
</div>

{{-- ===== MOBILE BOTTOM NAV ===== --}}
<div class="mob-nav">
    <div class="mob-nav-inner">
        <a href="/dashboard" class="mob-nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
            <span class="mob-dot"></span>
        </a>
        
        <a href="/my-orders" class="mob-nav-item {{ request()->is('my-orders*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M3 6h2l3.5 9h9L21 6H8"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
            Orders
            <span class="mob-dot"></span>
        </a>
        {{-- <a href="/cart" class="mob-nav-item {{ request()->is('cart') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.98 1.61h9.72a2 2 0 001.95-1.56L23 6H6"/></svg>
            Cart
            <span class="mob-dot"></span>
        </a> --}}

        <a href="{{ route('favorite.restaurants') }}"
        class="mob-nav-item {{ request()->routeIs('favorite.restaurants') ? 'active' : '' }}">

            <svg viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">

                <path d="M12 21s-7-4.35-10-9a6 6 0 0110-7 6 6 0 0110 7c-3 4.65-10 9-10 9z"/>

            </svg>

            Favorites

            @if($favoriteCount > 0)
                <span class="mob-count">
                    {{ $favoriteCount }}
                </span>
            @endif

            <span class="mob-dot"></span>

        </a>
        
        
        <a href="/transactions" class="mob-nav-item {{ request()->is('transactions') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
            Wallet
            <span class="mob-dot"></span>
        </a>
        <a href="/profile" class="mob-nav-item {{ request()->is('profile') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profile
            <span class="mob-dot"></span>
        </a>
    </div>
</div>