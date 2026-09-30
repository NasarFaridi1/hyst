<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of active blogs.
     */
    public function index(Request $request)
    {
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

        return view('front.blogs.index', compact('blogs', 'recentBlogs'));
    }

    /**
     * Display the specified blog details page.
     */
    public function show($slug)
    {
        $blog = Blog::where('status', 'active')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $recentBlogs = Blog::where('status', 'active')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(4)
            ->get();

        return view('front.blogs.show', compact('blog', 'recentBlogs'));
    }
}
