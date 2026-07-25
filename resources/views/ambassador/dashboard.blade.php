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
        --gold:      #B8862B;
        --gold-bg:   rgba(184,134,43,0.1);
        --border:    rgba(194,90,42,0.12);
        --border2:   rgba(194,90,42,0.22);
        --shadow:    0 2px 16px rgba(26,18,8,0.08);
        --shadow2:   0 8px 32px rgba(26,18,8,0.12);
        --ease:      cubic-bezier(0.16,1,0.3,1);
    }

    .dash-wrap * { box-sizing: border-box; }

    .dash-wrap{
        background: var(--cream);
    }

    /* Header */
    .dashboard-header{
        background:#fff;
        border:1px solid var(--border);
        border-radius:16px;
        padding:26px 28px;
        margin-bottom:26px;
        box-shadow: var(--shadow);
    }

    .dashboard-header h2{
        font-weight:700;
        color: var(--ink);
        letter-spacing: -0.02em;
        margin-bottom: 2px;
        font-size: 1.5rem;
    }

    .dashboard-header p{
        margin:0;
        color: var(--muted2);
    }

    .btn-primary{
        background: var(--terra);
        border:1px solid var(--terra);
        border-radius:10px;
        padding:11px 22px;
        font-weight:600;
        color:#fff;
        box-shadow: var(--shadow);
        transition: background .2s var(--ease), transform .2s var(--ease), box-shadow .2s var(--ease);
        display:inline-flex;
        align-items:center;
        text-decoration:none;
    }

    .btn-primary:hover{
        background: var(--terra-l);
        border-color: var(--terra-l);
        color:#fff;
        transform: translateY(-1px);
        box-shadow: var(--shadow2);
    }

    /* Stat cards */
    .stats-card{
        border: 1px solid var(--border);
        border-radius:16px;
        overflow:hidden;
        transition: transform .25s var(--ease), box-shadow .25s var(--ease), border-color .25s var(--ease);
        box-shadow: var(--shadow);
        background:#fff;
    }

    .stats-card:hover{
        transform:translateY(-5px);
        box-shadow: var(--shadow2);
        border-color: var(--border2);
    }

    .stats-card .card-body{
        padding:22px;
    }

    .stats-card small{
        font-size:13px;
        font-weight:600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--muted2);
    }

    .stats-card h2{
        font-size:30px;
        font-weight:700;
        margin-top:8px;
        margin-bottom:0;
        color: var(--ink);
    }

    .stats-card h2.text-success{ color: var(--green) !important; }
    .stats-card h2.text-warning{ color: var(--gold) !important; }
    .stats-card h2.text-info{ color: var(--blue) !important; }
    .stats-card h2.text-danger{ color: var(--terra) !important; }

    /* Icons */
    .icon-box{
        width:60px !important;
        height:60px !important;
        min-width:60px !important;
        border-radius:16px !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        flex-shrink:0;
        padding:0 !important;
    }

    .icon-box svg{
        width:26px;
        height:26px;
    }

    .icon-box.bg-primary{ background: var(--terra-bg) !important; color: var(--terra) !important; }
    .icon-box.bg-success{ background: var(--green-bg) !important; color: var(--green) !important; }
    .icon-box.bg-warning{ background: var(--gold-bg) !important; color: var(--gold) !important; }
    .icon-box.bg-info{ background: var(--blue-bg) !important; color: var(--blue) !important; }
    .icon-box.bg-danger{ background: var(--terra-bg2) !important; color: var(--terra-d) !important; }

    /* Quick Action Card */
    .action-card{
        border: 1px solid var(--border);
        border-radius:16px;
        overflow:hidden;
        box-shadow: var(--shadow);
        background:#fff;
    }

    .action-card .card-header{
        background:#fff;
        border-bottom:1px solid var(--border);
        font-weight:700;
        color: var(--ink);
        padding: 16px 22px;
    }

    .action-card .card-body{
        padding: 22px;
    }

    .quick-btn{
        display:flex !important;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:10px;
        text-align:center;
        border-radius:14px;
        font-weight:600;
        transition: transform .25s var(--ease), background .25s var(--ease), box-shadow .25s var(--ease);
        padding:26px 14px;
        font-size:16px;
        border:1.5px solid transparent;
        line-height:1.2;
        text-decoration:none;
    }

    .quick-btn svg{
        width:28px;
        height:28px;
    }

    .quick-btn:hover{
        transform:translateY(-4px);
        box-shadow: var(--shadow);
    }

    .btn-outline-primary{
        color: var(--terra-d);
        border-color: var(--border2);
        background:#fff;
    }

    .btn-outline-primary:hover{
        background: var(--terra-bg);
        border-color: var(--terra);
        color: var(--terra-d);
    }

    .btn-outline-success{
        color: var(--green);
        border-color: rgba(61,140,90,0.35);
        background:#fff;
    }

    .btn-outline-success:hover{
        background: var(--green-bg);
        border-color: var(--green);
        color: var(--green);
    }

    @media(max-width:768px){
        .dashboard-header{ text-align:center; }
        .dashboard-header .btn-primary{ margin-top:15px; }
    }
</style>

<div class="dash-wrap">

    <div class="dashboard-header flex justify-between items-center flex-wrap">
        <div>
            <h2>Ambassador Dashboard</h2>
            <p>Welcome back! Here's your restaurant overview.</p>
        </div>

        <a href="{{ route('ambassador.restaurants.create') }}" class="btn-primary">
            <i data-lucide="plus" style="width:16px;height:16px;margin-right:8px;"></i>
            Add Restaurant
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 mb-6">

        <div class="stats-card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <small>Total Restaurants</small>
                    <h2>{{ $totalRestaurants }}</h2>
                </div>
                <div class="icon-box bg-primary">
                    <i data-lucide="utensils"></i>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <small>Active Restaurants</small>
                    <h2 class="text-success">{{ $activeRestaurants }}</h2>
                </div>
                <div class="icon-box bg-success">
                    <i data-lucide="circle-check"></i>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <small>Pending Restaurants</small>
                    <h2 class="text-warning">{{ $pendingRestaurants }}</h2>
                </div>
                <div class="icon-box bg-warning">
                    <i data-lucide="hourglass"></i>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <small>Categories</small>
                    <h2 class="text-info">{{ $totalCategories }}</h2>
                </div>
                <div class="icon-box bg-info">
                    <i data-lucide="folder"></i>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <small>Products</small>
                    <h2 class="text-danger">{{ $totalProducts }}</h2>
                </div>
                <div class="icon-box bg-danger">
                    <i data-lucide="shopping-cart"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="action-card">
        <div class="card-header">
            Quick Actions
        </div>

        <div class="card-body">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <a href="{{ route('ambassador.restaurants.index') }}" class="btn-outline-primary quick-btn">
                    <i data-lucide="utensils"></i>
                    <span>My Restaurants</span>
                </a>

                <a href="{{ route('ambassador.restaurants.create') }}" class="btn-outline-success quick-btn">
                    <i data-lucide="circle-plus"></i>
                    <span>Add Restaurant</span>
                </a>

            </div>
        </div>
    </div>

</div>

<script>
    if (window.lucide) { lucide.createIcons(); }
</script>

@endsection