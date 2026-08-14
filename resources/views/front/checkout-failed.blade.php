@extends('front.layouts.app')

@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #F5F0E8;
    }

    .failed-page-wrap {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }

    .failed-card {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        width: 100%;
        max-width: 580px;
        box-shadow: 0 12px 48px rgba(194, 90, 42, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        border: 1px solid #EBE5DE;
    }

    .card-top-bar {
        height: 6px;
        background: linear-gradient(90deg, #E53E3E 0%, #DD6B20 100%);
    }

    .card-inner {
        padding: 2.5rem 2.5rem 2.25rem;
    }

    /* Logo */
    .hyst-logo {
        display: flex;
        align-items: center;
        gap: 9px;
        text-decoration: none;
        margin-bottom: 2rem;
    }

    .hyst-logo-icon {
        width: 36px;
        height: 36px;
        background: #C25A2A;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .hyst-logo-text {
        font-weight: 800;
        font-size: 19px;
        color: #0D0D0D;
        letter-spacing: -0.4px;
    }

    /* Failed Icon Animation */
    .failed-icon-wrap {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #FFF5F5 0%, #FED7D7 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 2px solid #FEB2B2;
        box-shadow: 0 6px 20px rgba(229, 62, 62, 0.15);
    }

    .failed-crossmark {
        width: 40px;
        height: 40px;
        stroke: #E53E3E;
        stroke-width: 3;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .failed-crossmark .circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        animation: stroke-circle 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .failed-crossmark .cross {
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke-cross 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.5s forwards;
    }

    @keyframes stroke-circle {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes stroke-cross {
        100% {
            stroke-dashoffset: 0;
        }
    }

    .failed-heading {
        font-size: 24px;
        font-weight: 800;
        color: #1A202C;
        margin: 0 0 8px;
        text-align: center;
        letter-spacing: -0.5px;
    }

    .failed-sub {
        font-size: 14px;
        color: #718096;
        text-align: center;
        margin: 0 0 1.75rem;
        line-height: 1.6;
    }

    /* Divider */
    .hyst-divider {
        height: 1px;
        background: #EBE5DE;
        margin: 0 0 1.5rem;
    }

    /* Safety Alert Banner */
    .safety-alert {
        background: #FFFAF0;
        border: 1.5px solid #FBD38D;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .safety-alert-icon {
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        color: #DD6B20;
        margin-top: 1px;
    }

    .safety-alert-text {
        font-size: 13px;
        color: #7B341E;
        line-height: 1.55;
        margin: 0;
    }

    .safety-alert-text strong {
        font-weight: 700;
        color: #9C4221;
    }

    /* Common Reasons Section */
    .reasons-box {
        background: #FDFAF7;
        border: 1.5px solid #EBE5DE;
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 1.75rem;
    }

    .reasons-title {
        font-size: 12px;
        font-weight: 700;
        color: #A0AEC0;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .reasons-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .reasons-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #4A5568;
        font-weight: 500;
    }

    .reasons-item-bullet {
        width: 6px;
        height: 6px;
        background: #E53E3E;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-try-again {
        background: linear-gradient(135deg, #C25A2A 0%, #A84B22 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
        padding: 14px 24px;
        border-radius: 14px;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(194, 90, 42, 0.25);
        border: none;
    }

    .btn-try-again:hover {
        background: linear-gradient(135deg, #A84B22 0%, #8C3D19 100%);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(194, 90, 42, 0.35);
    }

    .btn-secondary-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .btn-cart {
        background: #EDF2F7;
        color: #4A5568;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 18px;
        border-radius: 12px;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-cart:hover {
        background: #E2E8F0;
        color: #2D3748;
    }

    .btn-support {
        background: #ffffff;
        border: 1.5px solid #E2E8F0;
        color: #4A5568;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 18px;
        border-radius: 12px;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-support:hover {
        border-color: #CBD5E0;
        background: #F7FAFC;
        color: #2D3748;
    }

    @media(max-width: 540px) {
        .card-inner {
            padding: 1.75rem 1.25rem 1.5rem;
        }

        .failed-heading {
            font-size: 20px;
        }

        .btn-secondary-group {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="failed-page-wrap">
    <div class="failed-card">
        <div class="card-top-bar"></div>

        <div class="card-inner">

            {{-- Logo --}}
            <a href="/" class="hyst-logo">
                <div class="hyst-logo-icon">
                    <i data-lucide="utensils" style="color:#fff; width:18px; height:18px;"></i>
                </div>
                <span class="hyst-logo-text">HYST</span>
            </a>

            {{-- Failure Icon + Heading --}}
            <div style="text-align:center; margin-bottom:1.5rem;">
                <div class="failed-icon-wrap">
                    <svg class="failed-crossmark" viewBox="0 0 52 52">
                        <circle class="circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="cross" d="M16 16 L36 36 M36 16 L16 36"/>
                    </svg>
                </div>
                <h2 class="failed-heading">Payment Unsuccessful</h2>
                <p class="failed-sub">
                    @if(session('error'))
                        {{ session('error') }}
                    @else
                        We were unable to process your payment. Don't worry, your account has not been charged for this attempt.
                    @endif
                </p>
            </div>

            {{-- Reassurance Alert Banner --}}
            <div class="safety-alert">
                <i data-lucide="shield-alert" class="safety-alert-icon"></i>
                <p class="safety-alert-text">
                    <strong>Your items are saved!</strong><br>
                    Your cart items remain intact in your basket so you can easily try again with a different payment method.
                </p>
            </div>

            <div class="hyst-divider"></div>

            {{-- Common Reasons --}}
            <div class="reasons-box">
                <div class="reasons-title">
                    <i data-lucide="help-circle" style="width:14px; height:14px;"></i>
                    Why might this have happened?
                </div>
                <ul class="reasons-list">
                    <li class="reasons-item">
                        <span class="reasons-item-bullet"></span>
                        Card authentication or 3D Secure verification timed out
                    </li>
                    <li class="reasons-item">
                        <span class="reasons-item-bullet"></span>
                        Insufficient funds or card transaction limit reached
                    </li>
                    <li class="reasons-item">
                        <span class="reasons-item-bullet"></span>
                        Incorrect card number, CVV, or expiration date
                    </li>
                    <li class="reasons-item">
                        <span class="reasons-item-bullet"></span>
                        Temporary bank network connection timeout
                    </li>
                </ul>
            </div>

            {{-- Actions --}}
            <div class="action-group">
                <a href="{{ url('/checkout') }}" class="btn-try-again">
                    <i data-lucide="rotate-cw" style="width:18px; height:18px;"></i>
                    Try Payment Again
                </a>

                <div class="btn-secondary-group">
                    <a href="{{ url('/cart') }}" class="btn-cart">
                        <i data-lucide="shopping-bag" style="width:16px; height:16px;"></i>
                        Return to Cart
                    </a>
                    <a href="{{ url('/contact') }}" class="btn-support">
                        <i data-lucide="headphones" style="width:16px; height:16px;"></i>
                        Contact Support
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

@endsection