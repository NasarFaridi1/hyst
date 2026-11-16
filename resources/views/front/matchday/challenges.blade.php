@extends('front.layouts.app')

@section('title', 'Friend Challenges & 1v1 Duels | HYST Fantasy XI')

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

    .f-section-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .f-section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 16px;
        color: #111;
    }
    .f-challenge-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        border: 1px solid #F0F0EC;
        border-radius: 14px;
        margin-bottom: 12px;
        background: #FAF7F2;
    }

    /* MODAL */
    .f-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .f-modal-content {
        background: #fff;
        border-radius: 20px;
        padding: 28px;
        max-width: 440px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

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
                    <h1>1v1 Friend Challenges</h1>
                    <p>Challenge friends to a head-to-head match with your saved England squad. 100% free to play.</p>
                </div>
                <div>
                    @if($myTeam)
                        <button type="button" onclick="document.getElementById('challengeModal').style.display = 'flex'" style="background: #C25A2A; color: #fff; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 13px; cursor: pointer;">
                            ⚔️ Challenge a Friend
                        </button>
                    @else
                        <a href="{{ route('matchday.team') }}" style="background: #C25A2A; color: #fff; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 13px; text-decoration: none;">
                            📋 Build Team First
                        </a>
                    @endif
                </div>
            </div>

            {{-- INCOMING CHALLENGES --}}
            <div class="f-section-card">
                <div class="f-section-title">Incoming Challenges ({{ $incomingChallenges->count() }})</div>

                @if($incomingChallenges->isEmpty())
                    <p style="font-size: 13.5px; color: #888; margin: 0;">No incoming challenges right now. Send one to a friend!</p>
                @else
                    @foreach($incomingChallenges as $ch)
                        <div class="f-challenge-item">
                            <div>
                                <strong style="font-family: 'Poppins', sans-serif; font-size: 15px; color: #111;">
                                    {{ $ch->challenger->name }} has challenged you!
                                </strong>
                                <div style="font-size: 12px; color: #666; margin-top: 2px;">
                                    Challenger Squad: {{ $ch->challengerTeam->name ?? 'Squad' }} ({{ $ch->challengerTeam->total_strength ?? 0 }} OVR)
                                </div>
                            </div>

                            @if($myTeam)
                                <form method="POST" action="{{ route('matchday.play-challenge', $ch->id) }}">
                                    @csrf
                                    <input type="hidden" name="team_id" value="{{ $myTeam->id }}">
                                    <button type="submit" style="background: #10B981; color: #fff; border: none; padding: 8px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;">
                                        Accept & Play &rarr;
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('matchday.team') }}" style="font-size: 12px; color: #C25A2A; font-weight: 700; text-decoration: none;">Save Team to Accept</a>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- MATCH HISTORY --}}
            <div class="f-section-card">
                <div class="f-section-title">Match History & Results</div>

                @if($recentGames->isEmpty())
                    <p style="font-size: 13.5px; color: #888; margin: 0;">No completed matches yet.</p>
                @else
                    @foreach($recentGames as $game)
                        <div class="f-challenge-item" style="background: #fff; border-color: #EFECE6;">
                            <div>
                                <div style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; color: #111;">
                                    {{ $game->challenger->name }} vs {{ $game->defender->name }}
                                </div>
                                <div style="font-size: 12px; color: #888; margin-top: 2px;">
                                    {{ $game->played_at ? $game->played_at->format('d M Y, H:i') : '' }} &bull; 
                                    Winner: <strong>{{ $game->winner ? $game->winner->name : 'Draw' }}</strong>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span style="font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 800; color: #C25A2A;">
                                    {{ $game->challenger_score }} - {{ $game->defender_score }}
                                </span>
                                <div>
                                    <a href="{{ route('matchday.match-result', $game->id) }}" style="font-size: 12px; color: #2563EB; font-weight: 600; text-decoration: none;">
                                        View Match Commentary &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</div>

{{-- CHALLENGE FRIEND MODAL --}}
<div id="challengeModal" class="f-modal">
    <div class="f-modal-content">
        <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin: 0 0 8px;">Challenge a Friend</h3>
        <p style="font-size: 13px; color: #666; margin: 0 0 16px;">
            Send a 1v1 match invitation using your saved squad: <strong>{{ $myTeam->name ?? '' }}</strong>.
        </p>

        <form method="POST" action="{{ route('matchday.create-challenge') }}">
            @csrf
            <input type="hidden" name="team_id" value="{{ $myTeam->id ?? 0 }}">

            <label style="font-size: 12px; font-weight: 700; color: #374151;">Friend's Registered Email</label>
            <input type="text" name="defender_identifier" placeholder="friend@example.com" style="width: 100%; border: 1px solid #D1D5DB; border-radius: 10px; padding: 10px 14px; font-size: 14px; margin-top: 6px; margin-bottom: 14px; box-sizing: border-box;" required>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="button" onclick="document.getElementById('challengeModal').style.display = 'none'" style="flex: 1; background: #F3F4F6; border: none; border-radius: 10px; padding: 10px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="flex: 2; background: #C25A2A; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Send Challenge</button>
            </div>
        </form>
    </div>
</div>
@endsection
