@extends('front.layouts.app')

@section('content')

<style>
    .orders-page {
        background: rgba(245, 240, 232, 0.95);
        min-height: 100vh;
        padding: 32px 16px 100px;
    }
    .orders-wrap {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
        align-items: start;
    }
    .orders-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #E8E6E0;
        overflow: hidden;
    }
    .orders-card-header {
        padding: 28px 32px;
        border-bottom: 1px solid #F0EDE8;
    }
    .orders-card-header h1 {
        font-size: 26px;
        font-weight: 700;
        color: #111;
        margin: 0;
    }
    .mob-page-title {
        display: none;
        font-size: 22px;
        font-weight: 700;
        color: #111;
        margin-bottom: 16px;
    }

    /* TABLE */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }
    .orders-table thead tr {
        background: #F9F8F5;
    }
    .orders-table thead th {
        padding: 14px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #888;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .orders-table tbody tr {
        border-top: 1px solid #F0EDE8;
        transition: background .15s;
    }
    .orders-table tbody tr:hover { background: #FAFAF8; }
    .orders-table tbody td {
        padding: 16px 20px;
        font-size: 14px;
        color: #222;
        vertical-align: middle;
    }
    .order-id { font-weight: 600; color: #111; }
    .order-amount { font-weight: 600; }
    .order-date { color: #888; font-size: 13px; }

    /* BADGES */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge-pending  { background:#FEF9C3; color:#A16207; }
    .badge-accepted { background:#DBEAFE; color:#1D4ED8; }
    .badge-completed{ background:#DCFCE7; color:#15803D; }
    .badge-cancelled{ background:#FEE2E2; color:#B91C1C; }
    .badge-default  { background:#F3F4F6; color:#374151; }

    .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #111;
        color: #fff;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s, transform .15s;
        white-space: nowrap;
    }
    .view-btn:hover { background: #333; transform: translateY(-1px); }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state .empty-icon { font-size: 52px; margin-bottom: 16px; }
    .empty-state h3 { font-size: 18px; font-weight: 700; color: #222; margin: 0 0 8px; }
    .empty-state p { color: #999; font-size: 14px; margin: 0; }

    /* MOBILE CARD VIEW */
    .order-mob-card {
        display: none;
        padding: 16px 20px;
        border-top: 1px solid #F0EDE8;
    }
    .order-mob-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }
    .order-mob-id { font-size: 15px; font-weight: 700; color: #111; }
    .order-mob-amount { font-size: 15px; font-weight: 700; color: #111; }
    .order-mob-meta { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .order-mob-date { font-size: 12px; color: #999; }

    @media(max-width: 900px) {
        .orders-wrap { grid-template-columns: 1fr; }
    }
    @media(max-width: 640px) {
        .orders-page { padding: 20px 14px 100px; }
        .mob-page-title { display: block; }
        .orders-card-header { padding: 20px 18px; }
        .orders-card-header h1 { font-size: 20px; }
        .orders-table thead,
        .orders-table tbody td:not(:first-child):not(:last-child) { display: none; }
        .orders-table tbody tr { display: flex; flex-direction: column; padding: 16px 18px; border-top: 1px solid #F0EDE8; }
        .orders-table tbody td { display: block; padding: 0; }
        .orders-table { display: block; }
        .orders-table tbody { display: block; }
        /* Use card layout on mobile */
        .orders-table { display: none; }
        .order-mob-card { display: block; }
    }
</style>

<div class="orders-page">
    <div class="orders-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- CONTENT --}}
        <div>
            <div class="mob-page-title">My Orders</div>

            <div class="orders-card">
                <div class="orders-card-header">
                    <h1>My Orders</h1>
                </div>

                {{-- DESKTOP TABLE --}}
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><span class="order-id">#{{ $order->id }}</span></td>
                            <td><span class="order-amount">£{{ $order->total_amount }}</span></td>
                            <td><span class="order-date">{{ $order->created_at->format('d M Y') }}</span></td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif($order->status == 'accepted')
                                    <span class="badge badge-accepted">Accepted</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge badge-completed">Completed</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-cancelled">Cancelled</span>
                                @else
                                    <span class="badge badge-default">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="/my-orders/{{ $order->id }}" class="view-btn">View →</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">📦</div>
                                    <h3>No Orders Yet</h3>
                                    <p>Your orders will appear here once you place one.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MOBILE CARD VIEW --}}
                @forelse($orders as $order)
                <div class="order-mob-card">
                    <div class="order-mob-row">
                        <span class="order-mob-id">#{{ $order->id }}</span>
                        <span class="order-mob-amount">£{{ $order->total_amount }}</span>
                    </div>
                    <div class="order-mob-meta">
                        <span class="order-mob-date">{{ $order->created_at->format('d M Y') }}</span>
                        @if($order->status == 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($order->status == 'accepted')
                            <span class="badge badge-accepted">Accepted</span>
                        @elseif($order->status == 'completed')
                            <span class="badge badge-completed">Completed</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge badge-cancelled">Cancelled</span>
                        @else
                            <span class="badge badge-default">{{ ucfirst($order->status) }}</span>
                        @endif
                        <a href="/my-orders/{{ $order->id }}" class="view-btn">View</a>
                    </div>
                </div>
                @empty
                <div class="order-mob-card" style="border-top:none;">
                    <div class="empty-state">
                        <div class="empty-icon">📦</div>
                        <h3>No Orders Yet</h3>
                        <p>Your orders will appear here once you place one.</p>
                    </div>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</div>

@endsection