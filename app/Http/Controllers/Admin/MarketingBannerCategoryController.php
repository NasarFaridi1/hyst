<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingBannerCategory;
use Illuminate\Http\Request;

class MarketingBannerCategoryController extends Controller
{
    public function index()
    {
        $categories = MarketingBannerCategory::latest()->get();

        return view(
            'admin.marketing-banner-categories.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view(
            'admin.marketing-banner-categories.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        MarketingBannerCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.marketing-banner-categories.index')
            ->with('success','Category Created Successfully');
    }

    public function edit($id)
    {
        $category = MarketingBannerCategory::findOrFail($id);

        return view(
            'admin.marketing-banner-categories.edit',
            compact('category')
        );
    }

    public function update(Request $request, $id)
    {
        $category = MarketingBannerCategory::findOrFail($id);

        $request->validate([
            'name' => 'required',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.marketing-banner-categories.index')
            ->with('success','Category Updated Successfully');
    }

    public function destroy($id)
    {
        $category = MarketingBannerCategory::withCount('banners')
            ->findOrFail($id);

        if ($category->banners_count > 0) {

            return back()->with(
                'error',
                'Cannot delete category because banners are using it.'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'Category Deleted Successfully'
        );
    }
}