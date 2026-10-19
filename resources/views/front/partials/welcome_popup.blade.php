{{-- 
    HYST — Premium Customer Welcome Popup Experience
    Light & Fresh Theme matching Hyst, Compact & Fully Responsive
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
     class="fixed inset-0 z-[100000] flex items-center justify-center p-3 sm:p-4 overflow-y-auto"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="hyst-welcome-heading"
     style="display: none;">

    <!-- Soft Ambient Backdrop -->
    <div id="hyst-welcome-backdrop" 
         class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0"
         onclick="closeHystWelcomeModal()"></div>

    <!-- Main Modal Card (White / Light Theme, Compact & Responsive) -->
    <div id="hyst-welcome-card" 
         class="relative w-full max-w-[760px] max-h-[92vh] bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-stone-200/90 overflow-hidden transform scale-95 translate-y-2 opacity-0 transition-all duration-300 ease-out z-10 my-auto flex flex-col">

        <!-- Top Brand Accent Line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-[#C25A2A] via-[#E06530] to-[#FBBF24] flex-shrink-0"></div>

        <!-- Solid White Cross (Close) Button - High Contrast on Mobile & Desktop -->
        <button type="button" 
                onclick="closeHystWelcomeModal()" 
                class="absolute top-3 right-3 sm:top-4 sm:right-4 z-30 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white hover:bg-stone-100 active:scale-95 shadow-md border border-stone-200 flex items-center justify-center text-stone-700 hover:text-black transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40"
                aria-label="Close welcome message">
            <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transition-transform duration-150 hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Internal Responsive Body: Scrollable if viewport is very short -->
        <div class="overflow-y-auto flex-1">
            <div class="grid grid-cols-1 md:grid-cols-12 items-stretch min-h-0">
                
                <!-- Left Column: Storytelling & Actions (7 cols) -->
                <div class="md:col-span-7 p-5 sm:p-6 lg:p-7 flex flex-col justify-between relative z-10">
                    
                    <div>
                        <!-- Brand Header Pill -->
                        <div class="flex items-center gap-2.5 mb-3.5">
                            <div class="w-7 h-7 rounded-lg bg-[#C25A2A] flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <span class="font-extrabold tracking-wider text-sm text-stone-900 font-['Poppins']">HYST</span>
                            <span class="text-stone-300">|</span>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200/80 text-[10.5px] font-bold text-amber-800 tracking-wide uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#C25A2A] animate-pulse"></span>
                                Food Delivery & Dining
                            </div>
                        </div>

                        <!-- Compact Headline -->
                        <h2 id="hyst-welcome-heading" class="text-xl sm:text-2xl font-extrabold tracking-tight text-stone-900 leading-tight mb-2 font-['Poppins']">
                            Your Next Craving <br class="hidden sm:inline">
                            <span class="text-[#C25A2A]">Deserves More.</span>
                        </h2>

                        <!-- Supporting Copy -->
                        <p class="text-xs sm:text-[13px] text-stone-600 leading-relaxed mb-4 font-['Poppins']">
                            Welcome to <span class="text-stone-900 font-semibold">Hyst</span> — where bold flavours meet elevated dining. Discover local gems, explore signature dishes, and order directly at genuine menu prices.
                        </p>

                        <!-- 3 Compact Value Chips -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-4">
                            <div class="p-2 sm:p-2.5 rounded-xl bg-stone-50 border border-stone-200/70">
                                <div class="text-xs mb-0.5">🍽️ <span class="font-bold text-stone-900 text-[11px] sm:text-xs">Curated</span></div>
                                <div class="text-[10.5px] text-stone-500 leading-tight">Handpicked local kitchens.</div>
                            </div>
                            <div class="p-2 sm:p-2.5 rounded-xl bg-emerald-50/60 border border-emerald-200/60">
                                <div class="text-xs mb-0.5">🏷️ <span class="font-bold text-emerald-900 text-[11px] sm:text-xs">0% Markup</span></div>
                                <div class="text-[10.5px] text-emerald-700 leading-tight">True menu pricing.</div>
                            </div>
                            <div class="p-2 sm:p-2.5 rounded-xl bg-amber-50/60 border border-amber-200/60">
                                <div class="text-xs mb-0.5">⚡ <span class="font-bold text-amber-900 text-[11px] sm:text-xs">Fast & Direct</span></div>
                                <div class="text-[10.5px] text-amber-700 leading-tight">Delivery & pickup.</div>
                            </div>
                        </div>

                        <!-- Gen-Z Foodie Circle & WhatsApp Community Invite -->
                        <div class="mb-4 p-3 sm:p-3.5 rounded-xl bg-gradient-to-br from-emerald-50/70 via-stone-50 to-amber-50/50 border border-emerald-200/80 shadow-xs">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm">🍕</span>
                                    <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Hyst Foodie Circles</span>
                                </div>
                                <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-bold">New</span>
                            </div>
                            
                            <p class="text-[11px] text-stone-600 leading-relaxed mb-2.5">
                                Share your food thoughts, ideas & dining experiences! Invite your friends on WhatsApp to join your Foodie Circle and swap reviews with zero markups:
                            </p>

                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ $welcomeWhatsappUrl }}" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#25D366] hover:bg-[#20BD5A] text-white text-[11px] font-bold shadow-sm transition-all text-center">
                                    <svg class="w-3.5 h-3.5 fill-current flex-shrink-0" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.044-1.109-.087-.414-.131-.954-.312-1.637-.607-1.19-.515-2.079-1.671-2.14-1.75-.062-.079-.484-.645-.484-1.232 0-.588.307-.877.417-.996.11-.119.24-.149.32-.149.08 0 .16.002.23.006.075.004.175-.029.273.208.103.249.351.856.382.919.031.063.051.137.01.218-.041.081-.062.132-.122.203-.061.071-.129.158-.184.212-.061.06-.125.126-.054.248.071.122.315.52.677.842.465.414.858.543.98.604.122.061.194.051.266-.031.072-.082.307-.358.389-.48.082-.122.164-.102.276-.061.112.041.71.335.832.396.122.061.203.092.234.143.031.051.031.296-.113.701zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.05 22l4.98-1.306A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167a8.13 8.13 0 01-4.218-1.175l-.302-.18-2.964.777.791-2.89-.196-.312A8.134 8.134 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167s8.167 3.664 8.167 8.167-3.664 8.167-8.167 8.167z"/>
                                    </svg>
                                    <span>Share on WhatsApp</span>
                                </a>

                                <a href="{{ route('front.community.index') }}" 
                                   onclick="closeHystWelcomeModal()"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-700 text-[11px] font-semibold transition-all">
                                    <span>Community Feed →</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Action CTAs -->
                    <div>
                        <div class="flex items-center gap-2.5 mb-2">
                            <button type="button" 
                                    onclick="handleHystExploreMenu()"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 rounded-xl bg-gradient-to-r from-[#C25A2A] to-[#D97040] hover:from-[#B04E20] hover:to-[#C25A2A] active:scale-[0.98] text-white font-bold text-xs sm:text-sm tracking-wide shadow-md shadow-[#C25A2A]/30 transition-all text-center cursor-pointer">
                                <span>Explore the Menu</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>

                            <button type="button" 
                                    onclick="handleHystDiscover()"
                                    class="inline-flex items-center justify-center px-3.5 py-2.5 sm:py-3 rounded-xl bg-stone-100 hover:bg-stone-200 active:scale-[0.98] border border-stone-200 text-stone-700 font-semibold text-xs sm:text-sm tracking-wide transition-all text-center cursor-pointer">
                                <span>About</span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between text-[10.5px] text-stone-400">
                            <span>No app download required</span>
                            <button type="button" onclick="closeHystWelcomeModal()" class="hover:text-stone-600 underline underline-offset-2 transition-colors">
                                Continue browsing →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Appetizing Food Image (5 cols, hidden on very small mobile) -->
                <div class="md:col-span-5 relative min-h-[200px] sm:min-h-[260px] md:min-h-full overflow-hidden flex flex-col justify-end p-4 sm:p-5 bg-stone-100">
                    
                    <!-- Food Photography with Clean Light Tint -->
                    <div class="absolute inset-0 z-0">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000&auto=format&fit=crop" 
                             alt="HYST Dining Experience" 
                             class="w-full h-full object-cover object-center"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/FoodMenu.png') }}';">
                        <!-- Soft Subtle Gradient overlay to ensure text contrast -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    </div>

                    <!-- Floating Badges over Photo -->
                    <div class="relative z-10 space-y-2">
                        <!-- Trending Pill -->
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/95 backdrop-blur-md border border-stone-200/80 text-[11px] font-semibold text-stone-800 shadow-md">
                            <span>🔥</span>
                            <span>Trending in West London</span>
                        </div>

                        <!-- Mini Glass Highlight Card -->
                        <div class="bg-white/95 backdrop-blur-md border border-stone-200/80 rounded-xl p-2.5 shadow-md text-stone-800">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-[11px] font-bold flex items-center gap-1 text-stone-900">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Zero Commission
                                </span>
                                <span class="text-amber-500 text-[11px]">★★★★★</span>
                            </div>
                            <p class="text-[10px] text-stone-500 leading-tight">
                                Supporting authentic local eateries directly with zero markup.
                            </p>
                        </div>
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
            
            card.classList.remove('scale-95', 'translate-y-2', 'opacity-0');
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
        card.classList.add('scale-95', 'translate-y-2', 'opacity-0');

        setTimeout(() => {
            root.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    };

    window.handleHystExploreMenu = function() {
        closeHystWelcomeModal();
        
        // If on homepage where #restaurants exists, smooth scroll to it
        const restaurantSection = document.getElementById('restaurants');
        if (restaurantSection && (window.location.pathname === '/' || window.location.pathname === '')) {
            setTimeout(() => {
                restaurantSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 320);
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

    // Natural smooth reveal after page render
    setTimeout(showModal, 600);
})();
</script>
