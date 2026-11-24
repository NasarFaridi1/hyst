<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        /*
        |--------------------------------------------------------------------------
        | Status & Error Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {
            if ($request->status === 'failed' || $request->status === 'error') {
                $query->where('status', '!=', 'success');
            } elseif ($request->status === 'success') {
                $query->where('status', 'success');
            }
        }

        if ($request->boolean('only_errors')) {
            $query->where('status', '!=', 'success');
        }

        /*
        |--------------------------------------------------------------------------
        | Status Code Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status_code')) {
            $code = (int) $request->status_code;
            $query->where('response->status_code', $code);
        }

        /*
        |--------------------------------------------------------------------------
        | Module Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('module')) {
            $query->where('module', 'like', '%' . $request->module . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Action / Method Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('action_method')) {
            $query->where('action', strtoupper($request->action_method));
        }

        /*
        |--------------------------------------------------------------------------
        | IP Address Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . trim($request->ip) . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | User ID & User Name Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('user_name')) {
            $userIdsByName = User::where('name', 'like', '%' . trim($request->user_name) . '%')->pluck('id');
            $query->whereIn('user_id', $userIdsByName);
        }

        /*
        |--------------------------------------------------------------------------
        | Keyword Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('description', 'like', '%' . $keyword . '%')
                  ->orWhere('ip_address', 'like', '%' . $keyword . '%')
                  ->orWhere('module', 'like', '%' . $keyword . '%')
                  ->orWhere('payload', 'like', '%' . $keyword . '%')
                  ->orWhere('response', 'like', '%' . $keyword . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Summary Counts & Stats
        |--------------------------------------------------------------------------
        */
        $totalLogs = ActivityLog::count();
        $totalErrors = ActivityLog::where('status', '!=', 'success')->count();
        $todayErrors = ActivityLog::where('status', '!=', 'success')
            ->whereDate('created_at', today())
            ->count();
        $total500Errors = ActivityLog::where('response->status_code', 500)->count();
        $uniqueIpsCount = ActivityLog::whereNotNull('ip_address')
            ->where('ip_address', '!=', '')
            ->distinct('ip_address')
            ->count('ip_address');

        /*
        |--------------------------------------------------------------------------
        | Raw / Flat Logs Table (Paginated)
        |--------------------------------------------------------------------------
        */
        $logs = (clone $query)
            ->latest('id')
            ->paginate(15, ['*'], 'log_page')
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Unique Visitor / IP Journey View (Grouped by IP)
        |--------------------------------------------------------------------------
        */
        $perPage = 15;
        $journeyPage = (int) $request->get('journey_page', 1);

        $totalUniqueVisitors = (clone $query)
            ->whereNotNull('ip_address')
            ->where('ip_address', '!=', '')
            ->distinct('ip_address')
            ->count('ip_address');

        $uniqueIps = (clone $query)
            ->select(
                'ip_address',
                DB::raw('COUNT(*) as total_requests'),
                DB::raw("SUM(CASE WHEN status != 'success' THEN 1 ELSE 0 END) as total_errors"),
                DB::raw('MIN(created_at) as first_seen'),
                DB::raw('MAX(created_at) as last_active')
            )
            ->whereNotNull('ip_address')
            ->where('ip_address', '!=', '')
            ->groupBy('ip_address')
            ->orderByDesc(DB::raw('MAX(created_at)'))
            ->forPage($journeyPage, $perPage)
            ->get();

        $uniqueJourneys = new LengthAwarePaginator(
            $uniqueIps,
            $totalUniqueVisitors,
            $perPage,
            $journeyPage,
            ['path' => $request->url(), 'pageName' => 'journey_page', 'query' => $request->query()]
        );

        $pageIps = $uniqueIps->pluck('ip_address')->filter()->values()->toArray();

        $logsByIp = [];
        $rawLogsForIps = collect();
        if (!empty($pageIps)) {
            $rawLogsForIps = ActivityLog::whereIn('ip_address', $pageIps)
                ->orderByDesc('id')
                ->limit(300)
                ->get();

            $logsByIp = $rawLogsForIps->groupBy('ip_address');
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve User Names across both views
        |--------------------------------------------------------------------------
        */
        $allUserIds = $logs->pluck('user_id')
            ->merge($rawLogsForIps->pluck('user_id'))
            ->filter()
            ->unique()
            ->values();

        $users = User::whereIn('id', $allUserIds)->pluck('name', 'id');

        return view('admin.activity-logs.index', compact(
            'logs',
            'uniqueJourneys',
            'logsByIp',
            'totalLogs',
            'totalErrors',
            'todayErrors',
            'total500Errors',
            'uniqueIpsCount',
            'users'
        ));
    }

    /**
     * Delete a single activity log
     */
    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        return redirect()->back()->with('success', 'Activity log entry #' . $id . ' deleted successfully.');
    }

    /**
     * Bulk delete selected activity logs
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'No activity logs selected for deletion.');
        }

        $count = ActivityLog::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', $count . ' activity log records deleted successfully.');
    }

    /**
     * Purge activity logs based on date, age, or status
     */
    public function purge(Request $request)
    {
        $request->validate([
            'purge_type' => 'required|string|in:days,date_range,only_success,all',
        ]);

        $query = ActivityLog::query();
        $message = '';

        if ($request->purge_type === 'days') {
            $days = (int) $request->input('days', 30);
            if ($days < 1) $days = 30;
            $cutoff = Carbon::now()->subDays($days);
            $count = $query->where('created_at', '<', $cutoff)->delete();
            $message = "Deleted {$count} logs older than {$days} days.";
        } elseif ($request->purge_type === 'date_range') {
            $from = $request->input('purge_from');
            $to = $request->input('purge_to');
            if ($from && $to) {
                $count = $query->whereBetween('created_at', [
                    Carbon::parse($from)->startOfDay(),
                    Carbon::parse($to)->endOfDay()
                ])->delete();
                $message = "Deleted {$count} logs between {$from} and {$to}.";
            } else {
                return redirect()->back()->with('error', 'Please provide both From and To dates for range deletion.');
            }
        } elseif ($request->purge_type === 'only_success') {
            $count = $query->where('status', 'success')->delete();
            $message = "Deleted {$count} successful logs (error records retained).";
        } elseif ($request->purge_type === 'all') {
            $count = $query->delete();
            $message = "Purged all {$count} activity logs.";
        }

        return redirect()->back()->with('success', $message);
    }
}
