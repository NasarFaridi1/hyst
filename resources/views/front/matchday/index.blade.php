@extends('front.layouts.app')

@section('title', 'HYST Fantasy XI | Build Your England Team & Challenge Friends')

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
    .f-hero {
        background: linear-gradient(135deg, #0A192F 0%, #172A45 50%, #0F3460 100%);
        border-radius: 24px;
        padding: 36px 32px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(10, 25, 47, 0.15);
    }
    .f-hero::after {
        content: "⚽";
        position: absolute;
        right: 20px;
        bottom: -20px;
        font-size: 130px;
        opacity: 0.08;
        pointer-events: none;
    }
    .f-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #F87171;
        margin-bottom: 14px;
    }
    .f-hero h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 30px;
        font-weight: 800;
        line-height: 1.2;
        margin: 0 0 10px;
        color: #FFFFFF;
    }
    .f-hero p {
        font-size: 14px;
        color: #CBD5E1;
        max-width: 600px;
        margin: 0 0 22px;
        line-height: 1.5;
    }
    .f-hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #C25A2A;
        color: #fff;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        transition: transform .15s, background .15s;
    }
    .f-hero-cta:hover {
        background: #A6461D;
        transform: translateY(-2px);
    }

    /* KPI STATS ROW */
    .f-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .f-kpi-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #EFECE6;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .f-kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: #FFF5F1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .f-kpi-title {
        font-size: 12px;
        color: #8C8C8C;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .f-kpi-value {
        font-family: 'Poppins', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: #111;
        line-height: 1;
    }

    /* NAV CARDS */
    .f-nav-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .f-action-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 24px;
        text-decoration: none;
        color: inherit;
        transition: transform .2s, box-shadow .2s, border-color .2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .f-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.06);
        border-color: #C25A2A;
    }
    .f-card-tag {
        align-self: flex-start;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .f-action-card h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #111;
        margin: 0 0 8px;
    }
    .f-action-card p {
        font-size: 13px;
        color: #666;
        margin: 0 0 16px;
        line-height: 1.4;
    }
    .f-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 700;
        font-size: 13px;
        color: #C25A2A;
    }

    /* RECENT MATCHES TABLE */
    .f-table-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .f-table-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .f-table-head h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin: 0;
        color: #111;
    }
    .f-match-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #F4F2ED;
    }
    .f-match-item:last-child {
        border-bottom: none;
    }

    @media (max-width: 991px) {
        .f-container { grid-template-columns: 1fr; }
        .f-kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .f-nav-grid { grid-template-columns: 1fr; }
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
            {{-- ALERT MESSAGES --}}
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

            {{-- HERO BANNER --}}
            <div class="f-hero">
                <div class="f-badge">🏴󠁧󠁢󠁥󠁮󠁧󠁿 England Football Experience</div>
                <h1>HYST FANTASY XI</h1>
                <p>Build your own England football squad. Back your favourite players at UK clubs, challenge your friends to 1v1 tactical duels, and climb to the top of the manager leaderboard!</p>

                @if($totalPicksRemaining > 0)
                    <a href="{{ route('matchday.unlock') }}" class="f-hero-cta">
                        ⚽ You Have {{ $totalPicksRemaining }} Pick{{ $totalPicksRemaining > 1 ? 's' : '' }} Available! Choose Now &rarr;
                    </a>
                @else
                    <a href="{{ route('matchday.team') }}" class="f-hero-cta">
                        📋 Manage Your England XI Squad &rarr;
                    </a>
                @endif
            </div>

            {{-- KPI STATS GRID --}}
            <div class="f-kpi-grid">
                <div class="f-kpi-card">
                    <div class="f-kpi-icon">🎟️</div>
                    <div>
                        <div class="f-kpi-title">Unlocks Waiting</div>
                        <div class="f-kpi-value">{{ $totalPicksRemaining }}</div>
                    </div>
                </div>

                <div class="f-kpi-card">
                    <div class="f-kpi-icon">🎴</div>
                    <div>
                        <div class="f-kpi-title">Squad Cards</div>
                        <div class="f-kpi-value">{{ $ownedCount }}</div>
                    </div>
                </div>

                <div class="f-kpi-card">
                    <div class="f-kpi-icon">⚡</div>
                    <div>
                        <div class="f-kpi-title">Team Rating</div>
                        <div class="f-kpi-value">{{ $team ? $team->total_strength : 'Unset' }}</div>
                    </div>
                </div>

                <div class="f-kpi-card">
                    <div class="f-kpi-icon">⚔️</div>
                    <div>
                        <div class="f-kpi-title">Pending Duels</div>
                        <div class="f-kpi-value">{{ $pendingChallengesCount }}</div>
                    </div>
                </div>
            </div>

            {{-- 3 CORE ACTIONS --}}
            <div class="f-nav-grid">
                {{-- UNLOCK PLAYERS --}}
                <a href="{{ route('matchday.unlock') }}" class="f-action-card">
                    <div>
                        <span class="f-card-tag" style="background: #EFF6FF; color: #1D4ED8;">Picks & Catalogue</span>
                        <h3>Unlock Footballers</h3>
                        <p>Browse eligible England players from top UK clubs and pick additions to your fantasy collection.</p>
                    </div>
                    <div class="f-action-btn">
                        Pick Players &rarr;
                    </div>
                </a>

                {{-- MY SQUAD / COLLECTION --}}
                <a href="{{ route('matchday.collection') }}" class="f-action-card">
                    <div>
                        <span class="f-card-tag" style="background: #FDF2F8; color: #BE185D;">Social & Trading</span>
                        <h3>My Player Cards</h3>
                        <p>Inspect your squad cards. Gift cards to friends or share temporary access without losing ownership.</p>
                    </div>
                    <div class="f-action-btn">
                        View Collection &rarr;
                    </div>
                </a>

                {{-- BUILD ENGLAND XI PITCH --}}
                <a href="{{ route('matchday.team') }}" class="f-action-card">
                    <div>
                        <span class="f-card-tag" style="background: #ECFDF5; color: #047857;">Tactics & Pitch</span>
                        <h3>Build England XI</h3>
                        <p>Set your 4-3-3, 4-4-2, or 3-5-2 formation on the visual pitch, name your captain, and boost your strength.</p>
                    </div>
                    <div class="f-action-btn">
                        Open Pitch Builder &rarr;
                    </div>
                </a>
            </div>

            {{-- RECENT CHALLENGES / MATCHES --}}
            <div class="f-table-card">
                <div class="f-table-head">
                    <h2>Recent 1v1 Matches & Challenges</h2>
                    <a href="{{ route('matchday.challenges') }}" style="font-weight: 700; color: #C25A2A; font-size: 13px; text-decoration: none;">View All Challenges &rarr;</a>
                </div>

                @if($recentGames->isEmpty())
                    <div style="text-align: center; padding: 30px; color: #9CA3AF;">
                        <p style="margin: 0 0 10px; font-size: 14px;">No matchday games played yet.</p>
                        <a href="{{ route('matchday.challenges') }}" style="display: inline-block; background: #FAF7F2; border: 1px solid #E5E7EB; padding: 8px 18px; border-radius: 8px; color: #374151; font-weight: 600; font-size: 13px; text-decoration: none;">
                            Send a Challenge to a Friend
                        </a>
                    </div>
                @else
                    @foreach($recentGames as $game)
                        <div class="f-match-item">
                            <div>
                                <span style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; color: #111;">
                                    {{ $game->challenger->name }} vs {{ $game->defender->name }}
                                </span>
                                <div style="font-size: 12px; color: #888;">
                                    {{ $game->played_at ? $game->played_at->format('d M Y, H:i') : 'Just now' }}
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span style="font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 18px; color: #C25A2A;">
                                    {{ $game->challenger_score }} - {{ $game->defender_score }}
                                </span>
                                <div>
                                    <a href="{{ route('matchday.match-result', $game->id) }}" style="font-size: 12px; color: #2563EB; font-weight: 600; text-decoration: none;">View Match Highlights &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- LEADERBOARD TEASER --}}
            <div style="margin-top: 24px; background: #FFFBEB; border: 1px dashed #F59E0B; border-radius: 16px; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="font-size: 28px;">🏆</div>
                    <div>
                        <strong style="color: #92400E; font-size: 15px; font-family: 'Poppins', sans-serif;">Season 2026 Manager Leaderboard</strong>
                        <p style="margin: 2px 0 0; font-size: 13px; color: #78350F;">Climb to the top of the manager rankings by winning 1v1 challenges with your England XI squad. Free to play!</p>
                    </div>
                </div>
                <a href="{{ route('matchday.leaderboard') }}" style="background: #F59E0B; color: #fff; font-weight: 700; font-size: 13px; padding: 8px 18px; border-radius: 10px; text-decoration: none;">
                    View Leaderboard
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
