@extends('front.layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

    .order-page * {
        font-family: 'Sora', sans-serif;
    }

    .order-page {
        background: #f0f2f5;
        min-height: 100vh;
        padding: 2.5rem 1.25rem;
    }

    /* CARDS */
    .card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.05);
    }

    /* HEADER CARD */
    .header-card {
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-title {
        font-size: 1.9rem;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.04em;
    }

    .order-subtitle {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        color: #888;
        margin-top: 0.3rem;
        letter-spacing: 0.05em;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #111;
        color: #fff;
        padding: 0.65rem 1.4rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, transform 0.15s;
    }

    .back-btn:hover {
        background: #333;
        transform: translateY(-1px);
    }

    /* TRACKING */
    .tracking-card {
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
    }

    .tracking-card h2 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111;
        letter-spacing: -0.02em;
        margin-bottom: 2.2rem;
    }

    .tracking-bar-wrap {
        position: relative;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 0 0.5rem;
    }

    .track-line-bg {
        position: absolute;
        top: 18px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e8e8e8;
        border-radius: 10px;
        z-index: 0;
    }

    .track-line-active {
        position: absolute;
        top: 18px;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #16a34a, #22c55e);
        border-radius: 10px;
        z-index: 1;
        transition: width 0.8s ease;
    }

    .track-step {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
    }

    .step-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        border: 3px solid #e8e8e8;
        background: #fff;
        color: #bbb;
        transition: all 0.3s ease;
    }

    .step-circle.active {
        background: #16a34a;
        border-color: #16a34a;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(22,163,74,0.15);
    }

    .step-circle.cancelled {
        background: #ef4444;
        border-color: #ef4444;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(239,68,68,0.15);
    }

    .step-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #aaa;
        white-space: nowrap;
        letter-spacing: 0.02em;
    }

    .step-label.active {
        color: #16a34a;
    }

    .step-label.cancelled {
        color: #ef4444;
    }

    /* STATUS BADGE */
    .status-badge-wrap {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.6rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: -0.01em;
    }

    .badge-pending  { background: #fef9c3; color: #a16207; }
    .badge-accepted { background: #dbeafe; color: #1d4ed8; }
    .badge-completed { background: #dcfce7; color: #15803d; }
    .badge-cancelled { background: #fee2e2; color: #b91c1c; }

    /* INFO GRID */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 640px) {
        .info-grid { grid-template-columns: 1fr; }
    }

    .info-card {
        padding: 1.75rem 2rem;
    }

    .info-card h3 {
        font-size: 0.8rem;
        font-weight: 700;
        color: #aaa;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1.2rem;
    }

    .info-row {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .info-item label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #bbb;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        display: block;
        margin-bottom: 0.2rem;
    }

    .info-item span {
        font-size: 0.9rem;
        font-weight: 600;
        color: #222;
    }

    .payment-status-paid   { color: #16a34a; }
    .payment-status-pending { color: #d97706; }

    /* ITEMS CARD */
    .items-card {
        overflow: hidden;
    }

    .items-header {
        padding: 1.5rem 2.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .items-header h2 {
        font-size: 1.1rem;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.02em;
    }

    .items-body {
        padding: 0 2.5rem 2rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.4rem 0;
        border-bottom: 1px solid #f5f5f5;
        gap: 1rem;
    }

    .order-item:last-of-type {
        border-bottom: none;
    }

    .item-left {
        display: flex;
        align-items: center;
        gap: 1.1rem;
    }

    .item-img {
        width: 70px;
        height: 70px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
        background: #f3f4f6;
    }

    .item-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 0.3rem;
    }

    .item-meta {
        font-size: 0.8rem;
        color: #999;
        font-family: 'JetBrains Mono', monospace;
    }

    .item-total {
        font-size: 1rem;
        font-weight: 800;
        color: #e11d48;
        white-space: nowrap;
    }

    /* TOTALS */
    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2.5rem 2rem;
        border-top: 2px solid #f0f0f0;
        margin-top: 0.5rem;
    }

    .totals-label {
        font-size: 1rem;
        font-weight: 700;
        color: #111;
    }

    .totals-amount {
        font-size: 1.6rem;
        font-weight: 800;
        color: #e11d48;
        letter-spacing: -0.04em;
        font-family: 'JetBrains Mono', monospace;
    }
</style>

<div class="order-page">
    <div class="mx-auto" style="max-width: 1280px;">
        <div style="display: grid; grid-template-columns: 260px 1fr; gap: 2rem; align-items: start;">

            {{-- SIDEBAR --}}
            <div>
                @include('front.layouts.user-sidebar')
            </div>

            {{-- MAIN CONTENT --}}
            <div>

                {{-- HEADER --}}
                <div class="card header-card">
                    <div>
                        <div class="order-title">Order Details</div>
                        <div class="order-subtitle">ORDER #{{ $order->id }}</div>
                    </div>
                    <a href="/my-orders" class="back-btn">
                        ← Back to Orders
                    </a>
                </div>

                {{-- TRACKING --}}
                <div class="card tracking-card">
                    <h2>Order Tracking</h2>

                    <div class="tracking-bar-wrap">
                        <div class="track-line-bg"></div>

                        {{-- Active line width based on status --}}
                        <div class="track-line-active" style="
                            width:
                            @if($order->status == 'pending') 10%
                            @elseif($order->status == 'accepted') 50%
                            @elseif($order->status == 'completed' || $order->status == 'cancelled') 100%
                            @endif
                            ;
                            @if($order->status == 'cancelled') background: linear-gradient(90deg, #ef4444, #f87171); @endif
                        "></div>

                        {{-- Step 1: Pending --}}
                        <div class="track-step">
                            <div class="step-circle {{ in_array($order->status, ['pending','accepted','completed']) ? 'active' : '' }}">
                                ✓
                            </div>
                            <div class="step-label {{ in_array($order->status, ['pending','accepted','completed']) ? 'active' : '' }}">
                                Pending
                            </div>
                        </div>

                        {{-- Step 2: Accepted --}}
                        <div class="track-step">
                            <div class="step-circle {{ in_array($order->status, ['accepted','completed']) ? 'active' : '' }}">
                                ✓
                            </div>
                            <div class="step-label {{ in_array($order->status, ['accepted','completed']) ? 'active' : '' }}">
                                Accepted
                            </div>
                        </div>

                        {{-- Step 3: Completed / Cancelled --}}
                        <div class="track-step">
                            @if($order->status == 'cancelled')
                                <div class="step-circle cancelled">✕</div>
                                <div class="step-label cancelled">Cancelled</div>
                            @else
                                <div class="step-circle {{ $order->status == 'completed' ? 'active' : '' }}">✓</div>
                                <div class="step-label {{ $order->status == 'completed' ? 'active' : '' }}">Completed</div>
                            @endif
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="status-badge-wrap">
                        @if($order->status == 'pending')
                            <span class="status-badge badge-pending">🕒 Waiting for Restaurant Approval</span>
                        @elseif($order->status == 'accepted')
                            <span class="status-badge badge-accepted">👨‍🍳 Restaurant is Preparing Your Order</span>
                        @elseif($order->status == 'completed')
                            <span class="status-badge badge-completed">✅ Order Delivered Successfully</span>
                        @elseif($order->status == 'cancelled')
                            <span class="status-badge badge-cancelled">❌ Order Cancelled</span>
                        @endif
                    </div>
                </div>

                   @if($order->tracking_url)

                    <button
                        type="button"
                        onclick="openTracking()"
                        class="bg-green-500 text-white px-6 py-3 rounded-2xl inline-block mt-5 mb-5">
                        Track Delivery
                    </button>

                    <div id="trackingContainer" style="display:none;" class="mt-4 mb-4">
                        <iframe
                            id="trackingFrame"
                            src=""
                            width="100%"
                            height="700"
                            style="border:none; border-radius:16px; background:#fff;">
                        </iframe>
                    </div>

                    <script>
                    function openTracking() {

                        document.getElementById('trackingContainer').style.display = 'block';

                        document.getElementById('trackingFrame').src =
                            "{{ $order->tracking_url }}";

                        // optional scroll
                        document.getElementById('trackingContainer')
                            .scrollIntoView({ behavior: 'smooth' });
                    }
                    </script>

                    @endif


                 
                {{-- DRIVER DETAILS --}}
                @if($order->driver_name)

                <div class="card info-card mt-4">

                    <h3>Driver Details</h3>

                    <div class="info-row">

                        <div class="info-item">
                            <label>Driver Name</label>

                            <span>
                                {{ $order->driver_name }}
                            </span>
                        </div>

                        <div class="info-item">
                            <label>Driver Phone</label>

                            <span>
                                {{ $order->driver_phone ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <label>Delivery Status</label>

                            <span style="
                                color:#16a34a;
                                font-weight:700;
                                text-transform:capitalize;
                            ">
                                {{ str_replace('_', ' ', $order->delivery_status) }}
                            </span>
                        </div>

                        @if($order->picked_at)

                        <div class="info-item">
                            <label>Picked At</label>

                            <span>
                                {{ \Carbon\Carbon::parse($order->picked_at)->format('d M Y h:i A') }}
                            </span>
                        </div>

                        @endif

                        @if($order->delivered_at)

                        <div class="info-item">
                            <label>Delivered At</label>

                            <span>
                                {{ \Carbon\Carbon::parse($order->delivered_at)->format('d M Y h:i A') }}
                            </span>
                        </div>

                        @endif

                    </div>

                </div>

                @endif


                {{-- PAYMENT + DELIVERY --}}
                <div class="info-grid">

                    {{-- Payment --}}
                    <div class="card info-card">
                        <h3>Payment Details</h3>
                        <div class="info-row">
                            <div class="info-item">
                                <label>Method</label>
                                <span>{{ ucfirst($order->payment_method) }}</span>
                            </div>
                            <div class="info-item">
                                <label>Status</label>
                                @php $pStatus = $order->payment->payment_status ?? 'pending'; @endphp
                                <span class="payment-status-{{ strtolower($pStatus) }}">
                                    {{ ucfirst($pStatus) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Delivery --}}
                    <div class="card info-card">
                        <h3>Delivery Details</h3>
                        <div class="info-row">
                            <div class="info-item">
                                <label>Order Type</label>
                                <span>{{ ucfirst(str_replace('_', ' ', $order->order_type)) }}</span>
                            </div>
                            <div class="info-item">
                                <label>Phone</label>
                                <span>{{ $order->phone ?? '—' }}</span>
                            </div>
                            <div class="info-item">
                                <label>Address</label>
                                <span>{{ $order->address ?? '—' }}</span>
                            </div>
                            <div class="info-item">
                                <label>Delivery Status</label>
                                <span>{{ $order->delivery_status ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ORDERED ITEMS --}}
                <div class="card items-card">
                    <div class="items-header">
                        <h2>Ordered Items</h2>
                    </div>

                    <div class="items-body">
                        @php $grandTotal = 0; @endphp

                        @foreach($order->items as $item)
                            @php
                                $subtotal = $item->price * $item->quantity;
                                $grandTotal += $subtotal;
                            @endphp

                            <div class="order-item">
                                <div class="item-left">
                                    <img
                                        src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : asset('no-image.png') }}"
                                        class="item-img"
                                        alt="{{ $item->product->name ?? 'Product' }}"
                                    >
                                    <div>
                                        <div class="item-name">{{ $item->product->name }}</div>
                                        <div class="item-meta">£{{ number_format($item->price, 2) }} × {{ $item->quantity }}</div>
                                    </div>
                                </div>
                                <div class="item-total">£{{ number_format($subtotal, 2) }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="totals-row">
                        <span class="totals-label">Total Amount</span>
                        <span class="totals-amount">£{{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>

            </div>{{-- end main --}}
        </div>
    </div>
</div>

@endsection