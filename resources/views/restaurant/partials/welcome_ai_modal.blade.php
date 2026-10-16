@php
    $showWelcome = (session('restaurant_just_logged_in') || request()->has('welcome_preview'));
    $user = auth()->user();
    $restaurant = $user ? ($user->restaurant ?? \App\Models\Restaurant::find($user->restaurant_id)) : null;
    $restaurantName = $restaurant->name ?? $user->name ?? 'Restaurant Partner';
@endphp

@if($showWelcome)
<div id="hyst-welcome-ai-modal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 sm:p-6 overflow-y-auto" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop Blur & Overlay -->
    <div id="hyst-welcome-backdrop" class="fixed inset-0 bg-black/65 backdrop-blur-sm transition-opacity duration-300 opacity-0" onclick="closeWelcomeModal()"></div>

    <!-- Modal Content Window -->
    <div id="hyst-welcome-card" class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-stone-200 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out z-10 my-8">
        
        <!-- Top Gradient Accent Strip -->
        <div class="h-2.5 w-full bg-gradient-to-r from-[#C25A2A] via-[#D97040] to-[#E59866]"></div>

        <!-- Close Button (Top Right) -->
        <button type="button" onclick="closeWelcomeModal()" class="absolute top-5 right-5 text-stone-400 hover:text-stone-700 bg-stone-100 hover:bg-stone-200 p-2 rounded-full transition-colors duration-150 focus:outline-none" title="Close">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="p-6 sm:p-8">
            
            <!-- Header Section -->
            <div class="flex items-start gap-4 mb-5">
                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#C25A2A] to-[#8C3D1A] flex items-center justify-center text-white shadow-lg shadow-[#C25A2A]/30 flex-shrink-0">
                    <span class="text-2xl sm:text-3xl">👋</span>
                </div>
                <div class="pr-8">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200/80 text-[11px] font-bold text-amber-800 tracking-wider uppercase mb-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#C25A2A] animate-pulse"></span>
                        Welcome Back
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-[#1A1208] leading-tight">
                        Great to see you, <span class="text-[#C25A2A]">{{ $restaurantName }}</span>!
                    </h2>
                    <p class="text-xs sm:text-sm text-stone-500 mt-0.5">
                        Your dashboard is loaded and ready. Let's make today your most profitable day yet!
                    </p>
                </div>
            </div>

            <!-- Spotlight Card: AI Analytics Feature -->
            <div class="rounded-2xl p-5 sm:p-6 bg-gradient-to-br from-stone-900 via-stone-900 to-[#2A1810] text-white border border-stone-800 shadow-inner relative overflow-hidden mb-6">
                <!-- Background decorative glowing shapes -->
                <div class="absolute -right-8 -top-8 w-40 h-40 bg-[#C25A2A]/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-amber-300">
                            <span class="text-sm">✨</span> HYST AI Growth Engine
                        </div>
                        <span class="text-[11px] text-emerald-400 font-medium flex items-center gap-1 bg-emerald-950/60 border border-emerald-800/60 px-2.5 py-0.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                            Ready to analyze your store
                        </span>
                    </div>

                    <h3 class="text-base sm:text-lg font-bold text-white mb-2 leading-snug">
                        Turn regular customers into repeat revenue with AI Analytics 🚀
                    </h3>
                    <p class="text-xs sm:text-sm text-stone-300 mb-4 leading-relaxed">
                        Don't let valuable customers drift away. Our built-in AI continuously inspects your order patterns and helps you drive repeat orders with zero hassle:
                    </p>

                    <!-- Feature Bullet Points -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        <div class="bg-white/5 hover:bg-white/10 transition-colors border border-white/10 rounded-xl p-3">
                            <div class="w-7 h-7 rounded-lg bg-[#C25A2A]/30 border border-[#C25A2A]/50 flex items-center justify-center text-amber-300 text-sm mb-2">
                                🎯
                            </div>
                            <div class="font-semibold text-xs text-white mb-0.5">Win-Back Dormant</div>
                            <div class="text-[11px] text-stone-400 leading-tight">Detects customers before they churn and brings them back.</div>
                        </div>

                        <div class="bg-white/5 hover:bg-white/10 transition-colors border border-white/10 rounded-xl p-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-300 text-sm mb-2">
                                ⚡
                            </div>
                            <div class="font-semibold text-xs text-white mb-0.5">1-Click Campaigns</div>
                            <div class="text-[11px] text-stone-400 leading-tight">Dispatches high-converting offers tailored to their tastes.</div>
                        </div>

                        <div class="bg-white/5 hover:bg-white/10 transition-colors border border-white/10 rounded-xl p-3">
                            <div class="w-7 h-7 rounded-lg bg-blue-500/20 border border-blue-500/40 flex items-center justify-center text-blue-300 text-sm mb-2">
                                📈
                            </div>
                            <div class="font-semibold text-xs text-white mb-0.5">Menu & Revenue</div>
                            <div class="text-[11px] text-stone-400 leading-tight">Identifies top-earning items and peak ordering times.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeWelcomeModal()" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-stone-300 text-stone-700 hover:text-stone-900 hover:bg-stone-100 font-semibold text-xs sm:text-sm transition-all focus:outline-none">
                    Continue to Dashboard
                </button>
                <a href="{{ route('restaurant.ai_analytics.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#C25A2A] to-[#D97040] hover:from-[#B04E20] hover:to-[#C25A2A] text-white font-bold text-xs sm:text-sm shadow-lg shadow-[#C25A2A]/30 hover:shadow-xl hover:shadow-[#C25A2A]/40 transform hover:-translate-y-0.5 transition-all text-center">
                    <span>Explore AI Analytics</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        const isPreview = {{ request()->has('welcome_preview') ? 'true' : 'false' }};
        const modal = document.getElementById('hyst-welcome-ai-modal');
        const backdrop = document.getElementById('hyst-welcome-backdrop');
        const card = document.getElementById('hyst-welcome-card');

        if (!modal) return;

        // If not in preview mode, don't show repeatedly in the same session tab if already dismissed
        if (!isPreview && sessionStorage.getItem('hyst_welcome_modal_dismissed')) {
            return;
        }

        function showWelcomeModal() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Trigger animation frame for smooth transition
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            });
        }

        window.closeWelcomeModal = function() {
            sessionStorage.setItem('hyst_welcome_modal_dismissed', '1');
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 250);
        };

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                closeWelcomeModal();
            }
        });

        // Slight 300ms delay for natural page load feel
        setTimeout(showWelcomeModal, 350);
    })();
</script>
@endif
