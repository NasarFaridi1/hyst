@extends('front.layouts.app')

@section('content')

<style>
    body { font-family: 'Poppins', sans-serif; background: #F5F0E8; }

    .success-page-wrap {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .success-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        width: 100%;
        max-width: 580px;
        box-shadow: 0 8px 40px rgba(194,90,42,0.12), 0 1px 6px rgba(0,0,0,0.06);
    }

    .card-top-bar {
        height: 6px;
        background: #C25A2A;
    }

    .card-inner { padding: 2.5rem 2.5rem 2rem; }

    /* Logo */
    .hyst-logo {
        display: flex;
        align-items: center;
        gap: 9px;
        text-decoration: none;
        margin-bottom: 2rem;
    }
    .hyst-logo-icon {
        width: 36px; height: 36px;
        background: #C25A2A;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .hyst-logo-text {
        font-weight: 800; font-size: 19px;
        color: #0D0D0D; letter-spacing: -0.4px;
    }

    /* Success icon */
    .success-icon-wrap {
        width: 90px; height: 90px;
        background: linear-gradient(135deg, #fff5f0 0%, #fde8dc 100%);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
        border: 2px solid #f0d4c5;
    }
    .success-checkmark {
        width: 38px; height: 38px;
        stroke: #C25A2A;
        stroke-width: 2.5;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .success-checkmark .circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        animation: stroke 0.6s cubic-bezier(0.65,0,0.45,1) forwards;
    }
    .success-checkmark .check {
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.4s cubic-bezier(0.65,0,0.45,1) 0.55s forwards;
    }
    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }

    .success-heading {
        font-size: 21px; font-weight: 700;
        color: #0D0D0D; margin: 0 0 6px;
        text-align: center;
    }
    .success-sub {
        font-size: 13px; color: #888;
        text-align: center; margin: 0 0 1.75rem;
    }

    /* Divider */
    .hyst-divider {
        height: 1px; background: #EBE5DE;
        margin: 0 0 1.5rem;
    }

    /* Detail grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 1.5rem;
    }
    @media(max-width: 540px) {
        .detail-grid { grid-template-columns: 1fr; }
        .card-inner { padding: 1.75rem 1.25rem 1.5rem; }
        .success-heading { font-size: 18px; }
    }

    .detail-box {
        background: #FDFAF7;
        border: 1.5px solid #EBE5DE;
        border-radius: 12px;
        padding: 14px 16px;
    }
    .detail-box-label {
        font-size: 11px;
        font-weight: 600;
        color: #AAA;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        display: block;
        margin-bottom: 5px;
    }
    .detail-box-value {
        font-size: 14px;
        font-weight: 700;
        color: #0D0D0D;
        margin: 0;
        word-break: break-all;
    }
    .detail-box-value.success-color { color: #2E9E6B; }

    /* Amount highlight box */
    .amount-box {
        background: linear-gradient(135deg, #C25A2A 0%, #A84B22 100%);
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .amount-box-label {
        font-size: 12px; font-weight: 600;
        color: rgba(255,255,255,0.75);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .amount-box-value {
        font-size: 26px; font-weight: 800;
        color: #fff;
        letter-spacing: -0.5px;
    }
    .amount-box-icon {
        width: 46px; height: 46px;
        background: rgba(255,255,255,0.15);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }

    /* Alert banner */
    .order-alert {
        background: #F0FDF6;
        border: 1.5px solid #BBF0D2;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    .order-alert-icon {
        flex-shrink: 0;
        width: 20px; height: 20px;
        color: #2E9E6B;
        margin-top: 1px;
    }
    .order-alert-text {
        font-size: 13px; color: #1A6640;
        line-height: 1.6; margin: 0;
    }
    .order-alert-text strong { font-weight: 700; }

    /* Countdown */
    .redirect-box {
        background: #FDFAF7;
        border: 1.5px solid #EBE5DE;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
    }
    .redirect-spinner {
        width: 36px; height: 36px;
        border: 3px solid #EBE5DE;
        border-top-color: #C25A2A;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 12px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .redirect-title {
        font-size: 14px; font-weight: 700;
        color: #0D0D0D; margin: 0 0 4px;
    }
    .redirect-sub {
        font-size: 12px; color: #AAA; margin: 0 0 12px;
    }
    .countdown-badge {
        display: inline-flex;
        align-items: center; justify-content: center;
        width: 48px; height: 48px;
        border-radius: 50%;
        background: #C25A2A;
        color: #fff;
        font-size: 20px;
        font-weight: 800;
    }
</style>

<div class="success-page-wrap">
    <div class="success-card">
        <div class="card-top-bar"></div>

        <div class="card-inner">

            {{-- Logo --}}
            <a href="/" class="hyst-logo">
                <div class="hyst-logo-icon">
                    <i data-lucide="utensils" style="color:#fff; width:18px; height:18px;"></i>
                </div>
                <span class="hyst-logo-text">HYST</span>
            </a>

            {{-- Success icon + heading --}}
            <div style="text-align:center; margin-bottom:1.5rem;">
                <div class="success-icon-wrap">
                    <svg class="success-checkmark" viewBox="0 0 52 52">
                        <circle class="circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="check" d="M14 27l8 8 16-16"/>
                    </svg>
                </div>
                <h2 class="success-heading">Payment Successful!</h2>
                <p class="success-sub">Your payment has been processed. Thank you for ordering with HYST.</p>
            </div>

            {{-- Amount highlight --}}
            <div class="amount-box">
                <div>
                    <div class="amount-box-label">Amount Paid</div>
                    <div class="amount-box-value">£{{ number_format($result['transaction']['amount'], 2) }}</div>
                </div>
                <div class="amount-box-icon">
                    <i data-lucide="credit-card" style="color:#fff; width:22px; height:22px;"></i>
                </div>
            </div>

            <div class="hyst-divider"></div>

            {{-- Detail grid --}}
            <div class="detail-grid">

                <div class="detail-box">
                    <span class="detail-box-label">Payment Status</span>
                    <p class="detail-box-value success-color">{{ str_replace('_', ' ', $result['status']) }}</p>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Payment Type</span>
                    <p class="detail-box-value">{{ $result['type'] }}</p>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Transaction Reference</span>
                    <p class="detail-box-value">{{ $result['transaction']['reference'] }}</p>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Transaction Token</span>
                    <p class="detail-box-value" style="font-size:12px; font-weight:600; color:#888;">{{ $result['token'] }}</p>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Customer</span>
                    <p class="detail-box-value">{{ $result['payer']['givenName'] }} {{ $result['payer']['familyOrBusinessName'] }}</p>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Email</span>
                    <p class="detail-box-value" style="font-size:13px;">{{ $result['payer']['email'] }}</p>
                </div>

                <div class="detail-box" style="grid-column: 1 / -1;">
                    <span class="detail-box-label">Payment Time</span>
                    <p class="detail-box-value">{{ \Carbon\Carbon::parse($result['time'])->format('d M Y h:i A') }}</p>
                </div>

            </div>

            {{-- Order alert --}}
            <div class="order-alert">
                <i data-lucide="check-circle-2" class="order-alert-icon"></i>
                <p class="order-alert-text">
                    <strong>Your order has been received.</strong><br>
                    We're preparing your food and will notify you once the restaurant accepts your order.
                </p>
            </div>

            {{-- Redirect countdown --}}
            <div class="redirect-box">
                <div class="redirect-spinner"></div>
                <p class="redirect-title">Redirecting to My Orders</p>
                <p class="redirect-sub">Please don't close this page.</p>
                <div class="countdown-badge" id="countdown">5</div>
            </div>

        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    let seconds = 5;
    const countdown = document.getElementById('countdown');
    const timer = setInterval(function () {
        seconds--;
        countdown.innerHTML = seconds;
        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = "{{ route('my.orders') }}";
        }
    }, 1000);
</script>

@endsection