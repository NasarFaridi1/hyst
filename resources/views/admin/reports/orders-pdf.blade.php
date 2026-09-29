<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Order Report - {{ $selectedRestaurant ? $selectedRestaurant->name : 'All Restaurants' }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #111; padding-bottom: 12px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; color: #111; }
        .meta { text-align: right; font-size: 11px; color: #666; }
        .summary-grid { display: table; width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 10px; }
        .summary-box { display: table-cell; background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 12px; text-align: center; width: 25%; }
        .summary-box .val { font-size: 18px; font-weight: bold; color: #111; margin-top: 4px; }
        .summary-box .lbl { font-size: 10px; text-transform: uppercase; color: #666; font-weight: bold; }
        table.ledger { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.ledger th { background: #111; color: #fff; font-size: 10px; text-transform: uppercase; padding: 8px 10px; text-align: left; }
        table.ledger td { padding: 8px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        table.ledger tr:nth-child(even) { background: #fcfcfc; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="background: #111; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Print / Save PDF
        </button>
    </div>

    <div class="header">
        <div>
            <div class="title">{{ $selectedRestaurant ? $selectedRestaurant->name : 'All System Restaurants' }}</div>
            <div style="font-size: 13px; font-weight: bold; color: #555;">Super Admin Order & Sales Executive Report</div>
        </div>
        <div class="meta">
            <div><strong>Generated:</strong> {{ date('d M Y, h:i A') }}</div>
            <div><strong>Period:</strong> {{ $startDate ? date('d M Y', strtotime($startDate)) : 'Beginning' }} to {{ $endDate ? date('d M Y', strtotime($endDate)) : 'Today' }}</div>
        </div>
    </div>

    <div class="summary-grid">
        <div class="summary-box">
            <div class="lbl">Total Orders</div>
            <div class="val">{{ number_format($totalOrders) }}</div>
        </div>
        <div class="summary-box">
            <div class="lbl">Completed Orders</div>
            <div class="val" style="color: #059669;">{{ number_format($completedOrders) }}</div>
        </div>
        <div class="summary-box">
            <div class="lbl">Gross Sales Revenue</div>
            <div class="val" style="color: #059669;">£{{ number_format($grossRevenue, 2) }}</div>
        </div>
        <div class="summary-box">
            <div class="lbl">Total Delivery Volume</div>
            <div class="val">£{{ number_format($totalDelivery, 2) }}</div>
        </div>
    </div>

    <table class="ledger">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Restaurant</th>
                <th>Date & Time</th>
                <th>Customer</th>
                <th class="text-center">Type</th>
                <th class="text-center">Status</th>
                <th>Payment</th>
                <th class="text-right">Total (£)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                @php
                    $cName = $order->is_guest ? ($order->guest_name ?? 'Guest') : ($order->user->name ?? 'N/A');
                @endphp
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td><strong>{{ $order->restaurant->name ?? 'N/A' }}</strong></td>
                    <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</td>
                    <td>{{ $cName }}</td>
                    <td class="text-center">{{ ucwords(str_replace('_', ' ', $order->order_type ?? 'delivery')) }}</td>
                    <td class="text-center">
                        @if($order->status == 'completed' || $order->status == 'delivered')
                            <span class="badge badge-completed">Completed</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge badge-cancelled">Cancelled</span>
                        @else
                            <span class="badge badge-pending">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td>{{ strtoupper($order->payment_method ?? 'online') }}</td>
                    <td class="text-right"><strong>£{{ number_format($order->total_amount ?? 0, 2) }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">No order records available for this report period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
