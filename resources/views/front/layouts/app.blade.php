<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HYST | Zero Commission Food Ordering Platform UK | Order Direct from Restaurants</title>

    <meta name="title" content="HYST — Premium Food Delivery | Order Food Online">
    <meta name="description" content="HYST is the UK's zero commission food ordering platform. Order directly from local restaurants at genuine menu prices with no hidden markups. Support local businesses while enjoying fair pricing and fast ordering.">
    <meta name="keywords"
    content="HYST, food ordering UK, zero commission food ordering, order directly from restaurants, restaurant takeaway UK, online takeaway, food delivery, Hounslow restaurants, restaurant ordering platform, fair food prices">
    <meta name="author" content="HYST — Premium Food Delivery">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">

    <meta name="theme-color" content="#C25A2A">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://hyst.uk/">

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Geo Tags -->
    <meta name="geo.region" content="GB-LND">
    <meta name="geo.placename" content="Hounslow">
    <meta name="geo.position" content="51.4686;-0.3618">
    <meta name="ICBM" content="51.4686,-0.3618">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="HYST | Zero Commission Food Ordering Platform">
    <meta property="og:description" content="Order directly from restaurants with zero commission and genuine menu prices.">
    <meta property="og:url" content="https://hyst.uk">
    <meta property="og:site_name" content="HYST">
    <meta property="og:image" content="https://hyst.uk/images/og-image.jpg">
    <meta property="og:locale" content="en_GB">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="HYST | Zero Commission Food Ordering">
    <meta name="twitter:description" content="Support local restaurants while paying genuine menu prices.">
    <meta name="twitter:image" content="https://hyst.uk/images/og-image.jpg">

    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"Organization",
            "name":"HYST",
            "url":"https://hyst.uk",
            "logo":"https://hyst.uk/images/logo.png",
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
            "image":"https://hyst.uk/images/logo.png",
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

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css">

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @laravelPWA


    <style>
        :root {
            --primary: #C25A2A;
            --primary-dark: #C42D0A;
            --primary-light: #FFF0EC;
            --black: #0D0D0D;
            --gray-mid: #6B7280;
            --gray-light: #F5F5F0;
            --success: #16A34A;
            --success-light: #DCFCE7;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-light);
            color: var(--black);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            border-radius: 12px;
            transition: all .2s;
            display: inline-block;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(232, 55, 14, .35);
        }

        .btn-black {
            background: var(--black);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            border-radius: 12px;
            transition: all .2s;
            display: inline-block;
        }

        .btn-black:hover {
            background: #333;
            transform: translateY(-1px);
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .07);
        }

        .badge-primary {
            background: var(--primary);
            color: #fff;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 12px;
            font-family: 'Poppins', sans-serif;
            letter-spacing: .03em;
        }

        .badge-success {
            background: var(--success-light);
            color: var(--success);
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            padding: 4px 14px;
        }

        .sidebar-link {
            display: block;
            padding: 13px 18px;
            border-radius: 12px;
            font-weight: 500;
            transition: all .18s;
            color: var(--black);
            text-decoration: none;
        }

        .sidebar-link:hover {
            background: var(--gray-light);
        }

        .sidebar-link.active {
            background: var(--primary);
            color: #fff;
            font-weight: 700;
        }

        input,
        select,
        textarea {
            border: 1.5px solid #E5E5E0;
            border-radius: 12px;
            padding: 13px 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            width: 100%;
            outline: none;
            transition: border .18s;
            background: #FAFAF8;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary);
        }

        label {
            font-weight: 600;
            font-size: 13px;
            display: block;
            margin-bottom: 7px;
            font-family: 'Poppins', sans-serif;
        }

        th {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: var(--gray-mid);
            text-transform: uppercase;
            letter-spacing: .07em;
            padding: 14px 18px;
            text-align: left;
            background: var(--gray-light);
        }

        td {
            padding: 16px 18px;
            border-bottom: 1px solid #F0F0EC;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .avatar {
            width: 44px;
            height: 44px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ── HEADER RESPONSIVE ── */
        .desktop-nav {
            display: flex;
        }

        .mobile-toggle {
            display: none;
        }

        

        .mobile-menu {
            display: none;
        }

        @media(max-width:992px) {
            .desktop-nav {
                display: none !important;
            }

            

            .mobile-toggle {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                border: none;
                background: #F5F5F0;
                border-radius: 12px;
                cursor: pointer;
            }

            .mobile-menu {
                display: none;
                background: #fff;
                border-top: 1px solid #F0F0EC;
                padding: 16px 20px 20px;
            }

            .mobile-menu.active {
                display: block;
            }

            .mobile-menu a {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 13px 0;
                text-decoration: none;
                color: #111827;
                border-bottom: 1px solid #F3F4F6;
                font-weight: 500;
                font-size: 14px;
            }

            .mobile-menu a:last-child {
                border-bottom: none;
            }
        }

        /* ── FOOTER RESPONSIVE ── */
        @media(max-width:900px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 36px !important;
            }
        }

        @media(max-width:560px) {
            .footer-grid {
                grid-template-columns: 1fr !important;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
        }

        /* ── HOME PAGE RESPONSIVE ── */
        @media(max-width:900px) {
            .hero-title {
                font-size: 36px !important;
            }

            .hero-stats {
                gap: 20px !important;
            }

            .categories-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .offer-grid {
                grid-template-columns: 1fr !important;
            }

            .offer-img {
                display: none !important;
            }

            .qr-wrapper {
                grid-template-columns: 1fr !important;
                text-align: center;
            }

            .qr-title {
                font-size: 30px !important;
            }
        }

        @media(max-width:600px) {
            .hero-title {
                font-size: 26px !important;
            }

            .section-title {
                font-size: 26px !important;
            }

            .categories-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .products-grid {
                grid-template-columns: 1fr !important;
            }

            .features-grid {
                grid-template-columns: 1fr !important;
            }

            .hero-stats {
                flex-wrap: wrap;
                gap: 16px !important;
            }

            .hero-cta {
                flex-direction: column !important;
            }

            .offer-title {
                font-size: 32px !important;
            }
        }
    </style>
</head>

<body>
    @include('partials.global_loader')
    @include('front.layouts.header')
    @yield('content')
    @include('front.layouts.footer')

    <!-- Notification Permission Banner -->
    <style>
        #notification-banner{
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,.2);
            border: 1px solid #ddd;
            z-index: 2147483647;
            display: none;
        }

        #notification-banner h4{
            margin: 0 0 10px;
            font-size: 18px;
            font-weight: 600;
        }

        #notification-banner p{
            margin: 0 0 15px;
            color: #666;
            line-height: 1.5;
        }

        #notification-banner .btn-enable{
            background: #C25A2A;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 8px;
        }

        #notification-banner .btn-later{
            background: #eee;
            color: #333;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>

    {{-- <div id="notification-banner">
        <h4>🔔 Enable Notifications</h4>

        <p>
            Stay updated with instant alerts for new orders and important updates.
        </p>

        <button
            id="enableNotifications"
            class="btn-enable"
        >
            Enable
        </button>

        <button
            id="closeNotificationBanner"
            class="btn-later"
        >
            Later
        </button>
    </div> --}}

    {{-- <script>
        window.onload = function () {

            if (!('Notification' in window)) {
                console.log('Notifications not supported');
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Already Granted
            |--------------------------------------------------------------------------
            */

            if (Notification.permission === 'granted') {

                document.getElementById(
                    'notification-banner'
                ).style.display = 'none';

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Show Popup After 3 Seconds
            |--------------------------------------------------------------------------
            */

            setTimeout(() => {

                document.getElementById(
                    'notification-banner'
                ).style.display = 'block';

            }, 3000);

            /*
            |--------------------------------------------------------------------------
            | Enable Notification
            |--------------------------------------------------------------------------
            */

            document
                .getElementById('enableNotifications')
                .onclick = async function () {

                    try {

                        const permission =
                            await Notification.requestPermission();

                        if (permission === 'granted') {

                            document.getElementById(
                                'notification-banner'
                            ).style.display = 'none';

                            alert(
                                'Notifications enabled successfully.'
                            );

                            /*
                            ====================================
                            GENERATE FCM TOKEN HERE
                            ====================================

                            Example:

                            const token = await getToken(
                                messaging,
                                {
                                    vapidKey: 'YOUR_VAPID_KEY'
                                }
                            );

                            save token to Laravel
                            */

                        } else if (permission === 'denied') {

                            alert(
                                'Notifications are blocked. Please enable them from browser settings.'
                            );

                        } else {

                            alert(
                                'Notification permission dismissed.'
                            );

                        }

                    } catch (error) {

                        console.error(error);

                    }
                };

            /*
            |--------------------------------------------------------------------------
            | Later Button
            |--------------------------------------------------------------------------
            */

            document
                .getElementById('closeNotificationBanner')
                .onclick = function () {

                    document.getElementById(
                        'notification-banner'
                    ).style.display = 'none';

                };
        };
    </script> --}}

    <script>lucide.createIcons();</script>


    <script type="module">

        console.log('FCM START');

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

        console.log('FIREBASE INITIALIZED');

        const messaging =
            getMessaging(app);

        Notification.requestPermission()

            .then(async (permission) => {

                console.log('PERMISSION:', permission);

                if (permission === 'granted') {

                    console.log('PERMISSION GRANTED');

                    const registration =
                        await navigator.serviceWorker.register(
                            '/firebase-messaging-sw.js'
                        );

                    console.log(
                        'SERVICE WORKER REGISTERED'
                    );

                    const token =
                        await getToken(

                            messaging,

                            {

                                vapidKey: "{{ config('services.firebase.vapid_key') }}",

                                serviceWorkerRegistration:
                                    registration
                            }

                        );

                    console.log(
                        'FCM TOKEN:',
                        token
                    );

                    if (token) {

                        fetch('/save-fcm-token', {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'X-CSRF-TOKEN':

                                    document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content
                            },

                            body: JSON.stringify({

                                token: token

                            })
                        });

                        console.log(
                            'TOKEN SAVED'
                        );
                    }
                }

            }).catch((error) => {

                console.log(
                    'FCM ERROR:',
                    error
                );

            });

        onMessage(messaging, (payload) => {

            console.log(
                'NOTIFICATION',
                payload
            );

            alert(

                payload.notification.title

                + '\n\n'

                +

                payload.notification.body

            );

            new Notification(

                payload.notification.title,

                {

                    body:
                        payload.notification.body

                }

            );

        });

    </script>

    <!-- INSTALL POPUP -->

    <div id="installPopup" style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.6);
        z-index:999999;
        justify-content:center;
        align-items:center;
        ">

        <div style="
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

                Install app for better experience.

            </p>

            <button id="installBtn" style="
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

            <button onclick="closeInstall()" style="
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

            <button onclick="document.getElementById('iosInstallGuide').style.display='none'; closeInstall();" style="width:100%; background:#C25A2A; color:#fff; font-weight:700; padding:13px; border:none; border-radius:12px; font-size:15px; cursor:pointer; box-shadow:0 8px 20px rgba(194,90,42,0.35);">
                Got It
            </button>
        </div>
    </div>

    <script>
        let deferredPrompt;
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.navigator.standalone || window.matchMedia('(display-mode: standalone)').matches;

        function closeInstall() {
            localStorage.setItem('install_popup_closed', Date.now());
            const popup = document.getElementById('installPopup');
            if (popup) popup.style.display = 'none';
        }

        function checkShowInstallPopup() {
            const lastClosed = localStorage.getItem('install_popup_closed');
            if (lastClosed) {
                const thirtyMins = 30 * 60 * 1000;
                if (Date.now() - parseInt(lastClosed) < thirtyMins) {
                    return false;
                }
            }
            return true;
        }

        // Show installation popup on iOS Safari
        if (isIOS && !isStandalone && checkShowInstallPopup()) {
            setTimeout(() => {
                const popup = document.getElementById('installPopup');
                if (popup) popup.style.display = 'flex';
            }, 3000);
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('INSTALL READY');
            e.preventDefault();
            deferredPrompt = e;

            if (checkShowInstallPopup()) {
                setTimeout(() => {
                    const popup = document.getElementById('installPopup');
                    if (popup) popup.style.display = 'flex';
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
                await deferredPrompt.userChoice;
                closeInstall();
            });
        }

        window.addEventListener('appinstalled', () => {
            closeInstall();
        });
    </script>

    @if(session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: @json(session('type', 'success')),
                    title: @json(ucfirst(session('type', 'success'))),
                    text: @json(session('message')),
                    confirmButtonColor: '#111827'
                });
            });
        </script>
    @endif
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