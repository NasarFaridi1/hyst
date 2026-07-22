@extends('layouts.app')

@section('content')

<style>
    /* =========================================================
       Self-contained styles — deliberately NOT relying on
       Bootstrap utility classes (d-none, col-*, btn, card, etc.)
       so this page renders correctly even if the parent layout
       doesn't load Bootstrap CSS on this route.
       ========================================================= */

    .pv * { box-sizing: border-box; }
    .pv { padding:24px; font-family:-apple-system,'Segoe UI',Roboto,Arial,sans-serif; color:#22243a; }

    .pv-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .pv-header h3 { margin:0; font-size:1.4rem; font-weight:700; display:flex; align-items:center; gap:8px; }
    .pv-live { font-size:.72rem; padding:5px 12px; border-radius:20px; background:#e8f7ee; color:#1b9c52; font-weight:600; display:inline-flex; align-items:center; gap:5px; }
    .pv-live .dot { width:6px; height:6px; border-radius:50%; background:#1b9c52; display:inline-block; }

    /* ---------- Stat cards: CSS grid, auto-fit, always side by side ---------- */
    .pv-stats { display:grid; grid-template-columns:repeat(auto-fit, minmax(170px,1fr)); gap:14px; margin-bottom:22px; }
    .pv-stat {
        background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(20,20,43,.06);
        padding:16px 18px; display:flex; align-items:center; gap:14px;
        transition:transform .15s ease, box-shadow .15s ease;
    }
    .pv-stat:hover { transform:translateY(-3px); box-shadow:0 8px 22px rgba(20,20,43,.1); }
    .pv-icon { width:44px; height:44px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:20px; color:#fff; }
    .pv-label { font-size:.72rem; color:#8a8fa3; font-weight:700; text-transform:uppercase; letter-spacing:.4px; margin-bottom:3px; }
    .pv-value { font-size:1.5rem; font-weight:800; color:#22243a; margin:0; line-height:1.1; }

    .bg-blue   { background:linear-gradient(135deg,#4e73df,#3f5fd6); }
    .bg-green  { background:linear-gradient(135deg,#1cc88a,#17a673); }
    .bg-red    { background:linear-gradient(135deg,#e74a3b,#d13425); }
    .bg-yellow { background:linear-gradient(135deg,#f6c23e,#e0a800); }
    .bg-cyan   { background:linear-gradient(135deg,#36b9cc,#2593a3); }
    .bg-purple { background:linear-gradient(135deg,#6f42c1,#59339d); }

    /* ---------- Generic card ---------- */
    .pv-card { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(20,20,43,.06); margin-bottom:22px; overflow:hidden; }
    .pv-card-head { padding:14px 20px; border-bottom:1px solid #eef0f5; font-weight:700; font-size:.95rem; display:flex; align-items:center; justify-content:space-between; gap:8px; }
    .pv-card-body { padding:20px; }

    /* ---------- Filter form: CSS grid ---------- */
    .pv-filter-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:14px; margin-bottom:16px; }
    .pv-field label { display:block; font-size:.76rem; font-weight:700; color:#5a5f7a; margin-bottom:5px; }
    .pv-field input {
        width:100%; padding:9px 12px; border-radius:9px; border:1px solid #e3e6f0;
        font-size:.9rem; color:#22243a; background:#fbfbfd;
    }
    .pv-field input:focus { outline:none; border-color:#4e73df; box-shadow:0 0 0 3px rgba(78,115,223,.15); background:#fff; }

    .pv-btn { display:inline-flex; align-items:center; gap:6px; border:0; padding:10px 22px; border-radius:9px; font-weight:700; font-size:.88rem; cursor:pointer; text-decoration:none; }
    .pv-btn-primary { background:#4e73df; color:#fff; }
    .pv-btn-primary:hover { background:#3f5fd6; color:#fff; }
    .pv-btn-light { background:#eef0f5; color:#22243a; }
    .pv-btn-light:hover { background:#e3e6f0; color:#22243a; }

    /* ---------- Chart grid ---------- */
    .pv-chart-row { display:grid; grid-template-columns:2fr 1fr; gap:18px; margin-bottom:0; }
    .pv-chart-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:0; }
    @media (max-width: 900px) {
        .pv-chart-row, .pv-chart-row-2 { grid-template-columns:1fr; }
    }
    .pv-chart-box { position:relative; height:300px; }
    .pv-chart-empty {
        position:absolute; inset:0; display:none; align-items:center; justify-content:center; flex-direction:column; gap:8px;
        color:#a7abc3; font-size:.85rem; font-weight:600;
    }
    .pv-chart-empty.show { display:flex; }
    .pv-chart-empty .ico { font-size:26px; opacity:.6; }
    .pv-chart-box canvas.hide { display:none; }

    /* ---------- Table ---------- */
    .pv-table-wrap { overflow-x:auto; }
    .pv-table { width:100%; border-collapse:collapse; font-size:.86rem; }
    .pv-table thead th {
        background:#22243a; color:#fff; text-transform:uppercase; font-size:.72rem; letter-spacing:.4px;
        padding:12px 14px; text-align:left; white-space:nowrap;
    }
    .pv-table tbody td { padding:11px 14px; border-bottom:1px solid #eef0f5; color:#3a3d55; white-space:nowrap; }
    .pv-table tbody tr:hover { background:#f8f9ff; }
    .pv-table tbody tr:last-child td { border-bottom:0; }
    .pv-empty-row td { text-align:center; padding:40px 14px; color:#a7abc3; white-space:normal; }
    .pv-empty-row .ico { font-size:28px; display:block; margin-bottom:8px; opacity:.6; }

    .pv-badge { border-radius:20px; padding:4px 11px; font-size:.72rem; font-weight:700; display:inline-block; }
    .pv-badge-browser { background:#eaf1ff; color:#3f5fd6; }
    .pv-badge-platform { background:#eafaf3; color:#17a673; }

    .pv-foot { padding:14px 20px; border-top:1px solid #eef0f5; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
    .pv-count { font-size:.82rem; color:#8a8fa3; font-weight:600; }

    /* Force our own look on Laravel's default pagination markup,
       regardless of whether Bootstrap classes are styled or not */
    .pv-foot nav { font-size:.85rem; }
    .pv-foot ul { list-style:none; display:flex; gap:4px; padding:0; margin:0; flex-wrap:wrap; }
    .pv-foot li { display:inline-block; }
    .pv-foot li > a, .pv-foot li > span {
        display:inline-flex; align-items:center; justify-content:center; min-width:34px; height:34px;
        padding:0 8px; border-radius:8px; border:1px solid #e3e6f0; color:#3a3d55; text-decoration:none; font-weight:600;
    }
    .pv-foot li.active > span, .pv-foot li > a:hover { background:#4e73df; border-color:#4e73df; color:#fff; }
    .pv-foot li.disabled > span { color:#c7cad9; }

    .pv-alert { background:#fff8e6; border:1px solid #ffe4a3; color:#8a6d00; padding:10px 16px; border-radius:9px; font-size:.85rem; margin-bottom:16px; display:none; }
    .pv-alert.show { display:block; }
</style>

<div class="pv">

    <div class="pv-header">
        <h3> Page Analytics</h3>
       
    </div>

    <div id="pvChartWarning" class="pv-alert">
        ⚠️ Charts library could not load (possibly blocked by network/CDN). Table and numbers below are still accurate.
    </div>

    {{-- Dashboard Cards --}}
    <div class="pv-stats">

        <div class="pv-stat">
            <div>
                <div class="pv-label">Total Visits</div>
                <p class="pv-value">{{ number_format($totalVisits) }}</p>
            </div>
        </div>

        <div class="pv-stat">
            <div>
                <div class="pv-label">Today</div>
                <p class="pv-value">{{ number_format($todayVisits) }}</p>
            </div>
        </div>

        <div class="pv-stat">
            <div>
                <div class="pv-label">Users</div>
                <p class="pv-value">{{ number_format($uniqueUsers) }}</p>
            </div>
        </div>

        

        <div class="pv-stat">
            <div>
                <div class="pv-label">Products</div>
                <p class="pv-value">{{ number_format($uniqueProducts) }}</p>
            </div>
        </div>

        <div class="pv-stat">
            <div>
                <div class="pv-label">Countries</div>
                <p class="pv-value">{{ number_format($uniqueCountries) }}</p>
            </div>
        </div>

    </div>

    

    {{-- Charts --}}

    <div class="pv-chart-row" style="margin-bottom:18px;">

        <div class="pv-card" style="margin-bottom:0;">
            <div class="pv-card-head"> Last 30 Days Visits</div>
            <div class="pv-card-body">
                <div class="pv-chart-box">
                    <canvas id="dailyChart"></canvas>
                    <div id="dailyEmpty" class="pv-chart-empty"><span class="ico">📭</span> No data available</div>
                </div>
            </div>
        </div>

        <div class="pv-card" style="margin-bottom:0;">
            <div class="pv-card-head"> Browser Usage</div>
            <div class="pv-card-body">
                <div class="pv-chart-box">
                    <canvas id="browserChart"></canvas>
                    <div id="browserEmpty" class="pv-chart-empty"><span class="ico">📭</span> No data available</div>
                </div>
            </div>
        </div>

    </div>

    <div style="height:18px;"></div>

    <div class="pv-chart-row-2" style="margin-bottom:18px;">

        <div class="pv-card" style="margin-bottom:0;">
            <div class="pv-card-head"> Top Pages</div>
            <div class="pv-card-body">
                <div class="pv-chart-box">
                    <canvas id="pageChart"></canvas>
                    <div id="pageEmpty" class="pv-chart-empty"><span class="ico">📭</span> No data available</div>
                </div>
            </div>
        </div>

        <div class="pv-card" style="margin-bottom:0;">
            <div class="pv-card-head"> Platform Usage</div>
            <div class="pv-card-body">
                <div class="pv-chart-box">
                    <canvas id="platformChart"></canvas>
                    <div id="platformEmpty" class="pv-chart-empty"><span class="ico">📭</span> No data available</div>
                </div>
            </div>
        </div>

    </div>

    <div style="height:18px;"></div>

    <div class="pv-chart-row-2">

        <div class="pv-card" style="margin-bottom:0;">
            <div class="pv-card-head"> Country Visits</div>
            <div class="pv-card-body">
                <div class="pv-chart-box">
                    <canvas id="countryChart"></canvas>
                    <div id="countryEmpty" class="pv-chart-empty"><span class="ico">📭</span> No data available</div>
                </div>
            </div>
        </div>

        {{-- <div class="pv-card" style="margin-bottom:0;">
            <div class="pv-card-head"> Top Restaurants</div>
            <div class="pv-card-body">
                <div class="pv-chart-box">
                    <canvas id="restaurantChart"></canvas>
                    <div id="restaurantEmpty" class="pv-chart-empty"><span class="ico">📭</span> No data available</div>
                </div>
            </div>
        </div> --}}

    </div>

    <div style="height:22px;"></div>

    {{-- Search / Filter Card --}}
    <div class="pv-card">
        <div class="pv-card-head"> Search Filters</div>
        <div class="pv-card-body">
            <form method="GET">
                <div class="pv-filter-grid">

                    <div class="pv-field">
                        <label>From</label>
                        <input type="date" name="from" value="{{ request('from') }}">
                    </div>

                    <div class="pv-field">
                        <label>To</label>
                        <input type="date" name="to" value="{{ request('to') }}">
                    </div>

                    <div class="pv-field">
                        <label>Restaurant</label>
                        <input type="text" name="restaurant" placeholder="Restaurant name" value="{{ request('restaurant') }}">
                    </div>

                    <div class="pv-field">
                        <label>Page Name</label>
                        <input type="text" name="page_name" placeholder="Page name" value="{{ request('page_name') }}">
                    </div>

                    <div class="pv-field">
                        <label>User ID</label>
                        <input type="text" name="user" placeholder="User ID" value="{{ request('user') }}">
                    </div>

                    <div class="pv-field">
                        <label>IP Address</label>
                        <input type="text" name="ip" placeholder="IP address" value="{{ request('ip') }}">
                    </div>

                    <div class="pv-field">
                        <label>Country</label>
                        <input type="text" name="country" placeholder="Country" value="{{ request('country') }}">
                    </div>

                    <div class="pv-field">
                        <label>Browser</label>
                        <input type="text" name="browser" placeholder="Browser" value="{{ request('browser') }}">
                    </div>

                    <div class="pv-field">
                        <label>Platform</label>
                        <input type="text" name="platform" placeholder="Platform" value="{{ request('platform') }}">
                    </div>

                </div>

                <button type="submit" class="pv-btn pv-btn-primary"> Search</button>
                {{-- <a href="{{ route('restaurant.page-visit.index') }}" class="pv-btn pv-btn-light"> Reset</a> --}}
            </form>
        </div>
    </div>
    {{-- Table --}}
    <div class="pv-card" style="margin-bottom:0;">
        <div class="pv-card-head">
            <span> Page Visit History</span>
            <span class="pv-count">{{ number_format($pageVisits->total()) }} total record(s)</span>
        </div>

        <div class="pv-table-wrap">
            <table class="pv-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Restaurant</th>
                        <th>Page</th>
                        <th>Product</th>
                        <th>Order</th>
                        <th>IP</th>
                        <th>Location</th>
                        <th>Browser</th>
                        <th>Platform</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pageVisits as $visit)
                        <tr>
                            <td>{{ $visit->id }}</td>
                            <td>{{ $users[$visit->user_id] ?? 'Guest' }}</td>
                            <td>{{ $visit->restaurant_name ?? '—' }}</td>
                            {{-- <td>
                                @if($visit->page_url)
                                    <a href="{{ $visit->page_url }}" target="_blank" rel="noopener" style="color:#4e73df;">{{ $visit->page_name }}</a>
                                @else
                                    {{ $visit->page_name ?? '—' }}
                                @endif
                            </td> --}}
                            <td>{{ $visit->page_name ?? '—' }}</td>
                            <td>
                                {{ $products[$visit->product_id] ?? '—' }}
                            </td>
                            <td>{{ $visit->order_id ?? '—' }}</td>
                            <td>{{ $visit->ip_address ?? '—' }}</td>
                            <td>
                                @php $location = array_filter([$visit->city, $visit->state, $visit->country]); @endphp
                                {{ $location ? implode(', ', $location) : '—' }}
                            </td>
                            <td>
                                @if($visit->browser)
                                    <span class="pv-badge pv-badge-browser">{{ $visit->browser }}</span>
                                @else — @endif
                            </td>
                            <td>
                                @if($visit->platform)
                                    <span class="pv-badge pv-badge-platform">{{ $visit->platform }}</span>
                                @else — @endif
                            </td>
                            <td>{{ $visit->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr class="pv-empty-row">
                            <td colspan="11">
                                <span class="ico">📭</span>
                                No Records Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pv-foot">
    {{ $pageVisits->appends(request()->query())->links() }}
</div>
    </div>

</div>

{{-- Chart.js + rendering script, kept inline right after the markup so it
     always executes regardless of the parent layout's script stacking --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    // If Chart.js failed to load (CDN blocked etc.) show a visible warning
    // instead of silently failing.
    if (typeof Chart === 'undefined') {
        var warn = document.getElementById('pvChartWarning');
        if (warn) warn.classList.add('show');
        return;
    }

    var chartColors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#858796', '#5a5c69', '#20c997', '#fd7e14', '#6f42c1'
    ];

    Chart.defaults.font.family = "-apple-system,'Segoe UI',Roboto,Arial,sans-serif";
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.tooltip.callbacks.label = function (ctx) {
        var label = ctx.label || ctx.dataset.label || '';
        var value = ctx.parsed.y !== undefined ? ctx.parsed.y : (ctx.parsed.x !== undefined ? ctx.parsed.x : ctx.parsed);
        return label + ': ' + value + ' visit' + (value == 1 ? '' : 's');
    };

    function renderOrEmpty(canvasId, emptyId, data, buildFn) {
        var hasData = Array.isArray(data) && data.length > 0 && data.some(function (v) { return Number(v) > 0; });
        var canvas = document.getElementById(canvasId);
        var empty = document.getElementById(emptyId);
        if (!hasData) {
            if (canvas) canvas.classList.add('hide');
            if (empty) empty.classList.add('show');
            return;
        }
        if (canvas) canvas.classList.remove('hide');
        if (empty) empty.classList.remove('show');
        try {
            buildFn();
        } catch (e) {
            console.error('Chart render failed for ' + canvasId, e);
            if (canvas) canvas.classList.add('hide');
            if (empty) { empty.classList.add('show'); empty.querySelector('span:last-child') && (empty.lastChild.textContent = ' Chart error'); }
        }
    }

   var dailyLabels = @json($dailyLabels);
var dailyData   = @json($dailyValues);

    renderOrEmpty('dailyChart', 'dailyEmpty', dailyData, function () {
        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Visits',
                    data: dailyData,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78,115,223,0.12)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 2,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { display: false }, tooltip: { enabled: true } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f0f1f7' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });

    var pageLabels = @json($topPages->pluck('page_name'));
    var pageData   = @json($topPages->pluck('total'));

    renderOrEmpty('pageChart', 'pageEmpty', pageData, function () {
        new Chart(document.getElementById('pageChart'), {
            type: 'bar',
            data: {
                labels: pageLabels,
                datasets: [{ label: 'Visits', data: pageData, backgroundColor: '#36b9cc', borderRadius: 6, maxBarThickness: 34 }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: true } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f0f1f7' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });

    var browserLabels = @json($browserGraph->pluck('browser'));
    var browserData   = @json($browserGraph->pluck('total'));

    renderOrEmpty('browserChart', 'browserEmpty', browserData, function () {
        new Chart(document.getElementById('browserChart'), {
            type: 'pie',
            data: { labels: browserLabels, datasets: [{ data: browserData, backgroundColor: chartColors, borderWidth: 2, borderColor: '#fff' }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { tooltip: { enabled: true } } }
        });
    });

    var platformLabels = @json($platformGraph->pluck('platform'));
    var platformData   = @json($platformGraph->pluck('total'));

    renderOrEmpty('platformChart', 'platformEmpty', platformData, function () {
        new Chart(document.getElementById('platformChart'), {
            type: 'doughnut',
            data: { labels: platformLabels, datasets: [{ data: platformData, backgroundColor: chartColors, borderWidth: 2, borderColor: '#fff' }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { tooltip: { enabled: true } } }
        });
    });

    var countryLabels = @json($countryGraph->pluck('country'));
    var countryData   = @json($countryGraph->pluck('total'));

    renderOrEmpty('countryChart', 'countryEmpty', countryData, function () {
        new Chart(document.getElementById('countryChart'), {
            type: 'bar',
            data: { labels: countryLabels, datasets: [{ label: 'Visits', data: countryData, backgroundColor: '#f6c23e', borderRadius: 6 }] },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: true } },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f0f1f7' } },
                    y: { grid: { display: false } }
                }
            }
        });
    });

    var restaurantLabels = @json($topRestaurants->pluck('restaurant_name'));
    var restaurantData   = @json($topRestaurants->pluck('total'));

    renderOrEmpty('restaurantChart', 'restaurantEmpty', restaurantData, function () {
        new Chart(document.getElementById('restaurantChart'), {
            type: 'bar',
            data: { labels: restaurantLabels, datasets: [{ label: 'Visits', data: restaurantData, backgroundColor: '#e74a3b', borderRadius: 6 }] },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: true } },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f0f1f7' } },
                    y: { grid: { display: false } }
                }
            }
        });
    });
})();
</script>

@endsection