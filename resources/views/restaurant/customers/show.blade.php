@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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

  .cd-wrap { margin: 0 auto; padding: 2rem 1.5rem 4rem; }

  .pg-header { margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; }
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

  .btn-back {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--ink); color: #fff; border: none; border-radius: 10px;
    padding: 10px 20px; font-family: 'Poppins', sans-serif;
    font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none;
    transition: all .22s var(--ease); white-space: nowrap; flex-shrink: 0;
    box-shadow: 0 3px 12px rgba(26,18,8,0.2);
  }
  .btn-back:hover { background: var(--terra); color: #fff; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(194,90,42,0.35); }

  /* ── Stat cards ── */
  .cd-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px; }
  @media(max-width:640px) { .cd-stats { grid-template-columns: 1fr; } }

  .stat-card {
    background: #fff; border: 1px solid var(--border); border-radius: 16px;
    padding: 22px; box-shadow: var(--shadow);
    animation: fadeUp .5s var(--ease) both;
    transition: box-shadow .25s var(--ease), transform .25s var(--ease);
  }
  .stat-card:hover { box-shadow: var(--shadow2); transform: translateY(-2px); border-color: var(--border2); }
  .stat-card:nth-child(2) { animation-delay: .06s; }

  .card-eyebrow {
    font-size: 10.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.12em; color: var(--terra); margin-bottom: 10px;
    display: flex; align-items: center; gap: 7px;
  }
  .card-eyebrow::before { content: ''; width: 12px; height: 2px; background: var(--terra); border-radius: 2px; }

  .stat-val {
    font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 700; color: var(--terra-d);
  }

  /* ── Cards ── */
  .cd-card {
    background: #fff; border: 1px solid var(--border); border-radius: 16px;
    box-shadow: var(--shadow); overflow: hidden; margin-bottom: 24px;
    animation: fadeUp .5s var(--ease) both;
  }
  .cd-card-header {
    padding: 18px 24px; background: var(--cream); border-bottom: 1px solid var(--border);
  }
  .cd-card-header h5 {
    font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; color: var(--ink); margin: 0;
  }
  .cd-card-body { padding: 0; }

  .cd-table-wrap { overflow-x: auto; }
  table.cd-table { width: 100%; border-collapse: collapse; }
  table.cd-table thead th {
    background: var(--cream); padding: 13px 20px; text-align: left;
    font-size: 10.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .1em; color: var(--muted); border-bottom: 1px solid var(--border);
    white-space: nowrap;
  }
  table.cd-table tbody td {
    padding: 14px 20px; font-size: 13px; color: var(--ink2);
    border-bottom: 1px solid rgba(194,90,42,0.06);
  }
  table.cd-table tbody tr:last-child td { border-bottom: none; }
  table.cd-table tbody tr { transition: background .15s; }
  table.cd-table tbody tr:hover { background: var(--cream); }
  table.cd-table tbody td.col-id { font-family: 'Courier New', monospace; color: var(--muted); }
  table.cd-table tbody td.col-name { font-weight: 600; color: var(--ink); }
  table.cd-table tbody td.col-total {
    font-weight: 700; color: var(--terra-d); font-family: 'Courier New', monospace;
  }
  table.cd-table tbody td.text-center { text-align: center; padding: 40px 20px; color: var(--muted); }

  /* ── Badges ── */
  .badge {
    display: inline-block; font-size: 10.5px; font-weight: 700;
    padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: .04em;
  }
  .badge-pending   { background: var(--terra-bg); color: var(--terra); border: 1px solid rgba(194,90,42,0.2); }
  .badge-accepted  { background: var(--blue-bg);  color: var(--blue);  border: 1px solid rgba(42,108,194,0.2); }
  .badge-completed { background: var(--green-bg); color: var(--green); border: 1px solid rgba(61,140,90,0.2); }
  .badge-cancelled { background: var(--red-bg);   color: var(--red);   border: 1px solid rgba(194,58,42,0.2); }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media(max-width:640px) {
    .pg-header h1 { font-size: 24px; }
    table.cd-table thead th, table.cd-table tbody td { padding: 10px 12px; }
  }
</style>

<div class="cd-wrap">

  <div class="pg-header">
    <div>
      <div class="pg-eyebrow">Restaurant Panel</div>
      <h1><span>{{ $customer->name }}</span></h1>
    </div>
    <a href="{{ url()->previous() }}" class="btn-back">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
      Back to Customers
    </a>
  </div>

  <div class="cd-stats">
    <div class="stat-card">
      <div class="card-eyebrow">Total Orders</div>
      <div class="stat-val">{{ $orders->count() }}</div>
    </div>
    <div class="stat-card">
      <div class="card-eyebrow">Customer Lifetime Value</div>
      <div class="stat-val">£{{ number_format($clv, 2) }}</div>
    </div>
  </div>
   <div class="cd-card">
    <div class="cd-card-header">
      <h5>Customer Favourite Top 5 Dishes</h5>
    </div>
    <div class="cd-card-body">
      <div class="cd-table-wrap">
        <table class="cd-table">
          <thead>
            <tr>
              <th>Dish Name</th>
              <th>Ordered</th>
            </tr>
          </thead>
          <tbody>
            @forelse($customerFavouriteDishes as $dish)
              <tr>
                <td class="col-name">{{ $dish->name }}</td>
                <td class="col-total">{{ $dish->total_orders }} Times</td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center">No Record</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="cd-card">
    <div class="cd-card-header">
      <h5>Order History</h5>
    </div>
    <div class="cd-card-body">
      <div class="cd-table-wrap">
        <table class="cd-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Date</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
              <tr>
                <td class="col-id">#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td class="col-total">£{{ number_format($order->total_amount, 2) }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No Orders Found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

 

</div>

@endsection