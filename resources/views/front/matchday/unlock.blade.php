@extends('front.layouts.app')

@section('title', 'Unlock England Footballers | HYST Fantasy XI')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;700&display=swap');

    .f-page {
        background: #FAF7F2;
        min-height: 100vh;
        padding: 30px 16px 80px;
        font-family: 'DM Sans', sans-serif;
    }
    .f-container {
        max-width: 1140px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
        align-items: start;
    }
    .f-head-banner {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .f-head-banner h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 4px;
        color: #111;
    }
    .f-head-banner p {
        margin: 0;
        font-size: 13.5px;
        color: #666;
    }

    /* POS TABS */
    .f-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 22px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .f-tab {
        padding: 9px 20px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid #E5E7EB;
        color: #4B5563;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all .15s;
    }
    .f-tab.active {
        background: #0D0D0D;
        color: #fff;
        border-color: #0D0D0D;
    }

    /* PLAYER CARDS GRID */
    .f-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }
    .f-player-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid #EFECE6;
        padding: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .f-player-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }
    .f-player-card.rarity-border-star { border: 2px solid #F59E0B; }
    .f-player-card.rarity-border-rare { border: 2px solid #3B82F6; }
    .f-player-card.rarity-border-common { border: 1px solid #E5E7EB; }

    .f-card-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .f-card-badge {
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .rarity-star { background: #FEF3C7; color: #B45309; }
    .rarity-rare { background: #E0E7FF; color: #4338CA; }
    .rarity-common { background: #F3F4F6; color: #4B5563; }

    .f-card-portrait-wrap {
        width: 100%;
        height: 130px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin: 6px 0 10px;
        background: radial-gradient(circle at center, rgba(194, 90, 42, 0.08) 0%, rgba(255,255,255,0) 70%);
    }
    .f-player-img {
        height: 125px;
        width: auto;
        max-width: 130px;
        object-fit: contain;
        filter: drop-shadow(0 6px 12px rgba(0,0,0,0.18));
        transition: transform 0.25s ease;
    }
    .f-player-card:hover .f-player-img {
        transform: scale(1.08) translateY(-2px);
    }

    .f-player-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .f-player-ovr {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #0D0D0D;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 16px;
        line-height: 1;
        flex-shrink: 0;
    }
    .f-player-ovr small {
        font-size: 8px;
        font-weight: 600;
        color: #9CA3AF;
        text-transform: uppercase;
        margin-top: 2px;
    }
    .f-player-info h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 2px;
        color: #111;
        line-height: 1.2;
    }
    .f-player-info span {
        font-size: 12px;
        color: #6B7280;
        font-weight: 500;
    }

    /* STATS ROW */
    .f-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background: #FAF7F2;
        border-radius: 14px;
        padding: 10px 8px;
        margin-bottom: 18px;
        text-align: center;
    }
    .f-stat-item div:first-child {
        font-size: 10px;
        font-weight: 700;
        color: #8C8C8C;
        text-transform: uppercase;
    }
    .f-stat-item div:last-child {
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #111;
    }

    .f-pick-btn {
        width: 100%;
        background: #C25A2A;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 11px 0;
        font-weight: 700;
        font-size: 13.5px;
        cursor: pointer;
        transition: background .15s, transform .1s;
    }
    .f-pick-btn:hover {
        background: #A6461D;
        transform: scale(1.01);
    }
    .f-owned-btn {
        width: 100%;
        background: #E5E7EB;
        color: #6B7280;
        border: none;
        border-radius: 12px;
        padding: 11px 0;
        font-weight: 700;
        font-size: 13px;
        cursor: not-allowed;
    }

    @media (max-width: 991px) {
        .f-container { grid-template-columns: 1fr; }
        .f-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .f-cards-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="f-page">
    <div class="f-container">
        {{-- USER SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- MAIN CONTENT --}}
        <div>
            @if(session('success'))
                <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; font-size: 14px;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- HEADER BANNER --}}
            <div class="f-head-banner">
                <div>
                    <h1>Pick Your England Player</h1>
                    <p>Choose an England-eligible footballer from UK clubs to recruit into your personal squad.</p>
                </div>

                @if($activeEntitlement)
                    <div style="background: #ECFDF5; border: 1px solid #10B981; padding: 10px 18px; border-radius: 14px; text-align: right;">
                        <span style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase;">From Order #{{ $activeEntitlement->order_id }}</span>
                        <div style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 800; color: #065F46;">
                            {{ $activeEntitlement->choices_remaining }} Choice{{ $activeEntitlement->choices_remaining > 1 ? 's' : '' }} Available
                        </div>
                    </div>
                @else
                    <div style="background: #FFFBEB; border: 1px solid #F59E0B; padding: 10px 18px; border-radius: 14px; text-align: right;">
                        <span style="font-size: 11px; font-weight: 700; color: #B45309; text-transform: uppercase;">No Picks Waiting</span>
                        <div style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 700; color: #92400E;">
                            Order Food on Hyst to Unlock!
                        </div>
                    </div>
                @endif
            </div>

            {{-- POSITION FILTER TABS --}}
            <div class="f-tabs">
                <a href="{{ route('matchday.unlock') }}" class="f-tab {{ empty($position) ? 'active' : '' }}">All Positions</a>
                <a href="{{ route('matchday.unlock', ['position' => 'GK']) }}" class="f-tab {{ $position == 'GK' ? 'active' : '' }}">Goalkeepers (GK)</a>
                <a href="{{ route('matchday.unlock', ['position' => 'DEF']) }}" class="f-tab {{ $position == 'DEF' ? 'active' : '' }}">Defenders (DEF)</a>
                <a href="{{ route('matchday.unlock', ['position' => 'MID']) }}" class="f-tab {{ $position == 'MID' ? 'active' : '' }}">Midfielders (MID)</a>
                <a href="{{ route('matchday.unlock', ['position' => 'FWD']) }}" class="f-tab {{ $position == 'FWD' ? 'active' : '' }}">Forwards (FWD)</a>
            </div>

            {{-- PLAYERS GRID --}}
            <div class="f-cards-grid">
                @foreach($players as $player)
                    <div class="f-player-card rarity-border-{{ $player->rarity }}">
                        <div>
                            <div class="f-card-top-bar">
                                <div class="f-player-ovr">
                                    {{ $player->overall_rating }}
                                    <small>{{ $player->position }}</small>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="font-size: 14px;" title="England">🏴󠁧󠁢󠁥󠁮󠁧󠁿</span>
                                    <span class="f-card-badge rarity-{{ $player->rarity }}">{{ $player->rarity }}</span>
                                </div>
                            </div>

                            {{-- PLAYER IMAGE PORTRAIT --}}
                            <div class="f-card-portrait-wrap">
                                <img src="{{ $player->image_url }}" 
                                     alt="{{ $player->name }}" 
                                     class="f-player-img" 
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($player->display_name ?: $player->name) }}&background=0A192F&color=FFFFFF&size=200&bold=true';">
                            </div>

                            <div class="f-player-info" style="text-align: center; margin-bottom: 12px;">
                                <h3>{{ $player->name }}</h3>
                                <span>{{ $player->club_name }} &bull; {{ $player->sub_position }}</span>
                            </div>

                            <div class="f-stats-row">
                                <div class="f-stat-item">
                                    <div>ATT</div>
                                    <div>{{ $player->stat_attack }}</div>
                                </div>
                                <div class="f-stat-item">
                                    <div>MID</div>
                                    <div>{{ $player->stat_midfield }}</div>
                                </div>
                                <div class="f-stat-item">
                                    <div>DEF</div>
                                    <div>{{ $player->stat_defence }}</div>
                                </div>
                                <div class="f-stat-item">
                                    <div>GK</div>
                                    <div>{{ $player->stat_goalkeeping }}</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            @if($player->is_owned)
                                <button type="button" class="f-owned-btn" disabled>
                                    ✓ In Your Squad
                                </button>
                            @elseif($activeEntitlement)
                                <form method="POST" action="{{ route('matchday.claim-player') }}">
                                    @csrf
                                    <input type="hidden" name="entitlement_id" value="{{ $activeEntitlement->id }}">
                                    <input type="hidden" name="catalogue_id" value="{{ $player->id }}">
                                    <button type="submit" class="f-pick-btn" onclick="return confirm('Recruit {{ $player->name }} into your squad?')">
                                        Pick {{ $player->display_name }} &rarr;
                                    </button>
                                </form>
                            @else
                                <a href="/restaurants" style="display: block; text-align: center; text-decoration: none;" class="f-pick-btn" style="background: #111;">
                                    Order Food to Unlock
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
