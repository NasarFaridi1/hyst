<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderReportController extends Controller
{
    /**
     * Display comprehensive order reports & analytics for the logged-in restaurant admin.
     */
    public function index(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $restaurant = Restaurant::find($restaurantId);

        $query = Order::with(['user', 'payment', 'payments', 'items.product', 'items.addons', 'coupon', 'loyaltyReward'])
            ->where('restaurant_id', $restaurantId);

        // 1. Date Filter (Preset or Custom Range)
        $datePreset = $request->input('preset', 'this_month');
        $startDate  = $request->input('start_date');
        $endDate    = $request->input('end_date');

        if ($datePreset && $datePreset !== 'custom') {
            switch ($datePreset) {
                case 'today':
                    $startDate = Carbon::today()->format('Y-m-d');
                    $endDate   = Carbon::today()->format('Y-m-d');
                    break;
                case 'yesterday':
                    $startDate = Carbon::yesterday()->format('Y-m-d');
                    $endDate   = Carbon::yesterday()->format('Y-m-d');
                    break;
                case 'this_week':
                    $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
                    $endDate   = Carbon::now()->endOfWeek()->format('Y-m-d');
                    break;
                case 'this_month':
                    $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                    $endDate   = Carbon::now()->endOfMonth()->format('Y-m-d');
                    break;
                case 'last_month':
                    $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                    $endDate   = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                    break;
                case 'last_30':
                    $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
                    $endDate   = Carbon::now()->format('Y-m-d');
                    break;
                case 'all_time':
                    $startDate = null;
                    $endDate   = null;
                    break;
            }
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // 2. Order Status Filter
        $status = $request->input('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // 3. Payment Status Filter
        $paymentStatus = $request->input('payment_status');
        if ($paymentStatus && $paymentStatus !== 'all') {
            $query->whereHas('payment', function ($pq) use ($paymentStatus) {
                $pq->where('payment_status', $paymentStatus);
            });
        }

        // 4. Payment Method Filter
        $paymentMethod = $request->input('payment_method');
        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where(function ($q) use ($paymentMethod) {
                $q->where('payment_method', $paymentMethod)
                  ->orWhereHas('payment', function ($pq) use ($paymentMethod) {
                      $pq->where('payment_method', $paymentMethod);
                  });
            });
        }

        // 5. Order Type Filter
        $orderType = $request->input('order_type');
        if ($orderType && $orderType !== 'all') {
            $query->where('order_type', $orderType);
        }

        // 6. Text Search Filter (Order ID, Customer Name, Email, Phone, Worldpay Transaction IDs)
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhere('guest_phone', 'like', "%{$search}%")
                  ->orWhereHas('payment', function ($pq) use ($search) {
                      $pq->where('payment_transaction_id', 'like', "%{$search}%")
                        ->orWhere('secondary_transaction_id', 'like', "%{$search}%")
                        ->orWhere('transaction_id', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // KPI Summaries Calculation (Cloned query before pagination)
        $summaryQuery = clone $query;

        $totalOrders     = (clone $summaryQuery)->count();
        $completedOrders = (clone $summaryQuery)->whereIn('status', ['completed', 'delivered'])->count();
        $cancelledOrders = (clone $summaryQuery)->where('status', 'cancelled')->count();
        $pendingOrders   = (clone $summaryQuery)->whereIn('status', ['pending', 'accepted', 'preparing', 'out_for_delivery'])->count();

        $grossRevenue    = (float) (clone $summaryQuery)->whereIn('status', ['completed', 'delivered'])->sum('total_amount');
        $allOrdersTotal  = (float) (clone $summaryQuery)->sum('total_amount');

        $avgOrderValue   = $completedOrders > 0 ? ($grossRevenue / $completedOrders) : 0;

        $totalDeliveryFees = (float) (clone $summaryQuery)->sum('delivery_charge');
        $totalServiceFees  = (float) (clone $summaryQuery)->sum(DB::raw('COALESCE(service_charge, 0) + COALESCE(hyst_charge, 0) + COALESCE(product_charge, 0)'));

        $totalDiscounts    = (float) (clone $summaryQuery)->sum(DB::raw('COALESCE(coupon_discount, 0) + COALESCE(offer_discount, 0) + COALESCE(loyalty_discount, 0) + COALESCE(referral_discount, 0) + COALESCE(gift_card_amount, 0)'));

        // Payment status metrics
        $paidOrdersCount = (clone $summaryQuery)->whereHas('payment', function ($pq) {
            $pq->where('payment_status', 'paid');
        })->count();

        $paidOrdersVolume = (float) (clone $summaryQuery)->whereHas('payment', function ($pq) {
            $pq->where('payment_status', 'paid');
        })->sum('total_amount');

        $refundedVolume = (float) Payment::where('restaurant_id', $restaurantId)
            ->whereIn('order_id', (clone $summaryQuery)->pluck('id'))
            ->sum('refunded_amount');

        // Date-wise Aggregation for Charts & Daily Trends Table
        $dateWiseReport = (clone $query)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(CASE WHEN status IN ("completed", "delivered") THEN 1 ELSE 0 END) as completed_count'),
                DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled_count'),
                DB::raw('SUM(CASE WHEN status IN ("completed", "delivered") THEN total_amount ELSE 0 END) as revenue'),
                DB::raw('SUM(total_amount) as total_volume')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        // Payment Method Breakdown
        $paymentMethodReport = (clone $query)
            ->select(
                DB::raw('COALESCE(payment_method, "online") as method'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->groupBy(DB::raw('COALESCE(payment_method, "online")'))
            ->get();

        // Paginated Orders List
        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('restaurant.reports.orders', compact(
            'restaurant',
            'orders',
            'datePreset',
            'startDate',
            'endDate',
            'status',
            'paymentStatus',
            'paymentMethod',
            'orderType',
            'search',
            'totalOrders',
            'completedOrders',
            'cancelledOrders',
            'pendingOrders',
            'grossRevenue',
            'allOrdersTotal',
            'avgOrderValue',
            'totalDeliveryFees',
            'totalServiceFees',
            'totalDiscounts',
            'paidOrdersCount',
            'paidOrdersVolume',
            'refundedVolume',
            'dateWiseReport',
            'paymentMethodReport'
        ));
    }

    /**
     * Export order report data as CSV file.
     */
    public function exportCsv(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $restaurant   = Restaurant::find($restaurantId);

        $query = Order::with(['user', 'payment', 'items.product'])
            ->where('restaurant_id', $restaurantId);

        // Apply same filters
        $datePreset = $request->input('preset');
        $startDate  = $request->input('start_date');
        $endDate    = $request->input('end_date');

        if ($datePreset && $datePreset !== 'custom') {
            switch ($datePreset) {
                case 'today':
                    $startDate = Carbon::today()->format('Y-m-d');
                    $endDate   = Carbon::today()->format('Y-m-d');
                    break;
                case 'yesterday':
                    $startDate = Carbon::yesterday()->format('Y-m-d');
                    $endDate   = Carbon::yesterday()->format('Y-m-d');
                    break;
                case 'this_week':
                    $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
                    $endDate   = Carbon::now()->endOfWeek()->format('Y-m-d');
                    break;
                case 'this_month':
                    $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                    $endDate   = Carbon::now()->endOfMonth()->format('Y-m-d');
                    break;
                case 'last_month':
                    $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                    $endDate   = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                    break;
                case 'last_30':
                    $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
                    $endDate   = Carbon::now()->format('Y-m-d');
                    break;
            }
        }

        if ($startDate) $query->whereDate('created_at', '>=', $startDate);
        if ($endDate)   $query->whereDate('created_at', '<=', $endDate);

        $status = $request->input('status');
        if ($status && $status !== 'all') $query->where('status', $status);

        $paymentStatus = $request->input('payment_status');
        if ($paymentStatus && $paymentStatus !== 'all') {
            $query->whereHas('payment', function ($pq) use ($paymentStatus) {
                $pq->where('payment_status', $paymentStatus);
            });
        }

        $paymentMethod = $request->input('payment_method');
        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where(function ($q) use ($paymentMethod) {
                $q->where('payment_method', $paymentMethod)
                  ->orWhereHas('payment', function ($pq) use ($paymentMethod) {
                      $pq->where('payment_method', $paymentMethod);
                  });
            });
        }

        $orderType = $request->input('order_type');
        if ($orderType && $orderType !== 'all') {
            $query->where('order_type', $orderType);
        }

        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhere('guest_phone', 'like', "%{$search}%")
                  ->orWhereHas('payment', function ($pq) use ($search) {
                      $pq->where('payment_transaction_id', 'like', "%{$search}%")
                        ->orWhere('secondary_transaction_id', 'like', "%{$search}%")
                        ->orWhere('transaction_id', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->get();

        $fileName = 'order_report_' . str_replace(' ', '_', strtolower($restaurant->name ?? 'restaurant')) . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');

            // Write UTF-8 Byte Order Mark (BOM) for Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header Row
            fputcsv($handle, [
                'Order ID',
                'Date & Time',
                'Customer Name',
                'Customer Phone',
                'Customer Email',
                'Order Type',
                'Order Status',
                'Payment Status',
                'Payment Method',
                'Payment Transaction ID',
                'Secondary Transaction ID',
                'Delivery Charge (£)',
                'Service Charge (£)',
                'Discount (£)',
                'Total Amount (£)',
                'Items Summary'
            ]);

            foreach ($orders as $order) {
                $customerName  = $order->is_guest ? ($order->guest_name ?? 'Guest') : ($order->user->name ?? 'N/A');
                $customerPhone = $order->is_guest ? ($order->guest_phone ?? 'N/A') : ($order->phone ?? $order->user->phone ?? 'N/A');
                $customerEmail = $order->is_guest ? ($order->guest_email ?? 'N/A') : ($order->user->email ?? 'N/A');

                $paymentStatus = $order->payment ? $order->payment->payment_status : ($order->status == 'completed' ? 'paid' : 'pending');
                $paymentTxId   = $order->payment->payment_transaction_id ?? $order->payment->transaction_id ?? 'N/A';
                $secondaryTxId = $order->payment->secondary_transaction_id ?? 'N/A';

                $discounts = ($order->coupon_discount ?? 0) + ($order->offer_discount ?? 0) + ($order->loyalty_discount ?? 0) + ($order->referral_discount ?? 0);

                $itemsSummary = $order->items->map(function ($item) {
                    $pName = str_replace(["\r", "\n"], ' ', $item->product_name ?? ($item->product->name ?? 'Item'));
                    return $pName . ' (x' . ($item->quantity ?? 1) . ')';
                })->implode('; ');

                fputcsv($handle, [
                    '#' . $order->id,
                    $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : '',
                    str_replace(["\r", "\n"], ' ', $customerName),
                    str_replace(["\r", "\n"], ' ', $customerPhone),
                    str_replace(["\r", "\n"], ' ', $customerEmail),
                    ucwords(str_replace('_', ' ', $order->order_type ?? 'delivery')),
                    ucwords($order->status),
                    ucwords($paymentStatus),
                    strtoupper($order->payment_method ?? 'online'),
                    $paymentTxId,
                    $secondaryTxId,
                    number_format($order->delivery_charge ?? 0, 2),
                    number_format(($order->service_charge ?? 0) + ($order->hyst_charge ?? 0), 2),
                    number_format($discounts, 2),
                    number_format($order->total_amount ?? 0, 2),
                    $itemsSummary
                ]);
            }

            fclose($handle);
        }, $fileName, $headers);
    }

    /**
     * Print / Export PDF order report view.
     */
    public function exportPdf(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $restaurant   = Restaurant::find($restaurantId);

        $query = Order::with(['user', 'payment', 'items.product'])
            ->where('restaurant_id', $restaurantId);

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        if ($startDate) $query->whereDate('created_at', '>=', $startDate);
        if ($endDate)   $query->whereDate('created_at', '<=', $endDate);

        $status = $request->input('status');
        if ($status && $status !== 'all') $query->where('status', $status);

        $orders = $query->latest()->get();

        $totalOrders     = $orders->count();
        $completedOrders = $orders->whereIn('status', ['completed', 'delivered'])->count();
        $grossRevenue    = $orders->whereIn('status', ['completed', 'delivered'])->sum('total_amount');
        $totalDelivery   = $orders->sum('delivery_charge');

        return view('restaurant.reports.orders-pdf', compact(
            'restaurant',
            'orders',
            'startDate',
            'endDate',
            'totalOrders',
            'completedOrders',
            'grossRevenue',
            'totalDelivery'
        ));
    }
}
