{{-- 
    HYST — Premium Restaurant Celebration & Choice Reassurance Experience
    Delights customers when entering a restaurant menu, reassuring them of their great choice
    with genuine direct menu pricing and fresh quality.
--}}
@php
    $restRating = $restaurant->reviews ? $restaurant->reviews->avg('rating') : 0;
    $formattedRating = $restRating ? number_format($restRating, 1) : null;
    $reviewsCount = $restaurant->reviews ? $restaurant->reviews->count() : 0;
@endphp

<!-- Celebration Floating Toast Container (Non-blocking: pointer-events none) -->
<div id="hyst-celebration-container" 
     class="hyst-celebration-wrapper"
     aria-live="polite" 
     style="display: none;">
    <div id="hyst-celebration-toast" class="hyst-celebration-card" role="status">
        <!-- Progress Bar Indicator -->
        <div class="hyst-toast-progress"></div>

        <div class="hyst-toast-body">
            <!-- Animated Icon Badge -->
            <div class="hyst-toast-icon-wrapper">
                <span class="hyst-toast-icon">🎉</span>
                <span class="hyst-toast-sparkle">✨</span>
            </div>

            <!-- Toast Content -->
            <div class="hyst-toast-content">
                <div class="hyst-toast-header">
                    <span class="hyst-toast-kicker">EXCELLENT CHOICE</span>
                    <span class="hyst-toast-dot">•</span>
                    <span class="hyst-toast-perk">Direct Dining</span>
                </div>
                <h4 class="hyst-toast-title">
                    Welcome to <span class="hyst-toast-restaurant-name">{{ $restaurant->name }}</span>!
                </h4>
                <div class="hyst-toast-meta">
                    @if($formattedRating && $formattedRating > 0)
                        <span class="hyst-meta-pill rating">
                            ⭐ {{ $formattedRating }} ({{ $reviewsCount }}+ reviews)
                        </span>
                    @endif
                    <span class="hyst-meta-pill zero-markup">
                        🏷️ 0% Markup Guarantee
                    </span>
                    <span class="hyst-meta-pill fresh">
                        👨‍🍳 Prepared Fresh To Order
                    </span>
                </div>
            </div>

            <!-- Close Button -->
            <button type="button" 
                    id="hyst-close-celebration" 
                    class="hyst-toast-close" 
                    aria-label="Close celebration message"
                    onclick="dismissHystCelebration()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Scoped Styles for Celebration Experience -->
<style>
    .hyst-celebration-wrapper {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 99999;
        width: 92%;
        max-width: 580px;
        pointer-events: none; /* Prevents blocking any menu clicks outside the card */
    }

    .hyst-celebration-card {
        pointer-events: auto;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1.5px solid #FED7AA;
        border-radius: 18px;
        box-shadow: 0 16px 38px -10px rgba(194, 90, 42, 0.28),
                    0 6px 18px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        position: relative;
        animation: hystToastSlideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        font-family: 'DM Sans', 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .hyst-toast-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: linear-gradient(90deg, #C25A2A 0%, #EA580C 50%, #F59E0B 100%);
        animation: hystProgressShrink 4s linear forwards;
    }

    .hyst-toast-body {
        padding: 12px 14px 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .hyst-toast-icon-wrapper {
        position: relative;
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%);
        border: 1px solid #FDBA74;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15);
    }

    .hyst-toast-icon {
        font-size: 22px;
        display: inline-block;
        animation: hystIconBounce 1.8s ease-in-out infinite;
    }

    .hyst-toast-sparkle {
        position: absolute;
        top: -4px;
        right: -4px;
        font-size: 13px;
        animation: hystSparkleTwinkle 1.4s ease-in-out infinite alternate;
    }

    .hyst-toast-content {
        flex: 1;
        min-width: 0;
    }

    .hyst-toast-header {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 2px;
    }

    .hyst-toast-kicker {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #C25A2A;
    }

    .hyst-toast-dot {
        font-size: 8px;
        color: #D1D5DB;
    }

    .hyst-toast-perk {
        font-size: 10.5px;
        font-weight: 700;
        color: #059669;
        background: #ECFDF5;
        padding: 1px 7px;
        border-radius: 999px;
        border: 1px solid #A7F3D0;
    }

    .hyst-toast-title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px 0;
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .hyst-toast-restaurant-name {
        color: #C25A2A;
        font-weight: 800;
    }

    .hyst-toast-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .hyst-meta-pill {
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 6px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
    }

    .hyst-meta-pill.rating {
        background: #FEF3C7;
        color: #92400E;
        border: 1px solid #FDE68A;
    }

    .hyst-meta-pill.zero-markup {
        background: #F3F4F6;
        color: #374151;
        border: 1px solid #E5E7EB;
    }

    .hyst-meta-pill.fresh {
        background: #FFF7ED;
        color: #9A3412;
        border: 1px solid #FFEDD5;
    }

    .hyst-toast-close {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #F3F4F6;
        border: 1px solid #E5E7EB;
        color: #6B7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        flex-shrink: 0;
        padding: 0;
    }

    .hyst-toast-close:hover {
        background: #E5E7EB;
        color: #111827;
        transform: scale(1.05);
    }

    /* Keyframe Animations */
    @keyframes hystToastSlideIn {
        0% {
            opacity: 0;
            transform: translateY(-24px) scale(0.96);
        }
        70% {
            transform: translateY(3px) scale(1.01);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes hystToastSlideOut {
        0% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        100% {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
    }

    @keyframes hystProgressShrink {
        0% { width: 100%; }
        100% { width: 0%; }
    }

    @keyframes hystIconBounce {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        35% { transform: translateY(-3px) rotate(-8deg); }
        70% { transform: translateY(1px) rotate(6deg); }
    }

    @keyframes hystSparkleTwinkle {
        0% { transform: scale(0.8) rotate(0deg); opacity: 0.6; }
        100% { transform: scale(1.25) rotate(15deg); opacity: 1; }
    }

    /* Hero Choice Badge Animation */
    .hyst-choice-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: linear-gradient(135deg, rgba(194, 90, 42, 0.25) 0%, rgba(245, 158, 11, 0.25) 100%);
        border: 1px solid rgba(245, 158, 11, 0.6);
        color: #FED7AA;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.02em;
        box-shadow: 0 0 14px rgba(245, 158, 11, 0.2);
        animation: hystPillShimmer 3s infinite ease-in-out;
    }

    @keyframes hystPillShimmer {
        0%, 100% { box-shadow: 0 0 10px rgba(245, 158, 11, 0.15); }
        50% { box-shadow: 0 0 18px rgba(245, 158, 11, 0.45); border-color: rgba(245, 158, 11, 0.9); }
    }

    @media (max-width: 640px) {
        .hyst-celebration-wrapper {
            top: 12px;
            width: 95%;
        }
        .hyst-toast-body {
            padding: 10px 12px;
            gap: 10px;
        }
        .hyst-toast-icon-wrapper {
            width: 38px;
            height: 38px;
            border-radius: 10px;
        }
        .hyst-toast-icon {
            font-size: 19px;
        }
        .hyst-toast-title {
            font-size: 13px;
        }
        .hyst-meta-pill.fresh {
            display: none; /* Keep super compact on narrow mobile */
        }
    }
</style>

<!-- Canvas Confetti Library (Lightweight ~6KB) -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

<script>
    (function() {
        const RESTAURANT_ID = @json($restaurant->id);
        const SESSION_KEY = 'hyst_celebrated_rest_' + RESTAURANT_ID;
        let autoDismissTimer = null;

        window.dismissHystCelebration = function() {
            const toast = document.getElementById('hyst-celebration-toast');
            const container = document.getElementById('hyst-celebration-container');
            if (!toast || !container) return;

            if (autoDismissTimer) clearTimeout(autoDismissTimer);

            toast.style.animation = 'hystToastSlideOut 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards';
            setTimeout(() => {
                container.style.display = 'none';
            }, 350);
        };

        function fireHYSTCelebrationConfetti() {
            // Check for user's reduced-motion preference
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                return;
            }

            if (typeof confetti !== 'function') return;

            const brandColors = ['#C25A2A', '#F59E0B', '#10B981', '#FFD700', '#EA580C', '#FFFFFF'];

            // Dual celebration burst (Left & Right cannons)
            confetti({
                particleCount: 36,
                angle: 60,
                spread: 55,
                origin: { x: 0.05, y: 0.4 },
                colors: brandColors,
                gravity: 0.95,
                scalar: 0.9,
                ticks: 200,
                disableForReducedMotion: true
            });

            confetti({
                particleCount: 36,
                angle: 120,
                spread: 55,
                origin: { x: 0.95, y: 0.4 },
                colors: brandColors,
                gravity: 0.95,
                scalar: 0.9,
                ticks: 200,
                disableForReducedMotion: true
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Check if user already saw the celebration for this restaurant in current tab session
            const hasCelebrated = sessionStorage.getItem(SESSION_KEY);

            if (!hasCelebrated) {
                // Mark as celebrated so it doesn't annoy the customer on every category filter click
                sessionStorage.setItem(SESSION_KEY, 'true');

                const container = document.getElementById('hyst-celebration-container');
                if (container) {
                    // Slight delay for smooth aesthetic entrance right after page paints
                    setTimeout(() => {
                        container.style.display = 'block';
                        fireHYSTCelebrationConfetti();

                        // Auto-dismiss smoothly after 4.2 seconds
                        autoDismissTimer = setTimeout(() => {
                            window.dismissHystCelebration();
                        }, 4200);
                    }, 350);
                }
            }
        });
    })();
</script>
