<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\SEOService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected SEOService $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of active blogs.
     */
    public function index(Request $request)
    {
        savePageVisit($request, 'Blog Index');

        $query = Blog::where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest()->paginate(9)->withQueryString();
        $recentBlogs = Blog::where('status', 'active')->latest()->take(5)->get();

        $seo = $this->seoService->generate('blog_index');

        return view('front.blogs.index', compact('blogs', 'recentBlogs', 'seo'));
    }

    /**
     * Display the specified blog details page.
     */
    public function show(Request $request, $slug)
    {
        $blog = Blog::where('status', 'active')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhere('id', $slug);
            })
            ->firstOrFail();

        savePageVisit($request, 'Blog View: ' . $blog->title);

        $recentBlogs = Blog::where('status', 'active')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(4)
            ->get();

        $seo = $this->seoService->generate('blog_show', ['blog' => $blog]);

        return view('front.blogs.show', compact('blog', 'recentBlogs', 'seo'));
    }
}
