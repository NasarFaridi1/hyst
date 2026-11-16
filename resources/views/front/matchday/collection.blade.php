@extends('front.layouts.app')

@section('title', 'My England Player Cards | HYST Fantasy XI')

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

    .f-filter-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }
    .f-tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
    }
    .f-tab {
        padding: 8px 18px;
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

    /* CARDS */
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

    .f-ownership-tag {
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .tag-owned { background: #ECFDF5; color: #047857; }
    .tag-gifted { background: #FDF2F8; color: #BE185D; }
    .tag-shared { background: #EFF6FF; color: #1D4ED8; }

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
    }

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

    .f-action-buttons {
        display: flex;
        gap: 8px;
    }
    .f-btn-secondary {
        flex: 1;
        background: #F3F4F6;
        color: #374151;
        border: none;
        border-radius: 10px;
        padding: 8px 0;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }
    .f-btn-secondary:hover {
        background: #E5E7EB;
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
    .f-modal-content h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px;
    }
    .f-input {
        width: 100%;
        border: 1px solid #D1D5DB;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        margin-top: 6px;
        margin-bottom: 14px;
        box-sizing: border-box;
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
                    <h1>My Squad Collection</h1>
                    <p>Manage your unlocked England footballers. Gift copies to friends or share temporary access.</p>
                </div>
                <div>
                    <a href="{{ route('matchday.unlock') }}" style="background: #C25A2A; color: #fff; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 13px; text-decoration: none;">
                        + Unlock More Players
                    </a>
                </div>
            </div>

            {{-- FILTER ROWS --}}
            <div class="f-filter-row">
                <div class="f-tabs">
                    <a href="{{ route('matchday.collection', ['filter' => 'all', 'position' => $position]) }}" class="f-tab {{ $filter == 'all' ? 'active' : '' }}">All Cards ({{ $collection['all']->count() }})</a>
                    <a href="{{ route('matchday.collection', ['filter' => 'owned', 'position' => $position]) }}" class="f-tab {{ $filter == 'owned' ? 'active' : '' }}">Owned ({{ $collection['owned']->count() }})</a>
                    <a href="{{ route('matchday.collection', ['filter' => 'gifted', 'position' => $position]) }}" class="f-tab {{ $filter == 'gifted' ? 'active' : '' }}">Gifted to Me ({{ $collection['gifted']->count() }})</a>
                    <a href="{{ route('matchday.collection', ['filter' => 'shared', 'position' => $position]) }}" class="f-tab {{ $filter == 'shared' ? 'active' : '' }}">Shared With Me ({{ $collection['shared']->count() }})</a>
                </div>

                <div class="f-tabs">
                    <a href="{{ route('matchday.collection', ['filter' => $filter]) }}" class="f-tab {{ empty($position) ? 'active' : '' }}">All Pos</a>
                    <a href="{{ route('matchday.collection', ['filter' => $filter, 'position' => 'GK']) }}" class="f-tab {{ $position == 'GK' ? 'active' : '' }}">GK</a>
                    <a href="{{ route('matchday.collection', ['filter' => $filter, 'position' => 'DEF']) }}" class="f-tab {{ $position == 'DEF' ? 'active' : '' }}">DEF</a>
                    <a href="{{ route('matchday.collection', ['filter' => $filter, 'position' => 'MID']) }}" class="f-tab {{ $position == 'MID' ? 'active' : '' }}">MID</a>
                    <a href="{{ route('matchday.collection', ['filter' => $filter, 'position' => 'FWD']) }}" class="f-tab {{ $position == 'FWD' ? 'active' : '' }}">FWD</a>
                </div>
            </div>

            {{-- CARDS GRID --}}
            @if($collection['all']->isEmpty())
                <div style="background: #fff; border-radius: 20px; border: 1px solid #EFECE6; padding: 50px 20px; text-align: center;">
                    <div style="font-size: 40px; margin-bottom: 12px;">🎴</div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin: 0 0 8px; color: #111;">No cards in this view</h3>
                    <p style="color: #666; font-size: 14px; margin: 0 0 18px;">Unlock England players with your Hyst food delivery orders!</p>
                    <a href="{{ route('matchday.unlock') }}" style="background: #C25A2A; color: #fff; padding: 10px 24px; border-radius: 12px; font-weight: 700; font-size: 13px; text-decoration: none;">
                        Browse England Catalogue
                    </a>
                </div>
            @else
                <div class="f-cards-grid">
                    @foreach($collection['all'] as $card)
                        @php
                            $player = $card->catalogue;
                            $isShared = !empty($card->is_shared);
                            $isGifted = ($card->acquisition_type === 'gift_received');
                        @endphp
                        <div class="f-player-card rarity-border-{{ $player->rarity }}">
                            <div>
                                <div class="f-card-top-bar">
                                    <div class="f-player-ovr">
                                        {{ $player->overall_rating }}
                                        <small>{{ $player->position }}</small>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span style="font-size: 14px;" title="England">🏴󠁧󠁢󠁥󠁮󠁧󠁿</span>
                                        @if($isShared)
                                            <span class="f-ownership-tag tag-shared">Shared</span>
                                        @elseif($isGifted)
                                            <span class="f-ownership-tag tag-gifted">Gifted</span>
                                        @else
                                            <span class="f-ownership-tag tag-owned">Owned</span>
                                        @endif
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

                            @if(!$isShared)
                                <div class="f-action-buttons">
                                    <button type="button" class="f-btn-secondary" onclick="openGiftModal('{{ $card->id }}', '{{ $player->name }}')">
                                        🎁 Gift Player
                                    </button>
                                    <button type="button" class="f-btn-secondary" onclick="openShareModal('{{ $card->id }}', '{{ $player->name }}')">
                                        🔗 Share Access
                                    </button>
                                </div>
                            @else
                                <div style="font-size: 11px; color: #2563EB; font-weight: 600; text-align: center; background: #EFF6FF; padding: 6px; border-radius: 8px;">
                                    Borrowed from friend for matches
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

{{-- GIFT MODAL --}}
<div id="giftModal" class="f-modal">
    <div class="f-modal-content">
        <h3>Gift Player Card</h3>
        <p style="font-size: 13px; color: #666; margin: 0 0 16px;">
            Transfer permanent ownership of <strong id="giftPlayerName"></strong> to a friend on Hyst.
        </p>

        <form method="POST" action="{{ route('matchday.gift') }}">
            @csrf
            <input type="hidden" name="player_copy_id" id="giftCopyId">

            <label style="font-size: 12px; font-weight: 700; color: #374151;">Friend's Registered Email</label>
            <input type="text" name="recipient_identifier" class="f-input" placeholder="friend@example.com" required>

            <label style="font-size: 12px; font-weight: 700; color: #374151;">Message (Optional)</label>
            <input type="text" name="message" class="f-input" placeholder="Good luck in your Fantasy XI team!">

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="button" onclick="closeModal('giftModal')" class="f-btn-secondary" style="padding: 10px;">Cancel</button>
                <button type="submit" style="flex: 1; background: #C25A2A; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Send Gift</button>
            </div>
        </form>
    </div>
</div>

{{-- SHARE MODAL --}}
<div id="shareModal" class="f-modal">
    <div class="f-modal-content">
        <h3>Share Player Access</h3>
        <p style="font-size: 13px; color: #666; margin: 0 0 16px;">
            Allow a friend to borrow <strong id="sharePlayerName"></strong> in their squad for 7 days while retaining your ownership.
        </p>

        <form method="POST" action="{{ route('matchday.share') }}">
            @csrf
            <input type="hidden" name="player_copy_id" id="shareCopyId">

            <label style="font-size: 12px; font-weight: 700; color: #374151;">Friend's Registered Email</label>
            <input type="text" name="borrower_identifier" class="f-input" placeholder="friend@example.com" required>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="button" onclick="closeModal('shareModal')" class="f-btn-secondary" style="padding: 10px;">Cancel</button>
                <button type="submit" style="flex: 1; background: #2563EB; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Share Player</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openGiftModal(id, name) {
        document.getElementById('giftCopyId').value = id;
        document.getElementById('giftPlayerName').innerText = name;
        document.getElementById('giftModal').style.display = 'flex';
    }
    function openShareModal(id, name) {
        document.getElementById('shareCopyId').value = id;
        document.getElementById('sharePlayerName').innerText = name;
        document.getElementById('shareModal').style.display = 'flex';
    }
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>
@endsection
