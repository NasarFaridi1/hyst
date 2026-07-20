<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarketingBanner;
use App\Models\MarketingBannerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MarketingBannerController extends Controller
{
    /**
     * GET /api/marketing-banners
     */
    public function index(Request $request)
    {
        $categories = MarketingBannerCategory::orderBy('name')->get();

        $query = MarketingBanner::with('category')
            ->where('status', 1)
            ->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $banners = $query->paginate(12);

        return response()->json([
            'status' => true,
            'message' => 'Marketing banners fetched successfully.',
            'data' => [
                'categories' => $categories,
                'banners' => $banners
            ]
        ]);
    }

    /**
     * GET /api/marketing-banners/{id}
     */
    public function show($id)
    {
        $banner = MarketingBanner::with('category')
            ->where('status', 1)
            ->find($id);

        if (!$banner) {
            return response()->json([
                'status' => false,
                'message' => 'Marketing banner not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Marketing banner details fetched successfully.',
            'data' => $banner
        ]);
    }

    /**
     * POST /api/marketing-banners/contact
     */
    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_id' => 'required|exists:marketing_banners,id',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = MarketingBanner::findOrFail($request->banner_id);

        Mail::send(
            'emails.marketing-banner-contact',
            [
                'banner' => $banner,
                'data' => $request
            ],
            function ($mail) use ($banner) {
                $mail->to($banner->email)
                    ->subject('New Marketing Banner Enquiry');
            }
        );

        return response()->json([
            'status' => true,
            'message' => 'Your enquiry has been sent successfully.'
        ]);
    }
}