<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderReportController extends Controller
{
    /**
     * Display comprehensive order reports & analytics for Super Admin across all restaurants.
     */
    public function index(Request $request)
    {
        $restaurants = Restaurant::select('id', 'name')->orderBy('name', 'asc')->get();

        $query = Order::with(['restaurant', 'user', 'payment', 'payments', 'items.product', 'items.addons', 'coupon', 'loyaltyReward']);

        // 1. Restaurant Filter
        $restaurantId = $request->input('restaurant_id');
        if ($restaurantId && $restaurantId !== 'all') {
            $query->where('restaurant_id', $restaurantId);
        }

        // 2. Date Filter (Preset or Custom Range)
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

        // 3. Order Status Filter
        $status = $request->input('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // 4. Payment Status Filter
        $paymentStatus = $request->input('payment_status');
        if ($paymentStatus && $paymentStatus !== 'all') {
            $query->whereHas('payment', function ($pq) use ($paymentStatus) {
                $pq->where('payment_status', $paymentStatus);
            });
        }

        // 5. Payment Method Filter
        $paymentMethod = $request->input('payment_method');
        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where(function ($q) use ($paymentMethod) {
                $q->where('payment_method', $paymentMethod)
                  ->orWhereHas('payment', function ($pq) use ($paymentMethod) {
                      $pq->where('payment_method', $paymentMethod);
                  });
            });
        }

        // 6. Order Type Filter
        $orderType = $request->input('order_type');
        if ($orderType && $orderType !== 'all') {
            $query->where('order_type', $orderType);
        }

        // 7. Text Search Filter (Order ID, Customer Name, Email, Phone, Transaction IDs, Restaurant Name)
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
                  })
                  ->orWhereHas('restaurant', function ($rq) use ($search) {
                      $rq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // KPI Summaries Calculation
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

        $paidOrdersCount = (clone $summaryQuery)->whereHas('payment', function ($pq) {
            $pq->where('payment_status', 'paid');
        })->count();

        $paidOrdersVolume = (float) (clone $summaryQuery)->whereHas('payment', function ($pq) {
            $pq->where('payment_status', 'paid');
        })->sum('total_amount');

        $refundedVolume = (float) Payment::whereIn('order_id', (clone $summaryQuery)->pluck('id'))
            ->sum('refunded_amount');

        // Restaurant Performance Summary Breakdown
        $restaurantReport = (clone $query)
            ->select(
                'restaurant_id',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(CASE WHEN status IN ("completed", "delivered") THEN 1 ELSE 0 END) as completed_count'),
                DB::raw('SUM(CASE WHEN status IN ("completed", "delivered") THEN total_amount ELSE 0 END) as revenue')
            )
            ->with('restaurant:id,name')
            ->groupBy('restaurant_id')
            ->orderBy('revenue', 'desc')
            ->limit(10)
            ->get();

        // Date-wise Aggregation
        $dateWiseReport = (clone $query)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(CASE WHEN status IN ("completed", "delivered") THEN 1 ELSE 0 END) as completed_count'),
                DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled_count'),
                DB::raw('SUM(CASE WHEN status IN ("completed", "delivered") THEN total_amount ELSE 0 END) as revenue')
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

        return view('admin.reports.orders', compact(
            'restaurants',
            'restaurantId',
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
            'restaurantReport',
            'dateWiseReport',
            'paymentMethodReport'
        ));
    }

    /**
     * Print / Export PDF order report view for Super Admin.
     */
    public function exportPdf(Request $request)
    {
        $query = Order::with(['restaurant', 'user', 'payment', 'items.product']);

        $restaurantId = $request->input('restaurant_id');
        if ($restaurantId && $restaurantId !== 'all') {
            $query->where('restaurant_id', $restaurantId);
        }

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
        $selectedRestaurant = $restaurantId && $restaurantId !== 'all' ? Restaurant::find($restaurantId) : null;

        return view('admin.reports.orders-pdf', compact(
            'selectedRestaurant',
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
