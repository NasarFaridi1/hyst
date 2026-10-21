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

            // SEO Meta Fields
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:500',

            // Open Graph Fields
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:1000',
            'og_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'og_image_url' => 'nullable|string|max:500',

            // JSON-LD Schema (BlogPosting) Fields
            'schema_headline' => 'nullable|string|max:255',
            'schema_description' => 'nullable|string|max:1000',
            'schema_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'schema_image_url' => 'nullable|string|max:500',
            'schema_author' => 'nullable|string|max:255',
            'schema_publisher' => 'nullable|string|max:255',
            'schema_date_published' => 'nullable|date',
            'schema_date_modified' => 'nullable|date',
            'schema_custom_json' => 'nullable|string',
        ]);

        if ($request->filled('schema_custom_json')) {
            json_decode($request->schema_custom_json);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['schema_custom_json' => 'Custom JSON-LD schema must be valid JSON: ' . json_last_error_msg()]);
            }
        }

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

        // Open Graph Image
        $ogImagePath = null;
        if ($request->hasFile('og_image_file')) {
            $file = $request->file('og_image_file');
            $imageName = time() . '_og_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/seo'), $imageName);
            $ogImagePath = 'uploads/blogs/seo/' . $imageName;
        } elseif ($request->filled('og_image_url')) {
            $ogImagePath = $request->og_image_url;
        }

        // Schema Image
        $schemaImagePath = null;
        if ($request->hasFile('schema_image_file')) {
            $file = $request->file('schema_image_file');
            $imageName = time() . '_schema_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/seo'), $imageName);
            $schemaImagePath = 'uploads/blogs/seo/' . $imageName;
        } elseif ($request->filled('schema_image_url')) {
            $schemaImagePath = $request->schema_image_url;
        }

        Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'video' => $videoPath,
            'status' => $request->status,

            // SEO Meta
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,

            // Open Graph
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $ogImagePath,

            // JSON-LD Schema
            'schema_headline' => $request->schema_headline,
            'schema_description' => $request->schema_description,
            'schema_image' => $schemaImagePath,
            'schema_author' => $request->schema_author,
            'schema_publisher' => $request->schema_publisher,
            'schema_date_published' => $request->schema_date_published,
            'schema_date_modified' => $request->schema_date_modified,
            'schema_custom_json' => $request->schema_custom_json,
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

            // SEO Meta Fields
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:500',

            // Open Graph Fields
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:1000',
            'og_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'og_image_url' => 'nullable|string|max:500',

            // JSON-LD Schema (BlogPosting) Fields
            'schema_headline' => 'nullable|string|max:255',
            'schema_description' => 'nullable|string|max:1000',
            'schema_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'schema_image_url' => 'nullable|string|max:500',
            'schema_author' => 'nullable|string|max:255',
            'schema_publisher' => 'nullable|string|max:255',
            'schema_date_published' => 'nullable|date',
            'schema_date_modified' => 'nullable|date',
            'schema_custom_json' => 'nullable|string',
        ]);

        if ($request->filled('schema_custom_json')) {
            json_decode($request->schema_custom_json);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['schema_custom_json' => 'Custom JSON-LD schema must be valid JSON: ' . json_last_error_msg()]);
            }
        }

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

        // Open Graph Image
        $ogImagePath = $blog->og_image;
        if ($request->hasFile('og_image_file')) {
            if ($blog->og_image && !Str::startsWith($blog->og_image, ['http://', 'https://']) && file_exists(public_path($blog->og_image))) {
                @unlink(public_path($blog->og_image));
            }
            $file = $request->file('og_image_file');
            $imageName = time() . '_og_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/seo'), $imageName);
            $ogImagePath = 'uploads/blogs/seo/' . $imageName;
        } elseif ($request->filled('og_image_url')) {
            $ogImagePath = $request->og_image_url;
        }

        // Schema Image
        $schemaImagePath = $blog->schema_image;
        if ($request->hasFile('schema_image_file')) {
            if ($blog->schema_image && !Str::startsWith($blog->schema_image, ['http://', 'https://']) && file_exists(public_path($blog->schema_image))) {
                @unlink(public_path($blog->schema_image));
            }
            $file = $request->file('schema_image_file');
            $imageName = time() . '_schema_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs/seo'), $imageName);
            $schemaImagePath = 'uploads/blogs/seo/' . $imageName;
        } elseif ($request->filled('schema_image_url')) {
            $schemaImagePath = $request->schema_image_url;
        }

        $blog->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'video' => $videoPath,
            'status' => $request->status,

            // SEO Meta
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,

            // Open Graph
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $ogImagePath,

            // JSON-LD Schema
            'schema_headline' => $request->schema_headline,
            'schema_description' => $request->schema_description,
            'schema_image' => $schemaImagePath,
            'schema_author' => $request->schema_author,
            'schema_publisher' => $request->schema_publisher,
            'schema_date_published' => $request->schema_date_published,
            'schema_date_modified' => $request->schema_date_modified,
            'schema_custom_json' => $request->schema_custom_json,
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

        if ($blog->og_image && !Str::startsWith($blog->og_image, ['http://', 'https://']) && file_exists(public_path($blog->og_image))) {
            @unlink(public_path($blog->og_image));
        }

        if ($blog->schema_image && !Str::startsWith($blog->schema_image, ['http://', 'https://']) && file_exists(public_path($blog->schema_image))) {
            @unlink(public_path($blog->schema_image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
