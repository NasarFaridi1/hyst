@extends('front.layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

.profile-page {
    background: #FAF7F2;
    min-height: 100vh;
    padding: 40px 16px 100px;
}

.profile-wrap {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    align-items: start;
}

.profile-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #F0F0EC;
    box-shadow: 0 2px 10px rgba(13,13,13,0.03);
    padding: 36px 32px;
}

/* ── Header with avatar ── */
.profile-header {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 32px;
    padding-bottom: 28px;
    border-bottom: 1px solid #F0F0EC;
}
.profile-avatar {
    width: 64px; height: 64px;
    border-radius: 16px;
    background: #FAF7F2;
    border: 1.5px solid #F0E4D8;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.profile-avatar svg { width: 30px; height: 30px; color: #C25A2A; }

.profile-eyebrow {
    color: #C25A2A;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: 4px;
}
.profile-title {
    font-family: 'Poppins', sans-serif;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -.4px;
    color: #0D0D0D;
    margin: 0 0 2px;
}
.profile-subtitle {
    color: #6B7280;
    font-size: 13.5px;
}

/* ── Form ── */
.p-label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
    letter-spacing: .03em;
    text-transform: uppercase;
}
.p-input-wrap { position: relative; }
.p-input-wrap svg {
    position: absolute;
    left: 16px; top: 50%;
    transform: translateY(-50%);
    width: 17px; height: 17px;
    color: #9CA3AF;
    pointer-events: none;
}
.p-input {
    width: 100%;
    border: 1.5px solid #F0F0EC;
    border-radius: 14px;
    padding: 14px 16px 14px 44px;
    font-size: 14.5px;
    font-family: 'DM Sans', sans-serif;
    color: #0D0D0D;
    background: #FAFAF8;
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
    box-sizing: border-box;
}
.p-input:focus {
    border-color: #C25A2A;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(194,90,42,.10);
}
.p-input:disabled {
    color: #9CA3AF;
    cursor: not-allowed;
}
.p-hint {
    font-size: 11.5px;
    color: #9CA3AF;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.p-hint svg { width: 12px; height: 12px; flex-shrink: 0; }

.p-group { margin-bottom: 22px; }
.p-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }

.p-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: #C25A2A;
    color: #fff;
    border: none;
    border-radius: 14px;
    padding: 15px 32px;
    font-family: 'Poppins', sans-serif;
    font-size: 14.5px;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s, transform .15s;
    margin-top: 6px;
}
.p-btn:hover { background: #c42d0b; transform: translateY(-1px); }
.p-btn svg { width: 16px; height: 16px; }

.p-success {
    background: #ECFDF5;
    border: 1px solid #BBF7D0;
    color: #065F46;
    padding: 14px 18px;
    border-radius: 14px;
    margin-bottom: 24px;
    font-size: 13.5px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}
.p-success svg { width: 18px; height: 18px; flex-shrink: 0; color: #16A34A; }

.mob-page-title {
    display: none;
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 800;
    color: #0D0D0D;
    margin-bottom: 18px;
    letter-spacing: -.3px;
}

@media(max-width: 900px) {
    .profile-wrap { grid-template-columns: 1fr; }
}
@media(max-width: 640px) {
    .profile-page { padding: 20px 14px 100px; }
    .mob-page-title { display: block; }
    .profile-card { padding: 24px 18px; }
    .profile-header { flex-wrap: wrap; }
    .profile-title { font-size: 22px; }
    .p-grid { grid-template-columns: 1fr; gap: 0; }
    .p-btn { width: 100%; justify-content: center; padding: 16px; }
}
</style>

<div class="profile-page">
    <div class="profile-wrap">

        {{-- SIDEBAR --}}
        <div>
            @include('front.layouts.user-sidebar')
        </div>

        {{-- CONTENT --}}
        <div>
            <div class="mob-page-title">My Profile</div>

            <div class="profile-card">

                <div class="profile-header">
                    <div class="profile-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="profile-eyebrow">Account Settings</div>
                        <h1 class="profile-title">My Profile</h1>
                        <p class="profile-subtitle">Manage your personal details</p>
                    </div>
                </div>

                @if(session('success'))
                <div class="p-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="/profile/update">
                    @csrf

                    <div class="p-grid">
                        <div class="p-group">
                            <label class="p-label">Full Name</label>
                            <div class="p-input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="p-input" required>
                            </div>
                        </div>
                        <div class="p-group">
                            <label class="p-label">Email Address</label>
                            <div class="p-input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <input type="email" readonly disabled name="email" value="{{ auth()->user()->email }}" class="p-input" required>
                            </div>
                            <div class="p-hint">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 16v-4m0-4h.01"/>
                                </svg>
                                Email can't be changed for security reasons
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="p-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection