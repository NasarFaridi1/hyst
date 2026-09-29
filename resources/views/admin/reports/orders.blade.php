@extends('layouts.app')

@section('content')
<div class="p-6 max-w-[1600px] mx-auto font-sans">
    
    <!-- ════════════════════════════════════════════════════════════
         TOP HEADER & ACTION BUTTONS
    ════════════════════════════════════════════════════════════ -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-[#C25A2A]"></span>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">System-Wide Order & Financial Reports</h1>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Real-time sales analytics, multi-restaurant revenue breakdowns, and transaction history for platform administrators.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.order_reports.export_pdf', request()->all()) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#C25A2A] text-white hover:bg-[#a84c22] text-xs font-semibold shadow transition">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Print / Save PDF Report
            </a>
        </div>
    </div>

    <!-- ════════════════════════════════════════════════════════════
         FILTER BAR SECTION
    ════════════════════════════════════════════════════════════ -->
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm mb-8">
        <form method="GET" action="{{ route('admin.order_reports.index') }}" class="space-y-4">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
                
                <!-- 1. Restaurant Filter -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Restaurant</label>
                    <select name="restaurant_id" onchange="this.form.submit();"
                            class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="all">All Restaurants</option>
                        @foreach($restaurants as $rest)
                            <option value="{{ $rest->id }}" {{ $restaurantId == $rest->id ? 'selected' : '' }}>
                                {{ $rest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Preset Date -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Date Preset</label>
                    <select name="preset" onchange="toggleCustomDates(this.value); this.form.submit();"
                            class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="today" {{ $datePreset == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ $datePreset == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="this_week" {{ $datePreset == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ $datePreset == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ $datePreset == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="last_30" {{ $datePreset == 'last_30' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="all_time" {{ $datePreset == 'all_time' ? 'selected' : '' }}>All Time</option>
                        <option value="custom" {{ $datePreset == 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                    </select>
                </div>

                <!-- 3. Start Date -->
                <div id="start_date_wrap" style="{{ $datePreset == 'custom' ? '' : 'display:none;' }}">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                           class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                </div>

                <!-- 4. End Date -->
                <div id="end_date_wrap" style="{{ $datePreset == 'custom' ? '' : 'display:none;' }}">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                           class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                </div>

                <!-- 5. Order Status -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Order Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="all">All Statuses</option>
                        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="delivered" {{ $status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ $status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="preparing" {{ $status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="out_for_delivery" {{ $status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- 6. Payment Status -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="all">All Payments</option>
                        <option value="paid" {{ $paymentStatus == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ $paymentStatus == 'pending' ? 'selected' : '' }}>Unpaid / Pending</option>
                        <option value="refunded" {{ $paymentStatus == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- 7. Order Type -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Order Type</label>
                    <select name="order_type" class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="all">All Types</option>
                        <option value="delivery" {{ $orderType == 'delivery' ? 'selected' : '' }}>Home Delivery</option>
                        <option value="takeaway" {{ $orderType == 'takeaway' ? 'selected' : '' }}>Takeaway</option>
                        <option value="dine_in" {{ $orderType == 'dine_in' ? 'selected' : '' }}>Dine In</option>
                    </select>
                </div>

                <!-- 8. Search -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Search Keyword</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="ID, Customer, Tx ID..."
                           class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                </div>

            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                <a href="{{ route('admin.order_reports.index') }}" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs font-semibold transition">
                    Reset Filters
                </a>
                <button type="submit" class="px-5 py-2 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-semibold transition shadow-sm">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- ════════════════════════════════════════════════════════════
         KPI CARDS OVERVIEW (5 Columns)
    ════════════════════════════════════════════════════════════ -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        
        <!-- 1. Total Orders -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-gray-400">Total Orders</span>
                <span class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                </span>
            </div>
            <p class="text-2xl font-black text-gray-900 mt-2">{{ number_format($totalOrders) }}</p>
            <div class="flex items-center gap-2 mt-3 text-[11px] font-medium text-gray-500">
                <span class="text-emerald-600 font-bold">✓ {{ $completedOrders }} Completed</span>
                <span>•</span>
                <span class="text-rose-500 font-bold">✕ {{ $cancelledOrders }} Cancelled</span>
            </div>
        </div>

        <!-- 2. Gross Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-gray-400">Gross Sales Revenue</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="pound-sterling" class="w-4 h-4"></i>
                </span>
            </div>
            <p class="text-2xl font-black text-emerald-600 mt-2">£{{ number_format($grossRevenue, 2) }}</p>
            <div class="mt-3 text-[11px] text-gray-500">
                Total All Orders Volume: <span class="font-bold text-gray-800">£{{ number_format($allOrdersTotal, 2) }}</span>
            </div>
        </div>

        <!-- 3. Average Order Value -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-gray-400">Average Order Value</span>
                <span class="p-2 rounded-xl bg-orange-50 text-[#C25A2A]">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </span>
            </div>
            <p class="text-2xl font-black text-gray-900 mt-2">£{{ number_format($avgOrderValue, 2) }}</p>
            <div class="mt-3 text-[11px] text-gray-500">
                Based on <span class="font-bold text-gray-800">{{ $completedOrders }}</span> completed orders
            </div>
        </div>

        <!-- 4. Total Delivery & Service Fees -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-gray-400">Delivery & Charges</span>
                <span class="p-2 rounded-xl bg-purple-50 text-purple-600">
                    <i data-lucide="truck" class="w-4 h-4"></i>
                </span>
            </div>
            <p class="text-2xl font-black text-gray-900 mt-2">£{{ number_format($totalDeliveryFees, 2) }}</p>
            <div class="mt-3 text-[11px] text-gray-500">
                Platform Charges: <span class="font-bold text-gray-800">£{{ number_format($totalServiceFees, 2) }}</span>
            </div>
        </div>

        <!-- 5. Discounts & Rewards -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-gray-400">Total Discounts</span>
                <span class="p-2 rounded-xl bg-rose-50 text-rose-600">
                    <i data-lucide="tag" class="w-4 h-4"></i>
                </span>
            </div>
            <p class="text-2xl font-black text-rose-600 mt-2">£{{ number_format($totalDiscounts, 2) }}</p>
            <div class="mt-3 text-[11px] text-gray-500">
                Coupons, Offers & Loyalty Discount Volume
            </div>
        </div>

    </div>

    <!-- ════════════════════════════════════════════════════════════
         TOP RESTAURANTS PERFORMANCE & DAILY TREND (2 Columns)
    ════════════════════════════════════════════════════════════ -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Top Performing Restaurants Table -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Top Restaurants Sales</h3>
                <span class="text-xs text-gray-400">By Revenue</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-700">
                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-[10px] border-b border-gray-200">
                        <tr>
                            <th class="p-3">Restaurant</th>
                            <th class="p-3 text-center">Orders</th>
                            <th class="p-3 text-right">Revenue (£)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($restaurantReport as $row)
                            <tr class="hover:bg-gray-50/50">
                                <td class="p-3 font-semibold text-gray-900">
                                    {{ $row->restaurant->name ?? 'Deleted Restaurant' }}
                                </td>
                                <td class="p-3 text-center font-bold text-gray-800">{{ number_format($row->total_orders) }}</td>
                                <td class="p-3 text-right font-black text-emerald-600">£{{ number_format($row->revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-6 text-center text-gray-400">No restaurant revenue data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daily Sales Trend Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Daily Sales & Order Trend</h3>
                <span class="text-xs text-gray-400">Recent {{ count($dateWiseReport) }} Days</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-700">
                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-[10px] border-b border-gray-200">
                        <tr>
                            <th class="p-3">Date</th>
                            <th class="p-3 text-center">Total Orders</th>
                            <th class="p-3 text-center">Completed</th>
                            <th class="p-3 text-center">Cancelled</th>
                            <th class="p-3 text-right">Revenue (£)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($dateWiseReport as $row)
                            <tr class="hover:bg-gray-50/50">
                                <td class="p-3 font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($row->date)->format('D, d M Y') }}
                                </td>
                                <td class="p-3 text-center font-bold text-gray-800">{{ number_format($row->total_orders) }}</td>
                                <td class="p-3 text-center text-emerald-600 font-bold">{{ number_format($row->completed_count) }}</td>
                                <td class="p-3 text-center text-rose-500 font-bold">{{ number_format($row->cancelled_count) }}</td>
                                <td class="p-3 text-right font-black text-gray-900">£{{ number_format($row->revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-400">No daily order data available for this range.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ════════════════════════════════════════════════════════════
         DETAILED ORDERS LEDGER TABLE
    ════════════════════════════════════════════════════════════ -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Detailed System Orders Ledger</h3>
                <p class="text-xs text-gray-500">Showing filtered order logs across all restaurants with payment details</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                Showing {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} Orders
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-[10px] border-b border-gray-200">
                    <tr>
                        <th class="p-4">Order ID</th>
                        <th class="p-4">Restaurant</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Date & Time</th>
                        <th class="p-4 text-center">Type</th>
                        <th class="p-4 text-center">Order Status</th>
                        <th class="p-4 text-center">Payment Status</th>
                        <th class="p-4">Payment Method</th>
                        <th class="p-4 text-right">Total Amount</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        @php
                            $cName = $order->is_guest ? ($order->guest_name ?? 'Guest') : ($order->user->name ?? 'N/A');
                            $cPhone = $order->is_guest ? ($order->guest_phone ?? 'N/A') : ($order->phone ?? $order->user->phone ?? 'N/A');
                            $payStatus = $order->payment ? $order->payment->payment_status : ($order->status == 'completed' ? 'paid' : 'pending');
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="p-4 font-black text-gray-900">
                                #{{ $order->id }}
                            </td>
                            <td class="p-4 font-bold text-gray-900">
                                {{ $order->restaurant->name ?? 'N/A' }}
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-gray-900">{{ $cName }}</div>
                                <div class="text-[11px] text-gray-500">{{ $cPhone }}</div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="font-medium text-gray-800">{{ $order->created_at ? $order->created_at->format('d M Y') : '' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $order->created_at ? $order->created_at->format('h:i A') : '' }}</div>
                            </td>
                            <td class="p-4 text-center">
                                @if(($order->order_type ?? '') == 'dine_in')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">🍽️ Dine In</span>
                                @elseif(($order->order_type ?? '') == 'takeaway')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">🛍️ Takeaway</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-50 text-[#C25A2A] border border-orange-200">🛵 Delivery</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($order->status == 'completed' || $order->status == 'delivered')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Completed</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Cancelled</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">{{ ucwords($order->status) }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($payStatus == 'paid')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Paid</span>
                                @elseif($payStatus == 'refunded')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Refunded</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800">Unpaid</span>
                                @endif
                            </td>
                            <td class="p-4 uppercase font-bold text-gray-700">
                                {{ $order->payment_method ?? 'Online' }}
                            </td>
                            <td class="p-4 text-right font-black text-gray-900 text-sm">
                                £{{ number_format($order->total_amount ?? 0, 2) }}
                            </td>
                            <td class="p-4 text-center">
                                <button type="button" onclick='openPaymentHistoryModal(@json($order))'
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-orange-50 hover:bg-orange-100 text-[#C25A2A] border border-orange-200 text-xs font-bold transition shadow-sm">
                                    <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                                    Payment History
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="p-10 text-center text-gray-400">
                                No order records found matching the specified filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-200 bg-gray-50/50">
            {{ $orders->links() }}
        </div>

    </div>

</div>

<!-- ════════════════════════════════════════════════════════════
     ORDER PAYMENT HISTORY INTERACTIVE MODAL
════════════════════════════════════════════════════════════ -->
<div id="paymentHistoryModal" class="fixed inset-0 bg-black/60 z-[9999] hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">
        <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-gray-50">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">💳</span>
                    <h3 class="text-lg font-bold text-gray-900" id="modalOrderId">Payment History</h3>
                </div>
                <p class="text-xs text-gray-500" id="modalOrderDate"></p>
            </div>
            <button type="button" onclick="closePaymentHistoryModal()" class="text-gray-400 hover:text-gray-700 text-xl font-bold p-1">✕</button>
        </div>
        
        <div class="p-6 overflow-y-auto space-y-6" id="modalPaymentBody">
            <!-- Dynamic Payment History populated via JS -->
        </div>

        <div class="p-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
            <span class="text-xs text-gray-500 font-medium">Hyst Payment Ledger Log</span>
            <button type="button" onclick="closePaymentHistoryModal()" class="px-5 py-2 rounded-xl bg-gray-900 text-white text-xs font-bold hover:bg-black transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function toggleCustomDates(val) {
        const start = document.getElementById('start_date_wrap');
        const end   = document.getElementById('end_date_wrap');
        if (val === 'custom') {
            start.style.display = 'block';
            end.style.display   = 'block';
        } else {
            start.style.display = 'none';
            end.style.display   = 'none';
        }
    }

    function openPaymentHistoryModal(order) {
        document.getElementById('modalOrderId').textContent = 'Payment History — Order #' + order.id;
        document.getElementById('modalOrderDate').textContent = 'Placed on ' + (order.created_at ? new Date(order.created_at).toLocaleString() : '');

        const customerName = order.is_guest ? (order.guest_name || 'Guest') : (order.user ? order.user.name : 'N/A');
        const customerPhone = order.is_guest ? (order.guest_phone || 'N/A') : (order.phone || (order.user ? order.user.phone : 'N/A'));
        const customerEmail = order.is_guest ? (order.guest_email || 'N/A') : (order.user ? order.user.email : 'N/A');

        const orderTotal = parseFloat(order.total_amount || 0).toFixed(2);
        const orderType = (order.order_type || 'delivery').replace('_', ' ').toUpperCase();
        const orderStatus = (order.status || 'pending').toUpperCase();
        const paymentMethod = (order.payment_method || 'Online').toUpperCase();
        const restaurantName = order.restaurant ? order.restaurant.name : 'N/A';

        // Payments list (either order.payments array or single order.payment)
        let paymentsList = [];
        if (order.payments && order.payments.length) {
            paymentsList = order.payments;
        } else if (order.payment) {
            paymentsList = [order.payment];
        }

        let totalCharged = 0;
        let totalRefunded = 0;
        let paymentsTableRows = '';

        if (paymentsList.length) {
            paymentsList.forEach((p, idx) => {
                const amt = parseFloat(p.amount || order.total_amount || 0);
                const ref = parseFloat(p.refunded_amount || 0);
                const status = (p.payment_status || 'paid').toLowerCase();
                
                if (status === 'paid') {
                    totalCharged += amt;
                }
                totalRefunded += ref;

                const payTxId = p.payment_transaction_id || p.transaction_id || 'N/A';
                const secTxId = p.secondary_transaction_id || 'N/A';
                const pDate   = p.created_at ? new Date(p.created_at).toLocaleString() : (order.created_at ? new Date(order.created_at).toLocaleString() : 'N/A');
                const pType   = (p.payment_type || 'Order Payment').toUpperCase();

                let statusBadge = '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">PAID</span>';
                if (status === 'refunded') {
                    statusBadge = '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">REFUNDED</span>';
                } else if (status === 'pending' || status === 'unpaid') {
                    statusBadge = '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">UNPAID</span>';
                }

                paymentsTableRows += `
                    <tr class="border-b border-gray-100 text-xs">
                        <td class="py-2.5 px-3 font-semibold text-gray-800">#${idx + 1}</td>
                        <td class="py-2.5 px-3 font-mono font-bold text-gray-900">${payTxId}</td>
                        <td class="py-2.5 px-3 font-mono text-gray-600">${secTxId}</td>
                        <td class="py-2.5 px-3 font-medium text-gray-600">${pType}</td>
                        <td class="py-2.5 px-3 text-gray-500">${pDate}</td>
                        <td class="py-2.5 px-3 text-center">${statusBadge}</td>
                        <td class="py-2.5 px-3 text-right font-black text-gray-900">£${amt.toFixed(2)}</td>
                    </tr>
                `;

                if (ref > 0) {
                    paymentsTableRows += `
                        <tr class="bg-rose-50/50 border-b border-rose-100 text-xs text-rose-800">
                            <td class="py-2 px-3">↳ Refund</td>
                            <td class="py-2 px-3 font-mono font-bold text-rose-700">${payTxId}</td>
                            <td class="py-2 px-3 font-mono text-rose-600">${secTxId}</td>
                            <td class="py-2 px-3 italic">Reason: ${p.refund_reason || 'Customer Refund'}</td>
                            <td class="py-2 px-3">${pDate}</td>
                            <td class="py-2 px-3 text-center"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-200 text-rose-900">REFUND</span></td>
                            <td class="py-2 px-3 text-right font-black text-rose-700">-£${ref.toFixed(2)}</td>
                        </tr>
                    `;
                }
            });
        } else {
            const amt = parseFloat(order.total_amount || 0);
            totalCharged = order.status === 'completed' || order.status === 'delivered' ? amt : 0;
            const statusBadge = order.status === 'completed' || order.status === 'delivered' 
                ? '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">PAID</span>'
                : '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">PENDING</span>';

            paymentsTableRows = `
                <tr class="border-b border-gray-100 text-xs">
                    <td class="py-2.5 px-3 font-semibold text-gray-800">#1</td>
                    <td class="py-2.5 px-3 font-mono font-bold text-gray-900">ORD-TX-${order.id}</td>
                    <td class="py-2.5 px-3 font-mono text-gray-400">N/A</td>
                    <td class="py-2.5 px-3 font-medium text-gray-600">${paymentMethod}</td>
                    <td class="py-2.5 px-3 text-gray-500">${order.created_at ? new Date(order.created_at).toLocaleString() : ''}</td>
                    <td class="py-2.5 px-3 text-center">${statusBadge}</td>
                    <td class="py-2.5 px-3 text-right font-black text-gray-900">£${amt.toFixed(2)}</td>
                </tr>
            `;
        }

        const netCollected = (totalCharged - totalRefunded).toFixed(2);

        let itemsHtml = '';
        if (order.items && order.items.length) {
            order.items.forEach(item => {
                const productName = item.product ? item.product.name : (item.product_name || 'Item');
                const price = parseFloat(item.price || 0).toFixed(2);
                itemsHtml += `
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100 text-xs">
                        <div>
                            <span class="font-medium text-gray-800">${productName}</span>
                            <span class="text-gray-400 ml-1">x${item.quantity || 1}</span>
                        </div>
                        <span class="font-semibold text-gray-800">£${(price * (item.quantity || 1)).toFixed(2)}</span>
                    </div>
                `;
            });
        }

        document.getElementById('modalPaymentBody').innerHTML = `
            <!-- Customer & Restaurant Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-gray-50 p-4 rounded-xl border border-gray-200 text-xs">
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Restaurant & Customer</span>
                    <strong class="text-[#C25A2A] block mt-1">${restaurantName}</strong>
                    <div class="font-bold text-gray-900 mt-1">${customerName}</div>
                    <span class="text-gray-600 block">${customerPhone}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Order Overview</span>
                    <div class="mt-1"><span class="font-bold text-gray-800">Type:</span> ${orderType}</div>
                    <div><span class="font-bold text-gray-800">Status:</span> ${orderStatus}</div>
                    <div><span class="font-bold text-gray-800">Method:</span> ${paymentMethod}</div>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Financial Total</span>
                    <div class="text-xl font-black text-gray-900 mt-1">£${orderTotal}</div>
                    <span class="text-emerald-600 font-bold text-[11px]">Net Paid: £${netCollected}</span>
                </div>
            </div>

            <!-- Financial Ledger Summary Cards -->
            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                    <span class="text-[10px] font-bold uppercase text-emerald-700 block">Gross Charged</span>
                    <span class="text-base font-black text-emerald-800 mt-0.5 block">£${totalCharged.toFixed(2)}</span>
                </div>
                <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl">
                    <span class="text-[10px] font-bold uppercase text-rose-700 block">Total Refunded</span>
                    <span class="text-base font-black text-rose-800 mt-0.5 block">£${totalRefunded.toFixed(2)}</span>
                </div>
                <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl">
                    <span class="text-[10px] font-bold uppercase text-blue-700 block">Net Revenue</span>
                    <span class="text-base font-black text-blue-900 mt-0.5 block">£${netCollected}</span>
                </div>
            </div>

            <!-- Payment Transaction History Table -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-2 flex items-center justify-between">
                    <span>Payment Transaction Log</span>
                    <span class="text-[11px] font-normal text-gray-400">${paymentsList.length || 1} Record(s)</span>
                </h4>
                <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-bold uppercase text-gray-500 border-b border-gray-200">
                            <tr>
                                <th class="py-2.5 px-3">#</th>
                                <th class="py-2.5 px-3">Payment Transaction ID</th>
                                <th class="py-2.5 px-3">Secondary Transaction ID</th>
                                <th class="py-2.5 px-3">Type</th>
                                <th class="py-2.5 px-3">Date</th>
                                <th class="py-2.5 px-3 text-center">Status</th>
                                <th class="py-2.5 px-3 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${paymentsTableRows}
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Items Breakdown -->
            @if(!empty($order->items))
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Order Items Included</h4>
                <div class="bg-gray-50/60 border border-gray-200 rounded-xl p-3 max-h-40 overflow-y-auto">
                    ${itemsHtml}
                </div>
            </div>
            @endif
        `;

        document.getElementById('paymentHistoryModal').classList.remove('hidden');
        document.getElementById('paymentHistoryModal').classList.add('flex');
    }

    function closePaymentHistoryModal() {
        document.getElementById('paymentHistoryModal').classList.add('hidden');
        document.getElementById('paymentHistoryModal').classList.remove('flex');
    }
</script>
@endsection
