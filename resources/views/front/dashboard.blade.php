@extends('front.layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

    .dash-page {
        background: #FAF7F2;
        min-height: 100vh;
        padding: 40px 16px 100px;
    }
    .dash-wrap {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
        align-items: start;
    }

    /* stat cards */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #F0F0EC;
        box-shadow: 0 2px 10px rgba(13,13,13,0.03);
        padding: 22px 20px;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 22px rgba(13,13,13,0.06); }
    .stat-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: #FAF7F2;
        border: 1px solid #F0E4D8;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
    }
    .stat-icon svg { width: 18px; height: 18px; color: #C25A2A; }
    .stat-label {
        font-size: 12.5px;
        color: #9CA3AF;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .stat-value {
        font-family: 'Poppins', sans-serif;
        font-size: 34px;
        font-weight: 800;
        color: #0D0D0D;
        line-height: 1;
        letter-spacing: -.5px;
    }
    .stat-value.green { color: #16A34A; }

    /* page heading row */
    .dash-heading-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 14px;
    }
    .dash-eyebrow {
        color: #C25A2A;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .dash-heading-row h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0D0D0D;
        margin: 0;
        letter-spacing: -.3px;
    }
    .dash-heading-row p {
        color: #9CA3AF;
        font-size: 13.5px;
        margin: 2px 0 0;
    }

    /* notification bell */
    .bell-wrap { position: relative; flex-shrink: 0; }
    .bell-btn {
        border: 1px solid #F0F0EC;
        background: #fff;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(13,13,13,0.05);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color .2s, transform .15s;
    }
    .bell-btn:hover { border-color: #F0E4D8; transform: translateY(-1px); }
    .bell-btn svg { width: 21px; height: 21px; color: #374151; }
    .bell-count {
        position: absolute;
        top: 3px;
        right: 3px;
        background: #C25A2A;
        color: #fff;
        width: 19px;
        height: 19px;
        border-radius: 50%;
        font-size: 10.5px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }

    .notif-dropdown {
        display: none;
        position: absolute;
        top: 60px;
        right: 0;
        width: 380px;
        max-width: calc(100vw - 32px);
        background: #fff;
        border-radius: 18px;
        border: 1px solid #F0F0EC;
        box-shadow: 0 16px 50px rgba(13,13,13,0.12);
        z-index: 999;
        overflow: hidden;
    }
    .notif-dropdown-header {
        padding: 16px 18px;
        border-bottom: 1px solid #F0F0EC;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .notif-dropdown-header strong {
        font-family: 'Poppins', sans-serif;
        font-size: 14.5px;
        font-weight: 700;
        color: #0D0D0D;
    }
    .notif-clear-btn {
        border: none;
        background: none;
        color: #C25A2A;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
    }
    .notif-clear-btn:hover { text-decoration: underline; }
    .notif-list { max-height: 400px; overflow-y: auto; }

    /* table card */
    .table-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #F0F0EC;
        box-shadow: 0 2px 10px rgba(13,13,13,0.03);
        overflow: hidden;
    }
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 22px 24px;
        border-bottom: 1px solid #F0F0EC;
    }
    .table-header h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 19px;
        font-weight: 700;
        color: #0D0D0D;
        margin: 0;
        letter-spacing: -.2px;
    }
    .table-header a {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #C25A2A;
        font-weight: 700;
        font-size: 13.5px;
        text-decoration: none;
    }
    .table-header a:hover { text-decoration: underline; }
    .table-header a svg { width: 13px; height: 13px; }

    .orders-table { width: 100%; border-collapse: collapse; }
    .orders-table th {
        padding: 14px 20px;
        text-align: left;
        font-size: 11.5px;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: .06em;
        border-bottom: 1px solid #F0F0EC;
        background: #FAFAF8;
    }
    .orders-table td {
        padding: 16px 20px;
        font-size: 13.5px;
        color: #374151;
        font-weight: 500;
        border-bottom: 1px solid #F9F8F5;
    }
    .orders-table tr:last-child td { border-bottom: none; }
    .orders-table tr:hover td { background: #FAF7F2; }
    .order-id-cell {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #0D0D0D;
    }
    .order-amt-cell {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #0D0D0D;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .status-pill svg { width: 10px; height: 10px; }
    .pill-pending   { background: #FEF9C3; color: #A16207; }
    .pill-accepted  { background: #DBEAFE; color: #1D4ED8; }
    .pill-completed { background: #ECFDF5; color: #065F46; }
    .pill-cancelled { background: #FEE2E2; color: #B91C1C; }
    .pill-default   { background: #F3F4F6; color: #374151; }

    /* mobile order cards */
    .mob-order-list { display: none; }
    .mob-order-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid #F0F0EC;
        gap: 12px;
    }
    .mob-order-card:last-child { border-bottom: none; }
    .mob-oid { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 15px; color: #0D0D0D; }
    .mob-odate { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
    .mob-oamt { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 15px; color: #0D0D0D; }

    /* mobile page title */
    .mob-page-title {
        display: none;
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0D0D0D;
        margin-bottom: 18px;
        letter-spacing: -.3px;
    }

    @media(max-width: 900px) {
        .dash-wrap { grid-template-columns: 1fr; }
    }
    @media(max-width: 640px) {
        .dash-page { padding: 20px 14px 100px; }
        .mob-page-title { display: block; }
        .dash-heading-row h1, .dash-heading-row p, .dash-eyebrow { display: none; }
        .stat-grid { grid-template-columns: 1fr 1fr; }
        .stat-value { font-size: 26px; }
        .table-header { padding: 18px 16px; }
        .orders-table { display: none; }
        .mob-order-list { display: block; padding: 0 16px 8px; }
        .orders-table th, .orders-table td { padding: 12px 16px; }
        .notif-dropdown { right: -16px; }
    }
    @media(max-width: 380px) {
        .stat-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dash-page">
    <div class="dash-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- CONTENT --}}
        <div>

            <div class="mob-page-title">Dashboard</div>

            {{-- HEADING + NOTIFICATION BELL --}}
            <div class="dash-heading-row">
                <div>
                    <div class="dash-eyebrow">Account Overview</div>
                    <h1>Dashboard</h1>
                    <p>Track your orders and activity at a glance</p>
                </div>

                <div class="bell-wrap">
                    <button onclick="toggleNotifications()" class="bell-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span id="notificationCount" class="bell-count">{{ $unreadCount }}</span>
                    </button>

                    <div id="notificationDropdown" class="notif-dropdown">
                        <div class="notif-dropdown-header">
                            <strong>Notifications</strong>
                            
                            <form method="POST" action="{{ route('notifications.clearAll') }}">
                                @csrf
                                <button class="notif-clear-btn">Clear All</button>
                            </form>
                        </div>
                        <div id="notificationList" class="notif-list"></div>
                    </div>
                </div>
            </div>

            {{-- STAT CARDS --}}
            {{-- <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><path stroke-linecap="round" d="M1 10h22"/></svg>
                    </div>
                    <div class="stat-label">My Orders</div>
                    <div class="stat-value">
                        {{ \App\Models\Order::where('user_id', auth()->id())->count() }}
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2"/><circle cx="12" cy="12" r="9"/></svg>
                    </div>
                    <div class="stat-label">Total Spent</div>
                    <div class="stat-value green">
                        £{{ number_format(\App\Models\Payment::where('user_id', auth()->id())->where('payment_status','paid')->sum('amount'), 2) }}
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path stroke-linecap="round" stroke-linejoin="round" d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    </div>
                    <div class="stat-label">Cart Items</div>
                    <div class="stat-value">{{ count(session('cart', [])) }}</div>
                </div>
            </div> --}}

            {{-- RECENT ORDERS --}}
            <div class="table-card">
                <div class="table-header">
                    <h2>Recent Orders</h2>
                    <a href="/my-orders">
                        View All
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>

                {{-- Desktop table --}}
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Order::where('user_id', auth()->id())->latest()->take(5)->get() as $order)
                        <tr>
                            <td><span class="order-id-cell">#{{ $order->id }}</span></td>
                            <td><span class="order-amt-cell">£{{ $order->total_amount }}</span></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                @php
                                    $pillClass = match($order->status) {
                                        'pending'   => 'pill-pending',
                                        'accepted'  => 'pill-accepted',
                                        'completed' => 'pill-completed',
                                        'cancelled' => 'pill-cancelled',
                                        default     => 'pill-default',
                                    };
                                @endphp
                                <span class="status-pill {{ $pillClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Mobile card list --}}
                <div class="mob-order-list">
                    @foreach(\App\Models\Order::where('user_id', auth()->id())->latest()->take(5)->get() as $order)
                    @php
                        $pillClass = match($order->status) {
                            'pending'   => 'pill-pending',
                            'accepted'  => 'pill-accepted',
                            'completed' => 'pill-completed',
                            'cancelled' => 'pill-cancelled',
                            default     => 'pill-default',
                        };
                    @endphp
                    <div class="mob-order-card">
                        <div>
                            <div class="mob-oid">#{{ $order->id }}</div>
                            <div class="mob-odate">{{ $order->created_at->format('d M Y') }}</div>
                        </div>
                        <div style="display:flex; flex-direction:column; align-items:flex-end; gap:6px;">
                            <div class="mob-oamt">£{{ $order->total_amount }}</div>
                            <span class="status-pill {{ $pillClass }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function toggleNotifications()
    {
        const dropdown =
            document.getElementById(
                'notificationDropdown'
            );

        dropdown.style.display =
            dropdown.style.display === 'block'
            ? 'none'
            : 'block';
    }

    document.addEventListener('click', function(e){

        const dropdown =
            document.getElementById(
                'notificationDropdown'
            );

        if(
            !e.target.closest('#notificationDropdown')
            &&
            !e.target.closest('button')
        ){
            dropdown.style.display = 'none';
        }

    });
</script>

<script>

function fetchNotifications()
{
    fetch('/notifications/latest')
    .then(response => response.json())
    .then(data => {

        const badge =
            document.getElementById(
                'notificationCount'
            );

        if(data.unreadCount > 0){

            badge.style.display = 'flex';
            badge.innerText =
                data.unreadCount;

        }else{

            badge.style.display = 'none';
        }

        let html = '';

        data.notifications.forEach(item => {

            html += `
                <div style="
                    padding:15px 18px;
                    border-bottom:1px solid #F0F0EC;
                    transition: background .15s;
                ">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:10px;
                        ">

                        <div style="flex:1;">

                            <div style="
                                font-family:'Poppins',sans-serif;
                                font-weight:700;
                                font-size:13.5px;
                                color:#0D0D0D;
                                margin-bottom:5px;
                            ">
                                ${item.title}
                            </div>

                            <div style="
                                font-size:12.5px;
                                color:#6B7280;
                                line-height:1.4;
                            ">
                                ${item.message}

                                ${
                                    item.order_id
                                    ? `
                                        <a href="/my-orders/${item.order_id}"
                                            style="
                                                color:#16A34A;
                                                text-decoration:underline;
                                                font-weight:600;
                                                margin-left:4px;
                                            ">
                                            View
                                        </a>
                                    `
                                    : ''
                                }
                            </div>

                        </div>

                        ${
                            item.can_clear
                            ? `
                                <form method="POST"
                                    action="/notifications/${item.id}/clear"
                                    style="margin:0;">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                    <button type="submit"
                                            style="
                                                border:none;
                                                background:none;
                                                color:#9CA3AF;
                                                cursor:pointer;
                                                font-size:18px;
                                                line-height:1;
                                                padding:0;
                                            "
                                            title="Remove notification">
                                        &times;
                                    </button>
                                </form>
                            `
                            : ''
                        }

                    </div>

                </div>
            `;
        });

        if(data.notifications.length === 0){

            html = `
                <div style="
                    padding:30px 20px;
                    text-align:center;
                    color:#9CA3AF;
                    font-size:13px;
                ">
                    No notifications yet
                </div>
            `;
        }

        document.getElementById(
            'notificationList'
        ).innerHTML = html;
    });
}

/*
|--------------------------------------------------------------------------
| FIRST LOAD
|--------------------------------------------------------------------------
*/

fetchNotifications();

/*
|--------------------------------------------------------------------------
| EVERY 10 SECONDS
|--------------------------------------------------------------------------
*/

setInterval(() => {

    fetchNotifications();

}, 10000);

</script>

@endsection