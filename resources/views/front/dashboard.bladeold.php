@extends('front.layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

.dash-page {
    background: rgba(245, 240, 232, 0.95);
    min-height: 100vh;
    padding: 32px 16px 100px;
    /* font-family: 'DM Sans', sans-serif; */
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
    border-radius: 20px;
    border: 1px solid #E8E6E0;
    padding: 22px 20px;
}
.stat-label {
    font-size: 13px;
    color: #9CA3AF;
    font-weight: 500;
    margin-bottom: 10px;
}
.stat-value {
    /* font-family: 'Syne', sans-serif; */
    font-size: 36px;
    font-weight: 700;
    color: #111;
    line-height: 1;
}
.stat-value.green { color: #16A34A; }

/* table card */
.table-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #E8E6E0;
    overflow: hidden;
}
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 22px 24px;
    border-bottom: 1px solid #F0EEE9;
}
.table-header h2 {
    /* font-family: 'Syne', sans-serif; */
    font-size: 20px;
    font-weight: 700;
    color: #111;
    margin: 0;
}
.table-header a {
    color: #E63946;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
}
.orders-table { width: 100%; border-collapse: collapse; }
.orders-table th {
    padding: 14px 20px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: .06em;
    border-bottom: 1px solid #F0EEE9;
}
.orders-table td {
    padding: 16px 20px;
    font-size: 14px;
    color: #374151;
    font-weight: 500;
    border-bottom: 1px solid #F9F8F5;
}
.orders-table tr:last-child td { border-bottom: none; }
.status-pill {
    display: inline-flex;
    align-items: center;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.pill-pending  { background: #FEF9C3; color: #A16207; }
.pill-accepted { background: #DBEAFE; color: #1D4ED8; }
.pill-completed{ background: #DCFCE7; color: #15803D; }
.pill-cancelled{ background: #FEE2E2; color: #B91C1C; }
.pill-default  { background: #F3F4F6; color: #374151; }

/* mobile order cards */
.mob-order-list { display: none; }
.mob-order-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px solid #F0EEE9;
    gap: 12px;
}
.mob-order-card:last-child { border-bottom: none; }
.mob-oid {  font-weight: 700; font-size: 15px; color: #111; }
.mob-odate { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
.mob-oamt { font-weight: 700; font-size: 15px; color: #111; }

/* mobile page title */
.mob-page-title {
    display: none;
    /* font-family: 'Syne', sans-serif; */
    font-size: 26px;
    font-weight: 800;
    color: #111;
    margin-bottom: 18px;
}

@media(max-width: 900px) {
    .dash-wrap { grid-template-columns: 1fr; }
}
@media(max-width: 640px) {
    .dash-page { padding: 20px 14px 100px; }
    .mob-page-title { display: block; }
    .stat-grid { grid-template-columns: 1fr 1fr; }
    .stat-value { font-size: 28px; }
    .table-header { padding: 18px 16px; }
    .orders-table { display: none; }
    .mob-order-list { display: block; padding: 0 16px 8px; }
    .orders-table th, .orders-table td { padding: 12px 16px; }
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

            {{-- STAT CARDS --}}
            {{-- <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-label">My Orders</div>
                    <div class="stat-value">
                        {{ \App\Models\Order::where('user_id', auth()->id())->count() }}
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Spent</div>
                    <div class="stat-value green">
                        £{{ number_format(\App\Models\Payment::where('user_id', auth()->id())->where('payment_status','paid')->sum('amount'), 2) }}
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Cart Items</div>
                    <div class="stat-value">{{ count(session('cart', [])) }}</div>
                </div>
            </div> --}}

            <div style="
                display:flex;
                justify-content:flex-end;
                margin-bottom:20px;
            ">

                <div style="position:relative;">

                    <button
                        onclick="toggleNotifications()"
                        
                        style="
                            border:none;
                            background:#fff;
                            width:55px;
                            height:55px;
                            border-radius:50%;
                            cursor:pointer;
                            box-shadow:0 4px 15px rgba(0,0,0,.08);
                            position:relative;
                        ">

                        🔔

                        
                            <span
                            id="notificationCount"
                            style="
                                position:absolute;
                                top:5px;
                                right:5px;
                                background:red;
                                color:white;
                                width:20px;
                                height:20px;
                                border-radius:50%;
                                font-size:11px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                {{ $unreadCount }}
                            </span>
                        

                    </button>

                    <div id="notificationDropdown"
                        style="
                            display:none;
                            position:absolute;
                            top:65px;
                            right:0;
                            width:400px;
                            background:#fff;
                            border-radius:18px;
                            box-shadow:0 15px 50px rgba(0,0,0,.12);
                            z-index:999;
                            overflow:hidden;
                        ">

                        <div style="
                            padding:18px;
                            border-bottom:1px solid #eee;
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                        ">

                            <strong>Notifications</strong>

                            <form
                                method="POST"
                                action="{{ route('notifications.clearAll') }}">
                                @csrf

                                <button
                                    style="
                                        border:none;
                                        background:none;
                                        color:red;
                                        cursor:pointer;
                                    ">
                                    Clear All
                                </button>

                            </form>

                        </div>

                        <div 
                        id="notificationList"
                        style="
                            max-height:400px;
                            overflow-y:auto;
                        ">

                            {{-- @forelse($notifications as $notification)

                                <div style="
                                    padding:15px;
                                    border-bottom:1px solid #f5f5f5;
                                ">

                                    <div style="
                                        display:flex;
                                        justify-content:space-between;
                                        gap:10px;
                                    ">

                                        <div>

                                            <div style="
                                                font-weight:700;
                                                margin-bottom:5px;
                                            ">
                                                {{ $notification->title }}
                                            </div>

                                            <div style="
                                                font-size:13px;
                                                color:#666;
                                            ">
                                                {{ $notification->message }}
                                            </div>

                                            <div style="
                                                margin-top:6px;
                                                font-size:11px;
                                                color:#999;
                                            ">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>

                                        </div>

                                        <form
                                            method="POST"
                                            action="{{ route('notifications.clear',$notification->id) }}">
                                            @csrf

                                            <button
                                                style="
                                                    border:none;
                                                    background:none;
                                                    color:red;
                                                    cursor:pointer;
                                                ">
                                                ✕
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @empty

                                <div style="
                                    padding:25px;
                                    text-align:center;
                                    color:#999;
                                ">
                                    No notifications
                                </div>

                            @endforelse --}}

                        </div>

                    </div>

                </div>

            </div>

            {{-- RECENT ORDERS --}}
            <div class="table-card">
                <div class="table-header">
                    <h2>Recent Orders</h2>
                    <a href="/my-orders">View All</a>
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
                            <td>#{{ $order->id }}</td>
                            <td>£{{ $order->total_amount }}</td>
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
                    padding:15px;
                    border-bottom:1px solid #f5f5f5;
                ">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        gap:10px;
                    ">

                        <div>

                            <div style="
                                font-weight:700;
                                margin-bottom:5px;
                            ">
                                ${item.title}
                            </div>

                            <div style="
                                font-size:13px;
                                color:#666;
                            ">
                                ${item.message}
                            </div>

                        </div>

                    </div>

                </div>
            `;
        });

        if(data.notifications.length === 0){

            html = `
                <div style="
                    padding:25px;
                    text-align:center;
                    color:#999;
                ">
                    No notifications
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