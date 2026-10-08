<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\SEOService;
use Illuminate\Http\Request;

class InfoPageController extends Controller
{
    protected SEOService $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function about(Request $request)
    {
        savePageVisit($request, 'About Page');
        $seo = $this->seoService->generate('about');
        return view('front.about', compact('seo'));
    }

    public function contact(Request $request)
    {
        savePageVisit($request, 'Contact Page');
        $seo = $this->seoService->generate('contact');
        return view('front.contact', compact('seo'));
    }
}
