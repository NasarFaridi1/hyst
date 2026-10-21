<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use App\Services\SEOService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class BlogSeoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Configure SQLite in-memory database for testing
        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        DB::purge('sqlite');
        DB::reconnect('sqlite');

        // Create blogs table schema for testing
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('status')->default('active');
            
            // SEO Meta Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url', 500)->nullable();
            
            // Open Graph Fields
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image', 500)->nullable();
            
            // JSON-LD Schema (BlogPosting) Fields
            $table->string('schema_headline')->nullable();
            $table->text('schema_description')->nullable();
            $table->string('schema_image', 500)->nullable();
            $table->string('schema_author')->nullable();
            $table->string('schema_publisher')->nullable();
            $table->timestamp('schema_date_published')->nullable();
            $table->timestamp('schema_date_modified')->nullable();
            $table->longText('schema_custom_json')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Test creating a blog post with full SEO fields and retrieving them.
     */
    public function test_can_store_and_retrieve_blog_seo_fields(): void
    {
        $blog = Blog::create([
            'title' => 'Top 10 Halal Restaurants in Hounslow',
            'slug' => 'top-10-halal-restaurants-hounslow',
            'description' => '<p>Discover the finest halal culinary experiences in Hounslow.</p>',
            'status' => 'active',
            'meta_title' => 'Best Halal Restaurants Hounslow Guide | HYST',
            'meta_description' => 'A comprehensive guide to the top 10 halal restaurants in Hounslow. Explore menus, locations and order direct.',
            'meta_keywords' => 'halal hounslow, best restaurants hounslow, halal food london',
            'canonical_url' => 'https://hyst.uk/blog/top-10-halal-restaurants-hounslow',
            'og_title' => 'Top 10 Halal Restaurants in Hounslow (2026 Guide)',
            'og_description' => 'Looking for delicious halal food in Hounslow? Check out our top 10 spots for biryani, kebabs, and curries.',
            'og_image' => 'https://hyst.uk/uploads/blogs/seo/halal-guide.jpg',
            'schema_headline' => 'The Ultimate Hounslow Halal Dining Guide',
            'schema_description' => 'Discover the best halal restaurants in Hounslow, verified for quality and taste.',
            'schema_image' => 'https://hyst.uk/uploads/blogs/seo/halal-schema.jpg',
            'schema_author' => 'HYST Editorial Team',
            'schema_publisher' => 'HYST Food Platform',
            'schema_date_published' => '2026-10-21 12:00:00',
            'schema_date_modified' => '2026-10-21 14:00:00',
        ]);

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
            'meta_title' => 'Best Halal Restaurants Hounslow Guide | HYST',
            'canonical_url' => 'https://hyst.uk/blog/top-10-halal-restaurants-hounslow',
            'schema_author' => 'HYST Editorial Team',
        ]);

        $this->assertEquals('Best Halal Restaurants Hounslow Guide | HYST', $blog->effective_meta_title);
        $this->assertEquals('https://hyst.uk/blog/top-10-halal-restaurants-hounslow', $blog->effective_canonical_url);
        $this->assertEquals('Top 10 Halal Restaurants in Hounslow (2026 Guide)', $blog->effective_og_title);
    }

    /**
     * Test fallback defaults when optional SEO fields are not provided.
     */
    public function test_seo_fallbacks_when_custom_fields_are_empty(): void
    {
        $blog = Blog::create([
            'title' => 'Healthy Salads in West London',
            'slug' => 'healthy-salads-west-london',
            'description' => '<p>Find fresh greens and healthy organic bowls in West London.</p>',
            'status' => 'active',
        ]);

        $this->assertEquals('Healthy Salads in West London | HYST Blog', $blog->effective_meta_title);
        $this->assertStringContainsString('Find fresh greens', $blog->effective_meta_description);
        $this->assertStringContainsString('/blog/healthy-salads-west-london', $blog->effective_canonical_url);
        $this->assertEquals($blog->effective_meta_title, $blog->effective_og_title);
    }

    /**
     * Test SEOService generates complete metadata and schema for blog post.
     */
    public function test_seo_service_generates_blogposting_schema(): void
    {
        $blog = Blog::create([
            'title' => 'Authentic Sourdough Pizza in Hounslow',
            'slug' => 'authentic-sourdough-pizza-hounslow',
            'description' => '<p>The best wood-fired sourdough pizzas delivered in Hounslow.</p>',
            'status' => 'active',
            'meta_title' => 'Wood-Fired Pizza in Hounslow | HYST',
            'meta_description' => 'Crispy crusts and artisanal toppings in Hounslow.',
            'meta_keywords' => 'pizza, sourdough, hounslow food',
            'schema_author' => 'Chef Marco',
            'schema_publisher' => 'HYST Magazine',
        ]);

        $seoService = new SEOService();
        $seo = $seoService->generate('blog_show', ['blog' => $blog]);

        $this->assertEquals('Wood-Fired Pizza in Hounslow | HYST', $seo['title']);
        $this->assertEquals('Crispy crusts and artisanal toppings in Hounslow.', $seo['description']);
        $this->assertEquals('pizza, sourdough, hounslow food', $seo['keywords']);
        $this->assertNotEmpty($seo['schema_json_ld']);

        // Inspect BlogPosting Schema
        $blogPosting = $seo['schema_json_ld'][0];
        $this->assertEquals('https://schema.org', $blogPosting['@context']);
        $this->assertEquals('BlogPosting', $blogPosting['@type']);
        $this->assertEquals($blog->title, $blogPosting['headline']);
        $this->assertEquals('Crispy crusts and artisanal toppings in Hounslow.', $blogPosting['description']);
        $this->assertNotEmpty($blogPosting['image']);
        $this->assertEquals('Chef Marco', $blogPosting['author']['name']);
        $this->assertEquals('HYST Magazine', $blogPosting['publisher']['name']);
        $this->assertNotEmpty($blogPosting['datePublished']);
        $this->assertNotEmpty($blogPosting['dateModified']);
    }

    /**
     * Test frontend HTML rendering has meta tags in <head>, JSON-LD script, and no duplicates.
     */
    public function test_frontend_renders_meta_tags_in_head_and_no_duplicates(): void
    {
        $blog = Blog::create([
            'title' => 'Ultimate Street Food Guide',
            'slug' => 'ultimate-street-food-guide',
            'description' => '<p>From samosas to wraps, explore street food flavors.</p>',
            'status' => 'active',
            'meta_title' => 'Hounslow Street Food Guide 2026 | HYST',
            'meta_description' => 'Your essential guide to vibrant street food in Hounslow.',
            'meta_keywords' => 'street food, wraps, hounslow',
            'canonical_url' => 'https://hyst.uk/blog/ultimate-street-food-guide',
            'og_title' => 'Hounslow Street Food Guide 2026',
            'og_description' => 'Must-try street food stalls and eateries in Hounslow.',
            'og_image' => 'https://hyst.uk/uploads/streetfood.jpg',
        ]);

        $seoService = new SEOService();
        $seo = $seoService->generate('blog_show', ['blog' => $blog]);
        $recentBlogs = collect();

        // Render the blade view
        $html = View::make('front.blogs.show', compact('blog', 'recentBlogs', 'seo'))->render();

        // Validate <title> in <head>
        $this->assertStringContainsString('<title>Hounslow Street Food Guide 2026 | HYST</title>', $html);

        // Validate meta description
        $this->assertStringContainsString('<meta name="description" content="Your essential guide to vibrant street food in Hounslow.">', $html);

        // Validate meta keywords
        $this->assertStringContainsString('<meta name="keywords" content="street food, wraps, hounslow">', $html);

        // Validate canonical URL
        $this->assertStringContainsString('<link rel="canonical" href="https://hyst.uk/blog/ultimate-street-food-guide">', $html);

        // Validate Open Graph tags
        $this->assertStringContainsString('<meta property="og:title" content="Hounslow Street Food Guide 2026">', $html);
        $this->assertStringContainsString('<meta property="og:description" content="Must-try street food stalls and eateries in Hounslow.">', $html);
        $this->assertStringContainsString('<meta property="og:image" content="https://hyst.uk/uploads/streetfood.jpg">', $html);

        // Validate JSON-LD script tag in head
        $this->assertStringContainsString('<script type="application/ld+json">', $html);
        $this->assertStringContainsString('"@type":"BlogPosting"', $html);
        $this->assertStringContainsString('"headline":"Ultimate Street Food Guide"', $html);
        $this->assertStringContainsString('"url":"https://hyst.uk/blog/ultimate-street-food-guide"', $html);

        // Validate No Duplicate Meta Tags
        $descMatches = substr_count($html, 'name="description"');
        $this->assertEquals(1, $descMatches, 'Meta description should appear exactly once in HTML head');

        $canonicalMatches = substr_count($html, 'rel="canonical"');
        $this->assertEquals(1, $canonicalMatches, 'Canonical link should appear exactly once in HTML head');

        $ogTitleMatches = substr_count($html, 'property="og:title"');
        $this->assertEquals(1, $ogTitleMatches, 'OG title should appear exactly once in HTML head');

        // Validate JSON-LD does not leak into visible body content
        $this->assertStringNotContainsString('{@context', strip_tags($html));
    }

    /**
     * Test admin blog store and update functionality persists SEO fields.
     */
    public function test_admin_blog_controller_persists_seo_fields(): void
    {
        // 1. Test Store
        $controller = new \App\Http\Controllers\Admin\BlogController();
        $request = \Illuminate\Http\Request::create('/admin/blogs', 'POST', [
            'title' => 'Admin Created Blog Post',
            'slug' => 'admin-created-blog-post',
            'description' => '<p>Content created by admin.</p>',
            'status' => 'active',
            'meta_title' => 'Admin Blog Post SEO Title',
            'meta_description' => 'Admin Blog Post SEO Meta Description',
            'meta_keywords' => 'admin, blog, seo',
            'canonical_url' => 'https://hyst.uk/blog/admin-created-blog-post',
            'og_title' => 'Admin Blog OG Title',
            'og_description' => 'Admin Blog OG Description',
            'og_image_url' => 'https://hyst.uk/images/admin-og.jpg',
            'schema_headline' => 'Admin Schema Headline',
            'schema_description' => 'Admin Schema Description',
            'schema_author' => 'HYST Senior Editor',
            'schema_publisher' => 'HYST UK',
        ]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));

        $blog = Blog::where('slug', 'admin-created-blog-post')->first();
        $this->assertNotNull($blog);
        $this->assertEquals('Admin Blog Post SEO Title', $blog->meta_title);
        $this->assertEquals('Admin Blog Post SEO Meta Description', $blog->meta_description);
        $this->assertEquals('admin, blog, seo', $blog->meta_keywords);
        $this->assertEquals('https://hyst.uk/blog/admin-created-blog-post', $blog->canonical_url);
        $this->assertEquals('Admin Blog OG Title', $blog->og_title);
        $this->assertEquals('https://hyst.uk/images/admin-og.jpg', $blog->og_image);
        $this->assertEquals('Admin Schema Headline', $blog->schema_headline);
        $this->assertEquals('HYST Senior Editor', $blog->schema_author);
        $this->assertEquals('HYST UK', $blog->schema_publisher);

        // 2. Test Update
        $updateRequest = \Illuminate\Http\Request::create('/admin/blogs/' . $blog->id, 'PUT', [
            'title' => 'Updated Admin Blog Post',
            'slug' => 'admin-created-blog-post',
            'description' => '<p>Updated content.</p>',
            'status' => 'active',
            'meta_title' => 'Updated SEO Title',
            'meta_description' => 'Updated Meta Description',
            'meta_keywords' => 'updated, keywords',
            'canonical_url' => 'https://hyst.uk/blog/updated-canonical',
            'og_title' => 'Updated OG Title',
            'og_description' => 'Updated OG Description',
            'og_image_url' => 'https://hyst.uk/images/updated-og.jpg',
            'schema_headline' => 'Updated Headline',
            'schema_author' => 'Lead Writer',
            'schema_publisher' => 'HYST Press',
        ]);

        $updateResponse = $controller->update($updateRequest, $blog->id);
        $this->assertTrue($updateResponse->isRedirect(route('admin.blogs.index')));

        $blog->refresh();
        $this->assertEquals('Updated Admin Blog Post', $blog->title);
        $this->assertEquals('Updated SEO Title', $blog->meta_title);
        $this->assertEquals('Updated Meta Description', $blog->meta_description);
        $this->assertEquals('https://hyst.uk/blog/updated-canonical', $blog->canonical_url);
        $this->assertEquals('Lead Writer', $blog->schema_author);
    }

    /**
     * Test admin create and edit views render without errors when blog is null or set.
     */
    public function test_admin_views_render_successfully(): void
    {
        $errors = new \Illuminate\Support\ViewErrorBag();

        // 1. Create view (blog is null)
        $createHtml = View::make('admin.blogs.create', compact('errors'))->render();
        $this->assertStringContainsString('SEO & Structured Data Settings', $createHtml);
        $this->assertStringContainsString('name="meta_title"', $createHtml);
        $this->assertStringContainsString('name="schema_headline"', $createHtml);

        // 2. Edit view (blog is present)
        $blog = Blog::create([
            'title' => 'Sample Blog for Edit View',
            'slug' => 'sample-blog-for-edit-view',
            'description' => '<p>Some description.</p>',
            'status' => 'active',
            'meta_title' => 'Custom Edit Meta Title',
        ]);

        $editHtml = View::make('admin.blogs.edit', compact('blog', 'errors'))->render();
        $this->assertStringContainsString('Custom Edit Meta Title', $editHtml);
        $this->assertStringContainsString('name="meta_title"', $editHtml);
    }
}
