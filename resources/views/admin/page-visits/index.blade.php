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

    .pv-alert { background:#fff8e6; border:1px solid #ffe4a3; color:#8a6d00; padding:10px 16px; border-radius:99px; font-size:.85rem; margin-bottom:16px; display:none; }
    .pv-alert.show { display:block; }

    /* =========================================================
       Unique Visitor Profiles & Browsing Journeys (Image 2 style)
       ========================================================= */
    .pv-journey-card-wrap {
        background:#ffffff;
        border-radius:16px;
        border:1px solid #e2e8f0;
        box-shadow:0 1px 4px rgba(0,0,0,.04);
        overflow:hidden;
        margin-bottom:24px;
    }
    .pv-journey-head {
        padding:20px 24px;
        border-bottom:1px solid #f1f5f9;
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:14px;
    }
    .pv-journey-title-wrap {
        display:flex;
        align-items:center;
        gap:14px;
    }
    .pv-journey-icon {
        width:40px;
        height:40px;
        border-radius:10px;
        background:#ecfdf5;
        border:1px solid #a7f3d0;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#059669;
        flex-shrink:0;
    }
    .pv-journey-title {
        margin:0;
        font-size:1.15rem;
        font-weight:800;
        color:#0f172a;
        letter-spacing:-.2px;
    }
    .pv-journey-subtitle {
        margin:3px 0 0 0;
        font-size:.82rem;
        color:#64748b;
        font-weight:400;
    }
    .pv-journey-table {
        width:100%;
        border-collapse:separate;
        border-spacing:0;
        font-size:.85rem;
    }
    .pv-journey-table thead th {
        background:#f8fafc;
        color:#475569;
        text-transform:uppercase;
        font-size:.72rem;
        font-weight:700;
        letter-spacing:.05em;
        padding:14px 20px;
        text-align:left;
        border-bottom:1px solid #e2e8f0;
        white-space:nowrap;
    }
    .pv-journey-table tbody td {
        padding:15px 20px;
        border-bottom:1px solid #f1f5f9;
        vertical-align:middle;
        color:#334155;
        white-space:nowrap;
        background:#ffffff;
    }
    .pv-journey-table tbody tr.pv-visitor-row:hover td {
        background:#fbfcfe;
    }
    .pv-ip-text {
        font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace;
        font-weight:700;
        color:#2563eb;
        font-size:.88rem;
    }
    .pv-loc-wrap {
        display:flex;
        align-items:center;
        gap:10px;
    }
    .pv-loc-icon {
        width:28px;
        height:28px;
        border-radius:8px;
        background:#eff6ff;
        border:1px solid #dbeafe;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#3b82f6;
        flex-shrink:0;
    }
    .pv-loc-city {
        font-weight:700;
        color:#0f172a;
        font-size:.86rem;
        line-height:1.2;
    }
    .pv-loc-country {
        color:#64748b;
        font-size:.74rem;
        margin-top:2px;
    }
    .pv-pill-times {
        background:#ecfdf5;
        border:1px solid #a7f3d0;
        color:#059669;
        padding:4px 12px;
        border-radius:999px;
        font-size:.76rem;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        gap:5px;
    }
    .pv-pages-viewed {
        font-weight:700;
        color:#0f172a;
        font-size:.86rem;
    }
    .pv-device-os {
        color:#334155;
        font-size:.84rem;
        font-weight:500;
    }
    .pv-first-seen {
        color:#64748b;
        font-size:.8rem;
    }
    .pv-last-active {
        color:#0f172a;
        font-size:.82rem;
        font-weight:600;
    }
    .pv-btn-journey {
        background:#4f46e5;
        color:#ffffff;
        font-size:.78rem;
        font-weight:700;
        padding:7px 16px;
        border-radius:999px;
        border:none;
        cursor:pointer;
        display:inline-flex;
        align-items:center;
        gap:6px;
        transition:all .18s ease;
        box-shadow:0 2px 6px rgba(79,70,229,.25);
    }
    .pv-btn-journey:hover {
        background:#4338ca;
        transform:translateY(-1px);
        box-shadow:0 4px 10px rgba(79,70,229,.35);
    }
    .pv-btn-journey.active {
        background:#1e1b4b;
        box-shadow:none;
    }
    .pv-drawer-row td {
        padding:20px 24px !important;
        background:#f8fafc !important;
        border-bottom:2px solid #e2e8f0 !important;
    }
    .pv-drawer-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:14px;
        flex-wrap:wrap;
        gap:10px;
    }
    .pv-drawer-title {
        display:flex;
        align-items:center;
        gap:8px;
        font-weight:800;
        color:#4338ca;
        font-size:.92rem;
    }
    .pv-drawer-loc-pill {
        background:#eef2ff;
        border:1px solid #c7d2fe;
        color:#4338ca;
        border-radius:999px;
        padding:4px 14px;
        font-size:.76rem;
        font-weight:600;
        display:inline-flex;
        align-items:center;
        gap:5px;
    }
    .pv-journey-step-card {
        background:#ffffff;
        border:1px solid #e2e8f0;
        border-radius:10px;
        padding:11px 16px;
        margin-bottom:8px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:14px;
        transition:border-color .15s ease;
    }
    .pv-journey-step-card:hover {
        border-color:#cbd5e1;
    }
    .pv-step-left {
        display:flex;
        align-items:center;
        gap:12px;
        flex:1;
        min-width:0;
    }
    .pv-step-time {
        color:#475569;
        font-size:.78rem;
        font-weight:500;
        white-space:nowrap;
        min-width:125px;
    }
    .pv-step-page {
        font-weight:700;
        color:#0f172a;
        font-size:.84rem;
        white-space:nowrap;
    }
    .pv-step-arrow {
        color:#94a3b8;
        margin:0 4px;
    }
    .pv-step-url {
        color:#475569;
        font-size:.8rem;
        text-decoration:none;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }
    .pv-step-url:hover {
        color:#2563eb;
        text-decoration:underline;
    }
    .pv-step-right {
        display:flex;
        align-items:center;
        gap:8px;
        flex-shrink:0;
    }
    .pv-view-switcher {
        display:flex;
        background:#f1f5f9;
        border-radius:8px;
        padding:3px;
        gap:3px;
    }
    .pv-view-tab {
        border:none;
        background:none;
        padding:5px 12px;
        font-size:.78rem;
        font-weight:600;
        color:#64748b;
        border-radius:6px;
        cursor:pointer;
        transition:all .15s ease;
    }
    .pv-view-tab.active {
        background:#fff;
        color:#0f172a;
        box-shadow:0 1px 3px rgba(0,0,0,.08);
    }
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
                <div class="pv-label">Restaurants</div>
                <p class="pv-value">{{ number_format($uniqueRestaurants) }}</p>
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

        <div class="pv-card" style="margin-bottom:0;">
            <div class="pv-card-head"> Top Restaurants</div>
            <div class="pv-card-body">
                <div class="pv-chart-box">
                    <canvas id="restaurantChart"></canvas>
                    <div id="restaurantEmpty" class="pv-chart-empty"><span class="ico">📭</span> No data available</div>
                </div>
            </div>
        </div>

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
                <a href="{{ route('admin.page-visits.index') }}" class="pv-btn pv-btn-light"> Reset</a>
            </form>
        </div>
    </div>
    {{-- =========================================================
         UNIQUE VISITOR PROFILES & BROWSING JOURNEYS (Image 2 Style)
         ========================================================= --}}
    <div class="pv-journey-card-wrap">
        <div class="pv-journey-head">
            <div class="pv-journey-title-wrap">
                <div class="pv-journey-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                        <rect x="2" y="17" width="6" height="4" rx="1"/>
                        <rect x="16" y="17" width="6" height="4" rx="1"/>
                        <path d="M12 7v5m0 0H5v5m7-5h7v5"/>
                    </svg>
                </div>
                <div>
                    <h3 class="pv-journey-title">Unique Visitor Profiles &amp; Browsing Journeys</h3>
                    <p class="pv-journey-subtitle">Each IP address appears once with total visit count and click-by-click page history</p>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:12px;">
                <div class="pv-view-switcher">
                    <button type="button" class="pv-view-tab active" id="btnViewJourneys" onclick="switchPvView('journeys')">
                        Journeys View
                    </button>
                    <button type="button" class="pv-view-tab" id="btnViewRaw" onclick="switchPvView('raw')">
                        Raw Log ({{ number_format($pageVisits->total()) }})
                    </button>
                </div>
                <span class="pv-count" style="font-size:12px; background:#f1f5f9; color:#475569; padding:5px 12px; border-radius:8px; font-weight:700;">
                    {{ number_format($totalUniqueVisitors ?? $uniqueVisitors->total()) }} unique visitor(s)
                </span>
            </div>
        </div>

        {{-- JOURNEYS VIEW TABLE (Image 2) --}}
        <div id="pvJourneysView" class="pv-table-wrap">
            <table class="pv-journey-table">
                <thead>
                    <tr>
                        <th>IP ADDRESS</th>
                        <th>LOCATION / CITY</th>
                        <th>TIMES VISITED</th>
                        <th>PAGES VIEWED</th>
                        <th>DEVICE &amp; OS</th>
                        <th>FIRST SEEN</th>
                        <th>LAST ACTIVE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($uniqueVisitors as $visitor)
                        @php
                            $ip = $visitor->ip_address;
                            $ipVisits = $visitsByIp[$ip] ?? collect();
                            $latestVisit = $ipVisits->first();

                            $city = $latestVisit->city ?? '';
                            $state = $latestVisit->state ?? '';
                            $country = $latestVisit->country ?? '';
                            $countryCode = \App\Http\Controllers\Admin\PageVisitController::getCountryCode($country);

                            $deviceOs = \App\Http\Controllers\Admin\PageVisitController::formatDeviceAndOs(
                                $latestVisit->platform ?? '',
                                $latestVisit->browser ?? '',
                                $latestVisit->user_agent ?? ''
                            );

                            $visitCount = $visitor->total_sessions > 1 ? $visitor->total_sessions : ($visitor->total_views > 1 ? $visitor->total_views : 1);
                            $pagesCount = $visitor->total_views;

                            $firstSeen = $visitor->first_seen ? \Carbon\Carbon::parse($visitor->first_seen)->format('M d, H:i') : '—';
                            $lastActive = $visitor->last_active ? \Carbon\Carbon::parse($visitor->last_active)->diffForHumans() : '—';
                            $drawerId = 'journey-drawer-' . $loop->index;
                        @endphp
                        <tr class="pv-visitor-row">
                            <td>
                                <span class="pv-ip-text">{{ $ip }}</span>
                            </td>
                            <td>
                                <div class="pv-loc-wrap">
                                    <div class="pv-loc-icon">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="pv-loc-city">{{ $city ?: 'Unknown City' }}</div>
                                        <div class="pv-loc-country">{{ $country ?: 'Unknown' }} {{ $countryCode }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="pv-pill-times">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-1.19"/>
                                    </svg>
                                    <span>{{ $visitCount }} {{ $visitCount == 1 ? 'time' : 'times' }}</span>
                                </span>
                            </td>
                            <td>
                                <span class="pv-pages-viewed">{{ $pagesCount }} pages</span>
                            </td>
                            <td>
                                <span class="pv-device-os">{{ $deviceOs }}</span>
                            </td>
                            <td>
                                <span class="pv-first-seen">{{ $firstSeen }}</span>
                            </td>
                            <td>
                                <span class="pv-last-active">{{ $lastActive }}</span>
                            </td>
                            <td>
                                <button type="button" 
                                        class="pv-btn-journey" 
                                        onclick="toggleJourneyDrawer('{{ $drawerId }}', this)">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span>View Journey ({{ $pagesCount }})</span>
                                </button>
                            </td>
                        </tr>

                        {{-- Expanded Click-by-Click History Drawer --}}
                        <tr id="{{ $drawerId }}" class="pv-drawer-row" style="display:none;">
                            <td colspan="8">
                                <div class="pv-drawer-header">
                                    <div class="pv-drawer-title">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>Browsing History for IP: <strong style="font-family:monospace; color:#1E1B4B;">{{ $ip }}</strong></span>
                                    </div>
                                    <div class="pv-drawer-loc-pill">
                                        <span>📍</span>
                                        <span>{{ implode(', ', array_filter([$city, $state, $country])) ?: 'Location Unavailable' }}</span>
                                    </div>
                                </div>

                                <div class="pv-journey-steps-list">
                                    @forelse($ipVisits as $visitItem)
                                        <div class="pv-journey-step-card">
                                            <div class="pv-step-left">
                                                <span class="pv-step-time">
                                                    {{ $visitItem->created_at ? $visitItem->created_at->format('M d, H:i:s') : '—' }}
                                                </span>
                                                <span class="pv-step-page">
                                                    {{ $visitItem->page_name ?: 'Home' }}
                                                </span>
                                                @if($visitItem->page_url)
                                                    <span class="pv-step-arrow">→</span>
                                                    <a href="{{ $visitItem->page_url }}" target="_blank" rel="noopener" class="pv-step-url" title="{{ $visitItem->page_url }}">
                                                        {{ $visitItem->page_url }}
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="pv-step-right">
                                                @if($visitItem->restaurant_name)
                                                    <span style="background:#FFF7ED; color:#C25A2A; border:1px solid #FED7AA; font-size:11px; font-weight:700; padding:2px 8px; border-radius:6px; white-space:nowrap;">
                                                        🍽️ {{ $visitItem->restaurant_name }}
                                                    </span>
                                                @endif
                                                @if($visitItem->product_id)
                                                    <span style="background:#F0FDF4; color:#166534; border:1px solid #BBF7D0; font-size:11px; font-weight:700; padding:2px 8px; border-radius:6px; white-space:nowrap;">
                                                        📦 Product #{{ $visitItem->product_id }}
                                                    </span>
                                                @endif
                                                @if($visitItem->order_id)
                                                    <span style="background:#EEF2FF; color:#4338CA; border:1px solid #C7D2FE; font-size:11px; font-weight:700; padding:2px 8px; border-radius:6px; white-space:nowrap;">
                                                        🧾 Order #{{ $visitItem->order_id }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div style="padding:14px; text-align:center; color:#94A3B8; font-size:13px;">
                                            No page history recorded for this IP.
                                        </div>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:48px 20px; color:#94A3B8;">
                                <div style="font-size:32px; margin-bottom:10px;">🔍</div>
                                <div style="font-size:15px; font-weight:700; color:#475569;">No visitor profiles found</div>
                                <div style="font-size:13px; color:#94A3B8; margin-top:4px;">Try adjusting your search filters above.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pv-foot">
                <div style="font-size:13px; color:#64748B; font-weight:600;">
                    Showing {{ $uniqueVisitors->firstItem() ?? 0 }} to {{ $uniqueVisitors->lastItem() ?? 0 }} of {{ number_format($uniqueVisitors->total()) }} unique visitor(s)
                </div>
                <div>
                    {{ $uniqueVisitors->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        {{-- RAW FLAT LOG VIEW (Optional Toggle) --}}
        <div id="pvRawView" class="pv-table-wrap" style="display:none;">
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
                            <td>{{ $visit->page_name ?? '—' }}</td>
                            <td>{{ $products[$visit->product_id] ?? '—' }}</td>
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

            <div class="pv-foot">
                <div style="font-size:13px; color:#64748B; font-weight:600;">
                    Showing {{ $pageVisits->firstItem() ?? 0 }} to {{ $pageVisits->lastItem() ?? 0 }} of {{ number_format($pageVisits->total()) }} total record(s)
                </div>
                <div>
                    {{ $pageVisits->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleJourneyDrawer(drawerId, btn) {
            var drawer = document.getElementById(drawerId);
            if (!drawer) return;

            if (drawer.style.display === 'none' || drawer.style.display === '') {
                drawer.style.display = 'table-row';
                if (btn) {
                    btn.classList.add('active');
                    var span = btn.querySelector('span');
                    if (span && !span.dataset.orig) {
                        span.dataset.orig = span.innerText;
                    }
                    if (span) {
                        span.innerText = span.innerText.replace('View', 'Hide');
                    }
                }
            } else {
                drawer.style.display = 'none';
                if (btn) {
                    btn.classList.remove('active');
                    var span = btn.querySelector('span');
                    if (span && span.dataset.orig) {
                        span.innerText = span.dataset.orig;
                    } else if (span) {
                        span.innerText = span.innerText.replace('Hide', 'View');
                    }
                }
            }
        }

        function switchPvView(viewType) {
            var journeys = document.getElementById('pvJourneysView');
            var raw = document.getElementById('pvRawView');
            var btnJ = document.getElementById('btnViewJourneys');
            var btnR = document.getElementById('btnViewRaw');

            if (viewType === 'journeys') {
                if (journeys) journeys.style.display = 'block';
                if (raw) raw.style.display = 'none';
                if (btnJ) btnJ.classList.add('active');
                if (btnR) btnR.classList.remove('active');
            } else {
                if (journeys) journeys.style.display = 'none';
                if (raw) raw.style.display = 'block';
                if (btnJ) btnJ.classList.remove('active');
                if (btnR) btnR.classList.add('active');
            }
        }
    </script>

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

    var dailyLabels = @json($dailyVisits->pluck('visit_date'));
    var dailyData   = @json($dailyVisits->pluck('total'));

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