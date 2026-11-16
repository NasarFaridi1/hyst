@extends('front.layouts.app')
@section('content')

    <style>
        /* ---- MOBILE RESPONSIVENESS ---- */
        @media(max-width:1024px) {
            .hero-grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
            .hero-img-wrap {
                margin-top: 8px;
            }
            .comparison-grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
            .offer-grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
        }

        .partner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(13,13,13,0.09) !important;
        }
        .partner-card:hover .partner-banner-img {
            transform: scale(1.06) !important;
        }

        @media(max-width:900px) {
            .steps-grid {
                grid-template-columns: 1fr !important;
            }
            .partners-grid {
                grid-template-columns: 1fr !important;
                gap: 24px !important;
            }
            .features-grid {
                grid-template-columns: repeat(2,1fr) !important;
            }
            .testimonial-grid {
                grid-template-columns: 1fr !important;
            }
        }

        @media(max-width:768px) {
            .hero-title {
                font-size: 34px !important;
            }
            .offer-title {
                font-size:32px !important;
            }
            .section-title {
                font-size: 28px !important;
            }
            .hero-stats {
                gap: 22px !important;
            }
            .hero-img-wrap img {
                height: 340px !important;
            }
            /* floating cards would overflow the viewport at negative offsets,
               so pull them inside and stack them under the image instead */
            .hero-img-wrap > div:nth-of-type(1) {
                position: static !important;
                margin-top: 14px;
                display: inline-flex;
            }
            .hero-img-wrap > div:nth-of-type(2) {
                position: static !important;
                margin-top: 12px;
                display: block;
            }
        }

        @media(max-width:560px) {
            .hero-title {
                font-size: 28px !important;
            }
            .hero-stats {
                gap: 16px !important;
            }
            .hero-stats > div:first-child p:first-child,
            .hero-stats > div:nth-child(3) p:first-child,
            .hero-stats > div:nth-child(5) p:first-child {
                font-size: 21px !important;
            }
            .features-grid {
                grid-template-columns: 1fr !important;
            }
            .offer-title {
                font-size: 26px !important;
            }
        }
    </style>

    
    <section style="position:relative; min-height:250px; display:flex; align-items:flex-end; overflow:hidden; border-radius:12px;">

        <img src="images/Hanover.png" class="desktop-banner" alt="HYST Local Food Delivery & Restaurant Ordering in Hounslow" loading="lazy">

        <img src="images/FoodMenu.png" class="mobile-banner" alt="HYST Restaurant Menu & Offers in Hounslow London" loading="lazy">

    </section>

    <style>
        .desktop-banner,
        .mobile-banner {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-banner {
            display: none;
            object-fit: fill !important;
        }

        @media (max-width: 768px) {
            .desktop-banner {
                display: none;
                
            }

            .mobile-banner {
                display: block;
                  object-fit: fill !important;
            }
        }
    </style>


   
    {{-- ══════════════════════════════════════
         NATIVE AD UNIT: UK FOOTBALL FESTIVAL & HYST FANTASY XI
    ══════════════════════════════════════ --}}
    <div id="hyst-matchday-native-ad" style="max-width:1280px; margin: 18px auto 6px; padding: 0 16px;">
        <div style="
            position: relative;
            background: linear-gradient(90deg, #FFFFFF 0%, #FFFDF9 60%, #FFF7ED 100%);
            border: 1px solid #EAE6DE;
            border-left: 4px solid #C25A2A;
            border-radius: 14px;
            padding: 12px 16px 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 2px 10px rgba(13,13,13,0.04);
            flex-wrap: wrap;
            transition: all .2s;
        ">
            <!-- Left Info & Player Face Stack -->
            <div style="display: flex; align-items: center; gap: 14px; flex: 1; min-width: 280px;">
                <!-- Overlapping England Star Avatars -->
                <div style="display: flex; align-items: center; flex-shrink: 0;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #fff; background: #0A192F; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.15); z-index: 3;" title="Harry Kane (90)">
                        <img src="https://resources.premierleague.com/premierleague/photos/players/250x250/p78830.png" alt="Harry Kane" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Harry+Kane&background=0A192F&color=fff';">
                    </div>
                    <div style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #fff; background: #0F2746; overflow: hidden; margin-left: -14px; box-shadow: 0 2px 6px rgba(0,0,0,0.15); z-index: 2;" title="Bukayo Saka (88)">
                        <img src="https://resources.premierleague.com/premierleague/photos/players/250x250/p223340.png" alt="Bukayo Saka" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Bukayo+Saka&background=0F2746&color=fff';">
                    </div>
                    <div style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #fff; background: #16365C; overflow: hidden; margin-left: -14px; box-shadow: 0 2px 6px rgba(0,0,0,0.15); z-index: 1;" title="Cole Palmer (88)">
                        <img src="https://resources.premierleague.com/premierleague/photos/players/250x250/p244855.png" alt="Cole Palmer" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Cole+Palmer&background=16365C&color=fff';">
                    </div>
                </div>

                <!-- Text Copy -->
                <div>
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                        <span style="font-size: 9.5px; font-weight: 800; color: #8C8C8C; text-transform: uppercase; letter-spacing: .06em; background: #F3F1EC; padding: 1px 6px; border-radius: 4px;">
                            Ad &bull; Hyst Sports
                        </span>
                        <span style="font-size: 11px; font-weight: 700; color: #C25A2A; display: inline-flex; align-items: center; gap: 4px;">
                            <span>🏴󠁧󠁢󠁥󠁮󠁧󠁿</span> UK Football Festival Live
                        </span>
                    </div>
                    <div style="font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; color: #0D0D0D; line-height: 1.2;">
                        Build Your England Fantasy XI &amp; Challenge Friends
                    </div>
                    <div style="font-size: 11.5px; color: #666; margin-top: 1px;">
                        Unlock England stars with every food order &bull; Back your players &bull; 100% Free to Play
                    </div>
                </div>
            </div>

            <!-- Right CTAs & Dismiss -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('matchday.index') }}" 
                   style="
                       display: inline-flex;
                       align-items: center;
                       gap: 6px;
                       background: #C25A2A;
                       color: #ffffff;
                       padding: 8px 18px;
                       border-radius: 10px;
                       font-family: 'Poppins', sans-serif;
                       font-size: 12.5px;
                       font-weight: 700;
                       text-decoration: none;
                       box-shadow: 0 2px 8px rgba(194,90,42,0.25);
                       transition: background .15s, transform .15s;
                   "
                   onmouseover="this.style.background='#A6461D'; this.style.transform='translateY(-1px)';"
                   onmouseout="this.style.background='#C25A2A'; this.style.transform='translateY(0)';"
                >
                    <span>Play Fantasy XI</span>
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>

                <!-- Dismiss Button -->
                <button type="button" 
                        onclick="dismissHystMatchdayAd()" 
                        style="
                            background: transparent;
                            border: none;
                            color: #9CA3AF;
                            font-size: 18px;
                            line-height: 1;
                            cursor: pointer;
                            padding: 4px;
                            border-radius: 6px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        "
                        title="Dismiss Ad"
                        aria-label="Dismiss Ad">
                    &times;
                </button>
            </div>
        </div>
    </div>

    <script>
        function dismissHystMatchdayAd() {
            const ad = document.getElementById('hyst-matchday-native-ad');
            if (ad) ad.style.display = 'none';
            try { sessionStorage.setItem('hyst_matchday_ad_dismissed', '1'); } catch(e){}
        }
        (function() {
            try {
                if (sessionStorage.getItem('hyst_matchday_ad_dismissed') === '1') {
                    const ad = document.getElementById('hyst-matchday-native-ad');
                    if (ad) ad.style.display = 'none';
                }
            } catch(e){}
        })();
    </script>

    @include('front.restaurants')

    <!-- ══════════════════════════════════════
         PARTNERS SECTION (Worldpay & Uber Direct)
    ══════════════════════════════════════ -->
    <section style="background:#FAF7F2; padding:65px 0; border-top:1px solid #EFEAE0; border-bottom:1px solid #EFEAE0;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="text-align:center; margin-bottom:46px;">
                <div style="display:inline-flex; align-items:center; gap:8px; background:#fff; border:1px solid #EFE9DF; padding:6px 16px; border-radius:999px; margin-bottom:14px; box-shadow:0 2px 8px rgba(0,0,0,0.03);">
                    <i data-lucide="handshake" style="width:15px; height:15px; color:#C25A2A;"></i>
                    <span style="color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; letter-spacing:.08em; text-transform:uppercase;">
                        Our Trusted Partners
                    </span>
                </div>
                <h2 class="section-title" style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; color:#0D0D0D; margin:0 0 12px; letter-spacing:-.5px;">
                    Powered By World-Class Partners
                </h2>
                <p style="color:#6B7280; font-size:15px; max-width:640px; margin:0 auto; line-height:1.7;">
                    We collaborate with industry leaders to guarantee fast doorstep delivery and seamless, bank-grade payment security for every restaurant and customer.
                </p>
            </div>

            <div class="partners-grid" style="display:grid; grid-template-columns:repeat(2,1fr); gap:28px;">
                
                <!-- WORLD PAY (Payment Partner) -->
                <div class="partner-card" style="background:#fff; border-radius:24px; border:1px solid #EFEAE0; overflow:hidden; display:flex; flex-direction:column; transition:transform .3s ease, box-shadow .3s ease;">
                    <a href="https://platforms.worldpay.com/en" target="_blank" rel="noopener noreferrer" style="text-decoration:none; color:inherit; display:block;" title="Visit Worldpay Platform">
                        <div style="position:relative; width:100%; height:210px; background:#0F0B1E; overflow:hidden; display:flex; align-items:center; justify-content:center; padding:24px;">
                            <img src="{{asset('worldpay.png')}}" 
                                 alt="Worldpay Payment Partner" 
                                 style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.35; filter:brightness(0.7); transition:transform .4s ease;"
                                 class="partner-banner-img">
                            <div style="position:relative; z-index:2; text-align:center;">
                                <div style="background:rgba(255,255,255,0.96); backdrop-filter:blur(8px); border-radius:16px; padding:14px 28px; display:inline-flex; align-items:center; gap:12px; box-shadow:0 12px 30px rgba(0,0,0,0.25);">
                                    <img src="{{asset('world-pay.png')}}" 
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Worldpay_Logo.svg/512px-Worldpay_Logo.svg.png';"
                                         alt="Worldpay Logo" 
                                         style="height:32px; max-width:180px; object-fit:contain;">
                                </div>
                            </div>
                            <span style="position:absolute; top:16px; left:16px; background:#7C3AED; color:#fff; font-size:11px; font-weight:700; font-family:'Poppins',sans-serif; padding:5px 12px; border-radius:20px; letter-spacing:.03em; z-index:3; display:flex; align-items:center; gap:5px; box-shadow:0 4px 12px rgba(124,58,237,0.3);">
                                <i data-lucide="shield-check" style="width:13px; height:13px;"></i> Payment Partner
                            </span>
                            <span style="position:absolute; top:16px; right:16px; background:rgba(0,0,0,0.65); backdrop-filter:blur(4px); color:#fff; font-size:11px; font-weight:600; font-family:'Poppins',sans-serif; padding:5px 11px; border-radius:20px; z-index:3; display:flex; align-items:center; gap:4px;">
                                Click to Visit <i data-lucide="external-link" style="width:12px; height:12px;"></i>
                            </span>
                        </div>
                    </a>
                    <div style="padding:28px 26px 26px; flex:1; display:flex; flex-direction:column;">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                            <h3 style="font-family:'Poppins',sans-serif; font-size:22px; font-weight:800; color:#0D0D0D; margin:0;">Worldpay</h3>
                            <span style="font-size:12px; font-weight:700; color:#7C3AED; background:rgba(124,58,237,0.1); padding:4px 10px; border-radius:8px; font-family:'Poppins',sans-serif;">Payment Gateway</span>
                        </div>
                        <p style="color:#4B5563; font-size:14px; line-height:1.7; margin:0 0 20px;">
                            Worldpay provides fast, highly reliable online payment infrastructure for HYST, guaranteeing PCI-compliant card processing and end-to-end security for every transaction.
                        </p>
                        <div style="margin-top:auto; display:flex; flex-direction:column; gap:10px; margin-bottom:22px; padding-top:16px; border-top:1px dashed #E5E0D8;">
                            <div style="display:flex; align-items:center; gap:9px; color:#374151; font-size:13px; font-weight:600; font-family:'Poppins',sans-serif;">
                                <i data-lucide="check-circle-2" style="width:16px; height:16px; color:#7C3AED; flex-shrink:0;"></i>
                                <span>Bank-grade PCI DSS compliance & fraud prevention</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:9px; color:#374151; font-size:13px; font-weight:600; font-family:'Poppins',sans-serif;">
                                <i data-lucide="check-circle-2" style="width:16px; height:16px; color:#7C3AED; flex-shrink:0;"></i>
                                <span>Instant card processing & multi-currency support</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:9px; color:#374151; font-size:13px; font-weight:600; font-family:'Poppins',sans-serif;">
                                <i data-lucide="check-circle-2" style="width:16px; height:16px; color:#7C3AED; flex-shrink:0;"></i>
                                <span>Trusted payment platform used by millions worldwide</span>
                            </div>
                        </div>
                        <a href="https://platforms.worldpay.com/en" target="_blank" rel="noopener noreferrer" 
                           style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background:#0F0B1E; color:#fff; text-decoration:none; padding:13px 22px; border-radius:14px; font-family:'Poppins',sans-serif; font-weight:700; font-size:14px; transition:background .2s ease;"
                           onmouseover="this.style.background='#2A1A4E'" onmouseout="this.style.background='#0F0B1E'">
                           Visit Worldpay Platform <i data-lucide="arrow-up-right" style="width:16px; height:16px;"></i>
                        </a>
                    </div>
                </div>

                <!-- UBER DIRECT (Delivery Partner) -->
                <div class="partner-card" style="background:#fff; border-radius:24px; border:1px solid #EFEAE0; overflow:hidden; display:flex; flex-direction:column; transition:transform .3s ease, box-shadow .3s ease;">
                    <a href="https://merchants.uber.com/uber-direct.html" target="_blank" rel="noopener noreferrer" style="text-decoration:none; color:inherit; display:block;" title="Visit Uber Direct">
                        <div style="position:relative; width:100%; height:210px; background:#000000; overflow:hidden; display:flex; align-items:center; justify-content:center; padding:24px;">
                            <img src="{{asset('uber-direct.jpg')}}" 
                                 alt="Uber Direct Delivery Partner" 
                                 style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.35; filter:brightness(0.7); transition:transform .4s ease;"
                                 class="partner-banner-img">
                            <div style="position:relative; z-index:2; text-align:center;">
                                <div style="background:rgba(255,255,255,0.96); backdrop-filter:blur(8px); border-radius:16px; padding:14px 28px; display:inline-flex; align-items:center; gap:10px; box-shadow:0 12px 30px rgba(0,0,0,0.25);">
                                    <img src="{{asset('uber.jpg')}}" 
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Uber_logo_2018.svg/512px-Uber_logo_2018.svg.png';"
                                         alt="Uber Logo" 
                                         style="height:28px; max-width:140px; object-fit:contain;">
                                    <span style="font-family:'Poppins',sans-serif; font-weight:800; font-size:18px; color:#000; letter-spacing:-.3px; border-left:2px solid #000; padding-left:10px;">Direct</span>
                                </div>
                            </div>
                            <span style="position:absolute; top:16px; left:16px; background:#000000; color:#00FF66; border:1px solid rgba(0,255,102,0.4); font-size:11px; font-weight:700; font-family:'Poppins',sans-serif; padding:5px 12px; border-radius:20px; letter-spacing:.03em; z-index:3; display:flex; align-items:center; gap:5px; box-shadow:0 4px 12px rgba(0,0,0,0.4);">
                                <i data-lucide="truck" style="width:13px; height:13px;"></i> Delivery Partner
                            </span>
                            <span style="position:absolute; top:16px; right:16px; background:rgba(0,0,0,0.65); backdrop-filter:blur(4px); color:#fff; font-size:11px; font-weight:600; font-family:'Poppins',sans-serif; padding:5px 11px; border-radius:20px; z-index:3; display:flex; align-items:center; gap:4px;">
                                Click to Visit <i data-lucide="external-link" style="width:12px; height:12px;"></i>
                            </span>
                        </div>
                    </a>
                    <div style="padding:28px 26px 26px; flex:1; display:flex; flex-direction:column;">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                            <h3 style="font-family:'Poppins',sans-serif; font-size:22px; font-weight:800; color:#0D0D0D; margin:0;">Uber Direct</h3>
                            <span style="font-size:12px; font-weight:700; color:#008A00; background:rgba(0,180,75,0.1); padding:4px 10px; border-radius:8px; font-family:'Poppins',sans-serif;">On-Demand Delivery</span>
                        </div>
                        <p style="color:#4B5563; font-size:14px; line-height:1.7; margin:0 0 20px;">
                            Uber Direct powers HYST's fast home delivery network. By tapping directly into Uber's driver ecosystem, orders are picked up fast and delivered hot straight to your doorstep.
                        </p>
                        <div style="margin-top:auto; display:flex; flex-direction:column; gap:10px; margin-bottom:22px; padding-top:16px; border-top:1px dashed #E5E0D8;">
                            <div style="display:flex; align-items:center; gap:9px; color:#374151; font-size:13px; font-weight:600; font-family:'Poppins',sans-serif;">
                                <i data-lucide="check-circle-2" style="width:16px; height:16px; color:#008A00; flex-shrink:0;"></i>
                                <span>On-demand local courier dispatch & doorstep drop-off</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:9px; color:#374151; font-size:13px; font-weight:600; font-family:'Poppins',sans-serif;">
                                <i data-lucide="check-circle-2" style="width:16px; height:16px; color:#008A00; flex-shrink:0;"></i>
                                <span>Live GPS delivery tracking from kitchen to doorstep</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:9px; color:#374151; font-size:13px; font-weight:600; font-family:'Poppins',sans-serif;">
                                <i data-lucide="check-circle-2" style="width:16px; height:16px; color:#008A00; flex-shrink:0;"></i>
                                <span>Powered by Uber's global fleet & delivery technology</span>
                            </div>
                        </div>
                        <a href="https://merchants.uber.com/uber-direct.html" target="_blank" rel="noopener noreferrer" 
                           style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background:#000000; color:#fff; text-decoration:none; padding:13px 22px; border-radius:14px; font-family:'Poppins',sans-serif; font-weight:700; font-size:14px; transition:background .2s ease;"
                           onmouseover="this.style.background='#222222'" onmouseout="this.style.background='#000000'">
                           Learn About Uber Direct <i data-lucide="arrow-up-right" style="width:16px; height:16px;"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════
         HOW IT WORKS
    ══════════════════════════════════════ -->
    <section style="background:#fff; padding:50px 0;">
        <div style="max-width:1280px; margin:0 auto; padding:0 14px;">
            <div style="text-align:center; margin-bottom:52px;">
                <p
                    style="color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; letter-spacing:.1em; text-transform:uppercase; margin:0 0 8px;">
                    Simple By Design</p>
                <h2 class="section-title"
                    style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; margin:0; letter-spacing:-.4px;">
                    How HYST Works</h2>
            </div>

            <div class="steps-grid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px;">
                @php
                    $steps = [
                        ['icon' => 'search', 'title' => 'Find Your Restaurant', 'desc' => 'Search by cuisine, dish, or postcode and browse real menus from local restaurants.'],
                        ['icon' => 'utensils-crossed', 'title' => 'Order Direct', 'desc' => 'Pay restaurant prices, not inflated commission prices. No surprises at checkout.'],
                        ['icon' => 'package-check', 'title' => 'Track & Enjoy', 'desc' => 'Watch your order live from kitchen to doorstep, then sit back and dig in.'],
                    ];
                @endphp
                @foreach($steps as $i => $s)
                    <div style="position:relative; padding:32px 26px; border-radius:20px; background:#FAF7F2; border:1px solid #F0F0EC;">
                        <span style="position:absolute; top:20px; right:24px; font-family:'Poppins',sans-serif; font-size:42px; font-weight:800; color:#EFE9DF;">0{{ $i + 1 }}</span>
                        <div
                            style="width:52px; height:52px; background:#0D0D0D; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-bottom:18px; position:relative;">
                            <i data-lucide="{{ $s['icon'] }}" style="width:24px; height:24px; color:#C25A2A;"></i>
                        </div>
                        <h3 style="font-family:'Poppins',sans-serif; font-size:18px; font-weight:700; margin:0 0 10px; color:#0D0D0D; position:relative;">{{ $s['title'] }}</h3>
                        <p style="color:#6B7280; font-size:14px; line-height:1.7; margin:0; position:relative;">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

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
                        Get <span style="color:#C25A2A;">Discount</span><br>On Your Orders
                    </h2>
                    <p style="color:#D1D5DB; font-size:16px; line-height:1.8; margin:0 0 32px; max-width:420px;">
                        Enjoy premium dishes from top restaurants. Fresh food, fast delivery, best experience guaranteed.
                    </p>
                    <a href="#restaurants" class="btn-primary"
                        style="padding:14px 30px; font-size:15px; display:inline-flex; align-items:center; gap:9px; text-decoration:none;">
                        <i data-lucide="shopping-bag" style="width:17px; height:17px;"></i> Order Food Now
                    </a>
                </div>

                <div class="offer-img" style="position:relative;">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=2081"
                        alt="Special Restaurant Offer in Hounslow"
                        loading="lazy"
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
                    ['icon' => 'percent', 'title' => 'Zero Commission', 'desc' => 'Restaurants keep 100% of every order — savings that reach your bill.', 'color' => '#C25A2A'],
                    ['icon' => 'truck', 'title' => 'Fast Delivery', 'desc' => 'Quick and safe delivery right at your doorstep in 30 minutes.', 'color' => '#2563EB'],
                    ['icon' => 'shield-check', 'title' => 'Secure Payment', 'desc' => '100% secure online payment with end-to-end encryption.', 'color' => '#7C3AED'],
                    ['icon' => 'leaf', 'title' => 'Fresh Food', 'desc' => 'High quality fresh ingredients sourced daily from local kitchens.', 'color' => '#16A34A'],
                ];
            @endphp
            @foreach($features as $f)
                <div class="card"
                    style="padding:30px 22px; text-align:center; transition:transform .22s; border:1px solid #F0F0EC; background:#fff; border-radius:18px;"
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

    <!-- ══════════════════════════════════════
         TESTIMONIALS
    ══════════════════════════════════════ -->
    <section style="background:#fff; padding:80px 0;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="text-align:center; margin-bottom:52px;">
                <p
                    style="color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; letter-spacing:.1em; text-transform:uppercase; margin:0 0 8px;">
                    Real Orders, Real People</p>
                <h2 class="section-title"
                    style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; margin:0; letter-spacing:-.4px;">
                    What Our Customers Say</h2>
            </div>

            <div class="testimonial-grid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:22px;">
                @php
                    $testimonials = [
                        ['name' => 'Aisha K.', 'role' => 'Hounslow', 'quote' => 'Food arrived hot and the prices matched the restaurant menu exactly. No hidden markup, finally.'],
                        ['name' => 'Daniel R.', 'role' => 'Ealing', 'quote' => 'Ordering felt quick and the delivery tracking was spot on. My go-to app now for weeknight dinners.'],
                        ['name' => 'Priya S.', 'role' => 'Southall', 'quote' => 'Love that small local restaurants get to keep their full earnings. Great food, great cause.'],
                    ];
                @endphp
                @foreach($testimonials as $t)
                    <div style="background:#FAF7F2; border-radius:20px; padding:30px; border:1px solid #F0F0EC;">
                        <div style="display:flex; gap:3px; margin-bottom:16px;">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star" style="width:15px; height:15px; color:#C25A2A; fill:#C25A2A;"></i>
                            @endfor
                        </div>
                        <p style="color:#374151; font-size:14px; line-height:1.8; margin:0 0 22px;">"{{ $t['quote'] }}"</p>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; border-radius:50%; background:#0D0D0D; color:#C25A2A; display:flex; align-items:center; justify-content:center; font-family:'Poppins',sans-serif; font-weight:700; font-size:14px;">
                                {{ substr($t['name'], 0, 1) }}
                            </div>
                            <div>
                                <p style="margin:0; font-size:13px; font-weight:700; font-family:'Poppins',sans-serif; color:#0D0D0D;">{{ $t['name'] }}</p>
                                <p style="margin:0; font-size:12px; color:#9CA3AF;">{{ $t['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════
         APP DOWNLOAD CTA
    ══════════════════════════════════════ -->
    <section style="background:#C25A2A; padding:64px 0; display:none;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:28px;">
            <div style="max-width:540px;">
                <h2 style="font-family:'Poppins',sans-serif; font-size:30px; font-weight:800; color:#fff; margin:0 0 10px; letter-spacing:-.3px;">
                    Get the HYST app for faster ordering
                </h2>
                <p style="color:rgba(255,255,255,.85); font-size:15px; line-height:1.7; margin:0;">
                    Order, track delivery, and save your favourite restaurants — all from your phone.
                </p>
            </div>
            <div style="display:flex; gap:14px; flex-wrap:wrap;">
                <a href="#" style="display:flex; align-items:center; gap:10px; background:#0D0D0D; color:#fff; padding:12px 20px; border-radius:12px; text-decoration:none;">
                    <i data-lucide="apple" style="width:22px; height:22px;"></i>
                    <span style="font-family:'Poppins',sans-serif; font-size:13px; font-weight:600;">App Store</span>
                </a>
                <a href="#" style="display:flex; align-items:center; gap:10px; background:#0D0D0D; color:#fff; padding:12px 20px; border-radius:12px; text-decoration:none;">
                    <i data-lucide="play" style="width:20px; height:20px;"></i>
                    <span style="font-family:'Poppins',sans-serif; font-size:13px; font-weight:600;">Google Play</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════════════════════════════
         MINI RETRO TV AD POPUP (Bottom-Left England Matchday Showcase)
    ══════════════════════════════════════════════════════════════ -->
    @php
        try {
            $tvPlayers = \App\Models\PlayerCatalogue::where('is_active', 1)
                ->orderBy('overall_rating', 'desc')
                ->take(6)
                ->get();
        } catch (\Throwable $e) {
            $tvPlayers = collect();
        }

        if ($tvPlayers->isEmpty()) {
            $tvPlayers = collect([
                (object)[
                    'name' => 'Harry Kane',
                    'club_name' => 'England Captain',
                    'position' => 'ST',
                    'overall_rating' => 90,
                    'image_url' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p78830.png',
                ],
                (object)[
                    'name' => 'Bukayo Saka',
                    'club_name' => 'Arsenal',
                    'position' => 'RW',
                    'overall_rating' => 88,
                    'image_url' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p223340.png',
                ],
                (object)[
                    'name' => 'Cole Palmer',
                    'club_name' => 'Chelsea',
                    'position' => 'CAM',
                    'overall_rating' => 88,
                    'image_url' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p244855.png',
                ],
                (object)[
                    'name' => 'Phil Foden',
                    'club_name' => 'Man City',
                    'position' => 'LW',
                    'overall_rating' => 88,
                    'image_url' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p209244.png',
                ],
            ]);
        }
        $firstTvPlayer = $tvPlayers->first();
    @endphp
    <div id="hyst-tv-ad-widget" class="hyst-tv-container" style="display:none;" role="complementary" aria-label="England Matchday Fantasy XI Ad">
        
        <!-- TV Antennas -->
        <div class="hyst-tv-antenna-wrap">
            <div class="hyst-tv-antenna hyst-antenna-left"></div>
            <div class="hyst-tv-antenna hyst-antenna-right"></div>
        </div>

        <!-- TV Body / Frame -->
        <div class="hyst-tv-casing">
            
            <!-- TV Top Panel Controls & Close Button -->
            <div class="hyst-tv-top-bar">
                <div class="hyst-tv-power-led" title="Live Broadcast"></div>
                <div class="hyst-tv-brand-tag">HYST-TV &bull; CH-11</div>
                
                <!-- Close Button -->
                <button type="button" 
                        class="hyst-tv-close-btn" 
                        onclick="event.stopPropagation(); closeHystTvAd();" 
                        title="Close Ad" 
                        aria-label="Close Advertisement">
                    &times;
                </button>
            </div>

            <!-- TV Screen (Clickable Ad Link) -->
            <a href="{{ route('matchday.index') }}" class="hyst-tv-screen-link" title="Play Hyst Fantasy XI">
                <div class="hyst-tv-screen">
                    <!-- Glass Reflection Overlay -->
                    <div class="hyst-tv-glass-glare"></div>
                    <!-- CRT Scanlines -->
                    <div class="hyst-tv-scanlines"></div>

                    <!-- Screen Header: Live Badge & OVR -->
                    <div class="hyst-tv-screen-header">
                        <span class="hyst-tv-live-pill">
                            <span class="hyst-live-dot"></span> LIVE &bull; UK FEST
                        </span>
                        <span id="hyst-tv-ovr-pill" class="hyst-tv-ovr-pill">{{ $firstTvPlayer->overall_rating }} OVR</span>
                    </div>

                    <!-- Player Carousel Stage (Dynamic Admin CRUD Connected) -->
                    <div class="hyst-tv-player-stage">
                        @foreach($tvPlayers as $tIdx => $tp)
                            <div class="hyst-tv-slide {{ $tIdx === 0 ? 'active' : '' }}" 
                                 data-name="{{ $tp->name }}" 
                                 data-role="{{ $tp->club_name }} &bull; {{ $tp->position }}" 
                                 data-ovr="{{ $tp->overall_rating }} OVR">
                                <img src="{{ $tp->image_url }}" 
                                     alt="{{ $tp->name }}" 
                                     class="hyst-tv-player-img" 
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($tp->name) }}&background=0F172A&color=FFF';">
                            </div>
                        @endforeach
                    </div>

                    <!-- Player Meta Caption -->
                    <div class="hyst-tv-player-meta">
                        <div id="hyst-tv-player-name" class="hyst-tv-name">{{ $firstTvPlayer->name }}</div>
                        <div id="hyst-tv-player-role" class="hyst-tv-role">{{ $firstTvPlayer->club_name }} &bull; {{ $firstTvPlayer->position }}</div>
                    </div>

                    <!-- Mini CTA Banner inside Screen -->
                    <div class="hyst-tv-cta-bar">
                        <div class="hyst-tv-cta-text">
                            <span>⚽ Unlock cards with food!</span>
                        </div>
                        <span class="hyst-tv-play-btn">Pick XI &rarr;</span>
                    </div>

                </div>
            </a>

            <!-- TV Bottom Speaker Bar & Dials -->
            <div class="hyst-tv-bottom-bar">
                <div class="hyst-tv-speakers">
                    <span></span><span></span><span></span><span></span>
                </div>
                <div class="hyst-tv-dials">
                    <div class="hyst-tv-dial"></div>
                    <div class="hyst-tv-dial"></div>
                </div>
            </div>

        </div>

        <!-- TV Stand Legs -->
        <div class="hyst-tv-feet">
            <div class="hyst-tv-foot hyst-foot-left"></div>
            <div class="hyst-tv-foot hyst-foot-right"></div>
        </div>

    </div>

    <style>
        /* ══════════════════════════════════════
           MINI TV AD WIDGET STYLES
        ══════════════════════════════════════ */
        .hyst-tv-container {
            position: fixed;
            bottom: 24px;
            left: 24px;
            z-index: 9999;
            width: 240px;
            font-family: 'Poppins', system-ui, -apple-system, sans-serif;
            user-select: none;
            animation: hystTvSpringIn 0.75s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
            filter: drop-shadow(0 18px 30px rgba(0, 0, 0, 0.45));
            transition: transform 0.25s ease, filter 0.25s ease;
        }

        .hyst-tv-container:hover {
            transform: translateY(-4px) scale(1.02);
            filter: drop-shadow(0 24px 38px rgba(194, 90, 42, 0.35));
        }

        /* Power-off dismissal animation */
        .hyst-tv-container.tv-powering-off {
            animation: hystTvPowerOff 0.45s cubic-bezier(0.4, 0, 1, 1) forwards !important;
            pointer-events: none;
        }

        @keyframes hystTvSpringIn {
            0% {
                opacity: 0;
                transform: translateY(120px) scale(0.6) rotate(-4deg);
            }
            70% {
                opacity: 1;
                transform: translateY(-8px) scale(1.04) rotate(1deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0deg);
            }
        }

        @keyframes hystTvPowerOff {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scaleX(1.1) scaleY(0.04);
                opacity: 0.9;
                filter: brightness(2.5);
            }
            100% {
                transform: scale(0);
                opacity: 0;
            }
        }

        /* Antennas */
        .hyst-tv-antenna-wrap {
            position: relative;
            height: 18px;
            width: 100%;
        }

        .hyst-tv-antenna {
            position: absolute;
            bottom: 0;
            width: 3px;
            height: 22px;
            background: linear-gradient(to top, #64748B, #CBD5E1);
            border-radius: 2px;
            transform-origin: bottom center;
        }

        .hyst-tv-antenna::after {
            content: '';
            position: absolute;
            top: -4px;
            left: -2.5px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: radial-gradient(circle, #F1F5F9, #94A3B8);
            box-shadow: 0 0 4px rgba(255, 255, 255, 0.8);
        }

        .hyst-antenna-left {
            left: 36%;
            transform: rotate(-26deg);
        }

        .hyst-antenna-right {
            right: 36%;
            transform: rotate(26deg);
        }

        /* TV Outer Casing */
        .hyst-tv-casing {
            background: linear-gradient(155deg, #1E293B 0%, #0F172A 60%, #020617 100%);
            border: 3px solid #334155;
            border-radius: 18px;
            padding: 7px 8px 6px;
            box-shadow: inset 0 2px 3px rgba(255, 255, 255, 0.15),
                        inset 0 -3px 6px rgba(0, 0, 0, 0.8);
            position: relative;
        }

        /* Top Bar & Close */
        .hyst-tv-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4px 5px;
        }

        .hyst-tv-power-led {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #EF4444;
            box-shadow: 0 0 6px #EF4444;
            animation: hystLedBlink 1.8s infinite;
        }

        @keyframes hystLedBlink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }

        .hyst-tv-brand-tag {
            font-size: 8.5px;
            font-weight: 800;
            color: #94A3B8;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .hyst-tv-close-btn {
            background: #334155;
            border: 1px solid #475569;
            color: #E2E8F0;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            line-height: 1;
            cursor: pointer;
            padding: 0;
            transition: all 0.15s ease;
        }

        .hyst-tv-close-btn:hover {
            background: #DC2626;
            color: #fff;
            border-color: #EF4444;
            transform: scale(1.15) rotate(90deg);
        }

        /* TV Screen Link */
        .hyst-tv-screen-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        /* Screen Surface */
        .hyst-tv-screen {
            position: relative;
            background: radial-gradient(circle at 50% 30%, #172554 0%, #0B132B 65%, #030712 100%);
            border-radius: 12px;
            border: 2px solid #1E293B;
            padding: 6px 8px;
            overflow: hidden;
            box-shadow: inset 0 0 16px rgba(0, 0, 0, 0.95);
        }

        /* Glass reflection */
        .hyst-tv-glass-glare {
            position: absolute;
            top: -40%;
            left: -20%;
            width: 140%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.02) 45%, transparent 60%);
            transform: rotate(-18deg);
            pointer-events: none;
            z-index: 5;
        }

        /* CRT Scanlines */
        .hyst-tv-scanlines {
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.14) 0px,
                rgba(0, 0, 0, 0.14) 1px,
                transparent 1px,
                transparent 3px
            );
            pointer-events: none;
            z-index: 6;
        }

        /* Screen Header */
        .hyst-tv-screen-header {
            position: relative;
            z-index: 7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .hyst-tv-live-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(0, 0, 0, 0.55);
            border: 1px solid rgba(239, 68, 68, 0.5);
            padding: 1px 5px;
            border-radius: 6px;
            font-size: 8px;
            font-weight: 800;
            color: #F87171;
            letter-spacing: 0.3px;
        }

        .hyst-live-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #EF4444;
            animation: hystLedBlink 1s infinite;
        }

        .hyst-tv-ovr-pill {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: #0F172A;
            font-size: 8.5px;
            font-weight: 900;
            padding: 1px 5px;
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(245, 158, 11, 0.4);
        }

        /* Player Carousel Stage */
        .hyst-tv-player-stage {
            position: relative;
            z-index: 4;
            height: 88px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px 0;
        }

        .hyst-tv-slide {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0.88) translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .hyst-tv-slide.active {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        .hyst-tv-player-img {
            max-height: 86px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 6px 10px rgba(0, 0, 0, 0.75));
        }

        /* Player Meta */
        .hyst-tv-player-meta {
            position: relative;
            z-index: 7;
            text-align: center;
            background: rgba(15, 23, 42, 0.7);
            border-radius: 6px;
            padding: 2px 4px;
            margin-bottom: 5px;
        }

        .hyst-tv-name {
            font-size: 11px;
            font-weight: 800;
            color: #FFFFFF;
            line-height: 1.2;
            letter-spacing: -0.2px;
        }

        .hyst-tv-role {
            font-size: 9px;
            font-weight: 600;
            color: #FBBF24;
            line-height: 1.1;
        }

        /* Inside-screen CTA */
        .hyst-tv-cta-bar {
            position: relative;
            z-index: 7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 7px;
            padding: 3px 6px;
            gap: 4px;
        }

        .hyst-tv-cta-text {
            font-size: 8px;
            color: #E2E8F0;
            font-weight: 700;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .hyst-tv-play-btn {
            background: linear-gradient(135deg, #C25A2A 0%, #E06530 100%);
            color: #FFFFFF;
            font-size: 8.5px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 5px;
            letter-spacing: 0.2px;
            box-shadow: 0 1px 4px rgba(194, 90, 42, 0.5);
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .hyst-tv-screen-link:hover .hyst-tv-play-btn {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: #0F172A;
            transform: scale(1.05);
        }

        /* TV Bottom Grille & Dials */
        .hyst-tv-bottom-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 6px 1px;
        }

        .hyst-tv-speakers {
            display: flex;
            gap: 3px;
        }

        .hyst-tv-speakers span {
            width: 14px;
            height: 2.5px;
            background: #334155;
            border-radius: 1px;
        }

        .hyst-tv-dials {
            display: flex;
            gap: 4px;
        }

        .hyst-tv-dial {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: radial-gradient(circle, #94A3B8, #475569);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.5);
        }

        /* TV Feet */
        .hyst-tv-feet {
            display: flex;
            justify-content: space-between;
            padding: 0 24px;
        }

        .hyst-tv-foot {
            width: 14px;
            height: 5px;
            background: #0F172A;
            border-bottom: 2px solid #020617;
            border-radius: 0 0 3px 3px;
        }

        .hyst-foot-left { transform: skewX(12deg); }
        .hyst-foot-right { transform: skewX(-12deg); }

        /* Responsive Mobile Rules */
        @media (max-width: 640px) {
            .hyst-tv-container {
                left: 14px;
                bottom: 74px; /* Sits cleanly above mobile navigation bars */
                width: 210px;
            }
            .hyst-tv-player-stage {
                height: 78px;
            }
            .hyst-tv-player-img {
                max-height: 76px;
            }
        }
    </style>

    <script>
        (function() {
            var tvWidget = document.getElementById('hyst-tv-ad-widget');
            if (!tvWidget) return;

            // Check if dismissed previously in this session
            if (sessionStorage.getItem('hyst_tv_ad_closed') === '1') {
                return;
            }

            // Display TV after gentle entrance delay (1.8s)
            setTimeout(function() {
                if (sessionStorage.getItem('hyst_tv_ad_closed') !== '1') {
                    tvWidget.style.display = 'block';
                }
            }, 1800);

            // Slides Carousel Rotation
            var slides = tvWidget.querySelectorAll('.hyst-tv-slide');
            var nameEl = document.getElementById('hyst-tv-player-name');
            var roleEl = document.getElementById('hyst-tv-player-role');
            var ovrEl = document.getElementById('hyst-tv-ovr-pill');
            var currentIdx = 0;

            if (slides.length > 1) {
                setInterval(function() {
                    if (tvWidget.style.display === 'none' || tvWidget.classList.contains('tv-powering-off')) return;
                    
                    slides[currentIdx].classList.remove('active');
                    currentIdx = (currentIdx + 1) % slides.length;
                    var nextSlide = slides[currentIdx];
                    nextSlide.classList.add('active');

                    if (nameEl) nameEl.textContent = nextSlide.getAttribute('data-name');
                    if (roleEl) roleEl.innerHTML = nextSlide.getAttribute('data-role');
                    if (ovrEl) ovrEl.textContent = nextSlide.getAttribute('data-ovr');
                }, 3200);
            }
        })();

        function closeHystTvAd() {
            var tvWidget = document.getElementById('hyst-tv-ad-widget');
            if (!tvWidget) return;

            // Play CRT power-off animation
            tvWidget.classList.add('tv-powering-off');
            sessionStorage.setItem('hyst_tv_ad_closed', '1');

            setTimeout(function() {
                tvWidget.style.display = 'none';
            }, 450);
        }
    </script>

@endsection