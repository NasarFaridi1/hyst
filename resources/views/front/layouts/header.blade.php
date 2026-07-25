
@php
    $isAdmin = auth()->check() &&
        in_array(auth()->user()->role, ['super_admin', 'restaurant_admin']);
    $isRestaurant = auth()->check() && auth()->user()->role == 'restaurant_admin'; 
    $isSuperAdmin = auth()->check() && auth()->user()->role == 'super_admin';   
@endphp
@php
    session([
        'login_redirect' => request()->getRequestUri()
    ]);
@endphp
<header style="background:rgba(245, 240, 232, 0.95); box-shadow:0 1px 0 #F0F0EC; position:sticky; top:0; z-index:100;">
    <div style=" margin:0 auto; padding:0 24px;" class="mx-auto max-w-7xl">
        <div style="display:flex; align-items:center; justify-content:space-between; height:68px;">

            <!-- LOGO -->
            <a href="/" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
                <div
                    style="width:38px; height:38px; background:#C25A2A; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i data-lucide="utensils" style="color:#fff; width:20px; height:20px;"></i>
                </div>
                <span
                    style="font-family:'Poppins',sans-serif; font-weight:800; font-size:20px; color:#0D0D0D; letter-spacing:-.3px;">
                    HYST
                </span>
            </a>

            <!-- DESKTOP NAV -->
            <nav class="desktop-nav" style="align-items:center; gap:4px;">
                <a href="/"
                    style="padding:8px 15px; border-radius:10px; font-weight:500; font-size:14px; color:#0D0D0D; text-decoration:none; transition:background .18s;"
                    onmouseover="this.style.background='#F5F5F0'"
                    onmouseout="this.style.background='transparent'">Home</a>

                {{-- <a href="/restaurants"
                    style="padding:8px 15px; border-radius:10px; font-weight:500; font-size:14px; color:#0D0D0D; text-decoration:none; display:flex; align-items:center; gap:6px; transition:background .18s;"
                    onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='transparent'">
                    <i data-lucide="package" style="width:16px; height:16px;"></i> Restaurants
                </a> --}}




                @auth
                @if(!$isAdmin)
                    <a href="/cart"
                        
                        style="padding:8px 15px; border-radius:10px; font-weight:500; font-size:14px; color:#0D0D0D; text-decoration:none; display:flex; align-items:center; gap:6px; transition:background .18s;"
                        onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="shopping-cart" style="width:16px; height:16px;"></i> Cart
                        <span id="cartCount" style="
                        background:#C25A2A;
                        color:white;
                        padding:2px 8px;
                        border-radius:20px;
                        font-size:12px;
                        margin-left:5px;
                        ">

                            {{ collect(session('cart', []))->sum('quantity') }}

                        </span>
                    </a>
                    <a href="/my-orders"
                        style="padding:8px 15px; border-radius:10px; font-weight:500; font-size:14px; color:#0D0D0D; text-decoration:none; display:flex; align-items:center; gap:6px; transition:background .18s;"
                        onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="package" style="width:16px; height:16px;"></i> Orders
                    </a>

                @endif


                    <!-- USER DROPDOWN -->
                    {{-- <div style="position:relative;"
                        onmouseenter="document.getElementById('userDropdown').style.display='block'"
                        onmouseleave="document.getElementById('userDropdown').style.display='none'"> --}}
                    <div style="position:relative;" id="userDropdownWrapper">
                        {{-- <button
                            style="display:flex; align-items:center; gap:9px; background:#F5F5F0; border:none; padding:7px 13px 7px 7px; border-radius:12px; cursor:pointer; transition:background .18s;"
                            onmouseover="this.style.background='#EBEBEB'" onmouseout="this.style.background='#F5F5F0'">
                            <div class="avatar" style="width:34px; height:34px; font-size:14px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div style="text-align:left;">
                                <p
                                    style="font-family:'Poppins',sans-serif; font-weight:700; font-size:13px; margin:0; line-height:1.3;">
                                    {{ auth()->user()->name }}
                                </p>
                                <p style="font-size:10px; color:#6B7280; margin:0; text-transform:capitalize;">
                                    {{ auth()->user()->role }}
                                </p>
                            </div>
                            <i data-lucide="chevron-down" style="width:14px; height:14px; color:#6B7280;"></i>
                        </button> --}}

                        <button
                            onclick="toggleUserDropdown(event)"
                            style="display:flex; align-items:center; gap:9px; background:#F5F5F0; border:none; padding:7px 13px 7px 7px; border-radius:12px; cursor:pointer; transition:background .18s;"
                            onmouseover="this.style.background='#EBEBEB'"
                            onmouseout="this.style.background='#F5F5F0'">

                            <div class="avatar" style="width:34px; height:34px; font-size:14px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <div style="text-align:left;">
                                <p style="font-family:'Poppins',sans-serif; font-weight:700; font-size:13px; margin:0; line-height:1.3;">
                                    {{ auth()->user()->name }}
                                </p>

                                <p style="font-size:10px; color:#6B7280; margin:0; text-transform:capitalize;">
                                    {{ auth()->user()->role }}
                                </p>
                            </div>

                            <i data-lucide="chevron-down" style="width:14px; height:14px; color:#6B7280;"></i>
                        </button>

                        

                

                        {{-- <div id="userDropdown"
                            style="display:none; position:absolute; right:0; top:100%; margin-top:8px; width:210px; background:#fff; border-radius:16px; box-shadow:0 16px 48px rgba(0,0,0,.14); overflow:hidden; z-index:200; border:1px solid #F0F0EC;">
                             --}}
                            <div id="userDropdown"
                                style="display:none; position:absolute; right:0; top:100%; margin-top:8px; width:210px; background:#fff; border-radius:16px; box-shadow:0 16px 48px rgba(0,0,0,.14); overflow:hidden; z-index:200; border:1px solid #F0F0EC;">
                            
                            @if($isSuperAdmin)    
                            <a href="/admin/dashboard"
                                style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                                onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                                <i data-lucide="layout-dashboard" style="width:15px; height:15px; color:#C25A2A;"></i>
                                Dashboard
                            </a>
                            @endif
                            @if($isRestaurant)    
                            <a href="/restaurant/dashboard"
                                style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                                onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                                <i data-lucide="layout-dashboard" style="width:15px; height:15px; color:#C25A2A;"></i>
                                Dashboard
                            </a>
                            @endif
                            @if(!$isAdmin)    
                            <a href="/dashboard"
                                style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                                onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                                <i data-lucide="layout-dashboard" style="width:15px; height:15px; color:#C25A2A;"></i>
                                Dashboard
                            </a>
                            
                            <a href="/profile"
                                style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                                onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                                <i data-lucide="user" style="width:15px; height:15px; color:#C25A2A;"></i> My Profile
                            </a>
                            <a href="/my-orders"
                                style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                                onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                                <i data-lucide="package" style="width:15px; height:15px; color:#C25A2A;"></i> My Orders
                            </a>
                            <a href="{{ route('favorite.restaurants') }}"
                                 style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                                onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                                <i data-lucide="heart" style="width:15px; height:15px; color:#C25A2A;"></i>
                                Favorite Restaurants
                            </a>
                            {{-- <a href="/cart">

                                <i data-lucide="shopping-cart"></i>

                                Cart

                                <span id="cartCount" style="
                                    background:#C25A2A;
                                    color:white;
                                    padding:2px 8px;
                                    border-radius:20px;
                                    font-size:12px;
                                    margin-left:5px;
                                    ">

                                    {{ collect(session('cart', []))->sum('quantity') }}

                                </span>

                            </a> --}}
                            <a href="/cart"
                                style="
                                    display:flex;
                                    align-items:center;
                                    gap:10px;
                                    padding:13px 17px;
                                    text-decoration:none;
                                    color:#0D0D0D;
                                    font-size:13px;
                                    font-weight:500;
                                    transition:background .15s;
                                "
                                onmouseover="this.style.background='#F5F5F0'"
                                onmouseout="this.style.background='#fff'">

                                <i data-lucide="shopping-cart"
                                    style="width:15px; height:15px; color:#C25A2A;">
                                </i>

                                <span>Cart</span>

                                <span id="cartCount"
                                    style="
                                        background:#C25A2A;
                                        color:white;
                                        min-width:20px;
                                        height:20px;
                                        border-radius:999px;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        font-size:11px;
                                        font-weight:700;
                                        margin-left:auto;
                                        padding:0 6px;
                                    ">

                                    {{ collect(session('cart', []))->sum('quantity') }}


                                </span>

                            </a>
                            @endif
                            <div style="border-top:1px solid #F0F0EC; margin:4px 0;"></div>
                            <form method="POST" action="/logout">
                                @csrf
                                <button
                                    style="display:flex; align-items:center; gap:10px; padding:13px 17px; width:100%; background:none; border:none; cursor:pointer; font-size:13px; font-weight:600; color:#C25A2A; transition:background .15s; font-family:'Poppins',sans-serif;"
                                    onmouseover="this.style.background='#FFF0EC'"
                                    onmouseout="this.style.background='transparent'">
                                    <i data-lucide="log-out" style="width:15px; height:15px;"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- <a href="https://business.hyst.uk/" class="btn-primary"
                            style="padding:9px 18px; font-size:13px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                            <i data-lucide="building-2" style="width:15px; height:15px;"></i> Main Website
                    </a>
                    <a href="{{ route('front.banners.index') }}" class="btn-primary"
                            style="padding:9px 18px; font-size:13px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                            <i data-lucide="building-2" style="width:15px; height:15px;"></i> Business
                    </a> --}}
                @endauth

                @guest
                    <a href="/cart"
                        
                        style="padding:8px 15px; border-radius:10px; font-weight:500; font-size:14px; color:#0D0D0D; text-decoration:none; display:flex; align-items:center; gap:6px; transition:background .18s;"
                        onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="shopping-cart" style="width:16px; height:16px;"></i> Cart
                        <span id="cartCount" style="
                        background:#C25A2A;
                        color:white;
                        padding:2px 8px;
                        border-radius:20px;
                        font-size:12px;
                        margin-left:5px;
                        ">

                            {{ collect(session('cart', []))->sum('quantity') }}

                        </span>
                    </a>
                    {{-- <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn-black" --}}
                        {{-- <a href="{{ route('login', ['redirect' => urlencode(url()->full())]) }}" class="btn-black"
                            style="padding:9px 18px; font-size:13px; margin-left:4px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                            <i data-lucide="log-in" style="width:15px; height:15px;"></i> Login/Register
                        </a> --}}
                        
                        <a href="{{ route('login') }}" class="btn-black"
                            style="padding:9px 18px; font-size:13px; margin-left:4px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                            <i data-lucide="log-in" style="width:15px; height:15px;"></i> Login/Register
                        </a>
                        
                    {{-- <a href="/register" class="btn-primary"
                        style="padding:9px 18px; font-size:13px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                        <i data-lucide="user-plus" style="width:15px; height:15px;"></i> Register
                    </a> --}}
                    {{-- <a href="https://business.hyst.uk/" class="btn-primary"
                        style="padding:9px 18px; font-size:13px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                        <i data-lucide="building-2" style="width:15px; height:15px;"></i> Main Website
                    </a>
                    <a href="{{ route('front.banners.index') }}" class="btn-primary"
                        style="padding:9px 18px; font-size:13px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                        <i data-lucide="building-2" style="width:15px; height:15px;"></i> Business
                    </a> --}}
                @endguest
            </nav>

            @php
                $cartCount = collect(session('cart', []))->sum('quantity');
            @endphp
            <style>
                .mob-nav-item svg { width: 22px; height: 22px; stroke: currentColor; stroke-width: 1.8; fill: none; }
                .mob-nav-item.active { color: #E63946; }
                .mob-nav-item .mob-dot {
                    width: 5px; height: 5px;
                    border-radius: 50%;
                    background: #E63946;
                    display: none;
                }
                .mobile-toggle-nav {
                    display: none;
                }

                .mob-nav-item {
                    display: none;
                }
                @media(max-width:992px) {
                    .mobile-toggle-nav {
                        display: flex !important;
                        align-items:center; gap:4px;
                    }
                    .mob-nav-item {
                        display: flex;
                        align-items:center; gap:4px;
                    }
                }
            </style>

            <!-- MOBILE TOGGLE -->
            <div  class="mobile-toggle-nav">
                <a href="/cart" class="mob-nav-item {{ request()->is('cart') ? 'active' : '' }}">
    
                    <span style="position:relative; display:inline-block;">
                        <svg viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 001.98 1.61h9.72a2 2 0 001.95-1.56L23 6H6"/>
                        </svg>

                        @if($cartCount > 0)
                            <span id="cartCount"
                                style="
                                    position:absolute;
                                    top:-8px;
                                    right:-10px;
                                    min-width:18px;
                                    height:18px;
                                    background:#C25A2A;
                                    color:#fff;
                                    border-radius:50%;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-size:10px;
                                    font-weight:700;
                                    line-height:1;
                                    padding:0 4px;
                                    border:2px solid #fff;
                                ">
                                {{ collect(session('cart', []))->sum('quantity') }}
                            </span>
                        @endif
                    </span>

                </a>
            <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Menu">
                <i data-lucide="menu" style="width:22px; height:22px;"></i>
            </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">
        {{-- <a href="/"><i data-lucide="home" style="width:18px; height:18px; color:#C25A2A;"></i> Home</a> --}}
        {{-- <a href="/restaurants"><i data-lucide="package" style="width:18px; height:18px; color:#C25A2A;"></i>
            Restaurants</a> --}}

        @auth
            @if($isSuperAdmin)    
                <a href="/admin/dashboard"
                    style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                    onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                    <i data-lucide="layout-dashboard" style="width:15px; height:15px; color:#C25A2A;"></i>
                    Dashboard
                </a>
            @endif
            @if($isRestaurant)    
                <a href="/restaurant/dashboard"
                    style="display:flex; align-items:center; gap:10px; padding:13px 17px; text-decoration:none; color:#0D0D0D; font-size:13px; font-weight:500; transition:background .15s;"
                    onmouseover="this.style.background='#F5F5F0'" onmouseout="this.style.background='#fff'">
                    <i data-lucide="layout-dashboard" style="width:15px; height:15px; color:#C25A2A;"></i>
                    Dashboard
                </a>
            @endif

            @if(!$isSuperAdmin && !$isRestaurant)

                    <a href="/cart" style="
                        display:flex;
                        align-items:center;
                        gap:10px;
                        position:relative;
                        ">

                        <i data-lucide="shopping-cart" style="
                        width:18px;
                        height:18px;
                        color:#C25A2A;
                        ">
                        </i>

                        Cart

                        <span id="mobileCartCount" style="
                        background:#C25A2A;
                        color:#fff;
                        min-width:22px;
                        height:22px;
                        padding:0 7px;
                        border-radius:999px;

                        display:flex;
                        align-items:center;
                        justify-content:center;

                        font-size:11px;
                        font-weight:700;
                        margin-left:auto;
                        ">

                            {{ collect(session('cart', []))->sum('quantity') }}

                        </span>

                    </a>
                    <a href="/my-orders"><i data-lucide="package" style="width:18px; height:18px; color:#C25A2A;"></i> My Orders</a>
                    <a href="/dashboard"><i data-lucide="layout-dashboard" style="width:18px; height:18px; color:#C25A2A;"></i>
                        Dashboard</a>
                    <a href="/profile"><i data-lucide="user" style="width:18px; height:18px; color:#C25A2A;"></i> My Profile</a>
                    {{-- <a href="https://business.hyst.uk/"><i data-lucide="building-2" style="width:18px; height:18px; color:#C25A2A;"></i>Main Website</a>
                    <a href="{{ route('front.banners.index') }}"><i data-lucide="building-2" style="width:18px; height:18px; color:#C25A2A;"></i>Business</a> --}}


                    <form method="POST" action="/logout" style="border-bottom:none;">
                        @csrf
                        <button
                            style="display:flex; align-items:center; gap:10px; width:100%; background:none; border:none; padding:13px 0; font-size:14px; font-weight:600; color:#C25A2A; cursor:pointer; font-family:'Poppins',sans-serif; border-bottom:none;">
                            <i data-lucide="log-out" style="width:18px; height:18px;"></i> Logout
                        </button>
                    </form>
            @endif        
        @endauth

        @guest
            <a href="/login"><i data-lucide="log-in" style="width:18px; height:18px; color:#C25A2A;"></i> Login/Register</a>
            {{-- <a href="/register"><i data-lucide="user-plus" style="width:18px; height:18px; color:#C25A2A;"></i> Register</a> --}}
            {{-- <a href="https://business.hyst.uk/"><i data-lucide="building-2" style="width:18px; height:18px; color:#C25A2A;"></i>Main Website</a>
            <a href="{{ route('front.banners.index') }}"><i data-lucide="building-2" style="width:18px; height:18px; color:#C25A2A;"></i>Business</a>
 --}}

        @endguest
    </div>
</header>

{{-- <script>
    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('active');
    }
</script> --}}

<script>
    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('active');
    }

    function toggleUserDropdown(event) {
        event.stopPropagation();

        const dropdown = document.getElementById('userDropdown');

        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        } else {
            dropdown.style.display = 'block';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {

        const wrapper = document.getElementById('userDropdownWrapper');

        if (!wrapper.contains(event.target)) {
            document.getElementById('userDropdown').style.display = 'none';
        }
    });
</script>

