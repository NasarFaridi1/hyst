<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageVisitController extends Controller
{
   

   public function index(Request $request)
{
    // Logged in Restaurant ID
    $restaurantId = auth()->user()->restaurant_id;

    // Base Query (Only Current Restaurant)
    $query = PageVisit::where('restaurant_id', $restaurantId);

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
    | Table Data
    |--------------------------------------------------------------------------
    */

    $pageVisits = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $userIds = $pageVisits->pluck('user_id')
        ->filter()
        ->unique()
        ->values();

    $users = User::whereIn('id', $userIds)
        ->pluck('name', 'id');

    $productIds = $pageVisits->pluck('product_id')
        ->filter()
        ->unique()
        ->values();

    $products = Product::whereIn('id', $productIds)
        ->pluck('name', 'id');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Cards
    |--------------------------------------------------------------------------
    */

    $totalVisits = PageVisit::where('restaurant_id', $restaurantId)->count();

    $todayVisits = PageVisit::where('restaurant_id', $restaurantId)
        ->whereDate('created_at', today())
        ->count();

    $uniqueUsers = PageVisit::where('restaurant_id', $restaurantId)
        ->whereNotNull('user_id')
        ->distinct('user_id')
        ->count('user_id');

    $uniqueRestaurants = 1;

    $uniqueProducts = PageVisit::where('restaurant_id', $restaurantId)
        ->whereNotNull('product_id')
        ->distinct('product_id')
        ->count('product_id');

    $uniqueCountries = PageVisit::where('restaurant_id', $restaurantId)
        ->whereNotNull('country')
        ->distinct('country')
        ->count('country');

            /*
    |--------------------------------------------------------------------------
    | Top Pages
    |--------------------------------------------------------------------------
    */

    $topPages = PageVisit::where('restaurant_id', $restaurantId)
        ->selectRaw('page_name, COUNT(*) as total')
        ->groupBy('page_name')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Top Restaurants
    |--------------------------------------------------------------------------
    */

    $topRestaurants = PageVisit::where('restaurant_id', $restaurantId)
        ->selectRaw('restaurant_name, COUNT(*) as total')
        ->groupBy('restaurant_name')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Browser Graph
    |--------------------------------------------------------------------------
    */

    $browserGraph = PageVisit::where('restaurant_id', $restaurantId)
        ->selectRaw('browser, COUNT(*) as total')
        ->groupBy('browser')
        ->orderByDesc('total')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Platform Graph
    |--------------------------------------------------------------------------
    */

    $platformGraph = PageVisit::where('restaurant_id', $restaurantId)
        ->selectRaw('platform, COUNT(*) as total')
        ->groupBy('platform')
        ->orderByDesc('total')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Country Graph
    |--------------------------------------------------------------------------
    */

    $countryGraph = PageVisit::where('restaurant_id', $restaurantId)
        ->selectRaw('country, COUNT(*) as total')
        ->groupBy('country')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Last 30 Days Graph
    |--------------------------------------------------------------------------
    */

    $rawDaily = PageVisit::where('restaurant_id', $restaurantId)
        ->whereDate('created_at', '>=', now()->subDays(29))
        ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
        ->groupBy('day')
        ->orderBy('day')
        ->pluck('total', 'day');

    $dailyLabels = [];
    $dailyValues = [];

    for ($i = 29; $i >= 0; $i--) {
        $date = now()->subDays($i)->format('Y-m-d');
        $dailyLabels[] = now()->subDays($i)->format('d M');
        $dailyValues[] = $rawDaily[$date] ?? 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Return View
    |--------------------------------------------------------------------------
    */

    return view('restaurant.page-visits.index', compact(
        'pageVisits',
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
        'dailyLabels',
        'dailyValues'
    ));
}
}