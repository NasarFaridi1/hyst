@extends('front.layouts.app')

@section('title', 'Build Your England XI Pitch | HYST Fantasy XI')

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

    /* PITCH LAYOUT */
    .f-pitch-container {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }
    .f-football-pitch {
        background: linear-gradient(180deg, #1E7E34 0%, #155724 100%);
        border: 4px solid #fff;
        border-radius: 24px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        padding: 32px 20px;
        position: relative;
        overflow: hidden;
        min-height: 600px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    /* Pitch markings */
    .f-football-pitch::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(255,255,255,0.4);
    }
    .pitch-center-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120px;
        height: 120px;
        border: 2px solid rgba(255,255,255,0.4);
        border-radius: 50%;
        pointer-events: none;
    }

    .pitch-line {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 100%;
        position: relative;
        z-index: 2;
    }
    .pitch-slot {
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid #E2E8F0;
        border-radius: 16px;
        width: 90px;
        padding: 6px 4px 8px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: transform .15s, border-color .15s;
    }
    .pitch-slot:hover {
        transform: translateY(-2px) scale(1.03);
        border-color: #C25A2A;
    }
    .slot-avatar-wrap {
        width: 44px;
        height: 44px;
        margin: 0 auto 4px;
        border-radius: 50%;
        background: #F8FAFC;
        border: 2px solid #C25A2A;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    }
    .slot-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .slot-pos-badge {
        font-size: 9.5px;
        font-weight: 800;
        background: #0D0D0D;
        color: #fff;
        padding: 1px 6px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 4px;
    }
    .slot-name {
        font-family: 'Poppins', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #111;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .slot-ovr {
        font-size: 10px;
        color: #C25A2A;
        font-weight: 800;
    }

    /* SQUAD PANEL */
    .f-squad-panel {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #EFECE6;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .f-squad-panel h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 12px;
    }

    @media (max-width: 991px) {
        .f-container { grid-template-columns: 1fr; }
        .f-pitch-container { grid-template-columns: 1fr; }
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
                    <h1>Build Your England XI</h1>
                    <p>Select your formation, assign your 11 positions, pick your captain and save your squad.</p>
                </div>
                <div>
                    <span style="font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; color: #065F46; background: #ECFDF5; padding: 8px 16px; border-radius: 999px;">
                        Team Strength: {{ $team ? $team->total_strength : 0 }} OVR
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('matchday.save-team') }}">
                @csrf

                <div class="f-pitch-container">
                    {{-- THE GREEN FOOTBALL PITCH --}}
                    <div class="f-football-pitch">
                        <div class="pitch-center-circle"></div>

                        {{-- FORWARDS (ATT) --}}
                        <div class="pitch-line">
                            @php
                                $fwdPositions = ['LW', 'ST', 'RW'];
                            @endphp
                            @foreach($fwdPositions as $pos)
                                @php 
                                    $selId = $existingSlots[$pos] ?? null; 
                                    $selectedCard = $collection['all']->firstWhere('id', $selId);
                                    $avatarSrc = $selectedCard && $selectedCard->catalogue ? $selectedCard->catalogue->image_url : 'https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';
                                @endphp
                                <div class="pitch-slot">
                                    <div class="slot-avatar-wrap">
                                        <img src="{{ $avatarSrc }}" 
                                             id="avatar_{{ $pos }}" 
                                             class="slot-avatar-img" 
                                             alt="{{ $pos }}" 
                                             onerror="this.onerror=null; this.src='https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';">
                                    </div>
                                    <span class="slot-pos-badge">{{ $pos }}</span>
                                    <select name="positions[{{ $pos }}]" onchange="updateSlotAvatar('{{ $pos }}', this)" style="width: 100%; font-size: 10px; border: 1px solid #E5E7EB; border-radius: 6px; padding: 2px;" required>
                                        <option value="" data-img="https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png">-- Pick --</option>
                                        @foreach($collection['all']->where('catalogue.position', 'FWD') as $card)
                                            <option value="{{ $card->id }}" data-img="{{ $card->catalogue->image_url }}" {{ $selId == $card->id ? 'selected' : '' }}>
                                                {{ $card->catalogue->display_name }} ({{ $card->catalogue->overall_rating }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>

                        {{-- MIDFIELDERS (MID) --}}
                        <div class="pitch-line">
                            @php
                                $midPositions = ['CM1', 'CAM', 'CM2'];
                            @endphp
                            @foreach($midPositions as $pos)
                                @php 
                                    $selId = $existingSlots[$pos] ?? null; 
                                    $selectedCard = $collection['all']->firstWhere('id', $selId);
                                    $avatarSrc = $selectedCard && $selectedCard->catalogue ? $selectedCard->catalogue->image_url : 'https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';
                                @endphp
                                <div class="pitch-slot">
                                    <div class="slot-avatar-wrap">
                                        <img src="{{ $avatarSrc }}" 
                                             id="avatar_{{ $pos }}" 
                                             class="slot-avatar-img" 
                                             alt="{{ $pos }}" 
                                             onerror="this.onerror=null; this.src='https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';">
                                    </div>
                                    <span class="slot-pos-badge">{{ $pos }}</span>
                                    <select name="positions[{{ $pos }}]" onchange="updateSlotAvatar('{{ $pos }}', this)" style="width: 100%; font-size: 10px; border: 1px solid #E5E7EB; border-radius: 6px; padding: 2px;" required>
                                        <option value="" data-img="https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png">-- Pick --</option>
                                        @foreach($collection['all']->where('catalogue.position', 'MID') as $card)
                                            <option value="{{ $card->id }}" data-img="{{ $card->catalogue->image_url }}" {{ $selId == $card->id ? 'selected' : '' }}>
                                                {{ $card->catalogue->display_name }} ({{ $card->catalogue->overall_rating }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>

                        {{-- DEFENDERS (DEF) --}}
                        <div class="pitch-line">
                            @php
                                $defPositions = ['LB', 'CB1', 'CB2', 'RB'];
                            @endphp
                            @foreach($defPositions as $pos)
                                @php 
                                    $selId = $existingSlots[$pos] ?? null; 
                                    $selectedCard = $collection['all']->firstWhere('id', $selId);
                                    $avatarSrc = $selectedCard && $selectedCard->catalogue ? $selectedCard->catalogue->image_url : 'https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';
                                @endphp
                                <div class="pitch-slot">
                                    <div class="slot-avatar-wrap">
                                        <img src="{{ $avatarSrc }}" 
                                             id="avatar_{{ $pos }}" 
                                             class="slot-avatar-img" 
                                             alt="{{ $pos }}" 
                                             onerror="this.onerror=null; this.src='https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';">
                                    </div>
                                    <span class="slot-pos-badge">{{ $pos }}</span>
                                    <select name="positions[{{ $pos }}]" onchange="updateSlotAvatar('{{ $pos }}', this)" style="width: 100%; font-size: 10px; border: 1px solid #E5E7EB; border-radius: 6px; padding: 2px;" required>
                                        <option value="" data-img="https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png">-- Pick --</option>
                                        @foreach($collection['all']->where('catalogue.position', 'DEF') as $card)
                                            <option value="{{ $card->id }}" data-img="{{ $card->catalogue->image_url }}" {{ $selId == $card->id ? 'selected' : '' }}>
                                                {{ $card->catalogue->display_name }} ({{ $card->catalogue->overall_rating }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>

                        {{-- GOALKEEPER (GK) --}}
                        <div class="pitch-line">
                            @php 
                                $selId = $existingSlots['GK'] ?? null; 
                                $selectedCard = $collection['all']->firstWhere('id', $selId);
                                $avatarSrc = $selectedCard && $selectedCard->catalogue ? $selectedCard->catalogue->image_url : 'https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';
                            @endphp
                            <div class="pitch-slot" style="background: #FEF3C7; border-color: #F59E0B;">
                                <div class="slot-avatar-wrap" style="border-color: #D97706;">
                                    <img src="{{ $avatarSrc }}" 
                                         id="avatar_GK" 
                                         class="slot-avatar-img" 
                                         alt="GK" 
                                         onerror="this.onerror=null; this.src='https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png';">
                                </div>
                                <span class="slot-pos-badge" style="background: #B45309;">GK</span>
                                <select name="positions[GK]" onchange="updateSlotAvatar('GK', this)" style="width: 100%; font-size: 10px; border: 1px solid #E5E7EB; border-radius: 6px; padding: 2px;" required>
                                    <option value="" data-img="https://resources.premierleague.com/premierleague/photos/players/250x250/Photo-Missing.png">-- Pick GK --</option>
                                    @foreach($collection['all']->where('catalogue.position', 'GK') as $card)
                                        <option value="{{ $card->id }}" data-img="{{ $card->catalogue->image_url }}" {{ $selId == $card->id ? 'selected' : '' }}>
                                            {{ $card->catalogue->display_name }} ({{ $card->catalogue->overall_rating }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- SIDE CONFIGURATION PANEL --}}
                    <div class="f-squad-panel">
                        <h3>Team Settings</h3>

                        <div style="margin-bottom: 16px;">
                            <label style="font-size: 12px; font-weight: 700; color: #4B5563;">Team Name</label>
                            <input type="text" name="name" value="{{ $team->name ?? 'My England XI' }}" style="width: 100%; border: 1px solid #D1D5DB; border-radius: 10px; padding: 9px 12px; font-size: 14px; margin-top: 4px; box-sizing: border-box;" required>
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="font-size: 12px; font-weight: 700; color: #4B5563;">Tactical Formation</label>
                            <select name="formation" style="width: 100%; border: 1px solid #D1D5DB; border-radius: 10px; padding: 9px 12px; font-size: 14px; margin-top: 4px; box-sizing: border-box;">
                                <option value="4-3-3" {{ ($team->formation ?? '4-3-3') == '4-3-3' ? 'selected' : '' }}>4-3-3 (Default Attack)</option>
                                <option value="4-4-2" {{ ($team->formation ?? '') == '4-4-2' ? 'selected' : '' }}>4-4-2 (Balanced Classic)</option>
                                <option value="3-5-2" {{ ($team->formation ?? '') == '3-5-2' ? 'selected' : '' }}>3-5-2 (Midfield Control)</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 22px;">
                            <label style="font-size: 12px; font-weight: 700; color: #4B5563;">Squad Captain (+5 Boost)</label>
                            <select name="captain_id" style="width: 100%; border: 1px solid #D1D5DB; border-radius: 10px; padding: 9px 12px; font-size: 14px; margin-top: 4px; box-sizing: border-box;">
                                <option value="">-- None --</option>
                                @foreach($collection['all'] as $card)
                                    <option value="{{ $card->id }}" {{ ($team->captain_player_copy_id ?? null) == $card->id ? 'selected' : '' }}>
                                        {{ $card->catalogue->name }} ({{ $card->catalogue->overall_rating }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" style="width: 100%; background: #C25A2A; color: #fff; border: none; border-radius: 12px; padding: 13px 0; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; cursor: pointer; transition: background .15s;">
                            💾 Save England XI Lineup
                        </button>

                        <div style="margin-top: 14px; font-size: 12px; color: #6B7280; text-align: center; line-height: 1.4;">
                            You need 1 GK, 4 DEF, 3 MID, and 3 FWD to form a complete valid squad.
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    function updateSlotAvatar(pos, selectElem) {
        const selectedOption = selectElem.options[selectElem.selectedIndex];
        const imgUrl = selectedOption.getAttribute('data-img');
        const avatarImg = document.getElementById('avatar_' + pos);
        if (avatarImg && imgUrl) {
            avatarImg.src = imgUrl;
        }
    }
</script>
@endsection
