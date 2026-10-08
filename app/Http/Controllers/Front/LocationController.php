<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    protected SEOService $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display directory of covered locations
     */
    public function index(Request $request)
    {
        savePageVisit($request, 'Locations Index');

        $locations = [
            [
                'name' => 'Hounslow',
                'slug' => 'hounslow',
                'postcode' => 'TW3 / TW4',
                'description' => 'Explore top restaurants, takeaways & food delivery spots in central Hounslow, TW3.',
            ],
            [
                'name' => 'Isleworth',
                'slug' => 'isleworth',
                'postcode' => 'TW7',
                'description' => 'Discover local restaurants and dining options in Isleworth & nearby West London.',
            ],
            [
                'name' => 'Feltham',
                'slug' => 'feltham',
                'postcode' => 'TW13 / TW14',
                'description' => 'Order direct from favourite restaurants and takeaways in Feltham.',
            ],
            [
                'name' => 'Hanworth',
                'slug' => 'hanworth',
                'postcode' => 'TW13',
                'description' => 'Great local food discovery and direct ordering in Hanworth.',
            ],
            [
                'name' => 'Cranford',
                'slug' => 'cranford',
                'postcode' => 'TW5',
                'description' => 'Explore authentic dining and food delivery choices in Cranford.',
            ],
            [
                'name' => 'West London',
                'slug' => 'west-london',
                'postcode' => 'West London',
                'description' => 'Connecting West London food lovers with genuine menu prices and direct restaurant ordering.',
            ],
        ];

        $seo = $this->seoService->generate('location', ['slug' => 'index', 'name' => 'Locations in West London']);

        return view('front.location.index', compact('locations', 'seo'));
    }

    /**
     * Display specific location landing page (e.g. /locations/hounslow)
     */
    public function show(Request $request, string $slug)
    {
        $normalizedSlug = Str::slug($slug);
        $displayName = Str::title(str_replace('-', ' ', $normalizedSlug));

        savePageVisit($request, 'Location View: ' . $displayName);

        // Fetch restaurants matching city, postcode, location, or address
        try {
            $restaurants = Restaurant::where('status', 1)
                ->where(function ($query) use ($normalizedSlug, $displayName) {
                    $query->where('city', 'LIKE', "%{$displayName}%")
                        ->orWhere('location', 'LIKE', "%{$displayName}%")
                        ->orWhere('address', 'LIKE', "%{$displayName}%")
                        ->orWhere('postcode', 'LIKE', "%{$displayName}%");
                })
                ->latest()
                ->get();

            // If empty for specific sub-location, fallback to all active Hounslow / West London restaurants
            if ($restaurants->isEmpty()) {
                $restaurants = Restaurant::where('status', 1)->latest()->take(12)->get();
            }
        } catch (\Throwable $e) {
            $restaurants = collect();
        }

        $seo = $this->seoService->generate('location', [
            'slug' => $normalizedSlug,
            'name' => $displayName,
            'count' => $restaurants->count(),
        ]);

        return view('front.location.show', compact('slug', 'displayName', 'restaurants', 'seo'));
    }
}
