<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hyst vs Just Eat – Why Direct Ordering Wins | Hyst</title>
  <meta name="description" content="Just Eat charges up to 14% + payment fees on every order. Hyst gives restaurants 100% direct ordering with zero commission. See the real comparison." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --gold: #D97706; --gold-light: #F59E0B; --gold-dim: rgba(217,119,6,0.15);
      --bg: #0D0D0D; --bg2: #111111; --bg3: #161616;
      --glass: rgba(255,255,255,0.04); --glass-border: rgba(255,255,255,0.08);
      --text: #F5F5F5; --muted: #888; --danger: #EF4444; --success: #22C55E;
      --je: #FF6600;
    }
    html { scroll-behavior: smooth; }
    body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; overflow-x: hidden; }
    #particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
    .blob { position: fixed; border-radius: 50%; filter: blur(120px); opacity: 0.1; pointer-events: none; z-index: 0; animation: drift 22s ease-in-out infinite alternate; }
    .blob-1 { width: 500px; height: 500px; background: var(--gold); top: -150px; left: -150px; }
    .blob-2 { width: 450px; height: 450px; background: #DC2626; bottom: 10%; right: -150px; animation-delay: -9s; }
    .blob-3 { width: 300px; height: 300px; background: var(--gold-light); top: 50%; left: 40%; animation-delay: -16s; }
    @keyframes drift { from { transform: translate(0,0); } to { transform: translate(30px,25px); } }

    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.85); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .vs-badge { display: inline-flex; align-items: center; gap: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 50px; padding: 0.5rem 1.25rem; margin-bottom: 2.5rem; font-size: 0.875rem; font-weight: 600; }
    .vs-label { background: var(--je); color: white; padding: 0.2rem 0.75rem; border-radius: 50px; font-size: 0.75rem; }
    .vs-sep { color: var(--muted); }
    .vs-label.hyst { background: var(--gold); color: #000; }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.08; margin-bottom: 1.5rem; }
    .hero h1 .gold { color: var(--gold); }
    .hero-sub { font-size: clamp(1rem, 2vw, 1.2rem); color: #aaa; max-width: 600px; margin: 0 auto 3rem; line-height: 1.7; }
    .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: var(--gold); color: #000; font-weight: 700; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; transition: all 0.3s; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(217,119,6,0.5); }
    .btn-secondary { background: transparent; color: var(--text); font-weight: 600; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; border: 1px solid var(--glass-border); transition: all 0.3s; }
    .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }

    .fee-breakdown { position: relative; z-index: 1; padding: 0 1.5rem 5rem; max-width: 900px; margin: 0 auto; }
    .fee-title { text-align: center; font-family: 'Playfair Display', serif; font-size: 1.75rem; font-weight: 800; margin-bottom: 2rem; color: var(--danger); }
    .fee-bar-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .fee-bar-label { width: 200px; flex-shrink: 0; font-size: 0.875rem; font-weight: 500; }
    .fee-bar-track { flex: 1; height: 36px; background: rgba(255,255,255,0.05); border-radius: 8px; overflow: hidden; position: relative; }
    .fee-bar-fill { height: 100%; border-radius: 8px; display: flex; align-items: center; padding-left: 1rem; font-size: 0.8rem; font-weight: 700; color: white; }
    .fee-bar-fill.je { background: linear-gradient(90deg, var(--je), #FF4500); }
    .fee-bar-fill.hyst { background: linear-gradient(90deg, var(--gold), var(--gold-light)); color: #000; }
    .fee-pct { width: 60px; text-align: right; font-weight: 700; font-size: 0.9rem; }

    section { position: relative; z-index: 1; }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
    .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.25rem; }
    .section-body { color: #aaa; font-size: 1.0625rem; line-height: 1.8; max-width: 640px; }

    /* Features grid */
    .features-section { padding: 6rem 0; background: var(--bg2); }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .feat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; backdrop-filter: blur(12px); transition: all 0.3s; }
    .feat-card:hover { border-color: rgba(217,119,6,0.3); transform: translateY(-4px); }
    .feat-icon { font-size: 2.25rem; margin-bottom: 1rem; }
    .feat-title { font-weight: 700; font-size: 1.0625rem; margin-bottom: 0.5rem; }
    .feat-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* Compare table */
    .compare-section { padding: 6rem 0; }
    .compare-table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 3rem; border-radius: 20px; overflow: hidden; border: 1px solid var(--glass-border); }
    .compare-table thead th { padding: 1.5rem 1.25rem; font-size: 0.9rem; font-weight: 700; text-align: center; }
    .compare-table thead th:first-child { text-align: left; }
    .th-je { background: rgba(255,102,0,0.08); color: var(--je); }
    .th-hyst { background: var(--gold-dim); color: var(--gold); }
    .th-feature { background: var(--bg3); color: var(--muted); font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.06em; }
    .compare-table tbody tr { border-top: 1px solid var(--glass-border); }
    .compare-table tbody tr:hover { background: rgba(255,255,255,0.02); }
    .compare-table tbody td { padding: 1.1rem 1.25rem; font-size: 0.9375rem; vertical-align: middle; }
    .compare-table tbody td:not(:first-child) { text-align: center; }
    .tag-bad { color: var(--danger); font-weight: 700; }
    .tag-good { color: var(--success); font-weight: 700; }
    .tag-neutral { color: var(--muted); }
    .icon-check { color: var(--success); }
    .icon-cross { color: var(--danger); }

    /* Money saved section */
    .money-section { padding: 6rem 0; background: var(--bg2); }
    .money-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; margin-top: 3rem; }
    .money-card { background: linear-gradient(135deg, rgba(217,119,6,0.08), rgba(217,119,6,0.03)); border: 1px solid rgba(217,119,6,0.2); border-radius: 24px; padding: 2.5rem; }
    .money-label { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); margin-bottom: 0.5rem; }
    .money-figure { font-family: 'Playfair Display', serif; font-size: 4rem; font-weight: 900; color: var(--gold); line-height: 1; }
    .money-sub { font-size: 0.875rem; color: var(--muted); margin-top: 0.5rem; }
    .money-list { list-style: none; }
    .money-list li { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--glass-border); font-size: 0.9375rem; color: #ccc; }
    .money-list li::before { content: '✓'; color: var(--gold); font-weight: 700; flex-shrink: 0; }
    @media(max-width:640px){ .money-grid{grid-template-columns:1fr;} }

    /* CTA */
    .cta-section { padding: 8rem 0; text-align: center; position: relative; }
    .cta-glow { position: absolute; inset: 0; background: radial-gradient(ellipse at center, rgba(217,119,6,0.07) 0%, transparent 70%); pointer-events: none; }
    .cta-section h2 { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; margin-bottom: 1.25rem; }
    .cta-section p { color: #aaa; max-width: 520px; margin: 0 auto 3rem; font-size: 1.0625rem; line-height: 1.7; }

    footer { background: var(--bg); border-top: 1px solid var(--glass-border); padding: 3rem 1.5rem; text-align: center; position: relative; z-index: 1; }
    footer p { color: var(--muted); font-size: 0.875rem; }
    footer a { color: var(--gold); text-decoration: none; }
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

  <section class="hero">
    <div>
      <div class="vs-badge">
        <span class="vs-label">Just Eat</span>
        <span class="vs-sep">vs</span>
        <span class="vs-label hyst">Hyst</span>
      </div>
      <h1>Just Eat Takes a Cut.<br/><span class="gold">Hyst Takes Nothing.</span></h1>
      <p class="hero-sub">Just Eat's fees stack up fast — commission, payment processing, tablet rental, and more. With Hyst, you pay a simple flat fee and keep everything else.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Switch to Commission-Free →</a>
        <a href="#compare" class="btn-secondary">Compare the Fees</a>
      </div>
    </div>
  </section>

  <!-- Fee bars -->
  <div class="fee-breakdown" data-aos="fade-up">
    <div class="fee-title">Just Eat's Real Cost Per £100 Order</div>
    <div class="fee-bar-row">
      <div class="fee-bar-label">Commission (up to)</div>
      <div class="fee-bar-track"><div class="fee-bar-fill je" style="width:50%">Commission</div></div>
      <div class="fee-pct tag-bad">14%</div>
    </div>
    <div class="fee-bar-row">
      <div class="fee-bar-label">Payment processing</div>
      <div class="fee-bar-track"><div class="fee-bar-fill je" style="width:15%">PF</div></div>
      <div class="fee-pct tag-bad">1.9%</div>
    </div>
    <div class="fee-bar-row">
      <div class="fee-bar-label">Tablet / tech fee</div>
      <div class="fee-bar-track"><div class="fee-bar-fill je" style="width:10%">T</div></div>
      <div class="fee-pct tag-bad">£60/mo</div>
    </div>
    <div class="fee-bar-row">
      <div class="fee-bar-label" style="font-weight:700;color:var(--gold)">Hyst (total)</div>
      <div class="fee-bar-track"><div class="fee-bar-fill hyst" style="width:8%">Hyst</div></div>
      <div class="fee-pct tag-good">0%</div>
    </div>
  </div>

  <!-- Features -->
  <section class="features-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Why restaurants switch</p>
      <h2 class="section-title" data-aos="fade-up">What You Actually Get with Hyst</h2>
      <div class="features-grid">
        <div class="feat-card" data-aos="fade-up" data-aos-delay="0">
          <div class="feat-icon">📊</div>
          <div class="feat-title">Your customer data</div>
          <div class="feat-body">Just Eat owns every customer's contact details. Hyst gives you full access — email, phone, order history. Market to them whenever you want.</div>
        </div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="100">
          <div class="feat-icon">🏷️</div>
          <div class="feat-title">Your brand, not Just Eat's</div>
          <div class="feat-body">On Just Eat, customers are loyal to the platform. With Hyst, they order directly from you, building loyalty to your restaurant.</div>
        </div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="200">
          <div class="feat-icon">💳</div>
          <div class="feat-title">Loyalty & rewards</div>
          <div class="feat-body">Just Eat's loyalty is Just Eat's — not yours. Build your own programme: stamps, points, birthday rewards. Keep customers coming back to you.</div>
        </div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="300">
          <div class="feat-icon">📱</div>
          <div class="feat-title">QR table ordering</div>
          <div class="feat-body">Turn every table into a direct ordering touchpoint. Customers scan, order, and pay — no app download needed, no Just Eat involved.</div>
        </div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="400">
          <div class="feat-icon">🔗</div>
          <div class="feat-title">POS integration</div>
          <div class="feat-body">Orders flow straight into your existing POS. No extra tablet. No manual re-entry. Just clean, efficient service.</div>
        </div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="500">
          <div class="feat-icon">📈</div>
          <div class="feat-title">Real analytics</div>
          <div class="feat-body">See which customers order most, peak times, popular items, and reorder rates. Just Eat keeps this data. Hyst shares it all with you.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Compare table -->
  <section class="compare-section" id="compare">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">The honest breakdown</p>
      <h2 class="section-title" data-aos="fade-up">Just Eat vs Hyst: Side by Side</h2>
      <div style="overflow-x:auto" data-aos="fade-up">
        <table class="compare-table">
          <thead>
            <tr>
              <th class="th-feature">Feature</th>
              <th class="th-je">🍕 Just Eat</th>
              <th class="th-hyst">⚡ Hyst</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Commission per order</td><td class="tag-bad">Up to 14% + fees</td><td class="tag-good">0%</td></tr>
            <tr><td>Payment processing fee</td><td class="tag-bad">~1.9% extra</td><td class="tag-good">Included</td></tr>
            <tr><td>Tablet / hardware fee</td><td class="tag-bad">£60+/month</td><td class="tag-good">None needed</td></tr>
            <tr><td>Customer data access</td><td class="icon-cross">✕ Just Eat owns it</td><td class="icon-check">✓ Full access</td></tr>
            <tr><td>Direct marketing to customers</td><td class="icon-cross">✕ Prohibited</td><td class="icon-check">✓ Email + SMS included</td></tr>
            <tr><td>Own loyalty programme</td><td class="icon-cross">✕ Their loyalty only</td><td class="icon-check">✓ Fully customisable</td></tr>
            <tr><td>Branded ordering page</td><td class="icon-cross">✕ Just Eat branded</td><td class="icon-check">✓ Your brand</td></tr>
            <tr><td>Table QR ordering</td><td class="icon-cross">✕ Delivery only</td><td class="icon-check">✓ Full dine-in support</td></tr>
            <tr><td>Analytics & reporting</td><td class="tag-neutral">Basic / limited</td><td class="icon-check">✓ Full customer insights</td></tr>
            <tr><td>Setup time</td><td class="tag-neutral">Up to 4 weeks</td><td class="tag-good">Under 48 hours</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Money saved -->
  <section class="money-section">
    <div class="container">
      <div class="money-grid">
        <div data-aos="fade-right">
          <p class="section-eyebrow">The maths</p>
          <h2 class="section-title">On £15,000/month through Just Eat, you lose:</h2>
          <div class="money-card" style="margin-top:2rem">
            <div class="money-label">Monthly drain to Just Eat</div>
            <div class="money-figure">£2,400+</div>
            <div class="money-sub">Commission, processing fees, hardware rental</div>
          </div>
          <div class="money-card" style="margin-top:1rem;background:linear-gradient(135deg,rgba(34,197,94,0.08),rgba(34,197,94,0.03));border-color:rgba(34,197,94,0.2)">
            <div class="money-label" style="color:var(--success)">With Hyst instead, you save</div>
            <div class="money-figure" style="color:var(--success)">£28,800</div>
            <div class="money-sub">Per year — enough for a second hire</div>
          </div>
        </div>
        <div data-aos="fade-left">
          <p class="section-eyebrow">What comes with Hyst</p>
          <ul class="money-list">
            <li>Commission-free direct ordering, forever</li>
            <li>Branded ordering page and QR menus</li>
            <li>Full customer database — yours to keep</li>
            <li>Built-in loyalty and stamp card programmes</li>
            <li>Email and SMS marketing tools</li>
            <li>Real-time analytics and order insights</li>
            <li>POS integration with major providers</li>
            <li>Dedicated onboarding support</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">No lock-in</p>
      <h2>Your Restaurant. Your Revenue.</h2>
      <p>Stop splitting your earnings with Just Eat. Get your own direct ordering system up in 48 hours with zero commission, zero contract.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Get Started Free →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. For independent restaurants who mean business. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, offset: 60 });
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let W = canvas.width = window.innerWidth, H = canvas.height = window.innerHeight;
    const pts = Array.from({length:55},()=>({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.5+0.5,vx:(Math.random()-0.5)*0.25,vy:(Math.random()-0.5)*0.25,o:Math.random()*0.35+0.08}));
    function draw(){ctx.clearRect(0,0,W,H);pts.forEach(p=>{ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);ctx.fillStyle=`rgba(217,119,6,${p.o})`;ctx.fill();p.x+=p.vx;p.y+=p.vy;if(p.x<0||p.x>W)p.vx*=-1;if(p.y<0||p.y>H)p.vy*=-1;});requestAnimationFrame(draw);}
    draw();
    window.addEventListener('resize',()=>{W=canvas.width=window.innerWidth;H=canvas.height=window.innerHeight;});
    gsap.from('.hero > div > *',{y:30,opacity:0,stagger:0.15,duration:0.9,ease:'power3.out',delay:0.3});
    // Animate fee bars on scroll
    gsap.utils.toArray('.fee-bar-fill').forEach(el=>{
      const w = el.style.width;
      el.style.width = '0';
      gsap.to(el,{width:w,duration:1.2,ease:'power2.out',scrollTrigger:{trigger:el,start:'top 85%'}});
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</body>
</html>
