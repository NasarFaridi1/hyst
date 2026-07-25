
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
                    <div style="position:relative;" id="userDropdownWrapper">

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

                    <button onclick="openPartnerModal()" type="button"
                        style="padding:8px 15px; border-radius:10px; font-weight:600; font-size:14px; color:#C25A2A; background:#FFF5F0; border:1px solid #FCD9C8; cursor:pointer; display:flex; align-items:center; gap:6px; transition:all .18s; font-family:'Poppins',sans-serif; margin-left:6px;"
                        onmouseover="this.style.background='#C25A2A'; this.style.color='#ffffff';"
                        onmouseout="this.style.background='#FFF5F0'; this.style.color='#C25A2A';">
                        <i data-lucide="handshake" style="width:16px; height:16px;"></i> Become a partner
                    </button>
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
                        
                    <a href="{{ route('login') }}" class="btn-black"
                        style="padding:9px 18px; font-size:13px; margin-left:4px; display:flex; align-items:center; gap:7px; text-decoration:none;">
                        <i data-lucide="log-in" style="width:15px; height:15px;"></i> Login/Register
                    </a>

                    <button onclick="openPartnerModal()" type="button"
                        style="padding:8px 15px; border-radius:10px; font-weight:600; font-size:14px; color:#C25A2A; background:#FFF5F0; border:1px solid #FCD9C8; cursor:pointer; display:flex; align-items:center; gap:6px; transition:all .18s; font-family:'Poppins',sans-serif; margin-left:6px;"
                        onmouseover="this.style.background='#C25A2A'; this.style.color='#ffffff';"
                        onmouseout="this.style.background='#FFF5F0'; this.style.color='#C25A2A';">
                        <i data-lucide="handshake" style="width:16px; height:16px;"></i> Become a partner
                    </button>
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
        @endguest

        <button onclick="openPartnerModal(); toggleMobileMenu();" type="button"
            style="display:flex; align-items:center; gap:10px; width:100%; background:none; border:none; padding:13px 0; font-size:14px; font-weight:600; color:#C25A2A; cursor:pointer; font-family:'Poppins',sans-serif; text-align:left; border-top:1px solid #F0F0EC; margin-top:4px;">
            <i data-lucide="handshake" style="width:18px; height:18px; color:#C25A2A;"></i> Become a partner
        </button>
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

        if (wrapper && !wrapper.contains(event.target)) {
            document.getElementById('userDropdown').style.display = 'none';
        }
    });

    function openPartnerModal() {
        const modal = document.getElementById('partnerModal');
        if (modal) {
            modal.style.display = 'flex';
            if (window.lucide) lucide.createIcons();
        }
    }

    function closePartnerModal() {
        const modal = document.getElementById('partnerModal');
        if (modal) {
            modal.style.display = 'none';
            document.getElementById('partnerForm').reset();
            selectPartnerType('Become Restaurant Partner');
            const alertBox = document.getElementById('partnerAlert');
            if (alertBox) alertBox.style.display = 'none';
        }
    }

    function selectPartnerType(type) {
        document.getElementById('partnerTypeInput').value = type;
        const btnRest = document.getElementById('btnTypeRestaurant');
        const btnAmb = document.getElementById('btnTypeAmbassador');

        if (type === 'Become Restaurant Partner' || type === 'Restaurant Partner') {
            btnRest.style.border = '2px solid #C25A2A';
            btnRest.style.background = '#FFF5F0';
            btnRest.style.color = '#C25A2A';

            btnAmb.style.border = '2px solid #E5E7EB';
            btnAmb.style.background = '#fff';
            btnAmb.style.color = '#4B5563';
        } else {
            btnAmb.style.border = '2px solid #C25A2A';
            btnAmb.style.background = '#FFF5F0';
            btnAmb.style.color = '#C25A2A';

            btnRest.style.border = '2px solid #E5E7EB';
            btnRest.style.background = '#fff';
            btnRest.style.color = '#4B5563';
        }
    }

    function submitPartnerForm(event) {
        event.preventDefault();
        const form = document.getElementById('partnerForm');
        const alertBox = document.getElementById('partnerAlert');
        const submitBtn = document.getElementById('btnSubmitPartner');
        const formData = new FormData(form);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Submitting...</span>';

        fetch('/become-a-partner', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Send Partner Request</span><i data-lucide="send" style="width:16px; height:16px;"></i>';
            if (window.lucide) lucide.createIcons();

            alertBox.style.display = 'block';
            if (data.success) {
                alertBox.style.background = '#DEF7EC';
                alertBox.style.color = '#03543F';
                alertBox.style.border = '1px solid #BCF0DA';
                alertBox.innerText = data.message;
                form.reset();
                selectPartnerType('Become Restaurant Partner');
                setTimeout(() => {
                    closePartnerModal();
                }, 3000);
            } else {
                alertBox.style.background = '#FDE8E8';
                alertBox.style.color = '#9B1C1C';
                alertBox.style.border = '1px solid #FBD5D5';
                alertBox.innerText = data.message || 'An error occurred. Please check your inputs.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Send Partner Request</span><i data-lucide="send" style="width:16px; height:16px;"></i>';
            if (window.lucide) lucide.createIcons();

            alertBox.style.display = 'block';
            alertBox.style.background = '#FDE8E8';
            alertBox.style.color = '#9B1C1C';
            alertBox.style.border = '1px solid #FBD5D5';
            alertBox.innerText = 'Failed to submit request. Please try again.';
        });
    }

    function sendViaWhatsApp(phone) {
        const form = document.getElementById('partnerForm');
        const partnerType = document.getElementById('partnerTypeInput').value;
        const name = form.elements['name'] ? form.elements['name'].value.trim() : '';
        const email = form.elements['email'] ? form.elements['email'].value.trim() : '';
        const phoneNum = form.elements['phone_number'] ? form.elements['phone_number'].value.trim() : '';
        const location = form.elements['location'] ? form.elements['location'].value.trim() : '';

        let text = `*HYST Partner Request*\n`;
        text += `• *Type:* ${partnerType}\n`;
        if (name) text += `• *Name:* ${name}\n`;
        if (email) text += `• *Email:* ${email}\n`;
        if (phoneNum) text += `• *Phone:* ${phoneNum}\n`;
        if (location) text += `• *Location:* ${location}\n`;

        const url = `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
        window.open(url, '_blank');
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('partnerModal');
        if (modal && event.target === modal) {
            closePartnerModal();
        }
    });
</script>

<!-- BECOME A PARTNER MODAL -->
<div id="partnerModal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.55); backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:16px;">
    <div style="background:#fff; border-radius:20px; width:100%; max-width:480px; box-shadow:0 20px 50px rgba(0,0,0,0.2); overflow:hidden; position:relative; animation: modalFadeIn 0.25s ease-out;">
        
        <!-- Modal Header -->
        <div style="display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid #F0F0EC; background:#FAF9F6;">
            <div>
                <h3 style="font-family:'Poppins',sans-serif; font-size:18px; font-weight:700; color:#0D0D0D; margin:0;">Become a Partner</h3>
                <p style="font-size:12px; color:#6B7280; margin:2px 0 0 0;">Register your request with HYST</p>
            </div>
            <button onclick="closePartnerModal()" type="button" style="background:none; border:none; cursor:pointer; color:#6B7280; padding:4px; border-radius:8px; display:flex; align-items:center; justify-content:center;" onmouseover="this.style.color='#0D0D0D'" onmouseout="this.style.color='#6B7280'">
                <i data-lucide="x" style="width:20px; height:20px;"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="partnerForm" onsubmit="submitPartnerForm(event)" style="padding:24px;">
            @csrf
            
            <!-- Alert Message Container -->
            <div id="partnerAlert" style="display:none; padding:12px 16px; border-radius:12px; font-size:13px; margin-bottom:16px; font-family:'Poppins',sans-serif;"></div>

            <!-- Partner Type Selection Buttons -->
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Choose Partner Type *</label>
            <input type="hidden" name="partner_type" id="partnerTypeInput" value="Become Restaurant Partner">
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:20px;">
                <button type="button" id="btnTypeRestaurant" onclick="selectPartnerType('Become Restaurant Partner')"
                    style="padding:12px 10px; border-radius:12px; border:2px solid #C25A2A; background:#FFF5F0; color:#C25A2A; font-weight:600; font-size:13px; cursor:pointer; display:flex; flex-direction:column; align-items:center; gap:6px; transition:all .18s; font-family:'Poppins',sans-serif;">
                    <i data-lucide="store" style="width:20px; height:20px;"></i>
                    <span>Become Restaurant Partner</span>
                </button>
                
                <button type="button" id="btnTypeAmbassador" onclick="selectPartnerType('Become an Ambassador')"
                    style="padding:12px 10px; border-radius:12px; border:2px solid #E5E7EB; background:#fff; color:#4B5563; font-weight:600; font-size:13px; cursor:pointer; display:flex; flex-direction:column; align-items:center; gap:6px; transition:all .18s; font-family:'Poppins',sans-serif;">
                    <i data-lucide="award" style="width:20px; height:20px;"></i>
                    <span>Become an Ambassador</span>
                </button>
            </div>

            <!-- Form Inputs -->
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:5px;">Full Name *</label>
                <input type="text" name="name" required placeholder="Enter your full name"
                    style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid #D1D5DB; font-size:14px; font-family:'Poppins',sans-serif; outline:none; box-sizing:border-box; transition:border .18s;"
                    onfocus="this.style.borderColor='#C25A2A'" onblur="this.style.borderColor='#D1D5DB'">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:5px;">Email Address *</label>
                <input type="email" name="email" required placeholder="name@example.com"
                    style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid #D1D5DB; font-size:14px; font-family:'Poppins',sans-serif; outline:none; box-sizing:border-box; transition:border .18s;"
                    onfocus="this.style.borderColor='#C25A2A'" onblur="this.style.borderColor='#D1D5DB'">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:5px;">Phone Number *</label>
                <input type="tel" name="phone_number" required placeholder="e.g. +44 7123 456789"
                    style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid #D1D5DB; font-size:14px; font-family:'Poppins',sans-serif; outline:none; box-sizing:border-box; transition:border .18s;"
                    onfocus="this.style.borderColor='#C25A2A'" onblur="this.style.borderColor='#D1D5DB'">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:5px;">Location / City *</label>
                <input type="text" name="location" required placeholder="Enter your city or area"
                    style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid #D1D5DB; font-size:14px; font-family:'Poppins',sans-serif; outline:none; box-sizing:border-box; transition:border .18s;"
                    onfocus="this.style.borderColor='#C25A2A'" onblur="this.style.borderColor='#D1D5DB'">
            </div>

            <!-- Submit Button -->
            <button type="submit" id="btnSubmitPartner"
                style="width:100%; padding:12px; border-radius:12px; background:#C25A2A; color:#fff; border:none; font-size:14px; font-weight:700; cursor:pointer; font-family:'Poppins',sans-serif; transition:background .18s; display:flex; align-items:center; justify-content:center; gap:8px;"
                onmouseover="this.style.background='#a84b20'" onmouseout="this.style.background='#C25A2A'">
                <span>Send Request via Email</span>
                <i data-lucide="send" style="width:16px; height:16px;"></i>
            </button>

            <!-- WhatsApp Quick Connect -->
            <div style="margin-top:16px; padding-top:16px; border-top:1px solid #F0F0EC; text-align:center;">
                <p style="font-size:12px; color:#6B7280; margin:0 0 10px 0; font-family:'Poppins',sans-serif;">Or send your request directly via WhatsApp:</p>
                
                <button type="button" onclick="sendViaWhatsApp('447879175585')"
                   style="width:100%; display:flex; align-items:center; justify-content:center; gap:8px; padding:11px 16px; border-radius:12px; background:#25D366; color:#fff; font-weight:700; font-size:13px; border:none; cursor:pointer; transition:background .18s; font-family:'Poppins',sans-serif;"
                   onmouseover="this.style.background='#20ba5a'"
                   onmouseout="this.style.background='#25D366'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.74.949 3.699 1.45 5.71 1.45h.005c6.554 0 11.89-5.335 11.893-11.893 0-3.18-1.238-6.167-3.487-8.414"/>
                    </svg>
                    <span>Connect on WhatsApp (+44 7879 175585)</span>
                </button>
            </div>        </form>
    </div>
</div>

<style>
@keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>

