<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class PageVisitController extends Controller
{
    public function index(Request $request)
    {
        $query = PageVisit::query();

        /*
        |--------------------------------------------------------------------------
        | Date Filter
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
        | Restaurant
        |--------------------------------------------------------------------------
        */

        if ($request->filled('restaurant')) {
            $query->where('restaurant_name', 'like', '%' . $request->restaurant . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Page
        |--------------------------------------------------------------------------
        */

       if ($request->filled('page_name')) {
            $query->where('page_name', 'like', '%' . $request->page_name . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | User
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        /*
        |--------------------------------------------------------------------------
        | IP
        |--------------------------------------------------------------------------
        */

        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        */

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Browser
        |--------------------------------------------------------------------------
        */

        if ($request->filled('browser')) {
            $query->where('browser', 'like', '%' . $request->browser . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Platform
        |--------------------------------------------------------------------------
        */

        if ($request->filled('platform')) {
            $query->where('platform', 'like', '%' . $request->platform . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Table (paginated results) - run the filtered query ONCE
        |--------------------------------------------------------------------------
        */

        $pageVisits = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $userIds = $pageVisits->pluck('user_id')->filter()->unique()->values();

        $users = User::whereIn('id', $userIds)->pluck('name', 'id');

        $productIds = $pageVisits->pluck('product_id')
                ->filter()
                ->unique()
                ->values();

        $products = Product::whereIn('id', $productIds)
            ->pluck('name', 'id');

        /*
        |--------------------------------------------------------------------------
        | Unique Visitor Profiles & Browsing Journeys (Grouped by IP)
        |--------------------------------------------------------------------------
        */
        $perPage = 15;
        $page = (int) $request->get('page', 1);

        $totalUniqueVisitors = (clone $query)
            ->whereNotNull('ip_address')
            ->where('ip_address', '!=', '')
            ->distinct('ip_address')
            ->count('ip_address');

        $uniqueIps = (clone $query)
            ->select(
                'ip_address',
                DB::raw('COUNT(*) as total_views'),
                DB::raw('COUNT(DISTINCT session_id) as total_sessions'),
                DB::raw('MIN(created_at) as first_seen'),
                DB::raw('MAX(created_at) as last_active')
            )
            ->whereNotNull('ip_address')
            ->where('ip_address', '!=', '')
            ->groupBy('ip_address')
            ->orderByDesc(DB::raw('MAX(created_at)'))
            ->forPage($page, $perPage)
            ->get();

        $uniqueVisitors = new LengthAwarePaginator(
            $uniqueIps,
            $totalUniqueVisitors,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $pageIps = $uniqueIps->pluck('ip_address')->filter()->values()->toArray();

        $visitsByIp = [];
        if (!empty($pageIps)) {
            $rawVisits = PageVisit::whereIn('ip_address', $pageIps)
                ->orderByDesc('created_at')
                ->get();

            $visitsByIp = $rawVisits->groupBy('ip_address');
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards
        |--------------------------------------------------------------------------
        */

        $totalVisits = PageVisit::count();

        $todayVisits = PageVisit::whereDate('created_at', today())->count();

        $uniqueUsers = PageVisit::whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        $uniqueRestaurants = PageVisit::whereNotNull('restaurant_id')
            ->distinct('restaurant_id')
            ->count('restaurant_id');

        $uniqueProducts = PageVisit::whereNotNull('product_id')
            ->distinct('product_id')
            ->count('product_id');

        $uniqueCountries = PageVisit::whereNotNull('country')
            ->distinct('country')
            ->count('country');

        /*
        |--------------------------------------------------------------------------
        | Top Pages
        |--------------------------------------------------------------------------
        */

        $topPages = PageVisit::select('page_name', DB::raw('COUNT(*) as total'))
            ->whereNotNull('page_name')
            ->groupBy('page_name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Restaurants
        |--------------------------------------------------------------------------
        */

        $topRestaurants = PageVisit::select('restaurant_name', DB::raw('COUNT(*) as total'))
            ->whereNotNull('restaurant_name')
            ->groupBy('restaurant_name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Browser Graph
        |--------------------------------------------------------------------------
        */

        $browserGraph = PageVisit::select('browser', DB::raw('COUNT(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Platform Graph
        |--------------------------------------------------------------------------
        */

        $platformGraph = PageVisit::select('platform', DB::raw('COUNT(*) as total'))
            ->whereNotNull('platform')
            ->groupBy('platform')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Country Graph
        |--------------------------------------------------------------------------
        */

        $countryGraph = PageVisit::select('country', DB::raw('COUNT(*) as total'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Last 30 Days Visits (fills missing dates with 0 so the line graph
        | is continuous even on days with no traffic)
        |--------------------------------------------------------------------------
        */

        $rawDaily = PageVisit::select(
                DB::raw('DATE(created_at) as visit_date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('visit_date')
            ->orderBy('visit_date')
            ->get()
            ->keyBy('visit_date');

        $dailyVisits = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyVisits->push((object) [
                'visit_date' => $date,
                'total' => optional($rawDaily->get($date))->total ?? 0,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.page-visits.index',
            compact(
                'pageVisits',
                'uniqueVisitors',
                'visitsByIp',
                'totalUniqueVisitors',
                'users',
                'products',

                'totalVisits',
                'todayVisits',
                'uniqueUsers',
                'uniqueRestaurants',
                'uniqueProducts',
                'uniqueCountries',
                'topPages',
                'topRestaurants',
                'browserGraph',
                'platformGraph',
                'countryGraph',
                'dailyVisits'
            )
        );
    }

    public static function getCountryCode($countryName)
    {
        if (empty($countryName)) return '';
        $map = [
            'India' => 'IN',
            'United Kingdom' => 'GB',
            'UK' => 'GB',
            'England' => 'GB',
            'Australia' => 'AU',
            'United States' => 'US',
            'USA' => 'US',
            'France' => 'FR',
            'Philippines' => 'PH',
            'Canada' => 'CA',
            'Germany' => 'DE',
            'Netherlands' => 'NL',
            'Singapore' => 'SG',
            'United Arab Emirates' => 'AE',
            'UAE' => 'AE',
            'Spain' => 'ES',
            'Italy' => 'IT',
            'Ireland' => 'IE',
            'Pakistan' => 'PK',
            'Bangladesh' => 'BD',
            'Albania' => 'AL',
            'Russia' => 'RU',
            'China' => 'CN',
            'Japan' => 'JP',
            'Brazil' => 'BR',
            'South Africa' => 'ZA',
            'New Zealand' => 'NZ',
            'Sweden' => 'SE',
            'Switzerland' => 'CH',
            'Norway' => 'NO',
            'Finland' => 'FI',
            'Poland' => 'PL',
            'Belgium' => 'BE',
            'Austria' => 'AT',
            'Portugal' => 'PT',
            'Greece' => 'GR',
            'Turkey' => 'TR',
            'Saudi Arabia' => 'SA',
            'Malaysia' => 'MY',
            'Thailand' => 'TH',
            'Vietnam' => 'VN',
            'Indonesia' => 'ID',
        ];
        if (isset($map[$countryName])) {
            return $map[$countryName];
        }
        if (strlen($countryName) === 2) {
            return strtoupper($countryName);
        }
        return strtoupper(substr($countryName, 0, 2));
    }

    public static function formatDeviceAndOs($platform, $browser, $userAgent = '')
    {
        $platform = trim((string)$platform);
        $browser = trim((string)$browser);
        $ua = strtolower((string)$userAgent);

        $isMobile = false;
        if (in_array(strtolower($platform), ['android', 'ios', 'iphone', 'ipad', 'windows phone']) 
            || strpos($ua, 'mobile') !== false 
            || strpos($ua, 'android') !== false 
            || strpos($ua, 'iphone') !== false) {
            $isMobile = true;
        }

        $deviceType = $isMobile ? 'Mobile' : 'Desktop';

        // Normalize OS
        if (stripos($platform, 'OS X') !== false || stripos($platform, 'mac') !== false) {
            $os = 'macOS';
        } elseif (stripos($platform, 'Windows') !== false) {
            $os = 'Windows';
        } elseif (stripos($platform, 'Android') !== false) {
            $os = 'Android';
        } elseif (stripos($platform, 'iOS') !== false || stripos($platform, 'iphone') !== false) {
            $os = 'iOS';
        } elseif (stripos($platform, 'Linux') !== false) {
            $os = 'Linux';
        } else {
            $os = $platform ?: 'Windows';
        }

        $browserName = $browser ?: 'Chrome';

        return "{$deviceType} • {$browserName} ({$os})";
    }
}