<!-- ══════════ GLOBAL LOADER OVERLAY ══════════ -->
<style>
    #global-loader-overlay {
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.18s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #global-loader-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }

    .loader-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(229, 231, 235, 0.8);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-radius: 20px;
        padding: 22px 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .loader-spinner-wrap {
        position: relative;
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    .loader-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #C25A2A;
        border-right-color: #C25A2A;
        animation: loaderSpin 0.75s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
    }

    .loader-ring-outer {
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        border: 2px solid transparent;
        border-bottom-color: rgba(194, 90, 42, 0.25);
        border-left-color: rgba(194, 90, 42, 0.25);
        animation: loaderSpinReverse 1.1s linear infinite;
    }

    .loader-brand-icon {
        font-size: 24px;
        animation: loaderPulse 1.4s ease-in-out infinite;
        user-select: none;
    }

    .loader-text {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #1F2937;
        letter-spacing: 0.3px;
    }

    .loader-subtext {
        font-family: 'Poppins', sans-serif;
        font-size: 11px;
        font-weight: 500;
        color: #6B7280;
        margin-top: 2px;
    }

    @keyframes loaderSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes loaderSpinReverse {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(-360deg); }
    }

    @keyframes loaderPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.15); opacity: 0.8; }
    }
</style>

<div id="global-loader-overlay">
    <div class="loader-card">
        <div class="loader-spinner-wrap">
            <div class="loader-ring-outer"></div>
            <div class="loader-ring"></div>
            <div class="loader-brand-icon">🍽️</div>
        </div>
        <div class="loader-text" id="global-loader-text">Loading...</div>
        <div class="loader-subtext" id="global-loader-subtext">Please wait a moment</div>
    </div>
</div>

<script>
    (function () {
        const loader = document.getElementById('global-loader-overlay');
        const loaderText = document.getElementById('global-loader-text');
        const loaderSubtext = document.getElementById('global-loader-subtext');
        let hideTimer = null;

        window.showGlobalLoader = function (message, subtext, autoHideMs = 3500) {
            if (loaderText) loaderText.textContent = message || 'Loading...';
            if (loaderSubtext) loaderSubtext.textContent = subtext || 'Please wait a moment';
            if (loader) loader.classList.add('active');

            if (hideTimer) clearTimeout(hideTimer);
            if (autoHideMs && autoHideMs > 0) {
                hideTimer = setTimeout(function () {
                    window.hideGlobalLoader();
                }, autoHideMs);
            }
        };

        window.hideGlobalLoader = function () {
            if (hideTimer) clearTimeout(hideTimer);
            if (loader) loader.classList.remove('active');
        };

        // Hide loader when page finishes loading
        window.addEventListener('load', function () {
            window.hideGlobalLoader();
        });

        // Hide loader when restoring page tab
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                window.hideGlobalLoader();
            }
        });

        // Show loader on form submission
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form || form.hasAttribute('data-no-loader') || form.classList.contains('addCartForm')) return;

            const action = (form.getAttribute('action') || '').toLowerCase();
            const currentPath = window.location.pathname.toLowerCase();

            let msg = 'Processing Request...';
            if (action.includes('/login') || currentPath.includes('/login')) {
                msg = 'Logging In...';
            } else if (action.includes('/register') || currentPath.includes('/register')) {
                msg = 'Creating Account...';
            }

            window.showGlobalLoader(msg, 'Please wait', 4000);
        });

        // Auto show loader when clicking links
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = (link.getAttribute('href') || '').toLowerCase();
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:') || link.hasAttribute('data-no-loader') || link.getAttribute('target') === '_blank') {
                return;
            }

            let msg = 'Loading...';
            if (href.includes('/login')) {
                msg = 'Opening Login...';
            } else if (href.includes('/register')) {
                msg = 'Opening Register...';
            } else if (href.includes('/restaurant/')) {
                msg = 'Opening Restaurant Menu...';
            } else if (href === '/' || href.includes('/home')) {
                msg = 'Loading Home...';
            } else if (href.includes('/checkout')) {
                msg = 'Opening Checkout...';
            } else if (href.includes('/restaurants')) {
                msg = 'Loading Restaurants...';
            } else if (href.includes('/become-ambassador')) {
                msg = 'Opening Ambassador Programme...';
            } else if (href.includes('/become-a-partner')) {
                msg = 'Opening Restaurant Partner...';
            }

            window.showGlobalLoader(msg, 'Please wait', 4000);
        });
    })();
</script>
