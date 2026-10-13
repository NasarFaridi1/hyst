@extends('layouts.app')
@section('content')

<style>
    :root {
      --cream:     #F6F1E8;
      --cream2:    #EDE5D4;
      --terra:     #C25A2A;
      --terra-l:   #D97040;
      --terra-d:   #8C3D1A;
      --terra-bg:  rgba(194,90,42,0.08);
      --ink:       #1A1208;
      --ink2:      #2E2318;
      --muted:     #8A7A62;
      --green:     #15803D;
      --green-bg:  rgba(21,128,61,0.1);
      --red:       #B91C1C;
      --red-bg:    rgba(185,28,28,0.1);
      --blue:      #1D4ED8;
      --blue-bg:   rgba(29,78,216,0.1);
      --border:    rgba(194,90,42,0.14);
      --shadow:    0 4px 20px rgba(26,18,8,0.06);
      --shadow-lg: 0 10px 30px rgba(26,18,8,0.10);
    }

    .ai-page {
      padding: 30px;
      background: var(--cream);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
    }

    .ai-header {
      margin-bottom: 25px;
    }

    .ai-eyebrow {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--terra);
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--terra-bg);
      padding: 5px 12px;
      border-radius: 20px;
    }

    .ai-title {
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      font-weight: 700;
      color: var(--ink);
      margin: 8px 0 4px;
    }

    .ai-title span {
      color: var(--terra);
    }

    .ai-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 24px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
      transition: all 0.2s ease;
    }

    .opportunity-hero {
      background: linear-gradient(135deg, #2E2318 0%, #1A1208 100%);
      color: #fff;
      border-radius: 20px;
      padding: 28px;
      margin-bottom: 24px;
      box-shadow: var(--shadow-lg);
      position: relative;
      overflow: hidden;
    }

    .opportunity-hero::after {
      content: '🧠';
      position: absolute;
      right: 25px;
      bottom: -15px;
      font-size: 110px;
      opacity: 0.08;
    }

    .metric-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    @media(max-width: 992px) {
      .metric-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media(max-width: 576px) {
      .metric-grid { grid-template-columns: 1fr; }
    }

    .metric-box {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 20px;
      box-shadow: var(--shadow);
      position: relative;
    }

    .metric-box .label {
      font-size: 12px;
      font-weight: 600;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .metric-box .value {
      font-size: 28px;
      font-weight: 700;
      margin: 6px 0 2px;
      font-family: 'Playfair Display', serif;
    }

    .action-card {
      border: 1px solid var(--border);
      border-radius: 16px;
      background: var(--cream);
      padding: 20px;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .action-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow);
    }

    .funnel-bar {
      display: flex;
      background: var(--cream2);
      border-radius: 12px;
      overflow: hidden;
      margin-top: 14px;
      border: 1px solid var(--border);
    }

    .funnel-segment {
      padding: 10px 14px;
      text-align: center;
      flex: 1;
      border-right: 1px solid rgba(0,0,0,0.06);
      background: #fff;
    }

    .funnel-segment:last-child {
      border-right: none;
    }

    .twin-table th {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--muted);
      background: #FAFAFA;
      padding: 14px 12px;
      border-bottom: 2px solid var(--border);
    }

    .twin-table td {
      padding: 14px 12px;
      vertical-align: middle;
      font-size: 13px;
      border-bottom: 1px solid var(--border);
    }

    .score-badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 700;
    }

    .score-high { background: #DCFCE7; color: #15803D; }
    .score-mid  { background: #FEF3C7; color: #B45309; }
    .score-low  { background: #FEE2E2; color: #B91C1C; }

    .filter-pill {
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      color: var(--muted);
      background: #fff;
      border: 1px solid var(--border);
      transition: all 0.2s ease;
    }

    .filter-pill.active {
      background: var(--terra);
      color: #fff;
      border-color: var(--terra);
      box-shadow: 0 4px 12px rgba(194,90,42,0.3);
    }
</style>

<div class="ai-page">

  {{-- Page Header --}}
  <div class="ai-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
      <div class="ai-eyebrow">
        <span>✨</span> HYST AI CUSTOMER GROWTH ENGINE
      </div>
      <h1 class="ai-title">{{ $restaurant->name ?? 'Restaurant' }} <span>AI Analytics</span></h1>
      <p class="text-muted mb-0" style="font-size:14px;">
        Real-time intelligence connecting Orders → Patterns → Predictions → Next Best Actions.
      </p>
    </div>
    <div>
      <a href="{{ url('/restaurant/dashboard') }}" class="btn btn-outline-secondary" style="border-radius:10px; font-weight:600; font-size:13px;">
        ← Back to Dashboard
      </a>
      <button onclick="window.location.reload();" class="btn" style="background:var(--terra); color:#fff; border-radius:10px; font-weight:600; font-size:13px;">
        ↻ Refresh AI Insights
      </button>
    </div>
  </div>

  {{-- STEP 26: REVENUE OPPORTUNITY BOARD (HERO) --}}
  <div class="opportunity-hero">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <span style="font-size:12px; font-weight:700; letter-spacing:0.1em; color:#E0D5C0; text-transform:uppercase;">
          💰 STEP 26 — REVENUE OPPORTUNITY BOARD
        </span>
        <h2 style="font-family:'Playfair Display', serif; font-size:36px; margin:6px 0 10px; font-weight:700;">
          Potential Opportunity Today: <span style="color:#4ADE80;">£{{ number_format($totalPotentialToday, 2) }}</span>
        </h2>
        <p style="color:#C5BDB0; font-size:14px; margin-bottom:0; max-width:650px;">
          HYST AI analyzes previous order intervals, typical order days, and basket compositions to identify exactly who is ready to buy today.
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <span class="badge" style="background:rgba(74,222,128,0.2); color:#4ADE80; font-size:13px; padding:8px 14px; border-radius:8px;">
          🟢 Active Growth Flywheel
        </span>
      </div>
    </div>
  </div>

  {{-- 4 Metric Cards --}}
  <div class="metric-grid">
    <div class="metric-box">
      <div class="label">🟢 Ready to Reorder</div>
      <div class="value" style="color:var(--green);">{{ $reorderReadyCount }} <span style="font-size:15px; color:var(--muted); font-family:sans-serif;">Cust</span></div>
      <small class="text-muted">Potential: <strong>£{{ number_format($reorderReadyPotential, 2) }}</strong></small>
    </div>

    <div class="metric-box">
      <div class="label">⚠️ At Risk (Churn Warning)</div>
      <div class="value" style="color:#D97706;">{{ $atRiskCount }} <span style="font-size:15px; color:var(--muted); font-family:sans-serif;">Cust</span></div>
      <small class="text-muted">Potential: <strong>£{{ number_format($atRiskPotential, 2) }}</strong></small>
    </div>

    <div class="metric-box">
      <div class="label">⭐ VIP Inactive</div>
      <div class="value" style="color:var(--terra);">{{ $vipInactiveCount }} <span style="font-size:15px; color:var(--muted); font-family:sans-serif;">Cust</span></div>
      <small class="text-muted">Potential: <strong>£{{ number_format($vipInactivePotential, 2) }}</strong></small>
    </div>

    <div class="metric-box">
      <div class="label">🚀 Upsell Candidates</div>
      <div class="value" style="color:var(--blue);">{{ $upsellCount }} <span style="font-size:15px; color:var(--muted); font-family:sans-serif;">Cust</span></div>
      <small class="text-muted">Potential: <strong>£{{ number_format($upsellPotential, 2) }}</strong></small>
    </div>
  </div>

  {{-- STEP 4 & 25: NEXT BEST ACTION (WHO TO CONTACT TODAY) --}}
  <div class="ai-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h4 style="font-family:'Playfair Display', serif; font-size:24px; margin:0; font-weight:700;">
          🤖 Next Best Action — Who should you contact today?
        </h4>
        <p class="text-muted mb-0" style="font-size:13px;">High-conviction recommendations drafted by HYST AI to protect margin and drive repeat orders.</p>
      </div>
      <span class="badge" style="background:var(--terra-bg); color:var(--terra); padding:8px 14px; border-radius:10px; font-weight:700;">
        {{ count($nextBestActions) }} Priority Actions
      </span>
    </div>

    <div class="row g-3">
      @forelse($nextBestActions as $idx => $act)
        <div class="col-lg-4 col-md-6">
          <div class="action-card">
            <div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge {{ $act['badge_class'] }} px-2 py-1" style="font-size:11px;">
                  {{ $act['category'] }}
                </span>
                <span style="font-weight:700; color:var(--green); font-size:14px;">
                  +£{{ number_format($act['potential'], 2) }}
                </span>
              </div>
              <h5 style="font-weight:700; margin-bottom:4px; color:var(--ink);">{{ $act['customer'] }}</h5>
              <p style="font-size:12px; color:var(--muted); margin-bottom:10px;">{{ $act['headline'] }}</p>
              
              <div style="background:#fff; border:1px solid var(--border); border-radius:10px; padding:12px; font-size:12px; margin-bottom:14px;">
                <div style="font-weight:700; color:var(--terra); margin-bottom:4px;">💡 AI Recommendation:</div>
                <div style="color:var(--ink2);">{{ $act['recommendation'] }}</div>
              </div>
            </div>

            <button type="button" class="btn w-100" 
                    style="background:var(--terra); color:#fff; border-radius:10px; font-weight:600; font-size:13px;"
                    onclick="openActionModal('{{ addslashes($act['customer']) }}', '{{ addslashes($act['action_label']) }}', '{{ addslashes($act['suggested_copy']) }}')">
              {{ $act['action_label'] }} ➔
            </button>
          </div>
        </div>
      @empty
        <div class="col-12 py-4 text-center text-muted">
          No urgent actions required today. All customers are in healthy order cycles!
        </div>
      @endforelse
    </div>
  </div>

  {{-- STEP 12 & 15: CUSTOMER RELATIONSHIP FUNNEL --}}
  <div class="ai-card">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h4 style="font-family:'Playfair Display', serif; font-size:22px; margin:0; font-weight:700;">
        📊 Customer Relationship Lifecycle Funnel
      </h4>
      <span class="text-muted" style="font-size:12px;">Active Restaurant Base: {{ count($digitalTwins) }} Customers</span>
    </div>
    <p class="text-muted mb-3" style="font-size:13px;">Tracking customer progression through the $1 \rightarrow 2$ order engine to Regular, Loyal, and VIP status.</p>

    <div class="funnel-bar">
      <div class="funnel-segment">
        <small class="text-muted d-block">NEW</small>
        <strong style="font-size:18px;">{{ $funnel['new'] }}</strong>
      </div>
      <div class="funnel-segment" style="background:#FEF3C7;">
        <small class="text-warning-emphasis d-block fw-bold">1 → 2 ORDER</small>
        <strong style="font-size:18px; color:#B45309;">{{ $funnel['second_order'] }}</strong>
      </div>
      <div class="funnel-segment">
        <small class="text-muted d-block">REGULAR</small>
        <strong style="font-size:18px;">{{ $funnel['regular'] }}</strong>
      </div>
      <div class="funnel-segment">
        <small class="text-muted d-block">LOYAL</small>
        <strong style="font-size:18px;">{{ $funnel['loyal'] }}</strong>
      </div>
      <div class="funnel-segment" style="background:#DCFCE7;">
        <small class="text-success-emphasis d-block fw-bold">VIP</small>
        <strong style="font-size:18px; color:#15803D;">{{ $funnel['vip'] }}</strong>
      </div>
      <div class="funnel-segment">
        <small class="text-muted d-block">AT RISK</small>
        <strong style="font-size:18px; color:#B91C1C;">{{ $funnel['at_risk'] }}</strong>
      </div>
      <div class="funnel-segment">
        <small class="text-muted d-block">DORMANT</small>
        <strong style="font-size:18px; color:var(--muted);">{{ $funnel['dormant'] }}</strong>
      </div>
    </div>
  </div>

  {{-- STEP 1, 2 & 5: CUSTOMER DIGITAL TWINS & 7 OPPORTUNITY SCORES --}}
  <div class="ai-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
      <div>
        <h4 style="font-family:'Playfair Display', serif; font-size:22px; margin:0; font-weight:700;">
          🧬 Customer Digital Twin Explorer
        </h4>
        <p class="text-muted mb-0" style="font-size:13px;">Don't just store what they bought — store habits, reorder windows, and the 7 Opportunity Scores.</p>
      </div>

      {{-- Filters --}}
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ url('/restaurant/ai-analytics?filter=all') }}" class="filter-pill {{ $filter == 'all' ? 'active' : '' }}">All ({{ count($digitalTwins) }})</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=reorder_ready') }}" class="filter-pill {{ $filter == 'reorder_ready' ? 'active' : '' }}">🟢 Reorder Ready</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=at_risk') }}" class="filter-pill {{ $filter == 'at_risk' ? 'active' : '' }}">⚠️ At Risk</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=vip') }}" class="filter-pill {{ $filter == 'vip' ? 'active' : '' }}">⭐ VIP</a>
        <a href="{{ url('/restaurant/ai-analytics?filter=dormant') }}" class="filter-pill {{ $filter == 'dormant' ? 'active' : '' }}">💤 Dormant</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table twin-table align-middle">
        <thead>
          <tr>
            <th>CUSTOMER</th>
            <th>ORDERS & BASKET</th>
            <th>FAVOURITE HABIT</th>
            <th>REORDER WINDOW</th>
            <th>THE 7 AI SCORES</th>
            <th>STATUS</th>
            <th class="text-end">ACTION</th>
          </tr>
        </thead>
        <tbody>
          @forelse($filteredTwins as $t)
            <tr>
              <td>
                <div style="font-weight:700; color:var(--ink);">{{ $t['name'] }}</div>
                <small class="text-muted">{{ $t['phone'] ?: $t['email'] }}</small>
              </td>
              <td>
                <div><strong>{{ $t['orders_count'] }}</strong> orders</div>
                <small class="text-muted">AOV: £{{ number_format($t['average_order_value'], 2) }}</small>
              </td>
              <td>
                <div style="font-weight:600; color:var(--terra);">{{ $t['favourite_food'] }}</div>
                <small class="text-muted">{{ $t['typical_day'] }} ({{ $t['typical_time'] }})</small>
              </td>
              <td>
                <div>Every <strong>{{ $t['typical_interval'] }}</strong> days</div>
                <small class="text-muted">Last: {{ $t['last_order_days'] }} days ago</small>
              </td>
              <td>
                <div class="d-flex gap-1 flex-wrap">
                  <span class="score-badge {{ $t['scores']['reorder'] >= 75 ? 'score-high' : 'score-mid' }}" title="Reorder Score">
                    Reorder: {{ $t['scores']['reorder'] }}%
                  </span>
                  <span class="score-badge {{ $t['scores']['churn'] >= 70 ? 'score-low' : 'score-high' }}" title="Churn Score">
                    Churn: {{ $t['scores']['churn'] }}%
                  </span>
                  <span class="score-badge score-mid" title="Offer Sensitivity">
                    Sens: {{ $t['scores']['offer_sensitivity'] }}
                  </span>
                </div>
              </td>
              <td>
                <span class="badge {{ $t['current_status'] == 'REORDER READY' ? 'bg-success' : ($t['current_status'] == 'AT RISK' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                  {{ $t['current_status'] }}
                </span>
              </td>
              <td class="text-end">
                <button type="button" class="btn btn-sm btn-outline-dark" style="border-radius:8px; font-size:12px; font-weight:600;"
                        onclick="showDigitalTwinModal({{ json_encode($t) }})">
                  View Twin 🧬
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                No customers match the selected filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- MODAL 1: ACTION SENDER (PREVIEW & SEND) --}}
<div class="modal fade" id="actionModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:18px; border:1px solid var(--border);">
      <div class="modal-header" style="border-bottom:1px solid var(--border); background:var(--cream);">
        <h5 class="modal-title" id="actionModalTitle" style="font-family:'Playfair Display', serif; font-weight:700;">Create Campaign</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <label class="form-label text-muted small fw-bold">RECIPIENT</label>
        <p id="actionCustomerName" class="fw-bold fs-6 mb-3"></p>

        <label class="form-label text-muted small fw-bold">PRE-DRAFTED AI MESSAGE (NON-CREEPY & MARGIN SAFE)</label>
        <textarea id="actionMessageBody" class="form-control mb-3" rows="3" style="border-radius:10px;"></textarea>

        <div class="alert alert-info py-2 px-3 small mb-0" style="border-radius:10px;">
          🔒 <strong>Step 29 Rule Applied:</strong> The AI uses contextual reminders instead of creepy stats ("Friday again?" instead of "We know you order every 8.4 days").
        </div>
      </div>
      <div class="modal-footer" style="border-top:1px solid var(--border);">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cancel</button>
        <button type="button" class="btn" style="background:var(--terra); color:#fff; border-radius:10px; font-weight:600;" onclick="simulateSend()">
          Send via Push & SMS 🚀
        </button>
      </div>
    </div>
  </div>
</div>

{{-- MODAL 2: FULL CUSTOMER DIGITAL TWIN INSPECTOR (SARAH'S PROFILE) --}}
<div class="modal fade" id="twinModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; border:1px solid var(--border); overflow:hidden;">
      <div class="modal-header text-white" style="background:var(--terra); border:none; padding:20px;">
        <div>
          <span style="font-size:11px; text-transform:uppercase; letter-spacing:1px; opacity:0.85;">STEP 2 — CUSTOMER DIGITAL TWIN</span>
          <h4 class="modal-title fw-bold" id="twinName">Customer</h4>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4" style="background:#FAFAFA;">
        
        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:16px;">
              <small class="text-muted d-block">ORDERS</small>
              <h4 class="fw-bold mb-0" id="twinOrders">0</h4>
            </div>
          </div>
          <div class="col-md-3">
            <div style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:16px;">
              <small class="text-muted d-block">AVERAGE BASKET</small>
              <h4 class="fw-bold mb-0" id="twinAov">£0.00</h4>
            </div>
          </div>
          <div class="col-md-3">
            <div style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:16px;">
              <small class="text-muted d-block">TYPICAL INTERVAL</small>
              <h4 class="fw-bold mb-0" id="twinInterval">0 days</h4>
            </div>
          </div>
          <div class="col-md-3">
            <div style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:16px;">
              <small class="text-muted d-block">CURRENT STATUS</small>
              <h5 class="fw-bold mb-0 text-success" id="twinStatus">REORDER READY</h5>
            </div>
          </div>
        </div>

        <div class="card mb-3" style="border-radius:14px; border:1px solid var(--border);">
          <div class="card-body p-3">
            <h6 class="fw-bold text-uppercase small text-muted mb-2">BEHAVIOURAL PATTERNS</h6>
            <div class="row g-2" style="font-size:13px;">
              <div class="col-sm-6"><strong>Favourite Dish:</strong> <span id="twinFood" class="text-primary"></span></div>
              <div class="col-sm-6"><strong>Typical Day:</strong> <span id="twinDay"></span></div>
              <div class="col-sm-6"><strong>Typical Time:</strong> <span id="twinTime"></span></div>
              <div class="col-sm-6"><strong>Last Order:</strong> <span id="twinLast"></span></div>
              <div class="col-sm-6"><strong>Offer Sensitivity:</strong> <span id="twinSens"></span></div>
              <div class="col-sm-6"><strong>Customer Value:</strong> <span id="twinVal" class="badge bg-dark"></span></div>
              <div class="col-12 mt-2"><strong>Favourite Basket:</strong> <span id="twinBasket" class="badge bg-secondary"></span></div>
            </div>
          </div>
        </div>

        <div class="card" style="border-radius:14px; border:1px solid var(--border);">
          <div class="card-body p-3">
            <h6 class="fw-bold text-uppercase small text-muted mb-2">THE 7 AI OPPORTUNITY SCORES</h6>
            <div class="row g-2 text-center" style="font-size:12px;" id="twinScoresRow">
              <!-- Rendered via JS -->
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function openActionModal(customer, action, copy) {
  document.getElementById('actionCustomerName').innerText = customer;
  document.getElementById('actionModalTitle').innerText = action;
  document.getElementById('actionMessageBody').value = copy;
  new bootstrap.Modal(document.getElementById('actionModal')).show();
}

function simulateSend() {
  alert('Action successfully queued! Campaign sent via Customer Engagement channels.');
  bootstrap.Modal.getInstance(document.getElementById('actionModal')).hide();
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

  const scoresRow = document.getElementById('twinScoresRow');
  scoresRow.innerHTML = `
    <div class="col-4 col-md-2 p-2 bg-light rounded"><small class="text-muted d-block">Reorder</small><strong>${t.scores.reorder}%</strong></div>
    <div class="col-4 col-md-2 p-2 bg-light rounded"><small class="text-muted d-block">Churn</small><strong>${t.scores.churn}%</strong></div>
    <div class="col-4 col-md-2 p-2 bg-light rounded"><small class="text-muted d-block">Upsell</small><strong>${t.scores.upsell}%</strong></div>
    <div class="col-4 col-md-2 p-2 bg-light rounded"><small class="text-muted d-block">VIP</small><strong>${t.scores.vip}%</strong></div>
    <div class="col-4 col-md-2 p-2 bg-light rounded"><small class="text-muted d-block">Engagement</small><strong>${t.scores.engagement}%</strong></div>
    <div class="col-4 col-md-2 p-2 bg-light rounded"><small class="text-muted d-block">Affinity</small><strong>${t.scores.affinity}%</strong></div>
  `;

  new bootstrap.Modal(document.getElementById('twinModal')).show();
}
</script>

@endsection
