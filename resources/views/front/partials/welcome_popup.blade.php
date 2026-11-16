{{-- 
    HYST — England Football Festival & Matchday Fantasy XI Welcome Popup
    Interactive Player Spotlight with Live Switcher, England Cards & Matchday Food Ordering
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
    $whatsappText = urlencode("⚽ Join my England Fantasy XI squad on HYST! Order your matchday food with zero markup, pick England players & win the £500 Grand Prize: " . url('/matchday'));
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
         class="fixed inset-0 bg-stone-950/75 backdrop-blur-md transition-opacity duration-300 ease-out opacity-0"
         onclick="closeHystWelcomeModal()"></div>

    <!-- Main Modal Card (Football Festival Theme, Compact & Responsive) -->
    <div id="hyst-welcome-card" 
         class="relative w-full max-w-[840px] max-h-[92vh] bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-stone-200/90 overflow-hidden transform scale-95 translate-y-2 opacity-0 transition-all duration-300 ease-out z-10 my-auto flex flex-col">

        <!-- Top Football Festival Accent Line (England Flag & Gold Trophy Colors) -->
        <div class="h-2 w-full bg-gradient-to-r from-[#DC2626] via-[#F59E0B] to-[#2563EB] flex-shrink-0"></div>

        <!-- Solid Cross (Close) Button -->
        <button type="button" 
                onclick="closeHystWelcomeModal()" 
                class="absolute top-3 right-3 sm:top-4 sm:right-4 z-40 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/90 hover:bg-white active:scale-95 shadow-md border border-stone-200 flex items-center justify-center text-stone-700 hover:text-black transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40"
                aria-label="Close welcome message">
            <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transition-transform duration-150 hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Internal Responsive Body: Scrollable if viewport is very short -->
        <div class="overflow-y-auto flex-1">
            <div class="grid grid-cols-1 md:grid-cols-12 items-stretch min-h-0">
                
                <!-- Left Column: Storytelling & Actions (7 cols) -->
                <div class="md:col-span-7 p-5 sm:p-6 lg:p-7 flex flex-col justify-between relative z-10 bg-white">
                    
                    <div>
                        <!-- Festival Header Pill -->
                        <div class="flex items-center flex-wrap gap-2 mb-3">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-[11px] font-extrabold text-rose-700 tracking-wider uppercase">
                                <span class="text-sm">🏴󠁧󠁢󠁥󠁮󠁧󠁿</span>
                                <span>UK Football Festival</span>
                            </div>
                            <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-[10.5px] font-bold text-amber-800">
                                <span>🏆</span>
                                <span>£500 Grand Prize</span>
                            </div>
                        </div>

                        <!-- Main Festival Headline -->
                        <h2 id="hyst-welcome-heading" class="text-xl sm:text-2xl lg:text-[26px] font-black tracking-tight text-stone-900 leading-tight mb-2 font-['Poppins']">
                            Feast on Matchday. <br>
                            <span class="text-[#C25A2A]">Build Your England XI.</span>
                        </h2>

                        <!-- Supporting Copy -->
                        <p class="text-xs sm:text-[13px] text-stone-600 leading-relaxed mb-4 font-['Poppins']">
                            The football festival has arrived in the UK! Order matchday food directly with <strong class="text-stone-900">0% markup</strong>, unlock real England player cards, challenge your friends in free 1v1 duels, and claim the <strong class="text-amber-700">£500 Cash Prize</strong> on Dec 31, 2026.
                        </p>

                        <!-- 3 Compact Value Chips -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-4">
                            <div class="p-2 sm:p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/80">
                                <div class="text-[11px] font-bold text-amber-900 mb-0.5">🎴 Free Player Pick</div>
                                <div class="text-[10px] text-amber-800 leading-tight">Unlocked with every food order over £15.</div>
                            </div>
                            <div class="p-2 sm:p-2.5 rounded-xl bg-emerald-50/70 border border-emerald-200/80">
                                <div class="text-[11px] font-bold text-emerald-900 mb-0.5">🏷️ 0% Food Markup</div>
                                <div class="text-[10px] text-emerald-800 leading-tight">Genuine restaurant prices on HYST.</div>
                            </div>
                            <div class="p-2 sm:p-2.5 rounded-xl bg-blue-50/70 border border-blue-200/80">
                                <div class="text-[11px] font-bold text-blue-900 mb-0.5">⚔️ Free 1v1 Duels</div>
                                <div class="text-[10px] text-blue-800 leading-tight">Play mates & earn football rewards.</div>
                            </div>
                        </div>

                        <!-- Matchday Quick WhatsApp Invite -->
                        <div class="mb-4 p-2.5 sm:p-3 rounded-xl bg-stone-50 border border-stone-200/80 flex items-center justify-between gap-2">
                            <div class="text-[11px] text-stone-700 font-medium">
                                <span class="font-bold text-stone-900">Invite Friends:</span> Back players & swap football cards together!
                            </div>
                            <a href="{{ $welcomeWhatsappUrl }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-[#25D366] hover:bg-[#20BD5A] text-white text-[10.5px] font-bold shadow-xs transition-all whitespace-nowrap">
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.044-1.109-.087-.414-.131-.954-.312-1.637-.607-1.19-.515-2.079-1.671-2.14-1.75-.062-.079-.484-.645-.484-1.232 0-.588.307-.877.417-.996.11-.119.24-.149.32-.149.08 0 .16.002.23.006.075.004.175-.029.273.208.103.249.351.856.382.919.031.063.051.137.01.218-.041.081-.062.132-.122.203-.061.071-.129.158-.184.212-.061.06-.125.126-.054.248.071.122.315.52.677.842.465.414.858.543.98.604.122.061.194.051.266-.031.072-.082.307-.358.389-.48.082-.122.164-.102.276-.061.112.041.71.335.832.396.122.061.203.092.234.143.031.051.031.296-.113.701zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.05 22l4.98-1.306A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167a8.13 8.13 0 01-4.218-1.175l-.302-.18-2.964.777.791-2.89-.196-.312A8.134 8.134 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167s8.167 3.664 8.167 8.167-3.664 8.167-8.167 8.167z"/>
                                </svg>
                                <span>Share</span>
                            </a>
                        </div>
                    </div>

                    <!-- Action CTAs -->
                    <div>
                        <div class="flex items-center gap-2.5 mb-2">
                            <a href="{{ route('matchday.index') }}" 
                               class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 rounded-xl bg-gradient-to-r from-[#C25A2A] to-[#D97040] hover:from-[#B04E20] hover:to-[#C25A2A] active:scale-[0.98] text-white font-bold text-xs sm:text-sm tracking-wide shadow-md shadow-[#C25A2A]/30 transition-all text-center">
                                <span>Build England XI</span>
                                <span>⚽</span>
                            </a>

                            <button type="button" 
                                    onclick="handleHystExploreMenu()"
                                    class="inline-flex items-center justify-center px-4 py-2.5 sm:py-3 rounded-xl bg-stone-900 hover:bg-black active:scale-[0.98] text-white font-semibold text-xs sm:text-sm tracking-wide transition-all text-center cursor-pointer">
                                <span>Order Food</span>
                                <span>🍔</span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between text-[10.5px] text-stone-400">
                            <span>100% Free to Play &bull; No Gambling</span>
                            <button type="button" onclick="closeHystWelcomeModal()" class="hover:text-stone-600 underline underline-offset-2 transition-colors">
                                Continue to website →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive England Player Showcase (5 cols) -->
                <div class="md:col-span-5 relative min-h-[300px] sm:min-h-[360px] md:min-h-full overflow-hidden flex flex-col justify-between p-4 sm:p-5 bg-gradient-to-br from-[#0A192F] via-[#0F2744] to-[#1E3A8A] text-white">
                    
                    <!-- Ambient Stadium Lights & Pitch Glow -->
                    <div class="absolute inset-0 pointer-events-none opacity-30">
                        <div class="absolute -top-10 -left-10 w-44 h-44 rounded-full bg-blue-500 blur-3xl"></div>
                        <div class="absolute top-1/2 -right-10 w-48 h-48 rounded-full bg-amber-500 blur-3xl"></div>
                        <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-[#0A192F] to-transparent"></div>
                    </div>

                    <!-- Top Card Status -->
                    <div class="relative z-10 flex items-center justify-between">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[10.5px] font-bold text-amber-300">
                            <span>⭐</span>
                            <span id="popup-player-rarity">STAR CARD</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] uppercase tracking-wider text-blue-200 block">Season Grand Prize</span>
                            <span class="text-xs font-black text-amber-400 font-['Poppins']">£500 CASH</span>
                        </div>
                    </div>

                    <!-- Dynamic Player Cutout Portrait with Glow -->
                    <div class="relative z-10 my-auto py-2 text-center flex flex-col items-center justify-center">
                        <div class="relative w-36 h-36 sm:w-44 sm:h-44 flex items-center justify-center">
                            <!-- Golden Aura behind portrait -->
                            <div class="absolute inset-0 rounded-full bg-radial from-amber-400/20 via-transparent to-transparent blur-xl"></div>
                            
                            <img id="popup-player-img" 
                                 src="https://resources.premierleague.com/premierleague/photos/players/250x250/p78830.png" 
                                 alt="Harry Kane" 
                                 class="w-full h-full object-contain filter drop-shadow-[0_12px_20px_rgba(0,0,0,0.6)] transition-all duration-300 transform scale-100"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Harry+Kane&background=0A192F&color=FFFFFF&size=250&bold=true';">

                            <!-- Rating Badge Floating -->
                            <div class="absolute -top-1 -left-1 w-11 h-11 rounded-xl bg-black/80 backdrop-blur-md border border-amber-400/80 flex flex-col items-center justify-center text-center shadow-lg">
                                <span id="popup-player-ovr" class="font-extrabold text-[15px] text-amber-400 leading-none font-['Poppins']">90</span>
                                <span id="popup-player-pos" class="text-[8px] font-bold text-white uppercase">ST</span>
                            </div>
                        </div>

                        <!-- Player Name & Club -->
                        <div class="mt-2 text-center">
                            <h3 id="popup-player-name" class="font-black text-base sm:text-lg text-white font-['Poppins'] tracking-tight">Harry Kane</h3>
                            <p id="popup-player-club" class="text-[11px] text-blue-200 font-medium">England Captain &bull; FWD</p>
                        </div>

                        <!-- Mini Stats Pill Bar -->
                        <div class="mt-3 flex items-center justify-center gap-1.5 text-[10px] font-bold bg-white/10 backdrop-blur-md border border-white/15 px-3 py-1 rounded-full text-stone-200">
                            <span>ATT <strong id="popup-player-att" class="text-amber-300">93</strong></span>
                            <span class="text-white/30">&bull;</span>
                            <span>MID <strong id="popup-player-mid" class="text-amber-300">85</strong></span>
                            <span class="text-white/30">&bull;</span>
                            <span>DEF <strong id="popup-player-def" class="text-amber-300">46</strong></span>
                        </div>
                    </div>

                    <!-- Interactive Switcher (Click to switch player) -->
                    <div class="relative z-10">
                        <div class="text-[10px] text-center text-blue-200 mb-1.5 font-semibold">Tap to inspect England stars:</div>
                        <div class="grid grid-cols-4 gap-1">
                            <button type="button" 
                                    onclick="switchPopupPlayer(0)" 
                                    id="player-tab-0"
                                    class="py-1 px-1.5 rounded-lg bg-white/20 border border-amber-400 text-center transition-all cursor-pointer">
                                <span class="block text-[10px] font-bold text-amber-300 leading-tight">Kane</span>
                                <span class="block text-[8px] text-white/70">90 OVR</span>
                            </button>
                            <button type="button" 
                                    onclick="switchPopupPlayer(1)" 
                                    id="player-tab-1"
                                    class="py-1 px-1.5 rounded-lg bg-white/5 border border-white/10 text-center transition-all cursor-pointer hover:bg-white/15">
                                <span class="block text-[10px] font-bold text-white leading-tight">Saka</span>
                                <span class="block text-[8px] text-white/70">88 OVR</span>
                            </button>
                            <button type="button" 
                                    onclick="switchPopupPlayer(2)" 
                                    id="player-tab-2"
                                    class="py-1 px-1.5 rounded-lg bg-white/5 border border-white/10 text-center transition-all cursor-pointer hover:bg-white/15">
                                <span class="block text-[10px] font-bold text-white leading-tight">Palmer</span>
                                <span class="block text-[8px] text-white/70">88 OVR</span>
                            </button>
                            <button type="button" 
                                    onclick="switchPopupPlayer(3)" 
                                    id="player-tab-3"
                                    class="py-1 px-1.5 rounded-lg bg-white/5 border border-white/10 text-center transition-all cursor-pointer hover:bg-white/15">
                                <span class="block text-[10px] font-bold text-white leading-tight">Rice</span>
                                <span class="block text-[8px] text-white/70">87 OVR</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script>
(function() {
    const STORAGE_KEY = 'hyst_england_football_fest_dismissed_v2';
    const root = document.getElementById('hyst-welcome-popup-root');
    const backdrop = document.getElementById('hyst-welcome-backdrop');
    const card = document.getElementById('hyst-welcome-card');

    if (!root || !backdrop || !card) return;

    // England Players Dataset for Interactive Spotlight
    const popupPlayers = [
        {
            name: "Harry Kane",
            club: "England Captain • FWD",
            ovr: "90",
            pos: "ST",
            rarity: "STAR CARD",
            att: "93",
            mid: "85",
            def: "46",
            img: "https://resources.premierleague.com/premierleague/photos/players/250x250/p78830.png"
        },
        {
            name: "Bukayo Saka",
            club: "Arsenal • FWD",
            ovr: "88",
            pos: "RW",
            rarity: "STAR CARD",
            att: "89",
            mid: "84",
            def: "65",
            img: "https://resources.premierleague.com/premierleague/photos/players/250x250/p223340.png"
        },
        {
            name: "Cole Palmer",
            club: "Chelsea • MID",
            ovr: "88",
            pos: "CAM",
            rarity: "STAR CARD",
            att: "88",
            mid: "89",
            def: "48",
            img: "https://resources.premierleague.com/premierleague/photos/players/250x250/p244855.png"
        },
        {
            name: "Declan Rice",
            club: "Arsenal • MID",
            ovr: "87",
            pos: "CDM",
            rarity: "STAR CARD",
            att: "75",
            mid: "87",
            def: "88",
            img: "https://resources.premierleague.com/premierleague/photos/players/250x250/p204480.png"
        }
    ];

    window.switchPopupPlayer = function(index) {
        const p = popupPlayers[index];
        if (!p) return;

        const img = document.getElementById('popup-player-img');
        const name = document.getElementById('popup-player-name');
        const club = document.getElementById('popup-player-club');
        const ovr = document.getElementById('popup-player-ovr');
        const pos = document.getElementById('popup-player-pos');
        const att = document.getElementById('popup-player-att');
        const mid = document.getElementById('popup-player-mid');
        const def = document.getElementById('popup-player-def');

        if (img) {
            img.style.opacity = '0';
            img.style.transform = 'scale(0.9)';
            setTimeout(() => {
                img.src = p.img;
                name.innerText = p.name;
                club.innerText = p.club;
                ovr.innerText = p.ovr;
                pos.innerText = p.pos;
                att.innerText = p.att;
                mid.innerText = p.mid;
                def.innerText = p.def;
                img.style.opacity = '1';
                img.style.transform = 'scale(1)';
            }, 150);
        }

        for (let i = 0; i < popupPlayers.length; i++) {
            const btn = document.getElementById('player-tab-' + i);
            if (btn) {
                if (i === index) {
                    btn.className = 'py-1 px-1.5 rounded-lg bg-white/20 border border-amber-400 text-center transition-all cursor-pointer';
                    btn.querySelector('span:first-child').className = 'block text-[10px] font-bold text-amber-300 leading-tight';
                } else {
                    btn.className = 'py-1 px-1.5 rounded-lg bg-white/5 border border-white/10 text-center transition-all cursor-pointer hover:bg-white/15';
                    btn.querySelector('span:first-child').className = 'block text-[10px] font-bold text-white leading-tight';
                }
            }
        }
    };

    // Auto rotate every 4 seconds if modal is open
    let autoRotateInterval = setInterval(() => {
        if (root.style.display === 'flex') {
            const currentTab = document.querySelector('[id^="player-tab-"].border-amber-400');
            const currentIndex = currentTab ? parseInt(currentTab.id.replace('player-tab-', ''), 10) : 0;
            const nextIndex = (currentIndex + 1) % popupPlayers.length;
            switchPopupPlayer(nextIndex);
        }
    }, 4000);

    // Check URL parameters for explicit preview/testing mode
    const urlParams = new URLSearchParams(window.location.search);
    const isPreview = urlParams.has('welcome_preview') || urlParams.has('preview_welcome') || urlParams.has('matchday');

    if (!isPreview) {
        try {
            const dismissedAt = localStorage.getItem(STORAGE_KEY) || sessionStorage.getItem(STORAGE_KEY);
            if (dismissedAt) {
                const lastTime = parseInt(dismissedAt, 10);
                if (!isNaN(lastTime) && (Date.now() - lastTime < 12 * 60 * 60 * 1000)) {
                    return;
                }
            }
        } catch (e) {}
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

        if (autoRotateInterval) clearInterval(autoRotateInterval);

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
        const restaurantSection = document.getElementById('restaurants');
        if (restaurantSection && (window.location.pathname === '/' || window.location.pathname === '')) {
            setTimeout(() => {
                restaurantSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 320);
        } else {
            setTimeout(() => {
                window.location.href = "{{ route('front.restaurants') }}";
            }, 200);
        }
    };

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && root.style.display === 'flex') {
            closeHystWelcomeModal();
        }
    });

    setTimeout(showModal, 600);
})();
</script>
