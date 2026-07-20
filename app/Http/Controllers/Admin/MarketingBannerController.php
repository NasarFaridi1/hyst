<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingBanner;
use App\Models\MarketingBannerCategory;
use Illuminate\Http\Request;

class MarketingBannerController extends Controller
{
    public function index(Request $request)
    {
        $query = MarketingBanner::with('category');

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $banners = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = \App\Models\MarketingBannerCategory::where('status', 'active')->get();

        return view(
            'admin.marketing-banners.index',
            compact('banners', 'categories')
        );
    }

    public function create()
    {
        $categories = MarketingBannerCategory::where('status', 'active')->get();
        return view('admin.marketing-banners.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'description' => 'nullable',
            'banner_image' => 'nullable|image',
            'category_id' => 'required|exists:marketing_banner_categories,id',
            'email' => 'nullable',
            'phone' => 'nullable',
            
        ]);

        $image = null;

        if ($request->hasFile('banner_image')) {

            $file = $request->file('banner_image');

            $imageName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('marketing-banners'), $imageName);

            $image = 'marketing-banners/' . $imageName;
        }

        MarketingBanner::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'banner_image' => $image,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.marketing-banners.index')
            ->with('success', 'Banner Created Successfully');
    }

    public function edit($id)
    {
        $banner = MarketingBanner::findOrFail($id);
        $categories = MarketingBannerCategory::where('status', 'active')->get();

        return view('admin.marketing-banners.edit', compact('banner', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $banner = MarketingBanner::findOrFail($id);

        $image = $banner->banner_image;

        if ($request->hasFile('banner_image')) {

            $file = $request->file('banner_image');

            $imageName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('marketing-banners'), $imageName);

            $image = 'marketing-banners/' . $imageName;
        }

        $banner->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'banner_image' => $image,
            'status' => $request->status,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect()
            ->route('admin.marketing-banners.index')
            ->with('success', 'Banner Updated Successfully');
    }

    public function destroy($id)
    {
        MarketingBanner::findOrFail($id)->delete();

        return redirect()
            ->route('admin.marketing-banners.index')
            ->with('success', 'Banner Deleted Successfully');
    }
}