<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\RestaurantCategory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderOffer;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $products = Product::latest()->get();

        $categories = RestaurantCategory::where('status', 'active')->get();

        $qrCode = QrCode::format('svg')
            ->size(220)
            ->generate(url('/restaurants'));

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        // If location is not provided
        if (!$latitude || !$longitude) {

            $restaurants = Restaurant::with([
                'featuredOffer',
                'reviews'
            ])->latest()->get();

            return response()->json([
                'status' => true,
                'message' => 'Home data fetched successfully.',
                'data' => [
                    'products' => $products,
                    'categories' => $categories,
                    'qr_code' => $qrCode,
                    'restaurants' => $restaurants,
                ]
            ]);
        }

        // Restaurants sorted by distance
        $restaurants = Restaurant::with([
                'featuredOffer',
                'reviews'
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

        return response()->json([
            'status' => true,
            'message' => 'Home data fetched successfully.',
            'data' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'products' => $products,
                'categories' => $categories,
                'qr_code' => $qrCode,
                'restaurants' => $restaurants,
            ]
        ]);
    }

    public function categoryProducts($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found.'
            ], 404);
        }

        $products = Product::where('category_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Category products fetched successfully.',
            'data' => [
                'category' => $category,
                'products' => $products
            ]
        ]);
    }

    public function productDetails($id)
    {
        $product = Product::with([
            'variants',
            'allergies',
            'dietaries',
            'category'
        ])->find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        $reviews = \App\Models\Review::with('user')
            ->where('restaurant_id', $product->restaurant_id)
            ->where('status', 'approved')
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Product details fetched successfully.',
            'data' => [
                'product' => $product,
                'reviews' => $reviews
            ]
        ]);
    }

    public function restaurants(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        if (!$latitude || !$longitude) {

            $restaurants = Restaurant::with([
                'featuredOffer',
                'reviews'
            ])->latest()->get();

            return response()->json([
                'status' => true,
                'message' => 'Restaurants fetched successfully.',
                'data' => $restaurants
            ]);
        }

        $restaurants = Restaurant::with([
                'featuredOffer',
                'reviews'
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

        return response()->json([
            'status' => true,
            'message' => 'Restaurants fetched successfully.',
            'latitude' => $latitude,
            'longitude' => $longitude,
            'data' => $restaurants
        ]);
    }

    public function restaurantProducts($slug)
    {
        $restaurant = Restaurant::with('reviews')
            ->where('slug', $slug)
            ->first();

        if (!$restaurant) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant not found.'
            ], 404);
        }

        $categories = Category::where('restaurant_id', $restaurant->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $products = Product::with([
                'allergies',
                'dietaries',
                'variants'
            ])
            ->where('restaurant_id', $restaurant->id)
            ->latest()
            ->get();

        $offers = Offer::where('restaurant_id', $restaurant->id)
            ->where('is_active', 1)
            ->latest()
            ->get();

        $eligibleOffer = null;

        if (auth('sanctum')->check()) {

            $completedOrder = Order::where('user_id', auth('sanctum')->id())
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

        return response()->json([
            'status' => true,
            'message' => 'Restaurant products fetched successfully.',
            'data' => [
                'restaurant' => $restaurant,
                'categories' => $categories,
                'products' => $products,
                'offers' => $offers,
                'eligible_offer' => $eligibleOffer,
            ]
        ]);
    }

    public function restaurantCategoryProducts($slug, $categorySlug)
    {
        $restaurant = Restaurant::where('slug', $slug)->first();

        if (!$restaurant) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant not found.'
            ], 404);
        }

        $category = Category::where('slug', $categorySlug)
            ->where('restaurant_id', $restaurant->id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found.'
            ], 404);
        }

        $categories = Category::where('restaurant_id', $restaurant->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $products = Product::with([
                'allergies',
                'dietaries',
                'variants'
            ])
            ->where('restaurant_id', $restaurant->id)
            ->where('category_id', $category->id)
            ->latest()
            ->get();

        $eligibleOffer = null;

        if (auth('sanctum')->check()) {

            $completedOrder = Order::where('user_id', auth('sanctum')->id())
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

        return response()->json([
            'status' => true,
            'message' => 'Restaurant category products fetched successfully.',
            'data' => [
                'restaurant' => $restaurant,
                'selected_category' => $category,
                'categories' => $categories,
                'products' => $products,
                'eligible_offer' => $eligibleOffer,
            ]
        ]);
    }
}