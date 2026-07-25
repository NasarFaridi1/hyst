@extends('layouts.app')

@section('content')

<style>
    :root {
        --cream:     #F6F1E8;
        --cream2:    #EDE5D4;
        --cream3:    #E0D5C0;
        --terra:     #C25A2A;
        --terra-l:   #D97040;
        --terra-d:   #8C3D1A;
        --terra-bg:  rgba(194,90,42,0.08);
        --terra-bg2: rgba(194,90,42,0.14);
        --ink:       #1A1208;
        --ink2:      #2E2318;
        --muted:     #8A7A62;
        --muted2:    #6B5C46;
        --green:     #3D8C5A;
        --green-bg:  rgba(61,140,90,0.1);
        --red:       #C23A2A;
        --red-bg:    rgba(194,58,42,0.08);
        --blue:      #2A6CC2;
        --blue-bg:   rgba(42,108,194,0.08);
        --border:    rgba(194,90,42,0.12);
        --border2:   rgba(194,90,42,0.22);
        --shadow:    0 2px 16px rgba(26,18,8,0.08);
        --shadow2:   0 8px 32px rgba(26,18,8,0.12);
        --ease:      cubic-bezier(0.16,1,0.3,1);
    }

    .amb-wrap * { box-sizing: border-box; }

    .amb-wrap {
        background: var(--cream);
        min-height: 100%;
        padding: 32px 8px;
        border-radius: 18px;
    }

    .amb-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 14px;
    }

    .amb-header h2 {
        color: var(--ink);
        font-weight: 700;
        margin-bottom: 2px;
        letter-spacing: -0.02em;
        font-size: 1.4rem;
    }

    .amb-header p {
        color: var(--muted2);
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .btn-terra {
        background: var(--terra);
        border: 1px solid var(--terra);
        color: #fff;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        transition: background .2s var(--ease), transform .2s var(--ease), box-shadow .2s var(--ease);
        box-shadow: var(--shadow);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-terra:hover {
        background: var(--terra-l);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: var(--shadow2);
    }

    .btn-terra svg{ width:16px; height:16px; }

    .amb-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: var(--shadow);
    }

    .amb-card-body {
        padding: 28px;
    }

    .amb-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--cream3);
        box-shadow: var(--shadow);
    }

    .amb-name {
        color: var(--ink);
        font-weight: 700;
        margin-top: 16px;
        margin-bottom: 2px;
    }

    .amb-role-badge {
        display: inline-block;
        background: var(--terra-bg);
        color: var(--terra-d);
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 999px;
        margin-bottom: 4px;
    }

    .amb-divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 20px 0;
    }

    .amb-info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 0.95rem;
        color: var(--ink2);
        border-bottom: 1px dashed var(--border);
    }

    .amb-info-row:last-child {
        border-bottom: none;
    }

    .amb-info-row strong {
        color: var(--muted2);
        font-weight: 600;
    }

    .amb-stat-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        box-shadow: var(--shadow);
        padding: 20px 22px;
        height: 100%;
        transition: transform .2s var(--ease), box-shadow .2s var(--ease);
    }

    .amb-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow2);
    }

    .amb-stat-label {
        color: var(--muted2);
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .amb-stat-value {
        font-weight: 700;
        font-size: 2rem;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .amb-stat-total   .amb-stat-value { color: var(--terra); }
    .amb-stat-active  .amb-stat-value { color: var(--green); }
    .amb-stat-pending .amb-stat-value { color: #B8862B; }

    .amb-stat-earn {
        background: linear-gradient(135deg, var(--terra) 0%, var(--terra-d) 100%);
        color: #fff;
        border: none;
    }

    .amb-stat-earn .amb-stat-label { color: rgba(255,255,255,0.85); }
    .amb-stat-earn .amb-stat-value { color: #fff; }
    .amb-stat-earn small { color: rgba(255,255,255,0.75); }

    .amb-program-card {
        background: var(--terra-bg);
        border: 1px solid var(--border2);
        border-radius: 14px;
        margin-top: 16px;
        overflow: hidden;
    }

    .amb-program-header {
        background: transparent;
        border-bottom: 1px solid var(--border2);
        padding: 16px 22px;
    }

    .amb-program-header h5 {
        color: var(--terra-d);
        font-weight: 700;
        margin-bottom: 0;
    }

    .amb-program-body {
        padding: 18px 22px;
    }

    .amb-program-body ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .amb-program-body li {
        position: relative;
        padding-left: 22px;
        color: var(--ink2);
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .amb-program-body li:last-child {
        margin-bottom: 0;
    }

    .amb-program-body li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 8px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--terra);
    }

    .amb-program-body strong {
        color: var(--terra-d);
    }

    .text-earn {
        color: var(--green);
    }
</style>

<div class="amb-wrap">

    <div class="amb-header">
        <div>
            <h2>My Profile</h2>
            <p>Ambassador Profile &amp; Earnings</p>
        </div>

        <a href="{{ route('ambassador.profile.edit') }}" class="btn-terra">
            <i data-lucide="pencil"></i>
            Edit Profile
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Profile Card -->
        <div class="lg:col-span-4">
            <div class="amb-card">
                <div class="amb-card-body text-center">

                    @if($user->profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" class="amb-avatar mx-auto">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150&background=C25A2A&color=fff" class="amb-avatar mx-auto">
                    @endif

                    <h4 class="amb-name">{{ $user->name }}</h4>
                    <span class="amb-role-badge">Ambassador</span>

                    <hr class="amb-divider">

                    <div class="text-left">
                        <div class="amb-info-row">
                            <span><strong>Email</strong></span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="amb-info-row">
                            <span><strong>Phone</strong></span>
                            <span>{{ $user->phone ?? 'N/A' }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="lg:col-span-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="amb-stat-card amb-stat-total">
                    <div class="amb-stat-label">Total Restaurants</div>
                    <p class="amb-stat-value">{{ $totalRestaurants }}</p>
                </div>

                <div class="amb-stat-card amb-stat-active">
                    <div class="amb-stat-label">Active Restaurants</div>
                    <p class="amb-stat-value">{{ $activeRestaurants }}</p>
                </div>

                <div class="amb-stat-card amb-stat-pending">
                    <div class="amb-stat-label">Pending Restaurants</div>
                    <p class="amb-stat-value">{{ $pendingRestaurants }}</p>
                </div>

                <div class="amb-stat-card amb-stat-earn">
                    <div class="amb-stat-label">Restaurant Earnings</div>
                    <p class="amb-stat-value">£{{ number_format($restaurantEarnings,2) }}</p>
                    <small>£100 &times; {{ $totalRestaurants }} Restaurants</small>
                </div>

            </div>

            <div class="amb-program-card">
                <div class="amb-program-header">
                    <h5>HYST Ambassador Programme</h5>
                </div>
                <div class="amb-program-body">
                    <ul>
                        <li>Earn <strong>£100</strong> for every Restaurant you onboard.</li>
                        <li>Restaurants Created: <strong>{{ $totalRestaurants }}</strong></li>
                        <li>Current Earnings: <strong class="text-earn">£{{ number_format($restaurantEarnings,2) }}</strong></li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    if (window.lucide) { lucide.createIcons(); }
</script>

@endsection