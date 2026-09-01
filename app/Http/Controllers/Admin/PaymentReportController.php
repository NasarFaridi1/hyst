<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentReportController extends Controller
{
    /**
     * Display the Payment History and Production Report with filters.
     */
    public function index(Request $request)
    {
        $restaurants = Restaurant::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $query = Payment::with(['order', 'order.user', 'user', 'restaurant']);

        // Quick Preset Filter or Custom Date Range
        $datePreset = $request->input('preset', '');
        $startDate  = $request->input('start_date');
        $endDate    = $request->input('end_date');

        if ($datePreset) {
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
                case 'last_30':
                    $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
                    $endDate   = Carbon::now()->format('Y-m-d');
                    break;
            }
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Restaurant Filter
        $restaurantId = $request->input('restaurant_id');
        if ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        }

        // Payment Status Filter
        $paymentStatus = $request->input('payment_status');
        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }

        // Payment Method Filter
        $paymentMethod = $request->input('payment_method');
        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        // Text Search Filter (Order ID, Transaction ID, Customer Name/Email)
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_transaction_id', 'like', "%{$search}%")
                  ->orWhere('secondary_transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('order', function ($oq) use ($search) {
                      $oq->where('guest_name', 'like', "%{$search}%")
                        ->orWhere('guest_email', 'like', "%{$search}%");
                  });
            });
        }

        // Compute Production KPI Summary (Using a cloned query before pagination)
        $summaryQuery = clone $query;

        $totalTransactions = $summaryQuery->count();
        $totalGrossAmount  = (float) (clone $summaryQuery)->sum('amount');
        $totalRefunded     = (float) (clone $summaryQuery)->sum('refunded_amount');
        $netRevenue        = $totalGrossAmount - $totalRefunded;

        $paidCount         = (clone $summaryQuery)->where('payment_status', 'paid')->count();
        $paidAmount        = (float) (clone $summaryQuery)->where('payment_status', 'paid')->sum('amount');

        $pendingCount      = (clone $summaryQuery)->where('payment_status', 'pending')->count();
        $pendingAmount     = (float) (clone $summaryQuery)->where('payment_status', 'pending')->sum('amount');

        $avgPaymentValue   = $paidCount > 0 ? ($paidAmount / $paidCount) : 0;

        // Today's Live Production Stats
        $todayLiveQuery = Payment::whereDate('created_at', Carbon::today());
        if ($restaurantId) {
            $todayLiveQuery->where('restaurant_id', $restaurantId);
        }
        $todayLiveVolume = (float) (clone $todayLiveQuery)->where('payment_status', 'paid')->sum('amount');
        $todayLiveCount  = (clone $todayLiveQuery)->where('payment_status', 'paid')->count();

        // Date-wise Aggregation (for Daily Summary Table & Visual Chart)
        $dateWiseQuery = clone $query;
        $dateWiseReport = $dateWiseQuery
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) as paid_count'),
                DB::raw('SUM(amount) as gross_amount'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN amount ELSE 0 END) as paid_amount'),
                DB::raw('SUM(refunded_amount) as total_refunded')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->get();

        // Restaurant-wise Aggregation (for Restaurant Summary Table & Visual Chart)
        $restaurantWiseQuery = clone $query;
        $restaurantWiseReport = $restaurantWiseQuery
            ->select(
                'restaurant_id',
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) as paid_count'),
                DB::raw('SUM(amount) as gross_amount'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN amount ELSE 0 END) as paid_amount'),
                DB::raw('SUM(refunded_amount) as total_refunded')
            )
            ->with('restaurant:id,name')
            ->groupBy('restaurant_id')
            ->orderBy('paid_amount', 'desc')
            ->get();

        // Paginated Payment Records List
        $payments = $query->latest()->paginate(15)->withQueryString();

        // Unique Payment Methods list for filter dropdown
        $availableMethods = Payment::distinct()->pluck('payment_method')->filter()->values();

        return view('admin.payments.index', compact(
            'payments',
            'restaurants',
            'availableMethods',
            'startDate',
            'endDate',
            'datePreset',
            'restaurantId',
            'paymentStatus',
            'paymentMethod',
            'search',
            'totalTransactions',
            'totalGrossAmount',
            'totalRefunded',
            'netRevenue',
            'paidCount',
            'paidAmount',
            'pendingCount',
            'pendingAmount',
            'avgPaymentValue',
            'todayLiveVolume',
            'todayLiveCount',
            'dateWiseReport',
            'restaurantWiseReport'
        ));
    }

    /**
     * Real-time production stats JSON endpoint for live UI updates.
     */
    public function realtimeData(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');

        $todayQuery = Payment::whereDate('created_at', Carbon::today());
        if ($restaurantId) {
            $todayQuery->where('restaurant_id', $restaurantId);
        }

        $paidVolume = (float) (clone $todayQuery)->where('payment_status', 'paid')->sum('amount');
        $paidCount  = (clone $todayQuery)->where('payment_status', 'paid')->count();
        $pendingCount = (clone $todayQuery)->where('payment_status', 'pending')->count();
        $refundedAmount = (float) (clone $todayQuery)->sum('refunded_amount');

        $recentPayments = Payment::with(['restaurant:id,name', 'order:id,user_id,guest_name', 'user:id,name'])
            ->when($restaurantId, function ($q) use ($restaurantId) {
                $q->where('restaurant_id', $restaurantId);
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                return [
                    'id'             => $p->id,
                    'order_id'       => $p->order_id,
                    'restaurant'     => $p->restaurant->name ?? 'N/A',
                    'customer'       => $p->order->user->name ?? $p->user->name ?? $p->order->guest_name ?? 'Guest',
                    'amount'         => number_format($p->amount, 2),
                    'payment_status' => $p->payment_status,
                    'payment_method' => $p->payment_method,
                    'time'           => $p->created_at->format('H:i:s'),
                    'date'           => $p->created_at->format('d M Y')
                ];
            });

        return response()->json([
            'success'          => true,
            'today_volume'     => number_format($paidVolume, 2),
            'today_count'      => $paidCount,
            'today_pending'    => $pendingCount,
            'today_refunded'   => number_format($refundedAmount, 2),
            'recent_payments'  => $recentPayments,
            'timestamp'        => Carbon::now()->format('H:i:s d M Y')
        ]);
    }

    /**
     * Export payment history report as CSV file.
     */
    public function exportCsv(Request $request)
    {
        $query = Payment::with(['order', 'order.user', 'user', 'restaurant']);

        // Date Filters
        $datePreset = $request->input('preset', '');
        $startDate  = $request->input('start_date');
        $endDate    = $request->input('end_date');

        if ($datePreset) {
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
                case 'last_30':
                    $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
                    $endDate   = Carbon::now()->format('Y-m-d');
                    break;
            }
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($request->input('restaurant_id')) {
            $query->where('restaurant_id', $request->input('restaurant_id'));
        }

        if ($request->input('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        if ($request->input('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_transaction_id', 'like', "%{$search}%")
                  ->orWhere('secondary_transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest()->get();

        $filename = 'payment_report_' . Carbon::now()->format('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Payment ID',
                'Order ID',
                'Restaurant',
                'Customer Name',
                'Customer Email',
                'Payment Method',
                'Status',
                'Amount (£)',
                'Refunded (£)',
                'Transaction ID',
                'Payment Transaction ID',
                'Secondary Transaction ID',
                'Date & Time'
            ]);

            foreach ($payments as $payment) {
                $customerName = $payment->order->user->name ?? $payment->user->name ?? $payment->order->guest_name ?? 'Guest';
                $customerEmail = $payment->order->user->email ?? $payment->user->email ?? $payment->order->guest_email ?? 'N/A';

                fputcsv($file, [
                    $payment->id,
                    '#' . $payment->order_id,
                    $payment->restaurant->name ?? 'N/A',
                    $customerName,
                    $customerEmail,
                    $payment->payment_method ?? 'N/A',
                    ucfirst($payment->payment_status),
                    number_format($payment->amount, 2),
                    number_format($payment->refunded_amount ?? 0, 2),
                    $payment->transaction_id ?? 'N/A',
                    $payment->payment_transaction_id ?? 'N/A',
                    $payment->secondary_transaction_id ?? 'N/A',
                    $payment->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
