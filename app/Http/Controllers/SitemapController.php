<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = rtrim(config('app.url', 'https://hyst.uk'), '/');
        $now = now()->toIso8601String();

        $urls = [];

        // 1. Static Core Pages
        $staticPages = [
            '/' => ['changefreq' => 'daily', 'priority' => '1.0'],
            '/restaurants' => ['changefreq' => 'daily', 'priority' => '0.9'],
            '/cuisine' => ['changefreq' => 'weekly', 'priority' => '0.8'],
            '/locations' => ['changefreq' => 'weekly', 'priority' => '0.8'],
            '/about' => ['changefreq' => 'monthly', 'priority' => '0.7'],
            '/contact' => ['changefreq' => 'monthly', 'priority' => '0.7'],
            '/become-a-partner' => ['changefreq' => 'monthly', 'priority' => '0.7'],
            '/become-ambassador' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/blogs' => ['changefreq' => 'weekly', 'priority' => '0.7'],
            '/hyst-vs-deliveroo' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/hyst-vs-just-eat' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/why-food-is-more-expensive-on-marketplaces' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/commission-free-restaurant-ordering' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/restaurant-ordering-platform-uk' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/restaurant-marketing-guide' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/restaurant-loyalty-programme' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/restaurant-qr-ordering' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/direct-online-ordering-for-restaurants' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/restaurant-pos-integration' => ['changefreq' => 'monthly', 'priority' => '0.6'],
            '/food-ordering-platform-hounslow' => ['changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        foreach ($staticPages as $path => $meta) {
            $urls[] = [
                'loc' => $baseUrl . $path,
                'lastmod' => $now,
                'changefreq' => $meta['changefreq'],
                'priority' => $meta['priority'],
            ];
        }

        // 2. Active Restaurant Pages
        try {
            $restaurants = Restaurant::where('status', 1)->get();
            foreach ($restaurants as $restaurant) {
                if (empty($restaurant->slug)) {
                    continue;
                }
                $lastmod = $restaurant->updated_at ? $restaurant->updated_at->toIso8601String() : $now;
                $urls[] = [
                    'loc' => $baseUrl . '/restaurants/' . $restaurant->slug,
                    'lastmod' => $lastmod,
                    'changefreq' => 'daily',
                    'priority' => '0.9',
                ];
            }
        } catch (\Throwable $e) {
            // Safe fallback if DB unreachable during build
        }

        // 3. Cuisines & Categories
        $cuisines = [
            'indian', 'pizza', 'biryani', 'chinese', 'kebab', 'burgers',
            'halal', 'vegetarian', 'south-indian', 'north-indian', 'wraps',
            'snacks', 'chaats', 'ice-cream', 'cakes', 'desserts'
        ];

        try {
            $dbCategories = RestaurantCategory::where('status', 'active')->get();
            foreach ($dbCategories as $cat) {
                $slug = \Illuminate\Support\Str::slug($cat->name);
                if (!in_array($slug, $cuisines)) {
                    $cuisines[] = $slug;
                }
            }
        } catch (\Throwable $e) {
            // Safe fallback
        }

        foreach ($cuisines as $slug) {
            $urls[] = [
                'loc' => $baseUrl . '/cuisine/' . $slug,
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 4. Location Landing Pages
        $locations = ['hounslow', 'cranford', 'hanworth', 'isleworth', 'feltham', 'west-london'];
        foreach ($locations as $loc) {
            $urls[] = [
                'loc' => $baseUrl . '/locations/' . $loc,
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 5. Active Blogs
        try {
            $blogs = Blog::latest()->get();
            foreach ($blogs as $blog) {
                if (empty($blog->slug)) {
                    continue;
                }
                $lastmod = $blog->updated_at ? $blog->updated_at->toIso8601String() : $now;
                $urls[] = [
                    'loc' => $baseUrl . '/blog/' . $blog->slug,
                    'lastmod' => $lastmod,
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        } catch (\Throwable $e) {
            // Safe fallback
        }

        // Build XML output
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

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
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
