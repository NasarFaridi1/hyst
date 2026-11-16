@extends('front.layouts.app')

@section('title', 'Season Leaderboard | HYST Fantasy XI')

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

    .f-prize-card {
        background: linear-gradient(135deg, #0A192F 0%, #172A45 50%, #1E3A8A 100%);
        border-radius: 24px;
        padding: 32px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(10, 25, 47, 0.2);
    }
    .f-prize-card h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 26px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .f-leaderboard-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .lb-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-bottom: 1px solid #F4F2ED;
    }
    .lb-row:last-child {
        border-bottom: none;
    }
    .lb-rank {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #FAF7F2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 13px;
        color: #111;
        margin-right: 14px;
    }
    .rank-1 { background: #FEF3C7; color: #B45309; }
    .rank-2 { background: #E5E7EB; color: #374151; }
    .rank-3 { background: #FFEDD5; color: #9A3412; }

    @media (max-width: 991px) {
        .f-container { grid-template-columns: 1fr; }
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
            {{-- LEADERBOARD BANNER --}}
            <div class="f-prize-card">
                <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; background: rgba(255,255,255,0.15); padding: 4px 12px; border-radius: 999px; display: inline-block; margin-bottom: 10px;">
                    🏆 Season 2026 Rankings
                </div>
                <h1>Season Leaderboard</h1>
                <p style="margin: 0; font-size: 14px; color: #E2E8F0; max-width: 600px; line-height: 1.5;">
                    Points are earned by winning 1v1 challenges with your England XI squad. Free to play with your food orders. Test your football knowledge and climb to the top of the manager rankings!
                </p>
            </div>

            {{-- LEADERBOARD TABLE --}}
            <div class="f-leaderboard-card">
                <div style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 700; margin-bottom: 16px; color: #111;">
                    Top Managers Ranking
                </div>

                @forelse($topManagers as $index => $mgr)
                    @php $rank = $index + 1; @endphp
                    <div class="lb-row">
                        <div style="display: flex; align-items: center;">
                            <div class="lb-rank rank-{{ $rank <= 3 ? $rank : 'other' }}">
                                {{ $rank }}
                            </div>
                            <div>
                                <strong style="font-family: 'Poppins', sans-serif; font-size: 14px; color: #111;">
                                    {{ $mgr->name }}
                                </strong>
                                <div style="font-size: 12px; color: #888;">
                                    {{ $mgr->wins }} match victories
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <span style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 800; color: #C25A2A;">
                                {{ $mgr->points }} pts
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: #9CA3AF;">
                        <p style="margin: 0 0 10px; font-size: 14px;">Season has just kicked off! Challenge friends to get on the leaderboard.</p>
                        <a href="{{ route('matchday.challenges') }}" style="background: #C25A2A; color: #fff; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13px; text-decoration: none;">
                            Start a Challenge
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection
