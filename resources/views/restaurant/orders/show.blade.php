
@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}

<style>
  :root {
    --cream:     #F6F1E8;
    --cream2:    #EDE5D4;
    --cream3:    #E0D5C0;
    --terra:     #C25A2A;
    --terra-l:   #D97040;
    --terra-d:   #8C3D1A;
    --terra-bg:  rgba(194,90,42,0.08);
    --terra-bg2: rgba(194,90,42,0.14);
    --ink:       #1A1208;
    --ink2:      #2E2318;
    --muted:     #8A7A62;
    --muted2:    #6B5C46;
    --green:     #3D8C5A;
    --green-bg:  rgba(61,140,90,0.1);
    --red:       #C23A2A;
    --red-bg:    rgba(194,58,42,0.08);
    --blue:      #2A6CC2;
    --blue-bg:   rgba(42,108,194,0.08);
    --border:    rgba(194,90,42,0.12);
    --border2:   rgba(194,90,42,0.22);
    --shadow:    0 2px 16px rgba(26,18,8,0.08);
    --shadow2:   0 8px 32px rgba(26,18,8,0.12);
    --ease:      cubic-bezier(0.16,1,0.3,1);
  }

  

  

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: var(--cream2); }
  ::-webkit-scrollbar-thumb { background: var(--terra); border-radius: 4px; }

  /* ── Page wrap ── */
  .od-wrap {  margin: 0 auto; padding: 2rem 1.5rem 4rem; }

  /* ── Page header ── */
  .pg-header { margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-start; }
  .pg-eyebrow {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.16em; color: var(--terra); margin-bottom: 6px;
    display: flex; align-items: center; gap: 8px;
  }
  .pg-eyebrow::before { content: ''; width: 16px; height: 2px; background: var(--terra); border-radius: 2px; }
  .pg-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 32px; font-weight: 700; color: var(--ink); line-height: 1.15;
  }
  .pg-header h1 span { color: var(--terra); }
  .pg-sub { font-size: 13px; color: var(--muted); margin-top: 4px; font-weight: 400; }

  .btn-back {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--ink); color: #fff; border: none; border-radius: 10px;
    padding: 10px 20px; font-family: 'Poppins', sans-serif;
    font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none;
    transition: all .22s var(--ease); white-space: nowrap; flex-shrink: 0;
    box-shadow: 0 3px 12px rgba(26,18,8,0.2);
  }
  .btn-back:hover { background: var(--terra); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(194,90,42,0.35); }
  .btn-back svg { width: 14px; height: 14px; }

  /* ── Alert ── */
  .alert-success {
    background: #DCFCE7; border: 1px solid #86EFAC; color: #15803D;
    border-radius: 12px; padding: 14px 18px; margin-bottom: 22px;
    font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;
  }

  /* ── Grid layouts ── */
  .od-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-bottom: 16px; }
  .od-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; margin-bottom: 16px; }

  @media(max-width:900px) { .od-grid-3 { grid-template-columns: repeat(2,1fr); } }
  @media(max-width:600px) { .od-grid-3, .od-grid-2 { grid-template-columns: 1fr; } }

  /* ── Cards ── */
  .od-card {
    background: #fff; border: 1px solid var(--border); border-radius: 16px;
    padding: 22px; box-shadow: var(--shadow);
    animation: fadeUp .5s var(--ease) both;
    transition: box-shadow .25s var(--ease), transform .25s var(--ease);
  }
  .od-card:hover { box-shadow: var(--shadow2); transform: translateY(-2px); border-color: var(--border2); }
  .od-card:nth-child(1){animation-delay:.05s}
  .od-card:nth-child(2){animation-delay:.1s}
  .od-card:nth-child(3){animation-delay:.15s}
  .od-card:nth-child(4){animation-delay:.2s}
  .od-card:nth-child(5){animation-delay:.25s}

  .card-eyebrow {
    font-size: 10.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.12em; color: var(--terra); margin-bottom: 16px;
    display: flex; align-items: center; gap: 7px;
  }
  .card-eyebrow::before { content: ''; width: 12px; height: 2px; background: var(--terra); border-radius: 2px; }

  /* ── Info rows ── */
  .info-row { display: flex; flex-direction: column; gap: 0; }
  .info-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0; border-bottom: 1px solid rgba(194,90,42,0.07);
    gap: 8px;
  }
  .info-item:last-child { border-bottom: none; padding-bottom: 0; }
  .info-item:first-child { padding-top: 0; }
  .info-label { font-size: 12px; color: var(--muted); font-weight: 500; flex-shrink: 0; }
  .info-val { font-size: 13px; font-weight: 600; color: var(--ink2); text-align: right; }
  .info-val.mono { font-family: 'Courier New', monospace; font-size: 12px; }

  /* ── Badges ── */
  .badge {
    display: inline-block; font-size: 10.5px; font-weight: 700;
    padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: .04em;
  }
  .badge-pending  { background: var(--terra-bg);  color: var(--terra);  border: 1px solid rgba(194,90,42,0.2); }
  .badge-accepted { background: var(--blue-bg);   color: var(--blue);   border: 1px solid rgba(42,108,194,0.2); }
  .badge-pickup   { background: rgba(107,92,70,0.1); color: var(--muted2); border: 1px solid rgba(107,92,70,0.2); }
  .badge-completed{ background: var(--green-bg);  color: var(--green);  border: 1px solid rgba(61,140,90,0.2); }
  .badge-cancelled{ background: var(--red-bg);    color: var(--red);    border: 1px solid rgba(194,58,42,0.2); }
  .badge-paid     { background: var(--green-bg);  color: var(--green);  border: 1px solid rgba(61,140,90,0.2); }
  .badge-failed   { background: var(--red-bg);    color: var(--red);    border: 1px solid rgba(194,58,42,0.2); }
  .badge-refunded { background: var(--blue-bg);   color: var(--blue);   border: 1px solid rgba(42,108,194,0.2); }

  /* ── Status Workflow ── */
  .status-hint { font-size: 13px; color: var(--muted); line-height: 1.6; margin-bottom: 16px; }
  .btn-row { display: flex; gap: 10px; flex-wrap: wrap; }

  .od-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px; border-radius: 10px;
    font-size: 13px; font-weight: 600; border: none; cursor: pointer;
    font-family: 'Poppins', sans-serif; text-decoration: none;
    transition: all .22s var(--ease);
  }
  .od-btn svg { width: 15px; height: 15px; flex-shrink: 0; }
  .od-btn:active { transform: scale(.97); }

  .btn-accept  { background: var(--green); color: #fff; box-shadow: 0 3px 12px rgba(61,140,90,0.3); }
  .btn-accept:hover  { background: #2e6e45; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(61,140,90,0.35); }

  .btn-cancel  { background: var(--red-bg); color: var(--red); border: 1px solid rgba(194,58,42,0.25); }
  .btn-cancel:hover  { background: var(--red); color: #fff; transform: translateY(-1px); }

  .btn-pickup  { background: var(--terra); color: #fff; box-shadow: 0 3px 12px rgba(194,90,42,0.3); }
  .btn-pickup:hover  { background: var(--terra-l); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(194,90,42,0.38); }

  .btn-complete { background: var(--green); color: #fff; box-shadow: 0 3px 12px rgba(61,140,90,0.3); }
  .btn-complete:hover { background: #2e6e45; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(61,140,90,0.35); }

  .btn-pay-update {
    width: 100%; justify-content: center;
    background: var(--terra); color: #fff; box-shadow: 0 3px 12px rgba(194,90,42,0.28);
  }
  .btn-pay-update:hover { background: var(--terra-l); transform: translateY(-1px); }

  .btn-refund {
    width: 100%; justify-content: center;
    background: var(--red-bg); color: var(--red); border: 1px solid rgba(194,58,42,0.25);
  }
  .btn-refund:hover { background: var(--red); color: #fff; transform: translateY(-1px); }

  /* Terminal state */
  .terminal-state {
    display: flex; align-items: center; gap: 14px;
    padding: 16px; border-radius: 12px;
  }
  .terminal-state.ts-completed { background: var(--green-bg); border: 1px solid rgba(61,140,90,0.2); }
  .terminal-state.ts-cancelled { background: var(--red-bg);   border: 1px solid rgba(194,58,42,0.15); }
  .terminal-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .terminal-icon svg { width: 20px; height: 20px; }
  .ts-completed .terminal-icon { background: var(--green); }
  .ts-completed .terminal-icon svg { stroke: #fff; }
  .ts-cancelled .terminal-icon  { background: var(--red); }
  .ts-cancelled .terminal-icon svg { stroke: #fff; }
  .terminal-title { font-size: 14px; font-weight: 700; color: var(--ink); }
  .terminal-sub   { font-size: 12px; color: var(--muted); margin-top: 2px; }

  /* Tracking link */
  .track-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: var(--terra); font-size: 12px; font-weight: 600;
    text-decoration: none; margin-top: 10px;
    transition: color .2s;
  }
  .track-link:hover { color: var(--terra-l); }
  .track-link svg { width: 12px; height: 12px; stroke: currentColor; }

  /* Payment select */
  .pay-select {
    width: 100%; border: 1px solid var(--border2); border-radius: 10px;
    padding: 9px 34px 9px 12px; font-size: 13px; font-weight: 500;
    background: var(--cream); color: var(--ink2);
    font-family: 'Poppins', sans-serif; margin-bottom: 10px;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A7A62' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    transition: border-color .2s;
  }
  .pay-select:focus { outline: 2px solid var(--terra); outline-offset: 1px; border-color: var(--terra); }

  .pay-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
  .pay-section-label {
    font-size: 10.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .1em; color: var(--muted); margin-bottom: 10px;
  }

  /* ── Review ── */
  .stars { color: #C25A2A; font-size: 17px; letter-spacing: 2px; margin-bottom: 8px; }
  .review-text { font-size: 13px; color: var(--muted2); line-height: 1.7; }

  /* ── Items table ── */
  .od-table-wrap {
    background: #fff; border: 1px solid var(--border); border-radius: 16px;
    overflow: hidden; margin-bottom: 16px; box-shadow: var(--shadow);
    animation: fadeUp .5s var(--ease) .3s both;
  }
  .od-tbl-header {
    display: grid; grid-template-columns: 1fr 110px 70px 110px;
    padding: 0 22px; background: var(--cream); border-bottom: 1px solid var(--border);
  }
  .od-tbl-header span {
    padding: 12px 0; font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em; color: var(--muted);
  }
  .od-tbl-row {
    display: grid; grid-template-columns: 1fr 110px 70px 110px;
    padding: 0 22px; border-bottom: 1px solid rgba(194,90,42,0.06);
    transition: background .15s;
  }
  .od-tbl-row:last-child { border-bottom: none; }
  .od-tbl-row:hover { background: var(--cream); }
  .od-tbl-row span { padding: 13px 0; font-size: 13px; color: var(--ink2); }
  .od-tbl-row .col-name { font-weight: 600; color: var(--ink); }
  .od-tbl-row .col-total { font-weight: 700; color: var(--terra-d); font-family: 'Courier New', monospace; }
  .od-tbl-footer{
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding:12px 22px;
      border-top:1px solid var(--border);
      background:#fff;
  }

  .od-tbl-footer .total-label{
      font-size:14px;
      font-weight:600;
      color:#666;
  }

  .od-tbl-footer .total-val{
      font-size:16px;
      font-weight:700;
      color:#222;
  }

  .od-tbl-footer .discount{
      color:#16a34a;
  }

  .od-tbl-footer.grand-total{
      margin-top:8px;
      padding:18px 22px;
      background:var(--cream2);
      border-top:2px solid var(--terra);
  }

  .od-tbl-footer.grand-total .total-label{
      font-size:15px;
      font-weight:700;
      color:#222;
      text-transform:uppercase;
      letter-spacing:.05em;
  }

  .od-tbl-footer.grand-total .total-val{
      font-size:24px;
      font-weight:700;
      color:var(--terra-d);
      font-family:'Playfair Display', serif;
  }

  /* ── FAB ── */
  .od-fab {
    position: fixed; bottom: 28px; right: 28px;
    width: 54px; height: 54px; background: var(--terra); border: none;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; box-shadow: 0 8px 24px rgba(194,90,42,0.4); z-index: 9999;
    transition: all .22s var(--ease);
  }
  .od-fab:hover { background: var(--terra-l); transform: scale(1.08); box-shadow: 0 12px 32px rgba(194,90,42,0.5); }
  .od-fab svg { width: 22px; height: 22px; stroke: #fff; }

  /* ── Message Modal ── */
  .od-modal-bg {
    display: none; position: fixed; inset: 0;
    background: rgba(26,18,8,0.55); backdrop-filter: blur(8px);
    z-index: 99999; align-items: center; justify-content: center; padding: 1rem;
  }
  .od-modal-bg.open { display: flex; }
  .od-modal {
    width: 100%; max-width: 480px; background: #fff;
    border-radius: 20px; padding: 2rem; position: relative;
    animation: scaleIn .28s var(--ease);
    box-shadow: 0 24px 80px rgba(26,18,8,0.22);
    border: 1px solid var(--border2);
  }
  @keyframes scaleIn {
    from { opacity: 0; transform: scale(.94); }
    to   { opacity: 1; transform: scale(1); }
  }
  .od-modal-eyebrow {
    font-size: 10.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .12em; color: var(--terra); margin-bottom: 6px;
    display: flex; align-items: center; gap: 7px;
  }
  .od-modal-eyebrow::before { content: ''; width: 12px; height: 2px; background: var(--terra); border-radius: 2px; }
  .od-modal h3 {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 700; color: var(--ink); margin-bottom: 18px;
  }
  .od-modal textarea {
    width: 100%; border: 1px solid var(--border2); border-radius: 12px;
    padding: 13px 15px; font-size: 13px; font-family: 'Poppins', sans-serif;
    color: var(--ink2); resize: vertical; min-height: 120px;
    background: var(--cream); transition: border-color .2s;
  }
  .od-modal textarea:focus { outline: 2px solid var(--terra); outline-offset: 1px; border-color: var(--terra); }
  .od-modal-close {
    position: absolute; top: 14px; right: 14px;
    background: var(--cream); border: 1px solid var(--border);
    color: var(--muted); border-radius: 8px; width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 16px; line-height: 1;
    transition: all .2s;
  }
  .od-modal-close:hover { background: var(--red-bg); border-color: rgba(194,58,42,0.3); color: var(--red); }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media(max-width:640px) {
    .od-tbl-header { grid-template-columns: 1fr 80px 50px 80px; }
    .od-tbl-row    { grid-template-columns: 1fr 80px 50px 80px; }
    .pg-header h1  { font-size: 24px; }
  }
</style>

<div class="od-wrap">

  {{-- ── Page Header ── --}}
  <div class="pg-header">
    <div>
      <div class="pg-eyebrow">Restaurant Panel</div>
      <h1>Order <span>#{{ $order->id }}</span></h1>
      <p class="pg-sub">Placed {{ $order->created_at->format('d M Y, h:i A') }}</p>
    </div>
    {{-- <a href="/restaurant/orders" class="btn-back">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
      Back to Orders
    </a> --}}
    <div class="btn-row">

        @if(isset($order->invoice))

            <a href="{{ route('restaurant.invoice.show', $order->id) }}"
              class="od-btn btn-pickup">

                <i data-lucide="eye"></i>
                View Invoice

            </a>

        @endif

        <a href="/restaurant/orders"
          class="btn-back">

            Back to Orders

        </a>

    </div>
  </div>

  {{-- @if(session('success'))
  <div class="alert-success">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    {{ session('success') }}
  </div>
  @endif --}}

  {{-- ── Row 1: Customer · Order Info · Delivery ── --}}
  <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-8 mb-8">

    {{-- Customer --}}
    <div class="od-card">
      <div class="card-eyebrow">Customer</div>
      <div class="info-row">
        <div class="info-item">
          <span class="info-label">Name</span>
          <span class="info-val">{{ $order->user->name ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Address</span>
          <span class="info-val" style="max-width:60%;text-align:right">{{ $order->address ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Post code</span>
          <span class="info-val mono">{{ $order->pincode ?? 'N/A' }}</span>
        </div>
      </div>
    </div>

    {{-- Order Info --}}
    <div class="od-card">
      <div class="card-eyebrow">Order Info</div>
      <div class="info-row">
        <div class="info-item">
          <span class="info-label">Order ID</span>
          <span class="info-val mono">#{{ $order->id }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Restaurant</span>
          <span class="info-val">{{ $order->restaurant->name ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Order type</span>
          <span class="info-val">{{ ucfirst($order->order_type ?? 'Delivery') }}</span>
        </div>
        @if($order->order_type == 'delivery' && $order->delivery_provider == 'self')
        <div class="info-item">
            <span class="info-label">Delivery Time</span>
            <span class="info-val">
                @if($order->is_scheduled && $order->scheduled_for)
                    📅 {{ \Carbon\Carbon::parse($order->scheduled_for)->format('d M Y, h:i A') }}
                @else
                    ⚡ As Soon As Possible
                @endif
            </span>
        </div>
        @endif
        <div class="info-item">
          <span class="info-label">Status</span>
          <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Total</span>
          <span class="info-val" style="color:var(--terra-d);font-family:'Playfair Display',serif;font-size:16px">£{{ number_format($order->total_amount, 2) }}</span>
        </div>
      </div>
    </div>

    {{-- Delivery Info --}}
    @if($order->stuart_job_id)
    <div class="od-card">
      <div class="card-eyebrow">Delivery</div>
      <div class="info-row">
        <div class="info-item">
          <span class="info-label">Job ID</span>
          <span class="info-val mono">{{ $order->stuart_job_id }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Driver</span>
          <span class="info-val">{{ $order->driver_name ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Phone</span>
          <span class="info-val mono">{{ $order->driver_phone ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Status</span>
          <span class="info-val">{{ ucfirst($order->delivery_status ?? 'Pending') }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Picked at</span>
          <span class="info-val">{{ $order->picked_at ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Delivered at</span>
          <span class="info-val">{{ $order->delivered_at ?? 'N/A' }}</span>
        </div>
      </div>
      @if($order->tracking_url)
        <a href="{{ $order->tracking_url }}" target="_blank" class="track-link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          Track delivery →
        </a>
      @endif
    </div>
    @endif

    


    <div class="od-card">
      <div class="card-eyebrow">Order Status</div>

      @if($order->status === 'pending')

        <p class="status-hint">New order received. Accept it to start preparing, or cancel if unable to fulfil.</p>
        <div class="btn-row">
          <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="accepted">
            <button type="submit" class="od-btn btn-accept">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Accept Order
            </button>
          </form>
          {{-- <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="od-btn btn-cancel" onclick="return confirm('Cancel this order?')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              Cancel Order
            </button>
          </form> --}}
          
        </div>


      @elseif($order->status === 'accepted')

        <p class="status-hint">Order accepted — being prepared. Mark as picked up once the driver collects it.</p>
        <div class="btn-row">
          <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="od-btn btn-pickup">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              Mark as Picked Up
            </button>
          </form>
          <button
            type="button"
            class="od-btn btn-cancel"
            onclick="openCancelModal()">

            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2.5">

                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>

            </svg>

            Cancel Order

        </button>
        </div>

      {{-- @elseif($order->status === 'accepted')

        <p class="status-hint">Order is on the way to the customer. Confirm once it has been delivered.</p>
        <div class="btn-row">
          <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="od-btn btn-complete">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              Complete Order
            </button>
          </form>
        </div> --}}

      @elseif($order->status === 'completed')

        <div class="terminal-state ts-completed">
          <div class="terminal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <div>
            <p class="terminal-title">Order completed</p>
            <p class="terminal-sub">This order has been fulfilled successfully.</p>
          </div>
        </div>

      @elseif($order->status === 'cancelled')

        <div class="terminal-state ts-cancelled">
          <div class="terminal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <div>
            <p class="terminal-title">Order cancelled</p>
            <p class="terminal-sub">This order has been cancelled and is closed.</p>
          </div>
        </div>

      @endif
    </div>
	  
	  

   

    {{-- Payment --}}
    <div class="od-card">
      <div class="card-eyebrow">Payment</div>
      <div class="info-row" style="margin-bottom:16px">
        <div class="info-item">
          <span class="info-label">Method</span>
          <span class="info-val">{{ $order->payment->payment_type ?? 'N/A' }}({{ $order->payment->payment_method ?? 'N/A' }})</span>
        </div>
        
        <div class="info-item">
          <span class="info-label">Status</span>
          <span class="badge badge-{{ optional($order->payment)->payment_status ?? 'pending' }}">
            {{ ucfirst(optional($order->payment)->payment_status ?? 'Pending') }}
          </span>
        </div>
      </div>

      <hr class="pay-divider">
      <p class="pay-section-label">Update payment status</p>

      <form method="POST" action="{{ route('restaurant.orders.payment.status', $order->id) }}">
        @csrf
        <select name="payment_status" class="pay-select">
          @foreach(['pending','paid','failed','cancelled','refunded','partially_refunded'] as $ps)
            <option value="{{ $ps }}" {{ optional($order->payment)->payment_status == $ps ? 'selected' : '' }}>
              {{ ucfirst($ps) }}
            </option>
          @endforeach
        </select>
        {{-- <button type="submit" class="od-btn btn-pay-update">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Update Payment
        </button> --}}
      </form>

      @if($order->status === 'cancelled' && optional($order->payment)->payment_status === 'paid')
        {{-- <form method="POST" action="{{ route('restaurant.orders.refund', $order->id) }}" style="margin-top:8px">
          @csrf --}}
          <button disabled type="submit" class="od-btn btn-refund" onclick="return confirm('Issue a refund for this payment?')">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
            Refund Payment
          </button>
        {{-- </form> --}}
      @endif
      @if(
          $order->status === 'cancelled' &&
          optional($order->payment)
      )

          @php
              $payment = $order->payment;

              $refunded = $payment->refunded_amount ?? 0;
              $remaining = $payment->amount - $refunded;
          @endphp

          @if($remaining > 0)

              <div style="margin-top:15px;padding:12px;border:1px solid #ddd;border-radius:10px;">

                  <p style="margin-bottom:10px;">
                      <strong>Paid Amount:</strong> £{{ number_format($payment->amount,2) }}<br>

                      <strong>Already Refunded:</strong>
                      £{{ number_format($refunded,2) }}<br>

                      <strong>Available Refund:</strong>
                      £{{ number_format($remaining,2) }}
                  </p>

                  <form method="POST"
                        action="{{ route('restaurant.orders.refund',$order->id) }}">

                      @csrf

                      <input
                          type="number"
                          name="refund_amount"
                          step="0.01"
                          min="0.01"
                          max="{{ $remaining }}"
                          value="{{ $remaining }}"
                          required
                          style="
                              width:180px;
                              padding:8px;
                              border:1px solid #ddd;
                              border-radius:8px;
                          ">

                      <br><br>

                      <button
                          type="submit"
                          class="od-btn btn-refund"
                          onclick="return confirm('Are you sure you want to refund this payment?')">

                          Refund £{{ number_format($remaining,2) }}

                      </button>

                  </form>

              </div>

          @else

              <div style="
                  margin-top:15px;
                  padding:12px;
                  background:#d4edda;
                  color:#155724;
                  border-radius:8px;
                  font-size:10px;
              ">
                  ✅ Payment has been fully refunded.
              </div>

          @endif

      @endif

      @if($order->payment)

      <div style="margin-top:8px;font-size:13px;">

          Paid:
          £{{ number_format($order->total_amount,2) }}

          <br>

          Refunded:
          £{{ number_format($order->payment->refunded_amount ?? 0,2) }}

          <br>

          Remaining:
          £{{ number_format(
              $order->total_amount -
              ($order->payment->refunded_amount ?? 0),
              2
          ) }}

      </div>

      @endif
    </div>

  </div>

<div id="complaintsModal"
     class="od-modal-bg">

    <div class="od-modal"
         style="max-width:800px;">

        <button
            class="od-modal-close"
            onclick="closeComplaintsModal()">

            ×

        </button>

        <div class="od-modal-eyebrow">
            Customer Complaints
        </div>

        <h3>
            Complaint History
        </h3>

        <div style="
            max-height:65vh;
            overflow-y:auto;
        ">

            @foreach($complaints as $complaint)

                <div style="
                    border:1px solid #E5E7EB;
                    border-radius:14px;
                    padding:16px;
                    margin-bottom:20px;
                  ">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        margin-bottom:12px;
                    ">

                        <div>

                            <div style="font-size:18px;font-weight:700;">
                                {{ $complaint->subject }}
                            </div>

                            <div style="
                                display:flex;
                                gap:10px;
                                margin-top:8px;
                                flex-wrap:wrap;
                            ">

                                @if($complaint->category)
                                    <span style="
                                        background:#EFF6FF;
                                        color:#1D4ED8;
                                        padding:5px 12px;
                                        border-radius:999px;
                                        font-size:12px;
                                    ">
                                        {{ $complaint->category }}
                                    </span>
                                @endif

                                <span style="
                                    background:#F3F4F6;
                                    padding:5px 12px;
                                    border-radius:999px;
                                    font-size:12px;
                                    color:#666;
                                ">
                                    {{ $complaint->created_at->format('d M Y h:i A') }}
                                </span>

                            </div>

                        </div>

                    </div>


                    <div style="
                        background:#F9FAFB;
                        border-radius:12px;
                        padding:15px;
                        max-height:350px;
                        overflow-y:auto;
                        margin-bottom:15px;
                    ">

                        @foreach($complaint->messages as $message)

                            @if($message->sender_type=='customer')

                                <div style="
                                    display:flex;
                                    justify-content:flex-start;
                                    margin-bottom:12px;
                                ">

                                    <div style="
                                        max-width:75%;
                                        background:#DBEAFE;
                                        color:#1E3A8A;
                                        padding:4px 12px 4px 12px;
                                        border-radius:14px;
                                        font-size:12px;
                                    ">

                                        {{-- <strong>
                                            Customer
                                        </strong>

                                        <br> --}}

                                        {{ $message->message }}

                                        <div style="
                                            
                                            font-size:8px;
                                            color:#666;
                                        ">
                                            {{ $message->created_at->format('d M h:i A') }}
                                        </div>

                                    </div>

                                </div>

                            @else

                                <div style="
                                    display:flex;
                                    justify-content:flex-end;
                                    margin-bottom:12px;
                                ">

                                    <div style="
                                        max-width:75%;
                                        background:#DCFCE7;
                                        color:#166534;
                                        padding:4px 12px 4px 12px;
                                        border-radius:14px;
                                        font-size:12px;
                                    ">

                                        {{-- <strong>
                                            You
                                        </strong>

                                        <br> --}}

                                        {{ $message->message }}

                                        <div style="
                                          
                                            font-size:8px;
                                            color:#666;
                                        ">
                                            {{ $message->created_at->format('d M h:i A') }}
                                        </div>

                                    </div>

                                </div>

                            @endif

                        @endforeach

                    </div>


                    <form method="POST"
                          action="{{ route('restaurant.complaints.reply',$complaint->id) }}">

                        @csrf

                        <textarea
                            name="message"
                            rows="3"
                            required
                            placeholder="Type your reply..."
                            style="
                                width:100%;
                                border:1px solid #D1D5DB;
                                border-radius:12px;
                                padding:12px;
                                resize:none;
                            "></textarea>

                        <div style="
                            display:flex;
                            justify-content:flex-end;
                            margin-top:12px;
                        ">

                            <button
                                type="submit"
                                class="od-btn btn-pickup">

                                Send Message

                            </button>

                        </div>

                    </form>

                </div>

            @endforeach

        </div>

    </div>

</div>

<!-- Cancel Order Modal -->
<div id="cancelOrderModal" class="cancel-modal">

    <div class="cancel-modal-content">

        <span class="cancel-close" onclick="closeCancelModal()">&times;</span>

        <h3>Cancel Order</h3>

        <p class="cancel-subtitle">
            Please select a reason for cancelling this order.
        </p>

        <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf

            <input type="hidden" name="status" value="cancelled">

            <div class="form-group">

                <label>
                    Cancellation Reason <span class="text-danger">*</span>
                </label>

                <select
                    id="cancelReasonSelect"
                    name="cancel_reason"
                    class="cancel-input"
                    onchange="toggleOtherReason()"
                    required>

                    <option value="">Select Reason</option>

                    <option value="Out of stock">
                        Out of stock
                    </option>

                    <option value="Item unavailable">
                        Item unavailable
                    </option>

                    <option value="Kitchen issue">
                        Kitchen issue
                    </option>

                    <option value="Restaurant is closing">
                        Restaurant is closing
                    </option>

                    <option value="Unable to prepare on time">
                        Unable to prepare on time
                    </option>

                    <option value="Technical issue">
                        Technical issue
                    </option>

                    <option value="High order volume">
                        High order volume
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>

            <div
                id="otherReasonBox"
                style="display:none; margin-top:18px;">

                <label>
                    Enter Reason
                </label>

                <textarea
                    id="otherReason"
                    rows="4"
                    class="cancel-input"
                    placeholder="Please enter cancellation reason..."></textarea>

            </div>

            <div class="cancel-actions">

                <button
                    type="button"
                    class="btn-close-modal"
                    onclick="closeCancelModal()">

                    Close

                </button>

                <button
                    type="submit"
                    class="btn-cancel-order">

                    Cancel Order

                </button>

            </div>

        </form>

    </div>

</div>
  

<style>
  .cancel-modal{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,.55);
      display:none;
      justify-content:center;
      align-items:center;
      z-index:999999;
      padding:20px;
  }

  .cancel-modal.show{
      display:flex;
  }

  .cancel-modal-content{
      width:100%;
      max-width:520px;
      background:#fff;
      border-radius:18px;
      padding:28px;
      position:relative;
      animation:modalPop .25s ease;
      box-shadow:0 20px 50px rgba(0,0,0,.25);
  }

  @keyframes modalPop{
      from{
          opacity:0;
          transform:translateY(15px) scale(.95);
      }
      to{
          opacity:1;
          transform:translateY(0) scale(1);
      }
  }

  .cancel-close{
      position:absolute;
      right:18px;
      top:12px;
      font-size:30px;
      cursor:pointer;
      color:#777;
  }

  .cancel-close:hover{
      color:#dc3545;
  }

  .cancel-modal h3{
      margin:0;
      font-size:24px;
      font-weight:700;
  }

  .cancel-subtitle{
      margin:10px 0 25px;
      color:#777;
      font-size:14px;
  }

  .form-group{
      margin-bottom:15px;
  }

  .form-group label{
      display:block;
      margin-bottom:8px;
      font-weight:600;
  }

  .cancel-input{
      width:100%;
      border:1px solid #ddd;
      border-radius:10px;
      padding:12px 14px;
      font-size:14px;
      transition:.3s;
      box-sizing:border-box;
  }

  .cancel-input:focus{
      border-color:#dc3545;
      outline:none;
      box-shadow:0 0 0 3px rgba(220,53,69,.15);
  }

  .cancel-actions{
      margin-top:25px;
      display:flex;
      justify-content:flex-end;
      gap:10px;
  }

  .btn-close-modal{
      border:none;
      background:#6c757d;
      color:#fff;
      padding:10px 18px;
      border-radius:8px;
      cursor:pointer;
  }

  .btn-close-modal:hover{
      background:#5a6268;
  }

  .btn-cancel-order{
      border:none;
      background:#dc3545;
      color:#fff;
      padding:10px 18px;
      border-radius:8px;
      cursor:pointer;
  }

  .btn-cancel-order:hover{
      background:#bb2d3b;
  }
</style>


<script>

  function openCancelModal(){
      document.getElementById('cancelOrderModal').classList.add('show');
  }

  function closeCancelModal(){
      document.getElementById('cancelOrderModal').classList.remove('show');
  }

  window.onclick = function(event){

      let modal = document.getElementById('cancelOrderModal');

      if(event.target === modal){
          closeCancelModal();
      }

  }

  function toggleOtherReason(){

      let select = document.getElementById('cancelReasonSelect');
      let textarea = document.getElementById('otherReason');
      let box = document.getElementById('otherReasonBox');

      if(select.value === "Other"){

          box.style.display = "block";

          textarea.required = true;

          textarea.setAttribute("name","cancel_reason");

          select.removeAttribute("name");

      }else{

          box.style.display = "none";

          textarea.required = false;
          textarea.value = "";

          textarea.removeAttribute("name");

          select.setAttribute("name","cancel_reason");

      }

  }

</script>
  {{-- ── Row 2: Status Workflow · Payment ── --}}
  {{-- <div class="od-grid-2">

    
    <div class="od-card">
      <div class="card-eyebrow">Order Status</div>

      @if($order->status === 'pending')

        <p class="status-hint">New order received. Accept it to start preparing, or cancel if unable to fulfil.</p>
        <div class="btn-row">
          <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="accepted">
            <button type="submit" class="od-btn btn-accept">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Accept Order
            </button>
          </form>
          <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="od-btn btn-cancel" onclick="return confirm('Cancel this order?')">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              Cancel Order
            </button>
          </form>
        </div>

      @elseif($order->status === 'accepted')

        <p class="status-hint">Order accepted — being prepared. Mark as picked up once the driver collects it.</p>
        <div class="btn-row">
          <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="pickup">
            <button type="submit" class="od-btn btn-pickup">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              Mark as Picked Up
            </button>
          </form>
        </div>

      @elseif($order->status === 'pickup')

        <p class="status-hint">Order is on the way to the customer. Confirm once it has been delivered.</p>
        <div class="btn-row">
          <form method="POST" action="{{ route('restaurant.orders.status', $order->id) }}">
            @csrf
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="od-btn btn-complete">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              Complete Order
            </button>
          </form>
        </div>

      @elseif($order->status === 'completed')

        <div class="terminal-state ts-completed">
          <div class="terminal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <div>
            <p class="terminal-title">Order completed</p>
            <p class="terminal-sub">This order has been fulfilled successfully.</p>
          </div>
        </div>

      @elseif($order->status === 'cancelled')

        <div class="terminal-state ts-cancelled">
          <div class="terminal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <div>
            <p class="terminal-title">Order cancelled</p>
            <p class="terminal-sub">This order has been cancelled and is closed.</p>
          </div>
        </div>

      @endif
    </div>

    
    <div class="od-card">
      <div class="card-eyebrow">Payment</div>
      <div class="info-row" style="margin-bottom:16px">
        <div class="info-item">
          <span class="info-label">Method</span>
          <span class="info-val">{{ $order->payment->payment_method ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Status</span>
          <span class="badge badge-{{ optional($order->payment)->payment_status ?? 'pending' }}">
            {{ ucfirst(optional($order->payment)->payment_status ?? 'Pending') }}
          </span>
        </div>
      </div>

      <hr class="pay-divider">
      <p class="pay-section-label">Update payment status</p>

      <form method="POST" action="{{ route('restaurant.orders.payment.status', $order->id) }}">
        @csrf
        <select name="payment_status" class="pay-select">
          @foreach(['pending','paid','failed','cancelled','refunded'] as $ps)
            <option value="{{ $ps }}" {{ optional($order->payment)->payment_status == $ps ? 'selected' : '' }}>
              {{ ucfirst($ps) }}
            </option>
          @endforeach
        </select>
        <button type="submit" class="od-btn btn-pay-update">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Update Payment
        </button>
      </form>

      @if($order->status === 'cancelled' && optional($order->payment)->payment_status === 'paid')
        <form method="POST" action="{{ route('restaurant.orders.refund', $order->id) }}" style="margin-top:8px">
          @csrf
          <button type="submit" class="od-btn btn-refund" onclick="return confirm('Issue a refund for this payment?')">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
            Refund Payment
          </button>
        </form>
      @endif
    </div>

  </div> --}}

  {{-- ── Review (conditional) ── --}}
  @if($order->review)
  <div class="od-card" style="margin-bottom:16px">
    <div class="card-eyebrow">Customer Review</div>
    <div class="stars">
      @for($i = 1; $i <= 5; $i++){{ $i <= $order->review->rating ? '★' : '☆' }}@endfor
      <span style="font-size:12px;color:var(--muted);font-family:'Poppins',sans-serif;font-weight:600;margin-left:8px">{{ $order->review->rating }}/5</span>
    </div>
    <p class="review-text">{{ $order->review->review }}</p>
  </div>
  @endif

  {{-- ── Order Items ── --}}
  <div class="od-table-wrap">
    <div class="od-tbl-header">
      <span>Product</span>
      <span>Price</span>
      <span>Qty</span>
      <span>Total</span>
    </div>
    @foreach($order->items as $item)
    <div class="od-tbl-row">
      <span class="col-name">

        {{ $item->product->name ?? '—' }}

        @if(!empty($item->variant_name))
            <div style="
                font-size:12px;
                color:#6B7280;
                margin-top:2px;
            ">
                Variant: {{ $item->variant_name }}
            </div>
        @endif

        @if($item->addons->count())

            @php
                $groupedAddons = $item->addons->groupBy('category_name');
            @endphp

            <div style="margin-top:8px;">

                @foreach($groupedAddons as $category => $addons)

                    <div style="
                        font-size:11px;
                        font-weight:700;
                        color:#666;
                        margin:6px 0;
                    ">
                        {{ $category }}
                    </div>

                    <div style="
                        display:flex;
                        flex-wrap:wrap;
                        gap:6px;
                    ">

                        @foreach($addons as $addon)

                            <div style="
                                display:flex;
                                align-items:center;
                                gap:5px;
                                background:#FAFAFA;
                                border:1px solid #E5E7EB;
                                border-radius:999px;
                                padding:1px 5px;
                                font-size:8px;
                            ">

                                <span style="
                                    width:6px;
                                    height:6px;
                                    border-radius:50%;
                                    background:#C25A2A;
                                    display:inline-block;
                                "></span>

                                <span>{{ $addon->addon_name }}</span>

                                <span style="
                                    color:#C25A2A;
                                    font-weight:700;
                                ">
                                    +£{{ number_format($addon->price,2) }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @endforeach

            </div>

        @endif

    </span>
      <span>£{{ number_format($item->price, 2) }}</span>
      <span>{{ $item->quantity }}</span>
      <span class="col-total">£{{ number_format($item->total, 2) }}</span>
    </div>
    @endforeach
    @if($order->delivery_charge > 0)
    <div class="od-tbl-footer">
        <span class="total-label">Delivery Fee</span>
        <span class="total-val">£{{ number_format($order->delivery_charge, 2) }}</span>
    </div>
    @endif

    @if($order->hyst_charge > 0)
    <div class="od-tbl-footer">
        <span class="total-label">Hyst Charge</span>
        <span class="total-val">£{{ number_format($order->hyst_charge, 2) }}</span>
    </div>
    @endif

    @if($order->coupon_discount > 0)
    <div class="od-tbl-footer">
        <span class="total-label">Coupon Discount</span>
        <span class="total-val discount">-£{{ number_format($order->coupon_discount, 2) }}</span>
    </div>
    @endif

    @if($order->gift_card_amount > 0)
    <div class="od-tbl-footer">
        <span class="total-label">Gift Card</span>
        <span class="total-val discount">-£{{ number_format($order->gift_card_amount, 2) }}</span>
    </div>
    @endif

    <div class="od-tbl-footer grand-total">
        <span class="total-label">Order Total</span>
        <span class="total-val">£{{ number_format($order->total_amount, 2) }}</span>
    </div>
    
  </div>

</div>

{{-- ── FAB ── --}}
<button class="od-fab" onclick="document.getElementById('msgModal').classList.add('open')" aria-label="Send message">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
</button>

{{-- ── Message Modal ── --}}
<div id="msgModal" class="od-modal-bg" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="od-modal">
    <button class="od-modal-close" onclick="document.getElementById('msgModal').classList.remove('open')" aria-label="Close">×</button>
    <div class="od-modal-eyebrow">Messaging</div>
    <h3>Send Message</h3>
    <form method="POST" action="{{ route('restaurant.orders.message', $order->id) }}">
      @csrf
      <textarea name="message" rows="5" required placeholder="Write your message to the customer…"></textarea>
      <button type="submit" class="od-btn btn-pickup" style="margin-top:12px;width:100%;justify-content:center">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        Send Message
      </button>
    </form>
  </div>
</div>


<script>
function openComplaintsModal()
{
    document
        .getElementById('complaintsModal')
        .classList.add('open');
}

function closeComplaintsModal()
{
    document
        .getElementById('complaintsModal')
        .classList.remove('open');
}
</script>

@endsection