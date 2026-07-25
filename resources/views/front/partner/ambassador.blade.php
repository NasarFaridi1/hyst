@extends('front.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap');

    .amb-wrapper {
        font-family: 'Outfit', 'Poppins', sans-serif;
        color: #0F172A;
        background: #F8FAFC;
        overflow-x: hidden;
    }

    /* HERO SECTION */
    .amb-hero-section {
        position: relative;
        background: radial-gradient(circle at 50% 0%, #1E293B 0%, #0F172A 70%, #020617 100%);
        color: #fff;
        padding: 90px 24px 80px;
        text-align: center;
        overflow: hidden;
    }
    .amb-hero-section::before {
        content: '';
        position: absolute;
        top: -100px;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(194, 90, 42, 0.25) 0%, rgba(194, 90, 42, 0) 70%);
        pointer-events: none;
    }
    .amb-pill-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(12px);
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        color: #FFD8C9;
        margin-bottom: 24px;
        letter-spacing: 0.3px;
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        background: #10B981;
        border-radius: 50%;
        box-shadow: 0 0 10px #10B981;
    }
    .amb-hero-title {
        font-size: clamp(32px, 5.5vw, 56px);
        font-weight: 900;
        line-height: 1.15;
        max-width: 900px;
        margin: 0 auto 20px;
        letter-spacing: -1px;
        background: linear-gradient(135deg, #FFFFFF 30%, #FFD8C9 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .amb-hero-desc {
        font-size: 17px;
        color: #94A3B8;
        max-width: 720px;
        margin: 0 auto 36px;
        line-height: 1.6;
        font-weight: 400;
    }
    .amb-btn-primary {
        background: linear-gradient(135deg, #FF6B35 0%, #C25A2A 100%);
        color: #fff;
        font-weight: 800;
        padding: 16px 36px;
        border-radius: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 17px;
        border: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 12px 30px rgba(194, 90, 42, 0.45);
    }
    .amb-btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 40px rgba(194, 90, 42, 0.6);
        background: linear-gradient(135deg, #FF7B47 0%, #D36331 100%);
    }

    /* HERO STATS BAR */
    .hero-stats-wrap {
        max-width: 1000px;
        margin: 50px auto 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        padding: 0 16px;
    }
    .stat-item-box {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 20px 16px;
        text-align: center;
    }
    .stat-num-val {
        font-size: 32px;
        font-weight: 900;
        color: #FFD8C9;
        line-height: 1;
        margin-bottom: 6px;
    }
    .stat-lbl-txt {
        font-size: 13px;
        color: #94A3B8;
        font-weight: 500;
    }

    /* SECTION CONTAINERS */
    .amb-main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 24px;
    }
    .section-head {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 50px;
    }
    .section-head-tag {
        color: #C25A2A;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        display: block;
    }
    .section-head h2 {
        font-size: 34px;
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.5px;
        margin-bottom: 12px;
    }
    .section-head p {
        font-size: 16px;
        color: #64748B;
        line-height: 1.6;
    }

    /* EARNINGS CARDS GRID */
    .earnings-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
        gap: 24px;
    }
    .earnings-card-item {
        background: #FFFFFF;
        border: 2px solid #F1F5F9;
        border-radius: 24px;
        padding: 32px 28px;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .earnings-card-item:hover {
        border-color: #C25A2A;
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(194, 90, 42, 0.12);
    }
    .earn-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 16px;
        width: fit-content;
    }
    .badge-orange { background: #FFF7F3; color: #C25A2A; border: 1px solid #FFD8C9; }
    .badge-blue   { background: #F0F9FF; color: #0284C7; border: 1px solid #BAE6FD; }
    .badge-green  { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
    .badge-purple { background: #FAF5FF; color: #9333EA; border: 1px solid #E9D5FF; }

    .earn-price-amount {
        font-size: 42px;
        font-weight: 900;
        color: #0F172A;
        line-height: 1;
        margin-bottom: 12px;
        letter-spacing: -1px;
    }
    .earnings-card-item h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 8px;
    }
    .earnings-card-item p {
        font-size: 14px;
        color: #64748B;
        line-height: 1.6;
    }

    /* TOOLKIT SHOWCASE */
    .toolkit-showcase-bg {
        background: #0F172A;
        color: #fff;
        padding: 80px 0;
        position: relative;
    }
    .toolkit-grid-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
    }
    .tool-feature-box {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 20px;
        padding: 28px 24px;
        transition: all 0.25s ease;
    }
    .tool-feature-box:hover {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(194, 90, 42, 0.5);
        transform: translateY(-4px);
    }
    .tool-icon-circle {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(194, 90, 42, 0.2) 0%, rgba(255, 107, 53, 0.1) 100%);
        border: 1px solid rgba(194, 90, 42, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-bottom: 18px;
    }
    .tool-feature-box h4 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    .tool-feature-box p {
        font-size: 14px;
        color: #94A3B8;
        line-height: 1.5;
    }

    /* WHO CAN JOIN CARDS */
    .who-join-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }
    .who-persona-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 20px;
        padding: 26px;
        display: flex;
        gap: 18px;
        align-items: flex-start;
        transition: all 0.25s ease;
    }
    .who-persona-card:hover {
        border-color: #C25A2A;
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .persona-avatar {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #FFF7F3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
        border: 1px solid #FFD8C9;
    }
    .persona-content h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 4px;
    }
    .persona-content p {
        font-size: 14px;
        color: #64748B;
        line-height: 1.5;
    }

    /* MODAL STYLING */
    .amb-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(8px);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .amb-modal-overlay.active { display: flex; }
    .amb-modal-dialog {
        background: #FFFFFF;
        border-radius: 24px;
        padding: 36px;
        max-width: 500px;
        width: 100%;
        position: relative;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .amb-modal-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #F1F5F9;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748B;
        transition: background 0.18s;
    }
    .amb-modal-close-btn:hover { background: #E2E8F0; color: #0F172A; }

    .form-group-lbl {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-input-field {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        font-size: 14px;
        outline: none;
        transition: border 0.18s;
        background: #F8FAFC;
    }
    .form-input-field:focus {
        border-color: #C25A2A;
        background: #fff;
    }
</style>

<div class="amb-wrapper">

    <!-- HERO SECTION -->
    <section class="amb-hero-section">
        <div class="amb-pill-tag">
            <span class="pulse-dot"></span>
            <span>HYST Ambassador Programme</span>
        </div>
        <h1 class="amb-hero-title">Turn Your Network Into High Monthly Earnings</h1>
        <p class="amb-hero-desc">
            Anyone can become a HYST Ambassador. Help local UK takeaway businesses grow, onboard new restaurants, and earn continuous residual payouts with zero upfront investment.
        </p>

        <button type="button" class="amb-btn-primary" onclick="openAmbModal()">
            <span>Apply as Ambassador Now</span>
            <span>→</span>
        </button>

        <!-- HERO STATS -->
        <div class="hero-stats-wrap">
            <div class="stat-item-box">
                <div class="stat-num-val">£100</div>
                <div class="stat-lbl-txt">Per Restaurant Onboarded</div>
            </div>
            <div class="stat-item-box">
                <div class="stat-num-val">£50</div>
                <div class="stat-lbl-txt">Per Other Business</div>
            </div>
            <div class="stat-item-box">
                <div class="stat-num-val">10%</div>
                <div class="stat-lbl-txt">Residual Profit Share</div>
            </div>
            <div class="stat-item-box">
                <div class="stat-num-val">100%</div>
                <div class="stat-lbl-txt">Flexible Hours & Work</div>
            </div>
        </div>
    </section>


    <!-- EARNING CHANNELS -->
    <section class="amb-main-container">
        <div class="section-head">
            <span class="section-head-tag">Generous Payout Structure</span>
            <h2>Four Ways You Earn With HYST</h2>
            <p>Multiple revenue streams designed to reward both immediate onboarding and long-term restaurant activity.</p>
        </div>

        <div class="earnings-grid-container">
            <!-- 1. RESTAURANT ONBOARDING -->
            <div class="earnings-card-item">
                <div>
                    <span class="earn-hero-badge badge-orange">🏆 Restaurant Referral</span>
                    <div class="earn-price-amount">£100</div>
                    <h3>Per Restaurant Onboarded</h3>
                    <p>Receive a direct £100 reward for every restaurant that registers and completes setup on the HYST platform.</p>
                </div>
            </div>

            <!-- 2. OTHER BUSINESS ONBOARDING -->
            <div class="earnings-card-item">
                <div>
                    <span class="earn-hero-badge badge-blue">🏢 Business Referral</span>
                    <div class="earn-price-amount">£50</div>
                    <h3>Per Other Business</h3>
                    <p>Earn £50 for referring non-restaurant business partners or local merchant stores to the HYST network.</p>
                </div>
            </div>

            <!-- 3. ONBOARDING SUPPORT -->
            <div class="earnings-card-item">
                <div>
                    <span class="earn-hero-badge badge-purple">🛠️ Onboarding Support</span>
                    <div class="earn-price-amount">Support</div>
                    <h3>Setup & Onboarding Bonus</h3>
                    <p>Get paid for assisting restaurant owners in creating their profile, building digital menus, and submitting documents.</p>
                </div>
            </div>

            <!-- 4. 10% PROFIT SHARE -->
            <div class="earnings-card-item">
                <div>
                    <span class="earn-hero-badge badge-green">📈 Lifetime Residuals</span>
                    <div class="earn-price-amount">10%</div>
                    <h3>HYST Profit Share</h3>
                    <p>Earn 10% residual profit share on HYST's profit for keeping your onboarded restaurants active and thriving!</p>
                </div>
            </div>
        </div>
    </section>


    <!-- AMBASSADOR TOOLKIT -->
    <section class="toolkit-showcase-bg">
        <div class="amb-main-container">
            <div class="section-head" style="margin-bottom:60px;">
                <span class="section-head-tag" style="color:#FFD8C9;">Digital Ambassador Kit</span>
                <h2 style="color:#fff;">What Every Ambassador Receives</h2>
                <p style="color:#94A3B8;">We equip you with high-converting marketing tools and real-time tracking software.</p>
            </div>

            <div class="toolkit-grid-wrapper">
                <div class="tool-feature-box">
                    <div class="tool-icon-circle">🎟️</div>
                    <h4>Referral Code</h4>
                    <p>A unique trackable code assigned to you for seamless customer & restaurant attribution.</p>
                </div>

                <div class="tool-feature-box">
                    <div class="tool-icon-circle">📱</div>
                    <h4>Personalised QR Code</h4>
                    <p>Instant scan-to-register QR code perfect for in-person restaurant visits and event flyers.</p>
                </div>

                <div class="tool-feature-box">
                    <div class="tool-icon-circle">🎴</div>
                    <h4>Digital Business Card</h4>
                    <p>A professional digital card showcasing your official HYST Ambassador credentials.</p>
                </div>

                <div class="tool-feature-box">
                    <div class="tool-icon-circle">📊</div>
                    <h4>Earnings Dashboard</h4>
                    <p>A dedicated live dashboard to monitor signups, onboarded restaurants, and monthly payouts.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- WHO CAN JOIN -->
    <section class="amb-main-container">
        <div class="section-head">
            <span class="section-head-tag">Open To All</span>
            <h2>Who Can Become an Ambassador?</h2>
            <p>Whether you're looking for flexible side income or building a full network, HYST is open to everyone.</p>
        </div>

        <div class="who-join-grid">
            <div class="who-persona-card">
                <div class="persona-avatar">🎓</div>
                <div class="persona-content">
                    <h3>University Students</h3>
                    <p>Earn high commission payouts between classes by connecting local food spots to HYST.</p>
                </div>
            </div>

            <div class="who-persona-card">
                <div class="persona-avatar">💼</div>
                <div class="persona-content">
                    <h3>Part-Time Workers</h3>
                    <p>Supplement your primary salary on your own schedule with zero time restrictions.</p>
                </div>
            </div>

            <div class="who-persona-card">
                <div class="persona-avatar">🏡</div>
                <div class="persona-content">
                    <h3>Stay-at-Home Parents</h3>
                    <p>Flexible work-from-home opportunity connecting local takeaway businesses in your area.</p>
                </div>
            </div>

            <div class="who-persona-card">
                <div class="persona-avatar">👴</div>
                <div class="persona-content">
                    <h3>Retired People</h3>
                    <p>Stay engaged in your community while earning extra monthly income by helping local restaurants.</p>
                </div>
            </div>

            <div class="who-persona-card">
                <div class="persona-avatar">📱</div>
                <div class="persona-content">
                    <h3>Content Creators & Influencers</h3>
                    <p>Monetize your food reviews, foodies network, and social media audience easily.</p>
                </div>
            </div>

            <div class="who-persona-card">
                <div class="persona-avatar">📢</div>
                <div class="persona-content">
                    <h3>Community Organisers</h3>
                    <p>Empower independent high-street food spots to eliminate heavy commission cuts.</p>
                </div>
            </div>
        </div>

        <!-- FINAL CTA -->
        <div style="text-align:center; margin-top:60px; background:linear-gradient(135deg, #1E293B 0%, #0F172A 100%); padding:50px 24px; border-radius:24px; color:#fff;">
            <h3 style="font-size:28px; font-weight:800; margin-bottom:10px;">Ready to Become a HYST Ambassador?</h3>
            <p style="color:#94A3B8; font-size:15px; max-width:550px; margin:0 auto 24px;">Start earning by helping local food businesses thrive with zero commission fees.</p>
            <button type="button" class="amb-btn-primary" onclick="openAmbModal()">
                <span>Apply as Ambassador Now</span>
                <span>→</span>
            </button>
        </div>
    </section>

</div>


<!-- APPLICATION MODAL -->
<div class="amb-modal-overlay" id="ambModal">
    <div class="amb-modal-dialog">
        <button class="amb-modal-close-btn" onclick="closeAmbModal()">✕</button>
        <h3 style="font-size:22px; font-weight:800; color:#0F172A; margin-bottom:4px;">Join HYST Ambassador Programme</h3>
        <p style="font-size:14px; color:#64748B; margin-bottom:24px;">Fill out your details below and our team will contact you with your starter kit.</p>

        <form id="ambForm">
            @csrf
            <input type="hidden" name="partner_type" value="Become an Ambassador">

            <div style="margin-bottom:16px;">
                <label class="form-group-lbl">Full Name *</label>
                <input type="text" name="name" required placeholder="John Doe" class="form-input-field">
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-group-lbl">Email Address *</label>
                <input type="email" name="email" required placeholder="john@example.com" class="form-input-field">
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-group-lbl">Phone / WhatsApp *</label>
                <input type="text" name="phone_number" required placeholder="+44 7000 000000" class="form-input-field">
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-group-lbl">City / Location *</label>
                <input type="text" name="location" required placeholder="e.g. London, Manchester" class="form-input-field">
            </div>

            <button type="submit" class="amb-btn-primary" style="width:100%; justify-content:center;">
                <span>Submit Ambassador Application</span>
            </button>
        </form>
    </div>
</div>

<script>
    function openAmbModal() {
        document.getElementById('ambModal').classList.add('active');
    }
    function closeAmbModal() {
        document.getElementById('ambModal').classList.remove('active');
    }

    document.getElementById('ambForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');

        if (typeof window.showGlobalLoader === 'function') {
            window.showGlobalLoader('Submitting Application...', 'Please wait', 3000);
        }
        submitBtn.disabled = true;

        fetch("{{ route('front.become.partner') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {
            if (typeof window.hideGlobalLoader === 'function') {
                window.hideGlobalLoader();
            }
            submitBtn.disabled = false;

            if (data.success) {
                closeAmbModal();
                form.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Application Submitted!',
                    text: data.message,
                    confirmButtonColor: '#C25A2A'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: data.message || 'Something went wrong',
                    confirmButtonColor: '#C25A2A'
                });
            }
        })
        .catch(err => {
            if (typeof window.hideGlobalLoader === 'function') {
                window.hideGlobalLoader();
            }
            submitBtn.disabled = false;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Network error. Please try again.',
                confirmButtonColor: '#C25A2A'
            });
        });
    });
</script>

@endsection
