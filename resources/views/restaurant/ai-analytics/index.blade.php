@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<style>
    :root {
      --cream:     #F6F1E8;
      --cream2:    #EDE5D4;
      --cream3:    #E0D5C0;
      --terra:     #C25A2A;
      --terra-l:   #D97040;
      --terra-d:   #8C3D1A;
      --terra-bg:  rgba(194,90,42,0.10);
      --ink:       #1A1208;
      --ink2:      #2E2318;
      --muted:     #8A7A62;
      --green:     #15803D;
      --green-bg:  #DCFCE7;
      --amber:     #B45309;
      --amber-bg:  #FEF3C7;
      --red:       #B91C1C;
      --red-bg:    #FEE2E2;
      --blue:      #1D4ED8;
      --blue-bg:   #DBEAFE;
      --border:    rgba(194,90,42,0.15);
      --shadow:    0 4px 20px rgba(26,18,8,0.06);
      --shadow-lg: 0 12px 32px rgba(26,18,8,0.12);
    }

    /* ── Main Page Wrapper ── */
    .ai-page {
      padding: 28px 32px;
      background: var(--cream);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      color: var(--ink);
      max-width: 1600px;
      margin: 0 auto;
    }

    /* ── Header ── */
    .ai-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 24px;
    }

    .ai-eyebrow {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--terra);
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--terra-bg);
      padding: 5px 12px;
      border-radius: 999px;
    }

    .ai-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(24px, 3.5vw, 34px);
      font-weight: 700;
      color: var(--ink);
      margin: 8px 0 4px;
      line-height: 1.2;
    }

    .ai-title span {
      color: var(--terra);
    }

    .ai-subtitle {
      font-size: 13.5px;
      color: var(--muted);
      margin: 0;
    }

    .ai-header-actions {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn-ai-outline {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 10px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      color: var(--ink2);
      background: #fff;
      border: 1px solid var(--border);
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-ai-outline:hover {
      background: var(--cream2);
    }

    .btn-ai-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 10px 18px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      color: #fff;
      background: var(--terra);
      border: 1px solid var(--terra);
      text-decoration: none;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(194,90,42,0.28);
      transition: all 0.2s ease;
    }

    .btn-ai-primary:hover {
      background: var(--terra-l);
      transform: translateY(-1px);
    }

    /* ── Hero Banner (Step 26) ── */
    .opportunity-hero {
      background: linear-gradient(135deg, #2E2318 0%, #1A1208 100%);
      color: #fff;
      border-radius: 20px;
      padding: 28px;
      margin-bottom: 24px;
      box-shadow: var(--shadow-lg);
      position: relative;
      overflow: hidden;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
      border: 1px solid rgba(194,90,42,0.3);
    }

    .opportunity-hero::after {
      content: '🧠';
      position: absolute;
      right: 20px;
      bottom: -15px;
      font-size: 100px;
      opacity: 0.07;
      pointer-events: none;
    }

    .hero-eyebrow {
      font-size: 11.5px;
      font-weight: 700;
      letter-spacing: 0.1em;
      color: #E0D5C0;
      text-transform: uppercase;
      display: block;
    }

    .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(22px, 4vw, 36px);
      margin: 6px 0 10px;
      font-weight: 700;
      line-height: 1.2;
    }

    .hero-desc {
      color: #C5BDB0;
      font-size: 13.5px;
      margin: 0;
      max-width: 680px;
      line-height: 1.5;
    }

    .flywheel-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(74,222,128,0.16);
      border: 1px solid rgba(74,222,128,0.35);
      color: #4ADE80;
      font-size: 13px;
      font-weight: 600;
      padding: 9px 16px;
      border-radius: 999px;
      white-space: nowrap;
    }

    /* ── 4 Metric Cards Grid ── */
    .metric-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .metric-box {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 20px;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .metric-box .label {
      font-size: 11.5px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .metric-box .value {
      font-size: clamp(22px, 3vw, 30px);
      font-weight: 700;
      margin: 8px 0 4px;
      font-family: 'Playfair Display', serif;
      line-height: 1.1;
    }

    .metric-box .sub {
      font-size: 12.5px;
      color: var(--muted);
    }

    /* ── White Section Card ── */
    .ai-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 24px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
    }

    .ai-card-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 18px;
    }

    .ai-card-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(19px, 2.5vw, 24px);
      margin: 0 0 4px;
      font-weight: 700;
      color: var(--ink);
    }

    .ai-card-sub {
      font-size: 13px;
      color: var(--muted);
      margin: 0;
    }

    /* ── Next Best Action Grid ── */
    .actions-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }

    .action-card {
      border: 1px solid var(--border);
      border-radius: 16px;
      background: var(--cream);
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .action-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow);
    }

    .action-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
      margin-bottom: 10px;
    }

    .ai-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 10.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .badge-priority { background: var(--red-bg); color: var(--red); }
    .badge-value    { background: var(--amber-bg); color: var(--amber); }
    .badge-upsell   { background: var(--green-bg); color: var(--green); }
    .badge-neutral  { background: #E5E7EB; color: #374151; }

    .action-customer {
      font-size: 17px;
      font-weight: 700;
      color: var(--ink);
      margin: 0 0 4px;
    }

    .action-headline {
      font-size: 12.5px;
      color: var(--muted);
      margin: 0 0 12px;
      line-height: 1.4;
    }

    .action-rec-box {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px;
      font-size: 12.5px;
      margin-bottom: 16px;
    }

    /* ── Lifecycle Funnel Grid ── */
    .funnel-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 10px;
      margin-top: 14px;
    }

    .funnel-segment {
      padding: 14px 10px;
      text-align: center;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: var(--cream);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .funnel-segment .f-label {
      font-size: 10.5px;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 4px;
      letter-spacing: 0.04em;
    }

    .funnel-segment .f-num {
      font-size: 20px;
      font-weight: 700;
      color: var(--ink);
      line-height: 1.1;
    }

    /* ── Filter Pills ── */
    .filters-bar {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      align-items: center;
    }

    .filter-pill {
      padding: 8px 14px;
      border-radius: 10px;
      font-size: 12.5px;
      font-weight: 600;
      text-decoration: none;
      color: var(--muted);
      background: var(--cream);
      border: 1px solid var(--border);
      transition: all 0.2s ease;
      white-space: nowrap;
    }

    .filter-pill:hover {
      background: var(--cream2);
      color: var(--ink);
    }

    .filter-pill.active {
      background: var(--terra);
      color: #fff;
      border-color: var(--terra);
      box-shadow: 0 4px 12px rgba(194,90,42,0.28);
    }

    /* ── Desktop Table & Mobile Cards ── */
    .table-scroll-wrap {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .twin-table {
      width: 100%;
      border-collapse: collapse;
      min-width: 820px;
    }

    .twin-table th {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.07em;
      color: var(--muted);
      background: #FAFAFA;
      padding: 13px 12px;
      text-align: left;
      border-bottom: 2px solid var(--border);
    }

    .twin-table td {
      padding: 14px 12px;
      vertical-align: middle;
      font-size: 13px;
      border-bottom: 1px solid var(--border);
    }

    .twin-table tr:hover td {
      background: rgba(246, 241, 232, 0.45);
    }

    .score-badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 700;
      margin: 2px 2px 2px 0;
    }

    .score-high { background: var(--green-bg); color: var(--green); }
    .score-mid  { background: var(--amber-bg); color: var(--amber); }
    .score-low  { background: var(--red-bg); color: var(--red); }

    /* Mobile Twin Cards (Hidden on Desktop, Shown on < 768px) */
    .mobile-twins-list {
      display: none;
      flex-direction: column;
      gap: 12px;
    }

    .mobile-twin-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px;
    }

    .mobile-twin-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px;
      margin: 10px 0;
      font-size: 12px;
    }

    /* ── Custom Modals (Zero Bootstrap Dependency) ── */
    .ai-modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(26, 18, 8, 0.65);
      backdrop-filter: blur(3px);
      z-index: 99999;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 16px;
      overflow-y: auto;
    }

    .ai-modal-backdrop.open {
      display: flex;
    }

    .ai-modal-box {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 20px;
      width: 100%;
      max-width: 540px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 50px rgba(0,0,0,0.25);
      animation: modalFadeIn 0.2s ease-out;
    }

    .ai-modal-box.modal-lg {
      max-width: 720px;
    }

    @keyframes modalFadeIn {
      from { opacity: 0; transform: translateY(12px) scale(0.98); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .ai-modal-header {
      padding: 18px 22px;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
    }

    .ai-modal-close {
      background: rgba(0,0,0,0.08);
      border: none;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: inherit;
      flex-shrink: 0;
    }

    .ai-modal-body {
      padding: 22px;
    }

    .ai-modal-footer {
      padding: 16px 22px;
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      flex-wrap: wrap;
    }

    .twin-stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 18px;
    }

    .twin-stat-item {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 14px;
    }

    .twin-patterns-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      font-size: 13px;
    }

    .twin-scores-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 8px;
      text-align: center;
    }

    /* ── Responsive Breakpoints ── */
    @media (max-width: 1100px) {
      .metric-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .actions-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .funnel-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    @media (max-width: 768px) {
      .ai-page {
        padding: 18px 14px;
      }
      .ai-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .ai-header-actions {
        width: 100%;
      }
      .ai-header-actions > * {
        flex: 1;
      }
      .opportunity-hero {
        padding: 20px 18px;
      }
      .ai-card {
        padding: 18px 15px;
      }
      .actions-grid {
        grid-template-columns: 1fr;
      }
      .funnel-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      /* Switch from wide table to clean mobile cards on < 768px */
      .desktop-table-view {
        display: none;
      }
      .mobile-twins-list {
        display: flex;
      }
      .filters-bar {
        flex-wrap: nowrap;
        overflow-x: auto;
        width: 100%;
        padding-bottom: 6px;
        -webkit-overflow-scrolling: touch;
      }
      .twin-stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .twin-patterns-grid {
        grid-template-columns: 1fr;
      }
      .twin-scores-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 480px) {
      .metric-grid {
        grid-template-columns: 1fr;
        gap: 12px;
      }
      .metric-box {
        padding: 16px;
      }
      .ai-modal-body {
        padding: 16px;
      }
      .ai-modal-header, .ai-modal-footer {
        padding: 14px 16px;
      }
      .ai-modal-footer > button {
        width: 100%;
      }
    }
</style>

<div class="ai-page">

  {{-- Page Header --}}
  <div class="ai-header">
    <div>
      <div class="ai-eyebrow">
        <span>✨</span> HYST AI CUSTOMER GROWTH ENGINE
      </div>
      <h1 class="ai-title">{{ $restaurant->name ?? 'Restaurant' }} <span>AI Analytics</span></h1>
      <p class="ai-subtitle">
        Real-time intelligence connecting Orders → Patterns → Predictions → Next Best Actions.
      </p>
    </div>
    <div class="ai-header-actions">
      <a href="{{ url('/restaurant/dashboard') }}" class="btn-ai-outline">
        ← Back to Dashboard
      </a>
      <button onclick="window.location.reload();" class="btn-ai-primary">
        ↻ Refresh AI Insights
      </button>
    </div>
  </div>

  {{-- STEP 26 & STEP 6: REVENUE OPPORTUNITY & MARGIN PROTECTION HERO --}}
  <div class="opportunity-hero">
    <div style="z-index: 1;">
      <span class="hero-eyebrow">
        💰 STEP 26 & STEP 6 — REVENUE OPPORTUNITY & MARGIN PROTECTION
      </span>
      <h2 class="hero-title">
        Potential Opportunity Today: <span style="color:#4ADE80;">£{{ number_format($totalPotentialToday, 2) }}</span>
      </h2>
      <p class="hero-desc">
        HYST AI evaluates the 7 Opportunity Scores and protects food margins: <strong>£{{ number_format($totalMarginProtected, 2) }} in profit saved</strong> by replacing blanket discounts with intelligent habit triggers and value-adds.
      </p>
    </div>
    <div style="z-index: 1; display:flex; flex-direction:column; gap:8px; align-items:flex-end;">
      <span class="flywheel-pill">
        🟢 Active Growth Flywheel
      </span>
      <span style="background:rgba(217,119,6,0.2); border:1px solid rgba(217,119,6,0.4); color:#FDE68A; font-size:12px; font-weight:600; padding:6px 12px; border-radius:999px;">
        🛡️ £{{ number_format($totalMarginProtected, 2) }} Margin Protected
      </span>
    </div>
  </div>

  {{-- 4 Metric Cards --}}
  <div class="metric-grid">
    <div class="metric-box">
      <div class="label">🟢 Ready to Reorder</div>
      <div class="value" style="color:var(--green);">
        {{ $reorderReadyCount }} <span style="font-size:14px; color:var(--muted); font-family:'Poppins',sans-serif; font-weight:500;">Customers</span>
      </div>
      <div class="sub">Potential: <strong style="color:var(--ink);">£{{ number_format($reorderReadyPotential, 2) }}</strong> (Margin Safe)</div>
    </div>

    <div class="metric-box">
      <div class="label">⚠️ At Risk (Churn Warning)</div>
      <div class="value" style="color:#D97706;">
        {{ $atRiskCount }} <span style="font-size:14px; color:var(--muted); font-family:'Poppins',sans-serif; font-weight:500;">Customers</span>
      </div>
      <div class="sub">Potential: <strong style="color:var(--ink);">£{{ number_format($atRiskPotential, 2) }}</strong> (Winback)</div>
    </div>

    <div class="metric-box">
      <div class="label">⭐ VIP Inactive</div>
      <div class="value" style="color:var(--terra);">
        {{ $vipInactiveCount }} <span style="font-size:14px; color:var(--muted); font-family:'Poppins',sans-serif; font-weight:500;">Customers</span>
      </div>
      <div class="sub">Strategy: <strong style="color:var(--ink);">Free Treat (Value-Add)</strong></div>
    </div>

    <div class="metric-box">
      <div class="label">🛡️ Margin Protected (Step 6)</div>
      <div class="value" style="color:#2563EB;">
        £{{ number_format($totalMarginProtected, 2) }}
      </div>
      <div class="sub">Pure Profit: <strong style="color:var(--green);">Saved vs Discounts</strong></div>
    </div>
  </div>

  {{-- STEP 4 & 25: NEXT BEST ACTION (WHO TO CONTACT TODAY) --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🤖 Next Best Action — Who should you contact today?
        </h4>
        <p class="ai-card-sub">High-conviction recommendations drafted by HYST AI to protect margin and drive repeat orders.</p>
      </div>
      <span style="background:var(--terra-bg); color:var(--terra); padding:6px 14px; border-radius:999px; font-weight:700; font-size:12px; white-space:nowrap;">
        {{ count($nextBestActions) }} Priority Actions
      </span>
    </div>

    <div class="actions-grid">
      @forelse($nextBestActions as $idx => $act)
        @php
          $badgeType = 'badge-priority';
          if (str_contains($act['category'], 'VALUE')) $badgeType = 'badge-value';
          elseif (str_contains($act['category'], 'UPSELL')) $badgeType = 'badge-upsell';
        @endphp
        <div class="action-card">
          <div>
            <div class="action-top">
              <span class="ai-badge {{ $badgeType }}">
                {{ $act['category'] }}
              </span>
              <div style="text-align:right;">
                <span style="font-weight:700; color:var(--green); font-size:14px; display:block;">
                  +£{{ number_format($act['potential'], 2) }}
                </span>
                @if(!empty($act['margin_saved']) && $act['margin_saved'] > 0)
                  <span style="font-size:11px; color:#2563EB; font-weight:700;">
                    🛡️ £{{ number_format($act['margin_saved'], 2) }} saved
                  </span>
                @endif
              </div>
            </div>
            <h5 class="action-customer">{{ $act['customer'] }}</h5>
            <p class="action-headline">{{ $act['headline'] }}</p>

            <div style="margin-bottom:8px;">
              <span class="ai-badge" style="background:#EDE5D4; color:#6B5C46; font-size:11px;">
                {{ $act['incentive_badge'] ?? '🛡️ 0% Discount' }}
              </span>
            </div>

            <div class="action-rec-box">
              <div style="font-weight:700; color:var(--terra); margin-bottom:4px;">💡 AI Recommendation:</div>
              <div style="color:var(--ink2); line-height:1.4;">{{ $act['recommendation'] }}</div>
            </div>
          </div>

          <button type="button" class="btn-ai-primary" style="width:100%;"
                  onclick="openActionModal('{{ addslashes($act['customer']) }}', '{{ addslashes($act['action_label']) }}', '{{ addslashes($act['suggested_copy']) }}', '{{ addslashes($act['incentive_badge'] ?? '') }}')">
            {{ $act['action_label'] }} ➔
          </button>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align:center; padding: 32px 16px; color:var(--muted);">
          No urgent actions required today. All customers are in healthy order cycles!
        </div>
      @endforelse
    </div>
  </div>

  {{-- STEP 12 & 15: CUSTOMER RELATIONSHIP FUNNEL --}}
  <div class="ai-card">
    <div class="ai-card-header" style="margin-bottom:8px;">
      <div>
        <h4 class="ai-card-title">
          📊 Customer Relationship Lifecycle Funnel
        </h4>
        <p class="ai-card-sub">Tracking customer progression through the 1 → 2 order engine to Regular, Loyal, and VIP status.</p>
      </div>
      <span style="font-size:12.5px; color:var(--muted); font-weight:600;">
        Active Base: {{ count($digitalTwins) }} Customers
      </span>
    </div>

    <div class="funnel-grid">
      <div class="funnel-segment">
        <span class="f-label">NEW</span>
        <span class="f-num">{{ $funnel['new'] }}</span>
      </div>
      <div class="funnel-segment" style="background:var(--amber-bg); border-color:#FCD34D;">
        <span class="f-label" style="color:var(--amber);">1 → 2 ORDER</span>
        <span class="f-num" style="color:var(--amber);">{{ $funnel['second_order'] }}</span>
      </div>
      <div class="funnel-segment">
        <span class="f-label">REGULAR</span>
        <span class="f-num">{{ $funnel['regular'] }}</span>
      </div>
      <div class="funnel-segment">
        <span class="f-label">LOYAL</span>
        <span class="f-num">{{ $funnel['loyal'] }}</span>
      </div>
      <div class="funnel-segment" style="background:var(--green-bg); border-color:#86EFAC;">
        <span class="f-label" style="color:var(--green);">VIP</span>
        <span class="f-num" style="color:var(--green);">{{ $funnel['vip'] }}</span>
      </div>
      <div class="funnel-segment" style="background:var(--red-bg); border-color:#FCA5A5;">
        <span class="f-label" style="color:var(--red);">AT RISK</span>
        <span class="f-num" style="color:var(--red);">{{ $funnel['at_risk'] }}</span>
      </div>
      <div class="funnel-segment">
        <span class="f-label">DORMANT</span>
        <span class="f-num" style="color:var(--muted);">{{ $funnel['dormant'] }}</span>
      </div>
    </div>
  </div>

  {{-- STEP 1, 2 & 5: CUSTOMER DIGITAL TWINS & 7 OPPORTUNITY SCORES --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🧬 Customer Digital Twin Explorer
        </h4>
        <p class="ai-card-sub">Don't just store what they bought — store habits, reorder windows, and the 7 Opportunity Scores.</p>
      </div>

      {{-- Filters --}}
      <div class="filters-bar">
        <a href="{{ url('/restaurant/ai-analytics?filter=all') }}" class="filter-pill {{ $filter == 'all' ? 'active' : '' }}">All ({{ count($digitalTwins) }})</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=reorder_ready') }}" class="filter-pill {{ $filter == 'reorder_ready' ? 'active' : '' }}">🟢 Reorder Ready</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=margin_safe') }}" class="filter-pill {{ $filter == 'margin_safe' ? 'active' : '' }}">🛡️ Margin Safe (0% Disc)</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=at_risk') }}" class="filter-pill {{ $filter == 'at_risk' ? 'active' : '' }}">⚠️ At Risk</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=vip') }}" class="filter-pill {{ $filter == 'vip' ? 'active' : '' }}">⭐ VIP</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=dormant') }}" class="filter-pill {{ $filter == 'dormant' ? 'active' : '' }}">💤 Dormant</a>
      </div>
    </div>

    {{-- Desktop / Tablet Data Table View --}}
    <div class="table-scroll-wrap desktop-table-view">
      <table class="twin-table">
        <thead>
          <tr>
            <th>CUSTOMER</th>
            <th>ORDERS & BASKET</th>
            <th>FAVOURITE HABIT</th>
            <th>THE 7 AI SCORES (STEP 5)</th>
            <th>INCENTIVE POLICY (STEP 6)</th>
            <th>STATUS</th>
            <th style="text-align:right;">ACTION</th>
          </tr>
        </thead>
        <tbody>
          @forelse($filteredTwins as $t)
            <tr>
              <td>
                <div style="font-weight:700; color:var(--ink);">{{ $t['name'] }}</div>
                <div style="font-size:11.5px; color:var(--muted);">{{ $t['phone'] ?: $t['email'] }}</div>
              </td>
              <td>
                <div><strong>{{ $t['orders_count'] }}</strong> orders</div>
                <div style="font-size:11.5px; color:var(--muted);">AOV: £{{ number_format($t['average_order_value'], 2) }}</div>
              </td>
              <td>
                <div style="font-weight:600; color:var(--terra);">{{ $t['favourite_food'] }}</div>
                <div style="font-size:11.5px; color:var(--muted);">{{ $t['typical_day'] }} ({{ $t['typical_time'] }})</div>
              </td>
              <td>
                <div>
                  <span class="score-badge {{ $t['scores']['reorder'] >= 75 ? 'score-high' : 'score-mid' }}">
                    Reorder: {{ $t['scores']['reorder'] }}%
                  </span>
                  <span class="score-badge {{ $t['scores']['churn'] >= 70 ? 'score-low' : 'score-high' }}">
                    Churn: {{ $t['scores']['churn'] }}%
                  </span>
                  <span class="score-badge {{ $t['scores']['vip'] >= 75 ? 'score-high' : 'score-mid' }}">
                    VIP: {{ $t['scores']['vip'] }}%
                  </span>
                  <span class="score-badge score-mid">
                    Sens: {{ $t['scores']['offer_sensitivity'] }}%
                  </span>
                </div>
              </td>
              <td>
                <div style="font-weight:700; font-size:12px; color:var(--ink);">
                  {{ $t['incentive']['badge'] }}
                </div>
                <div style="font-size:11px; color:var(--muted); max-width:210px; line-height:1.3;">
                  {{ $t['incentive']['rationale'] }}
                </div>
              </td>
              <td>
                @php
                  $stClass = 'badge-neutral';
                  if ($t['current_status'] == 'REORDER READY') $stClass = 'badge-upsell';
                  elseif ($t['current_status'] == 'AT RISK') $stClass = 'badge-value';
                  elseif ($t['current_status'] == 'DORMANT') $stClass = 'badge-priority';
                @endphp
                <span class="ai-badge {{ $stClass }}">
                  {{ $t['current_status'] }}
                </span>
              </td>
              <td style="text-align:right;">
                <button type="button" class="btn-ai-outline" style="padding:6px 12px; font-size:12px;"
                        onclick='showDigitalTwinModal(@json($t))'>
                  View Twin 🧬
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="text-align:center; padding:32px; color:var(--muted);">
                No customers match the selected filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Mobile Responsive Card View (< 768px) --}}
    <div class="mobile-twins-list">
      @forelse($filteredTwins as $t)
        @php
          $stClass = 'badge-neutral';
          if ($t['current_status'] == 'REORDER READY') $stClass = 'badge-upsell';
          elseif ($t['current_status'] == 'AT RISK') $stClass = 'badge-value';
          elseif ($t['current_status'] == 'DORMANT') $stClass = 'badge-priority';
        @endphp
        <div class="mobile-twin-card">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
            <div>
              <div style="font-weight:700; font-size:15px; color:var(--ink);">{{ $t['name'] }}</div>
              <div style="font-size:12px; color:var(--muted);">{{ $t['phone'] ?: $t['email'] }}</div>
            </div>
            <span class="ai-badge {{ $stClass }}">{{ $t['current_status'] }}</span>
          </div>

          <div class="mobile-twin-grid">
            <div>
              <span style="color:var(--muted); display:block; font-size:10.5px;">ORDERS & AOV</span>
              <strong>{{ $t['orders_count'] }} orders</strong> (£{{ number_format($t['average_order_value'], 2) }})
            </div>
            <div>
              <span style="color:var(--muted); display:block; font-size:10.5px;">FAVOURITE DISH</span>
              <strong style="color:var(--terra);">{{ $t['favourite_food'] }}</strong>
            </div>
            <div>
              <span style="color:var(--muted); display:block; font-size:10.5px;">TYPICAL HABIT</span>
              <strong>{{ $t['typical_day'] }}</strong> ({{ $t['typical_time'] }})
            </div>
            <div>
              <span style="color:var(--muted); display:block; font-size:10.5px;">INCENTIVE POLICY</span>
              <strong style="color:#2563EB;">{{ $t['incentive']['badge'] }}</strong>
            </div>
          </div>

          <div style="font-size:11.5px; color:var(--muted); background:#fff; padding:8px 10px; border-radius:8px; margin-bottom:10px; border:1px solid var(--border);">
            💡 <em>{{ $t['incentive']['rationale'] }}</em>
          </div>

          <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
            <div>
              <span class="score-badge {{ $t['scores']['reorder'] >= 75 ? 'score-high' : 'score-mid' }}">
                Reorder: {{ $t['scores']['reorder'] }}%
              </span>
              <span class="score-badge {{ $t['scores']['churn'] >= 70 ? 'score-low' : 'score-high' }}">
                Churn: {{ $t['scores']['churn'] }}%
              </span>
            </div>
            <button type="button" class="btn-ai-outline" style="padding:7px 14px; font-size:12px;"
                    onclick='showDigitalTwinModal(@json($t))'>
              View Twin 🧬
            </button>
          </div>
        </div>
      @empty
        <div style="text-align:center; padding:28px 12px; color:var(--muted);">
          No customers match the selected filter.
        </div>
      @endforelse
    </div>

  </div>

</div>

{{-- MODAL 1: ACTION SENDER (PREVIEW & SEND) --}}
<div class="ai-modal-backdrop" id="actionModal" onclick="if(event.target === this) closeActionModal()">
  <div class="ai-modal-box">
    <div class="ai-modal-header" style="background:var(--cream);">
      <h5 id="actionModalTitle" style="font-family:'Playfair Display', serif; font-weight:700; font-size:20px; margin:0;">Create Campaign</h5>
      <button type="button" class="ai-modal-close" onclick="closeActionModal()">✕</button>
    </div>
    <div class="ai-modal-body">
      <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; margin-bottom:4px;">RECIPIENT</div>
      <div id="actionCustomerName" style="font-weight:700; font-size:16px; margin-bottom:12px; color:var(--ink);"></div>

      <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; margin-bottom:4px;">INCENTIVE POLICY (STEP 6)</div>
      <div style="margin-bottom:14px;">
        <span id="actionIncentiveBadge" class="ai-badge" style="background:#EDE5D4; color:#6B5C46; font-size:12px;">🛡️ 0% Discount (Margin Safe)</span>
      </div>

      <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; margin-bottom:6px;">
        PRE-DRAFTED AI MESSAGE (NON-CREEPY & MARGIN SAFE)
      </div>
      <textarea id="actionMessageBody" rows="3" style="width:100%; border:1px solid var(--border); border-radius:12px; padding:12px; font-family:inherit; font-size:13.5px; margin-bottom:14px; outline:none;"></textarea>

      <div style="background:var(--blue-bg); color:var(--blue); padding:12px 14px; border-radius:12px; font-size:12px; line-height:1.45;">
        🔒 <strong>Step 29 Rule Applied:</strong> The AI uses natural convenience reminders instead of creepy stats ("Friday again?" instead of "We know you order every 8.4 days").
      </div>
    </div>
    <div class="ai-modal-footer">
      <button type="button" class="btn-ai-outline" onclick="closeActionModal()">Cancel</button>
      <button type="button" class="btn-ai-primary" onclick="simulateSend()">
        Send via Push & SMS 🚀
      </button>
    </div>
  </div>
</div>

{{-- MODAL 2: FULL CUSTOMER DIGITAL TWIN INSPECTOR (SARAH'S PROFILE) --}}
<div class="ai-modal-backdrop" id="twinModal" onclick="if(event.target === this) closeTwinModal()">
  <div class="ai-modal-box modal-lg">
    <div class="ai-modal-header" style="background:var(--terra); color:#fff; border:none;">
      <div>
        <span style="font-size:10.5px; text-transform:uppercase; letter-spacing:1px; opacity:0.85; display:block;">STEP 2 — CUSTOMER DIGITAL TWIN</span>
        <h4 id="twinName" style="font-weight:700; font-size:20px; margin:2px 0 0; color:#fff;">Customer</h4>
      </div>
      <button type="button" class="ai-modal-close" style="background:rgba(255,255,255,0.2); color:#fff;" onclick="closeTwinModal()">✕</button>
    </div>

    <div class="ai-modal-body" style="background:#FAFAFA;">
      <div class="twin-stats-grid">
        <div class="twin-stat-item">
          <small style="color:var(--muted); font-size:10.5px; font-weight:700; display:block;">ORDERS</small>
          <div style="font-size:20px; font-weight:700; color:var(--ink); margin-top:2px;" id="twinOrders">0</div>
        </div>
        <div class="twin-stat-item">
          <small style="color:var(--muted); font-size:10.5px; font-weight:700; display:block;">AVERAGE BASKET</small>
          <div style="font-size:20px; font-weight:700; color:var(--ink); margin-top:2px;" id="twinAov">£0.00</div>
        </div>
        <div class="twin-stat-item">
          <small style="color:var(--muted); font-size:10.5px; font-weight:700; display:block;">TYPICAL INTERVAL</small>
          <div style="font-size:20px; font-weight:700; color:var(--ink); margin-top:2px;" id="twinInterval">0 days</div>
        </div>
        <div class="twin-stat-item">
          <small style="color:var(--muted); font-size:10.5px; font-weight:700; display:block;">CURRENT STATUS</small>
          <div style="font-size:15px; font-weight:700; color:var(--green); margin-top:5px;" id="twinStatus">REORDER READY</div>
        </div>
      </div>

      {{-- STEP 6: INCENTIVE POLICY & MARGIN PROTECTION --}}
      <div style="background:#fff; border:1px solid var(--border); border-radius:14px; padding:16px; margin-bottom:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
          <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:var(--muted);">
            STEP 6 — MARGIN-PROTECTED INCENTIVE POLICY
          </div>
          <span id="twinMarginSaved" style="font-size:11.5px; font-weight:700; color:#2563EB;"></span>
        </div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
          <strong id="twinIncentiveBadge" class="ai-badge" style="background:#EDE5D4; color:#6B5C46; font-size:12px;"></strong>
        </div>
        <div id="twinIncentiveRationale" style="font-size:12.5px; color:var(--muted); line-height:1.4;"></div>
      </div>

      <div style="background:#fff; border:1px solid var(--border); border-radius:14px; padding:16px; margin-bottom:16px;">
        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:var(--muted); margin-bottom:10px;">
          BEHAVIOURAL PATTERNS & HABITS
        </div>
        <div class="twin-patterns-grid">
          <div><strong>Favourite Dish:</strong> <span id="twinFood" style="color:var(--terra); font-weight:600;"></span></div>
          <div><strong>Typical Day:</strong> <span id="twinDay"></span></div>
          <div><strong>Typical Time:</strong> <span id="twinTime"></span></div>
          <div><strong>Last Order:</strong> <span id="twinLast"></span></div>
          <div><strong>Offer Sensitivity:</strong> <span id="twinSens"></span></div>
          <div><strong>Customer Value:</strong> <span id="twinVal" class="ai-badge badge-neutral"></span></div>
          <div style="grid-column: 1 / -1; margin-top:4px;">
            <strong>Favourite Basket:</strong> <span id="twinBasket" style="color:var(--ink2); font-weight:600;"></span>
          </div>
        </div>
      </div>

      <div style="background:#fff; border:1px solid var(--border); border-radius:14px; padding:16px;">
        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:var(--muted); margin-bottom:10px;">
          THE 7 AI OPPORTUNITY SCORES (STEP 5)
        </div>
        <div class="twin-scores-grid" id="twinScoresRow">
          <!-- Populated via JS -->
        </div>
      </div>
    </div>

    <div class="ai-modal-footer">
      <button type="button" class="btn-ai-outline" onclick="closeTwinModal()">Close Profile</button>
    </div>
  </div>
</div>

<script>
function openActionModal(customer, action, copy, incentive) {
  document.getElementById('actionCustomerName').innerText = customer;
  document.getElementById('actionModalTitle').innerText = action;
  document.getElementById('actionMessageBody').value = copy;
  document.getElementById('actionIncentiveBadge').innerText = incentive || '🛡️ 0% Discount (Margin Safe)';
  document.getElementById('actionModal').classList.add('open');
}

function closeActionModal() {
  document.getElementById('actionModal').classList.remove('open');
}

function simulateSend() {
  closeActionModal();
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      icon: 'success',
      title: 'Campaign Queued!',
      text: 'Your personalised AI message has been dispatched to the customer.',
      confirmButtonColor: '#C25A2A'
    });
  } else {
    alert('Action successfully queued! Campaign sent via Customer Engagement channels.');
  }
}

function showDigitalTwinModal(t) {
  document.getElementById('twinName').innerText = t.name + ' — Digital Twin';
  document.getElementById('twinOrders').innerText = t.orders_count;
  document.getElementById('twinAov').innerText = '£' + Number(t.average_order_value).toFixed(2);
  document.getElementById('twinInterval').innerText = t.typical_interval + ' days';
  document.getElementById('twinStatus').innerText = t.current_status;
  document.getElementById('twinFood').innerText = t.favourite_food;
  document.getElementById('twinDay').innerText = t.typical_day;
  document.getElementById('twinTime').innerText = t.typical_time;
  document.getElementById('twinLast').innerText = t.last_order_days + ' days ago';
  document.getElementById('twinSens').innerText = t.offer_sensitivity;
  document.getElementById('twinVal').innerText = t.customer_value;
  document.getElementById('twinBasket').innerText = t.favourite_basket;

  // Step 6: Incentive Policy & Margin Saved
  if (t.incentive) {
    document.getElementById('twinIncentiveBadge').innerText = t.incentive.badge || '🛡️ 0% Discount';
    document.getElementById('twinIncentiveRationale').innerText = t.incentive.rationale || 'Natural routine buyer';
    document.getElementById('twinMarginSaved').innerText = (t.incentive.margin_saved && t.incentive.margin_saved > 0) 
      ? '🛡️ +£' + Number(t.incentive.margin_saved).toFixed(2) + ' margin protected' 
      : '';
  }

  // Step 5: The 7 AI Opportunity Scores
  const scoresRow = document.getElementById('twinScoresRow');
  scoresRow.innerHTML = `
    <div style="background:var(--cream); padding:10px 6px; border-radius:10px;"><small style="color:var(--muted); display:block; font-size:10.5px;">1. Reorder</small><strong style="font-size:14px;">${t.scores.reorder}%</strong></div>
    <div style="background:var(--cream); padding:10px 6px; border-radius:10px;"><small style="color:var(--muted); display:block; font-size:10.5px;">2. Churn</small><strong style="font-size:14px;">${t.scores.churn}%</strong></div>
    <div style="background:var(--cream); padding:10px 6px; border-radius:10px;"><small style="color:var(--muted); display:block; font-size:10.5px;">3. Upsell</small><strong style="font-size:14px;">${t.scores.upsell}%</strong></div>
    <div style="background:var(--cream); padding:10px 6px; border-radius:10px;"><small style="color:var(--muted); display:block; font-size:10.5px;">4. VIP</small><strong style="font-size:14px;">${t.scores.vip}%</strong></div>
    <div style="background:var(--cream); padding:10px 6px; border-radius:10px;"><small style="color:var(--muted); display:block; font-size:10.5px;">5. Sensitivity</small><strong style="font-size:14px;">${t.scores.offer_sensitivity}%</strong></div>
    <div style="background:var(--cream); padding:10px 6px; border-radius:10px;"><small style="color:var(--muted); display:block; font-size:10.5px;">6. Engage</small><strong style="font-size:14px;">${t.scores.engagement}%</strong></div>
    <div style="background:var(--cream); padding:10px 6px; border-radius:10px;"><small style="color:var(--muted); display:block; font-size:10.5px;">7. Affinity</small><strong style="font-size:14px;">${t.scores.affinity}%</strong></div>
  `;

  document.getElementById('twinModal').classList.add('open');
}

function closeTwinModal() {
  document.getElementById('twinModal').classList.remove('open');
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeActionModal();
    closeTwinModal();
  }
});
</script>

@endsection
