@extends('front.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap');

    .rest-wrapper {
        font-family: 'Outfit', 'Poppins', sans-serif;
        color: #0F172A;
        background: #F8FAFC;
        overflow-x: hidden;
    }

    /* HERO SECTION */
    .rest-hero-section {
        position: relative;
        background: radial-gradient(circle at 50% 0%, #1E293B 0%, #0F172A 70%, #020617 100%);
        color: #fff;
        padding: 90px 24px 80px;
        text-align: center;
        overflow: hidden;
    }
    .rest-hero-section::before {
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
    .rest-pill-tag {
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
    .rest-hero-title {
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
    .rest-hero-desc {
        font-size: 17px;
        color: #94A3B8;
        max-width: 720px;
        margin: 0 auto 36px;
        line-height: 1.6;
        font-weight: 400;
    }
    .rest-btn-primary {
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
    .rest-btn-primary:hover {
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
    .rest-main-container {
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

    /* BENEFITS GRID */
    .benefits-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
    }
    .ben-card-item {
        background: #FFFFFF;
        border: 2px solid #F1F5F9;
        border-radius: 24px;
        padding: 32px 28px;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .ben-card-item:hover {
        border-color: #C25A2A;
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(194, 90, 42, 0.12);
    }
    .ben-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #FFF7F3;
        color: #C25A2A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 20px;
        border: 1px solid #FFD8C9;
    }
    .ben-card-item h3 {
        font-size: 19px;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 8px;
    }
    .ben-card-item p {
        font-size: 14px;
        color: #64748B;
        line-height: 1.6;
    }

    /* STEPS SECTION */
    .steps-bg-wrap {
        background: #0F172A;
        color: #fff;
        padding: 80px 0;
    }
    .steps-grid-wrap {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 28px;
    }
    .step-box-item {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 20px;
        padding: 32px 26px;
        position: relative;
        text-align: center;
    }
    .step-number-badge {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FF6B35 0%, #C25A2A 100%);
        color: #fff;
        font-weight: 900;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        box-shadow: 0 8px 20px rgba(194, 90, 42, 0.4);
    }
    .step-box-item h4 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    .step-box-item p {
        font-size: 14px;
        color: #94A3B8;
        line-height: 1.6;
    }

    /* MODAL STYLING */
    .rest-modal-overlay {
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
    .rest-modal-overlay.active { display: flex; }
    .rest-modal-dialog {
        background: #FFFFFF;
        border-radius: 24px;
        padding: 36px;
        max-width: 500px;
        width: 100%;
        position: relative;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .rest-modal-close-btn {
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
    .rest-modal-close-btn:hover { background: #E2E8F0; color: #0F172A; }

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

<div class="rest-wrapper">

    <!-- HERO SECTION -->
    <section class="rest-hero-section">
        <div class="rest-pill-tag">
            <span class="pulse-dot"></span>
            <span>Zero Commission Restaurant Partner</span>
        </div>
        <h1 class="rest-hero-title">Keep 100% of Your Hard-Earned Profit</h1>
        <p class="rest-hero-desc">
            Join independent UK restaurants offering genuine menu prices directly to customers. Zero commission fees, transparent payouts, and complete control over your business.
        </p>

        <button type="button" class="rest-btn-primary" onclick="openRestModal()">
            <span>Partner With Us Today</span>
            <span>→</span>
        </button>

        <!-- HERO STATS -->
        <div class="hero-stats-wrap">
            <div class="stat-item-box">
                <div class="stat-num-val">0%</div>
                <div class="stat-lbl-txt">Commission Fee</div>
            </div>
            <div class="stat-item-box">
                <div class="stat-num-val">100%</div>
                <div class="stat-lbl-txt">Direct Revenue Kept</div>
            </div>
            <div class="stat-item-box">
                <div class="stat-num-val">Direct</div>
                <div class="stat-lbl-txt">Customer Relationships</div>
            </div>
            <div class="stat-item-box">
                <div class="stat-num-val">24/7</div>
                <div class="stat-lbl-txt">Menu & Price Control</div>
            </div>
        </div>
    </section>


    <!-- BENEFITS GRID -->
    <section class="rest-main-container">
        <div class="section-head">
            <span class="section-head-tag">Empowering Restaurants</span>
            <h2>Why Restaurant Owners Choose HYST</h2>
            <p>A fair food ordering platform engineered specifically to protect independent restaurant profit margins.</p>
        </div>

        <div class="benefits-grid-container">
            <div class="ben-card-item">
                <div class="ben-icon-wrap">💯</div>
                <h3>0% Commission Model</h3>
                <p>Stop paying 25%-35%+ cuts to marketplace platforms. Keep 100% of your menu revenue on every direct order.</p>
            </div>

            <div class="ben-card-item">
                <div class="ben-icon-wrap">🏷️</div>
                <h3>Genuine Menu Pricing</h3>
                <p>Offer your true dine-in menu prices so customers enjoy fair, honest pricing without artificial markups.</p>
            </div>

            <div class="ben-card-item">
                <div class="ben-icon-wrap">🤝</div>
                <h3>Direct Customer Ownership</h3>
                <p>Build long-term customer relationships and repeat brand loyalty with transparent customer insights.</p>
            </div>

            <div class="ben-card-item">
                <div class="ben-icon-wrap">⚡</div>
                <h3>Full Menu & Price Control</h3>
                <p>Instantly update items, variants, addons, pricing, offers, and opening hours from your live dashboard.</p>
            </div>
        </div>
    </section>


    <!-- HOW IT WORKS (STEPS) -->
    <section class="steps-bg-wrap">
        <div class="rest-main-container">
            <div class="section-head" style="margin-bottom:60px;">
                <span class="section-head-tag" style="color:#FFD8C9;">Fast Onboarding Process</span>
                <h2 style="color:#fff;">Get Started in 3 Simple Steps</h2>
                <p style="color:#94A3B8;">Our dedicated team assists you through every step of setup and verification.</p>
            </div>

            <div class="steps-grid-wrap">
                <div class="step-box-item">
                    <div class="step-number-badge">1</div>
                    <h4>Register Interest</h4>
                    <p>Submit your restaurant name and contact details through our quick online partner application.</p>
                </div>

                <div class="step-box-item">
                    <div class="step-number-badge">2</div>
                    <h4>Set Up Profile & Menu</h4>
                    <p>Our team helps set up your digital menu, variants, addons, delivery radius, and operating hours.</p>
                </div>

                <div class="step-box-item">
                    <div class="step-number-badge">3</div>
                    <h4>Start Accepting Orders</h4>
                    <p>Go live on HYST and start receiving direct takeaway and delivery orders with zero commission.</p>
                </div>
            </div>

            <!-- FINAL CTA -->
            <div style="text-align:center; margin-top:60px;">
                <button type="button" class="rest-btn-primary" onclick="openRestModal()">
                    <span>Apply as Restaurant Partner Now</span>
                    <span>→</span>
                </button>
            </div>
        </div>
    </section>

</div>


<!-- APPLICATION MODAL -->
<div class="rest-modal-overlay" id="restModal">
    <div class="rest-modal-dialog">
        <button class="rest-modal-close-btn" onclick="closeRestModal()">✕</button>
        <h3 style="font-size:22px; font-weight:800; color:#0F172A; margin-bottom:4px;">Become a Restaurant Partner</h3>
        <p style="font-size:14px; color:#64748B; margin-bottom:24px;">Fill out your restaurant details below and our team will get in touch with you shortly.</p>

        <form id="restForm">
            @csrf
            <input type="hidden" name="partner_type" value="Become Restaurant Partner">

            <div style="margin-bottom:16px;">
                <label class="form-group-lbl">Restaurant / Business Name *</label>
                <input type="text" name="name" required placeholder="Urban Sugar Lab" class="form-input-field">
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-group-lbl">Contact Email *</label>
                <input type="email" name="email" required placeholder="contact@restaurant.com" class="form-input-field">
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-group-lbl">Phone / WhatsApp *</label>
                <input type="text" name="phone_number" required placeholder="+44 7879 175585" class="form-input-field">
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-group-lbl">City / Postcode *</label>
                <input type="text" name="location" required placeholder="e.g. Hounslow, London TW3" class="form-input-field">
            </div>

            <button type="submit" class="rest-btn-primary" style="width:100%; justify-content:center;">
                <span>Submit Partner Application</span>
            </button>
        </form>
    </div>
</div>

<script>
    function openRestModal() {
        document.getElementById('restModal').classList.add('active');
    }
    function closeRestModal() {
        document.getElementById('restModal').classList.remove('active');
    }

    document.getElementById('restForm').addEventListener('submit', function(e) {
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
                closeRestModal();
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
