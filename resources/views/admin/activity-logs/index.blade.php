@extends('layouts.app')

@section('content')

<style>
    /* =========================================================
       Self-contained styles for Error & Activity Journey UI
       ========================================================= */
    .al * { box-sizing: border-box; }
    .al { padding: 24px; font-family: -apple-system, 'Segoe UI', Roboto, Arial, sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

    .al-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 12px; }
    .al-header h3 { margin: 0; font-size: 1.45rem; font-weight: 800; display: flex; align-items: center; gap: 10px; color: #0f172a; }
    .al-live { font-size: .75rem; padding: 5px 12px; border-radius: 20px; background: #fef2f2; color: #dc2626; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #fecaca; }
    .al-live.green { background: #ecfdf5; color: #059669; border-color: #a7f3d0; }
    .al-live .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; display: inline-block; animation: alPulse 1.8s infinite; }
    @keyframes alPulse { 0%, 100% { opacity: 1; } 50% { opacity: .3; } }

    /* Top Stats Grid */
    .al-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 22px; }
    .al-stat {
        background: #fff; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,.04); border: 1px solid #e2e8f0;
        padding: 18px; display: flex; align-items: center; gap: 14px; transition: transform .15s ease, box-shadow .15s ease;
    }
    .al-stat:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.06); }
    .al-icon { width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff; }
    .al-label { font-size: .72rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 3px; }
    .al-value { font-size: 1.55rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.1; }

    .bg-blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .bg-red    { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .bg-amber  { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .bg-purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .bg-emerald{ background: linear-gradient(135deg, #10b981, #059669); }

    /* Flash alerts */
    .al-alert-banner {
        padding: 12px 18px; border-radius: 10px; margin-bottom: 18px; font-size: .9rem; font-weight: 600; display: flex; align-items: center; gap: 10px;
    }
    .al-alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
    .al-alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

    /* Card */
    .al-card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,.04); margin-bottom: 22px; overflow: hidden; }
    .al-card-head {
        padding: 16px 22px; border-bottom: 1px solid #f1f5f9; font-weight: 800; font-size: 1rem; color: #0f172a;
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
    }
    .al-card-body { padding: 22px; }

    /* Filter Grid */
    .al-filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin-bottom: 16px; }
    .al-field label { display: block; font-size: .76rem; font-weight: 700; color: #475569; margin-bottom: 6px; }
    .al-field input, .al-field select {
        width: 100%; padding: 9px 12px; border-radius: 9px; border: 1px solid #cbd5e1;
        font-size: .88rem; color: #0f172a; background: #fff;
    }
    .al-field input:focus, .al-field select:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.15); }

    /* Buttons */
    .al-btn { display: inline-flex; align-items: center; gap: 6px; border: 0; padding: 9px 18px; border-radius: 9px; font-weight: 700; font-size: .86rem; cursor: pointer; text-decoration: none; transition: all .15s ease; }
    .al-btn-primary { background: #2563eb; color: #fff; }
    .al-btn-primary:hover { background: #1d4ed8; }
    .al-btn-danger { background: #dc2626; color: #fff; }
    .al-btn-danger:hover { background: #b91c1c; }
    .al-btn-light { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
    .al-btn-light:hover { background: #e2e8f0; }
    .al-btn-sm { padding: 5px 10px; font-size: .76rem; border-radius: 6px; }

    /* View Mode Toggles */
    .al-view-toggle { display: inline-flex; background: #f1f5f9; padding: 4px; border-radius: 10px; gap: 4px; }
    .al-view-btn { padding: 7px 16px; border-radius: 7px; font-size: .84rem; font-weight: 700; border: 0; background: transparent; color: #64748b; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .al-view-btn.active { background: #fff; color: #0f172a; box-shadow: 0 1px 3px rgba(0,0,0,.08); }

    /* Table */
    .al-table-wrap { overflow-x: auto; }
    .al-table { width: 100%; border-collapse: collapse; font-size: .86rem; }
    .al-table thead th {
        background: #0f172a; color: #f8fafc; text-transform: uppercase; font-size: .72rem; letter-spacing: .4px;
        padding: 12px 14px; text-align: left; white-space: nowrap; font-weight: 700;
    }
    .al-table tbody td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    .al-table tbody tr:hover { background: #f8fafc; }

    /* Badges */
    .al-badge { border-radius: 6px; padding: 3px 8px; font-size: .72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; }
    .al-badge-method { font-family: monospace; font-size: .75rem; letter-spacing: .5px; }
    .method-GET { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .method-POST { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .method-PUT, .method-PATCH { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .method-DELETE { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .status-success { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-failed { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .code-200 { background: #ecfdf5; color: #047857; font-weight: 800; }
    .code-404 { background: #fffbeb; color: #b45309; font-weight: 800; }
    .code-500 { background: #fef2f2; color: #b91c1c; font-weight: 800; border: 1px solid #fca5a5; }

    /* Journey Drawer styles */
    .al-drawer-row { background: #f8fafc; }
    .al-drawer-header {
        padding: 12px 18px; background: #f1f5f9; border-radius: 8px 8px 0 0; border: 1px solid #e2e8f0; border-bottom: 0;
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;
    }
    .al-drawer-timeline {
        padding: 16px; background: #fff; border: 1px solid #e2e8f0; border-radius: 0 0 8px 8px;
        display: flex; flex-direction: column; gap: 12px; max-height: 550px; overflow-y: auto;
    }
    .al-step-card {
        padding: 14px 16px; border-radius: 10px; border: 1px solid #e2e8f0; background: #fff;
        box-shadow: 0 1px 2px rgba(0,0,0,.03); transition: border-color .15s ease;
    }
    .al-step-card.is-error {
        border-color: #fca5a5; background: #fffafb;
    }
    .al-step-head {
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 8px;
    }
    .al-step-url {
        font-family: monospace; font-size: .84rem; color: #0f172a; word-break: break-all;
    }

    /* Error Alert Box */
    .al-error-box {
        margin-top: 10px; padding: 12px 14px; border-radius: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-size: .83rem;
    }
    .al-error-msg { font-weight: 800; margin-bottom: 6px; font-size: .86rem; word-break: break-word; }
    .al-error-meta { font-family: monospace; font-size: .76rem; color: #b91c1c; margin-bottom: 8px; }
    .al-stack-trace {
        font-family: monospace; font-size: .72rem; background: #1e293b; color: #f8fafc; padding: 10px 12px;
        border-radius: 6px; max-height: 180px; overflow-y: auto; white-space: pre-wrap; line-height: 1.4;
    }

    /* JSON Details Accordion */
    .al-json-toggle {
        background: transparent; border: 0; color: #2563eb; font-size: .78rem; font-weight: 700; cursor: pointer; padding: 0; margin-top: 6px; display: inline-flex; align-items: center; gap: 4px;
    }
    .al-json-toggle:hover { text-decoration: underline; }
    .al-json-content {
        display: none; margin-top: 8px; font-family: monospace; font-size: .74rem; background: #f8fafc; border: 1px solid #cbd5e1;
        padding: 10px; border-radius: 6px; max-height: 220px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;
    }

    /* Pagination */
    .al-foot { padding: 14px 20px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .al-foot ul { list-style: none; display: flex; gap: 4px; padding: 0; margin: 0; }
    .al-foot li > a, .al-foot li > span {
        display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px;
        padding: 0 8px; border-radius: 7px; border: 1px solid #cbd5e1; color: #334155; text-decoration: none; font-weight: 600; font-size: .82rem;
    }
    .al-foot li.active > span, .al-foot li > a:hover { background: #2563eb; border-color: #2563eb; color: #fff; }

    /* Modal Backdrop & Box */
    .al-modal-overlay {
        position: fixed; inset: 0; background: rgba(15,23,42,.6); backdrop-filter: blur(2px);
        display: none; align-items: center; justify-content: center; z-index: 9999; padding: 20px;
    }
    .al-modal-overlay.open { display: flex; }
    .al-modal {
        background: #fff; border-radius: 14px; max-width: 540px; width: 100%; box-shadow: 0 20px 25px -5px rgba(0,0,0,.2);
        overflow: hidden; border: 1px solid #e2e8f0; animation: alModalIn .2s ease-out;
    }
    @keyframes alModalIn { from { opacity: 0; transform: scale(.95); } to { opacity: 1; transform: scale(1); } }
    .al-modal-head {
        padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; font-weight: 800; font-size: 1.05rem; color: #0f172a;
    }
    .al-modal-body { padding: 20px; }
    .al-modal-foot { padding: 14px 20px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px; }
</style>

<div class="al">

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="al-alert-banner al-alert-success">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="al-alert-banner al-alert-error">
            <span>⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Top Header --}}
    <div class="al-header">
        <div>
            <h3>
                <span>🛡️ Error &amp; Activity Log Monitor</span>
            </h3>
            <p style="margin:4px 0 0 0; font-size:.84rem; color:#64748b;">
                Monitoring errors and HTTP request journeys from <code>admin_hystLogs.activity_logs</code>
            </p>
        </div>

        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            @if($totalErrors > 0)
                <div class="al-live">
                    <span class="dot"></span>
                    <span>{{ number_format($totalErrors) }} Total Errors Recorded</span>
                </div>
            @else
                <div class="al-live green">
                    <span class="dot"></span>
                    <span>System Healthy (0 Errors)</span>
                </div>
            @endif

            <button type="button" class="al-btn al-btn-danger al-btn-sm" onclick="openPurgeModal()">
                🗑️ Purge Old Logs
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="al-stats">
        <div class="al-stat">
            <div class="al-icon bg-blue">📋</div>
            <div>
                <div class="al-label">Total Logs</div>
                <div class="al-value">{{ number_format($totalLogs) }}</div>
            </div>
        </div>

        <div class="al-stat">
            <div class="al-icon bg-red">🚨</div>
            <div>
                <div class="al-label">Total Errors</div>
                <div class="al-value" style="color:#dc2626;">{{ number_format($totalErrors) }}</div>
            </div>
        </div>

        <div class="al-stat">
            <div class="al-icon bg-amber">⚡</div>
            <div>
                <div class="al-label">Today's Errors</div>
                <div class="al-value" style="color:#d97706;">{{ number_format($todayErrors) }}</div>
            </div>
        </div>

        <div class="al-stat">
            <div class="al-icon bg-purple">💥</div>
            <div>
                <div class="al-label">500 Server Crashes</div>
                <div class="al-value" style="color:#7c3aed;">{{ number_format($total500Errors) }}</div>
            </div>
        </div>

        <div class="al-stat">
            <div class="al-icon bg-emerald">🌐</div>
            <div>
                <div class="al-label">Unique IPs</div>
                <div class="al-value">{{ number_format($uniqueIpsCount) }}</div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="al-card">
        <div class="al-card-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <span>🔍 Search &amp; Filter Logs</span>
            </div>

            {{-- Quick Filter Pills --}}
            <div style="display:flex; gap:8px;">
                <a href="{{ route('admin.activity-logs.index') }}" class="al-btn al-btn-light al-btn-sm">
                    All Logs
                </a>
                <a href="{{ route('admin.activity-logs.index', ['status' => 'failed']) }}" class="al-btn al-btn-danger al-btn-sm">
                    🚨 Only Errors
                </a>
                <a href="{{ route('admin.activity-logs.index', ['status_code' => 500]) }}" class="al-btn al-btn-sm" style="background:#7c3aed; color:#fff;">
                    💥 500 Errors
                </a>
            </div>
        </div>

        <div class="al-card-body">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}">
                <div class="al-filter-grid">

                    <div class="al-field">
                        <label>From Date</label>
                        <input type="date" name="from" value="{{ request('from') }}">
                    </div>

                    <div class="al-field">
                        <label>To Date</label>
                        <input type="date" name="to" value="{{ request('to') }}">
                    </div>

                    <div class="al-field">
                        <label>Status</label>
                        <select name="status">
                            <option value="">All Statuses</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>🚨 Failed / Errors Only</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>🟢 Success Only</option>
                        </select>
                    </div>

                    <div class="al-field">
                        <label>HTTP Code</label>
                        <input type="number" name="status_code" placeholder="e.g. 500, 404, 403" value="{{ request('status_code') }}">
                    </div>

                    <div class="al-field">
                        <label>User ID</label>
                        <input type="text" name="user" placeholder="User ID" value="{{ request('user') }}">
                    </div>

                    <div class="al-field">
                        <label>User Name</label>
                        <input type="text" name="user_name" placeholder="User name" value="{{ request('user_name') }}">
                    </div>

                    <div class="al-field">
                        <label>IP Address</label>
                        <input type="text" name="ip" placeholder="e.g. 192.168.1.1" value="{{ request('ip') }}">
                    </div>

                    <div class="al-field">
                        <label>Module</label>
                        <input type="text" name="module" placeholder="e.g. ADMIN, API, ORDERS" value="{{ request('module') }}">
                    </div>

                    <div class="al-field">
                        <label>Keyword / URL</label>
                        <input type="text" name="search" placeholder="Search message, URL, trace" value="{{ request('search') }}">
                    </div>

                </div>

                <div style="display:flex; gap:10px; align-items:center;">
                    <button type="submit" class="al-btn al-btn-primary">
                        🔍 Apply Filters
                    </button>
                    <a href="{{ route('admin.activity-logs.index') }}" class="al-btn al-btn-light">
                        🔄 Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Journey / Flat View Tabs Header --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px;">
        <div class="al-view-toggle">
            <button type="button" id="btnToggleJourneys" class="al-view-btn active" onclick="switchView('journeys')">
                🗺️ IP Journeys View
            </button>
            <button type="button" id="btnToggleFlat" class="al-view-btn" onclick="switchView('flat')">
                📑 All Logs &amp; Errors Table ({{ number_format($logs->total()) }})
            </button>
        </div>

        <div style="font-size:.82rem; color:#64748b; font-weight:600;">
            Showing {{ number_format($uniqueJourneys->total()) }} unique visitor IP journeys
        </div>
    </div>

    {{-- =========================================================
         VIEW 1: IP JOURNEYS VIEW (Click-by-click history & errors)
         ========================================================= --}}
    <div id="viewJourneys" class="al-card">
        <div class="al-table-wrap">
            <table class="al-table">
                <thead>
                    <tr>
                        <th>IP ADDRESS</th>
                        <th>TOTAL REQUESTS</th>
                        <th>ERROR / FAILURE STATUS</th>
                        <th>FIRST SEEN</th>
                        <th>LAST ACTIVE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($uniqueJourneys as $visitor)
                        @php
                            $ip = $visitor->ip_address;
                            $ipLogs = $logsByIp[$ip] ?? collect();
                            $errorCount = (int) $visitor->total_errors;
                            $drawerId = 'journey-drawer-' . $loop->index;
                        @endphp
                        <tr>
                            <td>
                                <strong style="font-family:monospace; color:#0f172a; font-size:.92rem;">{{ $ip }}</strong>
                            </td>
                            <td>
                                <span class="al-badge" style="background:#f1f5f9; color:#334155; font-size:.82rem;">
                                    {{ $visitor->total_requests }} requests
                                </span>
                            </td>
                            <td>
                                @if($errorCount > 0)
                                    <span class="al-badge status-failed" style="font-size:.8rem; padding:4px 10px;">
                                        🚨 {{ $errorCount }} Error(s) Detected
                                    </span>
                                @else
                                    <span class="al-badge status-success" style="font-size:.8rem; padding:4px 10px;">
                                        🟢 Clean (0 Errors)
                                    </span>
                                @endif
                            </td>
                            <td style="font-size:.82rem; color:#64748b;">
                                {{ $visitor->first_seen ? \Carbon\Carbon::parse($visitor->first_seen)->format('M d, H:i') : '—' }}
                            </td>
                            <td style="font-size:.82rem; color:#64748b;">
                                {{ $visitor->last_active ? \Carbon\Carbon::parse($visitor->last_active)->diffForHumans() : '—' }}
                            </td>
                            <td>
                                <button type="button"
                                        class="al-btn al-btn-light al-btn-sm"
                                        onclick="toggleDrawer('{{ $drawerId }}', this)">
                                    🔍 View Journey ({{ $ipLogs->count() }})
                                </button>
                            </td>
                        </tr>

                        {{-- Expanded Journey Drawer for this IP --}}
                        <tr id="{{ $drawerId }}" class="al-drawer-row" style="display:none;">
                            <td colspan="6" style="padding:16px;">
                                <div class="al-drawer-header">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="font-size:1.1rem;">⏱️</span>
                                        <strong>Chronological Browsing History &amp; Error Log for IP:</strong>
                                        <code style="background:#e2e8f0; padding:2px 8px; border-radius:5px; color:#0f172a;">{{ $ip }}</code>
                                    </div>
                                    <div style="font-size:.82rem; color:#64748b;">
                                        Total Logged: {{ $ipLogs->count() }} action(s)
                                    </div>
                                </div>

                                <div class="al-drawer-timeline">
                                    @forelse($ipLogs as $step)
                                        @php
                                            $resp = is_array($step->response) ? $step->response : (json_decode($step->response, true) ?? []);
                                            $payload = is_array($step->payload) ? $step->payload : (json_decode($step->payload, true) ?? []);
                                            $statusCode = $resp['status_code'] ?? 200;
                                            $isFailed = $step->status !== 'success' || $statusCode >= 400;
                                            $errorInfo = $resp['error'] ?? null;
                                            $jsonId = 'json-step-' . $step->id;
                                        @endphp
                                        <div class="al-step-card {{ $isFailed ? 'is-error' : '' }}">
                                            <div class="al-step-head">
                                                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                                    {{-- Timestamp --}}
                                                    <span style="font-size:.78rem; font-weight:700; color:#64748b;">
                                                        {{ $step->created_at ? $step->created_at->format('M d, H:i:s') : '—' }}
                                                    </span>

                                                    {{-- Method Badge --}}
                                                    <span class="al-badge al-badge-method method-{{ strtoupper($step->action) }}">
                                                        {{ strtoupper($step->action) }}
                                                    </span>

                                                    {{-- Status Code Badge --}}
                                                    <span class="al-badge {{ $statusCode >= 500 ? 'code-500' : ($statusCode >= 400 ? 'code-404' : 'code-200') }}">
                                                        HTTP {{ $statusCode }}
                                                    </span>

                                                    {{-- Module Badge --}}
                                                    @if($step->module)
                                                        <span class="al-badge" style="background:#e2e8f0; color:#334155;">
                                                            {{ $step->module }}
                                                        </span>
                                                    @endif

                                                    {{-- User Badge --}}
                                                    @if($step->user_id)
                                                        <span class="al-badge" style="background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">
                                                            👤 {{ $users[$step->user_id] ?? ('User #' . $step->user_id) }}
                                                        </span>
                                                    @endif
                                                </div>

                                                {{-- Single Delete Form --}}
                                                <form method="POST" action="{{ route('admin.activity-logs.destroy', $step->id) }}" onsubmit="return confirm('Delete this log entry #{{ $step->id }}?');" style="margin:0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="al-btn al-btn-sm" style="background:transparent; color:#94a3b8; padding:2px 6px; font-size:.72rem;" title="Delete this log record">
                                                        ✕ Delete
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- URL or Description --}}
                                            <div class="al-step-url">
                                                {{ $payload['url'] ?? $step->description }}
                                            </div>

                                            {{-- Prominent Error Box if Failed --}}
                                            @if($isFailed)
                                                <div class="al-error-box">
                                                    <div class="al-error-msg">
                                                        ⚠️ {{ $errorInfo['message'] ?? ($resp['message'] ?? 'Request Failed with HTTP ' . $statusCode) }}
                                                    </div>

                                                    @if(!empty($errorInfo['class']) || !empty($errorInfo['file']))
                                                        <div class="al-error-meta">
                                                            <strong>Exception:</strong> {{ $errorInfo['class'] ?? 'Error' }} in <code>{{ $errorInfo['file'] ?? '' }}:{{ $errorInfo['line'] ?? '' }}</code>
                                                        </div>
                                                    @endif

                                                    @if(!empty($errorInfo['trace']))
                                                        <div style="font-weight:700; font-size:.75rem; margin-bottom:4px; text-transform:uppercase;">Stack Trace:</div>
                                                        <div class="al-stack-trace">
@foreach($errorInfo['trace'] as $idx => $t)
#{{ $idx }} {{ $t['file'] ?? '' }}:{{ $t['line'] ?? '' }} -> {{ $t['class'] ?? '' }}{{ $t['function'] ? '::'.$t['function'].'()' : '' }}
@endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            {{-- Foldable JSON Inspector --}}
                                            <div>
                                                <button type="button" class="al-json-toggle" onclick="toggleJson('{{ $jsonId }}')">
                                                    ▶ View Request Payload &amp; Response Details
                                                </button>
                                                <div id="{{ $jsonId }}" class="al-json-content">
<strong>REQUEST PAYLOAD:</strong>
{{ json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}

<strong>RESPONSE:</strong>
{{ json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div style="padding:20px; text-align:center; color:#94a3b8; font-size:.85rem;">
                                            No detailed history found for this IP.
                                        </div>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:48px 20px; color:#94a3b8;">
                                <div style="font-size:32px; margin-bottom:10px;">🔍</div>
                                <div style="font-size:15px; font-weight:700; color:#475569;">No visitor journeys found</div>
                                <div style="font-size:13px; color:#94a3b8; margin-top:4px;">Try adjusting your search filters above.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="al-foot">
            <div style="font-size:.82rem; color:#64748b; font-weight:600;">
                Showing {{ $uniqueJourneys->firstItem() ?? 0 }} to {{ $uniqueJourneys->lastItem() ?? 0 }} of {{ number_format($uniqueJourneys->total()) }} unique IP journeys
            </div>
            <div>
                {{ $uniqueJourneys->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    {{-- =========================================================
         VIEW 2: RAW FLAT LOGS TABLE (with bulk delete checkboxes)
         ========================================================= --}}
    <div id="viewFlat" class="al-card" style="display:none;">
        <form method="POST" action="{{ route('admin.activity-logs.bulk-delete') }}" onsubmit="return confirm('Delete all selected logs?');">
            @csrf
            @method('DELETE')

            <div style="padding:14px 20px; background:#f8fafc; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <label style="font-size:.84rem; font-weight:700; display:flex; align-items:center; gap:6px; cursor:pointer;">
                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)"> Select All On Page
                    </label>
                </div>
                <div>
                    <button type="submit" id="btnBulkDelete" class="al-btn al-btn-danger al-btn-sm" disabled>
                        🗑️ Delete Selected
                    </button>
                </div>
            </div>

            <div class="al-table-wrap">
                <table class="al-table">
                    <thead>
                        <tr>
                            <th style="width:40px;"></th>
                            <th>ID</th>
                            <th>IP ADDRESS</th>
                            <th>USER</th>
                            <th>METHOD</th>
                            <th>STATUS</th>
                            <th>URL / DESCRIPTION</th>
                            <th>DATE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            @php
                                $resp = is_array($log->response) ? $log->response : (json_decode($log->response, true) ?? []);
                                $payload = is_array($log->payload) ? $log->payload : (json_decode($log->payload, true) ?? []);
                                $statusCode = $resp['status_code'] ?? 200;
                                $isFailed = $log->status !== 'success' || $statusCode >= 400;
                                $rawJsonId = 'raw-json-' . $log->id;
                            @endphp
                            <tr style="{{ $isFailed ? 'background:#fffafb;' : '' }}">
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $log->id }}" class="log-checkbox" onchange="updateBulkButton()">
                                </td>
                                <td>
                                    <span style="font-family:monospace; font-size:.8rem; color:#64748b;">#{{ $log->id }}</span>
                                </td>
                                <td>
                                    <strong style="font-family:monospace; font-size:.84rem;">{{ $log->ip_address }}</strong>
                                </td>
                                <td>
                                    @if($log->user_id)
                                        <span class="al-badge" style="background:#eff6ff; color:#1d4ed8;">
                                            {{ $users[$log->user_id] ?? ('User #' . $log->user_id) }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8; font-size:.8rem;">Guest</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="al-badge al-badge-method method-{{ strtoupper($log->action) }}">
                                        {{ strtoupper($log->action) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="al-badge {{ $statusCode >= 500 ? 'code-500' : ($statusCode >= 400 ? 'code-404' : 'code-200') }}">
                                        HTTP {{ $statusCode }}
                                    </span>
                                    @if($isFailed)
                                        <span class="al-badge status-failed">Failed</span>
                                    @else
                                        <span class="al-badge status-success">Success</span>
                                    @endif
                                </td>
                                <td style="max-width:320px;">
                                    <div style="font-family:monospace; font-size:.8rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $payload['url'] ?? $log->description }}">
                                        {{ $payload['url'] ?? $log->description }}
                                    </div>
                                    @if($isFailed && !empty($resp['error']['message']))
                                        <div style="font-size:.76rem; color:#dc2626; font-weight:700; margin-top:2px;">
                                            ⚠️ {{ Str::limit($resp['error']['message'], 60) }}
                                        </div>
                                    @endif
                                </td>
                                <td style="font-size:.8rem; color:#64748b; white-space:nowrap;">
                                    {{ $log->created_at ? $log->created_at->format('M d, H:i') : '—' }}
                                </td>
                                <td style="white-space:nowrap;">
                                    <button type="button" class="al-btn al-btn-light al-btn-sm" onclick="toggleJson('{{ $rawJsonId }}')">
                                        Inspect
                                    </button>
                                </td>
                            </tr>
                            <tr id="{{ $rawJsonId }}" style="display:none; background:#f8fafc;">
                                <td colspan="9" style="padding:16px;">
                                    @if($isFailed && !empty($resp['error']))
                                        <div class="al-error-box" style="margin-top:0; margin-bottom:12px;">
                                            <div class="al-error-msg">⚠️ {{ $resp['error']['message'] ?? 'Error' }}</div>
                                            @if(!empty($resp['error']['class']) || !empty($resp['error']['file']))
                                                <div class="al-error-meta">{{ $resp['error']['class'] ?? '' }} in {{ $resp['error']['file'] ?? '' }}:{{ $resp['error']['line'] ?? '' }}</div>
                                            @endif
                                            @if(!empty($resp['error']['trace']))
                                                <div class="al-stack-trace">
@foreach($resp['error']['trace'] as $idx => $t)
#{{ $idx }} {{ $t['file'] ?? '' }}:{{ $t['line'] ?? '' }} -> {{ $t['class'] ?? '' }}{{ $t['function'] ? '::'.$t['function'].'()' : '' }}
@endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                                        <div>
                                            <strong style="font-size:.78rem; color:#475569;">PAYLOAD:</strong>
                                            <pre class="al-stack-trace" style="background:#0f172a;">{{ json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                        <div>
                                            <strong style="font-size:.78rem; color:#475569;">RESPONSE:</strong>
                                            <pre class="al-stack-trace" style="background:#0f172a;">{{ json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center; padding:40px; color:#94a3b8;">
                                    No activity logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="al-foot">
                <div style="font-size:.82rem; color:#64748b; font-weight:600;">
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ number_format($logs->total()) }} log records
                </div>
                <div>
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </form>
    </div>

</div>

{{-- =========================================================
     PURGE LOGS MODAL
     ========================================================= --}}
<div id="purgeModal" class="al-modal-overlay">
    <div class="al-modal">
        <form method="POST" action="{{ route('admin.activity-logs.purge') }}" onsubmit="return confirm('Are you sure you want to delete these logs? This action cannot be undone.');">
            @csrf

            <div class="al-modal-head">
                <span>🗑️ Purge &amp; Delete Activity Logs</span>
                <button type="button" onclick="closePurgeModal()" style="background:transparent; border:0; font-size:1.2rem; cursor:pointer; color:#94a3b8;">✕</button>
            </div>

            <div class="al-modal-body">
                <p style="font-size:.85rem; color:#64748b; margin-top:0; margin-bottom:16px;">
                    Select how you would like to purge logs from the database <code>admin_hystLogs.activity_logs</code>:
                </p>

                <div style="display:flex; flex-direction:column; gap:14px;">
                    <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer; font-size:.88rem; font-weight:600;">
                        <input type="radio" name="purge_type" value="days" checked onchange="togglePurgeOptions(this.value)">
                        <div>
                            <div>Delete logs older than X days</div>
                            <div style="font-size:.76rem; color:#94a3b8; font-weight:400;">Cleans out old records while preserving recent logs</div>
                            <div id="purgeDaysInput" style="margin-top:8px;">
                                <input type="number" name="days" value="30" min="1" max="365" style="width:120px; padding:6px 10px; border-radius:6px; border:1px solid #cbd5e1; font-size:.86rem;"> days
                            </div>
                        </div>
                    </label>

                    <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer; font-size:.88rem; font-weight:600;">
                        <input type="radio" name="purge_type" value="only_success" onchange="togglePurgeOptions(this.value)">
                        <div>
                            <div>Delete only SUCCESS logs (Keep all Errors)</div>
                            <div style="font-size:.76rem; color:#94a3b8; font-weight:400;">Frees database storage while keeping 100% of error history</div>
                        </div>
                    </label>

                    <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer; font-size:.88rem; font-weight:600;">
                        <input type="radio" name="purge_type" value="date_range" onchange="togglePurgeOptions(this.value)">
                        <div>
                            <div>Delete logs within a specific date range</div>
                            <div id="purgeRangeInputs" style="display:none; margin-top:8px; gap:8px;">
                                <input type="date" name="purge_from" style="padding:6px 10px; border-radius:6px; border:1px solid #cbd5e1; font-size:.86rem;">
                                <span style="align-self:center;">to</span>
                                <input type="date" name="purge_to" style="padding:6px 10px; border-radius:6px; border:1px solid #cbd5e1; font-size:.86rem;">
                            </div>
                        </div>
                    </label>

                    <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer; font-size:.88rem; font-weight:600; color:#dc2626;">
                        <input type="radio" name="purge_type" value="all" onchange="togglePurgeOptions(this.value)">
                        <div>
                            <div>⚠️ Purge ALL logs completely</div>
                            <div style="font-size:.76rem; color:#dc2626; font-weight:400;">Deletes every single record in activity_logs</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="al-modal-foot">
                <button type="button" class="al-btn al-btn-light" onclick="closePurgeModal()">Cancel</button>
                <button type="submit" class="al-btn al-btn-danger">Confirm &amp; Purge</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchView(mode) {
        const vJourneys = document.getElementById('viewJourneys');
        const vFlat = document.getElementById('viewFlat');
        const bJourneys = document.getElementById('btnToggleJourneys');
        const bFlat = document.getElementById('btnToggleFlat');

        if (mode === 'journeys') {
            vJourneys.style.display = 'block';
            vFlat.style.display = 'none';
            bJourneys.classList.add('active');
            bFlat.classList.remove('active');
        } else {
            vJourneys.style.display = 'none';
            vFlat.style.display = 'block';
            bJourneys.classList.remove('active');
            bFlat.classList.add('active');
        }
    }

    function toggleDrawer(id, btn) {
        const row = document.getElementById(id);
        if (!row) return;
        const isHidden = row.style.display === 'none' || row.style.display === '';
        row.style.display = isHidden ? 'table-row' : 'none';
        if (btn) {
            btn.innerText = isHidden ? '▲ Hide Journey' : '🔍 View Journey';
        }
    }

    function toggleJson(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = (el.style.display === 'block') ? 'none' : 'block';
    }

    function openPurgeModal() {
        document.getElementById('purgeModal').classList.add('open');
    }

    function closePurgeModal() {
        document.getElementById('purgeModal').classList.remove('open');
    }

    function togglePurgeOptions(type) {
        const daysDiv = document.getElementById('purgeDaysInput');
        const rangeDiv = document.getElementById('purgeRangeInputs');
        if (daysDiv) daysDiv.style.display = (type === 'days') ? 'block' : 'none';
        if (rangeDiv) rangeDiv.style.display = (type === 'date_range') ? 'flex' : 'none';
    }

    function toggleSelectAll(master) {
        const boxes = document.querySelectorAll('.log-checkbox');
        boxes.forEach(b => b.checked = master.checked);
        updateBulkButton();
    }

    function updateBulkButton() {
        const checkedCount = document.querySelectorAll('.log-checkbox:checked').length;
        const btn = document.getElementById('btnBulkDelete');
        if (btn) {
            btn.disabled = checkedCount === 0;
            btn.innerText = checkedCount > 0 ? `🗑️ Delete Selected (${checkedCount})` : '🗑️ Delete Selected';
        }
    }
</script>

@endsection
