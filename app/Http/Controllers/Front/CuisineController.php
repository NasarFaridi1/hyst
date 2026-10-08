<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CuisineController extends Controller
{
    protected SEOService $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display listing of all cuisines in Hounslow
     */
    public function index(Request $request)
    {
        savePageVisit($request, 'Cuisines Index');

        $cuisines = [
            ['name' => 'Indian', 'slug' => 'indian', 'icon' => 'utensils', 'description' => 'Authentic Indian curries, dosas, and regional specialties in Hounslow.'],
            ['name' => 'Biryani', 'slug' => 'biryani', 'icon' => 'drumstick', 'description' => 'Fragrant Hyderabadi, Dum & Dum-pukht biryanis cooked to perfection.'],
            ['name' => 'Pizza', 'slug' => 'pizza', 'icon' => 'pizza', 'description' => 'Freshly baked artisanal, stone-baked, and traditional sourdough pizzas.'],
            ['name' => 'Halal', 'slug' => 'halal', 'icon' => 'check-circle', 'description' => '100% certified Halal dining, grills, burgers, and takeaway spots in Hounslow.'],
            ['name' => 'Vegetarian', 'slug' => 'vegetarian', 'icon' => 'leaf', 'description' => 'Pure vegetarian, Jain, and vegan options across top local spots.'],
            ['name' => 'South Indian', 'slug' => 'south-indian', 'icon' => 'soup', 'description' => 'Crispy dosas, idlis, sambar, and traditional Kerala/Tamil delicacies.'],
            ['name' => 'North Indian', 'slug' => 'north-indian', 'icon' => 'flame', 'description' => 'Rich butter chicken, dal makhani, naan bread, and tandoori specialties.'],
            ['name' => 'Chinese', 'slug' => 'chinese', 'icon' => 'chopsticks', 'description' => 'Noodles, fried rice, manchurian, and Indo-Chinese favorites.'],
            ['name' => 'Kebabs & Grills', 'slug' => 'kebab', 'icon' => 'flame', 'description' => 'Sizzling Seekh kebabs, Shawarmas, Peri Peri chicken, and mixed grills.'],
            ['name' => 'Burgers', 'slug' => 'burgers', 'icon' => 'sandwich', 'description' => 'Smash burgers, gourmet beef burgers, and spicy chicken burgers.'],
            ['name' => 'Wraps & Snacks', 'slug' => 'wraps', 'icon' => 'wrap', 'description' => 'Kathi rolls, wraps, samosas, and quick local snacks.'],
            ['name' => 'Chaats & Street Food', 'slug' => 'chaats', 'icon' => 'sparkles', 'description' => 'Pani puri, bhel puri, chaat items, and popular street snacks.'],
            ['name' => 'Desserts & Cakes', 'slug' => 'desserts', 'icon' => 'cake', 'description' => 'Ice creams, kulfi, boutique cakes, and sweet treats.'],
        ];

        $seo = $this->seoService->generate('cuisine', ['slug' => 'index', 'name' => 'Cuisines in Hounslow']);

        return view('front.cuisine.index', compact('cuisines', 'seo'));
    }

    /**
     * Display specific cuisine landing page (e.g. /cuisine/indian)
     */
    public function show(Request $request, string $slug)
    {
        $normalizedSlug = Str::slug($slug);
        $displayName = Str::title(str_replace('-', ' ', $normalizedSlug));

        savePageVisit($request, 'Cuisine View: ' . $displayName);

        // Fetch active restaurants matching cuisine name or categories
        try {
            $restaurants = Restaurant::where('status', 1)
                ->where(function ($query) use ($normalizedSlug, $displayName) {
                    $query->where('name', 'LIKE', "%{$displayName}%")
                        ->orWhere('description', 'LIKE', "%{$displayName}%")
                        ->orWhere('description', 'LIKE', "%{$normalizedSlug}%");
                })
                ->latest()
                ->get();

            // If empty, fetch all active restaurants so the page is never thin or blank
            if ($restaurants->isEmpty()) {
                $restaurants = Restaurant::where('status', 1)->latest()->take(12)->get();
            }
        } catch (\Throwable $e) {
            $restaurants = collect();
        }

        $seo = $this->seoService->generate('cuisine', [
            'slug' => $normalizedSlug,
            'name' => $displayName,
            'count' => $restaurants->count(),
        ]);

        return view('front.cuisine.show', compact('slug', 'displayName', 'restaurants', 'seo'));
    }
}
