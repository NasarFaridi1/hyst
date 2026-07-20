<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MarketingBanner;
use App\Models\MarketingBannerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class MarketingBannerController extends Controller
{
    /**
     * Display the marketing banners listing page.
     *
     * Route: GET /offers  (or /banners — register in web.php)
     * Name:  front.banners.index
     */
    public function index(Request $request)
    {
        // Categories
        $categories = MarketingBannerCategory::orderBy('name')->get();

        // Banners query
        $query = MarketingBanner::with('category')
            ->where('status', 1)
            ->latest();

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }

        // Paginate
        $banners = $query->paginate(12)->withQueryString();

        return view('front.marketing-banners', compact(
            'categories',
            'banners'
        ));
    }

    public function show($id)
    {
        $banner = MarketingBanner::with('category')
            ->where('status',1)
            ->findOrFail($id);

        return view('front.marketing-banner-detail', compact('banner'));
    }

   

    public function contact(Request $request)
    {
        $request->validate([
            'banner_id'=>'required|exists:marketing_banners,id',
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'message'=>'required'
        ]);

        $banner = MarketingBanner::findOrFail($request->banner_id);

        Mail::send(
            'emails.marketing-banner-contact',
            [
                'banner'=>$banner,
                'data'=>$request
            ],
            function($mail) use ($banner){

                $mail->to($banner->email)
                    ->subject('New Marketing Banner Enquiry');

            }
        );

        return back()->with('success','Your enquiry has been sent successfully.');
    }
}