<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Production Report - HYST</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            color: #111827;
            background: #FFFFFF;
            padding: 30px;
            margin: 0;
            font-size: 13px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-bottom: 2px solid #E5E7EB;
            padding-bottom: 15px;
        }
        .logo-title {
            font-size: 24px;
            font-weight: 800;
            color: #C25A2A;
            margin: 0;
        }
        .report-subtitle {
            color: #6B7280;
            font-size: 13px;
            margin-top: 4px;
        }
        .meta-box {
            text-align: right;
            font-size: 12px;
            color: #4B5563;
        }

        /* Summary Stats Cards */
        .stats-row {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            flex: 1;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 12px 15px;
            background: #F9FAFB;
        }
        .stat-card-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #6B7280;
            letter-spacing: 0.5px;
        }
        .stat-card-val {
            font-size: 18px;
            font-weight: 800;
            color: #111827;
            margin-top: 4px;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th {
            background: #1F2937;
            color: #FFFFFF;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 700;
            padding: 10px 12px;
            text-align: left;
            letter-spacing: 0.5px;
        }
        .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 12px;
        }
        .data-table tr:nth-child(even) td {
            background: #F9FAFB;
        }

        .badge-paid {
            background: #DEF7EC;
            color: #03543F;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            display: inline-block;
        }
        .badge-pending {
            background: #FEF08A;
            color: #854D0E;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            display: inline-block;
        }
        .badge-refunded {
            background: #F3E8FF;
            color: #6B21A8;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            display: inline-block;
        }

        .print-btn-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: #2563EB;
            color: #FFFFFF;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
        }

        @media print {
            .print-btn-bar {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <div class="print-btn-bar">
        <a href="javascript:history.back()" style="color: #6B7280; text-decoration: none; font-weight: 600;">&larr; Back to Admin Panel</a>
        <button onclick="window.print()" class="btn-print">🖨️ Print or Save as PDF</button>
    </div>

    <table class="header-table">
        <tr>
            <td>
                <h1 class="logo-title">HYST Payment Production Report</h1>
                <div class="report-subtitle">Official Payment & Transaction Audit Document</div>
            </td>
            <td class="meta-box">
                <div><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('d M Y, H:i:s') }}</div>
                <div><strong>Date Filter:</strong> {{ $startDate ? $startDate : 'Beginning' }} to {{ $endDate ? $endDate : 'Present' }}</div>
                <div><strong>Restaurant:</strong> {{ $restaurantName }}</div>
            </td>
        </tr>
    </table>

    <!-- Production KPI Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-card-title">Gross Revenue</div>
            <div class="stat-card-val">£{{ number_format($totalGrossAmount, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Net Revenue</div>
            <div class="stat-card-val" style="color:#10B981;">£{{ number_format($netRevenue, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Successful Payments</div>
            <div class="stat-card-val">£{{ number_format($paidAmount, 2) }}</div>
            <div style="font-size:11px; color:#6B7280; margin-top:2px;">{{ $paidCount }} Paid Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Refunded Total</div>
            <div class="stat-card-val" style="color:#8B5CF6;">£{{ number_format($totalRefunded, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-title">Total Records</div>
            <div class="stat-card-val">{{ $totalTransactions }}</div>
        </div>
    </div>

    <!-- Payment Records Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Restaurant</th>
                <th>Customer</th>
                <th>Method</th>
                <th>Platform Charge</th>
                <th>Delivery Charge</th>
                <th>Restaurant Amount</th>
                <th>Total Amount</th>
                <th>Refunded</th>
                <th>Status</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                @php
                    $platformCharge = (float) (($payment->order->hyst_charge ?? 0) + ($payment->order->service_charge ?? 0));
                    $deliveryCharge = (float) ($payment->order->delivery_charge ?? 0);
                    $totalAmount = (float) ($payment->amount ?? $payment->order->total_amount ?? 0);
                    $restaurantAmount = max($totalAmount - $platformCharge - $deliveryCharge, 0);
                @endphp
                <tr>
                    <td><strong>#{{ $payment->id }}</strong></td>
                    <td>{{ $payment->order_id ? '#' . $payment->order_id : 'N/A' }}</td>
                    <td>{{ $payment->restaurant->name ?? 'N/A' }}</td>
                    <td>{{ $payment->order->user->name ?? $payment->user->name ?? $payment->order->guest_name ?? 'Guest' }}</td>
                    <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                    <td style="color:#2563EB; font-weight:700;">£{{ number_format($platformCharge, 2) }}</td>
                    <td style="color:#4F46E5; font-weight:700;">£{{ number_format($deliveryCharge, 2) }}</td>
                    <td style="color:#10B981; font-weight:700;">£{{ number_format($restaurantAmount, 2) }}</td>
                    <td><strong>£{{ number_format($totalAmount, 2) }}</strong></td>
                    <td>{{ ($payment->refunded_amount ?? 0) > 0 ? '£' . number_format($payment->refunded_amount, 2) : '-' }}</td>
                    <td>
                        @if($payment->payment_status == 'paid')
                            <span class="badge-paid">Paid</span>
                        @elseif($payment->payment_status == 'pending')
                            <span class="badge-pending">Pending</span>
                        @elseif($payment->payment_status == 'refunded')
                            <span class="badge-refunded">Refunded</span>
                        @else
                            <span>{{ ucfirst($payment->payment_status) }}</span>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align: center; padding: 20px;">No payment records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        // Trigger print dialog automatically when loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 400);
        });
    </script>
</body>
</html>
