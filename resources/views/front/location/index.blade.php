@extends('front.layouts.app')

@section('content')
<main style="background: #F5F5F0; min-height: 80vh; padding: 40px 0 60px;">
    <div class="mx-auto max-w-7xl" style="padding: 0 24px;">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 20px;">
            <ol style="display: flex; gap: 8px; font-size: 13px; color: #6B7280; list-style: none; padding: 0;">
                <li><a href="/" style="color: #6B7280; text-decoration: none;">Home</a></li>
                <li>/</li>
                <li style="color: #C25A2A; font-weight: 600;">Locations</li>
            </ol>
        </nav>

        <!-- Header -->
        <div style="margin-bottom: 36px; text-align: center;">
            <h1 style="font-size: 32px; font-weight: 800; color: #0D0D0D; margin-bottom: 12px;">
                Restaurants in Hounslow & West London Areas
            </h1>
            <p style="font-size: 15px; color: #4B5563; max-width: 680px; margin: 0 auto; line-height: 1.6;">
                Find local restaurants, food delivery, and takeaway options across Hounslow, Isleworth, Feltham, Hanworth, Cranford, and West London.
            </p>
        </div>

        <!-- Locations Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
            @foreach($locations as $loc)
                <a href="/locations/{{ $loc['slug'] }}" style="text-decoration: none; color: inherit;">
                    <div class="card" style="padding: 28px; height: 100%; transition: transform .2s, box-shadow .2s; border: 1px solid #E5E5E0;"
                        onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 16px rgba(0,0,0,.07)'">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                            <div style="width: 48px; height: 48px; background: #FFF0EC; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="map-pin" style="width: 24px; height: 24px; color: #C25A2A;"></i>
                            </div>
                            <span class="badge-primary">{{ $loc['postcode'] }}</span>
                        </div>
                        <h2 style="font-size: 20px; font-weight: 700; color: #0D0D0D; margin-bottom: 8px;">
                            {{ $loc['name'] }}
                        </h2>
                        <p style="font-size: 13.5px; color: #6B7280; line-height: 1.5; margin-bottom: 20px;">
                            {{ $loc['description'] }}
                        </p>
                        <span style="font-size: 13px; font-weight: 600; color: #C25A2A; display: inline-flex; align-items: center; gap: 4px;">
                            Explore Restaurants in {{ $loc['name'] }}
                            <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Local SEO Footer Section -->
        <div class="card" style="margin-top: 48px; padding: 32px; background: #ffffff;">
            <h2 style="font-size: 22px; font-weight: 700; color: #0D0D0D; margin-bottom: 12px;">
                Direct Restaurant Ordering in Hounslow & Surrounding Areas
            </h2>
            <p style="font-size: 14.5px; color: #4B5563; line-height: 1.7; margin-bottom: 16px;">
                HYST brings restaurant discovery and direct online ordering to local communities across Hounslow and West London. By cutting out expensive marketplace commissions, HYST ensures customers pay true menu prices while local restaurants retain their profits.
            </p>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="/cuisine/indian" class="btn-primary" style="padding: 10px 20px; font-size: 13px; text-decoration: none;">Indian Restaurants</a>
                <a href="/cuisine/biryani" class="btn-primary" style="padding: 10px 20px; font-size: 13px; text-decoration: none;">Biryani Spots</a>
                <a href="/cuisine/pizza" class="btn-primary" style="padding: 10px 20px; font-size: 13px; text-decoration: none;">Pizza & Burgers</a>
            </div>
        </div>

    </div>
</main>
@endsection
