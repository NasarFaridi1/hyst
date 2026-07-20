@extends('front.layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

.favorites-page {
    background: #FAF7F2;
    min-height: 100vh;
    padding: 40px 16px 100px;
}

.favorites-wrap {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    align-items: start;
}

.favorites-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #F0F0EC;
    box-shadow: 0 2px 10px rgba(13,13,13,0.03);
    overflow: hidden;
}

/* ── Header ── */
.favorites-header {
    padding: 28px 32px;
    border-bottom: 1px solid #F0F0EC;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.favorites-eyebrow {
    color: #C25A2A;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.favorites-eyebrow svg { width: 13px; height: 13px; }
.favorites-header h1 {
    font-family: 'Poppins', sans-serif;
    margin: 0 0 2px;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -.4px;
    color: #0D0D0D;
}
.favorites-header p {
    margin: 0;
    font-size: 13.5px;
    color: #9CA3AF;
}
.favorites-count {
    background: #FAF7F2;
    border: 1px solid #F0E4D8;
    color: #C25A2A;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 50px;
    white-space: nowrap;
}

/* ── Restaurant item — card style with hover lift ── */
.restaurant-list { padding: 18px; }
.restaurant-item {
    display: flex;
    gap: 18px;
    padding: 16px;
    align-items: center;
    border-radius: 18px;
    border: 1px solid transparent;
    transition: background .2s, border-color .2s, transform .2s, box-shadow .2s;
}
.restaurant-item:hover {
    background: #FAF7F2;
    border-color: #F0E4D8;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13,13,13,0.05);
}
.restaurant-item + .restaurant-item { margin-top: 4px; }

.restaurant-image-wrap {
    position: relative;
    flex-shrink: 0;
}
.restaurant-image {
    width: 96px;
    height: 96px;
    border-radius: 16px;
    object-fit: cover;
    border: 1px solid #F0F0EC;
}
.fav-heart-pin {
    position: absolute;
    top: -7px;
    right: -7px;
    width: 26px; height: 26px;
    border-radius: 50%;
    background: #C25A2A;
    border: 2px solid #fff;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 6px rgba(194,90,42,.4);
}
.fav-heart-pin svg { width: 12px; height: 12px; color: #fff; }

.restaurant-content { flex: 1; min-width: 0; }

.restaurant-name {
    font-family: 'Poppins', sans-serif;
    font-size: 17px;
    font-weight: 700;
    color: #0D0D0D;
    margin-bottom: 6px;
    letter-spacing: -.2px;
}
.restaurant-location {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #6B7280;
    font-size: 13px;
    margin-bottom: 8px;
}
.restaurant-location svg { width: 13px; height: 13px; flex-shrink: 0; color: #9CA3AF; }

.restaurant-rating {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #FFFBEB;
    border: 1px solid #FEF3C7;
    color: #A16207;
    font-size: 12.5px;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 50px;
}
.restaurant-rating svg { width: 13px; height: 13px; color: #F59E0B; }
.restaurant-rating .rv-count {
    font-weight: 500;
    color: #9CA3AF;
    margin-left: 2px;
}

/* ── Action buttons ── */
.restaurant-actions {
    display: flex;
    flex-direction: column;
    gap: 9px;
    flex-shrink: 0;
}
.view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    background: #0D0D0D;
    color: #fff;
    text-decoration: none;
    padding: 11px 20px;
    border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 700;
    white-space: nowrap;
    transition: background .2s, transform .15s;
}
.view-btn:hover { background: #2a2a2a; color: #fff; transform: translateY(-1px); }
.view-btn svg { width: 14px; height: 14px; }

.remove-form { margin: 0; }
.remove-btn {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    background: #fff;
    color: #C0392B;
    border: 1.5px solid #FCE4E1;
    padding: 10px 20px;
    border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    transition: background .2s, border-color .2s;
}
.remove-btn:hover { background: #FEF2F1; border-color: #F8C6C0; }
.remove-btn svg { width: 14px; height: 14px; }

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}
.empty-state-icon-wrap {
    width: 84px; height: 84px;
    border-radius: 50%;
    background: #FDEDE4;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.empty-state-icon-wrap svg { width: 38px; height: 38px; color: #C25A2A; }
.empty-state h3 {
    font-family: 'Poppins', sans-serif;
    margin: 0 0 8px;
    font-size: 19px;
    font-weight: 700;
    color: #0D0D0D;
}
.empty-state p {
    color: #9CA3AF;
    font-size: 14px;
    margin: 0 0 22px;
}
.empty-state .browse-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #C25A2A;
    color: #fff;
    text-decoration: none;
    padding: 13px 28px;
    border-radius: 14px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 700;
    transition: background .2s, transform .15s;
}
.empty-state .browse-btn:hover { background: #c42d0b; transform: translateY(-1px); color: #fff; }
.empty-state .browse-btn svg { width: 16px; height: 16px; }

@media(max-width: 900px) {
    .favorites-wrap { grid-template-columns: 1fr; }
}

@media(max-width: 640px) {
    .favorites-page { padding: 20px 12px 100px; }
    .favorites-header { padding: 20px 20px; }
    .favorites-header h1 { font-size: 21px; }
    .restaurant-list { padding: 12px; }

    .restaurant-item {
        flex-direction: column;
        align-items: stretch;
        padding: 14px;
    }
    .restaurant-image-wrap { width: 100%; }
    .restaurant-image {
        width: 100%;
        height: 170px;
    }
    .restaurant-actions {
        flex-direction: row;
        margin-top: 4px;
    }
    .view-btn, .remove-btn { flex: 1; }
}
</style>

<div class="favorites-page">
    <div class="favorites-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- CONTENT --}}
        <div>
            <div class="favorites-card">

                {{-- HEADER --}}
                <div class="favorites-header">
                    <div>
                        <div class="favorites-eyebrow">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-6.7-4.35-9.33-8.2C.6 9.92 1.7 6.1 5 5.1c2.1-.63 4 .3 5 2.1 1-1.8 2.9-2.73 5-2.1 3.3 1 4.4 4.82 2.33 7.7C18.7 16.65 12 21 12 21z"/></svg>
                            YOUR SAVED PLACES
                        </div>
                        <h1>Favorite Restaurants</h1>
                        <p>Quick access to the places you love most</p>
                    </div>
                    @if($restaurants->count() > 0)
                        <div class="favorites-count">{{ $restaurants->count() }} {{ $restaurants->count() == 1 ? 'restaurant' : 'restaurants' }}</div>
                    @endif
                </div>

                <div class="restaurant-list">
                    @forelse($restaurants as $restaurant)

                        <div class="restaurant-item">

                            <div class="restaurant-image-wrap">
                                <img
                                    src="{{ $restaurant->image ? asset('storage/'.$restaurant->image) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop' }}"
                                    class="restaurant-image" alt="{{ $restaurant->name }}">
                                <span class="fav-heart-pin">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-6.7-4.35-9.33-8.2C.6 9.92 1.7 6.1 5 5.1c2.1-.63 4 .3 5 2.1 1-1.8 2.9-2.73 5-2.1 3.3 1 4.4 4.82 2.33 7.7C18.7 16.65 12 21 12 21z"/></svg>
                                </span>
                            </div>

                            <div class="restaurant-content">
                                <div class="restaurant-name">{{ $restaurant->name }}</div>

                                <div class="restaurant-location">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ $restaurant->location }}
                                </div>

                                <div class="restaurant-rating">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    {{ number_format($restaurant->reviews->avg('rating') ?? 0,1) }}
                                    <span class="rv-count">({{ $restaurant->reviews->count() }} reviews)</span>
                                </div>
                            </div>

                            <div class="restaurant-actions">
                                <a href="{{ url('/restaurant/'.$restaurant->slug) }}" class="view-btn">
                                    View Menu
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>

                                <form
                                    action="{{ route('favorite.remove',$restaurant->id) }}"
                                    method="POST"
                                    class="remove-form"
                                    onsubmit="return confirm('Remove from favorites?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Remove
                                    </button>
                                </form>
                            </div>

                        </div>

                    @empty

                        <div class="empty-state">
                            <div class="empty-state-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6.7-4.35-9.33-8.2C.6 9.92 1.7 6.1 5 5.1c2.1-.63 4 .3 5 2.1 1-1.8 2.9-2.73 5-2.1 3.3 1 4.4 4.82 2.33 7.7C18.7 16.65 12 21 12 21z"/>
                                </svg>
                            </div>
                            <h3>No Favorite Restaurants Yet</h3>
                            <p>Restaurants you add to favorites will appear here.</p>
                            <a href="/" class="browse-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                                Discover Restaurants
                            </a>
                        </div>

                    @endforelse
                </div>

            </div>
        </div>

    </div>
</div>

@endsection