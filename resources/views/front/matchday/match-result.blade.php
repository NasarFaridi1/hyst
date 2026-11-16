@extends('front.layouts.app')

@section('title', 'Match Highlights & Analysis | HYST Fantasy XI')

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
        max-width: 900px;
        margin: 0 auto;
    }

    /* SCOREBOARD */
    .f-scoreboard {
        background: linear-gradient(135deg, #0A192F 0%, #172A45 100%);
        border-radius: 24px;
        padding: 36px 30px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 12px 30px rgba(10,25,47,0.15);
    }
    .f-score-row {
        display: flex;
        justify-content: space-around;
        align-items: center;
        text-align: center;
    }
    .team-name {
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 6px;
    }
    .team-manager {
        font-size: 13px;
        color: #94A3B8;
    }
    .score-badge {
        font-family: 'Poppins', sans-serif;
        font-size: 52px;
        font-weight: 900;
        color: #F59E0B;
        padding: 0 24px;
    }

    /* SECTOR STATS COMPARISON */
    .f-stats-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 24px;
        margin-bottom: 24px;
    }
    .f-stats-card h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 18px;
    }
    .stat-comparison-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }
    .stat-bar-container {
        flex: 1;
        margin: 0 16px;
        height: 8px;
        background: #F3F4F6;
        border-radius: 999px;
        overflow: hidden;
        display: flex;
    }

    /* TIMELINE */
    .f-timeline {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 24px;
    }
    .timeline-item {
        display: flex;
        gap: 16px;
        padding: 14px 0;
        border-bottom: 1px solid #F4F2ED;
        align-items: flex-start;
    }
    .timeline-minute {
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 800;
        color: #C25A2A;
        width: 36px;
        flex-shrink: 0;
    }
    .timeline-icon {
        font-size: 18px;
    }
    .timeline-text {
        font-size: 14px;
        color: #374151;
        line-height: 1.4;
    }
</style>

<div class="f-page">
    <div class="f-container">

        <div style="margin-bottom: 16px;">
            <a href="{{ route('matchday.challenges') }}" style="color: #6B7280; font-weight: 600; font-size: 13px; text-decoration: none;">
                &larr; Back to Challenges
            </a>
        </div>

        {{-- SCOREBOARD --}}
        <div class="f-scoreboard">
            <div style="text-align: center; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #94A3B8; margin-bottom: 16px;">
                Full Time Match Result &bull; {{ $game->played_at ? $game->played_at->format('d M Y') : '' }}
            </div>

            <div class="f-score-row">
                <div style="flex: 1;">
                    <div class="team-name">{{ $game->challengerTeam->name ?? 'Challenger' }}</div>
                    <div class="team-manager">Manager: {{ $game->challenger->name }}</div>
                </div>

                <div class="score-badge">
                    {{ $game->challenger_score }} - {{ $game->defender_score }}
                </div>

                <div style="flex: 1;">
                    <div class="team-name">{{ $game->defenderTeam->name ?? 'Defender' }}</div>
                    <div class="team-manager">Manager: {{ $game->defender->name }}</div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 18px; font-size: 13px; color: #CBD5E1;">
                @if($game->winner)
                    🏆 <strong>{{ $game->winner->name }}</strong> claimed victory in this 1v1 showdown!
                @else
                    🤝 A hard-fought tactical draw between both England squads!
                @endif
            </div>
        </div>

        {{-- SECTOR ATTRIBUTES COMPARISON --}}
        @php
            $stats = $game->match_summary;
            $cStats = $stats['challenger_stats'] ?? ['att' => 75, 'mid' => 75, 'def' => 75, 'gk' => 80];
            $dStats = $stats['defender_stats'] ?? ['att' => 75, 'mid' => 75, 'def' => 75, 'gk' => 80];
        @endphp
        <div class="f-stats-card">
            <h3>Tactical Sector Breakdown</h3>

            <div class="stat-comparison-row">
                <strong style="width: 40px; text-align: left;">{{ $cStats['att'] }}</strong>
                <div class="stat-bar-container">
                    <div style="width: {{ ($cStats['att'] / ($cStats['att'] + $dStats['att'])) * 100 }}%; background: #C25A2A;"></div>
                    <div style="width: {{ ($dStats['att'] / ($cStats['att'] + $dStats['att'])) * 100 }}%; background: #2563EB;"></div>
                </div>
                <strong style="width: 40px; text-align: right;">{{ $dStats['att'] }}</strong>
            </div>
            <div style="text-align: center; font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; margin-top: -8px; margin-bottom: 14px;">Attack Comparison</div>

            <div class="stat-comparison-row">
                <strong style="width: 40px; text-align: left;">{{ $cStats['mid'] }}</strong>
                <div class="stat-bar-container">
                    <div style="width: {{ ($cStats['mid'] / ($cStats['mid'] + $dStats['mid'])) * 100 }}%; background: #C25A2A;"></div>
                    <div style="width: {{ ($dStats['mid'] / ($cStats['mid'] + $dStats['mid'])) * 100 }}%; background: #2563EB;"></div>
                </div>
                <strong style="width: 40px; text-align: right;">{{ $dStats['mid'] }}</strong>
            </div>
            <div style="text-align: center; font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; margin-top: -8px; margin-bottom: 14px;">Midfield Control</div>

            <div class="stat-comparison-row">
                <strong style="width: 40px; text-align: left;">{{ $cStats['def'] }}</strong>
                <div class="stat-bar-container">
                    <div style="width: {{ ($cStats['def'] / ($cStats['def'] + $dStats['def'])) * 100 }}%; background: #C25A2A;"></div>
                    <div style="width: {{ ($dStats['def'] / ($cStats['def'] + $dStats['def'])) * 100 }}%; background: #2563EB;"></div>
                </div>
                <strong style="width: 40px; text-align: right;">{{ $dStats['def'] }}</strong>
            </div>
            <div style="text-align: center; font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; margin-top: -8px; margin-bottom: 14px;">Defensive Strength</div>
        </div>

        {{-- MATCH COMMENTARY TIMELINE --}}
        <div class="f-timeline">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 700; margin: 0 0 16px;">
                Minute-by-Minute Highlights
            </h3>

            @forelse($game->events as $event)
                <div class="timeline-item">
                    <div class="timeline-minute">{{ $event->minute }}'</div>
                    <div class="timeline-icon">
                        @if($event->event_type === 'goal') ⚽ @elseif($event->event_type === 'save') 🧤 @else ⚡ @endif
                    </div>
                    <div class="timeline-text">
                        <strong>{{ $event->actor_name }}</strong>: {{ $event->description }}
                    </div>
                </div>
            @empty
                <p style="font-size: 14px; color: #888;">A disciplined tactical battle with no critical chances conceded.</p>
            @endforelse
        </div>

    </div>
</div>
@endsection
