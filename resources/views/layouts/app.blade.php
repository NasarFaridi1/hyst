<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HYST | Zero Commission Takeaway & Food Delivery Near Me | Dine In Hounslow & UK')</title>

    <meta name="title" content="@yield('title', 'HYST | Zero Commission Takeaway & Food Delivery Near Me | Dine In Hounslow & UK')">

    <meta name="description" content="@yield('meta_description', 'Find top takeaways, food delivery near me & dine in restaurants in Hounslow, TW3 & London UK. Order direct on HYST with zero commission & genuine menu prices.')">

    <meta name="keywords" content="@yield('keywords', 'takeaway near me, food delivery near me, dine in, order takeaway near me, food ordering platform Hounslow, takeaway Hounslow TW3, zero commission food delivery, HYST')">

    <meta name="author" content="HYST">
    <meta name="robots" content="@yield('robots', 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1')">
    <meta name="language" content="English">
    <meta name="theme-color" content="#C25A2A">

    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Geo -->
    <meta name="geo.region" content="GB-LND">
    <meta name="geo.placename" content="Hounslow">
    <meta name="geo.position" content="51.4686;-0.3618">
    <meta name="ICBM" content="51.4686,-0.3618">

    <!-- Open Graph -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:site_name" content="HYST">
    <meta property="og:locale" content="en_GB">

    <meta property="og:title" content="@yield('title', 'HYST | Zero Commission Food Ordering Platform UK | Order Direct from Restaurants')">

    <meta property="og:description" content="@yield('meta_description', 'HYST is the UK\'s zero commission food ordering platform. Order directly from local restaurants at genuine menu prices with no hidden markups.')">

    <meta property="og:image" content="@yield('og_image', asset('twitter.jpeg'))">
    <meta property="og:image:secure_url" content="@yield('og_image', asset('twitter.jpeg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="HYST - Zero Commission Food Ordering Platform">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="@yield('title', 'HYST | Zero Commission Food Ordering Platform UK | Order Direct from Restaurants')">

    <meta name="twitter:description" content="@yield('meta_description', 'HYST is the UK\'s zero commission food ordering platform. Order directly from local restaurants at genuine menu prices with no hidden markups.')">

    <meta name="twitter:image" content="@yield('og_image', asset('twitter.jpeg'))">
    <meta name="twitter:image:alt" content="HYST - Zero Commission Food Ordering Platform">

    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"Organization",
            "name":"HYST",
            "url":"https://hyst.uk",
            "logo":"https://hyst.uk/twitter.jpeg",
            "email":"info@hyst.uk",
            "telephone":"+44 7879 175585",
            "address":{
                "@type":"PostalAddress",
                "streetAddress":"Hounslow",
                "addressLocality":"London",
                "postalCode":"TW3 2DX",
                "addressCountry":"GB"
            },
            "sameAs":[
                "https://facebook.com/yourpage",
                "https://instagram.com/yourpage",
                "https://linkedin.com/company/hyst"
            ]
        }
    </script>

    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"WebSite",
            "name":"HYST",
            "url":"https://hyst.uk",
            "potentialAction":{
                "@type":"SearchAction",
                "target":"https://hyst.uk/search?q={search_term_string}",
                "query-input":"required name=search_term_string"
            }
        }
    </script>

    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"LocalBusiness",
            "name":"HYST",
            "image":"https://hyst.uk/twitter.jpeg",
            "telephone":"+44 7879 175585",
            "email":"info@hyst.uk",
            "address":{
                "@type":"PostalAddress",
                "addressLocality":"Hounslow",
                "addressRegion":"London",
                "postalCode":"TW3 2DX",
                "addressCountry":"United Kingdom"
            }
        }
    </script>

    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"SoftwareApplication",
            "name":"HYST",
            "applicationCategory":"BusinessApplication",
            "operatingSystem":"Web",
            "description":"Commission-free restaurant ordering platform in the UK."
        }
    </script>

    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"FAQPage",
            "mainEntity":[
                {
                    "@type":"Question",
                    "name":"Does HYST charge restaurant commission?",
                    "acceptedAnswer":{
                        "@type":"Answer",
                        "text":"No. HYST follows a zero commission model so restaurants keep more of their earnings."
                    }
                },
                {
                    "@type":"Question",
                    "name":"Why are HYST prices lower?",
                    "acceptedAnswer":{
                        "@type":"Answer",
                        "text":"Restaurants display their genuine menu prices because HYST does not charge high commissions."
                    }
                }
            ]
        }
    </script>

    @yield('ld_json')
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('twitter.jpeg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('twitter.jpeg') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/notification-sound.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    
       @laravelPWA

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #111827;
        }

        ::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 4px;
        }


        /* #sidebar {
            width: 260px;
            height: 100vh;
            background: #0D0D0D;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;

            /* IMPORTANT */

            overflow: hidden;
        } */

        /* #main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: rgba(245, 240, 232, 0.95);
        } */

        #main-content {
            margin-left: 0;
            min-height: 100vh;
            background: rgba(245,240,232,.95);
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #9CA3AF;
            text-decoration: none;
            transition: all .18s;
            margin: 2px 0;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
        }

        .nav-link.active {
            background: #C25A2A;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(232, 55, 14, .35);
        }

        .nav-link .nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* Alert */
        .alert-success {
            background: #DCFCE7;
            border: 1px solid #86EFAC;
            color: #15803D;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Mobile */
        /* #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 40;
        } */

        #sidebar-overlay{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.4);
            z-index:998;
            display:none;
        }

        #sidebar-overlay.active{
            display:block;
        }

        .mobile-menu-btn {
            display: none;
        }

        @media(max-width: 1024px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.open {
                transform: translateX(0);
            } */

            #main-content {
                margin-left: 0 !important;
            }

            .mobile-menu-btn {
                display: flex !important;
            }

            /* #sidebar-overlay.active {
                display: block;
            } */
        }
    </style>
</head>

<body>
    @include('partials.global_loader')

    {{-- <div id="sidebar-overlay" onclick="closeSidebar()"></div> --}}
    
    @include('layouts.sidebar')
    <div id="main-content">
        @include('layouts.navbar')

        <div style="padding: 28px 28px; background: rgba(245, 240, 232, 0.95); min-height: calc(100vh - 68px);">
            @if(session('success'))
                <div class="alert-success">
                    <i data-lucide="circle-check" style="width:18px; height:18px; flex-shrink:0;"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div
                    style="background:#FEE2E2; border:1px solid #FCA5A5; color:#DC2626; border-radius:12px; padding:14px 18px; margin-bottom:22px; font-size:14px; font-weight:500; display:flex; align-items:center; gap:10px;">
                    <i data-lucide="circle-x" style="width:18px; height:18px; flex-shrink:0;"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        lucide.createIcons();

        // function openSidebar() {
        //     document.getElementById('sidebar').classList.add('open');
        //     document.getElementById('sidebar-overlay').classList.add('active');
        // }
        // function closeSidebar() {
        //     document.getElementById('sidebar').classList.remove('open');
        //     document.getElementById('sidebar-overlay').classList.remove('active');
        // }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="module">

        import { initializeApp }

            from
            "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

        import {

            getMessaging,
            getToken,
            onMessage

        }

            from
            "https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging.js";

        const firebaseConfig = {

            apiKey:
                "{{ config('services.firebase.api_key') }}",

            authDomain:
                "{{ config('services.firebase.auth_domain') }}",

            projectId:
                "{{ config('services.firebase.project_id') }}",

            storageBucket:
                "{{ config('services.firebase.storage_bucket') }}",

            messagingSenderId:
                "{{ config('services.firebase.sender_id') }}",

            appId:
                "{{ config('services.firebase.app_id') }}",

            measurementId:
                "{{ config('services.firebase.measurement_id') }}"

        };

        const app =
            initializeApp(firebaseConfig);

        const messaging =
            getMessaging(app);

        async function registerAndSaveToken() {
            try {
                if (!('serviceWorker' in navigator)) return;
                const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
                const token = await getToken(messaging, {
                    vapidKey: "{{ config('services.firebase.vapid_key') }}",
                    serviceWorkerRegistration: registration
                });

                if (token) {
                    console.log('FCM TOKEN REFRESHED & SAVED:', token);
                    localStorage.setItem('fcm_token_saved', token);
                    localStorage.setItem('fcm_permission_granted', 'true');
                    fetch('/save-fcm-token', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ token: token })
                    });
                }
            } catch (err) {
                console.error('FCM Token Generation Error:', err);
            }
        }

        window.registerAndSaveToken = registerAndSaveToken;

        window.enablePushNotifications = async function(btn) {
            try {
                if (!('Notification' in window)) {
                    alert('Notifications are not supported on this browser.');
                    return;
                }
                const permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    localStorage.setItem('fcm_permission_granted', 'true');
                    await registerAndSaveToken();
                    if (btn) {
                        btn.innerHTML = '<i data-lucide="check" style="width:14px;height:14px;"></i> Alerts Active';
                        btn.style.background = '#16A34A';
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                    if (typeof window.playNotificationSound === 'function') {
                        window.playNotificationSound();
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Notifications Enabled! 🔔',
                            text: 'You will now receive instant sound & push alerts for new orders.',
                            confirmButtonColor: '#C25A2A'
                        });
                    }
                } else {
                    alert('Notification permission was blocked in browser settings.');
                }
            } catch (e) {
                console.error('Error enabling notifications:', e);
            }
        };

        window.refreshAndSaveNotificationToken = async function(btn) {
            try {
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = 'Refreshing Token...';
                }

                if (!('Notification' in window)) {
                    alert('Notifications are not supported on this browser.');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = 'Enable Notifications & Refresh Token';
                    }
                    return;
                }

                const permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    localStorage.setItem('fcm_permission_granted', 'true');
                    await registerAndSaveToken();

                    if (btn) {
                        btn.innerHTML = '✓ Notifications Active & Token Saved';
                        btn.style.background = '#16A34A';
                        btn.disabled = false;
                    }

                    if (typeof window.playNotificationSound === 'function') {
                        window.playNotificationSound();
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Token Refreshed & Saved! 🔔',
                            text: 'Your device FCM token has been updated and saved to your account.',
                            confirmButtonColor: '#C25A2A'
                        });
                    } else {
                        alert('Notifications enabled and token refreshed successfully!');
                    }
                } else {
                    alert('Notification permission was blocked in browser settings. Please allow notifications in browser URL bar.');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = 'Enable Notifications & Refresh Token';
                    }
                }
            } catch (e) {
                console.error('Error refreshing token:', e);
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = 'Enable Notifications & Refresh Token';
                }
            }
        };

        // Always attempt token refresh if permission is already granted
        if ('Notification' in window && Notification.permission === 'granted') {
            registerAndSaveToken();
            const navbarBtn = document.getElementById('btnEnableNavbarPush');
            if (navbarBtn) {
                navbarBtn.innerHTML = '<i data-lucide="check" style="width:14px;height:14px;"></i> Alerts Active';
                navbarBtn.style.background = '#16A34A';
            }
        }

        onMessage(messaging, (payload) => {
            console.log('MESSAGE RECEIVED', payload);

            if (typeof window.playNotificationSound === 'function') {
                window.playNotificationSound();
            }

            const title = payload.notification?.title || payload.data?.title || 'New Notification';
            const body = payload.notification?.body || payload.data?.body || '';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: title,
                    text: body,
                    showConfirmButton: true,
                    confirmButtonText: 'View',
                    confirmButtonColor: '#C25A2A',
                    timer: 8000
                });
            } else {
                alert(title + ' - ' + body);
            }
        });
    </script>

    <script>

    function toggleSidebar() {

        document
            .getElementById('sidebar')
            .classList.toggle('open');

    }

    document.addEventListener('click', function(e){

        const sidebar =
            document.getElementById('sidebar');

        const button =
            document.getElementById('menuToggle');

        if(
            !sidebar.contains(e.target)
            &&
            !button.contains(e.target)
        ){
            sidebar.classList.remove('open');
        }

    });

    </script>

    <!-- INSTALL POPUP -->

<div
id="installPopup"

style="
display:none;
position:fixed;
inset:0;
background:rgba(0,0,0,.6);
z-index:999999;
justify-content:center;
align-items:center;
">

<div
style="
width:350px;
background:white;
padding:30px;
border-radius:20px;
text-align:center;
">

<h2>

Install HYST

</h2>

<p>

Install Web App for better experience.

</p>

<button

id="installBtn"

style="
background:#C25A2A;
color:white;
padding:14px 30px;
border:none;
border-radius:10px;
margin-top:20px;
cursor:pointer;
">

Install

</button>

<br>

<button

onclick="closeInstall()"

style="
margin-top:12px;
">

Later

</button>

</div>

</div>
    <!-- iOS INSTALLATION GUIDE MODAL -->
    <div id="iosInstallGuide" style="display:none; position:fixed; inset:0; z-index:999999; background:rgba(0,0,0,0.7); backdrop-filter:blur(6px); align-items:center; justify-content:center; padding:20px;">
        <div style="background:#fff; border-radius:24px; padding:30px; max-width:400px; width:100%; text-align:center; position:relative; font-family:'Poppins',sans-serif; box-shadow:0 20px 50px rgba(0,0,0,0.25);">
            <button onclick="document.getElementById('iosInstallGuide').style.display='none'" style="position:absolute; top:16px; right:16px; border:none; background:#F3F4F6; width:32px; height:32px; border-radius:50%; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center;">✕</button>
            <div style="font-size:42px; margin-bottom:10px;">📲</div>
            <h3 style="font-size:20px; font-weight:800; color:#111827; margin-bottom:8px;">Install HYST App on iPhone</h3>
            <p style="font-size:13px; color:#6B7280; margin-bottom:20px; line-height:1.5;">Install HYST on your home screen for a fast, app-like experience:</p>
            
            <div style="background:#FFF7F3; border:1.5px solid #FFD8C9; border-radius:16px; padding:16px; text-align:left; margin-bottom:12px; display:flex; align-items:center; gap:14px;">
                <div style="width:36px; height:36px; border-radius:10px; background:#C25A2A; color:#fff; font-weight:800; font-size:16px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">1</div>
                <div style="font-size:13px; color:#1F2937; line-height:1.4;">
                    Tap the <strong>Share button</strong> <span style="font-size:18px;">⎋</span> at the bottom of Safari
                </div>
            </div>

            <div style="background:#FFF7F3; border:1.5px solid #FFD8C9; border-radius:16px; padding:16px; text-align:left; margin-bottom:20px; display:flex; align-items:center; gap:14px;">
                <div style="width:36px; height:36px; border-radius:10px; background:#C25A2A; color:#fff; font-weight:800; font-size:16px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">2</div>
                <div style="font-size:13px; color:#1F2937; line-height:1.4;">
                    Scroll down & tap <strong>"Add to Home Screen"</strong> <span style="font-size:18px;">⊕</span>
                </div>
            </div>

            <button onclick="document.getElementById('iosInstallGuide').style.display='none'; markPwaInstalled();" style="width:100%; background:#C25A2A; color:#fff; font-weight:700; padding:13px; border:none; border-radius:12px; font-size:15px; cursor:pointer; box-shadow:0 8px 20px rgba(194,90,42,0.35);">
                Got It
            </button>
        </div>
    </div>

<script>
    let deferredPrompt;
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    const isStandalone = (window.navigator.standalone === true) || window.matchMedia('(display-mode: standalone)').matches;

    if (isStandalone) {
        localStorage.setItem('pwa_installed', 'true');
        document.cookie = "pwa_installed=true; max-age=31536000; path=/; SameSite=Lax";
    }

    function markPwaInstalled() {
        localStorage.setItem('pwa_installed', 'true');
        document.cookie = "pwa_installed=true; max-age=31536000; path=/; SameSite=Lax";
        closeInstall();
    }

    function closeInstall() {
        localStorage.setItem('install_popup_closed', Date.now());
        const popup = document.getElementById('installPopup');
        if (popup) popup.style.display = 'none';
    }

    function checkShowInstallPopup() {
        if (isStandalone || localStorage.getItem('pwa_installed') === 'true' || document.cookie.indexOf('pwa_installed=true') !== -1) {
            localStorage.setItem('pwa_installed', 'true');
            document.cookie = "pwa_installed=true; max-age=31536000; path=/; SameSite=Lax";
            return false; // App is ALREADY INSTALLED!
        }
        const lastClosed = localStorage.getItem('install_popup_closed');
        if (lastClosed) {
            const thirtyMins = 30 * 60 * 1000;
            if (Date.now() - parseInt(lastClosed) < thirtyMins) {
                return false;
            }
        }
        return true;
    }

    if (isIOS && !isStandalone && checkShowInstallPopup()) {
        setTimeout(() => {
            const popup = document.getElementById('installPopup');
            if (popup && checkShowInstallPopup()) popup.style.display = 'flex';
        }, 3000);
    }

    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('INSTALL READY');
        e.preventDefault();
        deferredPrompt = e;

        if (checkShowInstallPopup()) {
            setTimeout(() => {
                const popup = document.getElementById('installPopup');
                if (popup && checkShowInstallPopup()) popup.style.display = 'flex';
            }, 3000);
        }
    });

    const installBtn = document.getElementById('installBtn');
    if (installBtn) {
        installBtn.addEventListener('click', async () => {
            if (isIOS) {
                const guide = document.getElementById('iosInstallGuide');
                if (guide) guide.style.display = 'flex';
                closeInstall();
                return;
            }

            if (!deferredPrompt) {
                alert('To install HYST, use Safari share menu on iOS or Chrome menu on Android.');
                return;
            }

            deferredPrompt.prompt();
            const choice = await deferredPrompt.userChoice;
            if (choice && choice.outcome === 'accepted') {
                markPwaInstalled();
            } else {
                closeInstall();
            }
        });
    }

    window.addEventListener('appinstalled', () => {
        markPwaInstalled();
    });
</script>




@if(session('success'))
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            confirmButtonColor: '#16A34A'
        });
        </script>
    @endif

    @if(session('error'))
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
            confirmButtonColor: '#d33'
        });
        </script>
    @endif

    @if(session('warning'))
        <script>
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: @json(session('warning')),
            confirmButtonColor: '#F59E0B'
        });
        </script>
    @endif

    @if(session('info'))
        <script>
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: @json(session('info')),
            confirmButtonColor: '#3B82F6'
        });
        </script>
    @endif

</body>

</html>