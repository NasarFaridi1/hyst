@extends('front.layouts.app')

@section('content')
<main style="background: #F5F5F0; min-height: 80vh; padding: 40px 0 60px;">
    <div class="mx-auto max-w-5xl" style="padding: 0 24px;">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 20px;">
            <ol style="display: flex; gap: 8px; font-size: 13px; color: #6B7280; list-style: none; padding: 0;">
                <li><a href="/" style="color: #6B7280; text-decoration: none;">Home</a></li>
                <li>/</li>
                <li style="color: #C25A2A; font-weight: 600;">About Us</li>
            </ol>
        </nav>

        <!-- Main Card -->
        <div class="card" style="padding: 40px; background: #ffffff;">
            <span class="badge-primary" style="margin-bottom: 12px; display: inline-block;">ABOUT HYST</span>
            <h1 style="font-size: 32px; font-weight: 800; color: #0D0D0D; margin-bottom: 16px;">
                Supporting Local Restaurants in Hounslow & West London
            </h1>

            <p style="font-size: 16px; color: #374151; line-height: 1.7; margin-bottom: 24px;">
                HYST is a modern restaurant discovery and direct-ordering platform created specifically for local restaurants in Hounslow, London and surrounding West London communities.
            </p>

            <h2 style="font-size: 22px; font-weight: 700; color: #0D0D0D; margin-top: 32px; margin-bottom: 12px;">
                Our Mission: Transparent Prices & Zero High Commissions
            </h2>
            <p style="font-size: 14.5px; color: #4B5563; line-height: 1.7; margin-bottom: 16px;">
                For years, third-party delivery apps have charged restaurants 20% to 35% commission on every order, forcing businesses to raise their online menu prices or compromise on quality. HYST changes the narrative with a zero commission model that allows restaurants to offer genuine menu prices directly to customers.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin: 32px 0;">
                <div style="background: #FFF0EC; padding: 20px; border-radius: 16px; border: 1px solid #FCD9C8;">
                    <i data-lucide="percent" style="width: 24px; height: 24px; color: #C25A2A; margin-bottom: 8px;"></i>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0D0D0D; margin-bottom: 4px;">Zero Commission</h3>
                    <p style="font-size: 13px; color: #6B7280; margin: 0;">Restaurants keep 100% of their food sales earnings.</p>
                </div>
                <div style="background: #FFF0EC; padding: 20px; border-radius: 16px; border: 1px solid #FCD9C8;">
                    <i data-lucide="tag" style="width: 24px; height: 24px; color: #C25A2A; margin-bottom: 8px;"></i>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0D0D0D; margin-bottom: 4px;">Genuine Menu Prices</h3>
                    <p style="font-size: 13px; color: #6B7280; margin: 0;">No inflated app prices or hidden markup costs.</p>
                </div>
                <div style="background: #FFF0EC; padding: 20px; border-radius: 16px; border: 1px solid #FCD9C8;">
                    <i data-lucide="heart" style="width: 24px; height: 24px; color: #C25A2A; margin-bottom: 8px;"></i>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0D0D0D; margin-bottom: 4px;">Support Local</h3>
                    <p style="font-size: 13px; color: #6B7280; margin: 0;">Empowering independent eateries across Hounslow, TW3.</p>
                </div>
            </div>

            <h2 style="font-size: 22px; font-weight: 700; color: #0D0D0D; margin-top: 32px; margin-bottom: 12px;">
                Where We Operate
            </h2>
            <p style="font-size: 14.5px; color: #4B5563; line-height: 1.7; margin-bottom: 24px;">
                We are actively expanding across Hounslow, Isleworth, Feltham, Hanworth, Cranford, and nearby West London areas. Whether you are looking for authentic Indian biryani, artisanal pizza, certified Halal dining, or fresh local takeaways, HYST is your direct destination.
            </p>

            <div style="display: flex; gap: 16px; flex-wrap: wrap; margin-top: 24px;">
                <a href="/restaurants" class="btn-primary" style="padding: 12px 24px; text-decoration: none;">Explore Restaurants</a>
                <a href="/become-a-partner" class="btn-black" style="padding: 12px 24px; text-decoration: none;">Become a Partner</a>
            </div>
        </div>

    </div>
</main>
@endsection
