<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $blogs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_file' => 'nullable|mimes:mp4,mov,ogg,qt,webm|max:2048',
            'video_url' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->title);
        
        // Ensure slug uniqueness
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/images'), $imageName);
            $imagePath = 'uploads/blogs/images/' . $imageName;
        }

        $videoPath = null;
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $videoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/videos'), $videoName);
            $videoPath = 'uploads/blogs/videos/' . $videoName;
        } elseif ($request->filled('video_url')) {
            $videoPath = $request->video_url;
        }

        Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'video' => $videoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_file' => 'nullable|mimes:mp4,mov,ogg,qt,webm|max:2048',
            'video_url' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = $blog->image;
        if ($request->hasFile('image')) {
            if ($blog->image && file_exists(public_path($blog->image))) {
                @unlink(public_path($blog->image));
            }
            $file = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/images'), $imageName);
            $imagePath = 'uploads/blogs/images/' . $imageName;
        }

        $videoPath = $blog->video;
        if ($request->hasFile('video_file')) {
            if ($blog->video && file_exists(public_path($blog->video))) {
                @unlink(public_path($blog->video));
            }
            $file = $request->file('video_file');
            $videoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/videos'), $videoName);
            $videoPath = 'uploads/blogs/videos/' . $videoName;
        } elseif ($request->filled('video_url')) {
            $videoPath = $request->video_url;
        }

        $blog->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'video' => $videoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && file_exists(public_path($blog->image))) {
            @unlink(public_path($blog->image));
        }

        if ($blog->video && file_exists(public_path($blog->video))) {
            @unlink(public_path($blog->video));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
