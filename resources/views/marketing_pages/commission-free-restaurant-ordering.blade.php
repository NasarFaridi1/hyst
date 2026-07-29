<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Commission-Free Restaurant Ordering | Hyst</title>
  <meta name="description" content="Commission-free online ordering for UK restaurants. No per-order fees, no contracts, no hidden costs. Set up your direct ordering system in under 48 hours." />
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
    }
    html { scroll-behavior: smooth; }
    body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; overflow-x: hidden; }
    #particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
    .blob { position: fixed; border-radius: 50%; filter: blur(130px); opacity: 0.1; pointer-events: none; z-index: 0; animation: drift 20s ease-in-out infinite alternate; }
    .blob-1 { width: 700px; height: 700px; background: var(--gold); top: -300px; right: -200px; }
    .blob-2 { width: 400px; height: 400px; background: #7C3AED; bottom: 0; left: -100px; animation-delay: -10s; }
    @keyframes drift { from{transform:translate(0,0)} to{transform:translate(35px,28px)} }

    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.88); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--gold-dim); border: 1px solid rgba(217,119,6,0.3); color: var(--gold); font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 2rem; letter-spacing: 0.08em; text-transform: uppercase; }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.08; margin-bottom: 1.5rem; }
    .hero h1 .gold { color: var(--gold); }
    .hero-sub { font-size: clamp(1rem, 2vw, 1.2rem); color: #aaa; max-width: 620px; margin: 0 auto 3rem; line-height: 1.7; }
    .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: var(--gold); color: #000; font-weight: 700; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; transition: all 0.3s; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(217,119,6,0.5); }
    .btn-secondary { background: transparent; color: var(--text); font-weight: 600; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; border: 1px solid var(--glass-border); transition: all 0.3s; }
    .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }

    /* Stats */
    .stats-row { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto; padding: 0 1.5rem 5rem; }
    .stat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.75rem 1.5rem; text-align: center; backdrop-filter: blur(12px); }
    .stat-number { font-family: 'Playfair Display', serif; font-size: 2.75rem; font-weight: 900; color: var(--gold); line-height: 1; }
    .stat-label { font-size: 0.875rem; color: var(--muted); margin-top: 0.5rem; }

    section { position: relative; z-index: 1; }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
    .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.25rem; }
    .section-body { color: #aaa; font-size: 1.0625rem; line-height: 1.8; }

    /* How it works */
    .how-section { padding: 6rem 0; background: var(--bg2); }
    .steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .step-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; backdrop-filter: blur(12px); position: relative; overflow: hidden; transition: all 0.3s; }
    .step-card:hover { transform: translateY(-4px); border-color: rgba(217,119,6,0.3); box-shadow: 0 20px 60px rgba(217,119,6,0.1); }
    .step-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--gold), transparent); }
    .step-num { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900; color: var(--gold-dim); line-height: 1; margin-bottom: 0.75rem; }
    .step-title { font-size: 1.0625rem; font-weight: 700; margin-bottom: 0.5rem; }
    .step-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* Features grid */
    .features-section { padding: 6rem 0; }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .feat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; transition: all 0.3s; }
    .feat-card:hover { border-color: rgba(217,119,6,0.25); }
    .feat-icon { font-size: 2.25rem; margin-bottom: 1rem; }
    .feat-title { font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem; }
    .feat-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }
    .feat-tag { display: inline-block; background: var(--gold-dim); color: var(--gold); font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 50px; margin-top: 0.75rem; letter-spacing: 0.06em; text-transform: uppercase; }

    /* Pricing */
    .pricing-section { padding: 6rem 0; background: var(--bg2); }
    .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 3rem; align-items: start; }
    .plan-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 24px; padding: 2.5rem; position: relative; overflow: hidden; }
    .plan-card.featured { border-color: rgba(217,119,6,0.4); background: linear-gradient(135deg, rgba(217,119,6,0.06), var(--glass)); }
    .plan-card.featured::before { content: 'MOST POPULAR'; position: absolute; top: 1.25rem; right: 1.25rem; background: var(--gold); color: #000; font-size: 0.65rem; font-weight: 800; padding: 0.25rem 0.75rem; border-radius: 50px; letter-spacing: 0.08em; }
    .plan-name { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); margin-bottom: 0.5rem; }
    .plan-price { font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 900; color: var(--gold); line-height: 1; }
    .plan-price span { font-size: 1.25rem; font-weight: 500; color: var(--muted); }
    .plan-desc { font-size: 0.875rem; color: var(--muted); margin: 0.75rem 0 1.5rem; }
    .plan-features { list-style: none; }
    .plan-features li { display: flex; align-items: flex-start; gap: 0.625rem; padding: 0.5rem 0; font-size: 0.875rem; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .plan-features li::before { content: '✓'; color: var(--gold); font-weight: 700; flex-shrink: 0; }
    .plan-btn { display: block; text-align: center; margin-top: 2rem; padding: 0.875rem; border-radius: 50px; font-weight: 700; font-size: 0.9375rem; text-decoration: none; transition: all 0.3s; }
    .plan-btn.primary { background: var(--gold); color: #000; }
    .plan-btn.primary:hover { background: var(--gold-light); }
    .plan-btn.outline { border: 1px solid var(--glass-border); color: var(--text); }
    .plan-btn.outline:hover { border-color: var(--gold); color: var(--gold); }

    /* CTA */
    .cta-section { padding: 8rem 0; text-align: center; position: relative; }
    .cta-glow { position: absolute; inset: 0; background: radial-gradient(ellipse at center, rgba(217,119,6,0.07) 0%, transparent 70%); pointer-events: none; }
    .cta-section h2 { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; margin-bottom: 1.25rem; }
    .cta-section p { color: #aaa; max-width: 540px; margin: 0 auto 3rem; font-size: 1.0625rem; line-height: 1.7; }

    footer { background: var(--bg); border-top: 1px solid var(--glass-border); padding: 3rem 1.5rem; text-align: center; position: relative; z-index: 1; }
    footer p { color: var(--muted); font-size: 0.875rem; }
    footer a { color: var(--gold); text-decoration: none; }
  </style>
</head>
<body>
  <canvas id="particles"></canvas>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <nav>
    <div class="logo">Hyst</div>
    <a href="#get-started" class="nav-cta">Start Free →</a>
  </nav>

  <section class="hero">
    <div>
      <div class="hero-badge">✦ 0% Commission Forever</div>
      <h1>Commission-Free Ordering<br/>for <span class="gold">Independent Restaurants</span></h1>
      <p class="hero-sub">Your own branded ordering system. No per-order commission. No middleman. Customers order directly from you — and every penny of profit stays where it belongs.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Get Started Free — 0% Commission</a>
        <a href="#how" class="btn-secondary">How It Works</a>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <div class="stats-row">
    <div class="stat-card" data-aos="fade-up"><div class="stat-number" data-count="0">0</div><div style="font-size:1.2rem;color:var(--gold)">%</div><div class="stat-label">Commission on every order</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="100"><div class="stat-number" data-count="48">0</div><div style="font-size:1.2rem;color:var(--gold)">hr</div><div class="stat-label">To go live with your system</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="200"><div class="stat-number" data-count="100">0</div><div style="font-size:1.2rem;color:var(--gold)">%</div><div class="stat-label">Customer data ownership</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="300"><div class="stat-number" data-count="2400">0</div><div style="font-size:1.2rem;color:var(--gold)">+</div><div class="stat-label">UK restaurants using Hyst</div></div>
  </div>

  <!-- How it works -->
  <section class="how-section" id="how">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Live in 48 hours</p>
      <h2 class="section-title" data-aos="fade-up">Getting Started Is Simpler Than You Think</h2>
      <div class="steps">
        <div class="step-card" data-aos="fade-up" data-aos-delay="0">
          <div class="step-num">01</div>
          <div class="step-title">Build your menu</div>
          <div class="step-body">Import from your existing POS or build from scratch with our drag-and-drop menu builder. Add photos, modifiers, and categories in minutes.</div>
        </div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="100">
          <div class="step-num">02</div>
          <div class="step-title">Get your ordering link</div>
          <div class="step-body">Your personalised ordering page is ready instantly. Share it on Google, Instagram, WhatsApp, and via QR codes on tables and takeaway bags.</div>
        </div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="200">
          <div class="step-num">03</div>
          <div class="step-title">Accept orders directly</div>
          <div class="step-body">Orders land in your POS and on your printer. Payments go straight to your account. No waiting for weekly marketplace payouts.</div>
        </div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="300">
          <div class="step-num">04</div>
          <div class="step-title">Build customer loyalty</div>
          <div class="step-body">Every customer who orders is yours — email, phone, order history. Run promotions, loyalty programmes, and re-engagement campaigns whenever you want.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="features-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Everything included</p>
      <h2 class="section-title" data-aos="fade-up">One Platform, Everything You Need</h2>
      <div class="features-grid">
        <div class="feat-card" data-aos="fade-up"><div class="feat-icon">🌐</div><div class="feat-title">Branded ordering page</div><div class="feat-body">A beautiful, mobile-optimised ordering page with your logo, colours, and domain. No Hyst branding visible to customers.</div><div class="feat-tag">Included</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="50"><div class="feat-icon">📱</div><div class="feat-title">QR table ordering</div><div class="feat-body">Customers scan a QR code at their table, order, and pay without waiting for staff. Works on any smartphone, no app download.</div><div class="feat-tag">Included</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="100"><div class="feat-icon">💌</div><div class="feat-title">Email & SMS marketing</div><div class="feat-body">Built-in tools to send promotions, reorder nudges, and birthday offers to your customer list. Your audience, your messages.</div><div class="feat-tag">Included</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="150"><div class="feat-icon">🏅</div><div class="feat-title">Loyalty programme</div><div class="feat-body">Stamp cards, points, and tier rewards. Keeps customers ordering from you — not from the next restaurant on a platform.</div><div class="feat-tag">Included</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="200"><div class="feat-icon">🔌</div><div class="feat-title">POS integration</div><div class="feat-body">Works with Square, Lightspeed, Tevalis, Epos Now, and more. Orders flow straight to your kitchen without any manual steps.</div><div class="feat-tag">Included</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="250"><div class="feat-icon">📊</div><div class="feat-title">Real-time analytics</div><div class="feat-body">See who orders, how often, peak times, popular items, and churn. Use data to make smarter menu and marketing decisions.</div><div class="feat-tag">Included</div></div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section class="pricing-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Simple pricing</p>
      <h2 class="section-title" data-aos="fade-up">Flat Fee. Zero Commission. Always.</h2>
      <div class="pricing-grid" style="margin-top:3rem">
        <div class="plan-card" data-aos="fade-up">
          <div class="plan-name">Starter</div>
          <div class="plan-price">£49<span>/mo</span></div>
          <div class="plan-desc">Perfect for single-location restaurants just getting started with direct ordering.</div>
          <ul class="plan-features">
            <li>Branded ordering page</li>
            <li>QR table ordering</li>
            <li>Up to 500 orders/month</li>
            <li>Email marketing basics</li>
            <li>Basic POS integration</li>
          </ul>
          <a href="#" class="plan-btn outline">Get Started</a>
        </div>
        <div class="plan-card featured" data-aos="fade-up" data-aos-delay="100">
          <div class="plan-name">Growth</div>
          <div class="plan-price">£99<span>/mo</span></div>
          <div class="plan-desc">The full stack for restaurants serious about owning their customer relationships.</div>
          <ul class="plan-features">
            <li>Everything in Starter</li>
            <li>Unlimited orders</li>
            <li>Full loyalty programme</li>
            <li>Email + SMS marketing</li>
            <li>Advanced analytics</li>
            <li>Priority POS sync</li>
          </ul>
          <a href="#" class="plan-btn primary">Start Free Trial</a>
        </div>
        <div class="plan-card" data-aos="fade-up" data-aos-delay="200">
          <div class="plan-name">Multi-Site</div>
          <div class="plan-price">£199<span>/mo</span></div>
          <div class="plan-desc">For restaurant groups and franchises managing multiple locations.</div>
          <ul class="plan-features">
            <li>Everything in Growth</li>
            <li>Unlimited locations</li>
            <li>Central menu management</li>
            <li>Multi-location reporting</li>
            <li>Dedicated account manager</li>
            <li>Custom integrations</li>
          </ul>
          <a href="#" class="plan-btn outline">Talk to Sales</a>
        </div>
      </div>
      <p style="margin-top:2rem;color:var(--muted);font-size:0.875rem">All plans include 0% commission on every order. No hidden fees. Cancel anytime.</p>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">Commission-free starts today</p>
      <h2>Your Restaurant. Your Orders.<br/>Your Profit.</h2>
      <p>Try Hyst free for 30 days. No credit card required. Set up in under an hour and start taking commission-free orders today.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Start Free — 0% Commission Forever →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. Commission-free ordering for UK restaurants. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, offset: 60 });
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let W = canvas.width = window.innerWidth, H = canvas.height = window.innerHeight;
    const pts = Array.from({length:55},()=>({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.5+0.5,vx:(Math.random()-0.5)*0.25,vy:(Math.random()-0.5)*0.25,o:Math.random()*0.3+0.08}));
    function draw(){ctx.clearRect(0,0,W,H);pts.forEach(p=>{ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);ctx.fillStyle=`rgba(217,119,6,${p.o})`;ctx.fill();p.x+=p.vx;p.y+=p.vy;if(p.x<0||p.x>W)p.vx*=-1;if(p.y<0||p.y>H)p.vy*=-1;});requestAnimationFrame(draw);}
    draw();
    window.addEventListener('resize',()=>{W=canvas.width=window.innerWidth;H=canvas.height=window.innerHeight;});
    gsap.registerPlugin(ScrollTrigger);
    document.querySelectorAll('[data-count]').forEach(el=>{
      const target=+el.dataset.count;
      ScrollTrigger.create({trigger:el,start:'top 85%',once:true,onEnter:()=>{
        gsap.fromTo(el,{innerText:0},{innerText:target,duration:1.8,ease:'power2.out',snap:{innerText:1},onUpdate:function(){el.innerText=Math.round(this.targets()[0].innerText);}});
      }});
    });
    gsap.from('.hero > div > *',{y:30,opacity:0,stagger:0.15,duration:0.9,ease:'power3.out',delay:0.3});
  </script>
</body>
</html>
