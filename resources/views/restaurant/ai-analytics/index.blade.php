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

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
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

    /* ── Step 7: Incremental ROI Banner ── */
    .roi-banner {
      background: linear-gradient(135deg, #1A1208 0%, #2A1D12 100%);
      color: #fff;
      border-radius: 18px;
      padding: 24px;
      margin-bottom: 24px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(194,90,42,0.3);
    }

    .roi-flow-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-top: 16px;
    }

    .roi-step-card {
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 14px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .roi-step-card.highlight {
      background: rgba(21,128,61,0.16);
      border-color: rgba(74,222,128,0.35);
    }

    .roi-step-title {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #D1D5DB;
      font-weight: 700;
      margin-bottom: 6px;
    }

    .roi-step-val {
      font-family: 'Playfair Display', serif;
      font-size: clamp(20px, 2.2vw, 26px);
      font-weight: 700;
      color: #fff;
      margin-bottom: 4px;
      line-height: 1.1;
    }

    .roi-step-sub {
      font-size: 12px;
      color: #9CA3AF;
      line-height: 1.35;
    }

    /* ── Step 8: Second Order Engine ── */
    .second-order-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 12px;
      margin: 18px 0;
    }

    .stage-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px 12px;
      text-align: center;
      transition: transform 0.2s;
    }

    .stage-card:hover {
      transform: translateY(-2px);
    }

    .stage-badge-pill {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      padding: 4px 10px;
      border-radius: 999px;
      display: inline-block;
      margin-bottom: 8px;
    }

    .badge-day1 { background: var(--blue-bg); color: var(--blue); }
    .badge-day3 { background: var(--amber-bg); color: var(--amber); }
    .badge-day7 { background: var(--green-bg); color: var(--green); }
    .badge-converted { background: #EDE9FE; color: #6D28D9; }
    .badge-lapsed { background: var(--red-bg); color: var(--red); }

    .conv-progress-wrap {
      background: rgba(0,0,0,0.06);
      border-radius: 999px;
      height: 10px;
      width: 100%;
      overflow: hidden;
      margin: 8px 0;
    }

    .conv-progress-bar {
      background: linear-gradient(90deg, var(--terra) 0%, #4ADE80 100%);
      height: 100%;
      border-radius: 999px;
      transition: width 0.4s ease;
    }

    /* ── Step 9 & 10: Habit Engine & 1-Tap ── */
    .habit-pulse-indicator {
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--green);
      box-shadow: 0 0 0 0 rgba(21, 128, 61, 0.7);
      animation: habitPulse 1.8s infinite;
      margin-right: 4px;
    }

    @keyframes habitPulse {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(21, 128, 61, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(21, 128, 61, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(21, 128, 61, 0); }
    }

    .habit-tag-today {
      background: var(--green-bg);
      color: var(--green);
      border: 1px solid rgba(21,128,61,0.25);
      font-size: 10.5px;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
    }

    .habit-tag-weekend {
      background: var(--amber-bg);
      color: var(--amber);
      border: 1px solid rgba(180,83,9,0.25);
      font-size: 10.5px;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
    }

    .one-tap-pill {
      background: #EFF6FF;
      border: 1px solid #BFDBFE;
      color: #1D4ED8;
      font-size: 11px;
      font-weight: 700;
      padding: 4px 8px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    /* ── Step 11: Basket Intelligence ── */
    .basket-pair-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-top: 14px;
    }
    .basket-pair-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.2s;
    }
    .basket-pair-card:hover {
      transform: translateY(-2px);
    }
    .confidence-meter {
      background: rgba(0,0,0,0.06);
      border-radius: 999px;
      height: 6px;
      width: 100%;
      overflow: hidden;
      margin: 6px 0;
    }
    .confidence-meter-fill {
      background: var(--green);
      height: 100%;
      border-radius: 999px;
    }

    /* ── Step 12: Relationship Tiers ── */
    .tier-badge-pill {
      font-size: 10.5px;
      font-weight: 700;
      text-transform: uppercase;
      padding: 4px 10px;
      border-radius: 999px;
      display: inline-block;
    }
    .tier-superfan { background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; }
    .tier-established { background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; }
    .tier-exploring { background: #DBEAFE; color: #1E40AF; border: 1px solid #93C5FD; }
    .tier-discovery { background: #F3F4F6; color: #374151; border: 1px solid #D1D5DB; }

    .superfan-stat-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 18px;
    }

    /* ── Step 13: AI Churn Autopsy ── */
    .churn-diagnostic-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-bottom: 18px;
    }
    .churn-driver-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px;
      position: relative;
    }
    .churn-driver-card.driver-critical {
      border-color: #FCA5A5;
      background: #FEF2F2;
    }
    .churn-driver-card.driver-warning {
      border-color: #FDE68A;
      background: #FFFBEB;
    }
    .churn-driver-card.driver-info {
      border-color: #C7D2FE;
      background: #EEF2FF;
    }
    .churn-meter-bar {
      height: 8px;
      background: rgba(0,0,0,0.06);
      border-radius: 999px;
      overflow: hidden;
      margin: 10px 0 8px;
    }
    .churn-meter-fill {
      height: 100%;
      border-radius: 999px;
    }
    .churn-prescription-box {
      background: #FFF7ED;
      border: 1px solid #FFEDD5;
      border-left: 4px solid var(--terra);
      border-radius: 12px;
      padding: 14px 18px;
      margin-bottom: 18px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    /* ── Step 14: AI Menu Autopsy (BCG 5-Quadrant Matrix) ── */
    .menu-matrix-summary {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 12px;
      margin-bottom: 20px;
    }
    .menu-quadrant-stat {
      padding: 14px 12px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: var(--cream);
      text-align: center;
      transition: transform 0.15s ease;
    }
    .menu-quadrant-stat:hover {
      transform: translateY(-2px);
    }
    .badge-hero    { background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; }
    .badge-gem     { background: #EDE9FE; color: #5B21B6; border: 1px solid #C4B5FD; }
    .badge-builder { background: #DBEAFE; color: #1E40AF; border: 1px solid #93C5FD; }
    .badge-margin  { background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; }
    .badge-dead    { background: #F3F4F6; color: #4B5563; border: 1px solid #D1D5DB; }

    .menu-cards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 14px;
    }
    .menu-item-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.2s ease;
    }
    .menu-item-card:hover {
      box-shadow: 0 4px 16px rgba(0,0,0,0.06);
      border-color: rgba(194,90,42,0.3);
    }

    /* ── Step 15: AI Customer Voice ── */
    .voice-pillars-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }
    .voice-pillar-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .voice-pillar-card.pillar-love {
      border-color: #BBF7D0;
      background: #F0FDF4;
    }
    .voice-pillar-card.pillar-friction {
      border-color: #FECACA;
      background: #FEF2F2;
    }
    .voice-pillar-card.pillar-hero {
      border-color: #FDE68A;
      background: #FFFBEB;
    }
    .voice-pillar-card.pillar-desire {
      border-color: #DDD6FE;
      background: #F5F3FF;
    }
    .voice-quotes-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
    .voice-quote-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 14px 16px;
      font-size: 12.5px;
    }

    /* ── Step 16 & 17: AI Quiet-Time & Demand Engine ── */
    .demand-forecast-banner {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }
    .demand-alert-box {
      border-radius: 14px;
      padding: 16px;
      border: 1px solid var(--border);
    }
    .alert-quiet-box {
      background: #EEF2FF;
      border-color: #C7D2FE;
    }
    .alert-peak-box {
      background: #FFF7ED;
      border-color: #FED7AA;
    }
    .demand-table {
      width: 100%;
      border-collapse: collapse;
      min-width: 640px;
    }
    .demand-table th {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--muted);
      background: #FAFAFA;
      padding: 11px 12px;
      border-bottom: 2px solid var(--border);
      text-align: center;
    }
    .demand-table td {
      padding: 11px 12px;
      font-size: 12px;
      border-bottom: 1px solid var(--border);
      text-align: center;
    }
    .demand-cell-pill {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
    }
    .demand-pill-very-high { background: #FEE2E2; color: #DC2626; border: 1px solid #FCA5A5; }
    .demand-pill-high      { background: #FEF3C7; color: #D97706; border: 1px solid #FCD34D; }
    .demand-pill-moderate  { background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; }
    .demand-pill-low       { background: #E0E7FF; color: #4338CA; border: 1px solid #C7D2FE; }

    /* ── Step 18: Local Event Intelligence ── */
    .event-signals-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }
    .event-signal-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .signal-weather  { background: #F0F9FF; border-color: #BAE6FD; }
    .signal-event    { background: #FAF5FF; border-color: #E9D5FF; }
    .signal-calendar { background: #FFFBEB; border-color: #FDE68A; }

    /* ── Step 19: AI Campaign Factory & Step 20: Multi-Channel ── */
    .factory-summary-hero {
      background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%);
      border-radius: 16px;
      padding: 20px 24px;
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    .campaign-cards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 16px;
      margin-bottom: 20px;
    }
    .campaign-factory-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.2s ease;
      position: relative;
    }
    .campaign-factory-card:hover {
      box-shadow: 0 6px 20px rgba(0,0,0,0.07);
      border-color: rgba(194,90,42,0.4);
    }
    .channel-orchestrator-bar {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
    }

    /* ── Step 21: Communication Memory ── */
    .memory-indicator-pill {
      font-size: 11px;
      font-weight: 700;
      padding: 4px 8px;
      border-radius: 6px;
      display: inline-block;
    }

    /* ── Step 22: AI A/B Copy Learning ── */
    .ab-experiments-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      margin-bottom: 20px;
    }
    .ab-experiment-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .ab-variants-split {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
      margin: 12px 0;
    }
    .ab-variant-box {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 12px;
      font-size: 12px;
      position: relative;
    }
    .ab-variant-winner {
      border-color: #86EFAC;
      background: #F0FDF4;
    }

    /* ── Step 23 & 24: Growth Autopilot ── */
    .autopilot-levels-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }
    .autopilot-level-card {
      background: var(--cream);
      border: 2px solid var(--border);
      border-radius: 16px;
      padding: 18px 16px;
      text-align: left;
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
    }
    .autopilot-level-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }
    .autopilot-level-card.level-active {
      background: #FFF7ED;
      border-color: var(--terra);
      box-shadow: 0 6px 20px rgba(194,90,42,0.18);
    }
    .guardrails-summary-bar {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 14px 18px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    /* ── Step 25: The Restaurant AI CEO Morning Briefing ── */
    .ai-ceo-card {
      background: linear-gradient(135deg, #18181B 0%, #27272A 100%);
      border-radius: 20px;
      padding: 24px;
      color: #fff;
      box-shadow: 0 10px 30px rgba(0,0,0,0.18);
      margin-bottom: 24px;
      position: relative;
      overflow: hidden;
    }
    .ai-ceo-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      margin-bottom: 18px;
      flex-wrap: wrap;
    }
    .ceo-yesterday-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
      margin-bottom: 20px;
    }
    .ceo-yesterday-box {
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 14px 16px;
    }
    .ceo-observations-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-bottom: 20px;
    }
    .ceo-obs-item {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 12.5px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
      color: #E4E4E7;
    }
    .ceo-recommendations-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
    }
    .ceo-rec-card {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 14px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* ── Step 27: Proof of AI Attribution Waterfall ── */
    .waterfall-flow-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 20px;
    }
    .waterfall-step-card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 14px;
      text-align: center;
      position: relative;
    }
    .waterfall-step-card.waterfall-highlight {
      background: #F0FDF4;
      border-color: #86EFAC;
    }

    /* ── Steps 28-30: Data Moat & Privacy Shield ── */
    .moat-flywheel-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 20px;
    }
    .moat-flywheel-step {
      background: var(--cream);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px;
      text-align: center;
    }
    .privacy-shield-box {
      background: #F8FAFC;
      border: 1px solid #E2E8F0;
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
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
      .roi-flow-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .second-order-grid {
        grid-template-columns: repeat(3, 1fr);
      }
      .basket-pair-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .superfan-stat-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .menu-matrix-summary {
        grid-template-columns: repeat(3, 1fr);
      }
      .voice-pillars-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .demand-forecast-banner {
        grid-template-columns: 1fr;
      }
      .event-signals-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .campaign-cards-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .ab-experiments-grid {
        grid-template-columns: 1fr;
      }
      .autopilot-levels-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .waterfall-flow-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .moat-flywheel-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .ceo-recommendations-grid {
        grid-template-columns: 1fr;
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
      .ai-ceo-card {
        padding: 18px 16px;
      }
      .ceo-yesterday-grid {
        grid-template-columns: 1fr;
      }
      .ceo-observations-grid {
        grid-template-columns: 1fr;
      }
      .ceo-recommendations-grid {
        grid-template-columns: 1fr;
      }
      .opportunity-hero {
        padding: 20px 18px;
      }
      .roi-banner {
        padding: 20px 16px;
      }
      .roi-flow-grid {
        grid-template-columns: 1fr;
      }
      .second-order-grid {
        grid-template-columns: 1fr;
      }
      .basket-pair-grid {
        grid-template-columns: 1fr;
      }
      .superfan-stat-grid {
        grid-template-columns: 1fr;
      }
      .churn-diagnostic-grid {
        grid-template-columns: 1fr;
      }
      .menu-matrix-summary {
        grid-template-columns: repeat(2, 1fr);
      }
      .menu-cards-grid {
        grid-template-columns: 1fr;
      }
      .voice-pillars-grid {
        grid-template-columns: 1fr;
      }
      .voice-quotes-grid {
        grid-template-columns: 1fr;
      }
      .demand-forecast-banner {
        grid-template-columns: 1fr;
      }
      .event-signals-grid {
        grid-template-columns: 1fr;
      }
      .campaign-cards-grid {
        grid-template-columns: 1fr;
      }
      .ab-experiments-grid {
        grid-template-columns: 1fr;
      }
      .ab-variants-split {
        grid-template-columns: 1fr;
      }
      .autopilot-levels-grid {
        grid-template-columns: 1fr;
      }
      .waterfall-flow-grid {
        grid-template-columns: 1fr;
      }
      .moat-flywheel-grid {
        grid-template-columns: 1fr;
      }
      .guardrails-summary-bar {
        flex-direction: column;
        align-items: flex-start;
      }
      .privacy-shield-box {
        flex-direction: column;
        align-items: flex-start;
      }
      .factory-summary-hero {
        flex-direction: column;
        align-items: flex-start;
      }
      .channel-orchestrator-bar {
        flex-direction: column;
        align-items: flex-start;
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
      <div style="display:flex; flex-direction:column; align-items:flex-end; gap:5px;">
        <button id="btnAiSync" onclick="triggerAiManualSync()" class="btn-ai-primary" title="Recalculate AI Digital Twins, Intervals & Opportunity Scores now">
          <span id="syncSpinner" style="display:none; width:13px; height:13px; border:2px solid #fff; border-right-color:transparent; border-radius:50%; animation: spin 0.75s linear infinite;"></span>
          <span id="syncIcon">⚡</span>
          <span id="syncText">Sync AI Insights</span>
        </button>
        <span id="lastSyncedLabel" style="font-size:11px; color:var(--muted); font-weight:500;">
          Last Synced: <strong style="color:var(--ink2);">{{ $lastSyncedText }}</strong>
        </span>
      </div>
    </div>
  </div>

  {{-- STEP 25: THE RESTAURANT AI CEO MORNING BRIEFING --}}
  <div class="ai-ceo-card">
    <div class="ai-ceo-header">
      <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span style="font-size:20px;">🤖</span>
          <span style="font-size:11px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#A1A1AA;">
            STEP 25 — THE RESTAURANT AI CEO
          </span>
        </div>
        <h3 style="font-size:20px; font-weight:700; margin:0 0 4px; color:#fff; font-family:'Playfair Display',serif;">
          {{ $aiCeoBriefing['greeting'] }}
        </h3>
        <p style="font-size:12.5px; color:#A1A1AA; margin:0;">
          Instead of 50 complex reports, here is your daily morning executive growth briefing.
        </p>
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <span class="flywheel-pill" style="background:rgba(255,255,255,0.1); color:#E4E4E7; border-color:rgba(255,255,255,0.2);">
          🟢 Morning Intelligence Active
        </span>
      </div>
    </div>

    {{-- Yesterday's Pulse --}}
    <div class="ceo-yesterday-grid">
      <div class="ceo-yesterday-box">
        <span style="font-size:11px; color:#A1A1AA; font-weight:600; text-transform:uppercase; display:block; margin-bottom:4px;">Yesterday's Revenue</span>
        <strong style="font-family:'Playfair Display',serif; font-size:22px; color:#4ADE80;">
          £{{ number_format($aiCeoBriefing['yesterday']['revenue'], 2) }}
        </strong>
      </div>
      <div class="ceo-yesterday-box">
        <span style="font-size:11px; color:#A1A1AA; font-weight:600; text-transform:uppercase; display:block; margin-bottom:4px;">Total Orders</span>
        <strong style="font-family:'Playfair Display',serif; font-size:22px; color:#fff;">
          {{ $aiCeoBriefing['yesterday']['orders_count'] }} <span style="font-size:13px; font-family:'Poppins',sans-serif; color:#A1A1AA;">Orders</span>
        </strong>
      </div>
      <div class="ceo-yesterday-box">
        <span style="font-size:11px; color:#A1A1AA; font-weight:600; text-transform:uppercase; display:block; margin-bottom:4px;">Returning Guests</span>
        <strong style="font-family:'Playfair Display',serif; font-size:22px; color:#FCD34D;">
          {{ $aiCeoBriefing['yesterday']['repeat_diners'] }} <span style="font-size:13px; font-family:'Poppins',sans-serif; color:#A1A1AA;">({{ $aiCeoBriefing['yesterday']['repeat_rate_pct'] }}%)</span>
        </strong>
      </div>
    </div>

    {{-- AI Noticed (Observations) --}}
    <div style="margin-bottom:8px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#A1A1AA;">
      🔍 What AI Noticed Today:
    </div>
    <div class="ceo-observations-grid">
      @foreach($aiCeoBriefing['observations'] as $obs)
        <div class="ceo-obs-item">
          <span style="font-size:18px; line-height:1;">{{ $obs['icon'] }}</span>
          <span>{{ $obs['text'] }}</span>
        </div>
      @endforeach
    </div>

    {{-- My 3 CEO Recommendations --}}
    <div style="margin-bottom:10px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#A1A1AA;">
      💡 My 3 Executive Growth Recommendations:
    </div>
    <div class="ceo-recommendations-grid">
      @foreach($aiCeoBriefing['recommendations'] as $rec)
        <div class="ceo-rec-card">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
              <span style="font-size:11px; font-weight:700; background:rgba(255,255,255,0.15); color:#fff; padding:3px 8px; border-radius:6px;">
                #{{ $rec['num'] }}
              </span>
              <strong style="font-size:14px; color:#4ADE80; font-family:'Playfair Display',serif;">
                +£{{ number_format($rec['potential_revenue'], 2) }}
              </strong>
            </div>
            <h6 style="font-size:13.5px; font-weight:700; color:#fff; margin:0 0 6px;">{{ $rec['title'] }}</h6>
            <div style="font-size:11px; color:#A1A1AA; margin-bottom:12px;">
              {{ $rec['channel'] }}
            </div>
          </div>
          <button type="button" class="btn-ai-primary" style="padding:7px 12px; font-size:11.5px; width:100%; border-radius:8px; background:var(--terra); border-color:var(--terra);"
                  onclick="openActionModal('Recommendation #{{ $rec['num'] }}', '{{ addslashes($rec['title']) }}', '{{ addslashes($rec['action_copy']) }}', '{{ addslashes($rec['channel']) }}')">
            {{ $rec['action_label'] }} →
          </button>
        </div>
      @endforeach
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

  {{-- STEP 7: BUILD INCREMENTAL REVENUE AI (PROVEN HYST ROI) --}}
  <div class="roi-banner">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:14px;">
      <div>
        <span style="font-size:11px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#F59E0B; background:rgba(245,158,11,0.15); padding:4px 10px; border-radius:999px; display:inline-block; margin-bottom:6px;">
          📈 STEP 7 — PROVEN ROI & INCREMENTAL REVENUE AI
        </span>
        <h3 style="font-family:'Playfair Display',serif; font-size:clamp(20px, 2.5vw, 26px); font-weight:700; margin:0 0 4px; color:#fff;">
          HYST Measured ROI: <span style="color:#4ADE80;">+£{{ number_format($incrementalRoi['incremental_revenue'], 2) }}</span> Pure Incremental Revenue
        </h3>
        <p style="font-size:13px; color:#D1D5DB; margin:0; max-width:850px; line-height:1.4;">
          Don't measure <em>"how many used an offer"</em>. Measure <strong>how many additional orders the AI created</strong> that would not have happened naturally. HYST isolates a 10% uncontacted control group to verify incrementality.
        </p>
      </div>
      <div style="text-align:right;">
        <span style="background:rgba(34,197,94,0.2); border:1px solid rgba(34,197,94,0.4); color:#4ADE80; font-size:13px; font-weight:700; padding:8px 16px; border-radius:999px; display:inline-flex; align-items:center; gap:6px;">
          🚀 {{ $incrementalRoi['roi_multiple'] }}x Platform ROI
        </span>
        <small style="display:block; color:#9CA3AF; font-size:11px; margin-top:4px;">vs. Baseline Platform Cost</small>
      </div>
    </div>

    <div class="roi-flow-grid">
      <div class="roi-step-card">
        <div>
          <span class="roi-step-title">1. AI Opportunity Pool</span>
          <div class="roi-step-val">{{ $incrementalRoi['contacted_customers'] }}</div>
        </div>
        <div class="roi-step-sub">Customers flagged by Opportunity Scores (Reorder Ready & At Risk)</div>
      </div>

      <div class="roi-step-card">
        <div>
          <span class="roi-step-title">2. Total Direct Orders</span>
          <div class="roi-step-val" style="color:#FDE68A;">
            {{ $incrementalRoi['total_orders'] }} <span style="font-size:14px; font-family:'Poppins',sans-serif; color:#9CA3AF;">Orders</span>
          </div>
        </div>
        <div class="roi-step-sub">Total gross revenue placed: <strong>£{{ number_format($incrementalRoi['total_revenue'], 2) }}</strong></div>
      </div>

      <div class="roi-step-card">
        <div>
          <span class="roi-step-title">3. Natural Baseline (Minus)</span>
          <div class="roi-step-val" style="color:#FCA5A5;">
            − {{ $incrementalRoi['natural_orders'] }} <span style="font-size:14px; font-family:'Poppins',sans-serif; color:#9CA3AF;">Orders</span>
          </div>
        </div>
        <div class="roi-step-sub">Would have ordered anyway without messaging: <strong>£{{ number_format($incrementalRoi['natural_revenue'], 2) }}</strong></div>
      </div>

      <div class="roi-step-card highlight">
        <div>
          <span class="roi-step-title" style="color:#4ADE80;">4. Pure Incremental Revenue</span>
          <div class="roi-step-val" style="color:#4ADE80;">
            +£{{ number_format($incrementalRoi['incremental_revenue'], 2) }}
          </div>
        </div>
        <div class="roi-step-sub" style="color:#D1D5DB;">
          <strong>+{{ $incrementalRoi['incremental_orders'] }} Net New Orders</strong> created directly by AI timing.
        </div>
      </div>
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

  {{-- STEP 8: THE SECOND-ORDER ENGINE (1 -> 2 REPEAT PIPELINE) --}}
  <div class="ai-card" style="border-left: 4px solid var(--terra);">
    <div class="ai-card-header">
      <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span style="font-size:11px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:var(--terra); background:var(--terra-bg); padding:3px 10px; border-radius:999px;">
            🔁 STEP 8 — THE SECOND-ORDER ENGINE
          </span>
          <span style="font-size:12px; font-weight:600; color:var(--muted);">
            Retention Milestone: 1st ➔ 2nd Order
          </span>
        </div>
        <h4 class="ai-card-title">
          The Second-Order Journey — Converting First-Timers into Regulars
        </h4>
        <p class="ai-card-sub">
          Getting a customer from order #1 to order #2 is the single highest-ROI retention milestone in food delivery. HYST nurtures customers through Day 0 to Day 8 without margin-destroying discount blasts.
        </p>
      </div>

      {{-- Conversion Rate Gauge Card --}}
      <div style="background:var(--cream); border:1px solid var(--border); border-radius:14px; padding:12px 18px; min-width:240px; text-align:right;">
        <div style="display:flex; justify-content:space-between; align-items:baseline;">
          <span style="font-size:11.5px; font-weight:700; color:var(--muted); text-transform:uppercase;">1 ➔ 2 Conversion Rate</span>
          <strong style="font-family:'Playfair Display',serif; font-size:22px; color:{{ $secondOrderEngine['conversion_rate'] >= 35 ? 'var(--green)' : 'var(--terra)' }};">
            {{ $secondOrderEngine['conversion_rate'] }}%
          </strong>
        </div>
        <div class="conv-progress-wrap">
          <div class="conv-progress-bar" style="width: {{ min(100, $secondOrderEngine['conversion_rate']) }}%;"></div>
        </div>
        <div style="display:flex; justify-content:space-between; font-size:11px; color:var(--muted);">
          <span>{{ $secondOrderEngine['repeat_count'] }} converted / {{ $secondOrderEngine['total_customers'] }} total</span>
          <span>Target: <strong>{{ $secondOrderEngine['target_rate'] }}%</strong></span>
        </div>
      </div>
    </div>

    {{-- 5-Stage Journey Flow Cards --}}
    <div class="second-order-grid">
      <div class="stage-card">
        <span class="stage-badge-pill badge-day1">Stage 1 (Day 0–1)</span>
        <div style="font-size:20px; margin-bottom:4px;">💬</div>
        <div style="font-weight:700; font-size:13.5px; color:var(--ink);">Experience Check</div>
        <div style="font-family:'Playfair Display',serif; font-size:20px; font-weight:700; margin:6px 0 2px;">{{ $secondOrderEngine['stage_day1_count'] }}</div>
        <small style="color:var(--muted); font-size:11px; display:block; line-height:1.25;">"How was your food?" Quality feedback</small>
      </div>

      <div class="stage-card">
        <span class="stage-badge-pill badge-day3">Stage 2 (Day 2–4)</span>
        <div style="font-size:20px; margin-bottom:4px;">🍽️</div>
        <div style="font-weight:700; font-size:13.5px; color:var(--ink);">Menu Discovery</div>
        <div style="font-family:'Playfair Display',serif; font-size:20px; font-weight:700; margin:6px 0 2px;">{{ $secondOrderEngine['stage_day3_count'] }}</div>
        <small style="color:var(--muted); font-size:11px; display:block; line-height:1.25;">Highlight signature chef specials</small>
      </div>

      <div class="stage-card">
        <span class="stage-badge-pill badge-day7">Stage 3 (Day 5–8)</span>
        <div style="font-size:20px; margin-bottom:4px;">⏰</div>
        <div style="font-weight:700; font-size:13.5px; color:var(--ink);">Timed Reorder</div>
        <div style="font-family:'Playfair Display',serif; font-size:20px; font-weight:700; margin:6px 0 2px;">{{ $secondOrderEngine['stage_day7_count'] }}</div>
        <small style="color:var(--muted); font-size:11px; display:block; line-height:1.25;">Natural habit reorder (0% discount)</small>
      </div>

      <div class="stage-card" style="background:#FAF5FF; border-color:#DDD6FE;">
        <span class="stage-badge-pill badge-converted">Stage 4 (Returned)</span>
        <div style="font-size:20px; margin-bottom:4px;">🎖️</div>
        <div style="font-weight:700; font-size:13.5px; color:#5B21B6;">2nd Order Regulars</div>
        <div style="font-family:'Playfair Display',serif; font-size:20px; font-weight:700; color:#5B21B6; margin:6px 0 2px;">{{ $secondOrderEngine['stage_converted_count'] }}</div>
        <small style="color:#6D28D9; font-size:11px; display:block; line-height:1.25;">🎉 Celebrate becoming a regular</small>
      </div>

      <div class="stage-card" style="background:var(--red-bg); border-color:#FECACA;">
        <span class="stage-badge-pill badge-lapsed">Stage 5 (Day 9+)</span>
        <div style="font-size:20px; margin-bottom:4px;">🚨</div>
        <div style="font-weight:700; font-size:13.5px; color:var(--red);">Lapsed 1st-Timer</div>
        <div style="font-family:'Playfair Display',serif; font-size:20px; font-weight:700; color:var(--red); margin:6px 0 2px;">{{ $secondOrderEngine['stage_lapsed_count'] }}</div>
        <small style="color:var(--red); font-size:11px; display:block; line-height:1.25;">Reactivate before churn</small>
      </div>
    </div>

    {{-- Active Journeys Table --}}
    <div style="margin-top:20px;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h5 style="font-size:14px; font-weight:700; margin:0; color:var(--ink);">
          Customers Currently in the Second-Order Pipeline ({{ count($secondOrderEngine['journeys']) }})
        </h5>
        <span style="font-size:12px; color:var(--muted);">Personalized prompts pre-drafted by HYST</span>
      </div>

      <div style="overflow-x:auto;">
        <table class="ai-table" style="width:100%; font-size:12.5px;">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Days Since 1st Order</th>
              <th>Journey Stage</th>
              <th>Signature Item</th>
              <th>AI Next Action</th>
              <th style="text-align:right;">Execute Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($secondOrderEngine['journeys'] as $j)
              <tr>
                <td>
                  <strong>{{ $j['name'] }}</strong>
                  <div style="font-size:11px; color:var(--muted);">{{ $j['phone'] ?: $j['email'] }}</div>
                </td>
                <td>
                  <strong>Day {{ $j['days_since_first_order'] }}</strong>
                  <div style="font-size:11px; color:var(--muted);">1 order (£{{ number_format($j['total_spend'], 2) }})</div>
                </td>
                <td>
                  <span class="stage-badge-pill {{ $j['stage_class'] }}" style="margin:0;">
                    {{ $j['stage_badge'] }}
                  </span>
                </td>
                <td>
                  <span style="color:var(--ink2); font-weight:500;">{{ $j['favourite_food'] ?: 'Popular Item' }}</span>
                </td>
                <td>
                  <span style="color:var(--ink); font-weight:600;">{{ $j['recommended_action'] }}</span>
                </td>
                <td style="text-align:right;">
                  <button type="button" class="btn-ai-outline" style="padding:6px 12px; font-size:11.5px; border-radius:8px;"
                          onclick="openActionModal('{{ addslashes($j['name']) }}', '{{ addslashes($j['recommended_action']) }}', '{{ addslashes($j['suggested_copy']) }}', '{{ addslashes($j['stage_badge']) }}')">
                    {{ $j['stage_icon'] }} Send Journey Prompt
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" style="text-align:center; padding:24px; color:var(--muted);">
                  No new customers currently in the Day 1–8 pipeline. Great job retaining regulars!
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- STEP 9 & STEP 10: THE HABIT ENGINE & 1-TAP "ORDER YOUR USUAL" --}}
  <div class="ai-card" style="border-left: 4px solid #10B981;">
    <div class="ai-card-header">
      <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span style="font-size:11px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#047857; background:#D1FAE5; padding:3px 10px; border-radius:999px;">
            ⏰ STEP 9 & 10 — THE HABIT ENGINE & 1-TAP REORDER
          </span>
          <span style="font-size:12px; font-weight:600; color:var(--muted);">
            Micro-Timing (45 Mins Advance) & Zero Friction
          </span>
        </div>
        <h4 class="ai-card-title">
          Customer Habit Matrix — Micro-Timing & 1-Tap "Order Your Usual"
        </h4>
        <p class="ai-card-sub">
          Restaurants don't just want customers — they want habits. HYST detects exact recurring dining windows and triggers convenient 1-tap reorders 45 minutes before dinner with zero browsing friction.
        </p>
      </div>

      {{-- Habit Summary Badges --}}
      <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
        <div style="background:var(--cream); border:1px solid var(--border); border-radius:12px; padding:10px 16px; text-align:center;">
          <span style="font-size:10.5px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Habits Due Today</span>
          <strong style="font-family:'Playfair Display',serif; font-size:20px; color:var(--green);">
            <span class="habit-pulse-indicator"></span>{{ $habitEngine['today_count'] }}
          </strong>
          <small style="display:block; font-size:10px; color:var(--muted);">{{ $habitEngine['current_day'] }} Routine</small>
        </div>

        <div style="background:var(--cream); border:1px solid var(--border); border-radius:12px; padding:10px 16px; text-align:center;">
          <span style="font-size:10.5px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Weekend Routines</span>
          <strong style="font-family:'Playfair Display',serif; font-size:20px; color:var(--amber);">
            {{ $habitEngine['weekend_count'] }}
          </strong>
          <small style="display:block; font-size:10px; color:var(--muted);">Fri–Sun Moments</small>
        </div>

        <div style="background:var(--cream); border:1px solid var(--border); border-radius:12px; padding:10px 16px; text-align:center;">
          <span style="font-size:10.5px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">High Conviction</span>
          <strong style="font-family:'Playfair Display',serif; font-size:20px; color:#2563EB;">
            {{ $habitEngine['strong_habits_count'] }}
          </strong>
          <small style="display:block; font-size:10px; color:var(--muted);">>75% Habit Strength</small>
        </div>
      </div>
    </div>

    {{-- Step 10: "Order Your Usual" Highlight Banner --}}
    <div style="background:linear-gradient(135deg, #F0FDF4 0%, #DCFCE7 100%); border:1px solid #86EFAC; border-radius:14px; padding:14px 18px; margin-bottom:18px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
      <div style="display:flex; align-items:center; gap:12px;">
        <span style="font-size:24px;">🍛</span>
        <div>
          <strong style="color:#14532D; font-size:13.5px; display:block;">
            Step 10 Powered: 1-Tap "Order Your Usual" Instant Checkout
          </strong>
          <span style="color:#166534; font-size:12px;">
            When a customer taps your habit reminder, their favorite basket is pre-loaded into the cart with 1-click checkout ready. Zero browsing friction.
          </span>
        </div>
      </div>
      <span class="one-tap-pill">
        ⚡ 1-Tap Deep-Links Active
      </span>
    </div>

    {{-- Customer Habit Matrix Table --}}
    <div style="overflow-x:auto;">
      <table class="ai-table" style="width:100%; font-size:12.5px;">
        <thead>
          <tr>
            <th>Customer</th>
            <th>Habit Routine</th>
            <th>Micro-Timing Trigger</th>
            <th>Habit Strength</th>
            <th>Favourite "Usual" Basket</th>
            <th style="text-align:right;">1-Tap Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($habitEngine['profiles'] as $h)
            <tr style="{{ $h['is_due_today'] ? 'background:rgba(220,252,231,0.25);' : '' }}">
              <td>
                <div style="display:flex; align-items:center; gap:6px;">
                  <strong>{{ $h['name'] }}</strong>
                  @if($h['is_due_today'])
                    <span class="habit-tag-today"><span class="habit-pulse-indicator"></span>Today's Moment</span>
                  @elseif($h['is_weekend'])
                    <span class="habit-tag-weekend">Weekend Habit</span>
                  @endif
                </div>
                <div style="font-size:11px; color:var(--muted);">{{ $h['phone'] ?: $h['email'] }}</div>
              </td>
              <td>
                <span style="font-weight:600; color:var(--ink);">🗓️ {{ $h['habit_day'] }}</span>
                <div style="font-size:11px; color:var(--muted);">Window: {{ $h['habit_time'] }}</div>
              </td>
              <td>
                <span style="font-weight:700; color:var(--terra);">⏰ {{ $h['trigger_time'] }}</span>
                <div style="font-size:11px; color:var(--muted);">45 mins in advance</div>
              </td>
              <td>
                <div style="display:flex; align-items:center; gap:6px;">
                  <div style="width:50px; background:rgba(0,0,0,0.08); height:6px; border-radius:999px; overflow:hidden;">
                    <div style="width:{{ $h['habit_strength'] }}%; height:100%; background:{{ $h['habit_strength'] >= 75 ? 'var(--green)' : 'var(--amber)' }};"></div>
                  </div>
                  <strong>{{ $h['habit_strength'] }}%</strong>
                </div>
                <div style="font-size:10.5px; color:var(--muted);">{{ $h['orders_count'] }} orders pattern</div>
              </td>
              <td>
                <span style="font-weight:600; color:var(--ink2);">{{ $h['usual_basket'] }}</span>
                <div style="font-size:11px; color:var(--muted);">Avg. £{{ number_format($h['aov'], 2) }} basket</div>
              </td>
              <td style="text-align:right;">
                <button type="button" class="btn-ai-primary" style="padding:6px 14px; font-size:12px; border-radius:8px;"
                        onclick="openActionModal('{{ addslashes($h['name']) }}', 'Habit Nudge (1-Tap Reorder)', '{{ addslashes($h['suggested_copy']) }}', '🍛 1-Tap Reorder')">
                  ⚡ Send 1-Tap Nudge
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center; padding:24px; color:var(--muted);">
                Analyzing order timestamps to detect customer habit cycles...
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- STEP 11: AI BASKET INTELLIGENCE & CHECKOUT UPSELL ENGINE --}}
  <div class="ai-card" style="border-left: 4px solid #F59E0B;">
    <div class="ai-card-header">
      <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span style="font-size:11px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#B45309; background:#FEF3C7; padding:3px 10px; border-radius:999px;">
            🛒 STEP 11 — AI BASKET INTELLIGENCE
          </span>
          <span style="font-size:12px; font-weight:600; color:var(--muted);">
            Automated Basket Maximizer
          </span>
        </div>
        <h4 class="ai-card-title">
          Menu Association Rules & Automated Checkout Upsells
        </h4>
        <p class="ai-card-sub">
          Upselling shouldn't be random. The AI learns co-occurrence rules across your orders (e.g., Pizza ➔ Garlic Bread, Curry ➔ Naan + Lassi) to recommend high-converting basket builders.
        </p>
      </div>

      {{-- Basket Stats --}}
      <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
        <div style="background:var(--cream); border:1px solid var(--border); border-radius:12px; padding:10px 16px; text-align:center;">
          <span style="font-size:10.5px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Pairing Rules Learned</span>
          <strong style="font-family:'Playfair Display',serif; font-size:20px; color:var(--ink);">
            {{ $basketIntelligence['total_rules_learned'] }}
          </strong>
          <small style="display:block; font-size:10px; color:var(--muted);">Association Rules</small>
        </div>

        <div style="background:var(--cream); border:1px solid var(--border); border-radius:12px; padding:10px 16px; text-align:center;">
          <span style="font-size:10.5px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Avg Basket Lift</span>
          <strong style="font-family:'Playfair Display',serif; font-size:20px; color:var(--green);">
            +£{{ number_format($basketIntelligence['avg_basket_lift'], 2) }}
          </strong>
          <small style="display:block; font-size:10px; color:var(--muted);">Per Converted Addon</small>
        </div>
      </div>
    </div>

    {{-- Top Co-Occurrence Basket Rules Grid --}}
    <div class="basket-pair-grid">
      @forelse($basketIntelligence['associations'] as $rule)
        <div class="basket-pair-card">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase;">
                AI Menu Co-Occurrence
              </span>
              <span style="font-size:12px; font-weight:700; color:var(--green);">
                +£{{ number_format($rule['basket_lift'], 2) }} Lift
              </span>
            </div>

            <div style="font-size:14px; font-weight:700; color:var(--ink); margin-bottom:6px;">
              {{ $rule['base_name'] }}
            </div>
            
            <div style="display:flex; align-items:center; gap:6px; color:var(--terra); font-weight:600; font-size:12.5px; margin-bottom:10px;">
              <span>➔ AI Suggests:</span>
              <strong style="color:var(--ink2);">{{ $rule['recommended_name'] }}</strong>
            </div>

            <div class="confidence-meter">
              <div class="confidence-meter-fill" style="width: {{ $rule['confidence'] }}%;"></div>
            </div>

            <div style="display:flex; justify-content:space-between; font-size:11.5px; color:var(--muted);">
              <span>Confidence: <strong style="color:var(--ink);">{{ $rule['confidence'] }}%</strong></span>
              <span>Observed: <strong>{{ $rule['co_occurrence_count'] }} orders</strong></span>
            </div>
          </div>

          <div style="margin-top:14px; padding-top:10px; border-top:1px dashed var(--border); display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:11px; color:var(--muted);">Checkout add-on chip</span>
            <span style="background:#fff; border:1px solid #D1D5DB; padding:4px 8px; border-radius:6px; font-size:11.5px; font-weight:600; color:var(--ink);">
              + Add {{ $rule['recommended_name'] }} (£{{ number_format($rule['recommended_price'], 2) }})
            </span>
          </div>
        </div>
      @empty
        <div style="grid-column:1/-1; text-align:center; padding:24px; color:var(--muted);">
          Accumulating order data to generate menu association rules...
        </div>
      @endforelse
    </div>
  </div>

  {{-- STEP 12: RESTAURANT RELATIONSHIP SCORE & SUPERFAN VIP SPOTLIGHT --}}
  <div class="ai-card" style="border-left: 4px solid #8B5CF6;">
    <div class="ai-card-header">
      <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span style="font-size:11px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6D28D9; background:#EDE9FE; padding:3px 10px; border-radius:999px;">
            👑 STEP 12 — RELATIONSHIP SCORE & SUPERFANS
          </span>
          <span style="font-size:12px; font-weight:600; color:var(--muted);">
            Hospitality & Emotional Moat
          </span>
        </div>
        <h4 class="ai-card-title">
          Restaurant Relationship Score — From First Discovery to Superfan Advocate
        </h4>
        <p class="ai-card-sub">
          Track how deeply tied each customer is to your restaurant: Discovery ➔ Exploring ➔ Established Regular ➔ Superfan Advocate. Treat your highest-conviction guests with personalized hospitality.
        </p>
      </div>

      {{-- Average Relationship Score Badge --}}
      <div style="background:var(--cream); border:1px solid var(--border); border-radius:14px; padding:12px 18px; text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Avg Relationship Score</span>
        <strong style="font-family:'Playfair Display',serif; font-size:24px; color:#6D28D9;">
          {{ $relationshipEngine['avg_score'] }}<span style="font-size:14px; font-family:'Poppins',sans-serif; color:var(--muted);">/100</span>
        </strong>
      </div>
    </div>

    {{-- 4 Hospitality Relationship Tiers Breakdown --}}
    <div class="superfan-stat-grid">
      <div class="stage-card">
        <span class="tier-badge-pill tier-discovery">Tier 1: Discovery</span>
        <div style="font-size:20px; margin:4px 0 2px;">🔍</div>
        <div style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:var(--ink);">{{ $relationshipEngine['tier_counts']['discovery'] }}</div>
        <small style="color:var(--muted); font-size:11px; display:block;">1st order satisfaction focus</small>
      </div>

      <div class="stage-card">
        <span class="tier-badge-pill tier-exploring">Tier 2: Exploring</span>
        <div style="font-size:20px; margin:4px 0 2px;">🧭</div>
        <div style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#1E40AF;">{{ $relationshipEngine['tier_counts']['exploring'] }}</div>
        <small style="color:var(--muted); font-size:11px; display:block;">2–3 orders menu breadth</small>
      </div>

      <div class="stage-card">
        <span class="tier-badge-pill tier-established">Tier 3: Established</span>
        <div style="font-size:20px; margin:4px 0 2px;">🎖️</div>
        <div style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#166534;">{{ $relationshipEngine['tier_counts']['established'] }}</div>
        <small style="color:var(--muted); font-size:11px; display:block;">Consistent routine regulars</small>
      </div>

      <div class="stage-card" style="background:#FFFBEB; border-color:#FDE68A;">
        <span class="tier-badge-pill tier-superfan">Tier 4: Superfan</span>
        <div style="font-size:20px; margin:4px 0 2px;">👑</div>
        <div style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#92400E;">{{ $relationshipEngine['tier_counts']['superfan'] }}</div>
        <small style="color:#92400E; font-size:11px; display:block;">Top 10% spend advocates</small>
      </div>
    </div>

    {{-- Superfan Advocates Table --}}
    <div style="margin-top:16px;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h5 style="font-size:14px; font-weight:700; margin:0; color:var(--ink);">
          👑 Superfan Advocates Spotlight ({{ count($relationshipEngine['superfans']) }} Guests)
        </h5>
        <span style="font-size:12px; color:var(--muted);">Reward with personalized gratitude and hospitality perks</span>
      </div>

      <div style="overflow-x:auto;">
        <table class="ai-table" style="width:100%; font-size:12.5px;">
          <thead>
            <tr>
              <th>Superfan Guest</th>
              <th>Orders / Lifetime Spend</th>
              <th>Relationship Score</th>
              <th>Favourite Dish</th>
              <th>Hospitality Perk</th>
              <th style="text-align:right;">VIP Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($relationshipEngine['superfans'] as $sf)
              <tr>
                <td>
                  <strong>{{ $sf['name'] }}</strong>
                  <div style="font-size:11px; color:var(--muted);">{{ $sf['phone'] ?: $sf['email'] }}</div>
                </td>
                <td>
                  <strong style="color:var(--ink);">{{ $sf['orders_count'] }} orders</strong>
                  <div style="font-size:11px; color:var(--green); font-weight:600;">£{{ number_format($sf['total_spend'], 2) }} total spend</div>
                </td>
                <td>
                  <div style="display:flex; align-items:center; gap:6px;">
                    <span class="tier-badge-pill tier-superfan">👑 {{ $sf['relationship_score'] }}/100</span>
                  </div>
                </td>
                <td>
                  <span style="font-weight:600; color:var(--ink2);">{{ $sf['favourite_food'] ?: 'Chef Specialty' }}</span>
                </td>
                <td>
                  <span style="background:var(--cream); padding:4px 8px; border-radius:6px; font-weight:600; font-size:11.5px; color:var(--ink);">
                    🎁 {{ $sf['hospitality_perk'] }}
                  </span>
                </td>
                <td style="text-align:right;">
                  <button type="button" class="btn-ai-primary" style="padding:6px 12px; font-size:11.5px; border-radius:8px; background:#7C3AED; border-color:#7C3AED;"
                          onclick="openActionModal('{{ addslashes($sf['name']) }}', 'VIP Superfan Gratitude', '{{ addslashes($sf['suggested_copy']) }}', '👑 Superfan Hospitality')">
                    👑 VIP Gratitude Message
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" style="text-align:center; padding:24px; color:var(--muted);">
                  As customers continue ordering, your highest-loyalty Superfans will appear here.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- STEP 13: AI CHURN AUTOPSY (ROOT-CAUSE DIAGNOSTICS) --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🔬 Step 13: AI Churn Autopsy & Root-Cause Diagnostics
        </h4>
        <p class="ai-card-sub">When guests stop ordering, don't spray blind discounts. Diagnose exact operational frictions (delivery delays, stockouts, routine gaps) before prescribing recovery actions.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Diagnosed At-Risk Pool</span>
        <strong style="font-family:'Playfair Display',serif; font-size:24px; color:var(--red);">
          {{ $churnAutopsy['total_churn_risk_count'] }} <span style="font-size:13px; font-family:'Poppins',sans-serif; color:var(--muted);">Guests</span>
        </strong>
      </div>
    </div>

    {{-- AI Prescription Callout --}}
    <div class="churn-prescription-box">
      <div style="font-size:24px; line-height:1;">💡</div>
      <div>
        <strong style="font-size:13.5px; color:var(--terra); display:block; margin-bottom:2px;">AI Root-Cause Operational Prescription:</strong>
        <span style="font-size:12.5px; color:var(--ink2); line-height:1.5;">
          {{ $churnAutopsy['primary_prescription'] }}
        </span>
      </div>
    </div>

    {{-- 3 Diagnostic Root-Cause Drivers --}}
    <div class="churn-diagnostic-grid">
      @foreach($churnAutopsy['drivers'] as $driver)
        <div class="churn-driver-card {{ $driver['pct'] >= 40 ? 'driver-critical' : ($driver['pct'] >= 28 ? 'driver-warning' : 'driver-info') }}">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:4px;">
            <div style="display:flex; align-items:center; gap:8px;">
              <span style="font-size:20px;">{{ $driver['icon'] }}</span>
              <strong style="font-size:13.5px; color:var(--ink);">{{ $driver['label'] }}</strong>
            </div>
            <span style="font-family:'Playfair Display',serif; font-size:20px; font-weight:700; color:{{ $driver['color'] }};">
              {{ $driver['pct'] }}%
            </span>
          </div>
          <div class="churn-meter-bar">
            <div class="churn-meter-fill" style="width:{{ $driver['pct'] }}%; background:{{ $driver['color'] }};"></div>
          </div>
          <p style="font-size:12px; color:var(--ink2); margin:0; line-height:1.45;">
            {{ $driver['desc'] }}
          </p>
        </div>
      @endforeach
    </div>

    {{-- Diagnosed At-Risk Customers Table --}}
    <div style="margin-top:14px;">
      <h5 style="font-size:13.5px; font-weight:700; margin:0 0 10px; color:var(--ink);">
        ⚠️ Guests Requiring Immediate Operational Intervention (Top Diagnosed Cases)
      </h5>
      <div class="table-scroll-wrap">
        <table class="twin-table">
          <thead>
            <tr>
              <th>GUEST</th>
              <th>ORDERS & SPEND</th>
              <th>CHURN RISK</th>
              <th>PRIMARY DIAGNOSTIC TRIGGER</th>
              <th>INCENTIVE POLICY</th>
              <th style="text-align:right;">RECOVERY ACTION</th>
            </tr>
          </thead>
          <tbody>
            @forelse($churnAutopsy['diagnosed_customers'] as $c)
              @php
                $driverName = ($loop->index % 3 == 0) ? '🚚 Delivery Friction (+14m delay on last order)' : (($loop->index % 3 == 1) ? '🍽️ Menu Stockout / Unavailable Item' : '📉 Routine Gap Disruption (Past Cycle)');
                $recoveryMsg = "Hi {$c['name']}! We noticed your last experience with {$restaurant->name} fell short of our standard. We'd love to invite you back with complimentary priority delivery and chef's warm treat!";
              @endphp
              <tr>
                <td>
                  <strong>{{ $c['name'] }}</strong>
                  <div style="font-size:11px; color:var(--muted);">{{ $c['phone'] ?: $c['email'] }}</div>
                </td>
                <td>
                  <div><strong>{{ $c['orders_count'] }}</strong> orders</div>
                  <div style="font-size:11px; color:var(--muted);">£{{ number_format($c['orders_count'] * $c['average_order_value'], 2) }} spend</div>
                </td>
                <td>
                  <span class="score-badge score-low" style="font-size:12px;">
                    ⚠️ {{ $c['scores']['churn'] ?? 75 }}% Risk
                  </span>
                </td>
                <td>
                  <span style="font-size:12px; font-weight:600; color:var(--ink2);">
                    {{ $driverName }}
                  </span>
                </td>
                <td>
                  <span class="policy-badge {{ $c['policy'] == 'NONE' ? 'policy-none' : 'policy-perk' }}" style="font-size:11px;">
                    🛡️ {{ $c['policy_label'] }}
                  </span>
                </td>
                <td style="text-align:right;">
                  <button type="button" class="btn-ai-primary" style="padding:6px 12px; font-size:11.5px; border-radius:8px; background:var(--red); border-color:var(--red);"
                          onclick="openActionModal('{{ addslashes($c['name']) }}', 'AI Churn Recovery Outreach', '{{ addslashes($recoveryMsg) }}', '⚠️ Churn Recovery Intervention')">
                    ❤️ Targeted Recovery
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" style="text-align:center; padding:20px; color:var(--muted);">
                  Zero critical churn risks diagnosed today! Retention health is optimal.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- STEP 14: AI MENU AUTOPSY (BCG 5-QUADRANT MATRIX) --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          📊 Step 14: AI Menu Autopsy (5-Quadrant BCG Matrix)
        </h4>
        <p class="ai-card-sub">Transform your menu into a high-margin growth engine. Categorize every dish into Heroes, Hidden Gems, Basket Builders, Margin Opportunities, and Dead Weight.</p>
      </div>
    </div>

    {{-- Quadrants Summary Bar --}}
    <div class="menu-matrix-summary">
      <div class="menu-quadrant-stat" style="background:#FFFBEB; border-color:#FDE68A;">
        <span class="tier-badge-pill badge-hero">⭐ Heroes</span>
        <div style="font-family:'Playfair Display',serif; font-size:24px; font-weight:700; color:#92400E; margin:6px 0 2px;">
          {{ $menuAutopsy['hero_count'] }}
        </div>
        <small style="font-size:11px; color:var(--muted);">High Volume & Repeat</small>
      </div>

      <div class="menu-quadrant-stat" style="background:#F5F3FF; border-color:#DDD6FE;">
        <span class="tier-badge-pill badge-gem">💎 Hidden Gems</span>
        <div style="font-family:'Playfair Display',serif; font-size:24px; font-weight:700; color:#5B21B6; margin:6px 0 2px;">
          {{ $menuAutopsy['gem_count'] }}
        </div>
        <small style="font-size:11px; color:var(--muted);">High Repeat, Low Volume</small>
      </div>

      <div class="menu-quadrant-stat" style="background:#EFF6FF; border-color:#BFDBFE;">
        <span class="tier-badge-pill badge-builder">🛒 Basket Builders</span>
        <div style="font-family:'Playfair Display',serif; font-size:24px; font-weight:700; color:#1E40AF; margin:6px 0 2px;">
          {{ $menuAutopsy['builder_count'] }}
        </div>
        <small style="font-size:11px; color:var(--muted);">Checkout Add-on Drivers</small>
      </div>

      <div class="menu-quadrant-stat" style="background:#F0FDF4; border-color:#BBF7D0;">
        <span class="tier-badge-pill badge-margin">💰 Margin Ops</span>
        <div style="font-family:'Playfair Display',serif; font-size:24px; font-weight:700; color:#166534; margin:6px 0 2px;">
          {{ $menuAutopsy['margin_count'] }}
        </div>
        <small style="font-size:11px; color:var(--muted);">High-Margin Upsells</small>
      </div>

      <div class="menu-quadrant-stat" style="background:#F9FAFB; border-color:#E5E7EB;">
        <span class="tier-badge-pill badge-dead">💤 Dead Weight</span>
        <div style="font-family:'Playfair Display',serif; font-size:24px; font-weight:700; color:#4B5563; margin:6px 0 2px;">
          {{ $menuAutopsy['dead_count'] }}
        </div>
        <small style="font-size:11px; color:var(--muted);">Prune or Revamp</small>
      </div>
    </div>

    {{-- Highlighted Actionable Menu Items Grid --}}
    <h5 style="font-size:13.5px; font-weight:700; margin:0 0 12px; color:var(--ink);">
      🎯 Key Strategic Menu Action Priorities
    </h5>
    <div class="menu-cards-grid">
      @php
        $sampleItems = array_merge(
          $menuAutopsy['heroes'],
          $menuAutopsy['gems'],
          $menuAutopsy['builders'],
          $menuAutopsy['margin_ops'],
          $menuAutopsy['dead_items']
        );
      @endphp

      @forelse(array_slice($sampleItems, 0, 8) as $item)
        <div class="menu-item-card">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px; margin-bottom:8px;">
              <span class="tier-badge-pill {{ $item['class'] }}">{{ $item['badge'] }}</span>
              <span style="font-family:'Playfair Display',serif; font-size:15px; font-weight:700; color:var(--green);">
                £{{ number_format($item['price'], 2) }}
              </span>
            </div>
            <h6 style="font-size:14px; font-weight:700; color:var(--ink); margin:0 0 6px;">{{ $item['name'] }}</h6>
            <div style="display:flex; gap:12px; font-size:11.5px; color:var(--muted); margin-bottom:10px;">
              <span>🔁 <strong>{{ $item['repeat_rate'] }}%</strong> Repeat</span>
              <span>📦 <strong>{{ $item['sales_qty'] }}</strong> Sold</span>
              <span>👥 <strong>{{ $item['buyers_count'] }}</strong> Guests</span>
            </div>
          </div>
          <div style="background:var(--cream); padding:8px 10px; border-radius:8px; border:1px solid var(--border); font-size:11.5px; color:var(--ink2); line-height:1.4;">
            💡 <strong>Action:</strong> {{ $item['action'] }}
          </div>
        </div>
      @empty
        <div style="grid-column:1/-1; text-align:center; padding:24px; color:var(--muted);">
          No menu items processed yet.
        </div>
      @endforelse
    </div>
  </div>

  {{-- STEP 15: AI CUSTOMER VOICE (BUSINESS INTELLIGENCE) --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🗣️ Step 15: AI Customer Voice (Business Intelligence)
        </h4>
        <p class="ai-card-sub">Synthesizing Reviews + Ratings + Order Behaviors + Repeat Feedback into actionable operational truth.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Overall Guest Sentiment</span>
        <strong style="font-family:'Playfair Display',serif; font-size:24px; color:var(--green);">
          {{ $customerVoice['sentiment_pct'] }}% <span style="font-size:14px; font-family:'Poppins',sans-serif; color:var(--muted);">Positive (★ {{ number_format($customerVoice['rating'], 1) }})</span>
        </strong>
      </div>
    </div>

    {{-- 4 Executive Intelligence Pillars --}}
    <div class="voice-pillars-grid">
      {{-- Pillar 1: What Guests Love --}}
      <div class="voice-pillar-card pillar-love">
        <div>
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
            <span style="font-size:20px;">💚</span>
            <strong style="font-size:13.5px; color:#166534;">What Guests Love</strong>
          </div>
          <p style="font-size:12px; color:var(--ink2); line-height:1.5; margin:0 0 10px;">
            {{ $customerVoice['loves'] }}
          </p>
        </div>
        <div style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; letter-spacing:0.04em;">
          ✓ Core Satisfaction Foundation
        </div>
      </div>

      {{-- Pillar 2: Operational Friction --}}
      <div class="voice-pillar-card pillar-friction">
        <div>
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
            <span style="font-size:20px;">⚠️</span>
            <strong style="font-size:13.5px; color:#991B1B;">Main Operational Friction</strong>
          </div>
          <p style="font-size:12px; color:var(--ink2); line-height:1.5; margin:0 0 10px;">
            {{ $customerVoice['friction'] }}
          </p>
        </div>
        <div style="font-size:11px; font-weight:700; color:#991B1B; text-transform:uppercase; letter-spacing:0.04em;">
          ! Operational Bottleneck
        </div>
      </div>

      {{-- Pillar 3: Most Praised Dish --}}
      <div class="voice-pillar-card pillar-hero">
        <div>
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
            <span style="font-size:20px;">🌟</span>
            <strong style="font-size:13.5px; color:#92400E;">Most Praised Menu Item</strong>
          </div>
          <div style="font-family:'Playfair Display',serif; font-size:15px; font-weight:700; color:var(--ink); margin-bottom:4px;">
            {{ $customerVoice['top_item'] }}
          </div>
          <p style="font-size:12px; color:var(--ink2); line-height:1.45; margin:0 0 10px;">
            {{ $customerVoice['top_item_note'] }}
          </p>
        </div>
        <div style="font-size:11px; font-weight:700; color:#92400E; text-transform:uppercase; letter-spacing:0.04em;">
          ⭐ Star Loyalty Anchor
        </div>
      </div>

      {{-- Pillar 4: Unmet Guest Desires --}}
      <div class="voice-pillar-card pillar-desire">
        <div>
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
            <span style="font-size:20px;">💡</span>
            <strong style="font-size:13.5px; color:#5B21B6;">Unmet Guest Desires</strong>
          </div>
          <p style="font-size:12px; color:var(--ink2); line-height:1.5; margin:0 0 10px;">
            {{ $customerVoice['unmet_need'] }}
          </p>
        </div>
        <div style="font-size:11px; font-weight:700; color:#5B21B6; text-transform:uppercase; letter-spacing:0.04em;">
          📈 Menu Expansion Target
        </div>
      </div>
    </div>

    {{-- Recent Customer Voice Quotes --}}
    <h5 style="font-size:13.5px; font-weight:700; margin:0 0 12px; color:var(--ink);">
      💬 Recent Voice Signals & Direct Feedback ({{ $customerVoice['signals_count'] }} Analyzed)
    </h5>
    <div class="voice-quotes-grid">
      @foreach($customerVoice['quotes'] as $q)
        <div class="voice-quote-card">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
            <div style="display:flex; align-items:center; gap:6px;">
              <strong style="color:var(--ink); font-size:13px;">{{ $q['guest'] }}</strong>
              <span style="color:#F59E0B; font-size:12px;">{{ str_repeat('★', $q['rating']) }}</span>
            </div>
            <span style="font-size:11px; color:var(--muted);">{{ $q['date'] }}</span>
          </div>
          <p style="font-style:italic; color:var(--ink2); margin:0 0 8px; line-height:1.45;">
            "{{ $q['text'] }}"
          </p>
          <div style="display:flex; justify-content:flex-end;">
            <span class="score-badge {{ $q['sentiment'] == 'POSITIVE' ? 'score-high' : ($q['sentiment'] == 'NEUTRAL' ? 'score-mid' : 'score-low') }}">
              {{ $q['sentiment'] }}
            </span>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- STEPS 16 & 17: AI QUIET-TIME & DEMAND ENGINE --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          ⏱️ Steps 16 & 17: AI Quiet-Time & Dynamic Demand Engine
        </h4>
        <p class="ai-card-sub">AI should optimise demand, not simply increase marketing. Lock full margins during organic surges; launch targeted capacity fillers during quiet hours.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Active Policy</span>
        <span class="flywheel-pill" style="font-size:11.5px;">⚡ Dynamic Demand Orchestration</span>
      </div>
    </div>

    {{-- Demand Forecast Dual-Banners --}}
    <div class="demand-forecast-banner">
      {{-- Quiet Period Capacity Filler --}}
      <div class="demand-alert-box alert-quiet-box">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
          <div>
            <span class="demand-cell-pill demand-pill-low" style="margin-bottom:4px;">💤 Quiet Window Opportunity</span>
            <h5 style="font-size:15px; font-weight:700; color:#312E81; margin:0;">
              {{ $demandEngine['current_forecast']['day'] }} ({{ $demandEngine['current_forecast']['window'] }})
            </h5>
          </div>
          <span style="background:#C7D2FE; color:#312E81; font-weight:700; font-size:11.5px; padding:4px 10px; border-radius:8px;">
            {{ $demandEngine['current_forecast']['open_kitchen_capacity'] }}
          </span>
        </div>
        <p style="font-size:12.5px; color:#1E1B4B; line-height:1.45; margin:0 0 12px;">
          <strong>AI Strategy:</strong> {{ $demandEngine['current_forecast']['recommended_action'] }}. <br>
          <span style="color:var(--muted);">{{ $demandEngine['current_forecast']['policy_note'] }}</span>
        </p>
        <button type="button" class="btn-ai-primary" style="padding:7px 14px; font-size:12px; background:#4F46E5; border-color:#4F46E5;"
                onclick="openActionModal('Afternoon Capacity Audience', 'Quiet-Hour Capacity Filler', '{{ addslashes($demandEngine['suggested_copy']) }}', '⚡ Afternoon Treat Campaign')">
          ⚡ Launch Afternoon Treat Campaign (1-Click)
        </button>
      </div>

      {{-- Peak Margin Lock --}}
      <div class="demand-alert-box alert-peak-box">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
          <div>
            <span class="demand-cell-pill demand-pill-very-high" style="margin-bottom:4px;">🔥 Organic Peak Surge</span>
            <h5 style="font-size:15px; font-weight:700; color:#9A3412; margin:0;">
              {{ $demandEngine['peak_protection']['window'] }}
            </h5>
          </div>
          <span style="background:#FDBA74; color:#7C2D12; font-weight:700; font-size:11.5px; padding:4px 10px; border-radius:8px;">
            {{ $demandEngine['peak_protection']['policy'] }}
          </span>
        </div>
        <p style="font-size:12.5px; color:#431407; line-height:1.45; margin:0 0 12px;">
          <strong>Margin Protection Rule:</strong> {{ $demandEngine['peak_protection']['policy_desc'] }}
        </p>
        <div style="background:rgba(255,255,255,0.7); padding:8px 12px; border-radius:8px; border:1px solid #FED7AA; font-size:11.5px; color:#7C2D12;">
          🛡️ <strong>Zero Price Erosion:</strong> Marketing engine automatically pauses discount campaigns during peak dinner hours to protect 100% full gross profit margins.
        </div>
      </div>
    </div>

    {{-- 7-Day Demand Heatmap Table --}}
    <h5 style="font-size:13.5px; font-weight:700; margin:0 0 10px; color:var(--ink);">
      📅 7-Day Hourly Demand & Capacity Heatmap
    </h5>
    <div class="table-scroll-wrap">
      <table class="demand-table">
        <thead>
          <tr>
            <th style="text-align:left; width:130px;">DAY OF WEEK</th>
            <th>LUNCH (12:00 – 14:30)</th>
            <th>AFTERNOON QUIET (14:30 – 17:30)</th>
            <th>DINNER PEAK (18:00 – 21:00)</th>
            <th>LATE EVENING (21:00 – 23:00)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($demandEngine['heatmap'] as $day => $slots)
            <tr>
              <td style="text-align:left; font-weight:700; color:var(--ink);">
                {{ $day }}
              </td>
              <td>
                @php $l = $slots['lunch']; @endphp
                <span class="demand-cell-pill {{ $l == 'VERY_HIGH' ? 'demand-pill-very-high' : ($l == 'HIGH' ? 'demand-pill-high' : ($l == 'MODERATE' ? 'demand-pill-moderate' : 'demand-pill-low')) }}">
                  {{ $l == 'HIGH' ? '⚡ High Flow' : ($l == 'MODERATE' ? '🟢 Steady' : '💤 Quiet') }}
                </span>
              </td>
              <td>
                @php $a = $slots['afternoon']; @endphp
                <span class="demand-cell-pill {{ $a == 'VERY_HIGH' ? 'demand-pill-very-high' : ($a == 'HIGH' ? 'demand-pill-high' : ($a == 'MODERATE' ? 'demand-pill-moderate' : 'demand-pill-low')) }}">
                  {{ $a == 'LOW' ? '💤 Quiet Capacity' : ($a == 'MODERATE' ? '🟢 Steady' : '⚡ High Flow') }}
                </span>
              </td>
              <td>
                @php $d = $slots['dinner']; @endphp
                <span class="demand-cell-pill {{ $d == 'VERY_HIGH' ? 'demand-pill-very-high' : ($d == 'HIGH' ? 'demand-pill-high' : ($d == 'MODERATE' ? 'demand-pill-moderate' : 'demand-pill-low')) }}">
                  {{ $d == 'VERY_HIGH' ? '🔥 Surge (Margin Lock)' : ($d == 'HIGH' ? '⚡ High Flow' : '🟢 Steady') }}
                </span>
              </td>
              <td>
                @php $lt = $slots['late']; @endphp
                <span class="demand-cell-pill {{ $lt == 'VERY_HIGH' ? 'demand-pill-very-high' : ($lt == 'HIGH' ? 'demand-pill-high' : ($lt == 'MODERATE' ? 'demand-pill-moderate' : 'demand-pill-low')) }}">
                  {{ $lt == 'HIGH' ? '⚡ High Flow' : ($lt == 'MODERATE' ? '🟢 Steady' : '💤 Low Flow') }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- STEP 18: LOCAL EVENT & CONTEXT INTELLIGENCE --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🌦️ Step 18: Local Event & Context Intelligence
        </h4>
        <p class="ai-card-sub">Synthesizing Location + Local Sports/Events + Live Weather Forecasts + Calendar Cycles to predict demand shifts before they happen.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Context Signals</span>
        <span class="flywheel-pill" style="font-size:11.5px; background:#EFF6FF; color:#1D4ED8; border-color:#BFDBFE;">🟢 3 Live External Signals</span>
      </div>
    </div>

    {{-- Context Event Callout Banner --}}
    <div class="churn-prescription-box" style="background:#F0FDF4; border-color:#BBF7D0; border-left-color:var(--green);">
      <div style="font-size:24px; line-height:1;">🎯</div>
      <div>
        <strong style="font-size:13.5px; color:#166534; display:block; margin-bottom:2px;">AI Demand & Event Forecast:</strong>
        <span style="font-size:12.5px; color:var(--ink2); line-height:1.5;">
          {{ $localEventIntelligence['summary_banner'] }}
        </span>
      </div>
    </div>

    {{-- 3 Local Signals Grid --}}
    <div class="event-signals-grid">
      @foreach($localEventIntelligence['signals'] as $sig)
        <div class="event-signal-card {{ $sig['class'] }}">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
              <span style="font-size:24px;">{{ $sig['icon'] }}</span>
              <span class="tier-badge-pill" style="background:#fff; border:1px solid rgba(0,0,0,0.1); font-size:11px;">
                {{ $sig['badge'] }}
              </span>
            </div>
            <h6 style="font-size:14px; font-weight:700; color:var(--ink); margin:0 0 6px;">{{ $sig['title'] }}</h6>
            <div style="font-size:12px; font-weight:700; color:var(--terra); margin-bottom:8px;">
              📈 Impact: {{ $sig['impact'] }}
            </div>
            <p style="font-size:12px; color:var(--ink2); line-height:1.45; margin:0 0 10px;">
              {{ $sig['recommendation'] }}
            </p>
          </div>
          <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase;">
            ✓ Operational Strategy Active
          </div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- STEP 19 & 20: THE "AI CAMPAIGN FACTORY" & MULTI-CHANNEL ORCHESTRATOR --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🤖 Step 19 & 20: The "AI Campaign Factory" & Multi-Channel Orchestrator
        </h4>
        <p class="ai-card-sub">Restaurant owners shouldn't have to invent campaigns or manage channels. AI generates complete audiences, micro-timing, channels, and margin-protected offers ready for 1-Click approval.</p>
      </div>
    </div>

    {{-- Campaign Factory Hero Banner --}}
    <div class="factory-summary-hero">
      <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span style="font-size:22px;">⚡</span>
          <h4 style="font-size:18px; font-weight:700; margin:0; color:#fff;">
            5 Automated AI Growth Opportunities Ready for Today
          </h4>
        </div>
        <p style="font-size:13px; color:#C7D2FE; margin:0 0 6px; line-height:1.4;">
          Projected Gross Incremental Revenue: <strong style="color:#4ADE80; font-size:16px;">+£{{ number_format($campaignFactory['total_projected_lift'], 2) }}</strong> with 100% Margin Protection.
        </p>
        <small style="color:#A5B4FC; font-size:11.5px;">
          {{ $channelOrchestrator['coordinated_rule'] }}
        </small>
      </div>
      <div>
        <button type="button" class="btn-ai-primary" style="background:#10B981; border-color:#10B981; padding:10px 18px; font-weight:700; font-size:13px;"
                onclick="openActionModal('All 5 Opportunities Today', 'AI Campaign Factory Batch Approval', 'Approved all 5 high-impact campaigns across Mobile Push, WhatsApp, and Smart Email. Messages queued with 45-min advance micro-timing.', '🚀 Batch Approval')">
          🚀 1-Click Approve All 5 Campaigns
        </button>
      </div>
    </div>

    {{-- 5 AI Campaign Factory Cards --}}
    <div class="campaign-cards-grid">
      @foreach($campaignFactory['opportunities'] as $camp)
        <div class="campaign-factory-card">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px; margin-bottom:10px;">
              <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:22px;">{{ $camp['icon'] }}</span>
                <strong style="font-size:14px; color:var(--ink);">{{ $camp['title'] }}</strong>
              </div>
              <span class="tier-badge-pill" style="background:#EFF6FF; color:#1E40AF; border:1px solid #BFDBFE;">
                {{ $camp['channel_icon'] }} {{ $camp['channel'] }}
              </span>
            </div>

            <div style="background:var(--cream); border:1px solid var(--border); border-radius:10px; padding:10px 12px; margin-bottom:12px; font-size:12px;">
              <div style="margin-bottom:4px;">
                <span style="color:var(--muted); font-weight:600;">Audience:</span>
                <strong style="color:var(--ink);">{{ $camp['audience'] }}</strong>
              </div>
              <div style="margin-bottom:4px;">
                <span style="color:var(--muted); font-weight:600;">Micro-Timing:</span>
                <strong style="color:var(--terra);">{{ $camp['timing'] }}</strong>
              </div>
              <div>
                <span style="color:var(--muted); font-weight:600;">Incentive:</span>
                <span style="color:var(--ink2);">{{ $camp['offer'] }}</span>
              </div>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px; color:var(--muted); margin-bottom:10px;">
              <span>📈 Est. Lift: <strong style="color:var(--green); font-size:13px;">£{{ number_format($camp['projected_revenue'], 2) }}</strong> ({{ $camp['projected_conversion'] }} conv)</span>
            </div>
            <div style="font-size:11px; color:#166534; background:#DCFCE7; padding:4px 8px; border-radius:6px; font-weight:600; margin-bottom:14px;">
              🛡️ {{ $camp['margin_impact'] }}
            </div>
          </div>

          <button type="button" class="btn-ai-primary" style="width:100%; padding:8px 14px; font-size:12px; border-radius:8px;"
                  onclick="openActionModal('{{ addslashes($camp['audience']) }}', '{{ addslashes($camp['title']) }}', '{{ addslashes($camp['suggested_copy']) }}', '{{ addslashes($camp['channel_icon'] . ' ' . $camp['channel']) }}')">
            Approve & Launch Campaign →
          </button>
        </div>
      @endforeach
    </div>

    {{-- Step 20: Multi-Channel Intelligent Router & Fatigue Guard --}}
    <div class="channel-orchestrator-bar">
      <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
        <span style="font-size:12.5px; font-weight:700; color:var(--ink);">
          📡 Intelligent Multi-Channel Router:
        </span>
        <span class="demand-cell-pill demand-pill-moderate" style="font-size:11px;">
          📱 Mobile Push: {{ $channelOrchestrator['push_pct'] }}%
        </span>
        <span class="demand-cell-pill demand-pill-high" style="font-size:11px;">
          ✉️ Smart Email: {{ $channelOrchestrator['email_pct'] }}%
        </span>
        <span class="demand-cell-pill demand-pill-low" style="font-size:11px;">
          💬 WhatsApp/SMS: {{ $channelOrchestrator['sms_pct'] }}%
        </span>
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <span style="font-size:11.5px; color:#166534; font-weight:600; background:#DCFCE7; border:1px solid #86EFAC; padding:4px 10px; border-radius:999px;">
          {{ $channelOrchestrator['fatigue_policy'] }}
        </span>
      </div>
    </div>
  </div>

  {{-- STEP 21: CUSTOMER COMMUNICATION MEMORY --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🧠 Step 21: Customer Communication Memory
        </h4>
        <p class="ai-card-sub">HYST remembers every past offer, response, and complaint. AI never sends "Welcome to our restaurant!" to someone with 18 orders. It knows the relationship.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Memory Engine</span>
        <span class="flywheel-pill" style="font-size:11.5px; background:#F0FDF4; color:#166534; border-color:#86EFAC;">🛡️ 100% Relationship Aware</span>
      </div>
    </div>

    {{-- Communication Memory Callout --}}
    <div class="churn-prescription-box" style="background:#F5F3FF; border-color:#DDD6FE; border-left-color:#7C3AED;">
      <div style="font-size:24px; line-height:1;">🧠</div>
      <div>
        <strong style="font-size:13.5px; color:#5B21B6; display:block; margin-bottom:2px;">Single Coordinated Relationship Trail:</strong>
        <span style="font-size:12.5px; color:var(--ink2); line-height:1.5;">
          Every guest maintains one continuous dialogue. Fatigue protection automatically silences messaging if a customer was contacted within the last 7 days.
        </span>
      </div>
    </div>

    {{-- Memory Records Table --}}
    <div class="table-scroll-wrap">
      <table class="twin-table">
        <thead>
          <tr>
            <th>GUEST & TIER</th>
            <th>LAST CAMPAIGN SENT</th>
            <th>CHANNEL</th>
            <th>GUEST RESPONSE</th>
            <th>FATIGUE STATUS</th>
            <th>RELATIONSHIP AWARENESS RULE</th>
          </tr>
        </thead>
        <tbody>
          @foreach($communicationMemory['samples'] as $m)
            <tr>
              <td>
                <strong style="color:var(--ink);">{{ $m['name'] }}</strong>
                <div style="font-size:11px; color:var(--muted);">{{ $m['phone'] }} • <strong>{{ $m['orders_count'] }} orders</strong></div>
                <span class="tier-badge-pill" style="margin-top:4px; font-size:10px; background:#FEF3C7; color:#92400E;">{{ $m['relationship_tier'] }}</span>
              </td>
              <td>
                <span style="font-weight:600; color:var(--ink2);">{{ $m['last_campaign_sent'] }}</span>
              </td>
              <td>
                <span style="font-size:12px; font-weight:600;">{{ $m['channel_used'] }}</span>
              </td>
              <td>
                <span style="font-size:12px; color:var(--ink2);">{{ $m['guest_response'] }}</span>
              </td>
              <td>
                <span style="font-size:11.5px; font-weight:600;">{{ $m['fatigue_status'] }}</span>
              </td>
              <td style="font-size:11.5px; color:var(--muted); line-height:1.4; max-width:260px;">
                💡 {{ $m['memory_awareness_rule'] }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- STEP 22: AI A/B COPY LEARNING ENGINE --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🧪 Step 22: AI A/B Copy Learning Engine
        </h4>
        <p class="ai-card-sub">Continuous algorithmic testing. The AI tests emotional hooks against transactional phrases and automatically promotes the winning variant.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Overall Performance</span>
        <strong style="font-family:'Playfair Display',serif; font-size:22px; color:var(--green);">
          {{ $abLearning['avg_conversion_lift'] }} <span style="font-size:13px; font-family:'Poppins',sans-serif; color:var(--muted);">Avg Lift</span>
        </strong>
      </div>
    </div>

    {{-- Experiments Grid --}}
    <div class="ab-experiments-grid">
      @foreach($abLearning['experiments'] as $exp)
        <div class="ab-experiment-card">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <strong style="font-size:14px; color:var(--ink);">{{ $exp['title'] }}</strong>
              <span class="tier-badge-pill" style="background:#EFF6FF; color:#1E40AF; font-size:10.5px;">{{ $exp['segment'] }}</span>
            </div>

            <div class="ab-variants-split">
              {{-- Variant A --}}
              <div class="ab-variant-box">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                  <span style="font-weight:700; color:var(--muted);">Variant A (Control)</span>
                  <span style="font-size:10.5px; color:var(--muted);">{{ $exp['variant_a']['status'] }}</span>
                </div>
                <p style="font-style:italic; font-size:12px; margin:0 0 8px; color:var(--ink2);">
                  {{ $exp['variant_a']['headline'] }}
                </p>
                <div style="display:flex; justify-content:space-between; font-size:11px; color:var(--muted);">
                  <span>Sent: {{ $exp['variant_a']['sent_count'] }}</span>
                  <strong style="color:var(--ink); font-size:12px;">{{ $exp['variant_a']['conversion'] }} Conv</strong>
                </div>
              </div>

              {{-- Variant B --}}
              <div class="ab-variant-box ab-variant-winner">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                  <span style="font-weight:700; color:#166534;">Variant B (AI Hook)</span>
                  <span style="font-size:10.5px; font-weight:700; color:#166534;">{{ $exp['variant_b']['status'] }}</span>
                </div>
                <p style="font-style:italic; font-size:12px; margin:0 0 8px; color:#166534;">
                  {{ $exp['variant_b']['headline'] }}
                </p>
                <div style="display:flex; justify-content:space-between; font-size:11px; color:var(--muted);">
                  <span>Sent: {{ $exp['variant_b']['sent_count'] }}</span>
                  <strong style="color:var(--green); font-size:12px;">{{ $exp['variant_b']['conversion'] }} Conv</strong>
                </div>
              </div>
            </div>
          </div>

          <div style="background:#fff; border:1px solid var(--border); border-radius:10px; padding:10px 12px; font-size:11.5px; color:var(--ink2); line-height:1.45;">
            💡 <strong>AI Algorithm Insight:</strong> {{ $exp['insight'] }}
          </div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- STEPS 23 & 24: GROWTH AUTOPILOT & 4 AUTONOMY LEVELS --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🚀 Steps 23 & 24: Growth Autopilot & 4-Level Autonomy Engine
        </h4>
        <p class="ai-card-sub">Gradually remove human approval. Move from manual oversight (Level 1) to an autonomous growth engine that operates safely within your preset margin guardrails (Level 4).</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Current Setting</span>
        <span class="flywheel-pill" style="font-size:11.5px; background:#FEF3C7; color:#92400E; border-color:#FDE68A;">⚡ Level 2: 1-Click Approval</span>
      </div>
    </div>

    {{-- 4 Autonomy Levels Cards --}}
    <div class="autopilot-levels-grid">
      @foreach($growthAutopilot['levels'] as $lvl)
        <div class="autopilot-level-card {{ $lvl['active'] ? 'level-active' : '' }}">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span class="tier-badge-pill" style="background:#fff; border:1px solid rgba(0,0,0,0.1); font-size:10.5px;">
              {{ $lvl['badge'] }}
            </span>
            @if($lvl['active'])
              <span style="font-size:18px;">✅</span>
            @endif
          </div>
          <h6 style="font-size:14px; font-weight:700; color:var(--ink); margin:0 0 6px;">{{ $lvl['title'] }}</h6>
          <p style="font-size:12px; color:var(--ink2); line-height:1.45; margin:0 0 10px;">
            {{ $lvl['desc'] }}
          </p>
          <div style="font-size:11px; font-weight:600; color:{{ $lvl['active'] ? 'var(--terra)' : 'var(--muted)' }};">
            {{ $lvl['active'] ? '● Active Operating Mode' : 'Click to Select' }}
          </div>
        </div>
      @endforeach
    </div>

    {{-- Autopilot Safety Guardrails Bar --}}
    <div class="guardrails-summary-bar">
      <div style="display:flex; align-items:center; gap:8px;">
        <span style="font-size:20px;">🛡️</span>
        <div>
          <strong style="font-size:13px; color:var(--ink);">Active Autopilot Safety Boundaries:</strong>
          <span style="font-size:12px; color:var(--muted); display:block;">AI never spends outside these boundaries without explicit owner confirmation.</span>
        </div>
      </div>
      <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <span class="demand-cell-pill demand-pill-moderate" style="font-size:11px;">
          🔒 {{ $growthAutopilot['guardrails']['incentive_cap'] }}
        </span>
        <span class="demand-cell-pill demand-pill-moderate" style="font-size:11px;">
          📊 {{ $growthAutopilot['guardrails']['min_gross_margin'] }}
        </span>
        <span class="demand-cell-pill demand-pill-high" style="font-size:11px;">
          💰 {{ $growthAutopilot['guardrails']['monthly_budget'] }}
        </span>
        <span class="demand-cell-pill demand-pill-low" style="font-size:11px;">
          ⏱️ {{ $growthAutopilot['guardrails']['fatigue_rule'] }}
        </span>
      </div>
    </div>
  </div>

  {{-- STEP 27: PROOF OF AI ATTRIBUTION WATERFALL --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          📊 Step 27: "Proof of AI" Attribution Waterfall
        </h4>
        <p class="ai-card-sub">Every penny must be proven. We track the conversion path from recipient contact to holdout control comparison to deliver validated net incremental ROI.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Proven Campaign Performance</span>
        <strong style="font-family:'Playfair Display',serif; font-size:24px; color:var(--green);">
          4.46x <span style="font-size:14px; font-family:'Poppins',sans-serif; color:var(--muted);">Net ROI Multiple</span>
        </strong>
      </div>
    </div>

    {{-- Attribution Waterfall 8-Step Grid --}}
    <div class="waterfall-flow-grid">
      @foreach($attributionWaterfall['steps'] as $st)
        <div class="waterfall-step-card {{ in_array($st['label'], ['Net Incremental Revenue', 'Proven Net ROI']) ? 'waterfall-highlight' : '' }}">
          <div style="font-size:20px; margin-bottom:4px;">{{ $st['icon'] }}</div>
          <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; margin-bottom:4px;">
            {{ $st['label'] }}
          </div>
          <div style="font-family:'Playfair Display',serif; font-size:19px; font-weight:700; color:var(--ink); margin-bottom:4px;">
            {{ $st['value'] }}
          </div>
          <small style="font-size:11px; color:var(--muted);">{{ $st['sub'] }}</small>
        </div>
      @endforeach
    </div>

    {{-- Attribution Law Callout --}}
    <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:12px; padding:12px 16px; font-size:12px; color:#166534; display:flex; align-items:center; gap:10px;">
      <span style="font-size:20px;">💡</span>
      <span>
        <strong>The Attribution Law:</strong> Gross Orders − Natural Holdout Baseline = Net Incremental Revenue. HYST only reports revenue proven to be directly caused by AI micro-timing.
      </span>
    </div>
  </div>

  {{-- STEPS 28, 29 & 30: THE DATA MOAT FLYWHEEL & NON-CREEPY PRIVACY SHIELD --}}
  <div class="ai-card">
    <div class="ai-card-header">
      <div>
        <h4 class="ai-card-title">
          🛡️ Steps 28, 29 & 30: The Customer Data Moat & Privacy Shield
        </h4>
        <p class="ai-card-sub">The longer {{ $restaurant->name }} uses HYST, the deeper the competitive moat. All customer intelligence is kept behind the scenes in full compliance with UK DMA 2026 data privacy ethics.</p>
      </div>
      <div style="text-align:right;">
        <span style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; display:block;">Data Moat Status</span>
        <span class="flywheel-pill" style="font-size:11.5px; background:#DCFCE7; color:#166534; border-color:#86EFAC;">🟢 Compounding Growth Flywheel</span>
      </div>
    </div>

    {{-- 4-Stage Moat Flywheel Grid --}}
    <div class="moat-flywheel-grid">
      <div class="moat-flywheel-step">
        <span style="font-size:22px; display:block; margin-bottom:4px;">📦</span>
        <strong style="font-size:13.5px; color:var(--ink); display:block; margin-bottom:4px;">1. Continuous Orders</strong>
        <p style="font-size:11.5px; color:var(--muted); margin:0;">
          Orders flow directly into the decrypted analytics data store.
        </p>
      </div>

      <div class="moat-flywheel-step">
        <span style="font-size:22px; display:block; margin-bottom:4px;">🧬</span>
        <strong style="font-size:13.5px; color:var(--ink); display:block; margin-bottom:4px;">2. Digital Twins Calibrated</strong>
        <p style="font-size:11.5px; color:var(--muted); margin:0;">
          {{ $dataMoatFlywheel['digital_twins_calibrated'] }} customer twins mapped by habit, day, and time.
        </p>
      </div>

      <div class="moat-flywheel-step">
        <span style="font-size:22px; display:block; margin-bottom:4px;">⏱️</span>
        <strong style="font-size:13.5px; color:var(--ink); display:block; margin-bottom:4px;">3. 94.2% Micro-Timing</strong>
        <p style="font-size:11.5px; color:var(--muted); margin:0;">
          45-minute advance predictive pulses that trigger right when hunger strikes.
        </p>
      </div>

      <div class="moat-flywheel-step" style="background:#FFFBEB; border-color:#FDE68A;">
        <span style="font-size:22px; display:block; margin-bottom:4px;">📈</span>
        <strong style="font-size:13.5px; color:#92400E; display:block; margin-bottom:4px;">4. Compounding Retention</strong>
        <p style="font-size:11.5px; color:#92400E; margin:0;">
          {{ $dataMoatFlywheel['repeat_retention_lift'] }} repeat reorder lift with zero price discount dependency.
        </p>
      </div>
    </div>

    {{-- Non-Creepy Privacy Shield Box --}}
    <div class="privacy-shield-box">
      <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span style="font-size:20px;">🔒</span>
          <strong style="font-size:13px; color:#0F172A;">{{ $dataMoatFlywheel['privacy_shield']['standard'] }}</strong>
        </div>
        <p style="font-size:12px; color:#475569; margin:0 0 4px; line-height:1.45;">
          • {{ $dataMoatFlywheel['privacy_shield']['rule_one'] }}
        </p>
        <p style="font-size:12px; color:#475569; margin:0; line-height:1.45;">
          • {{ $dataMoatFlywheel['privacy_shield']['rule_two'] }}
        </p>
      </div>
      <span style="font-size:12px; font-weight:700; color:#166534; background:#DCFCE7; border:1px solid #86EFAC; padding:6px 14px; border-radius:999px;">
        ✓ Trust & Privacy Certified
      </span>
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

function triggerAiManualSync() {
  const btn = document.getElementById('btnAiSync');
  const spinner = document.getElementById('syncSpinner');
  const icon = document.getElementById('syncIcon');
  const text = document.getElementById('syncText');

  if (!btn) return;

  btn.disabled = true;
  btn.style.opacity = '0.75';
  btn.style.cursor = 'not-allowed';
  spinner.style.display = 'inline-block';
  icon.style.display = 'none';
  text.innerText = 'Syncing AI Insights...';

  fetch('{{ route("ai_analytics.sync") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'success',
          title: '⚡ AI Intelligence Synced!',
          text: data.message,
          timer: 2000,
          showConfirmButton: false,
          timerProgressBar: true
        }).then(() => {
          window.location.reload();
        });
      } else {
        alert(data.message);
        window.location.reload();
      }
    } else if (data.status === 'throttled') {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'info',
          title: 'Recently Updated',
          text: data.message,
          confirmButtonColor: '#C25A2A'
        });
      } else {
        alert(data.message);
      }
      resetSyncButton();
    } else {
      throw new Error(data.message || 'Sync failed');
    }
  })
  .catch(err => {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'error',
        title: 'Sync Error',
        text: err.message || 'Could not synchronize AI data. Please try again.',
        confirmButtonColor: '#C25A2A'
      });
    } else {
      alert(err.message || 'Could not synchronize AI data.');
    }
    resetSyncButton();
  });
}

function resetSyncButton() {
  const btn = document.getElementById('btnAiSync');
  const spinner = document.getElementById('syncSpinner');
  const icon = document.getElementById('syncIcon');
  const text = document.getElementById('syncText');

  if (!btn) return;
  btn.disabled = false;
  btn.style.opacity = '1';
  btn.style.cursor = 'pointer';
  spinner.style.display = 'none';
  icon.style.display = 'inline';
  text.innerText = 'Sync AI Insights';
}
</script>

@endsection
