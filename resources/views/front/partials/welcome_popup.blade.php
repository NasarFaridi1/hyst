{{-- 
    HYST — Premium Gen-Z Customer Welcome Popup Experience
    High-fashion, luxury lifestyle food ordering introduction
--}}
@php
    $welcomeUser = auth()->user();
    $welcomeCircleCode = 'HYST';
    if ($welcomeUser) {
        try {
            $circle = \App\Models\Community::getOrCreateForUser($welcomeUser);
            if ($circle) {
                $welcomeCircleCode = $circle->invite_code;
            }
        } catch (\Throwable $e) {}
    }
    $communityInviteUrl = url('/community/join/' . $welcomeCircleCode);
    $whatsappText = urlencode("Hey! I'm using HYST for genuine local restaurant ordering without high app markups. Join my Foodie Circle so we can share our favorite food thoughts, dish picks, and reviews together: " . $communityInviteUrl);
    $welcomeWhatsappUrl = "https://api.whatsapp.com/send?text=" . $whatsappText;
@endphp
<div id="hyst-welcome-popup-root" 
     class="fixed inset-0 z-[100000] flex items-center justify-center p-3 sm:p-5 md:p-8 overflow-y-auto"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="hyst-welcome-heading"
     style="display: none;">

    <!-- Ambient Dark Cinema Backdrop with Refined Blur -->
    <div id="hyst-welcome-backdrop" 
         class="fixed inset-0 bg-[#070605]/80 backdrop-blur-md transition-opacity duration-400 ease-out opacity-0"
         onclick="closeHystWelcomeModal()"></div>

    <!-- Main Editorial Modal Card -->
    <div id="hyst-welcome-card" 
         class="relative w-full max-w-4xl bg-[#0D0B09] rounded-3xl shadow-[0_25px_70px_rgba(0,0,0,0.85),0_0_50px_rgba(194,90,42,0.18)] border border-white/10 overflow-hidden transform scale-95 translate-y-3 opacity-0 transition-all duration-400 ease-out z-10 my-auto text-white">

        <!-- Subtle Top Ambient Glow Line -->
        <div class="h-[3px] w-full bg-gradient-to-r from-transparent via-[#C25A2A] to-transparent opacity-90"></div>

        <!-- Sleek Close Button -->
        <button type="button" 
                onclick="closeHystWelcomeModal()" 
                class="absolute top-4 right-4 sm:top-5 sm:right-5 z-20 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/10 hover:bg-white/20 active:scale-95 border border-white/10 backdrop-blur-md flex items-center justify-center text-stone-300 hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/50"
                aria-label="Close welcome message">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-transform duration-200 hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
            
            <!-- Left Column: Storytelling & Action (7 cols) -->
            <div class="lg:col-span-7 p-6 sm:p-8 md:p-10 flex flex-col justify-between relative z-10 order-2 lg:order-1">
                
                <!-- Ambient Glow inside Card -->
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-[#C25A2A]/15 rounded-full blur-3xl pointer-events-none"></div>

                <div>
                    <!-- Brand Header Pill & Logo -->
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-[#C25A2A] flex items-center justify-center text-white shadow-md shadow-[#C25A2A]/40 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <span class="font-extrabold tracking-wider text-base text-white font-['Poppins']">HYST</span>
                        <span class="text-stone-600">|</span>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/5 border border-white/10 text-[10.5px] font-semibold text-amber-300/90 tracking-wide uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#C25A2A] animate-ping"></span>
                            The New Dining Era
                        </div>
                    </div>

                    <!-- Editorial Headline -->
                    <h2 id="hyst-welcome-heading" class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold tracking-tight text-white leading-[1.18] mb-3.5 font-['Poppins']">
                        Your Next Craving <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-[#FF8A50] via-[#E06530] to-[#FBBF24] bg-clip-text text-transparent">
                            Deserves More.
                        </span>
                    </h2>

                    <!-- Supporting Message -->
                    <p class="text-xs sm:text-sm text-stone-300 leading-relaxed mb-6 font-['Poppins'] font-normal">
                        Welcome to <span class="text-white font-semibold">Hyst</span> — where bold flavours meet elevated dining. Discover local culinary gems, explore signature dishes, and experience direct restaurant ordering at genuine menu prices.
                    </p>

                    <!-- Gen-Z Lifestyle Value Props -->
                    <div class="space-y-2.5 mb-7">
                        <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white/[0.04] border border-white/[0.06] hover:bg-white/[0.07] transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-[#C25A2A]/20 border border-[#C25A2A]/40 flex items-center justify-center text-sm flex-shrink-0 text-amber-300">
                                🍽️
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-[13px] font-bold text-white tracking-wide">Curated Kitchens</div>
                                <div class="text-[11px] text-stone-400 truncate">Handpicked culinary spots, authentic tastes & signature dishes.</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white/[0.04] border border-white/[0.06] hover:bg-white/[0.07] transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-sm flex-shrink-0 text-emerald-400">
                                🏷️
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-[13px] font-bold text-white tracking-wide">Zero Aggregator Markups</div>
                                <div class="text-[11px] text-stone-400 truncate">Genuine menu prices with 0% commission tax on food.</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white/[0.04] border border-white/[0.06] hover:bg-white/[0.07] transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-sm flex-shrink-0 text-blue-400">
                                ⚡
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-[13px] font-bold text-white tracking-wide">Effortless Delivery & Pickup</div>
                                <div class="text-[11px] text-stone-400 truncate">Direct kitchen dispatch powered for modern, seamless dining.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Gen-Z Foodie Circle & WhatsApp Community Invite -->
                    <div class="mb-5 p-3.5 sm:p-4 rounded-2xl bg-gradient-to-r from-emerald-950/40 via-stone-900 to-[#1C140E] border border-emerald-500/20 shadow-inner">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-sm">🍕</span>
                                <span class="text-[11px] sm:text-xs font-bold text-emerald-400 uppercase tracking-wider">Hyst Foodie Circles</span>
                            </div>
                            <span class="text-[10px] bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 px-2 py-0.5 rounded-full font-medium">New</span>
                        </div>
                        
                        <p class="text-[11.5px] sm:text-xs text-stone-300 leading-relaxed mb-3">
                            Share your thoughts, food ideas & dining experiences! Invite your friends on WhatsApp to join your Foodie Circle and swap reviews with zero markups:
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ $welcomeWhatsappUrl }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#25D366] hover:bg-[#20BD5A] text-white text-xs font-bold shadow-md shadow-[#25D366]/25 transition-all text-center">
                                <svg class="w-4 h-4 fill-current flex-shrink-0" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.044-1.109-.087-.414-.131-.954-.312-1.637-.607-1.19-.515-2.079-1.671-2.14-1.75-.062-.079-.484-.645-.484-1.232 0-.588.307-.877.417-.996.11-.119.24-.149.32-.149.08 0 .16.002.23.006.075.004.175-.029.273.208.103.249.351.856.382.919.031.063.051.137.01.218-.041.081-.062.132-.122.203-.061.071-.129.158-.184.212-.061.06-.125.126-.054.248.071.122.315.52.677.842.465.414.858.543.98.604.122.061.194.051.266-.031.072-.082.307-.358.389-.48.082-.122.164-.102.276-.061.112.041.71.335.832.396.122.061.203.092.234.143.031.051.031.296-.113.701zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.05 22l4.98-1.306A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167a8.13 8.13 0 01-4.218-1.175l-.302-.18-2.964.777.791-2.89-.196-.312A8.134 8.134 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167s8.167 3.664 8.167 8.167-3.664 8.167-8.167 8.167z"/>
                                </svg>
                                <span>Share on WhatsApp</span>
                            </a>

                            <a href="{{ route('front.community.index') }}" 
                               onclick="closeHystWelcomeModal()"
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-stone-200 text-xs font-semibold transition-all">
                                <span>Explore Community Feed →</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Action CTAs -->
                <div class="pt-2">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-3">
                        <button type="button" 
                                onclick="handleHystExploreMenu()"
                                class="inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-[#C25A2A] via-[#D97040] to-[#E06530] hover:from-[#B04E20] hover:to-[#C25A2A] active:scale-[0.98] text-white font-bold text-xs sm:text-sm tracking-wide shadow-lg shadow-[#C25A2A]/35 hover:shadow-xl hover:shadow-[#C25A2A]/50 transition-all duration-200 text-center group cursor-pointer">
                            <span>Explore the Menu</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>

                        <button type="button" 
                                onclick="handleHystDiscover()"
                                class="inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-2xl bg-white/[0.06] hover:bg-white/[0.12] active:scale-[0.98] border border-white/15 text-stone-200 hover:text-white font-semibold text-xs sm:text-sm tracking-wide transition-all duration-200 text-center cursor-pointer">
                            <span>Discover Hyst</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-stone-500 pt-1">
                        <span>No app download or account required to browse</span>
                        <button type="button" onclick="closeHystWelcomeModal()" class="hover:text-stone-300 underline underline-offset-2 transition-colors">
                            Continue browsing →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Immersive Visual & Vibe Showcase (5 cols) -->
            <div class="lg:col-span-5 relative min-h-[220px] sm:min-h-[280px] lg:min-h-full overflow-hidden order-1 lg:order-2 flex flex-col justify-end p-5 sm:p-7">
                
                <!-- Food Photography Visual with Gradient Overlays -->
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1200&auto=format&fit=crop" 
                         alt="HYST Premium Dining Experience" 
                         class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-1000 ease-out hover:scale-100"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ asset('images/FoodMenu.png') }}';">
                    <!-- Cinematic Multi-direction Dark Overlays -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0D0B09] via-[#0D0B09]/40 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0D0B09] via-transparent to-transparent hidden lg:block"></div>
                    <div class="absolute inset-0 bg-[#C25A2A]/10 mix-blend-overlay"></div>
                </div>

                <!-- Floating Gen-Z Lifestyle Badges Over Photo -->
                <div class="relative z-10 space-y-2.5">
                    
                    <!-- Trending Pill -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/60 backdrop-blur-md border border-white/20 text-xs font-medium text-white shadow-xl">
                        <span class="text-amber-400">🔥</span>
                        <span>Trending in West London</span>
                        <span class="text-stone-400 text-[10px]">• Direct Kitchens</span>
                    </div>

                    <!-- Glass Highlight Card -->
                    <div class="bg-black/60 backdrop-blur-xl border border-white/20 rounded-2xl p-3.5 shadow-2xl">
                        <div class="flex items-center justify-between gap-3 mb-1.5">
                            <span class="text-xs font-bold text-white tracking-wide flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                Honest Hospitality
                            </span>
                            <div class="flex items-center text-amber-400 text-xs gap-0.5">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-stone-300 leading-snug">
                            Every bite supports local independent chefs without aggressive third-party commission markups.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<style>
    /* Respect reduced-motion accessibility */
    @media (prefers-reduced-motion: reduce) {
        #hyst-welcome-popup-root,
        #hyst-welcome-backdrop,
        #hyst-welcome-card {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
(function() {
    const STORAGE_KEY = 'hyst_customer_welcome_dismissed_v1';
    const PREVIEW_PARAM = 'welcome_preview';
    const root = document.getElementById('hyst-welcome-popup-root');
    const backdrop = document.getElementById('hyst-welcome-backdrop');
    const card = document.getElementById('hyst-welcome-card');

    if (!root || !backdrop || !card) return;

    // Check URL parameters for explicit preview/testing mode
    const urlParams = new URLSearchParams(window.location.search);
    const isPreview = urlParams.has(PREVIEW_PARAM) || urlParams.has('preview_welcome');

    // Frequency check: once per session / 24 hours, unless in preview mode
    if (!isPreview) {
        try {
            const dismissedAt = localStorage.getItem(STORAGE_KEY) || sessionStorage.getItem(STORAGE_KEY);
            if (dismissedAt) {
                // If dismissed within last 24 hours, skip
                const lastTime = parseInt(dismissedAt, 10);
                if (!isNaN(lastTime) && (Date.now() - lastTime < 24 * 60 * 60 * 1000)) {
                    return;
                }
            }
        } catch (e) {
            // In case localStorage is blocked by privacy mode, fail quietly
        }
    }

    function showModal() {
        root.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            
            card.classList.remove('scale-95', 'translate-y-3', 'opacity-0');
            card.classList.add('scale-100', 'translate-y-0', 'opacity-100');
        });
    }

    window.closeHystWelcomeModal = function() {
        try {
            localStorage.setItem(STORAGE_KEY, Date.now().toString());
            sessionStorage.setItem(STORAGE_KEY, Date.now().toString());
        } catch (e) {}

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');

        card.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
        card.classList.add('scale-95', 'translate-y-3', 'opacity-0');

        setTimeout(() => {
            root.style.display = 'none';
            document.body.style.overflow = '';
        }, 350);
    };

    window.handleHystExploreMenu = function() {
        closeHystWelcomeModal();
        
        // If on homepage where #restaurants exists, smooth scroll to it
        const restaurantSection = document.getElementById('restaurants');
        if (restaurantSection && (window.location.pathname === '/' || window.location.pathname === '')) {
            setTimeout(() => {
                restaurantSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 360);
        } else {
            // Otherwise navigate to the restaurants page
            setTimeout(() => {
                window.location.href = "{{ route('front.restaurants') }}";
            }, 200);
        }
    };

    window.handleHystDiscover = function() {
        closeHystWelcomeModal();
        setTimeout(() => {
            window.location.href = "{{ url('/about') }}";
        }, 200);
    };

    // Keyboard support: Escape closes the modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && root.style.display === 'flex') {
            closeHystWelcomeModal();
        }
    });

    // Slight delay (~650ms) for high-end cinematic feel after initial page assets load
    setTimeout(showModal, 650);
})();
</script>
