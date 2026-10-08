<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Str;

class SEOService
{
    protected string $baseUrl;
    protected string $defaultImage;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('app.url', 'https://hyst.uk'), '/');
        $this->defaultImage = $this->baseUrl . '/twitter.jpeg';
    }

    /**
     * Generate metadata for any page type.
     */
    public function generate(string $type = 'home', array $data = []): array
    {
        switch ($type) {
            case 'home':
                return $this->forHome($data);

            case 'restaurants':
                return $this->forRestaurantList($data);

            case 'restaurant_show':
                return $this->forRestaurantShow($data['restaurant'] ?? null);

            case 'cuisine':
                return $this->forCuisineShow($data['slug'] ?? '', $data['name'] ?? '', $data['count'] ?? 0);

            case 'location':
                return $this->forLocationShow($data['slug'] ?? '', $data['name'] ?? '', $data['count'] ?? 0);

            case 'blog_index':
                return $this->forBlogIndex($data);

            case 'blog_show':
                return $this->forBlogShow($data['blog'] ?? null);

            case 'marketing':
                return $this->forMarketingPage($data['title'] ?? '', $data['description'] ?? '', $data['path'] ?? '');

            case 'about':
                return $this->forAboutPage();

            case 'contact':
                return $this->forContactPage();

            default:
                return $this->forGenericPage($data['title'] ?? 'HYST', $data['description'] ?? '', $data['path'] ?? '');
        }
    }

    /**
     * Homepage SEO Metadata
     */
    protected function forHome(array $data = []): array
    {
        $title = 'Discover Restaurants in Hounslow, London | HYST';
        $description = 'Discover local restaurants, takeaway & food delivery in Hounslow, London. Order directly from top local spots with zero hidden markups on HYST.';
        $url = $this->baseUrl;

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'HYST',
                'url' => $this->baseUrl,
                'logo' => $this->defaultImage,
                'email' => 'info@hyst.uk',
                'telephone' => '+44 7879 175585',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Hounslow',
                    'addressLocality' => 'London',
                    'postalCode' => 'TW3 2DX',
                    'addressCountry' => 'GB',
                ],
                'sameAs' => [
                    'https://facebook.com/hystuk',
                    'https://instagram.com/hystuk',
                    'https://linkedin.com/company/hyst',
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => 'HYST',
                'url' => $this->baseUrl,
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => $this->baseUrl . '/restaurants?search={search_term_string}',
                    'query-input' => 'required name=search_term_string',
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                'name' => 'HYST Restaurant Discovery & Direct Ordering',
                'image' => $this->defaultImage,
                'telephone' => '+44 7879 175585',
                'email' => 'info@hyst.uk',
                'priceRange' => '£',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Hounslow',
                    'addressRegion' => 'London',
                    'postalCode' => 'TW3 2DX',
                    'addressCountry' => 'United Kingdom',
                ],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => $schemas,
        ];
    }

    /**
     * Restaurant Listing Page (/restaurants)
     */
    protected function forRestaurantList(array $data = []): array
    {
        $title = 'Restaurants in Hounslow & West London | HYST';
        $description = 'Browse top-rated restaurants, Indian dining, biryani, pizza & takeaway in Hounslow, TW3 & West London. Order direct with zero hidden fees.';
        $url = $this->baseUrl . '/restaurants';

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $this->baseUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Restaurants', 'item' => $url],
                ],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => $schemas,
        ];
    }

    /**
     * Individual Restaurant Page (/restaurants/{slug})
     */
    protected function forRestaurantShow(?Restaurant $restaurant): array
    {
        if (!$restaurant) {
            return $this->forGenericPage('Restaurant Not Found | HYST', 'Restaurant details on HYST', '/restaurants');
        }

        $name = e($restaurant->name);
        $location = $restaurant->city ?? 'Hounslow, London';
        $cuisine = $this->extractCuisineName($restaurant);
        $slug = $restaurant->slug;

        // Custom override or auto default
        $title = !empty($restaurant->seo_title)
            ? $restaurant->seo_title
            : "{$name} | {$cuisine} Restaurant in {$location} | HYST";

        // Limit title length if needed
        if (mb_strlen($title) > 68) {
            $title = "{$name} | {$cuisine} in {$location} | HYST";
        }

        $description = !empty($restaurant->seo_description)
            ? $restaurant->seo_description
            : "Discover {$name} in {$location}. View menu, opening hours, cuisine, offers and order directly through HYST.";

        if (mb_strlen($description) > 158) {
            $description = Str::limit($description, 155);
        }

        $url = $this->baseUrl . '/restaurants/' . $slug;

        $image = !empty($restaurant->image)
            ? (Str::startsWith($restaurant->image, 'http') ? $restaurant->image : asset($restaurant->image))
            : (!empty($restaurant->seo_og_image) ? asset($restaurant->seo_og_image) : $this->defaultImage);

        // Schema.org Restaurant / LocalBusiness
        $restaurantSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Restaurant',
            'name' => $restaurant->name,
            'image' => $image,
            'url' => $url,
            'telephone' => $restaurant->phone ?? '+44 7879 175585',
            'servesCuisine' => $cuisine,
            'priceRange' => '££',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $restaurant->address ?? $restaurant->location ?? 'Hounslow',
                'addressLocality' => $restaurant->city ?? 'Hounslow',
                'addressRegion' => 'London',
                'postalCode' => $restaurant->postcode ?? 'TW3',
                'addressCountry' => 'GB',
            ],
            'acceptsReservations' => !empty($restaurant->table_book) ? 'True' : 'False',
        ];

        if (!empty($restaurant->latitude) && !empty($restaurant->longitude)) {
            $restaurantSchema['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $restaurant->latitude,
                'longitude' => $restaurant->longitude,
            ];
        }

        // Add opening hours schema if present
        if (!empty($restaurant->opening_hours) && is_array($restaurant->opening_hours)) {
            $hoursSpecs = [];
            foreach ($restaurant->opening_hours as $day => $config) {
                if (!empty($config['enabled']) && !empty($config['open']) && !empty($config['close'])) {
                    $hoursSpecs[] = [
                        '@type' => 'OpeningHoursSpecification',
                        'dayOfWeek' => $day,
                        'opens' => $config['open'],
                        'closes' => $config['close'],
                    ];
                }
            }
            if (!empty($hoursSpecs)) {
                $restaurantSchema['openingHoursSpecification'] = $hoursSpecs;
            }
        }

        // Aggregate Rating schema ONLY if genuine reviews exist
        if ($restaurant->relationLoaded('reviews') && $restaurant->reviews->where('status', 'approved')->count() > 0) {
            $approved = $restaurant->reviews->where('status', 'approved');
            $count = $approved->count();
            $avg = round($approved->avg('rating'), 1);

            $restaurantSchema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $avg,
                'reviewCount' => $count,
                'bestRating' => '5',
                'worstRating' => '1',
            ];
        }

        $breadcrumbsSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $this->baseUrl],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Restaurants', 'item' => $this->baseUrl . '/restaurants'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $restaurant->name, 'item' => $url],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => !empty($restaurant->seo_noindex) ? 'noindex, nofollow' : 'index, follow',
            'og_type' => 'restaurant',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $image,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $image,
            'schema_json_ld' => [$restaurantSchema, $breadcrumbsSchema],
        ];
    }

    /**
     * Cuisine / Category SEO Page (/cuisine/{slug})
     */
    protected function forCuisineShow(string $slug, string $name = '', int $count = 0): array
    {
        $displayName = !empty($name) ? $name : Str::title(str_replace('-', ' ', $slug));
        $title = "{$displayName} Restaurants in Hounslow, London | HYST";

        if (mb_strlen($title) > 68) {
            $title = "{$displayName} Restaurants in Hounslow | HYST";
        }

        $description = "Find the best {$displayName} restaurants and takeaway in Hounslow, London. View menus & order direct with zero hidden fees on HYST.";
        $url = $this->baseUrl . '/cuisine/' . Str::slug($slug);

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => "{$displayName} Restaurants in Hounslow",
                'description' => $description,
                'url' => $url,
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $this->baseUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Cuisines', 'item' => $this->baseUrl . '/cuisine'],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $displayName, 'item' => $url],
                ],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => $schemas,
        ];
    }

    /**
     * Location Landing SEO Page (/locations/{slug})
     */
    protected function forLocationShow(string $slug, string $name = '', int $count = 0): array
    {
        $displayName = !empty($name) ? $name : Str::title(str_replace('-', ' ', $slug));
        $title = "Restaurants in {$displayName}, London | HYST";

        if (mb_strlen($title) > 68) {
            $title = "Restaurants in {$displayName} | HYST";
        }

        $description = "Discover restaurants, takeaway and local food in {$displayName}, London. Explore local restaurants and order directly through HYST.";
        $url = $this->baseUrl . '/locations/' . Str::slug($slug);

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => "Restaurants in {$displayName}, London",
                'description' => $description,
                'url' => $url,
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $this->baseUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Locations', 'item' => $this->baseUrl . '/locations'],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $displayName, 'item' => $url],
                ],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => $schemas,
        ];
    }

    /**
     * Blog Index Page (/blogs)
     */
    protected function forBlogIndex(array $data = []): array
    {
        $title = 'Hounslow Restaurant & Food Guides | HYST Blog';
        $description = 'Explore top restaurant recommendations, food guides & local dining news in Hounslow & West London on HYST.';
        $url = $this->baseUrl . '/blogs';

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $this->baseUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => $url],
                ],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => $schemas,
        ];
    }

    /**
     * Blog Post Page (/blog/{slug})
     */
    protected function forBlogShow($blog = null): array
    {
        if (!$blog) {
            return $this->forBlogIndex();
        }

        $title = e($blog->title ?? 'Food Guide | HYST');
        if (mb_strlen($title) > 65) {
            $title = Str::limit($title, 62) . ' | HYST';
        } else {
            $title .= ' | HYST';
        }

        $description = Str::limit(strip_tags($blog->content ?? $blog->excerpt ?? 'Read our local Hounslow food guide on HYST.'), 155);
        $url = $this->baseUrl . '/blog/' . ($blog->slug ?? '');
        $image = !empty($blog->image) ? asset($blog->image) : $this->defaultImage;

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $blog->title,
                'image' => $image,
                'url' => $url,
                'datePublished' => optional($blog->created_at)->toIso8601String() ?? now()->toIso8601String(),
                'dateModified' => optional($blog->updated_at)->toIso8601String() ?? now()->toIso8601String(),
                'author' => [
                    '@type' => 'Organization',
                    'name' => 'HYST',
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'HYST',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $this->defaultImage,
                    ],
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $this->baseUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => $this->baseUrl . '/blogs'],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $blog->title, 'item' => $url],
                ],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'article',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $image,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $image,
            'schema_json_ld' => $schemas,
        ];
    }

    /**
     * Marketing Landing Page
     */
    protected function forMarketingPage(string $rawTitle, string $rawDesc, string $path): array
    {
        $title = Str::contains($rawTitle, '| HYST') ? $rawTitle : "{$rawTitle} | HYST";
        $description = $rawDesc;
        $url = $this->baseUrl . '/' . ltrim($path, '/');

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $this->baseUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => $rawTitle, 'item' => $url],
                ],
            ],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => $schemas,
        ];
    }

    /**
     * About Page
     */
    protected function forAboutPage(): array
    {
        $title = 'About HYST | Supporting Local Restaurants in Hounslow';
        $description = 'Learn how HYST connects diners with local restaurants in Hounslow & West London, supporting direct ordering and transparent menu pricing.';
        $url = $this->baseUrl . '/about';

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'AboutPage',
                    'name' => 'About HYST',
                    'url' => $url,
                    'description' => $description,
                ],
            ],
        ];
    }

    /**
     * Contact Page
     */
    protected function forContactPage(): array
    {
        $title = 'Contact HYST | Get in Touch with HYST Hounslow';
        $description = 'Contact HYST for restaurant partnerships, customer support or inquiries in Hounslow, TW3 & London.';
        $url = $this->baseUrl . '/contact';

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'ContactPage',
                    'name' => 'Contact HYST',
                    'url' => $url,
                    'description' => $description,
                ],
            ],
        ];
    }

    /**
     * Generic Page Fallback
     */
    protected function forGenericPage(string $title, string $description, string $path): array
    {
        $fullTitle = Str::contains($title, '| HYST') ? $title : "{$title} | HYST";
        $fullDesc = !empty($description) ? $description : 'HYST - Direct Restaurant Ordering & Local Discovery in Hounslow & West London.';
        $url = $this->baseUrl . '/' . ltrim($path, '/');

        return [
            'title' => $fullTitle,
            'description' => $fullDesc,
            'canonical' => $url,
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_title' => $fullTitle,
            'og_description' => $fullDesc,
            'og_url' => $url,
            'og_image' => $this->defaultImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $fullTitle,
            'twitter_description' => $fullDesc,
            'twitter_image' => $this->defaultImage,
            'schema_json_ld' => [],
        ];
    }

    /**
     * Helper to extract primary cuisine name from restaurant model
     */
    protected function extractCuisineName(?Restaurant $restaurant): string
    {
        if (!$restaurant) {
            return 'Local';
        }

        // Try extracting from category_ids if present
        if (!empty($restaurant->category_ids) && is_array($restaurant->category_ids)) {
            $catId = reset($restaurant->category_ids);
            if ($catId) {
                $cat = \App\Models\RestaurantCategory::find($catId);
                if ($cat && !empty($cat->name)) {
                    return $cat->name;
                }
            }
        }

        return 'Local';
    }
}
