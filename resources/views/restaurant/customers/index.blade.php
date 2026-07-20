@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: var(--cream2); }
  ::-webkit-scrollbar-thumb { background: var(--terra); border-radius: 4px; }

  .cm-wrap { margin: 0 auto; padding: 2rem 1.5rem 4rem; }

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

  .cm-card {
    background: #fff; border: 1px solid var(--border); border-radius: 16px;
    box-shadow: var(--shadow); overflow: hidden; margin-bottom: 24px;
    animation: fadeUp .5s var(--ease) both;
  }
  .cm-card-header {
    padding: 18px 24px; background: var(--cream); border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
  }
  .cm-card-header h5 {
    font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; color: var(--ink); margin: 0;
  }

  .cm-table-wrap { overflow-x: auto; }
  table.cm-table { width: 100%; border-collapse: collapse; }
  table.cm-table thead th {
    background: var(--cream); padding: 13px 20px; text-align: left;
    font-size: 10.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .1em; color: var(--muted); border-bottom: 1px solid var(--border);
    white-space: nowrap;
  }
  table.cm-table tbody td {
    padding: 14px 20px; font-size: 13px; color: var(--ink2);
    border-bottom: 1px solid rgba(194,90,42,0.06);
  }
  table.cm-table tbody tr:last-child td { border-bottom: none; }
  table.cm-table tbody tr { transition: background .15s; }
  table.cm-table tbody tr:hover { background: var(--cream); }
  table.cm-table tbody td.col-id { font-family: 'Courier New', monospace; color: var(--muted); }
  table.cm-table tbody td.col-name { font-weight: 600; color: var(--ink); }
  table.cm-table tbody td.col-orders {
    font-weight: 700; color: var(--terra-d); font-family: 'Courier New', monospace;
  }
  table.cm-table tbody td.text-center { text-align: center; padding: 40px 20px; color: var(--muted); }

  .cm-badge-count {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 26px; height: 26px; padding: 0 8px; border-radius: 999px;
    background: var(--terra-bg); color: var(--terra); font-size: 12px; font-weight: 700;
  }

  .cm-btn {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--terra); color: #fff; border: none; border-radius: 9px;
    padding: 7px 16px; font-family: 'Poppins', sans-serif;
    font-size: 12.5px; font-weight: 600; cursor: pointer; text-decoration: none;
    transition: all .22s var(--ease); box-shadow: 0 3px 10px rgba(194,90,42,0.25);
  }
  .cm-btn:hover { background: var(--terra-l); color: #fff; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(194,90,42,0.35); }

  .cm-pagination { padding: 16px 24px; border-top: 1px solid var(--border); background: var(--cream); }
  .cm-pagination nav { display: flex; justify-content: flex-end; }
  .cm-pagination .pagination { margin: 0; }
  .cm-pagination .page-link {
    border: 1px solid var(--border2); color: var(--terra-d);
    font-size: 13px; font-family: 'Poppins', sans-serif;
  }
  .cm-pagination .page-link:hover { background: var(--terra-bg); color: var(--terra-d); }
  .cm-pagination .page-item.active .page-link {
    background: var(--terra); border-color: var(--terra); color: #fff;
  }

  /* ── Top dishes split layout ── */
  .cm-dishes-grid {
    display: grid; grid-template-columns: 1fr 1fr; align-items: stretch;
  }
  @media(max-width:900px) { .cm-dishes-grid { grid-template-columns: 1fr; } }

  .cm-dishes-chart-side {
    padding: 24px; border-left: 1px solid var(--border);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
  }
  @media(max-width:900px) { .cm-dishes-chart-side { border-left: none; border-top: 1px solid var(--border); } }

  .cm-chart-wrap { width: 100%; max-width: 320px; height: 260px; position: relative; }
  .cm-chart-empty { text-align: center; padding: 40px 20px; color: var(--muted); font-size: 13px; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media(max-width:640px) {
    .pg-header h1 { font-size: 24px; }
    table.cm-table thead th, table.cm-table tbody td { padding: 10px 12px; }
  }
</style>

<div class="cm-wrap">

  <div class="pg-header">
    <div class="pg-eyebrow">Restaurant Panel</div>
    <h1>Customer <span>Management</span></h1>
    <p class="pg-sub">All customers who have ordered from your restaurant</p>
  </div>

  <div class="cm-card">
    <div class="cm-card-header">
      <h5>Restaurant Top 5 Selling Dishes</h5>
    </div>

    <div class="cm-dishes-grid">

      <div class="cm-table-wrap">
        <table class="cm-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Dish Name</th>
              <th>Total Ordered</th>
            </tr>
          </thead>
          <tbody>
            @forelse($restaurantFavouriteDishes as $index => $dish)
              <tr>
                <td class="col-name">
                  @if($index == 0)
                    🥇
                  @elseif($index == 1)
                    🥈
                  @elseif($index == 2)
                    🥉
                  @else
                    {{ $index + 1 }}
                  @endif
                </td>
                <td class="col-name">{{ $dish->name }}</td>
                <td class="col-orders">{{ $dish->total_orders }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center">No Data Found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="cm-dishes-chart-side">
        @if($restaurantFavouriteDishes->count())
          <div class="cm-chart-wrap">
            <canvas id="topDishesChart"></canvas>
          </div>
        @else
          <div class="cm-chart-empty">No Data To Chart</div>
        @endif
      </div>

    </div>
  </div>

  <div class="cm-card">
    <div class="cm-card-header">
      <h5>All Customers</h5>
      <span class="cm-badge-count">{{ $customers->total() ?? $customers->count() }}</span>
    </div>

    <div class="cm-table-wrap">
      <table class="cm-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            {{-- <th>Email</th> --}}
            <th>Total Orders</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($customers as $customer)
            <tr>
              <td class="col-id">#{{ $customer->id }}</td>
              <td class="col-name">{{ $customer->name }}</td>
              {{-- <td>{{ $customer->email }}</td> --}}
              <td class="col-orders">{{ $customer->total_orders }}</td>
              <td>
                <a href="{{ url('/restaurant/customers/'.$customer->id) }}" class="cm-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  View
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">No Customers Found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(method_exists($customers, 'links'))
      <div class="cm-pagination">
        {{ $customers->links() }}
      </div>
    @endif
  </div>



</div>

@if($restaurantFavouriteDishes->count())
<script>

const dishLabels = [
    @foreach($restaurantFavouriteDishes as $dish)
        "{{ addslashes($dish->name) }}",
    @endforeach
];

const dishTotals = [
    @foreach($restaurantFavouriteDishes as $dish)
        {{ $dish->total_orders }},
    @endforeach
];

Chart.defaults.font.family = "'Poppins', sans-serif";

new Chart(document.getElementById('topDishesChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: dishLabels,
        datasets: [{
            label: 'Total Ordered',
            data: dishTotals,
            backgroundColor: [
                '#C25A2A',
                '#D97040',
                '#3D8C5A',
                '#2A6CC2',
                '#C99A3C'
            ],
            borderRadius: 8,
            maxBarThickness: 36
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1A1208',
                titleFont: { family: "'Poppins', sans-serif", size: 12, weight: '600' },
                bodyFont: { family: "'Poppins', sans-serif", size: 12 },
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: 'rgba(194,90,42,0.06)' },
                ticks: { color: '#8A7A62', font: { size: 11 } },
                border: { color: 'rgba(194,90,42,0.1)' }
            },
            y: {
                grid: { display: false },
                ticks: { color: '#2E2318', font: { size: 12, weight: '600' } },
                border: { color: 'rgba(194,90,42,0.1)' }
            }
        }
    }
});

</script>
@endif

@endsection