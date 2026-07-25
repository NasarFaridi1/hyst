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

        window.showGlobalLoader = function (message, subtext, autoHideMs = 2500) {
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

        // Show loader on form submission unless data-no-loader is set
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form || form.hasAttribute('data-no-loader')) return;

            window.showGlobalLoader('Processing Request...', 'Please wait', 2500);
        });
    })();
</script>
