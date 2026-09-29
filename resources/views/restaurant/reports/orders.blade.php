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
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Order & Financial Reports</h1>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Real-time sales analytics, payment breakdowns, and order history for <strong class="text-gray-800">{{ $restaurant->name ?? 'Your Restaurant' }}</strong>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('restaurant.order_reports.export_csv', request()->all()) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 hover:text-[#C25A2A] hover:border-orange-200 text-xs font-semibold shadow-sm transition">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export CSV
            </a>
            
            <a href="{{ route('restaurant.order_reports.export_pdf', request()->all()) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#C25A2A] text-white hover:bg-[#a84c22] text-xs font-semibold shadow transition">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Print / Save PDF
            </a>
        </div>
    </div>

    <!-- ════════════════════════════════════════════════════════════
         FILTER BAR SECTION
    ════════════════════════════════════════════════════════════ -->
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm mb-8">
        <form method="GET" action="{{ route('restaurant.order_reports.index') }}" class="space-y-4">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                
                <!-- 1. Preset Date -->
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

                <!-- 2. Start Date -->
                <div id="start_date_wrap" style="{{ $datePreset == 'custom' ? '' : 'display:none;' }}">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                           class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                </div>

                <!-- 3. End Date -->
                <div id="end_date_wrap" style="{{ $datePreset == 'custom' ? '' : 'display:none;' }}">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                           class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                </div>

                <!-- 4. Order Status -->
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

                <!-- 5. Payment Status -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="all">All Payments</option>
                        <option value="paid" {{ $paymentStatus == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ $paymentStatus == 'pending' ? 'selected' : '' }}>Unpaid / Pending</option>
                        <option value="refunded" {{ $paymentStatus == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- 6. Order Type -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Order Type</label>
                    <select name="order_type" class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="all">All Types</option>
                        <option value="delivery" {{ $orderType == 'delivery' ? 'selected' : '' }}>Home Delivery</option>
                        <option value="takeaway" {{ $orderType == 'takeaway' ? 'selected' : '' }}>Takeaway</option>
                        <option value="dine_in" {{ $orderType == 'dine_in' ? 'selected' : '' }}>Dine In</option>
                    </select>
                </div>

                <!-- 7. Search -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Search Keyword</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="ID, Customer, Phone..."
                           class="w-full border border-gray-200 rounded-xl p-2.5 text-xs text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                </div>

            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                <a href="{{ route('restaurant.order_reports.index') }}" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs font-semibold transition">
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
                Service/Platform Charges: <span class="font-bold text-gray-800">£{{ number_format($totalServiceFees, 2) }}</span>
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
         DAILY BREAKDOWN & PAYMENT METHOD BREAKDOWN (2 Columns)
    ════════════════════════════════════════════════════════════ -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
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

        <!-- Payment Method Breakdown -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Payment Method Breakdown</h3>
            <div class="space-y-3">
                @forelse($paymentMethodReport as $pm)
                    @php
                        $pct = $allOrdersTotal > 0 ? round(($pm->total_amount / $allOrdersTotal) * 100, 1) : 0;
                    @endphp
                    <div class="p-3.5 rounded-xl border border-gray-100 bg-gray-50/50">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-gray-800 uppercase">{{ strtoupper($pm->method) }}</span>
                            <span class="text-xs font-black text-gray-900">£{{ number_format($pm->total_amount, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-gray-500">
                            <span>{{ $pm->count }} orders</span>
                            <span>{{ $pct }}% of total</span>
                        </div>
                        <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden mt-2">
                            <div class="bg-[#C25A2A] h-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-6">No payment data recorded.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ════════════════════════════════════════════════════════════
         DETAILED ORDERS LEDGER TABLE
    ════════════════════════════════════════════════════════════ -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Detailed Orders Ledger</h3>
                <p class="text-xs text-gray-500">Showing filtered orders list with payment details & customer breakdown</p>
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
                                <button type="button" onclick='openOrderModal(@json($order))'
                                        class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-10 text-center text-gray-400">
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
     ORDER DETAILS INTERACTIVE MODAL
════════════════════════════════════════════════════════════ -->
<div id="orderDetailModal" class="fixed inset-0 bg-black/60 z-[9999] hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">
        <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-gray-50">
            <div>
                <h3 class="text-lg font-bold text-gray-900" id="modalOrderId">Order Details</h3>
                <p class="text-xs text-gray-500" id="modalOrderDate"></p>
            </div>
            <button type="button" onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-700 text-xl font-bold p-1">✕</button>
        </div>
        
        <div class="p-6 overflow-y-auto space-y-6" id="modalBody">
            <!-- Dynamic Content populated via JS -->
        </div>

        <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end">
            <button type="button" onclick="closeOrderModal()" class="px-5 py-2 rounded-xl bg-gray-900 text-white text-xs font-bold hover:bg-black transition">
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

    function openOrderModal(order) {
        document.getElementById('modalOrderId').textContent = 'Order #' + order.id;
        document.getElementById('modalOrderDate').textContent = order.created_at ? new Date(order.created_at).toLocaleString() : '';

        const customerName = order.is_guest ? (order.guest_name || 'Guest') : (order.user ? order.user.name : 'N/A');
        const customerPhone = order.is_guest ? (order.guest_phone || 'N/A') : (order.phone || (order.user ? order.user.phone : 'N/A'));
        const customerAddress = order.address || order.guest_address || 'N/A';

        let itemsHtml = '';
        if (order.items && order.items.length) {
            order.items.forEach(item => {
                const productName = item.product ? item.product.name : (item.product_name || 'Item');
                const price = parseFloat(item.price || 0).toFixed(2);
                itemsHtml += `
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 text-xs">
                        <div>
                            <span class="font-bold text-gray-900">${productName}</span>
                            <span class="text-gray-500 ml-1">x${item.quantity || 1}</span>
                        </div>
                        <span class="font-bold text-gray-900">£${(price * (item.quantity || 1)).toFixed(2)}</span>
                    </div>
                `;
            });
        } else {
            itemsHtml = '<p class="text-xs text-gray-400">No items breakdown recorded.</p>';
        }

        const deliveryCharge = parseFloat(order.delivery_charge || 0).toFixed(2);
        const serviceCharge = parseFloat(order.service_charge || order.hyst_charge || 0).toFixed(2);
        const discount = (parseFloat(order.coupon_discount || 0) + parseFloat(order.offer_discount || 0) + parseFloat(order.loyalty_discount || 0)).toFixed(2);
        const totalAmount = parseFloat(order.total_amount || 0).toFixed(2);

        document.getElementById('modalBody').innerHTML = `
            <div class="grid grid-cols-2 gap-4 text-xs bg-gray-50 p-4 rounded-xl border border-gray-200">
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Customer Info</span>
                    <strong class="text-gray-900 block mt-1">${customerName}</strong>
                    <span class="text-gray-600 block">${customerPhone}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Delivery Address</span>
                    <span class="text-gray-800 block mt-1">${customerAddress}</span>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Order Items</h4>
                <div class="bg-white border border-gray-200 rounded-xl p-3">
                    ${itemsHtml}
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-xs space-y-2">
                <div class="flex justify-between text-gray-600">
                    <span>Delivery Charge:</span>
                    <span>£${deliveryCharge}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Service Fee:</span>
                    <span>£${serviceCharge}</span>
                </div>
                <div class="flex justify-between text-rose-600 font-semibold">
                    <span>Discounts Applied:</span>
                    <span>-£${discount}</span>
                </div>
                <div class="flex justify-between text-sm font-black text-gray-900 border-t border-gray-200 pt-2">
                    <span>Total Amount Paid:</span>
                    <span>£${totalAmount}</span>
                </div>
            </div>

            <div class="text-xs text-gray-500 space-y-1">
                <div><strong>Payment Method:</strong> ${ (order.payment_method || 'Online').toUpperCase() }</div>
                <div><strong>Status:</strong> ${ order.status }</div>
            </div>
        `;

        document.getElementById('orderDetailModal').classList.remove('hidden');
        document.getElementById('orderDetailModal').classList.add('flex');
    }

    function closeOrderModal() {
        document.getElementById('orderDetailModal').classList.add('hidden');
        document.getElementById('orderDetailModal').classList.remove('flex');
    }
</script>
@endsection
