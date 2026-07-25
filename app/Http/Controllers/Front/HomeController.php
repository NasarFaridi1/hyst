<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Restaurant;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Offer;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\RestaurantCategory;
use App\Models\HomeVisitor;
use App\Models\RestaurantView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartnerRequestMail;

class HomeController extends Controller
{


    public function home(Request $request)
    {
        savePageVisit($request,'Home');
        $products = Product::latest()->get();

        $categories = Category::whereNull('parent_id')->get();

        $qrCode = QrCode::size(220)
            ->generate(url('/restaurants'));


        $latitude = session('user_lat');
        $longitude = session('user_lon');

        if (!$latitude || !$longitude) {
            try {
                $ip = $request->ip();
                $response = Http::timeout(1)->get("http://ip-api.com/json/" . $ip);
                if ($response->successful()) {
                    $data = $response->json();
                    $latitude = $data['lat'] ?? null;
                    $longitude = $data['lon'] ?? null;
                    if ($latitude && $longitude) {
                        session(['user_lat' => $latitude, 'user_lon' => $longitude]);
                    }
                }
            } catch (\Exception $e) {
                Log::warning('IP API Timeout/Error: ' . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IF LOCATION NOT FOUND
        |--------------------------------------------------------------------------
        */

       


        if (!$latitude || !$longitude) {

            $restaurants = Restaurant::where('status', 1)
    ->latest()
    ->get();

            return view(
                'front.home',
                compact('restaurants', 'products', 'categories', 'qrCode')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ALL RESTAURANTS WITH DISTANCE
        |--------------------------------------------------------------------------
        */

        // $restaurants = Restaurant::select(
        // $restaurants = Restaurant::with('featuredOffer')
        $restaurants = Restaurant::with([
            'featuredOffer',
            'reviews'
        ])
        ->where('status', 1)
            ->select(
                        '*',
                        DB::raw("
                    (
                        6371 * acos(
                            cos(radians($latitude))
                            * cos(radians(latitude))
                            * cos(radians(longitude) - radians($longitude))
                            + sin(radians($latitude))
                            * sin(radians(latitude))
                        )
                    ) AS distance
                ")
                    )
                    ->orderByRaw("
                CASE
                    WHEN distance <= 5 THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('distance')
            ->orderByRaw("
                CASE
                    WHEN display_order IS NULL THEN 999999
                    ELSE display_order
                END ASC
            ")
            ->get();

        // Log::info('Restaurants Count: ' . $restaurants->count());

        // foreach ($restaurants as $restaurant) {

        //     Log::info('Restaurant Found', [
        //         'name' => $restaurant->name,
        //         'distance' => $restaurant->distance
        //     ]);
        // }    

        $categories = RestaurantCategory::where('status', 'active')->orderBy('display_order')->get();

        return view('front.home', compact(
            'products',
            'categories',
            'qrCode',
            'restaurants',
            'latitude',
            'longitude',
            'categories'
        ));
    }

    public function categoryProducts($id)
    {
        $category = Category::findOrFail($id);

        $products = Product::where(
            'category_id',
            $id
        )->latest()->get();

        return view(
            'front.category-products',
            compact('products', 'category')
        );
    }

    public function productDetails($id)
    {
        $product = Product::with([
            'variants',
            'allergies',
            'dietaries',
            'category'
        ])->findOrFail($id);
        $reviews = \App\Models\Review::with('user')

        ->where(

            'restaurant_id',
            $product->restaurant_id

        )

        ->where(

            'status',
            'approved'

        )

        ->latest()

        ->take(10)

        ->get();

        return view(
            'front.product-details',
            compact('product','reviews')
        );
    }

    public function restaurants(Request $request)
    {
        $latitude = session('user_lat');
        $longitude = session('user_lon');

        if (!$latitude || !$longitude) {
            try {
                $ip = $request->ip();
                $response = Http::timeout(1)->get("http://ip-api.com/json/" . $ip);
                if ($response->successful()) {
                    $data = $response->json();
                    $latitude = $data['lat'] ?? null;
                    $longitude = $data['lon'] ?? null;
                    if ($latitude && $longitude) {
                        session(['user_lat' => $latitude, 'user_lon' => $longitude]);
                    }
                }
            } catch (\Exception $e) {
                Log::warning('IP API Timeout/Error: ' . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IF LOCATION NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!$latitude || !$longitude) {

            $restaurants = Restaurant::with([
                'featuredOffer',
                'reviews'
            ])->latest()->get();

        } else {

            /*
            |--------------------------------------------------------------------------
            | RESTAURANTS WITH DISTANCE
            |--------------------------------------------------------------------------
            */

            $restaurants = Restaurant::with([
                'featuredOffer',
                'reviews',
                'coupons' => function ($query) {
                    $query->where('status', 'active')
                        ->where(function ($q) {
                            $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>=', now());
                        })
                        ->orderBy('value');
                }
            ])
            ->select(
                '*',
                DB::raw("
                    (
                        6371 * acos(
                            cos(radians($latitude))
                            * cos(radians(latitude))
                            * cos(radians(longitude) - radians($longitude))
                            + sin(radians($latitude))
                            * sin(radians(latitude))
                        )
                    ) AS distance
                ")
            )
            ->orderByRaw("
                CASE
                    WHEN distance <= 5 THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('distance')
            ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK OPEN / CLOSED
        |--------------------------------------------------------------------------
        */

        $restaurants = $restaurants->map(function ($restaurant) {

            $restaurant->is_open = false;

            if (
                empty($restaurant->working_days) ||
                empty($restaurant->opening_time) ||
                empty($restaurant->closing_time)
            ) {
                return $restaurant;
            }

            $now = Carbon::now('Europe/London');

            $today = $now->format('l');

            $workingDays = array_map('trim', explode(',', $restaurant->working_days));

            if (!in_array($today, $workingDays)) {
                return $restaurant;
            }

            $open = Carbon::createFromFormat(
                'H:i:s',
                $restaurant->opening_time,
                'Europe/London'
            );

            $close = Carbon::createFromFormat(
                'H:i:s',
                $restaurant->closing_time,
                'Europe/London'
            );

            // Overnight timing support (e.g. 8 PM → 2 AM)
            if ($close->lessThan($open)) {
                $close->addDay();
            }

            if ($now->between($open, $close)) {
                $restaurant->is_open = true;
            }

            return $restaurant;
        });

        return view(
            'front.restaurants',
            compact(
                'restaurants',
                'latitude',
                'longitude'
            )
        );
    }
    // public function restaurantProducts($slug)
    // {
    //     $restaurant = Restaurant::with([
    //             'reviews',
    //             'banners' => function ($query) {
    //                 $query->where('status', 1);
    //             }
    //         ])

    //         ->where(
    //             'slug',
    //             $slug
    //         )

    //         ->firstOrFail();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | ONLY THIS RESTAURANT CATEGORIES
    //     |--------------------------------------------------------------------------
    //     */

    //     $categories = Category::where(
    //         'restaurant_id',
    //         $restaurant->id
    //     )
    //         ->whereNull('parent_id')
    //         ->latest()
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | ONLY THIS RESTAURANT PRODUCTS
    //     |--------------------------------------------------------------------------
    //     */

    //     $products = Product::with([
    //             'allergies',
    //             'dietaries',
    //             'variants',
    //             'addons'
    //         ])
    //         ->where(
    //             'restaurant_id',
    //             $restaurant->id
    //         )
    //         ->latest()
    //         ->get();

    //     $offers = Offer::where(
    //         'restaurant_id',
    //         $restaurant->id
    //     )
    //         ->where('is_active', 1)
    //         // ->where('type', 'offer')
    //         ->latest()
    //         ->get();


    //         $eligibleOffer = null;

    //         if(auth()->check()) {

    //             $completedOrder = Order::where('user_id', auth()->id())
    //                 ->where('restaurant_id', $restaurant->id)
    //                 ->whereIn('status', ['completed', 'delivered'])
    //                 ->latest()
    //                 ->first();
                    

    //             if($completedOrder) {

    //                 $eligibleOffer = OrderOffer::active()
    //                     ->where('restaurant_id', $restaurant->id)
    //                     ->where('min_order_value', '<=', $completedOrder->total_amount)
    //                     ->orderByDesc('value')
    //                     ->first();
    //             }
    //         } 
            

    //     return view(
    //         'front.restaurant-products',
    //         compact(
    //             'restaurant',
    //             'products',
    //             'categories',
    //             'offers',
    //             'eligibleOffer'
    //         )
    //     );
    // }

    // public function restaurantProducts(Request $request, $slug)
    // {
    //     $restaurant = Restaurant::with([
    //         'reviews',
    //         'banners' => function ($query) {
    //             $query->where('status', 1);
    //         }
    //     ])
    //     ->where('slug', $slug)
    //     ->firstOrFail();

    //     // $categories = Category::where('restaurant_id', $restaurant->id)
    //     //     ->whereNull('parent_id')
    //     //     ->latest()
    //     //     ->get();
    //     $categories = Category::where('restaurant_id', $restaurant->id)
    //             ->whereNull('parent_id')
    //             ->orderByRaw('display_order IS NULL, display_order ASC')
    //             ->orderBy('id', 'ASC')
    //             ->get();

    //     $search = $request->search;

    //     // $products = Product::with([
    //     //         'allergies',
    //     //         'dietaries',
    //     //         'variants',
    //     //         'addons'
    //     //     ])
    //     //     ->where('restaurant_id', $restaurant->id)
    //     //     ->when($search, function ($query) use ($search) {
    //     //         $query->where(function ($q) use ($search) {
    //     //             $q->where('name', 'LIKE', "%{$search}%")
    //     //             ->orWhere('description', 'LIKE', "%{$search}%");
    //     //         });
    //     //     })
    //     //     ->latest()
    //     //     ->get();
    //             $products = Product::with([
    //             'allergies',
    //             'dietaries',
    //             'variants',
    //             'addons'
    //         ])
    //         ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
    //         ->select('products.*')
    //         ->where('products.restaurant_id', $restaurant->id)
    //         ->when($search, function ($query) use ($search) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('products.name', 'LIKE', "%{$search}%")
    //                 ->orWhere('products.description', 'LIKE', "%{$search}%");
    //             });
    //         })
    //         ->orderByRaw('categories.display_order IS NULL')
    //         ->orderBy('categories.display_order')
    //         ->orderBy('products.id')
    //         ->get();

    //     $offers = Offer::where('restaurant_id', $restaurant->id)
    //         ->where('is_active', 1)
    //         ->latest()
    //         ->get();

    //     $eligibleOffer = null;

    //     if (auth()->check()) {

    //         $completedOrder = Order::where('user_id', auth()->id())
    //             ->where('restaurant_id', $restaurant->id)
    //             ->whereIn('status', ['completed', 'delivered'])
    //             ->latest()
    //             ->first();

    //         if ($completedOrder) {
    //             $eligibleOffer = OrderOffer::active()
    //                 ->where('restaurant_id', $restaurant->id)
    //                 ->where('min_order_value', '<=', $completedOrder->total_amount)
    //                 ->orderByDesc('value')
    //                 ->first();
    //         }
    //     }

    //     return view(
    //         'front.restaurant-products',
    //         compact(
    //             'restaurant',
    //             'products',
    //             'categories',
    //             'offers',
    //             'eligibleOffer',
    //             'search'
    //         )
    //     );
    // }
    public function restaurantProducts(Request $request, $slug)
    {

   
        $restaurant = Restaurant::with([
            'reviews',
            'banners' => function ($query) {
                $query->where('status', 1);
            }
        ])
        ->where('slug', $slug)
        ->firstOrFail();
        // Visitor Log Save

        savePageVisit(
    $request,
    'Restaurant View',
    $restaurant->id,
    $restaurant->name
);
    
        $categories = Category::where('restaurant_id', $restaurant->id)
                ->whereNull('parent_id')
                ->orderByRaw('display_order IS NULL, display_order ASC')
                ->orderBy('id', 'ASC')
                ->get();

        $search = $request->search;

       
                $products = Product::with([
                'allergies',
                'dietaries',
                'variants',
                'addons'
            ])
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*')
            ->where('products.restaurant_id', $restaurant->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.name', 'LIKE', "%{$search}%")
                    ->orWhere('products.description', 'LIKE', "%{$search}%");
                });
            })
            ->orderByRaw('categories.display_order IS NULL')
            ->orderBy('categories.display_order')
            ->orderBy('products.id')
            ->get();

        $offers = Offer::where('restaurant_id', $restaurant->id)
            ->where('is_active', 1)
            ->latest()
            ->get();

        $eligibleOffer = null;

        if (auth()->check()) {

            $completedOrder = Order::where('user_id', auth()->id())
                ->where('restaurant_id', $restaurant->id)
                ->whereIn('status', ['completed', 'delivered'])
                ->latest()
                ->first();

            if ($completedOrder) {
                $eligibleOffer = OrderOffer::active()
                    ->where('restaurant_id', $restaurant->id)
                    ->where('min_order_value', '<=', $completedOrder->total_amount)
                    ->orderByDesc('value')
                    ->first();
            }
        }

       $isAdmin = auth()->check() &&
            in_array(auth()->user()->role, ['super_admin', 'restaurant_admin']);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html'    => view('front.partials.restaurant-products-grid', compact('products', 'isAdmin'))->render(),
                'count'   => $products->count(),
            ]);
        }

        return view(
            'front.restaurant-productsnew',
            compact('restaurant', 'products', 'categories', 'offers', 'eligibleOffer', 'search', 'isAdmin')
        );
    }
    // public function restaurantCategoryProducts(
    //     $slug,
    //     $categorySlug
    // ) {

    //     $restaurant = Restaurant::where(
    //         'slug',
    //         $slug
    //     )->firstOrFail();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | CATEGORY MUST BELONG TO SAME RESTAURANT
    //     |--------------------------------------------------------------------------
    //     */

    //     $category = Category::where(
    //         'slug',
    //         $categorySlug
    //     )
    //         ->where(
    //             'restaurant_id',
    //             $restaurant->id
    //         )
    //         ->firstOrFail();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | ALL CATEGORIES OF THIS RESTAURANT
    //     |--------------------------------------------------------------------------
    //     */

    //     $categories = Category::where(
    //         'restaurant_id',
    //         $restaurant->id
    //     )
    //         ->whereNull('parent_id')
    //         ->orderByRaw('display_order IS NULL, display_order ASC')
    //         ->orderBy('id', 'ASC')
    //         ->latest()
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | ONLY PRODUCTS OF THIS RESTAURANT + CATEGORY
    //     |--------------------------------------------------------------------------
    //     */

    //     $products = Product::where(
    //         'restaurant_id',
    //         $restaurant->id
    //     )
    //         ->where(
    //             'category_id',
    //             $category->id
    //         )
    //         ->latest()
    //         ->get();

        
    //      $eligibleOffer = null;

    //         if(auth()->check()) {

    //             $completedOrder = Order::where('user_id', auth()->id())
    //                 ->where('restaurant_id', $restaurant->id)
    //                 ->whereIn('status', ['completed', 'delivered'])
    //                 ->latest()
    //                 ->first();
                    

    //             if($completedOrder) {

    //                 $eligibleOffer = OrderOffer::active()
    //                     ->where('restaurant_id', $restaurant->id)
    //                     ->where('min_order_value', '<=', $completedOrder->total_amount)
    //                     ->orderByDesc('value')
    //                     ->first();
    //             }
    //         } 
                



    //     return view(
    //         'front.restaurant-products',
    //         compact(
    //             'restaurant',
    //             'products',
    //             'categories',
    //             'category',
    //             'eligibleOffer'

    //         )
    //     );
    // }

    public function restaurantCategoryProducts(Request $request, $slug, $categorySlug)
{
    $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

    $category = Category::where('slug', $categorySlug)
        ->where('restaurant_id', $restaurant->id)
        ->firstOrFail();

    $categories = Category::where('restaurant_id', $restaurant->id)
        ->whereNull('parent_id')
        ->orderByRaw('display_order IS NULL, display_order ASC')
        ->orderBy('id', 'ASC')
        ->get();

    $search = $request->search;

    $products = Product::with(['allergies', 'dietaries', 'variants', 'addons'])
        ->where('restaurant_id', $restaurant->id)
        ->where('category_id', $category->id)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        })
        ->latest()
        ->get();

    $isAdmin = auth()->check() &&
        in_array(auth()->user()->role, ['super_admin', 'restaurant_admin']);

    $eligibleOffer = null;
    if (auth()->check()) {
        $completedOrder = Order::where('user_id', auth()->id())
            ->where('restaurant_id', $restaurant->id)
            ->whereIn('status', ['completed', 'delivered'])
            ->latest()
            ->first();

        if ($completedOrder) {
            $eligibleOffer = OrderOffer::active()
                ->where('restaurant_id', $restaurant->id)
                ->where('min_order_value', '<=', $completedOrder->total_amount)
                ->orderByDesc('value')
                ->first();
        }
    }

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'html'    => view('front.partials.restaurant-products-grid', compact('products', 'isAdmin'))->render(),
            'count'   => $products->count(),
        ]);
    }

    return view(
        'front.restaurant-productsnew',
        compact('restaurant', 'products', 'categories', 'category', 'eligibleOffer', 'isAdmin')
    );
}

    public function becomePartnerPage()
    {
        return view('front.partner.restaurant');
    }

    public function becomeAmbassadorPage()
    {
        return view('front.partner.ambassador');
    }

    public function becomePartner(Request $request)
    {
        // IP Rate Limiting (Max 3 partner requests per minute per IP)
        $ipKey = 'partner-ip:' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($ipKey, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($ipKey);
            return response()->json([
                'success' => false,
                'message' => "Too many partner requests detected from your IP. Please wait {$seconds} seconds before trying again.",
            ], 429);
        }
        \Illuminate\Support\Facades\RateLimiter::hit($ipKey, 60);

        $validated = $request->validate([
            'partner_type' => 'required|string|in:Become Restaurant Partner,Become an Ambassador,Restaurant Partner,Ambassador',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone_number' => 'required|string|max:50',
            'location'     => 'required|string|max:255',
        ]);

        try {
            Mail::to(['infoharry99@gmail.com', 'nasar@thenexteck.com'])->send(new PartnerRequestMail($validated));

            return response()->json([
                'success' => true,
                'message' => 'Your request to become a partner has been submitted successfully! We will reach out to you soon.',
            ]);
        } catch (\Exception $e) {
            Log::error('Become Partner Mail Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send request. Please try again later.',
            ], 500);
        }
    }
}