@extends('front.layouts.app')

@section('title', '404 - Page Not Found | HYST')
@section('meta_description', 'The page you requested could not be found. Explore top restaurants in Hounslow on HYST.')
@section('robots', 'noindex, follow')

@section('content')
<main style="background: #F5F5F0; min-height: 75vh; display: flex; align-items: center; justify-content: center; padding: 60px 24px;">
    <div class="card" style="padding: 48px; max-width: 560px; width: 100%; text-align: center; background: #ffffff;">
        <div style="width: 64px; height: 64px; background: #FFF0EC; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i data-lucide="utensils-crossed" style="width: 32px; height: 32px; color: #C25A2A;"></i>
        </div>
        <h1 style="font-size: 36px; font-weight: 800; color: #0D0D0D; margin-bottom: 8px;">404</h1>
        <h2 style="font-size: 20px; font-weight: 700; color: #374151; margin-bottom: 12px;">Page Not Found</h2>
        <p style="font-size: 14.5px; color: #6B7280; line-height: 1.6; margin-bottom: 28px;">
            Sorry, the page or restaurant link you are looking for might have been moved or doesn't exist. Discover top local food and takeaways in Hounslow below.
        </p>

        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="/" class="btn-primary" style="padding: 12px 24px; text-decoration: none; font-size: 14px;">Return to Homepage</a>
            <a href="/restaurants" class="btn-black" style="padding: 12px 24px; text-decoration: none; font-size: 14px;">Browse Restaurants</a>
        </div>
    </div>
</main>
@endsection