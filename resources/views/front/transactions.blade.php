@extends('front.layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

/* =============================================
   TRANSACTIONS PAGE — RESPONSIVE
   ============================================= */
.txn-page {
    background: #FAF7F2;
    min-height: 100vh;
    padding: 40px 16px 100px;
}
.txn-wrap {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    align-items: start;
}
.mob-page-title {
    display: none;
    font-family: 'Poppins', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: #0D0D0D;
    margin-bottom: 16px;
    letter-spacing: -.3px;
}

/* CARD */
.txn-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #F0F0EC;
    box-shadow: 0 2px 10px rgba(13,13,13,0.03);
    overflow: hidden;
}

/* HEADER */
.txn-header {
    padding: 26px 28px;
    border-bottom: 1px solid #F0F0EC;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
}
.txn-eyebrow {
    color: #C25A2A;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.txn-eyebrow svg { width: 13px; height: 13px; }
.txn-header h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: #0D0D0D;
    margin: 0 0 4px;
    letter-spacing: -.3px;
}
.txn-header p { font-size: 13px; color: #9CA3AF; margin: 0; }
.txn-total {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #FAF7F2;
    border: 1px solid #F0E4D8;
    color: #C25A2A;
    padding: 10px 20px;
    border-radius: 14px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
}
.txn-total svg { width: 15px; height: 15px; }

/* TABLE */
.txn-table { width: 100%; border-collapse: collapse; }
.txn-table thead tr { background: #FAFAF8; }
.txn-table thead th {
    padding: 13px 18px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #9CA3AF;
    letter-spacing: .06em;
    text-transform: uppercase;
    white-space: nowrap;
}
.txn-table tbody tr {
    border-top: 1px solid #F0F0EC;
    transition: background .15s;
}
.txn-table tbody tr:hover { background: #FAF7F2; }
.txn-table tbody td {
    padding: 15px 18px;
    font-size: 13px;
    color: #1F2937;
    vertical-align: middle;
}

/* BADGES — driven by real status, terracotta/green/blue tokens only */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 700;
    white-space: nowrap;
}
.badge svg { width: 11px; height: 11px; }
.badge-online   { background: #FDEDE4; color: #C25A2A; }
.badge-cod      { background: #DBEAFE; color: #1D4ED8; }
.badge-paid     { background: #ECFDF5; color: #065F46; }
.badge-pending  { background: #FEF9C3; color: #A16207; }

.txn-id    { font-family: 'Poppins', sans-serif; font-weight: 700; color: #374151; font-size: 13px; }
.txn-link  { color: #C25A2A; font-weight: 600; text-decoration: none; font-size: 13px; }
.txn-link:hover { text-decoration: underline; }
.txn-amount { font-family: 'Poppins', sans-serif; font-weight: 700; color: #0D0D0D; font-size: 14px; }
.txn-date   { color: #9CA3AF; font-size: 12px; }
.txn-restaurant { font-size: 13px; color: #374151; }

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 64px 20px;
}
.empty-state-icon-wrap {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: #FAF7F2;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
}
.empty-state-icon-wrap svg { width: 32px; height: 32px; color: #C25A2A; }
.empty-state h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 17px; font-weight: 700; color: #0D0D0D; margin: 0 0 6px;
}
.empty-state p  { color: #9CA3AF; font-size: 13px; margin: 0; }

/* MOBILE CARD VIEW */
.txn-mob-list { display: none; }
.txn-mob-item {
    padding: 16px 18px;
    border-top: 1px solid #F0F0EC;
    transition: background .15s;
}
.txn-mob-item:first-child { border-top: none; }
.tmob-row1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.tmob-row2 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.tmob-id { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; color: #0D0D0D; }
.tmob-amount { font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 700; color: #0D0D0D; }
.tmob-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.tmob-restaurant { font-size: 12px; color: #6B7280; }
.tmob-date { font-size: 11px; color: #9CA3AF; }
.tmob-order-link { font-size: 12px; color: #C25A2A; text-decoration: none; font-weight: 600; }

@media(max-width: 900px) {
    .txn-wrap { grid-template-columns: 1fr; }
}
@media(max-width: 640px) {
    .txn-page { padding: 20px 12px 100px; }
    .mob-page-title { display: block; }
    .txn-header { padding: 18px 18px; }
    .txn-header h1 { font-size: 18px; }
    /* Switch to card layout */
    .txn-table { display: none; }
    .txn-mob-list { display: block; }
    .txn-card { border-radius: 18px; }
    .txn-total { font-size: 13px; padding: 8px 14px; }
}
@media(max-width: 400px) {
    .tmob-row2 { flex-direction: column; align-items: flex-start; }
}
</style>

<div class="txn-page">
    <div class="txn-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- CONTENT --}}
        <div>
            <div class="mob-page-title">Transactions</div>

            <div class="txn-card">

                {{-- HEADER --}}
                <div class="txn-header">
                    <div>
                        <div class="txn-eyebrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2"/><path stroke-linecap="round" d="M1 10h22"/>
                            </svg>
                            Payment History
                        </div>
                        <h1>My Transactions</h1>
                        <p>All your payment records in one place</p>
                    </div>
                    <div class="txn-total">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                        Total: £{{ number_format($payments->sum('amount'), 2) }}
                    </div>
                </div>

                {{-- DESKTOP TABLE --}}
                <table class="txn-table">
                    <thead>
                        <tr>
                            <th>TXN ID</th>
                            <th>Order</th>
                            <th>Restaurant</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td><span class="txn-id">TXN-{{ $payment->id }}</span></td>
                            <td>
                                <a href="/my-orders/{{ $payment->order_id }}" class="txn-link">#{{ $payment->order_id }}</a>
                            </td>
                            <td>
                                <span class="txn-restaurant">{{ $payment->restaurant->name ?? '—' }}</span>
                            </td>
                            <td>
                                @if($payment->payment_method == 'online')
                                    <span class="badge badge-online">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2"/><path stroke-linecap="round" d="M1 10h22"/></svg>
                                        Online
                                    </span>
                                @else
                                    <span class="badge badge-cod">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2"/><circle cx="12" cy="12" r="9"/></svg>
                                        COD
                                    </span>
                                @endif
                            </td>
                            <td><span class="txn-amount">£{{ number_format($payment->amount, 2) }}</span></td>
                            <td>
                                @if($payment->payment_status == 'paid')
                                    <span class="badge badge-paid">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                        Paid
                                    </span>
                                @else
                                    <span class="badge badge-pending">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 3"/></svg>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td><span class="txn-date">{{ $payment->created_at->format('d M Y') }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-state-icon-wrap">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><path stroke-linecap="round" d="M1 10h22"/></svg>
                                    </div>
                                    <h3>No Transactions Found</h3>
                                    <p>Your payment history will appear here.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MOBILE CARD LIST --}}
                <div class="txn-mob-list">
                    @forelse($payments as $payment)
                    <div class="txn-mob-item">
                        <div class="tmob-row1">
                            <span class="tmob-id">TXN-{{ $payment->id }}</span>
                            <span class="tmob-amount">£{{ number_format($payment->amount, 2) }}</span>
                        </div>
                        <div class="tmob-row2">
                            <div class="tmob-meta">
                                <span class="tmob-restaurant">{{ $payment->restaurant->name ?? '—' }}</span>
                                <span class="tmob-date">{{ $payment->created_at->format('d M Y') }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                @if($payment->payment_method == 'online')
                                    <span class="badge badge-online">Online</span>
                                @else
                                    <span class="badge badge-cod">COD</span>
                                @endif
                                @if($payment->payment_status == 'paid')
                                    <span class="badge badge-paid">Paid</span>
                                @else
                                    <span class="badge badge-pending">Pending</span>
                                @endif
                                <a href="/my-orders/{{ $payment->order_id }}" class="tmob-order-link">Order #{{ $payment->order_id }}</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="txn-mob-item">
                        <div class="empty-state">
                            <div class="empty-state-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><path stroke-linecap="round" d="M1 10h22"/></svg>
                            </div>
                            <h3>No Transactions Found</h3>
                            <p>Your payment history will appear here.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

@endsection