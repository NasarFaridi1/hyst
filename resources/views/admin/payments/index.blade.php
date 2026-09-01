@extends('layouts.app')

@section('content')

<style>
    /* Payment Report Custom Dashboard Styles */
    .pr-container * { box-sizing: border-box; }
    .pr-container { padding: 10px 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    
    .pr-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
    .pr-header h1 { font-size: 2.25rem; font-weight: 800; color: #111827; margin: 0; }
    .pr-header p { color: #6B7280; margin-top: 4px; font-size: 0.95rem; }

    .pr-badge-live {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px;
        background: #DEF7EC; color: #03543F; font-weight: 700; border-radius: 9999px; font-size: 0.85rem;
    }
    .pr-badge-live .dot {
        width: 8px; height: 8px; border-radius: 50%; background: #0E9F6E;
        box-shadow: 0 0 0 0 rgba(14, 159, 110, 0.7); animation: pulse-live 1.8s infinite;
    }
    @keyframes pulse-live {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(14, 159, 110, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(14, 159, 110, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(14, 159, 110, 0); }
    }

    /* KPI Summary Cards Grid */
    .pr-stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .pr-card { background: #FFFFFF; border-radius: 16px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #E5E7EB; }
    .pr-card-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6B7280; margin-bottom: 6px; }
    .pr-card-value { font-size: 1.75rem; font-weight: 800; color: #111827; margin: 0; line-height: 1.2; }
    .pr-card-sub { font-size: 0.8rem; color: #9CA3AF; margin-top: 6px; font-weight: 500; }

    .card-border-blue { border-top: 4px solid #2563EB; }
    .card-border-green { border-top: 4px solid #10B981; }
    .card-border-purple { border-top: 4px solid #8B5CF6; }
    .card-border-red { border-top: 4px solid #EF4444; }
    .card-border-yellow { border-top: 4px solid #F59E0B; }
    .card-border-indigo { border-top: 4px solid #6366F1; }

    /* Filter Form Box */
    .pr-filter-box { background: #FFFFFF; border-radius: 16px; padding: 20px; margin-bottom: 24px; border: 1px solid #E5E7EB; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .pr-filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 14px; margin-top: 14px; }
    .pr-filter-label { font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 4px; display: block; }
    .pr-input { width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #D1D5DB; font-size: 0.875rem; color: #111827; background: #F9FAFB; transition: border 0.15s; }
    .pr-input:focus { outline: none; border-color: #2563EB; background: #FFFFFF; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }

    /* Presets row */
    .pr-presets { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; align-items: center; }
    .pr-preset-btn { padding: 6px 14px; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; text-decoration: none; border: 1px solid #D1D5DB; background: #F3F4F6; color: #374151; transition: all 0.15s; }
    .pr-preset-btn:hover, .pr-preset-btn.active { background: #2563EB; color: #FFFFFF; border-color: #2563EB; }

    /* Navigation Tabs */
    .pr-tabs-bar { display: flex; gap: 8px; border-bottom: 2px solid #E5E7EB; margin-bottom: 24px; overflow-x: auto; }
    .pr-tab-btn { padding: 12px 20px; font-size: 0.95rem; font-weight: 700; color: #6B7280; background: none; border: none; border-bottom: 3px solid transparent; margin-bottom: -2px; cursor: pointer; white-space: nowrap; transition: all 0.15s; }
    .pr-tab-btn:hover { color: #111827; }
    .pr-tab-btn.active { color: #2563EB; border-bottom-color: #2563EB; }

    .pr-tab-content { display: none; }
    .pr-tab-content.active { display: block; }

    /* Tables */
    .pr-table-card { background: #FFFFFF; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); margin-bottom: 24px; }
    .pr-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem; }
    .pr-table th { background: #F9FAFB; padding: 14px 16px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #4B5563; border-bottom: 1px solid #E5E7EB; }
    .pr-table td { padding: 14px 16px; border-bottom: 1px solid #F3F4F6; color: #1F2937; }
    .pr-table tr:hover { background: #F9FAFB; }
    .pr-table tr:last-child td { border-bottom: none; }

    /* Status Badges */
    .badge-paid { background: #DEF7EC; color: #03543F; font-weight: 700; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; }
    .badge-pending { background: #FEF08A; color: #854D0E; font-weight: 700; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; }
    .badge-refunded { background: #F3E8FF; color: #6B21A8; font-weight: 700; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; }
    .badge-failed { background: #FDE8E8; color: #9B1C1C; font-weight: 700; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; }

    /* Charts Container */
    .pr-chart-card { background: #FFFFFF; border-radius: 16px; border: 1px solid #E5E7EB; padding: 20px; margin-bottom: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); }
    .pr-chart-box { position: relative; height: 320px; width: 100%; }

    /* Action Buttons */
    .btn-export { background: #10B981; color: #FFFFFF; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background 0.15s; }
    .btn-export:hover { background: #059669; }
    .btn-search { background: #2563EB; color: #FFFFFF; padding: 8px 18px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; font-size: 0.875rem; }
    .btn-search:hover { background: #1D4ED8; }
    .btn-reset { background: #6B7280; color: #FFFFFF; padding: 8px 18px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 0.875rem; }
    .btn-reset:hover { background: #4B5563; }

    /* Live Feed Item */
    .live-feed-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid #F3F4F6; }
    .live-feed-item:last-child { border-bottom: none; }
</style>

<div class="pr-container">

    <!-- Header Section -->
    <div class="pr-header">
        <div>
            <h1>Payment History & Production Report</h1>
            <p>Real-time payment analytics, date-wise reports, and restaurant breakdown</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="pr-badge-live">
                <span class="dot"></span> Real-Time Production Active
            </span>
            <a href="{{ route('admin.payments.export', request()->query()) }}" class="btn-export">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV Report
            </a>
        </div>
    </div>

    <!-- Production KPI Summary Cards -->
    <div class="pr-stats-grid">

        <div class="pr-card card-border-blue">
            <div class="pr-card-title">Gross Revenue</div>
            <div class="pr-card-value">£{{ number_format($totalGrossAmount, 2) }}</div>
            <div class="pr-card-sub">{{ number_format($totalTransactions) }} Total Transactions</div>
        </div>

        <div class="pr-card card-border-green">
            <div class="pr-card-title">Net Revenue</div>
            <div class="pr-card-value">£{{ number_format($netRevenue, 2) }}</div>
            <div class="pr-card-sub">After £{{ number_format($totalRefunded, 2) }} Refunds</div>
        </div>

        <div class="pr-card card-border-indigo">
            <div class="pr-card-title">Successful Payments</div>
            <div class="pr-card-value">£{{ number_format($paidAmount, 2) }}</div>
            <div class="pr-card-sub">{{ number_format($paidCount) }} Paid Orders</div>
        </div>

        <div class="pr-card card-border-yellow">
            <div class="pr-card-title">Pending / Unpaid</div>
            <div class="pr-card-value">£{{ number_format($pendingAmount, 2) }}</div>
            <div class="pr-card-sub">{{ number_format($pendingCount) }} Pending Payments</div>
        </div>

        <div class="pr-card card-border-red">
            <div class="pr-card-title">Refunded Total</div>
            <div class="pr-card-value">£{{ number_format($totalRefunded, 2) }}</div>
            <div class="pr-card-sub">Processed Refunds</div>
        </div>

        <div class="pr-card card-border-purple">
            <div class="pr-card-title">Today's Live Production</div>
            <div class="pr-card-value" id="kpiTodayVolume">£{{ number_format($todayLiveVolume, 2) }}</div>
            <div class="pr-card-sub" id="kpiTodayCount">{{ $todayLiveCount }} Paid Today • Live</div>
        </div>

    </div>

    <!-- Filter Control Panel -->
    <div class="pr-filter-box">
        <div class="pr-presets">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mr-2">Quick Presets:</span>
            <a href="{{ route('admin.payments.index', array_merge(request()->except(['start_date', 'end_date', 'preset', 'page']), ['preset' => 'today'])) }}" class="pr-preset-btn {{ request('preset') == 'today' ? 'active' : '' }}">Today</a>
            <a href="{{ route('admin.payments.index', array_merge(request()->except(['start_date', 'end_date', 'preset', 'page']), ['preset' => 'yesterday'])) }}" class="pr-preset-btn {{ request('preset') == 'yesterday' ? 'active' : '' }}">Yesterday</a>
            <a href="{{ route('admin.payments.index', array_merge(request()->except(['start_date', 'end_date', 'preset', 'page']), ['preset' => 'this_week'])) }}" class="pr-preset-btn {{ request('preset') == 'this_week' ? 'active' : '' }}">This Week</a>
            <a href="{{ route('admin.payments.index', array_merge(request()->except(['start_date', 'end_date', 'preset', 'page']), ['preset' => 'this_month'])) }}" class="pr-preset-btn {{ request('preset') == 'this_month' ? 'active' : '' }}">This Month</a>
            <a href="{{ route('admin.payments.index', array_merge(request()->except(['start_date', 'end_date', 'preset', 'page']), ['preset' => 'last_30'])) }}" class="pr-preset-btn {{ request('preset') == 'last_30' ? 'active' : '' }}">Last 30 Days</a>
            <a href="{{ route('admin.payments.index') }}" class="pr-preset-btn {{ !request('preset') && !request('start_date') && !request('end_date') ? 'active' : '' }}">All Time / Reset</a>
        </div>

        <form method="GET" action="{{ route('admin.payments.index') }}">
            <div class="pr-filter-grid">

                <div>
                    <label class="pr-filter-label">From Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="pr-input">
                </div>

                <div>
                    <label class="pr-filter-label">To Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="pr-input">
                </div>

                <div>
                    <label class="pr-filter-label">Restaurant</label>
                    <select name="restaurant_id" class="pr-input">
                        <option value="">All Restaurants</option>
                        @foreach($restaurants as $rest)
                            <option value="{{ $rest->id }}" {{ $restaurantId == $rest->id ? 'selected' : '' }}>
                                {{ $rest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="pr-filter-label">Payment Status</label>
                    <select name="payment_status" class="pr-input">
                        <option value="">All Statuses</option>
                        <option value="paid" {{ $paymentStatus == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ $paymentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="refunded" {{ $paymentStatus == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        <option value="failed" {{ $paymentStatus == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <div>
                    <label class="pr-filter-label">Payment Method</label>
                    <select name="payment_method" class="pr-input">
                        <option value="">All Methods</option>
                        @foreach($availableMethods as $method)
                            <option value="{{ $method }}" {{ $paymentMethod == $method ? 'selected' : '' }}>
                                {{ ucfirst($method) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="pr-filter-label">Search Keyword</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Order ID, Tx ID, Customer..." class="pr-input">
                </div>

            </div>

            <div class="flex gap-3 mt-4 justify-end">
                <button type="submit" class="btn-search">Apply Filters</button>
                <a href="{{ route('admin.payments.index') }}" class="btn-reset">Reset All</a>
            </div>
        </form>
    </div>

    <!-- Navigation Tabs -->
    <div class="pr-tabs-bar">
        <button class="pr-tab-btn active" onclick="switchTab('history', this)">Payment History List ({{ $payments->total() }})</button>
        <button class="pr-tab-btn" onclick="switchTab('date-report', this)">Date-wise Production Report</button>
        <button class="pr-tab-btn" onclick="switchTab('restaurant-report', this)">Restaurant-wise Report</button>
        <button class="pr-tab-btn" onclick="switchTab('realtime-stream', this)">⚡ Real-Time Production Feed</button>
    </div>

    <!-- TAB 1: Payment History List -->
    <div id="tab-history" class="pr-tab-content active">
        <div class="pr-table-card">
            <div class="overflow-x-auto">
                <table class="pr-table">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Order ID</th>
                            <th>Restaurant</th>
                            <th>Customer</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Refunded</th>
                            <th>Status</th>
                            <th>Transaction Ref</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="font-bold">#{{ $payment->id }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="text-blue-600 font-bold hover:underline">
                                        #{{ $payment->order_id }}
                                    </a>
                                </td>
                                <td class="font-medium">{{ $payment->restaurant->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="font-semibold">{{ $payment->order->user->name ?? $payment->user->name ?? $payment->order->guest_name ?? 'Guest Customer' }}</div>
                                    <div class="text-xs text-gray-500">{{ $payment->order->user->email ?? $payment->user->email ?? $payment->order->guest_email ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-1 rounded">
                                        {{ ucfirst($payment->payment_method ?? 'N/A') }}
                                    </span>
                                </td>
                                <td class="font-extrabold text-gray-900">£{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @if(($payment->refunded_amount ?? 0) > 0)
                                        <span class="text-purple-700 font-bold">£{{ number_format($payment->refunded_amount, 2) }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payment->payment_status == 'paid')
                                        <span class="badge-paid">Paid</span>
                                    @elseif($payment->payment_status == 'pending')
                                        <span class="badge-pending">Pending</span>
                                    @elseif($payment->payment_status == 'refunded')
                                        <span class="badge-refunded">Refunded</span>
                                    @else
                                        <span class="badge-failed">{{ ucfirst($payment->payment_status) }}</span>
                                    @endif
                                </td>
                                <td class="text-xs text-gray-600 font-mono">
                                    {{ $payment->transaction_id ?? $payment->payment_transaction_id ?? '-' }}
                                </td>
                                <td class="text-xs text-gray-500">
                                    {{ $payment->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-12 text-gray-500 font-medium">
                                    No payment records match the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

    <!-- TAB 2: Date-wise Production Report -->
    <div id="tab-date-report" class="pr-tab-content">
        <!-- Daily Chart -->
        <div class="pr-chart-card">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Daily Revenue Trend</h3>
            <div class="pr-chart-box">
                <canvas id="dailyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Daily Data Table -->
        <div class="pr-table-card">
            <div class="p-4 border-b bg-gray-50 font-bold text-gray-700">Date-wise Summary Breakdown</div>
            <div class="overflow-x-auto">
                <table class="pr-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total Transactions</th>
                            <th>Paid Count</th>
                            <th>Gross Volume (£)</th>
                            <th>Paid Revenue (£)</th>
                            <th>Refunded (£)</th>
                            <th>Net Revenue (£)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dateWiseReport as $day)
                            <tr>
                                <td class="font-bold">{{ \Carbon\Carbon::parse($day->date)->format('d M Y (D)') }}</td>
                                <td>{{ number_format($day->total_count) }}</td>
                                <td><span class="badge-paid">{{ number_format($day->paid_count) }}</span></td>
                                <td class="font-semibold">£{{ number_format($day->gross_amount, 2) }}</td>
                                <td class="font-bold text-green-600">£{{ number_format($day->paid_amount, 2) }}</td>
                                <td class="text-purple-700">£{{ number_format($day->total_refunded, 2) }}</td>
                                <td class="font-extrabold text-blue-700">£{{ number_format($day->paid_amount - $day->total_refunded, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">No date-wise data available for this range.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 3: Restaurant-wise Report -->
    <div id="tab-restaurant-report" class="pr-tab-content">
        <!-- Restaurant Chart -->
        <div class="pr-chart-card">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Top Restaurants by Payment Revenue</h3>
            <div class="pr-chart-box">
                <canvas id="restaurantRevenueChart"></canvas>
            </div>
        </div>

        <!-- Restaurant Data Table -->
        <div class="pr-table-card">
            <div class="p-4 border-b bg-gray-50 font-bold text-gray-700">Restaurant Performance Breakdown</div>
            <div class="overflow-x-auto">
                <table class="pr-table">
                    <thead>
                        <tr>
                            <th>Restaurant Name</th>
                            <th>Total Transactions</th>
                            <th>Paid Orders</th>
                            <th>Gross Volume (£)</th>
                            <th>Successful Revenue (£)</th>
                            <th>Refunds (£)</th>
                            <th>Net Revenue (£)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($restaurantWiseReport as $restRow)
                            <tr>
                                <td class="font-bold text-gray-900">{{ $restRow->restaurant->name ?? 'Unknown Restaurant' }}</td>
                                <td>{{ number_format($restRow->total_count) }}</td>
                                <td><span class="badge-paid">{{ number_format($restRow->paid_count) }}</span></td>
                                <td>£{{ number_format($restRow->gross_amount, 2) }}</td>
                                <td class="font-bold text-green-600">£{{ number_format($restRow->paid_amount, 2) }}</td>
                                <td class="text-purple-700">£{{ number_format($restRow->total_refunded, 2) }}</td>
                                <td class="font-extrabold text-blue-700">£{{ number_format($restRow->paid_amount - $restRow->total_refunded, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">No restaurant payment data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 4: Real-Time Live Feed -->
    <div id="tab-realtime-stream" class="pr-tab-content">
        <div class="pr-card mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">⚡ Live Today's Production Stream</h3>
                <span class="text-xs text-gray-500" id="liveLastSync">Auto-refreshing every 15s</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-xl text-center">
                    <div class="text-xs text-gray-500 font-bold uppercase">Today Volume</div>
                    <div class="text-xl font-extrabold text-green-600" id="liveVolumeVal">£{{ number_format($todayLiveVolume, 2) }}</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl text-center">
                    <div class="text-xs text-gray-500 font-bold uppercase">Today Paid Count</div>
                    <div class="text-xl font-extrabold text-blue-600" id="liveCountVal">{{ $todayLiveCount }}</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl text-center">
                    <div class="text-xs text-gray-500 font-bold uppercase">Today Pending</div>
                    <div class="text-xl font-extrabold text-yellow-600" id="livePendingVal">{{ $pendingCount }}</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl text-center">
                    <div class="text-xs text-gray-500 font-bold uppercase">Today Refunded</div>
                    <div class="text-xl font-extrabold text-purple-600" id="liveRefundedVal">£{{ number_format($totalRefunded, 2) }}</div>
                </div>
            </div>

            <div class="border rounded-xl overflow-hidden bg-white">
                <div class="p-4 bg-gray-100 font-bold text-sm text-gray-700">Recent Transactions Feed</div>
                <div id="liveStreamContainer">
                    <div class="p-8 text-center text-gray-400">Loading live stream data...</div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function switchTab(tabName, btnElement) {
    document.querySelectorAll('.pr-tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.pr-tab-content').forEach(content => content.classList.remove('active'));

    btnElement.classList.add('active');
    document.getElementById('tab-' + tabName).classList.add('active');

    if (tabName === 'date-report' && !window.dailyChartRendered) {
        renderDailyChart();
    }
    if (tabName === 'restaurant-report' && !window.restaurantChartRendered) {
        renderRestaurantChart();
    }
    if (tabName === 'realtime-stream') {
        fetchRealtimeData();
    }
}

// Render Daily Revenue Chart
function renderDailyChart() {
    window.dailyChartRendered = true;
    const ctx = document.getElementById('dailyRevenueChart');
    if (!ctx) return;

    const labels = @json($dateWiseReport->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M')));
    const paidRevenue = @json($dateWiseReport->pluck('paid_amount'));
    const grossVolume = @json($dateWiseReport->pluck('gross_amount'));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.reverse(),
            datasets: [
                {
                    label: 'Paid Revenue (£)',
                    data: paidRevenue.reverse(),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 3
                },
                {
                    label: 'Gross Volume (£)',
                    data: grossVolume.reverse(),
                    borderColor: '#2563EB',
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    fill: false,
                    borderDash: [5, 5],
                    tension: 0.35,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

// Render Restaurant Revenue Chart
function renderRestaurantChart() {
    window.restaurantChartRendered = true;
    const ctx = document.getElementById('restaurantRevenueChart');
    if (!ctx) return;

    const restReport = @json($restaurantWiseReport);
    const labels = restReport.map(r => r.restaurant ? r.restaurant.name : 'Unknown');
    const revenues = restReport.map(r => parseFloat(r.paid_amount || 0));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Paid Revenue (£)',
                data: revenues,
                backgroundColor: '#2563EB',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

// Realtime AJAX Polling
function fetchRealtimeData() {
    const params = new URLSearchParams(window.location.search);
    fetch("{{ route('admin.payments.realtime') }}?" + params.toString())
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('liveVolumeVal').innerText = '£' + data.today_volume;
                document.getElementById('liveCountVal').innerText = data.today_count;
                document.getElementById('livePendingVal').innerText = data.today_pending;
                document.getElementById('liveRefundedVal').innerText = '£' + data.today_refunded;
                document.getElementById('kpiTodayVolume').innerText = '£' + data.today_volume;
                document.getElementById('kpiTodayCount').innerText = data.today_count + ' Paid Today • Live';
                document.getElementById('liveLastSync').innerText = 'Last updated: ' + data.timestamp;

                let feedHtml = '';
                if (data.recent_payments.length === 0) {
                    feedHtml = '<div class="p-6 text-center text-gray-500">No payment activity recorded yet today.</div>';
                } else {
                    data.recent_payments.forEach(item => {
                        let statusBadge = item.payment_status === 'paid' 
                            ? '<span class="badge-paid">Paid</span>' 
                            : '<span class="badge-pending">' + item.payment_status + '</span>';
                        
                        feedHtml += `
                            <div class="live-feed-item">
                                <div>
                                    <div class="font-bold text-gray-900">Order #${item.order_id} &bull; ${item.restaurant}</div>
                                    <div class="text-xs text-gray-500">${item.customer} &bull; ${item.payment_method}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-extrabold text-green-600">£${item.amount}</div>
                                    <div class="text-xs text-gray-400 mt-1">${statusBadge} &bull; ${item.time}</div>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('liveStreamContainer').innerHTML = feedHtml;
            }
        })
        .catch(err => console.error('Realtime fetch failed:', err));
}

// Auto poll every 15 seconds
setInterval(fetchRealtimeData, 15000);
</script>

@endsection
