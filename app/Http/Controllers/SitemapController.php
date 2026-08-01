<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = config('app.url', 'https://hyst.uk');

        $staticPages = [
            '/',
            '/restaurants',
            '/become-a-partner',
            '/become-ambassador',
            '/hyst-vs-deliveroo',
            '/hyst-vs-just-eat',
            '/why-food-is-more-expensive-on-marketplaces',
            '/commission-free-restaurant-ordering',
            '/restaurant-ordering-platform-uk',
            '/restaurant-marketing-guide',
            '/restaurant-loyalty-programme',
            '/restaurant-qr-ordering',
            '/direct-online-ordering-for-restaurants',
            '/restaurant-pos-integration',
            '/food-ordering-platform-hounslow',
        ];

        $urls = [];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => rtrim($baseUrl, '/') . $page,
                'lastmod' => now()->toAtomString(),
                'changefreq' => $page === '/' ? 'daily' : 'weekly',
                'priority' => $page === '/' ? '1.0' : '0.8',
            ];
        }

        // Active Restaurants
        $restaurants = Restaurant::where('status', 1)->get();
        foreach ($restaurants as $restaurant) {
            $urls[] = [
                'loc' => rtrim($baseUrl, '/') . '/restaurant/' . $restaurant->slug,
                'lastmod' => $restaurant->updated_at ? $restaurant->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
