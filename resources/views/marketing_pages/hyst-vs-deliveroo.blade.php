<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hyst vs Deliveroo – Keep Your Revenue, Lose the Commission | Hyst</title>
  <meta name="description" content="Deliveroo takes up to 35% commission from every order. Hyst gives you direct ordering with 0% commission. See the true cost comparison." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --gold: #D97706;
      --gold-light: #F59E0B;
      --gold-dim: rgba(217,119,6,0.15);
      --bg: #0D0D0D;
      --bg2: #111111;
      --bg3: #161616;
      --glass: rgba(255,255,255,0.04);
      --glass-border: rgba(255,255,255,0.08);
      --text: #F5F5F5;
      --muted: #888;
      --danger: #EF4444;
      --success: #22C55E;
    }
    html { scroll-behavior: smooth; }
    body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; overflow-x: hidden; }

    /* Particles canvas */
    #particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; }

    /* Floating gradients */
    .blob { position: fixed; border-radius: 50%; filter: blur(120px); opacity: 0.12; pointer-events: none; z-index: 0; animation: drift 20s ease-in-out infinite alternate; }
    .blob-1 { width: 600px; height: 600px; background: var(--gold); top: -200px; right: -200px; animation-delay: 0s; }
    .blob-2 { width: 400px; height: 400px; background: #7C3AED; bottom: 20%; left: -150px; animation-delay: -8s; }
    .blob-3 { width: 300px; height: 300px; background: var(--gold-light); bottom: -100px; right: 30%; animation-delay: -14s; }
    @keyframes drift { from { transform: translate(0,0) scale(1); } to { transform: translate(40px,30px) scale(1.08); } }

    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.85); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); letter-spacing: -0.02em; }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

    /* Hero */
    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--gold-dim); border: 1px solid rgba(217,119,6,0.3); color: var(--gold); font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 2rem; letter-spacing: 0.08em; text-transform: uppercase; }
    .hero-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--gold); animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:0.5; transform:scale(1.5); } }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.08; margin-bottom: 1.5rem; }
    .hero h1 .accent { color: var(--gold); }
    .hero h1 .strike { text-decoration: line-through; color: var(--muted); }
    .hero-sub { font-size: clamp(1rem, 2vw, 1.25rem); color: #aaa; max-width: 640px; margin: 0 auto 3rem; line-height: 1.7; }
    .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: var(--gold); color: #000; font-weight: 700; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; transition: all 0.3s; display: inline-block; position: relative; overflow: hidden; }
    .btn-primary::after { content: ''; position: absolute; inset: 0; background: white; opacity: 0; transition: opacity 0.3s; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(217,119,6,0.5); }
    .btn-secondary { background: transparent; color: var(--text); font-weight: 600; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; border: 1px solid var(--glass-border); transition: all 0.3s; }
    .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }

    /* Stats row */
    .stats-row { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto; padding: 0 1.5rem 5rem; }
    .stat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.75rem 1.5rem; text-align: center; backdrop-filter: blur(12px); }
    .stat-number { font-family: 'Playfair Display', serif; font-size: 2.75rem; font-weight: 900; color: var(--gold); line-height: 1; }
    .stat-label { font-size: 0.875rem; color: var(--muted); margin-top: 0.5rem; }

    section { position: relative; z-index: 1; }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
    .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.25rem; }
    .section-body { color: #aaa; font-size: 1.0625rem; line-height: 1.8; max-width: 640px; }

    /* Comparison table */
    .compare-section { padding: 6rem 0; background: var(--bg2); }
    .compare-table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 3rem; border-radius: 20px; overflow: hidden; border: 1px solid var(--glass-border); }
    .compare-table thead th { padding: 1.5rem 1.25rem; font-size: 0.9rem; font-weight: 700; text-align: center; }
    .compare-table thead th:first-child { text-align: left; }
    .th-deliveroo { background: rgba(0,204,102,0.06); color: #00CC66; }
    .th-hyst { background: var(--gold-dim); color: var(--gold); }
    .th-feature { background: var(--bg3); color: var(--muted); font-weight: 600; font-size: 0.8rem; letter-spacing: 0.06em; text-transform: uppercase; }
    .compare-table tbody tr { border-top: 1px solid var(--glass-border); }
    .compare-table tbody tr:hover { background: rgba(255,255,255,0.02); }
    .compare-table tbody td { padding: 1.1rem 1.25rem; font-size: 0.9375rem; vertical-align: middle; }
    .compare-table tbody td:first-child { font-weight: 500; }
    .compare-table tbody td:not(:first-child) { text-align: center; }
    .tag-bad { color: var(--danger); font-weight: 700; }
    .tag-good { color: var(--success); font-weight: 700; }
    .tag-neutral { color: var(--muted); }
    .icon-check { color: var(--success); font-size: 1.2rem; }
    .icon-cross { color: var(--danger); font-size: 1.2rem; }

    /* Cost calculator */
    .calc-section { padding: 6rem 0; }
    .calc-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 24px; padding: 2.5rem; backdrop-filter: blur(16px); max-width: 700px; margin: 3rem auto 0; }
    .calc-label { font-size: 0.875rem; font-weight: 600; color: var(--muted); margin-bottom: 0.5rem; }
    .calc-input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; padding: 0.875rem 1rem; color: var(--text); font-size: 1.25rem; font-weight: 700; outline: none; transition: border-color 0.3s; margin-bottom: 1.5rem; }
    .calc-input:focus { border-color: var(--gold); }
    .calc-range { width: 100%; accent-color: var(--gold); margin-bottom: 2rem; cursor: pointer; }
    .calc-results { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .calc-result-card { border-radius: 16px; padding: 1.5rem; text-align: center; }
    .calc-result-card.bad { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); }
    .calc-result-card.good { background: rgba(217,119,6,0.1); border: 1px solid rgba(217,119,6,0.3); }
    .calc-result-label { font-size: 0.8rem; font-weight: 600; color: var(--muted); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.08em; }
    .calc-result-number { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 900; }
    .calc-result-card.bad .calc-result-number { color: var(--danger); }
    .calc-result-card.good .calc-result-number { color: var(--gold); }

    /* Timeline / How section */
    .how-section { padding: 6rem 0; background: var(--bg2); }
    .steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .step-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; backdrop-filter: blur(12px); position: relative; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; }
    .step-card:hover { transform: translateY(-4px); box-shadow: 0 20px 60px rgba(217,119,6,0.12); }
    .step-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--gold), transparent); }
    .step-num { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900; color: var(--gold-dim); line-height: 1; margin-bottom: 0.75rem; }
    .step-title { font-size: 1.0625rem; font-weight: 700; margin-bottom: 0.5rem; }
    .step-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* Testimonials */
    .testimonials-section { padding: 6rem 0; }
    .testimonials-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .testi-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; backdrop-filter: blur(12px); }
    .testi-stars { color: var(--gold); font-size: 0.875rem; margin-bottom: 1rem; letter-spacing: 2px; }
    .testi-text { font-size: 0.9375rem; line-height: 1.7; color: #ccc; margin-bottom: 1.5rem; font-style: italic; }
    .testi-author { display: flex; align-items: center; gap: 0.75rem; }
    .testi-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; color: #000; }
    .testi-name { font-weight: 700; font-size: 0.9rem; }
    .testi-role { font-size: 0.8rem; color: var(--muted); }

    /* Final CTA */
    .cta-section { padding: 8rem 0; text-align: center; background: var(--bg2); }
    .cta-glow { position: absolute; inset: 0; background: radial-gradient(ellipse at center, rgba(217,119,6,0.08) 0%, transparent 70%); pointer-events: none; }
    .cta-section h2 { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; margin-bottom: 1.25rem; }
    .cta-section p { color: #aaa; font-size: 1.0625rem; max-width: 540px; margin: 0 auto 3rem; line-height: 1.7; }

    footer { background: var(--bg); border-top: 1px solid var(--glass-border); padding: 3rem 1.5rem; text-align: center; position: relative; z-index: 1; }
    footer p { color: var(--muted); font-size: 0.875rem; }
    footer a { color: var(--gold); text-decoration: none; }

    @media (max-width: 640px) {
      .calc-results { grid-template-columns: 1fr; }
      nav { padding: 1rem; }
      .hero { padding: 7rem 1rem 3rem; }
    }
  </style>
</head>
<body>
  <canvas id="particles"></canvas>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>

  <nav>
    <div class="logo">Hyst</div>
    <a href="#get-started" class="nav-cta">Start Free →</a>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div>
      <div class="hero-badge">Hyst vs Deliveroo</div>
      <h1>Stop Feeding <span class="strike">Deliveroo</span><br/><span class="accent">35% of Every Order</span></h1>
      <p class="hero-sub">Deliveroo built their empire on your kitchen. It's time to take back your margin with a direct ordering system that works harder than any marketplace ever could.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Get Direct Ordering Free</a>
        <a href="#compare" class="btn-secondary">See the Numbers</a>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <div class="stats-row">
    <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
      <div class="stat-number" data-count="35">0</div><div style="font-size:1.5rem;color:var(--gold)">%</div>
      <div class="stat-label">Max Deliveroo commission</div>
    </div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
      <div class="stat-number" data-count="0">0</div><div style="font-size:1.5rem;color:var(--gold)">%</div>
      <div class="stat-label">Hyst commission</div>
    </div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
      <div class="stat-number" data-count="3">0</div><div style="font-size:1.5rem;color:var(--gold)">x</div>
      <div class="stat-label">More profit per order</div>
    </div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
      <div class="stat-number" data-count="48">0</div><div style="font-size:1.5rem;color:var(--gold)">hr</div>
      <div class="stat-label">Setup time</div>
    </div>
  </div>

  <!-- Comparison Table -->
  <section class="compare-section" id="compare">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Side by side</p>
      <h2 class="section-title" data-aos="fade-up">The Honest Comparison</h2>
      <p class="section-body" data-aos="fade-up">Deliveroo's model is designed to make their growth dependent on your costs. Here's what that really looks like.</p>
      <div style="overflow-x:auto" data-aos="fade-up">
        <table class="compare-table">
          <thead>
            <tr>
              <th class="th-feature">Feature</th>
              <th class="th-deliveroo">🛵 Deliveroo</th>
              <th class="th-hyst">⚡ Hyst</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Commission per order</td><td class="tag-bad">25–35%</td><td class="tag-good">0%</td></tr>
            <tr><td>Customer data ownership</td><td class="icon-cross">✕ Deliveroo owns it</td><td class="icon-check">✓ You own it</td></tr>
            <tr><td>Branded ordering experience</td><td class="icon-cross">✕ Deliveroo branding</td><td class="icon-check">✓ Fully branded</td></tr>
            <tr><td>Loyalty programme</td><td class="icon-cross">✕ Deliveroo Plus only</td><td class="icon-check">✓ Built-in</td></tr>
            <tr><td>Direct customer re-marketing</td><td class="icon-cross">✕ Not allowed</td><td class="icon-check">✓ Email + SMS</td></tr>
            <tr><td>Table ordering (QR)</td><td class="icon-cross">✕ No</td><td class="icon-check">✓ Yes</td></tr>
            <tr><td>POS integration</td><td class="tag-neutral">Limited</td><td class="icon-check">✓ Full sync</td></tr>
            <tr><td>Monthly fixed cost</td><td class="tag-bad">Commission only (no cap)</td><td class="tag-good">Flat fee, no surprises</td></tr>
            <tr><td>Contract lock-in</td><td class="tag-bad">Yes – terms apply</td><td class="tag-good">No contract</td></tr>
            <tr><td>Setup time</td><td class="tag-neutral">Weeks (approval needed)</td><td class="tag-good">Under 48 hours</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Cost Calculator -->
  <section class="calc-section" id="calculator">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Real numbers</p>
      <h2 class="section-title" data-aos="fade-up">How Much Is Deliveroo Really Costing You?</h2>
      <p class="section-body" data-aos="fade-up" style="margin:0 auto 0">Enter your monthly revenue to see the true cost of commission.</p>
      <div class="calc-card" data-aos="fade-up">
        <div class="calc-label">Monthly order revenue through Deliveroo</div>
        <input type="number" class="calc-input" id="revenue" value="10000" min="1000" max="500000" placeholder="£10,000" />
        <div class="calc-label">Deliveroo commission rate: <span id="rateLabel">30</span>%</div>
        <input type="range" class="calc-range" id="rate" min="20" max="35" value="30" step="1" />
        <div class="calc-results">
          <div class="calc-result-card bad">
            <div class="calc-result-label">💸 Lost to Deliveroo / month</div>
            <div class="calc-result-number" id="lostMonth">£3,000</div>
          </div>
          <div class="calc-result-card good">
            <div class="calc-result-label">💰 Saved with Hyst / year</div>
            <div class="calc-result-number" id="savedYear">£36,000</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- How it works -->
  <section class="how-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Simple switch</p>
      <h2 class="section-title" data-aos="fade-up">Switch in 3 Steps</h2>
      <div class="steps">
        <div class="step-card" data-aos="fade-up" data-aos-delay="0">
          <div class="step-num">01</div>
          <div class="step-title">Set up your menu</div>
          <div class="step-body">Import your existing menu or build from scratch. Hyst works with your POS so menus stay in sync automatically.</div>
        </div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="100">
          <div class="step-num">02</div>
          <div class="step-title">Share your ordering link</div>
          <div class="step-body">Your branded ordering page is live in hours. Share on Instagram, your website, Google listing, and with QR codes at every table.</div>
        </div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="200">
          <div class="step-num">03</div>
          <div class="step-title">Keep every penny</div>
          <div class="step-body">Orders land directly in your POS. No commission. You own the customer relationship and can market to them directly forever.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Real restaurants</p>
      <h2 class="section-title" data-aos="fade-up">What Owners Say</h2>
      <div class="testimonials-grid">
        <div class="testi-card" data-aos="fade-up" data-aos-delay="0">
          <div class="testi-stars">★★★★★</div>
          <div class="testi-text">"We were giving Deliveroo £8,000 a month. After switching to Hyst for direct orders, that money stays with us. Game-changer doesn't cover it."</div>
          <div class="testi-author"><div class="testi-avatar">MR</div><div><div class="testi-name">Marco R.</div><div class="testi-role">Owner, Osteria Firenze – London</div></div></div>
        </div>
        <div class="testi-card" data-aos="fade-up" data-aos-delay="100">
          <div class="testi-stars">★★★★★</div>
          <div class="testi-text">"The setup took one afternoon. We sent a WhatsApp to our regulars, linked it on our Instagram bio, and within a week had 40 direct orders."</div>
          <div class="testi-author"><div class="testi-avatar">PK</div><div><div class="testi-name">Priya K.</div><div class="testi-role">Owner, Spice Routes – Manchester</div></div></div>
        </div>
        <div class="testi-card" data-aos="fade-up" data-aos-delay="200">
          <div class="testi-stars">★★★★★</div>
          <div class="testi-text">"Having the customer data is everything. I can now run email promotions on quiet Tuesdays and actually see them fill up."</div>
          <div class="testi-author"><div class="testi-avatar">TS</div><div><div class="testi-name">Tom S.</div><div class="testi-role">Director, The Burger Society – Bristol</div></div></div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started" style="position:relative">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">Start today</p>
      <h2>Ready to Stop Paying Deliveroo's Commission?</h2>
      <p>Join hundreds of UK restaurants saving thousands per month. Free setup. No contract. No commission. Ever.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Get Started Free – Zero Commission →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. Built for independent restaurants. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, offset: 60 });

    // Particles
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let W = canvas.width = window.innerWidth;
    let H = canvas.height = window.innerHeight;
    const particles = Array.from({length:60},()=>({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.5+0.5,vx:(Math.random()-0.5)*0.3,vy:(Math.random()-0.5)*0.3,o:Math.random()*0.4+0.1}));
    function drawParticles(){
      ctx.clearRect(0,0,W,H);
      particles.forEach(p=>{
        ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
        ctx.fillStyle=`rgba(217,119,6,${p.o})`; ctx.fill();
        p.x+=p.vx; p.y+=p.vy;
        if(p.x<0||p.x>W)p.vx*=-1;
        if(p.y<0||p.y>H)p.vy*=-1;
      });
      requestAnimationFrame(drawParticles);
    }
    drawParticles();
    window.addEventListener('resize',()=>{W=canvas.width=window.innerWidth;H=canvas.height=window.innerHeight;});

    // Counter animation
    gsap.registerPlugin(ScrollTrigger);
    document.querySelectorAll('[data-count]').forEach(el=>{
      const target = +el.dataset.count;
      ScrollTrigger.create({trigger:el,start:'top 85%',once:true,onEnter:()=>{
        gsap.fromTo(el,{innerText:0},{innerText:target,duration:1.8,ease:'power2.out',snap:{innerText:1},onUpdate:function(){el.innerText=Math.round(this.targets()[0].innerText);}});
      }});
    });

    // Calculator
    const revenueInput = document.getElementById('revenue');
    const rateInput = document.getElementById('rate');
    const rateLabel = document.getElementById('rateLabel');
    const lostMonth = document.getElementById('lostMonth');
    const savedYear = document.getElementById('savedYear');
    function updateCalc(){
      const rev = parseFloat(revenueInput.value)||0;
      const rate = parseFloat(rateInput.value)||30;
      rateLabel.textContent = rate;
      const lost = rev * rate / 100;
      const saved = lost * 12;
      lostMonth.textContent = '£'+lost.toLocaleString('en-GB',{maximumFractionDigits:0});
      savedYear.textContent = '£'+saved.toLocaleString('en-GB',{maximumFractionDigits:0});
    }
    revenueInput.addEventListener('input',updateCalc);
    rateInput.addEventListener('input',updateCalc);
    updateCalc();

    // GSAP hero entrance
    gsap.from('.hero > div > *',{y:30,opacity:0,stagger:0.15,duration:0.9,ease:'power3.out',delay:0.3});
  </script>
</body>
</html>
