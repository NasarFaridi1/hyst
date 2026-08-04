@extends('layouts.app')
@section('content')

{{-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

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



    /* Scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--cream2); }
    ::-webkit-scrollbar-thumb { background: var(--terra); border-radius: 4px; }

    /* ── Layout ── */
    .db-shell { display: flex; min-height: 100vh; background: var(--cream); }





    /* ── Top bar ── */

    .qr-btn {
      display: flex; align-items: center; gap: 7px;
      background: var(--terra); color: #fff; border: none; border-radius: 9px;
      padding: 9px 18px; font-family: 'Poppins', sans-serif;
      font-size: 13px; font-weight: 600; cursor: pointer;
      transition: all .22s var(--ease);
      box-shadow: 0 3px 12px rgba(194,90,42,0.3);
    }
    .qr-btn:hover { background: var(--terra-l); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(194,90,42,0.4); }

    /* ── Page body ── */
    .page-body { padding: 28px; }

    /* ── Page header ── */
    .pg-header { margin-bottom: 28px; }
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

    /* ── Alert ── */
    .alert-success {
      background: #DCFCE7; border: 1px solid #86EFAC; color: #15803D;
      border-radius: 12px; padding: 14px 18px; margin-bottom: 22px;
      font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;
    }

    /* ── Stat cards ── */
    .stat-grid {
      display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px;
    }
    @media(max-width:1100px) { .stat-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:580px)  { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
      background: #fff; border: 1px solid var(--border);
      border-radius: 16px; padding: 22px;
      position: relative; overflow: hidden;
      transition: all .25s var(--ease);
      animation: fadeUp .5s var(--ease) both;
      box-shadow: var(--shadow);
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow2); border-color: var(--border2); }
    .stat-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      border-radius: 16px 16px 0 0;
    }
    .stat-card.c-terra::before { background: var(--terra); }
    .stat-card.c-green::before { background: var(--green); }
    .stat-card.c-blue::before  { background: var(--blue); }
    .stat-card.c-red::before   { background: var(--red); }

    .stat-card:nth-child(1){animation-delay:.05s}
    .stat-card:nth-child(2){animation-delay:.1s}
    .stat-card:nth-child(3){animation-delay:.15s}
    .stat-card:nth-child(4){animation-delay:.2s}

    .stat-icon {
      width: 42px; height: 42px; border-radius: 11px;
      display: flex; align-items: center; justify-content: center;
      font-size: 19px; margin-bottom: 14px;
    }
    .c-terra .stat-icon { background: var(--terra-bg); }
    .c-green .stat-icon { background: var(--green-bg); }
    .c-blue  .stat-icon { background: var(--blue-bg); }
    .c-red   .stat-icon { background: var(--red-bg); }

    .stat-label { font-size: 11.5px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; }
    .stat-value {
      font-family: 'Playfair Display', serif; font-size: 34px; font-weight: 700;
      color: var(--ink); margin: 4px 0 4px; line-height: 1;
    }
    .c-terra .stat-value { color: var(--terra-d); }
    .c-green .stat-value { color: var(--green); }
    .c-blue  .stat-value { color: var(--blue); }
    .c-red   .stat-value { color: var(--red); }
    .stat-meta { font-size: 12px; color: var(--muted); }

    /* ── Status row ── */
    .status-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media(max-width:580px) { .status-row { grid-template-columns: 1fr; } }

    .status-card {
      border-radius: 16px; padding: 22px 24px;
      display: flex; align-items: center; gap: 18px;
      animation: fadeUp .5s var(--ease) .25s both;
      box-shadow: var(--shadow);
    }
    .status-card.pending  { background: #fff; border: 1.5px solid rgba(194,90,42,0.2); }
    .status-card.complete { background: #fff; border: 1.5px solid rgba(61,140,90,0.2); }

    .status-circle {
      width: 56px; height: 56px; border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 24px; flex-shrink: 0;
    }
    .pending  .status-circle { background: var(--terra-bg); }
    .complete .status-circle { background: var(--green-bg); }

    .status-label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); }
    .status-num {
      font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 700; line-height: 1.05;
    }
    .pending  .status-num { color: var(--terra); }
    .complete .status-num { color: var(--green); }

    /* ── Charts grid ── */
    .chart-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 20px; margin-bottom: 20px; }
    @media(max-width:900px) { .chart-grid { grid-template-columns: 1fr; } }

    .panel {
      background: #fff; border: 1px solid var(--border); border-radius: 16px;
      padding: 22px; box-shadow: var(--shadow);
      animation: fadeUp .5s var(--ease) .3s both;
    }
    .panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .panel-title { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; color: var(--ink); }
    .panel-badge {
      font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px;
      background: var(--terra-bg); color: var(--terra);
      border: 1px solid rgba(194,90,42,0.2); text-transform: uppercase; letter-spacing: 0.07em;
    }

    .chart-wrap{
        height:220px;
        position:relative;
    }

    /* Donut */
    .donut-wrap{
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:18px;
    }

    .donut-canvas-box{
        position:relative;
        width:170px;
        height:170px;
    }

    .donut-center{
        position:absolute;
        inset:0;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
    }

    .dc-num{
        font-family:'Playfair Display',serif;
        font-size:30px;
        font-weight:700;
        color:var(--ink);
    }

    .dc-lbl{
        font-size:11px;
        color:var(--muted);
        font-weight:600;
        text-transform:uppercase;
    }

    .donut-legend{
        width:100%;
        display:flex;
        flex-direction:column;
        gap:10px;
    }

    .legend-row{
        display:flex;
        align-items:center;
        justify-content:space-between;
    }

    .legend-left{
        display:flex;
        align-items:center;
        gap:8px;
        font-size:13px;
        color:var(--muted2);
        font-weight:500;
    }

    .legend-dot{
        width:8px;
        height:8px;
        border-radius:50%;
    }

    .legend-right{
        font-size:13px;
        font-weight:700;
        color:var(--ink);
    }

    /* Mobile */
    @media (max-width:768px){

        .chart-grid{
            grid-template-columns:1fr;
            gap:16px;
        }

        .chart-wrap{
            height:250px;
        }

        .donut-wrap{
            gap:14px;
        }

        .donut-canvas-box{
            width:140px;
            height:140px;
        }

        .dc-num{
            font-size:24px;
        }

        .dc-lbl{
            font-size:10px;
        }

        .legend-row{
            padding:0 10px;
        }

        .legend-left,
        .legend-right{
            font-size:12px;
        }
    }

    /* Small Phones */
    @media (max-width:480px){

        .panel{
            padding:14px;
        }

        .panel-header{
            flex-direction:column;
            align-items:flex-start;
            gap:6px;
        }

        .panel-title{
            font-size:14px;
        }

        .panel-badge{
            font-size:10px;
        }

        .chart-wrap{
            height:220px;
        }

        .donut-canvas-box{
            width:100px;
            height:120px;
        }

        .dc-num{
            font-size:20px;
        }

        .legend-left,
        .legend-right{
            font-size:11px;
        }
    }

    /* ── Bottom grid ── */
    .bottom-grid { display: grid; grid-template-columns: 1fr 1.8fr; gap: 20px; margin-bottom: 20px; }
    @media(max-width:900px) { .bottom-grid { grid-template-columns: 1fr; } }

    /* Quick actions */
    .action-list { display: flex; flex-direction: column; gap: 8px; }
    .action-link {
      display: flex; align-items: center; gap: 12px;
      background: var(--cream); border: 1px solid var(--border);
      border-radius: 11px; padding: 13px 16px;
      text-decoration: none; color: var(--ink2);
      font-size: 13.5px; font-weight: 500;
      transition: all .2s var(--ease);
    }
    .action-link:hover {
      background: var(--terra-bg2); border-color: var(--border2);
      color: var(--terra-d); transform: translateX(4px);
    }
    .action-link .al-icon {
      width: 32px; height: 32px; border-radius: 8px;
      background: #fff; border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: 15px; flex-shrink: 0; transition: all .2s;
    }
    .action-link:hover .al-icon { background: var(--terra); border-color: var(--terra); }
    .al-arrow { margin-left: auto; color: var(--muted); font-size: 16px; transition: transform .2s; }
    .action-link:hover .al-arrow { transform: translateX(3px); color: var(--terra); }

    /* Recent orders table */
    .tbl { width: 100%; border-collapse: collapse; }
    .tbl th {
      font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;
      color: var(--muted); padding: 0 0 12px; text-align: left;
      border-bottom: 1px solid var(--border);
    }
    .tbl td {
      padding: 12px 0; border-bottom: 1px solid rgba(194,90,42,0.06);
      font-size: 13px; color: var(--muted2); vertical-align: middle;
    }
    .tbl tr:last-child td { border-bottom: none; }
    .tbl td:first-child { font-weight: 700; color: var(--ink); }

    @media(max-width:768px){

        .tbl,
        .tbl tbody,
        .tbl tr,
        .tbl td{
            display:block;
            width:100%;
        }

        .tbl thead{
            display:none;
        }

        .tbl tr{
            background:#fff;
            border:1px solid #eee;
            border-radius:14px;
            margin-bottom:12px;
            padding:12px;
        }

        .tbl td{
            border:none;
            padding:6px 0;
            display:flex;
            justify-content:space-between;
            gap:15px;
        }

        .tbl td::before{
            font-weight:700;
            color:#666;
        }

        .tbl td:nth-child(1)::before{ content:"Payment #"; }
        .tbl td:nth-child(2)::before{ content:"Order"; }
        .tbl td:nth-child(3)::before{ content:"Amount"; }
        .tbl td:nth-child(4)::before{ content:"Method"; }
        .tbl td:nth-child(5)::before{ content:"Status"; }
        .tbl td:nth-child(6)::before{ content:"Date"; }
    }
    .order-status {
      display: inline-block; padding: 3px 10px; border-radius: 20px;
      font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
    }
    .os-pending   { background: var(--terra-bg);  color: var(--terra);  border: 1px solid rgba(194,90,42,0.2); }
    .os-completed { background: var(--green-bg);  color: var(--green);  border: 1px solid rgba(61,140,90,0.2); }
    .os-cancelled { background: var(--red-bg);    color: var(--red);    border: 1px solid rgba(194,58,42,0.2); }

    .pay-amount { font-weight: 700; color: var(--green); }
    .pay-status { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .ps-paid   { background: var(--green-bg); color: var(--green); border: 1px solid rgba(61,140,90,0.2); }
    .ps-unpaid { background: var(--red-bg);   color: var(--red);   border: 1px solid rgba(194,58,42,0.2); }

    .empty-cell { text-align: center; padding: 28px !important; color: var(--muted); font-size: 13px; }

    /* ── QR Modal ── */
    .qr-modal-bg {
      position: fixed; inset: 0; background: rgba(26,18,8,0.6);
      backdrop-filter: blur(8px); display: none;
      align-items: center; justify-content: center; z-index: 2000; padding: 20px;
    }
    .qr-modal-bg.open { display: flex; }
    .qr-modal {
      background: #fff; border: 1px solid var(--border2); border-radius: 20px;
      padding: 36px; max-width: 400px; width: 100%; position: relative;
      animation: scaleIn .3s var(--ease);
      box-shadow: 0 24px 80px rgba(26,18,8,0.2);
    }
    .qr-close {
      position: absolute; top: 14px; right: 14px;
      background: var(--cream); border: 1px solid var(--border);
      color: var(--muted); border-radius: 8px; width: 30px; height: 30px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: 14px; transition: all .2s;
    }
    .qr-close:hover { background: var(--red-bg); border-color: rgba(194,58,42,0.3); color: var(--red); }
    .qr-modal h2 {
      font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700;
      text-align: center; color: var(--ink); margin-bottom: 4px;
    }
    .qr-modal-sub { text-align: center; font-size: 13px; color: var(--muted); margin-bottom: 24px; }
    .qr-svg-box {
      background: var(--cream); border-radius: 14px; padding: 20px;
      display: flex; justify-content: center; margin-bottom: 18px;
      border: 1px solid var(--border);
    }
    .qr-svg-box svg { width: 200px; height: 200px; }
    .qr-url-row {
      display: flex; gap: 8px; align-items: center;
      background: var(--cream); border: 1px solid var(--border);
      border-radius: 10px; padding: 10px 14px; margin-bottom: 14px;
    }
    .qr-url-row input {
      background: transparent; border: none; outline: none;
      font-family: 'Poppins', sans-serif; font-size: 12px; color: var(--muted2); flex: 1; min-width: 0;
    }
    .copy-btn {
      background: var(--terra-bg); border: 1px solid rgba(194,90,42,0.2);
      color: var(--terra); border-radius: 6px; padding: 4px 10px;
      font-size: 11px; font-weight: 700; cursor: pointer; white-space: nowrap; transition: all .2s;
    }
    .copy-btn:hover { background: var(--terra); color: #fff; }
    .dl-btn {
      width: 100%; background: var(--terra); color: #fff; border: none;
      border-radius: 10px; padding: 13px; font-family: 'Poppins', sans-serif;
      font-size: 14px; font-weight: 600; cursor: pointer; transition: all .22s;
      box-shadow: 0 4px 16px rgba(194,90,42,0.3);
    }
    .dl-btn:hover { background: var(--terra-l); transform: translateY(-1px); }



    /* ── Animations ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
      from { opacity: 0; transform: scale(0.94); }
      to   { opacity: 1; transform: scale(1); }
    }


</style>





<div class="db-shell">

 

  {{-- ── MAIN ── --}}
  <div class="w-full">


    <div class="page-body">

      {{-- Page header --}}
      <div class="pg-header">
        <div class="pg-eyebrow">Overview</div>
        <h1>{{ $restaurant->name ?? 'Restaurant' }} <span>Dashboard</span></h1>
        <p class="pg-sub" id="pgDate">Loading…</p>

        <div class="flex justify-end">
            <button class="qr-btn" onclick="openQrModal()">
            &#9638; Restaurant QR
            </button>
      </div>
      </div>

      <div class="bg-white rounded-2xl shadow border border-gray-200 p-5 mb-6">

          <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

              <div>
                  <h2 class="text-lg md:text-2xl  font-bold text-gray-800">
                      {{ $restaurant->name ?? 'Restaurant' }} availability & operating hours
                  </h2>

                  
              </div>

              <form action="{{ route('restaurant.status.update') }}" method="POST">
                  @csrf

                  <select
                      name="restaurant_status"
                      onchange="this.form.submit()"
                      class="rounded-xl border px-5 py-3 font-semibold">

                      <option value="Open" {{ $restaurant->restaurant_status == 'Open' ? 'selected' : '' }}>
                        🟢 Open
                      </option>

                      <option value="Closed" {{ $restaurant->restaurant_status == 'Closed' ? 'selected' : '' }}>
                        🔴 Closed
                      </option>

                  </select>

              </form>

          </div>

          <div class="border-t mt-5 mb-4 pt-5">

              <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                  <div class="flex items-center gap-4">

                      <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-xl">
                          📅
                      </div>

                      <div>

                          <p class="text-xs uppercase text-gray-500 font-medium">
                              Working Days
                          </p>

                          <p class="font-semibold text-gray-800 leading-6">
                              {{ str_replace(',', ', ', $restaurant->working_days) }}
                          </p>

                      </div>

                  </div>

                  <div class="flex items-center gap-4">

                      <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-xl">
                          🕘
                      </div>

                      <div>

                          <p class="text-xs uppercase text-gray-500 font-medium">
                              Opens At
                          </p>

                          <p class="font-bold text-green-600 text-lg">

                              {{ $restaurant->opening_time
                                  ? \Carbon\Carbon::parse($restaurant->opening_time)->format('h:i A')
                                  : '--' }}

                          </p>

                      </div>

                  </div>

                  <div class="flex items-center gap-4">

                      <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-xl">
                          🌙
                      </div>

                      <div>

                          <p class="text-xs uppercase text-gray-500 font-medium">
                              Closes At
                          </p>

                          <p class="font-bold text-red-600 text-lg">

                              {{ $restaurant->closing_time
                                  ? \Carbon\Carbon::parse($restaurant->closing_time)->format('h:i A')
                                  : '--' }}

                          </p>

                      </div>

                  </div>

              </div>

          </div>

          <div class="bg-white rounded-2xl shadow border border-gray-200 p-5 mb-6">

              <div class="flex items-center justify-between">

                  <div>
                      <h3 class="text-lg font-semibold text-gray-800">
                          Self Delivery
                      </h3>

                      <p class="text-sm text-gray-500">
                          Enable if you deliver orders using your own drivers.
                      </p>
                  </div>

                  <label class="relative inline-flex items-center cursor-pointer">

                      <input
                          type="checkbox"
                          id="selfDeliveryToggle"
                          class="sr-only peer"
                          {{ $restaurant->self_delivery ? 'checked' : '' }}
                      >

                      <div class="w-14 h-8 bg-gray-300 rounded-full peer peer-checked:bg-green-600
                          after:content-[''] after:absolute after:top-1 after:left-1
                          after:w-6 after:h-6 after:bg-white after:rounded-full
                          after:transition-all peer-checked:after:translate-x-6">
                      </div>

                  </label>

              </div>

              @if($restaurant->self_delivery)
                  <div class="mt-5 pt-5 border-t border-gray-200">
                      @if($restaurant->deliveryCharges()->exists())
                          <div class="flex justify-end">
                              <a href="{{ route('restaurant.delivery-charges.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-[#C25A2A] text-white rounded-lg hover:bg-blue-700 transition">
                                  <i data-lucide="truck" class="w-4 h-4 mr-2"></i>
                                  Manage Delivery Charges
                              </a>
                          </div>
                      @else
                          <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4">
                              <p class="text-sm text-yellow-800">
                                  <strong>Delivery charges are not configured.</strong>
                                  Home Delivery will not be shown to customers until you add at least one delivery charge range.
                                  If you don't provide your own delivery service, you can simply turn off <strong>Self Delivery</strong>, and then Home Delivery will be handled by the platform's delivery service.
                              </p>

                              <div class="mt-3">
                                  <a href="{{ route('restaurant.delivery-charges.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-[#C25A2A] text-white rounded-lg hover:bg-blue-700 transition">
                                      <i data-lucide="truck" class="w-4 h-4 mr-2"></i>
                                      Add Delivery Charges
                                  </a>
                              </div>
                          </div>
                      @endif
                  </div>
              @endif

          </div>
          
          
      </div>
      

      {{-- Stat Cards --}}
      <div class="stat-grid">
        <div class="stat-card c-terra">
          <div class="stat-icon">🍽️</div>
          <div class="stat-label">Total Products</div>
          <div class="stat-value">{{ $products }}</div>
          <div class="stat-meta">Active menu items</div>
        </div>
        <div class="stat-card c-blue">
          <div class="stat-icon">📋</div>
          <div class="stat-label">Total Orders</div>
          <div class="stat-value">{{ $orders }}</div>
          <div class="stat-meta">All time</div>
        </div>
        <div class="stat-card c-red">
          <div class="stat-icon">🏷️</div>
          <div class="stat-label">Categories</div>
          <div class="stat-value">{{ $categories }}</div>
          <div class="stat-meta">Menu sections</div>
        </div>
        <div class="stat-card c-green">
          <div class="stat-icon">💷</div>
          <div class="stat-label">Total Earnings</div>
          <div class="stat-value">£{{ number_format($earnings, 2) }}</div>
          <div class="stat-meta">Confirmed payments</div>
        </div>
      </div>

      {{-- Status row --}}
      <div class="status-row">
        <div class="status-card pending">
          <div class="status-circle">⏳</div>
          <div>
            <div class="status-label">Pending Orders</div>
            <div class="status-num">{{ $pendingOrders }}</div>
          </div>
        </div>
        <div class="status-card complete">
          <div class="status-circle">✅</div>
          <div>
            <div class="status-label">Completed Orders</div>
            <div class="status-num">{{ $completedOrders }}</div>
          </div>
        </div>
      </div>

      {{-- Charts --}}
      <div class="chart-grid">
        <div class="panel">
          <div class="panel-header">
            <span class="panel-title">Orders & Earnings</span>
            <span class="panel-badge">Last 7 days</span>
          </div>
          <div class="chart-wrap"><canvas id="barChart"></canvas></div>
        </div>
        <div class="panel">
          <div class="panel-header">
            <span class="panel-title">Order Breakdown</span>
          </div>
          <div class="donut-wrap">
            <div class="donut-canvas-box">
              <canvas id="donutChart"></canvas>
              <div class="donut-center">
                <span class="dc-num">{{ $orders }}</span>
                <span class="dc-lbl">Total</span>
              </div>
            </div>
            <div class="donut-legend">
              <div class="legend-row">
                <div class="legend-left"><span class="legend-dot" style="background:#C25A2A"></span> Pending</div>
                <div class="legend-right">{{ $pendingOrders }}</div>
              </div>
              <div class="legend-row">
                <div class="legend-left"><span class="legend-dot" style="background:#3D8C5A"></span> Completed</div>
                <div class="legend-right">{{ $completedOrders }}</div>
              </div>
              <div class="legend-row">
                <div class="legend-left"><span class="legend-dot" style="background:#C23A2A"></span> Other</div>
                <div class="legend-right">{{ max(0, $orders - $pendingOrders - $completedOrders) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Bottom: Quick Actions + Recent Orders --}}
      <div class="bottom-grid">
        <div class="panel">
          <div class="panel-header"><span class="panel-title">Quick Actions</span></div>
          <div class="action-list">
            <a href="/restaurant/orders" class="action-link">
                <span class="al-icon">🧾</span> Orders
                <span class="al-arrow">›</span>
            </a>
            <a href="/restaurant/payments" class="action-link">
                <span class="al-icon">💷</span> Payment
                <span class="al-arrow">›</span>
            </a>
            <a href="/restaurant/complaint" class="action-link">
                <span class="al-icon">💬</span> Payment Complain
                <span class="al-arrow">›</span>
            </a>
            <a href="/restaurant/reviews" class="action-link">
                <span class="al-icon">⭐</span> Review
                <span class="al-arrow">›</span>
            </a>
            <a href="/restaurant/banners" class="action-link">
                <span class="al-icon">📣</span> Banner
                <span class="al-arrow">›</span>
            </a>
            <a href="/restaurant/coupons" class="action-link">
                <span class="al-icon">🎟️</span> Coupon
                <span class="al-arrow">›</span>
            </a>
          </div>
        </div>

        <div class="panel">
          <div class="panel-header">
            <span class="panel-title">Recent Orders</span>
            <span class="panel-badge">Latest 5</span>
          </div>
          <table class="tbl">
            <thead>
              <tr>
                <th>Order</th>
                <th>Table</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentOrders as $order)
              <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->table_number ?? '—' }}</td>
                <td>£{{ number_format($order->total_amount ?? 0, 2) }}</td>
                <td>
                  @php $s = strtolower($order->status ?? 'pending'); @endphp
                  <span class="order-status
                    @if($s==='completed') os-completed
                    @elseif($s==='cancelled') os-cancelled
                    @else os-pending @endif">{{ ucfirst($s) }}</span>
                </td>
                <td>{{ optional($order->created_at)->format('d M, H:i') ?? '—' }}</td>
              </tr>
              @empty
              <tr><td colspan="5" class="empty-cell">No orders yet</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Recent Payments --}}
     <div class="chart-grid">
         

          <div class="panel">
            <div class="panel-header">
              <span class="panel-title">Recent Payments</span>
              <span class="panel-badge">Latest 5</span>
            </div>
           <table class="tbl">
            <thead>
              <tr>
                <th>Payment #</th>
                <th>Order</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentPayments as $pay)
                <tr>
                  <td>#{{ $pay->id }}</td>
                  <td>#{{ $pay->order_id ?? '—' }}</td>
                  <td class="pay-amount">£{{ number_format($pay->amount ?? 0, 2) }}</td>
                  <td>{{ ucfirst($pay->payment_method ?? 'card') }}</td>
                  <td>
                    <span class="pay-status {{ ($pay->payment_status ?? '') === 'paid' ? 'ps-paid' : 'ps-unpaid' }}">
                      {{ ucfirst($pay->payment_status ?? 'unpaid') }}
                    </span>
                  </td>
                  <td>{{ optional($pay->created_at)->format('d M, H:i') ?? '—' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="empty-cell">No payments yet</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          </div>
           <div class="panel">
            <div class="panel-header"><span class="panel-title">Quick Actions</span></div>
            <div class="action-list">
              
              <a href="/restaurant/customers" class="action-link">
                <span class="al-icon">👥</span> Customer Management
                <span class="al-arrow">›</span>
              </a>
              <a href="{{ route('restaurant.marketing.index') }}" class="action-link">
                <span class="al-icon">✉️</span> Marketing Automation
                <span class="al-arrow">›</span>
              </a>
              <a href="{{ route('restaurant.ordering.index') }}" class="action-link">
                <span class="al-icon">🌐</span> Online Ordering
                <span class="al-arrow">›</span>
              </a>
               <a href="{{ route('restaurant.loyalty.index') }}" class="action-link">
                <span class="al-icon">🎁</span>  Loyalty & Rewards
                <span class="al-arrow">›</span>
              </a>
              
            </div>
          </div>
        </div>

    </div>{{-- /page-body --}}
  </div>{{-- /main-content --}}
</div>{{-- /db-shell --}}

{{-- QR Modal --}}
<div class="qr-modal-bg" id="qrModal">
  <div class="qr-modal">
    <button class="qr-close" onclick="closeQrModal()">✕</button>
    <h2>Restaurant QR</h2>
    <p class="qr-modal-sub">Scan to view your menu online</p>
    <div class="qr-svg-box" id="qrCodeWrapper">{!! $restaurantQr !!}</div>
    <div class="qr-url-row">
      <input type="text" value="{{ $restaurantUrl }}" readonly id="qrUrlInput">
      <button class="copy-btn" onclick="copyUrl()">Copy</button>
    </div>
    <button class="dl-btn" onclick="downloadQR()">⬇ Download QR Code</button>
  </div>
</div>

<script>
// Live date
(function(){
  const el = document.getElementById('pgDate');
  const tb = document.getElementById('liveDate');
  const d  = new Date();
  const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
  const str  = d.toLocaleDateString('en-GB', opts) + ' · Live overview';
  if(el) el.textContent = str;
  if(tb){ tb.textContent = d.toLocaleDateString('en-GB',{weekday:'short',day:'numeric',month:'short'}); tb.style.display=''; }
})();

// Sidebar
function toggleSidebar() {
  const sb  = document.getElementById('sidebar');
  const ov  = document.getElementById('sidebar-overlay');
  const mc  = document.getElementById('main-content');
  const isW = window.innerWidth > 1024;
  if(isW) {
    sb.classList.toggle('collapsed');
    mc.classList.toggle('expanded');
  } else {
    sb.classList.toggle('open');
    ov.classList.toggle('active');
  }
}

// QR
function openQrModal()  { document.getElementById('qrModal').classList.add('open'); }
function closeQrModal() { document.getElementById('qrModal').classList.remove('open'); }
document.getElementById('qrModal').addEventListener('click', e => { if(e.target === document.getElementById('qrModal')) closeQrModal(); });

function copyUrl() {
  const i = document.getElementById('qrUrlInput');
  i.select(); document.execCommand('copy');
  const b = i.nextElementSibling;
  b.textContent = 'Copied!';
  setTimeout(() => b.textContent = 'Copy', 2000);
}

function downloadQR() {
  const svg     = document.querySelector('#qrCodeWrapper svg');
  const svgData = new XMLSerializer().serializeToString(svg);
  const canvas  = document.createElement('canvas');
  canvas.width  = 400; canvas.height = 400;
  const ctx = canvas.getContext('2d');
  const img = new Image();
  img.onload = () => {
    ctx.fillStyle = '#F6F1E8';
    ctx.fillRect(0,0,400,400);
    ctx.drawImage(img,0,0,400,400);
    const a = document.createElement('a');
    a.download = 'hyst-restaurant-qr.png';
    a.href = canvas.toDataURL('image/png');
    a.click();
  };
  img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
}

// Charts
const days = [];
for(let i=6;i>=0;i--){
  const d=new Date(); d.setDate(d.getDate()-i);
  days.push(d.toLocaleDateString('en-GB',{weekday:'short',day:'numeric'}));
}

Chart.defaults.font.family = "'Poppins', sans-serif";

// Bar chart
new Chart(document.getElementById('barChart').getContext('2d'), {
  type: 'bar',
  data: {
    labels: days,
    datasets: [
      {
        label: 'Orders',
        data: [0,0,0,0,0,0, {{ $orders }}],
        backgroundColor: 'rgba(194,90,42,0.15)',
        borderColor: '#C25A2A',
        borderWidth: 2,
        borderRadius: 6,
        borderSkipped: false,
        yAxisID: 'y',
      },
      {
        label: 'Earnings (£)',
        data: [0,0,0,0,0,0, {{ $earnings }}],
        backgroundColor: 'rgba(61,140,90,0.12)',
        borderColor: '#3D8C5A',
        borderWidth: 2,
        borderRadius: 6,
        borderSkipped: false,
        yAxisID: 'y1',
      }
    ]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: {
      legend: { labels: { color: '#8A7A62', font: { size: 12 }, boxWidth: 10, boxHeight: 10 } }
    },
    scales: {
      x: {
        grid: { color: 'rgba(194,90,42,0.06)' },
        ticks: { color: '#8A7A62', font: { size: 11 } },
        border: { color: 'rgba(194,90,42,0.1)' }
      },
      y: {
        grid: { color: 'rgba(194,90,42,0.06)' },
        ticks: { color: '#8A7A62', font: { size: 11 } },
        border: { color: 'rgba(194,90,42,0.1)' },
        beginAtZero: true, position: 'left',
      },
      y1: {
        grid: { drawOnChartArea: false },
        ticks: { color: '#3D8C5A', font: { size: 11 }, callback: v => '£'+v },
        border: { color: 'rgba(61,140,90,0.2)' },
        beginAtZero: true, position: 'right',
      }
    }
  }
});

// Donut
const pending   = {{ $pendingOrders }};
const completed = {{ $completedOrders }};
const other     = Math.max(0, {{ $orders }} - pending - completed);
const total     = pending + completed + other;

new Chart(document.getElementById('donutChart').getContext('2d'), {
  type: 'doughnut',
  data: {
    labels: ['Pending','Completed','Other'],
    datasets: [{
      data: total > 0 ? [pending, completed, other] : [1,0,0],
      backgroundColor: ['rgba(194,90,42,0.75)','rgba(61,140,90,0.75)','rgba(194,58,42,0.6)'],
      borderColor:     ['#C25A2A','#3D8C5A','#C23A2A'],
      borderWidth: 2, hoverOffset: 6,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false, cutout: '74%',
    plugins: {
      legend: { display: false },
      tooltip: { callbacks: { label: c => ` ${c.label}: ${c.parsed} (${total>0?Math.round(c.parsed/total*100):0}%)` } }
    }
  }
});

</script>



<script>
  document.addEventListener("DOMContentLoaded", function () {

      const toggle = document.getElementById("selfDeliveryToggle");

      if (!toggle) return;

      toggle.addEventListener("change", function () {

          const enabled = this.checked;
          this.disabled = true;

          fetch("{{ route('restaurant.self-delivery') }}", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
                  "Accept": "application/json",
                  "X-CSRF-TOKEN": document
                      .querySelector('meta[name="csrf-token"]')
                      .getAttribute("content")
              },
              body: JSON.stringify({
                  self_delivery: enabled ? 1 : 0,
                  restaurant_id: "{{ $restaurant->id }}"
              })
          })
          .then(async response => {
              const data = await response.json();

              if (!response.ok) {
                  throw data;
              }

              alert(data.message);
          })
          .catch(error => {

              // Restore previous state if API fails
              toggle.checked = !enabled;

              alert(error.message || "Unable to update self delivery.");

              console.error(error);

          })
          .finally(() => {
              toggle.disabled = false;
          });

      });

  });
</script>

@endsection