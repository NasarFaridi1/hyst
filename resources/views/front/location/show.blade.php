@extends('front.layouts.app')

@section('content')
<main style="background: #F5F5F0; min-height: 80vh; padding: 40px 0 60px;">
    <div class="mx-auto max-w-7xl" style="padding: 0 24px;">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 20px;">
            <ol style="display: flex; gap: 8px; font-size: 13px; color: #6B7280; list-style: none; padding: 0;">
                <li><a href="/" style="color: #6B7280; text-decoration: none;">Home</a></li>
                <li>/</li>
                <li><a href="/locations" style="color: #6B7280; text-decoration: none;">Locations</a></li>
                <li>/</li>
                <li style="color: #C25A2A; font-weight: 600;">{{ $displayName }}</li>
            </ol>
        </nav>

        <!-- Header -->
        <div style="margin-bottom: 36px;">
            <h1 style="font-size: 32px; font-weight: 800; color: #0D0D0D; margin-bottom: 12px;">
                Restaurants in {{ $displayName }}, London
            </h1>
            <p style="font-size: 15px; color: #4B5563; max-width: 760px; line-height: 1.6;">
                Discover restaurants, takeaway and local food in {{ $displayName }}, London. Explore local restaurants and order directly through HYST at genuine menu prices.
            </p>
        </div>

        <!-- Restaurants Grid -->
        @if($restaurants->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($restaurants as $restaurant)
                    <div class="card" style="overflow: hidden; display: flex; flex-direction: column; transition: transform .2s;">
                        <div style="position: relative; height: 180px; background: #E5E7EB;">
                            @if(!empty($restaurant->image))
                                <img src="{{ Str::startsWith($restaurant->image, 'http') ? $restaurant->image : asset($restaurant->image) }}"
                                     alt="{{ $restaurant->name }} - Restaurant in {{ $displayName }}, London"
                                     loading="lazy"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #FFF0EC; color: #C25A2A; font-weight: 700; font-size: 20px;">
                                    {{ $restaurant->name }}
                                </div>
                            @endif
                            <span class="badge-primary" style="position: absolute; top: 12px; left: 12px;">
                                {{ $displayName }}
                            </span>
                        </div>

                        <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                            <h2 style="font-size: 18px; font-weight: 700; color: #0D0D0D; margin-bottom: 6px;">
                                <a href="/restaurants/{{ $restaurant->slug }}" style="color: inherit; text-decoration: none;">
                                    {{ $restaurant->name }}
                                </a>
                            </h2>
                            <p style="font-size: 13px; color: #6B7280; margin-bottom: 12px; display: flex; align-items: center; gap: 4px;">
                                <i data-lucide="map-pin" style="width: 14px; height: 14px; color: #C25A2A;"></i>
                                {{ $restaurant->address ?? $restaurant->location ?? ($displayName . ', London') }}
                            </p>

                            @if(!empty($restaurant->description))
                                <p style="font-size: 13px; color: #4B5563; line-height: 1.5; margin-bottom: 16px; flex-grow: 1;">
                                    {{ Str::limit($restaurant->description, 100) }}
                                </p>
                            @endif

                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto; padding-top: 12px; border-top: 1px solid #F0F0EC;">
                                <span style="font-size: 12px; font-weight: 600; color: {{ $restaurant->is_open ? '#16A34A' : '#DC2626' }};">
                                    {{ $restaurant->is_open ? 'Open Now' : 'Closed' }}
                                </span>
                                <a href="/restaurants/{{ $restaurant->slug }}" class="btn-primary" style="padding: 8px 16px; font-size: 13px; text-decoration: none;">
                                    View Menu & Order
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card" style="padding: 40px; text-align: center;">
                <i data-lucide="map-pin" style="width: 48px; height: 48px; color: #C25A2A; margin-bottom: 16px;"></i>
                <h2 style="font-size: 20px; font-weight: 700; color: #0D0D0D; margin-bottom: 8px;">Explore Restaurants in Hounslow</h2>
                <p style="font-size: 14px; color: #6B7280; margin-bottom: 20px;">View all restaurants operating in Hounslow and surrounding West London locations.</p>
                <a href="/restaurants" class="btn-primary" style="padding: 12px 24px; text-decoration: none;">View All Restaurants</a>
            </div>
        @endif

        <!-- Internal Links to nearby Cuisines & Areas -->
        <div class="card" style="margin-top: 48px; padding: 32px; background: #ffffff;">
            <h2 style="font-size: 20px; font-weight: 700; color: #0D0D0D; margin-bottom: 16px;">
                Explore Nearby Areas & Cuisines in West London
            </h2>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <a href="/locations/hounslow" style="padding: 8px 14px; background: #FFF0EC; border-radius: 8px; font-size: 13px; font-weight: 600; color: #C25A2A; text-decoration: none;">Hounslow Central</a>
                <a href="/locations/isleworth" style="padding: 8px 14px; background: #FFF0EC; border-radius: 8px; font-size: 13px; font-weight: 600; color: #C25A2A; text-decoration: none;">Isleworth</a>
                <a href="/locations/feltham" style="padding: 8px 14px; background: #FFF0EC; border-radius: 8px; font-size: 13px; font-weight: 600; color: #C25A2A; text-decoration: none;">Feltham</a>
                <a href="/locations/cranford" style="padding: 8px 14px; background: #FFF0EC; border-radius: 8px; font-size: 13px; font-weight: 600; color: #C25A2A; text-decoration: none;">Cranford</a>
                <a href="/locations/hanworth" style="padding: 8px 14px; background: #FFF0EC; border-radius: 8px; font-size: 13px; font-weight: 600; color: #C25A2A; text-decoration: none;">Hanworth</a>
                <a href="/cuisine/indian" style="padding: 8px 14px; background: #F5F5F0; border-radius: 8px; font-size: 13px; font-weight: 500; color: #0D0D0D; text-decoration: none;">Indian Food</a>
                <a href="/cuisine/biryani" style="padding: 8px 14px; background: #F5F5F0; border-radius: 8px; font-size: 13px; font-weight: 500; color: #0D0D0D; text-decoration: none;">Biryani</a>
                <a href="/cuisine/pizza" style="padding: 8px 14px; background: #F5F5F0; border-radius: 8px; font-size: 13px; font-weight: 500; color: #0D0D0D; text-decoration: none;">Pizza & Burgers</a>
            </div>
        </div>

    </div>
</main>
@endsection
