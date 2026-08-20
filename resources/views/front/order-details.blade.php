@extends('front.layouts.app')

@section('content')

<style>
        /* =============================================
        ORDER DETAIL PAGE — RESPONSIVE
        ============================================= */
        .od-page {
            background: rgba(245, 240, 232, 0.95);
            min-height: 100vh;
            padding: 32px 16px 100px;
        }
        .od-wrap {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 24px;
            align-items: start;
        }
        /* CARDS */
        .od-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #E8E6E0;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .od-card:last-child { margin-bottom: 0; }

        /* HEADER */
        .od-header {
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .od-title { font-size: 22px; font-weight: 700; color: #111; margin: 0 0 4px; }
        .od-sub   { font-size: 12px; color: #999; letter-spacing: .06em; }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #111;
            color: #fff;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .back-btn:hover { background: #333; }

        /* TRACKING */
        .od-tracking { padding: 24px 28px; }
        .od-tracking h2 { font-size: 15px; font-weight: 700; color: #111; margin: 0 0 28px; }

        .track-bar-wrap {
            position: relative;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 0 4px;
        }
        .track-line-bg {
            position: absolute;
            top: 18px; left: 0; right: 0;
            height: 3px;
            background: #E8E6E0;
            border-radius: 10px;
            z-index: 0;
        }
        .track-line-active {
            position: absolute;
            top: 18px; left: 0;
            height: 3px;
            border-radius: 10px;
            z-index: 1;
            background: linear-gradient(90deg, #16a34a, #22c55e);
            transition: width .8s ease;
        }
        .track-line-cancelled {
            background: linear-gradient(90deg, #ef4444, #f87171) !important;
        }
        .track-step {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
        }
        .step-dot {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            border: 3px solid #E8E6E0;
            background: #fff;
            color: #ccc;
            transition: all .3s;
        }
        .step-dot.active    { background:#16a34a; border-color:#16a34a; color:#fff; box-shadow:0 0 0 4px rgba(22,163,74,.15); }
        .step-dot.cancelled { background:#ef4444; border-color:#ef4444; color:#fff; box-shadow:0 0 0 4px rgba(239,68,68,.15); }
        .step-lbl {
            font-size: 11px;
            font-weight: 600;
            color: #aaa;
            white-space: nowrap;
            text-align: center;
            line-height: 1.3;
        }
        .step-lbl.active    { color: #16a34a; }
        .step-lbl.cancelled { color: #ef4444; }

        /* STATUS BADGE */
        .status-badge-wrap { margin-top: 24px; display: flex; justify-content: center; }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 22px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
        }
        .sb-searching     { background:#FEF9C3; color:#A16207; }
        .sb-almost_picking{ background:#DBEAFE; color:#1D4ED8; }
        .sb-in_transit    { background:#EDE9FE; color:#6D28D9; }
        .sb-delivered     { background:#DCFCE7; color:#15803D; }
        .sb-canceled      { background:#FEE2E2; color:#B91C1C; }

        /* INFO SECTIONS */
        .od-info-body { padding: 20px 28px; }
        .od-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #aaa;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin: 0 0 16px;
        }
        .od-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .od-info-item label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #bbb;
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .od-info-item span {
            font-size: 14px;
            font-weight: 600;
            color: #222;
        }
        .pay-paid    { color: #16a34a; }
        .pay-pending { color: #d97706; }

        /* TRACK BUTTON */
        .track-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #16a34a;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .track-btn:hover { background: #15803d; }
        .track-iframe-wrap { margin-bottom: 20px; }
        .track-iframe-wrap iframe {
            width: 100%;
            height: 500px;
            border: none;
            border-radius: 16px;
            background: #fff;
        }

        /* ORDERED ITEMS */
        .items-header { padding: 18px 28px; border-bottom: 1px solid #F0EDE8; }
        .items-header h2 { font-size: 16px; font-weight: 700; color: #111; margin: 0; }
        .items-body { padding: 0 28px 20px; }
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #F5F5F2;
            gap: 12px;
        }
        .order-item:last-of-type { border-bottom: none; }
        .item-left { display: flex; align-items: center; gap: 14px; }
        .item-img {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            background: #F3F4F6;
        }
        .item-name { font-size: 14px; font-weight: 600; color: #111; margin-bottom: 4px; }
        .item-meta { font-size: 12px; color: #999; }
        .item-total { font-size: 14px; font-weight: 700; color: #E11D48; white-space: nowrap; }
        .items-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 28px 20px;
            border-top: 2px solid #F0EDE8;
        }
        .items-total-label { font-size: 14px; font-weight: 700; color: #111; }
        .items-total-amount { font-size: 22px; font-weight: 800; color: #E11D48; }

        /* REVIEW SECTION */
        .review-prompt {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            padding: 22px 28px;
        }
        .review-prompt h3 { font-size: 18px; font-weight: 700; color: #111; margin: 0 0 5px; }
        .review-prompt p  { font-size: 13px; color: #888; margin: 0; }
        .review-btn {
            background: #111;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .15s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .review-btn:hover { background: #333; transform: translateY(-1px); }

        /* REVIEW DISPLAY */
        .review-display { padding: 22px 28px; }
        .review-display h3 { font-size: 16px; font-weight: 700; color: #111; margin: 0 0 10px; }
        .review-stars { font-size: 20px; margin-bottom: 12px; }
        .review-text  { color: #4B5563; font-size: 14px; line-height: 1.7; margin: 0 0 14px; }
        .review-submitted {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ECFDF5;
            color: #16A34A;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        /* REVIEW MODAL */
        .review-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .review-modal {
            background: #fff;
            width: 100%;
            max-width: 520px;
            border-radius: 24px;
            overflow: hidden;
            animation: rpop .2s ease;
        }
        @keyframes rpop {
            from { opacity:0; transform:scale(.92); }
            to   { opacity:1; transform:scale(1); }
        }
        .rmodal-header {
            padding: 22px 26px;
            border-bottom: 1px solid #F0EDE8;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }
        .rmodal-header h2 { font-size: 20px; font-weight: 700; color: #111; margin: 0 0 4px; }
        .rmodal-header p  { font-size: 13px; color: #888; margin: 0; }
        .rmodal-close {
            background: #F3F4F6;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .rmodal-body { padding: 24px 26px; }

        /* STAR RATING */
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: center; gap: 6px; }
        .star-rating input { display: none; }
        .star-rating .star { font-size: 44px; color: #D1D5DB; cursor: pointer; transition: .2s; }
        .star-rating .star:hover,
        .star-rating .star:hover ~ .star { color: #FBBF24; transform: scale(1.1); }
        .star-rating input:checked ~ .star { color: #F59E0B; }
        .rating-text {
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
            font-weight: 600;
            color: #888;
            min-height: 20px;
        }

        .r-label { display: block; font-size: 13px; font-weight: 600; color: #111; margin: 0 0 10px; }
        .r-textarea {
            width: 100%;
            border: 1.5px solid #E8E6E0;
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 14px;
            resize: none;
            outline: none;
            color: #111;
            background: #FAFAF8;
            box-sizing: border-box;
            transition: border-color .2s;
        }
        .r-textarea:focus { border-color: #E63946; background: #fff; }
        .rmodal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        .rmodal-cancel {
            background: #F3F4F6;
            color: #111;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .rmodal-submit {
            background: #16A34A;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }
        .rmodal-submit:hover { background: #15803d; }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .od-wrap { grid-template-columns: 1fr; }
        }
        @media(max-width: 640px) {
            .od-page { padding: 16px 12px 100px; }
            .od-header { padding: 16px 18px; }
            .od-title { font-size: 18px; }
            .od-tracking { padding: 18px; }
            .track-bar-wrap { padding: 0; }
            .step-dot { width: 28px; height: 28px; font-size: 11px; }
            .track-line-bg, .track-line-active { top: 13px; }
            .step-lbl { font-size: 9px; }
            .od-info-grid { grid-template-columns: 1fr; gap: 14px; }
            .od-info-body { padding: 16px 18px; }
            .items-body { padding: 0 16px 16px; }
            .items-header { padding: 14px 18px; }
            .items-total-row { padding: 14px 18px 18px; }
            .review-prompt { padding: 16px 18px; }
            .review-display { padding: 16px 18px; }
            .item-img { width: 52px; height: 52px; }
            .od-card { border-radius: 16px; }
            .review-modal { max-width: 100%; border-radius: 20px 20px 0 0; }
            .review-modal-bg { align-items: flex-end; padding: 0; }
            .star-rating .star { font-size: 36px; }
        }



        .order-flow-card{
            background:#fff;
            border-radius:24px;
            padding:30px;
            margin-bottom:30px;
            box-shadow:0 10px 30px rgba(0,0,0,.05);
        }

        .order-flow-title{
            font-size:22px;
            font-weight:700;
            color:#111827;
            margin-bottom:35px;
        }

        .order-flow-wrapper{
            position:relative;
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
        }

        .order-flow-bar{
            position:absolute;
            top:18px;
            left:0;
            right:0;
            height:4px;
            background:#E5E7EB;
            z-index:1;
        }

        .order-flow-bar-active{
            height:100%;
            width:0;
            background:#22C55E;
            transition:.5s ease;
        }

        .order-flow-step{
            position:relative;
            z-index:2;
            width:33.33%;
            display:flex;
            flex-direction:column;
            align-items:center;
        }

        .order-flow-circle{
            width:38px;
            height:38px;
            border-radius:50%;
            background:#D1D5DB;
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:14px;
            font-weight:700;
            transition:.3s;
        }

        .order-flow-circle.active{
            background:#22C55E;
        }

        .order-flow-circle.cancelled{
            background:#EF4444;
        }

        .order-flow-step span{
            margin-top:12px;
            font-size:13px;
            font-weight:600;
            color:#6B7280;
        }

        .order-flow-status{
            text-align:center;
            margin-top:35px;
        }

        .order-flow-status span{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 18px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
        }

        .flow-pending{
            background:#FEF3C7;
            color:#B45309;
        }

        .flow-accepted{
            background:#DBEAFE;
            color:#1D4ED8;
        }

        .flow-completed{
            background:#DCFCE7;
            color:#15803D;
        }

        .flow-cancelled{
            background:#FEE2E2;
            color:#DC2626;
        }

        .flow-refunded{
            background:#F3E8FF;
            color:#7E22CE;
        }

        @media(max-width:768px){

            .order-flow-card{
                padding:20px;
            }

            .order-flow-step span{
                font-size:11px;
            }

            .order-flow-circle{
                width:32px;
                height:32px;
                font-size:12px;
            }
        }
</style>

<div class="od-page">
    <div class="od-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- MAIN --}}
        <div>

            {{-- HEADER --}}
            <div class="">
                <div class="od-header">
                    <div>
                        {{-- <div class="od-title">Order Details</div> --}}
                        <div class="od-title">ORDER #{{ $order->id }}</div>
                    </div>
                    {{-- <a href="/my-orders" class="back-btn">← Back</a> --}}
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">

                        

                        <a href="/my-orders"
                            class="back-btn">

                            ← Back

                        </a>

                    </div>
                </div>
            </div>

            {{-- ORDER MESSAGES --}}
            @if($messages->count())
                <div class="od-card" style="margin-bottom:20px;">

                    <div class="items-header"
                        style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                        ">

                        <h2>Messages</h2>

                        
                            <span style="
                                background:#EFF6FF;
                                color:#2563EB;
                                padding:6px 12px;
                                border-radius:999px;
                                font-size:12px;
                                font-weight:700;
                            ">
                                {{ $messages->count() }} Messages
                            </span>
                        

                    </div>

                    <div style="padding:22px;">

                        @forelse($messages as $message)

                            <div style="
                                margin-bottom:18px;
                                display:flex;
                                {{ $message->sender_id == auth()->id() ? 'justify-content:flex-end;' : 'justify-content:flex-start;' }}
                            ">

                                <div style="
                                    max-width:80%;
                                    padding:14px 16px;
                                    border-radius:18px;
                                    {{ $message->sender_id == auth()->id()
                                        ? 'background:#2563EB; color:#fff; border-bottom-right-radius:4px;'
                                        : 'background:#F3F4F6; color:#111827; border-bottom-left-radius:4px;'
                                    }}
                                ">

                                    <div style="
                                        font-size:13px;
                                        line-height:1.7;
                                        margin-bottom:8px;
                                        word-break:break-word;
                                    ">

                                        {{ $message->message }}

                                    </div>

                                    <div style="
                                        font-size:11px;
                                        opacity:.7;
                                        text-align:right;
                                    ">

                                        {{ $message->created_at->format('d M Y h:i A') }}

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div style="
                                text-align:center;
                                padding:30px 20px;
                            ">

                                <div style="
                                    font-size:42px;
                                    margin-bottom:10px;
                                ">
                                    💬
                                </div>

                                <h3 style="
                                    font-size:16px;
                                    font-weight:700;
                                    color:#111827;
                                    margin-bottom:6px;
                                ">
                                    No Messages Yet
                                </h3>

                                <p style="
                                    color:#6B7280;
                                    font-size:13px;
                                    margin:0;
                                ">
                                    Restaurant messages about your order will appear here.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>
            @endif

            {{-- TRACKING --}}
            {{-- @php
                $deliveryStatus = $order->delivery_status ?? 'searching';
                $isCancelled    = $deliveryStatus === 'canceled';

                $progressMap = [
                    'searching'       => '10%',
                    'almost_picking'  => '30%',
                    'waiting_at_pickup'=> '55%',
                    'picking'         => '55%',
                    'in_transit'      => '80%',
                    'delivered'       => '100%',
                    'canceled'        => '100%',
                ];
                $progress = $progressMap[$deliveryStatus] ?? '5%';

                $step1 = in_array($deliveryStatus, ['searching','almost_picking','waiting_at_pickup','picking','in_transit','delivered']);
                $step2 = in_array($deliveryStatus, ['almost_picking','waiting_at_pickup','picking','in_transit','delivered']);
                $step3 = in_array($deliveryStatus, ['waiting_at_pickup','picking','in_transit','delivered']);
                $step4 = in_array($deliveryStatus, ['in_transit','delivered']);
                $step5 = $deliveryStatus === 'delivered';
            @endphp --}}

            @php

                $deliveryStatus = $order->uber_delivery_status ?? 'pending';

               

                $courierImminent = $order->courier_imminent ?? false;

                $isCancelled = in_array($deliveryStatus, ['canceled','returned']);

                $progressMap = [
                    'pending'           => '10%',
                    'pickup'            => $courierImminent ? '40%' : '30%',
                    'pickup_complete'   => '60%',
                    'dropoff'           => $courierImminent ? '90%' : '80%',
                    'delivered'         => '100%',
                    'canceled'          => '100%',
                    'returned'          => '100%',
                    'shopping_completed'=> '60%',
                ];

                $progress = $progressMap[$deliveryStatus] ?? '10%';

                $step1 = in_array($deliveryStatus, [
                    'pending',
                    'pickup',
                    'pickup_complete',
                    'dropoff',
                    'delivered'
                ]);

                $step2 = in_array($deliveryStatus, [
                    'pickup',
                    'pickup_complete',
                    'dropoff',
                    'delivered'
                ]);

                $step3 = in_array($deliveryStatus, [
                    'pickup_complete',
                    'dropoff',
                    'delivered'
                ]);

                $step4 = in_array($deliveryStatus, [
                    'dropoff',
                    'delivered'
                ]);

                $step5 = $deliveryStatus == 'delivered';

            @endphp

            
            
 
            @if ($order->order_type == 'delivery' && $order->delivery_provider == 'uber')
                <div class="od-card">
                    <div class="od-tracking">
                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            margin-bottom:20px;
                            
                            ">
                            <h2>Delivery Tracking</h2>
                            @if($order->invoice)

                                <a href="{{ route('user.invoice.show',$order->id) }}"
                                    class="back-btn"
                                    style="
                                        background:#2563EB;
                                    ">

                                    👁 Invoice

                                </a>

                            @endif
                        </div>
                        

                        <div class="track-bar-wrap">
                            <div class="track-line-bg"></div>
                            <div class="track-line-active {{ $isCancelled ? 'track-line-cancelled' : '' }}" style="width:{{ $progress }};"></div>

                            {{-- Step 1 --}}
                            <div class="track-step">
                                <div class="step-dot {{ $step1 ? 'active' : '' }}">✓</div>
                                <div class="step-lbl {{ $step1 ? 'active' : '' }}">Search</div>
                            </div>
                            {{-- Step 2 --}}
                            <div class="track-step">
                                <div class="step-dot {{ $step2 ? 'active' : '' }}">✓</div>
                                <div class="step-lbl {{ $step2 ? 'active' : '' }}">Assigned</div>
                            </div>
                            {{-- Step 3 --}}
                            <div class="track-step">
                                <div class="step-dot {{ $step3 ? 'active' : '' }}">✓</div>
                                <div class="step-lbl {{ $step3 ? 'active' : '' }}">Pickup</div>
                            </div>
                            {{-- Step 4 --}}
                            <div class="track-step">
                                <div class="step-dot {{ $step4 ? 'active' : '' }}">✓</div>
                                <div class="step-lbl {{ $step4 ? 'active' : '' }}">On Way</div>
                            </div>
                            {{-- Step 5 --}}
                            <div class="track-step">
                                @if($isCancelled)
                                    <div class="step-dot cancelled">✕</div>
                                    <div class="step-lbl cancelled">Cancelled</div>
                                @else
                                    <div class="step-dot {{ $step5 ? 'active' : '' }}">✓</div>
                                    <div class="step-lbl {{ $step5 ? 'active' : '' }}">Delivered</div>
                                @endif
                            </div>
                        </div>

                        <div class="status-badge-wrap">

                            @switch($deliveryStatus)

                                @case('pending')
                                    <span class="status-badge sb-searching">
                                        Searching Driver
                                    </span>
                                @break

                                @case('pickup')
                                    @if($courierImminent)
                                        <span class="status-badge sb-almost_picking">
                                            Driver Near Restaurant
                                        </span>
                                    @else
                                        <span class="status-badge sb-almost_picking">
                                            Driver Assigned
                                        </span>
                                    @endif
                                @break

                                @case('pickup_complete')
                                    <span class="status-badge sb-almost_picking">
                                        Order Picked Up
                                    </span>
                                @break

                                @case('dropoff')
                                    @if($courierImminent)
                                        <span class="status-badge sb-in_transit">
                                            Driver Arriving
                                        </span>
                                    @else
                                        <span class="status-badge sb-in_transit">
                                            On The Way
                                        </span>
                                    @endif
                                @break

                                @case('delivered')
                                    <span class="status-badge sb-delivered">
                                        Delivered
                                    </span>
                                @break

                                @case('canceled')
                                    <span class="status-badge sb-canceled">
                                        ❌ Cancelled
                                    </span>
                                @break

                                @case('returned')
                                    <span class="status-badge sb-canceled">
                                        Returned
                                    </span>
                                @break

                            @endswitch

                        </div>
                    </div>
                </div>
            @else
                <div class="order-flow-card">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        margin-bottom:20px;
                        
                        ">
                        <h3 class="order-flow-title" style="margin:0;">
                            Order Progress
                        </h3>
                        @if($order->invoice)

                            <a href="{{ route('user.invoice.show',$order->id) }}"
                                class="back-btn"
                                style="
                                    background:#2563EB;
                                ">

                                👁 Invoice

                            </a>

                        @endif
                    </div>

                    <div class="order-flow-wrapper">

                        <div class="order-flow-bar">
                            <div
                                id="orderFlowProgress"
                                class="order-flow-bar-active">
                            </div>
                        </div>

                        <div class="order-flow-step">
                            <div id="flowPending" class="order-flow-circle">
                                ✓
                            </div>
                            <span>Pending</span>
                        </div>

                        <div class="order-flow-step">
                            <div id="flowAccepted" class="order-flow-circle">
                                ✓
                            </div>
                            <span>Accepted</span>
                        </div>

                        <div class="order-flow-step">
                            <div id="flowCompleted" class="order-flow-circle">
                                ✓
                            </div>
                            <span>Completed</span>
                        </div>

                    </div>

                    <div class="order-flow-status">
                        <span id="flowStatusBadge">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                </div>
            @endif

            <script>

                const orderId = {{ $order->id }};

                function fetchOrderStatus()
                {
                    fetch(`/my-orders/${orderId}/status`)
                    .then(response => response.json())
                    .then(data => {

                        console.log(data);

                        if(document.getElementById('flowStatusBadge'))
                        {
                            updateOrderFlow(data.status);
                            updateCancelSection(data);
                        }

                        if(document.querySelector('.od-tracking'))
                        {
                            updateDeliveryTracking(data.uber_delivery_status);
                        }

                    })
                    .catch(error => {

                        console.log(error);

                    });
                }

                /*
                |--------------------------------------------------------------------------
                | ORDER FLOW
                |--------------------------------------------------------------------------
                */

                function updateOrderFlow(status)
                {
                    const pending =
                        document.getElementById('flowPending');

                    const accepted =
                        document.getElementById('flowAccepted');

                    const completed =
                        document.getElementById('flowCompleted');

                    const progress =
                        document.getElementById('orderFlowProgress');

                    const badge =
                        document.getElementById('flowStatusBadge');

                    if(!badge) return;

                    [pending, accepted, completed].forEach(el => {

                        if(el){
                            el.classList.remove('active');
                            el.classList.remove('cancelled');
                        }

                    });

                    badge.className = '';

                    switch(status)
                    {
                        case 'pending':

                            pending?.classList.add('active');

                            badge.classList.add('flow-pending');

                            badge.innerHTML = 'Pending';

                            progress && (progress.style.width='0%');

                        break;

                        case 'accepted':

                            pending?.classList.add('active');
                            accepted?.classList.add('active');

                            badge.classList.add('flow-accepted');

                            badge.innerHTML = 'Accepted';

                            progress && (progress.style.width='50%');

                        break;

                        case 'completed':

                            pending?.classList.add('active');
                            accepted?.classList.add('active');
                            completed?.classList.add('active');

                            badge.classList.add('flow-completed');

                            badge.innerHTML = 'Completed';

                            progress && (progress.style.width='100%');

                        break;

                        case 'cancelled':

                            pending?.classList.add('cancelled');

                            badge.classList.add('flow-cancelled');

                            badge.innerHTML = '❌ Cancelled';

                        break;

                        case 'refunded':

                            pending?.classList.add('active');
                            accepted?.classList.add('active');

                            badge.classList.add('flow-refunded');

                            badge.innerHTML = '↩ Refunded';

                            progress && (progress.style.width='50%');

                        break;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | DELIVERY FLOW
                |--------------------------------------------------------------------------
                */

                function updateDeliveryTracking(status, courierImminent = false)
                {
                    const badgeWrap = document.querySelector('.status-badge-wrap');

                    if(!badgeWrap) return;

                    let badge = '';

                    switch(status)
                    {
                        case 'pending':

                            badge =
                            '<span class="status-badge sb-searching">Searching Driver</span>';

                        break;

                        case 'pickup':

                            if(courierImminent){

                                badge =
                                '<span class="status-badge sb-almost_picking">Driver Near Restaurant</span>';

                            }else{

                                badge =
                                '<span class="status-badge sb-almost_picking">Driver Assigned</span>';

                            }

                        break;

                        case 'pickup_complete':

                            badge =
                            '<span class="status-badge sb-almost_picking">Order Picked Up</span>';

                        break;

                        case 'dropoff':

                            if(courierImminent){

                                badge =
                                '<span class="status-badge sb-in_transit">Driver Arriving</span>';

                            }else{

                                badge =
                                '<span class="status-badge sb-in_transit">On The Way</span>';

                            }

                        break;

                        case 'delivered':

                            badge =
                            '<span class="status-badge sb-delivered">Delivered</span>';

                        break;

                        case 'canceled':

                            badge =
                            '<span class="status-badge sb-canceled">Cancelled</span>';

                        break;

                        case 'returned':

                            badge =
                            '<span class="status-badge sb-canceled">Returned</span>';

                        break;

                        case 'shopping_completed':

                            badge =
                            '<span class="status-badge sb-almost_picking">Shopping Completed</span>';

                        break;

                        default:

                            badge =
                            '<span class="status-badge sb-searching">Searching Driver</span>';

                    }

                    badgeWrap.innerHTML = badge;
                }


                function updateCancelSection(data)
                {
                    const container = document.getElementById('cancelOrderContainer');

                    if (!container) return;

                    // Hide completely after completion
                    if (data.status === 'completed') {
                        container.innerHTML = '';
                        return;
                    }

                    // Show cancelled card
                    if (data.status === 'cancelled') {

                        container.innerHTML = `
                            <div class="od-card" style="margin-bottom:20px;">
                                <div class="od-info-body">

                                    <h3 style="font-size:18px;font-weight:700;color:#DC2626;margin-bottom:8px;">
                                        Order Cancelled
                                    </h3>

                                    <p style="font-size:13px;color:#6B7280;margin-bottom:18px;">
                                        This order has been cancelled.
                                    </p>

                                    <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:12px;padding:16px;">
                                        <div style="font-size:13px;font-weight:700;color:#991B1B;margin-bottom:8px;">
                                            Cancellation Reason
                                        </div>

                                        <div style="font-size:14px;color:#374151;">
                                            ${data.cancel_reason ?? 'No reason provided.'}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        `;

                        return;
                    }

                    // Hide cancel button once order is accepted by restaurant (status is no longer pending)
                    if (data.status !== 'pending' && data.status !== 'cancelled') {
                        container.innerHTML = '';
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | INITIAL LOAD
                |--------------------------------------------------------------------------
                */

                fetchOrderStatus();

                /*
                |--------------------------------------------------------------------------
                | AUTO REFRESH EVERY 5 SECONDS
                |--------------------------------------------------------------------------
                */

                setInterval(fetchOrderStatus, 5000);





            </script>

            

            {{-- LIVE TRACK BUTTON --}}
            {{-- @if($order->tracking_url)
            <div style="margin-bottom:20px;">
                <button type="button" onclick="openTracking()"  class="track-btn">
                     Track Live Delivery
                </button>
                <div id="trackingContainer" style="display:none;" class="track-iframe-wrap">
                    <object
                        data="{{ $order->tracking_url }}"
                        width="100%"
                        height="600">
                    </object>
                </div>
            </div>
            @endif --}}

            @if($order->uber_tracking_url)

            <div style="margin-bottom:20px;">
                <button type="button" onclick="openTracking()"  class="track-btn">
                     Track Live Delivery
                </button>
            </div>    

            @endif
            

            
            {{-- @if($order->tracking_url)

                <a
                    href="{{ $order->tracking_url }}"
                    target="_blank"
                    class="track-btn"
                >
                    Track Live Delivery
                </a>

            @endif --}}

            {{-- DRIVER DETAILS --}}
            @if($order->driver_name)
            <div class="od-card">
                <div class="od-info-body">
                    <div class="od-section-title">Driver Details</div>
                    <div class="od-info-grid">
                        <div class="od-info-item">
                            <label>Driver Name</label>
                            <span>{{ $order->driver_name }}</span>
                        </div>
                        <div class="od-info-item">
                            <label>Phone</label>
                            <span>{{ $order->driver_phone ?? 'N/A' }}</span>
                        </div>
                        <div class="od-info-item">
                            <label>Status</label>
                            <span style="color:#16a34a; text-transform:capitalize;">
                                {{ str_replace('_', ' ', $order->delivery_status) }}
                            </span>
                        </div>
                        @if($order->picked_at)
                        <div class="od-info-item">
                            <label>Picked At</label>
                            <span>{{ \Carbon\Carbon::parse($order->picked_at)->format('d M Y h:i A') }}</span>
                        </div>
                        @endif
                        @if($order->delivered_at)
                        <div class="od-info-item">
                            <label>Delivered At</label>
                            <span>{{ \Carbon\Carbon::parse($order->delivered_at)->format('d M Y h:i A') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            

            {{-- Complaint Support --}}
            @if($order->status !== 'pending' && $order->status !== 'canceled')
                <div class="od-card" style="margin-bottom:20px;">

                    <div class="od-info-body">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            flex-wrap:wrap;
                            gap:20px;
                        ">

                            <div>

                                <h3 style="
                                    font-size:18px;
                                    font-weight:700;
                                    color:#111827;
                                    margin-bottom:8px;
                                ">
                                    Complaint Support
                                </h3>

                                <p style="
                                    color:#6B7280;
                                    font-size:13px;
                                    line-height:1.7;
                                    margin:0;
                                ">
                                    View complaint history or raise a new complaint.
                                </p>

                            </div>

                            <div style="display:flex;gap:10px;">

                                <button
                                    onclick="openComplaintsModal()"
                                    style="
                                        background:#111827;
                                        color:#fff;
                                        border:none;
                                        padding:12px 20px;
                                        border-radius:14px;
                                        cursor:pointer;
                                        font-weight:700;
                                    ">
                                    Complaints ({{ $complaints->count() }})
                                </button>

                                <button
                                    onclick="document.getElementById('complaintModal').style.display='flex'"
                                    style="
                                        background:#DC2626;
                                        color:#fff;
                                        border:none;
                                        padding:12px 20px;
                                        border-radius:14px;
                                        cursor:pointer;
                                        font-weight:700;
                                    ">
                                    New Complaint
                                </button>

                            </div>

                        </div>

                    </div>

                </div>
            @endif

            {{-- Complaint History --}}

            <div id="complaintsHistoryModal"
                style="
                    display:none;
                    position:fixed;
                    inset:0;
                    background:rgba(0,0,0,.6);
                    z-index:99999;
                    align-items:center;
                    justify-content:center;
                "
                >

                        <div style="
                            width:95%;
                            max-width:800px;
                            max-height:80vh;
                            overflow-y:auto;
                            background:#fff;
                            border-radius:20px;
                            padding:25px;
                            ">

                            <div style="
                                display:flex;
                                justify-content:space-between;
                                align-items:center;
                                margin-bottom:20px;
                                ">

                                <h3 style="margin:0;">
                                    Complaint History
                                </h3>

                                <button
                                    onclick="closeComplaintsModal()"
                                    style="
                                        border:none;
                                        background:none;
                                        font-size:22px;
                                        cursor:pointer;
                                    ">
                                    ✕
                                </button>

                            </div>

                            @forelse($complaints as $complaint)

                                <div style="
                                    border:1px solid #E5E7EB;
                                    border-radius:14px;
                                    padding:16px;
                                    margin-bottom:16px;
                                ">

                                    <div style="
                                        display:flex;
                                        justify-content:space-between;
                                        margin-bottom:10px;
                                    ">

                                        <strong>
                                            {{ $complaint->subject }}
                                        </strong>

                                        <small>
                                            {{ $complaint->created_at->format('d M Y') }}
                                        </small>

                                    </div>

                                    @foreach($complaint->messages as $message)

                                        @if($message->sender_type == 'customer')

                                            <div style="
                                                background:#DBEAFE;
                                                padding:4px 12px 4px 12px;
                                                border-radius:12px;
                                                margin-bottom:10px;
                                                margin-left:80px;
                                                font-size:12px;
                                            ">

                                                {{-- <strong>You</strong><br> --}}

                                                {{ $message->message }}

                                            </div>

                                        @else

                                            <div style="
                                                background:#ECFDF5;
                                                padding:4px 12px 4px 12px;
                                                border-radius:12px;
                                                margin-bottom:10px;
                                                margin-right:80px;
                                                font-size:12px;
                                            ">

                                                {{-- <strong>Restaurant</strong><br> --}}

                                                {{ $message->message }}

                                            </div>

                                        @endif

                                        

                                    @endforeach

                                    <form method="POST"
                                            action="{{ route('complaints.message',$complaint->id) }}">

                                            @csrf

                                            <textarea
                                                name="message"
                                                rows="2"
                                                required
                                                style="
                                                    width:100%;
                                                    padding:10px;
                                                    border-radius:10px;
                                                    border:1px solid #ddd;
                                                    font-size:14px;
                                                "></textarea>

                                            <button
                                                type="submit"
                                                style="
                                                    margin-top:10px;
                                                    background:#DC2626;
                                                    color:#fff;
                                                    border:none;
                                                    padding:10px 20px;
                                                    border-radius:10px;
                                                ">
                                                Send
                                            </button>

                                        </form>

                                </div>

                            @empty

                                <div style="
                                    text-align:center;
                                    color:#6B7280;
                                    padding:30px;
                                ">
                                    No complaints found.
                                </div>

                            @endforelse

                        </div>

            </div>

            {{-- @if(
                in_array(
                    $order->status,
                    ['delivered','canceled']
                )
            ) --}}

            

            {{-- @endif --}}

            <div id="complaintModal"
                style="
                    display:none;
                    position:fixed;
                    inset:0;
                    background:rgba(0,0,0,.6);
                    z-index:99999;
                    align-items:center;
                    justify-content:center;
                ">

                <div style="
                    background:#fff;
                    width:100%;
                    max-width:550px;
                    border-radius:24px;
                    padding:25px;
                ">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        margin-bottom:20px;
                    ">

                        <h3 style="margin:0;">
                            Raise Complaint
                        </h3>

                        <button
                            onclick="document.getElementById('complaintModal').style.display='none'"
                            style="
                                border:none;
                                background:none;
                                font-size:20px;
                                cursor:pointer;
                            ">
                            ✕
                        </button>

                    </div>

                    <form action="{{ route('complaints.store') }}"
                        method="POST">

                        @csrf


                        <input type="hidden"
                            name="restaurant_id"
                            value="{{ $order->restaurant_id }}">

                        <input type="hidden"
                            name="order_id"
                            value="{{ $order->id }}">

                        <div style="margin-bottom:15px;">

                            <label style="font-weight:600;">
                                Subject
                            </label>

                            <input type="text"
                                name="subject"
                                required
                                style="
                                        width:100%;
                                        padding:12px;
                                        border:1px solid #ddd;
                                        border-radius:12px;
                                        margin-top:6px;
                                ">

                        </div>
                        <div style="margin-bottom:15px;">

                            <label style="font-weight:600;">
                                Complaint Category
                            </label>

                            <select
                                name="category"
                                required
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:1px solid #ddd;
                                    border-radius:12px;
                                    margin-top:6px;
                                ">

                                <option value="">
                                    Select Category
                                </option>

                                <option value="Food Quality">
                                    Food Quality
                                </option>

                                <option value="Wrong Order">
                                    Wrong Order
                                </option>

                                <option value="Late Delivery">
                                    Late Delivery
                                </option>

                                <option value="Missing Items">
                                    Missing Items
                                </option>

                                <option value="Hygiene Issue">
                                    Hygiene Issue
                                </option>

                                <option value="Packaging Issue">
                                    Packaging Issue
                                </option>

                                <option value="Staff Behaviour">
                                    Staff Behaviour
                                </option>

                                <option value="Billing Issue">
                                    Billing Issue
                                </option>

                                <option value="Refund Issue">
                                    Refund Issue
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>

                        <div style="margin-bottom:20px;">

                            <label style="font-weight:600;">
                                Complaint
                            </label>

                            <textarea
                                name="complaint"
                                rows="5"
                                required
                                style="
                                    width:100%;
                                    padding:12px;
                                    border:1px solid #ddd;
                                    border-radius:12px;
                                    margin-top:6px;
                                "
                            ></textarea>

                        </div>

                        <button type="submit"
                                style="
                                    width:100%;
                                    background:#DC2626;
                                    color:#fff;
                                    border:none;
                                    padding:14px;
                                    border-radius:12px;
                                    font-weight:700;
                                ">

                            Submit Complaint

                        </button>

                    </form>

                </div>

            </div>

            {{-- CANCEL ORDER --}}
            <div id="cancelOrderContainer">
                @if($order->status === 'pending')

                    <div class="od-card" style="margin-bottom:20px;">

                        <div class="od-info-body">

                            <div style="
                                display:flex;
                                justify-content:space-between;
                                align-items:center;
                                gap:20px;
                                flex-wrap:wrap;
                            ">

                                <div>

                                    <h3 style="
                                        font-size:18px;
                                        font-weight:700;
                                        color:#111827;
                                        margin-bottom:8px;
                                    ">
                                        Cancel Order
                                    </h3>

                                    <p style="
                                        font-size:13px;
                                        color:#6B7280;
                                        line-height:1.7;
                                        margin:0 0 14px;
                                        max-width:620px;
                                    ">

                                        You can cancel this order only until the restaurant accepts it.
                                        Once the restaurant has accepted your order,
                                        cancellation will no longer be available.

                                    </p>

                                    <div style="
                                        background:#FEF2F2;
                                        border:1px solid #FECACA;
                                        color:#B91C1C;
                                        padding:12px 14px;
                                        border-radius:14px;
                                        font-size:13px;
                                        font-weight:600;
                                        line-height:1.6;
                                    ">

                                        ⚠️ Cancellation is allowed only before the restaurant accepts your order.

                                    </div>

                                </div>

                                <form method="POST"
                                    action="/order/cancel/{{ $order->id }}"
                                    onsubmit="return confirm('Are you sure you want to cancel this order?')">

                                    @csrf

                                    <button type="submit"
                                        style="
                                            background:#DC2626;
                                            color:#fff;
                                            border:none;
                                            padding:14px 24px;
                                            border-radius:14px;
                                            font-size:14px;
                                            font-weight:700;
                                            cursor:pointer;
                                            white-space:nowrap;
                                            transition:.2s;
                                        "
                                        onmouseover="this.style.background='#B91C1C'"
                                        onmouseout="this.style.background='#DC2626'">

                                        Cancel Order

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @elseif($order->status === 'cancelled' && $order->cancel_reason !== null)

                    <div class="od-card" style="margin-bottom:20px;">

                        <div class="od-info-body">

                            <div>

                                <h3 style="
                                    font-size:18px;
                                    font-weight:700;
                                    color:#DC2626;
                                    margin-bottom:8px;
                                ">
                                    Order Cancelled
                                </h3>

                                <p style="
                                    font-size:13px;
                                    color:#6B7280;
                                    line-height:1.7;
                                    margin-bottom:18px;
                                ">
                                    This order has been cancelled.
                                </p>

                                <div style="
                                    background:#FEF2F2;
                                    border:1px solid #FECACA;
                                    border-radius:12px;
                                    padding:16px;
                                ">

                                    <div style="
                                        font-size:13px;
                                        font-weight:700;
                                        color:#991B1B;
                                        margin-bottom:8px;
                                    ">
                                        Cancellation Reason
                                    </div>

                                    <div style="
                                        font-size:14px;
                                        color:#374151;
                                        line-height:1.7;
                                    ">
                                        {{ $order->cancel_reason ?? 'No reason provided.' }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                @endif

            </div>

            {{-- PAYMENT + DELIVERY --}}
            <div class="od-info-grid" style="margin-bottom:20px;">
                {{-- Payment --}}
                <div class="od-card" style="margin-bottom:0;">
                    <div class="od-info-body">
                        <div class="od-section-title">Payment Details</div>
                        <div style="display:flex; flex-direction:column; gap:14px;">
                            <div class="od-info-item">
                                <label>Method</label>
                                <span>{{ ucfirst($order->payment->payment_type ?? 'N/A') }}({{ $order->payment->payment_method ?? 'N/A' }})</span>
                            </div>
                            <div class="od-info-item">
                                <label>Status</label>
                                @php $pStatus = $order->payment->payment_status ?? 'pending'; @endphp
                                <span class="pay-{{ strtolower($pStatus) }}">{{ ucfirst($pStatus) }}</span>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                {{-- Delivery --}}
                <div class="od-card" style="margin-bottom:0;">
                    <div class="od-info-body">
                        <div class="od-section-title">
                            @if($order->order_type == 'takeaway')
                                Takeaway Details
                            @elseif($order->order_type == 'dine_in')
                                Dine-In Details
                            @elseif($order->order_type == 'table_book')
                                Table Booking Details
                            @else
                                Delivery Details
                            @endif
                        </div>
                        <div style="display:flex; flex-direction:column; gap:14px;">
                            <div class="od-info-item">
                                <label>Type</label>
                                <span style="font-weight:700; text-transform:capitalize;">{{ str_replace('_', ' ', $order->order_type) }}</span>
                            </div>

                            @if($order->order_type == 'table_book')
                                <div class="od-info-item">
                                    <label>Booking Date</label>
                                    <span style="font-weight:700;">{{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->format('d M Y') : '—' }}</span>
                                </div>
                                <div class="od-info-item">
                                    <label>Booking Time</label>
                                    <span style="font-weight:700;">{{ $order->booking_time ? \Carbon\Carbon::parse($order->booking_time)->format('h:i A') : '—' }}</span>
                                </div>
                                <div class="od-info-item">
                                    <label>Guests</label>
                                    <span style="font-weight:700;">{{ $order->number_of_people ?? '—' }} Persons</span>
                                </div>
                                <div class="od-info-item">
                                    <label>Occasion</label>
                                    <span style="font-weight:700; color:#6B21A8; background:#F3E8FF; padding:4px 10px; border-radius:12px; border:1px solid #E9D5FF;">🎉 {{ $order->occasion ?? '—' }}</span>
                                </div>
                            @else
                                <div class="od-info-item" style="align-items:flex-start;">
                                    <label style="margin-top:6px;">{{ $order->order_type == 'takeaway' ? 'Pick Up Time' : 'Order Time' }}</label>
                                    <span>
                                        @if($order->is_scheduled && $order->scheduled_for)
                                            <div style="background:linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%); border:1px solid #C7D2FE; padding:10px 14px; border-radius:12px; display:inline-flex; align-items:center; gap:10px;">
                                                <span style="font-size:20px;">📅</span>
                                                <div>
                                                    <div style="font-size:10px; font-weight:700; color:#4338CA; text-transform:uppercase; letter-spacing:0.5px;">Scheduled Order</div>
                                                    <div style="font-size:13px; font-weight:700; color:#1E1B4B; margin-top:1px;">
                                                        {{ \Carbon\Carbon::parse($order->scheduled_for)->format('l, d M Y @ h:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span style="display:inline-flex; align-items:center; gap:6px; background:#ECFDF5; border:1px solid #A7F3D0; color:#065F46; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:600;">
                                                <span>⚡</span> As Soon As Possible (ASAP)
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            @endif

                            <div class="od-info-item">
                                <label>Phone</label>
                                <span>{{ $order->phone ?? '—' }}</span>
                            </div>

                            @if($order->order_type == 'delivery')
                            <div class="od-info-item">
                                <label>Address</label>
                                <span>{{ $order->address ?? '—' }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- REVIEW --}}
            @if($order->delivery_status == 'delivered' || $order->status === 'completed')
                @if(!$order->review)
                <div class="od-card" style="margin-bottom:20px;">
                    <div class="review-prompt">
                        <div>
                            <h3>Enjoyed Your Meal?</h3>
                            <p>Share your experience with this restaurant.</p>
                        </div>
                        <button onclick="openReviewModal()" class="review-btn">⭐ Write Review</button>
                    </div>
                </div>
                @else
                <div class="od-card" style="margin-bottom:20px;">
                    <div class="review-display">
                        <h3>Your Review</h3>
                        <div class="review-stars">
                            @for($i = 1; $i <= $order->review->rating; $i++) ⭐ @endfor
                        </div>
                        <p class="review-text">{{ $order->review->review }}</p>
                        <span class="review-submitted">✓ Submitted</span>
                    </div>
                </div>
                @endif
            @endif

            @if($order->status === 'completed')

            <div class="od-card" style="margin-bottom:20px;">

                <div class="items-header">
                    <h2>Order Received Proof</h2>
                </div>

                <div style="padding:22px;">

                    @if(!$customerEvidence)

                        <form
                            method="POST"
                            action="{{ route('user.orders.evidence',$order->id) }}"
                            enctype="multipart/form-data">

                            @csrf

                            <div style="margin-bottom:15px;">
                                <input
                                    type="file"
                                    name="photo"
                                    required
                                    style="
                                        width:100%;
                                        padding:12px;
                                        border:1px solid #ddd;
                                        border-radius:12px;
                                    ">
                            </div>

                            <div style="margin-bottom:15px;">
                                <textarea
                                    name="description"
                                    rows="4"
                                    required
                                    placeholder="Describe what you received..."
                                    style="
                                        width:100%;
                                        padding:12px;
                                        border:1px solid #ddd;
                                        border-radius:12px;
                                    "></textarea>
                            </div>

                            <button
                                type="submit"
                                class="review-btn">

                                Upload Proof

                            </button>

                        </form>

                    @else

                        <img
                            src="{{ asset($customerEvidence->photo) }}"
                            style="
                                width:100%;
                                max-height:350px;
                                object-fit:cover;
                                border-radius:14px;
                                margin-bottom:15px;
                            ">

                        <div style="
                            background:#F9FAFB;
                            padding:16px;
                            border-radius:14px;
                            line-height:1.8;
                            color:#374151;
                        ">
                            {{ $customerEvidence->description }}
                        </div>

                    @endif

                </div>

            </div>

            @endif
					
				@if($restaurantEvidence)

                    <div class="od-card" style="margin-bottom:20px; overflow:hidden;">

                        <div class="items-header">
                            <h2> Restaurant Completion Proof</h2>
                        </div>

                        <div style="padding:20px;">

                            <!-- Image Box -->
                            <div style="
                                width:100%;
                                height:320px;
                                border-radius:16px;
                                overflow:hidden;
                                
                                
                            ">

                                <img
                                    src="{{ asset($restaurantEvidence->photo) }}"
                                    alt="Restaurant Proof"
                                    style="
                                        width:100%;
                                        height:100%;
                                        object-fit:cover;
                                        display:block;
                                    ">

                            </div>

                            <!-- Description -->
                            <div style="
                                margin-top:20px;
                                background:#F9FAFB;
                                border:1px solid #E5E7EB;
                                border-radius:16px;
                                padding:18px;
                            ">

                                <h4 style="
                                    margin:0 0 10px;
                                    font-size:16px;
                                    font-weight:700;
                                    color:#111827;
                                ">
                                    Description
                                </h4>

                                <p style="
                                    margin:0;
                                    color:#4B5563;
                                    line-height:1.8;
                                    font-size:15px;
                                ">
                                    {{ $restaurantEvidence->description }}
                                </p>

                            </div>

                        </div>

                    </div>

				@endif

            
            @if($order->description)
            <div style="margin-top:20px;
                        margin-bottom:20px;
                        background:#FFF8F4;
                        border:1px solid #F3D6C8;
                        border-radius:12px;
                        padding:16px;">

                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                    <span style="font-size:18px;">📝</span>
                    <span style="font-size:15px;font-weight:700;color:#111;">
                        Order Notes
                    </span>
                </div>

                <p style="font-size:14px;
                        color:#555;
                        line-height:1.7;
                        white-space:pre-line;
                        margin:0;">
                    {{ $order->description }}
                </p>

            </div>
            @endif    
					
            {{-- LOYALTY REWARD ATTACHED INFORMATION --}}
            @if(($order->loyalty_discount ?? 0) > 0 || $order->loyaltyReward)
            <div class="od-card" style="background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); border: 1px solid #FCD34D; padding: 20px 24px; border-radius: 20px; margin-bottom: 20px; box-shadow: 0 4px 14px rgba(245,158,11,0.12);">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #F59E0B; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(245,158,11,0.25);">
                            🏷️
                        </div>
                        <div>
                            <h3 style="font-size: 15px; font-weight: 700; color: #78350F; margin: 0 0 3px;">Loyalty Reward Redeemed</h3>
                            <p style="font-size: 13px; color: #92400E; margin: 0;">
                                You saved <strong>£{{ number_format($order->loyalty_discount, 2) }}</strong> on this order using your loyalty reward!
                                @if($order->loyaltyReward)
                                    <span style="display:inline-block; margin-left:4px; font-weight:600;">({{ $order->loyaltyReward->reward_type === 'percentage' ? number_format($order->loyaltyReward->reward_value, 0).'% Off' : '£'.number_format($order->loyaltyReward->reward_value, 2).' Off' }})</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <span style="background: #F59E0B; color: #fff; font-size: 12px; font-weight: 700; padding: 6px 16px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 2px 8px rgba(245,158,11,0.25);">
                        -£{{ number_format($order->loyalty_discount, 2) }} OFF
                    </span>
                </div>
            </div>
            @endif

            @if($order->earnedLoyaltyReward)
            <div class="od-card" style="background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border: 1px solid #6EE7B7; padding: 20px 24px; border-radius: 20px; margin-bottom: 20px; box-shadow: 0 4px 14px rgba(16,185,129,0.12);">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #10B981; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(16,185,129,0.25);">
                            🎁
                        </div>
                        <div>
                            <h3 style="font-size: 15px; font-weight: 700; color: #065F46; margin: 0 0 3px;">Loyalty Reward Unlocked!</h3>
                            <p style="font-size: 13px; color: #047857; margin: 0;">
                                Congratulations! This order earned you a reward of <strong>{{ $order->earnedLoyaltyReward->reward_type === 'percentage' ? number_format($order->earnedLoyaltyReward->reward_value, 0).'% Off' : '£'.number_format($order->earnedLoyaltyReward->reward_value, 2).' Off' }}</strong> for your next order at {{ $order->restaurant->name ?? 'this restaurant' }}!
                                @if($order->earnedLoyaltyReward->expires_at)
                                    <span style="display:block; margin-top:2px; font-size:12px; color:#059669;">Expires on {{ $order->earnedLoyaltyReward->expires_at->format('d M, Y') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <span style="background: #10B981; color: #fff; font-size: 12px; font-weight: 700; padding: 6px 16px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 2px 8px rgba(16,185,129,0.25);">
                        {{ ucfirst($order->earnedLoyaltyReward->status) }}
                    </span>
                </div>
            </div>
            @endif

            {{-- ORDERED ITEMS --}}
            <div class="od-card" style="background:#ffffff; border-radius:20px; border:1px solid #E8E6E0; overflow:hidden; margin-bottom:20px;">
                <div class="items-header" style="padding:22px 28px; border-bottom:1px solid #F0EDE8;">
                    <h2 style="font-size:18px; font-weight:700; color:#111111; margin:0;">Ordered Items</h2>
                </div>
                <div class="items-body" style="padding:8px 28px 16px;">
                    @php $itemsSubtotal = 0; @endphp
                    @foreach($order->items as $item)
                        @php
                            $itemTotal = $item->total ?? ($item->price * $item->quantity);
                            $itemsSubtotal += $itemTotal;
                            $unitPrice = $item->quantity > 0 ? ($itemTotal / $item->quantity) : $item->price;
                        @endphp
                        <div class="order-item" style="display:flex; justify-content:space-between; align-items:flex-start; padding:20px 0; border-bottom:1px solid #F0EDE8; gap:16px;">
                            <div class="item-left" style="display:flex; align-items:flex-start; gap:16px; flex:1;">
                                <img 
                                    src="{{ $item->product && $item->product->image ? (str_starts_with($item->product->image, 'http') ? $item->product->image : config('services.google_drive.image_url') . $item->product->image) : asset('no-image.png') }}"
                                    class="item-img" 
                                    alt="{{ $item->product->name ?? 'Product' }}"
                                    style="width:68px; height:68px; border-radius:12px; object-fit:cover; flex-shrink:0; background:#F3F4F6; border:1px solid #E5E7EB;"
                                >
                                <div style="flex:1;">
                                    <div class="item-name" style="font-size:15px; font-weight:700; color:#111827; margin-bottom:4px;">
                                        {{ $item->product->name ?? 'Product' }}
                                    </div>
                                    @if(!empty($item->variant_name))
                                        <div style="font-size:13px; color:#6B7280; margin-bottom:6px; font-weight:500;">
                                            Variant: {{ $item->variant_name }}
                                        </div>
                                    @endif

                                    @if($item->addons && $item->addons->count())
                                        @php
                                            $groupedAddons = $item->addons->groupBy('category_name');
                                        @endphp
                                        <div style="margin-top:8px; margin-bottom:8px;">
                                            @foreach($groupedAddons as $category => $addons)
                                                <div style="font-size:12px; font-weight:700; color:#374151; margin-bottom:6px;">
                                                    {{ $category ?: 'Common Addons' }}
                                                </div>
                                                <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
                                                    @foreach($addons as $addon)
                                                        <div style="display:inline-flex; align-items:center; gap:6px; background:#FFF7F5; border:1px solid #FCD34D; border-radius:50px; padding:4px 12px; font-size:12px; font-weight:600; color:#374151;">
                                                            <span style="width:6px; height:6px; border-radius:50%; background:#C25A2A; display:inline-block;"></span>
                                                            <span>{{ $addon->addon_name }}</span>
                                                            <span style="color:#C25A2A; font-weight:700;">+£{{ number_format($addon->price, 2) }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="item-meta" style="font-size:13px; color:#888888; font-weight:500; margin-top:4px;">
                                        £{{ number_format($unitPrice, 2) }} × {{ $item->quantity }}
                                    </div>
                                </div>
                            </div>
                            <div class="item-total" style="font-size:16px; font-weight:700; color:#C25A2A; white-space:nowrap; text-align:right; margin-top:2px;">
                                £{{ number_format($itemTotal, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Subtotal --}}
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:18px 28px; border-top:1px solid #F0EDE8;">
                    <span class="items-total-label" style="font-size:15px; font-weight:700; color:#111827;">Subtotal</span>
                    <span class="item-total" style="font-size:15px; font-weight:700; color:#C25A2A;">£{{ number_format($itemsSubtotal, 2) }}</span>
                </div>

                {{-- Delivery Fee --}}
                @if($order->delivery_charge > 0)
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:18px 28px; border-top:1px solid #F0EDE8;">
                    <span class="items-total-label" style="font-size:15px; font-weight:700; color:#111827;">Delivery Fee</span>
                    <span class="item-total" style="font-size:15px; font-weight:700; color:#C25A2A;">£{{ number_format($order->delivery_charge, 2) }}</span>
                </div>
                @endif

                {{-- Hyst Charge --}}
                @if($order->hyst_charge > 0)
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:18px 28px; border-top:1px solid #F0EDE8;">
                    <span class="items-total-label" style="font-size:15px; font-weight:700; color:#111827;">Hyst Charge</span>
                    <span class="item-total" style="font-size:15px; font-weight:700; color:#C25A2A;">£{{ number_format($order->hyst_charge, 2) }}</span>
                </div>
                @endif

                {{-- Offer Discount --}}
                @if(($order->offer_discount ?? 0) > 0)
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:18px 28px; border-top:1px solid #F0EDE8;">
                    <span class="items-total-label" style="font-size:15px; font-weight:700; color:#C25A2A; display:flex; align-items:center; gap:6px;">
                        <span>🎉 Offer Discount</span>
                        @if(!empty($order->offer_title))
                            <span style="font-size:12px; font-weight:600; color:#854D0E;">({{ $order->offer_title }})</span>
                        @endif
                    </span>
                    <span class="item-total" style="font-size:15px; font-weight:700; color:#DC2626;">-£{{ number_format($order->offer_discount, 2) }}</span>
                </div>
                @endif

                {{-- Coupon Discount --}}
                @if($order->coupon_discount > 0)
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:18px 28px; border-top:1px solid #F0EDE8;">
                    <span class="items-total-label" style="font-size:15px; font-weight:700; color:#111827;">Coupon Discount</span>
                    <span class="item-total" style="font-size:15px; font-weight:700; color:#DC2626;">-£{{ number_format($order->coupon_discount, 2) }}</span>
                </div>
                @endif

                {{-- Gift Card --}}
                @if($order->gift_card_amount > 0)
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:18px 28px; border-top:1px solid #F0EDE8;">
                    <span class="items-total-label" style="font-size:15px; font-weight:700; color:#111827;">Gift Card</span>
                    <span class="item-total" style="font-size:15px; font-weight:700; color:#DC2626;">-£{{ number_format($order->gift_card_amount, 2) }}</span>
                </div>
                @endif

                {{-- Loyalty Reward Discount --}}
                @if(($order->loyalty_discount ?? 0) > 0)
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:18px 28px; border-top:1px solid #F0EDE8;">
                    <span class="items-total-label" style="font-size:15px; font-weight:700; color:#111827; display:flex; align-items:center; gap:8px;">
                        <span>Loyalty Reward Discount</span>
                        <span style="font-size:10px; background:#FEF3C7; color:#92400E; padding:3px 8px; border-radius:12px; font-weight:700; border:1px solid #FCD34D;">REDEEMED</span>
                    </span>
                    <span class="item-total" style="font-size:15px; font-weight:700; color:#DC2626;">-£{{ number_format($order->loyalty_discount, 2) }}</span>
                </div>
                @endif

                {{-- Order Total --}}
                <div class="items-total-row" style="display:flex; justify-content:space-between; align-items:center; padding:22px 28px; border-top:2px solid #E8E6E0; background:#FAFAFA;">
                    <span class="items-total-label" style="font-size:18px; font-weight:800; color:#111827;">Order Total</span>
                    <span class="items-total-amount" style="font-size:24px; font-weight:800; color:#C25A2A;">£{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

        </div>{{-- end main --}}
    </div>
</div>

{{-- REVIEW MODAL --}}
@if($order->delivery_status == 'delivered' || $order->status === 'completed' && !$order->review)
    <div id="reviewModal" class="review-modal-bg">
        <div class="review-modal">
            <div class="rmodal-header">
                <div>
                    <h2>Rate Your Restaurant Order</h2>
                    <p>Your feedback helps improve service.</p>
                </div>
                <button onclick="closeReviewModal()" class="rmodal-close">✕</button>
            </div>
            <div class="rmodal-body">
                <form method="POST" action="/submit-review/{{ $order->id }}">
                    @csrf
                    <div style="margin-bottom:24px;">
                        <label class="r-label" style="text-align:center; display:block; margin-bottom:16px;">Select Rating</label>
                        <div class="star-rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                                <label for="star{{ $i }}" class="star">★</label>
                            @endfor
                        </div>
                        <p class="rating-text" id="ratingText">Tap a star to rate</p>
                    </div>
                    <div style="margin-bottom:20px;">
                        <label class="r-label">Write Review</label>
                        <textarea name="review" rows="4" class="r-textarea" placeholder="Tell us about food quality, delivery, packaging..."></textarea>
                    </div>
                    <div class="rmodal-footer">
                        <button type="button" onclick="closeReviewModal()" class="rmodal-cancel">Cancel</button>
                        <button type="submit" class="rmodal-submit">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<script>
    function openReviewModal() {
        document.getElementById('reviewModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    @if($order->tracking_url)
    function openTracking() {
        var c = document.getElementById('trackingContainer');
        var f = document.getElementById('trackingFrame');
        c.style.display = c.style.display === 'none' ? 'block' : 'none';
        if(f.src === '') f.src = "{{ $order->tracking_url }}";
    }
    @endif

    // Star rating text
    document.addEventListener('DOMContentLoaded', function() {
        var labels = ['','😞 Poor','🙂 Average','😊 Good','😍 Very Good','🔥 Excellent'];
        var inputs = document.querySelectorAll('.star-rating input');
        var text   = document.getElementById('ratingText');
        if(inputs && text) {
            inputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    text.textContent = labels[this.value] || '';
                });
            });
        }
    });
</script>

<script>
    function openComplaintsModal()
    {
        document.getElementById(
            'complaintsHistoryModal'
        ).style.display = 'flex';
    }

    function closeComplaintsModal()
    {
        document.getElementById(
            'complaintsHistoryModal'
        ).style.display = 'none';
    }
    
</script>

@endsection