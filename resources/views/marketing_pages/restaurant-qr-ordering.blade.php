<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant QR Ordering – Table Ordering Made Easy | Hyst</title>
  <meta name="description" content="QR code ordering for restaurants. Customers scan, order, and pay from their own phone — no app, no waiting, no errors. Set up in hours." />
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
    .blob { position: fixed; border-radius: 50%; filter: blur(130px); opacity: 0.09; pointer-events: none; z-index: 0; animation: drift 22s ease-in-out infinite alternate; }
    .blob-1 { width: 600px; height: 600px; background: var(--gold); top: -200px; left: -100px; }
    .blob-2 { width: 400px; height: 400px; background: #10B981; bottom: 10%; right: -100px; animation-delay: -11s; }
    @keyframes drift { from{transform:translate(0,0)} to{transform:translate(30px,25px)} }
    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.88); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #34D399; font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 2rem; letter-spacing: 0.06em; }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.08; margin-bottom: 1.5rem; }
    .hero h1 .gold { color: var(--gold); }
    .hero-sub { font-size: clamp(1rem, 2vw, 1.2rem); color: #aaa; max-width: 600px; margin: 0 auto 3rem; line-height: 1.7; }
    .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: var(--gold); color: #000; font-weight: 700; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; transition: all 0.3s; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(217,119,6,0.5); }
    .btn-secondary { background: transparent; color: var(--text); font-weight: 600; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; border: 1px solid var(--glass-border); transition: all 0.3s; }
    .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }

    section { position: relative; z-index: 1; }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
    .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.25rem; }

    /* QR visual */
    .qr-visual-section { padding: 6rem 0; background: var(--bg2); }
    .qr-demo { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; margin-top: 3rem; }
    .qr-phone { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 32px; padding: 1.5rem; max-width: 260px; margin: 0 auto; position: relative; }
    .qr-phone-header { background: rgba(255,255,255,0.05); border-radius: 16px 16px 0 0; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 600; color: var(--muted); text-align: center; margin: -1.5rem -1.5rem 1.5rem; }
    .qr-menu-item { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .qr-item-name { font-size: 0.875rem; font-weight: 500; }
    .qr-item-price { font-size: 0.875rem; color: var(--gold); font-weight: 700; }
    .qr-add-btn { background: var(--gold); color: #000; border: none; border-radius: 50%; width: 28px; height: 28px; font-size: 1rem; cursor: pointer; font-weight: 700; }
    .qr-order-btn { display: block; width: 100%; background: var(--gold); color: #000; border: none; border-radius: 50px; padding: 0.875rem; font-weight: 700; font-size: 0.9rem; cursor: pointer; margin-top: 1.5rem; }
    .qr-code-box { text-align: center; }
    .qr-code-svg { display: inline-block; width: 140px; height: 140px; background: white; border-radius: 16px; padding: 8px; margin: 0 auto 1.5rem; }
    .qr-label { font-size: 0.875rem; color: var(--muted); }
    .qr-label strong { color: var(--text); }
    @media(max-width:640px){ .qr-demo{grid-template-columns:1fr;} }

    /* Steps */
    .steps-section { padding: 6rem 0; }
    .steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .step-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; transition: all 0.3s; position: relative; overflow: hidden; }
    .step-card:hover { transform: translateY(-4px); border-color: rgba(217,119,6,0.3); }
    .step-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--gold), transparent); }
    .step-num { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900; color: var(--gold-dim); line-height: 1; margin-bottom: 0.75rem; }
    .step-title { font-size: 1.0625rem; font-weight: 700; margin-bottom: 0.5rem; }
    .step-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* Benefits */
    .benefits-section { padding: 6rem 0; background: var(--bg2); }
    .benefits-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .benefit-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; transition: all 0.3s; }
    .benefit-card:hover { border-color: rgba(217,119,6,0.25); }
    .benefit-icon { font-size: 2.25rem; margin-bottom: 1rem; }
    .benefit-title { font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem; }
    .benefit-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }
    .benefit-stat { margin-top: 0.875rem; font-size: 0.8rem; font-weight: 700; color: var(--gold); }

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
    <a href="#get-started" class="nav-cta">Get QR Ordering →</a>
  </nav>

  <section class="hero">
    <div>
      <div class="hero-badge">📱 Scan. Order. Done.</div>
      <h1>QR Ordering That<br/><span class="gold">Actually Works</span></h1>
      <p class="hero-sub">Every table becomes a self-service ordering point. Customers scan a QR code, browse your menu, order, and pay — no app download, no staff wait time, no errors.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Get QR Ordering Free →</a>
        <a href="#how" class="btn-secondary">See a Demo</a>
      </div>
    </div>
  </section>

  <!-- QR Demo -->
  <section class="qr-visual-section" id="how">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">See it live</p>
      <h2 class="section-title" data-aos="fade-up">From Scan to Kitchen in 60 Seconds</h2>
      <div class="qr-demo" data-aos="fade-up">
        <div class="qr-code-box">
          <div class="qr-code-svg">
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
              <rect width="100" height="100" fill="white"/>
              <rect x="5" y="5" width="35" height="35" rx="4" fill="#D97706"/>
              <rect x="10" y="10" width="25" height="25" rx="2" fill="white"/>
              <rect x="14" y="14" width="17" height="17" fill="#D97706"/>
              <rect x="60" y="5" width="35" height="35" rx="4" fill="#D97706"/>
              <rect x="65" y="10" width="25" height="25" rx="2" fill="white"/>
              <rect x="69" y="14" width="17" height="17" fill="#D97706"/>
              <rect x="5" y="60" width="35" height="35" rx="4" fill="#D97706"/>
              <rect x="10" y="65" width="25" height="25" rx="2" fill="white"/>
              <rect x="14" y="69" width="17" height="17" fill="#D97706"/>
              <rect x="48" y="48" width="8" height="8" fill="#D97706"/>
              <rect x="60" y="48" width="8" height="8" fill="#D97706"/>
              <rect x="72" y="48" width="8" height="8" fill="#D97706"/>
              <rect x="84" y="48" width="8" height="8" fill="#D97706"/>
              <rect x="48" y="60" width="8" height="8" fill="#D97706"/>
              <rect x="72" y="60" width="8" height="8" fill="#D97706"/>
              <rect x="60" y="72" width="8" height="8" fill="#D97706"/>
              <rect x="84" y="72" width="8" height="8" fill="#D97706"/>
              <rect x="48" y="84" width="8" height="8" fill="#D97706"/>
              <rect x="72" y="84" width="8" height="8" fill="#D97706"/>
              <rect x="84" y="84" width="8" height="8" fill="#D97706"/>
            </svg>
          </div>
          <div class="qr-label"><strong>Table 7 — The Crown Pub</strong><br/>Scan to view menu & order</div>
        </div>
        <div class="qr-phone">
          <div class="qr-phone-header">📱 The Crown — Table 7</div>
          <div class="qr-menu-item"><div><div class="qr-item-name">Fish & Chips</div></div><div style="display:flex;align-items:center;gap:0.5rem"><span class="qr-item-price">£14.50</span><button class="qr-add-btn">+</button></div></div>
          <div class="qr-menu-item"><div><div class="qr-item-name">Battered Cod</div></div><div style="display:flex;align-items:center;gap:0.5rem"><span class="qr-item-price">£12.00</span><button class="qr-add-btn">+</button></div></div>
          <div class="qr-menu-item"><div><div class="qr-item-name">Scampi Basket</div></div><div style="display:flex;align-items:center;gap:0.5rem"><span class="qr-item-price">£11.00</span><button class="qr-add-btn">+</button></div></div>
          <div class="qr-menu-item"><div><div class="qr-item-name">Mushy Peas</div></div><div style="display:flex;align-items:center;gap:0.5rem"><span class="qr-item-price">£2.50</span><button class="qr-add-btn">+</button></div></div>
          <button class="qr-order-btn">Place Order & Pay</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Steps -->
  <section class="steps-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Getting started</p>
      <h2 class="section-title" data-aos="fade-up">Set Up in Four Steps</h2>
      <div class="steps">
        <div class="step-card" data-aos="fade-up"><div class="step-num">01</div><div class="step-title">Build your menu</div><div class="step-body">Upload your menu with photos, prices, and modifiers. Takes 30–60 minutes. Import from your POS in seconds.</div></div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="100"><div class="step-num">02</div><div class="step-title">Generate your QR codes</div><div class="step-body">We create a unique QR code for each table. Download, print, and place them in tent cards, frames, or directly on your tables.</div></div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="200"><div class="step-num">03</div><div class="step-title">Connect your kitchen</div><div class="step-body">Orders print directly to your kitchen printer and sync to your POS. No extra screen needed — it just works.</div></div>
        <div class="step-card" data-aos="fade-up" data-aos-delay="300"><div class="step-num">04</div><div class="step-title">Start serving smarter</div><div class="step-body">Customers scan and order. Staff focus on service. You see higher table turns, bigger spend, and fewer errors.</div></div>
      </div>
    </div>
  </section>

  <!-- Benefits -->
  <section class="benefits-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">The payoff</p>
      <h2 class="section-title" data-aos="fade-up">What QR Ordering Does for Your Restaurant</h2>
      <div class="benefits-grid">
        <div class="benefit-card" data-aos="fade-up"><div class="benefit-icon">⏱️</div><div class="benefit-title">Faster table turns</div><div class="benefit-body">No waiting for a server to take orders. Customers order the moment they're ready, and the kitchen gets it instantly.</div><div class="benefit-stat">→ Average 18% faster table turn</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="100"><div class="benefit-icon">💷</div><div class="benefit-title">Higher average spend</div><div class="benefit-body">Customers who browse menus digitally order 18–23% more. Upsell suggestions and photos do the work automatically.</div><div class="benefit-stat">→ +£4.20 average spend per cover</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="200"><div class="benefit-icon">❌</div><div class="benefit-title">Fewer order errors</div><div class="benefit-body">Customers input their own orders. No mishearing, no miscommunication. Kitchen gets exactly what was ordered.</div><div class="benefit-stat">→ 90% reduction in order errors</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="300"><div class="benefit-icon">👥</div><div class="benefit-title">Staff work smarter</div><div class="benefit-body">Your team focuses on service and experience instead of taking orders. Better hospitality, happier staff, better reviews.</div><div class="benefit-stat">→ Handle 30% more covers per shift</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="400"><div class="benefit-icon">📊</div><div class="benefit-title">Rich dine-in data</div><div class="benefit-body">See exactly what table 4 ordered, when, and what they skipped. Use it to refine your menu, pricing, and promotions.</div><div class="benefit-stat">→ Full per-table analytics</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="500"><div class="benefit-icon">🏅</div><div class="benefit-title">Loyalty at the table</div><div class="benefit-body">Customers earn stamps on every dine-in order. Scan QR → order → earn stamp. No app, no friction.</div><div class="benefit-stat">→ Loyalty built into every visit</div></div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">Live in hours</p>
      <h2>Your Tables Are Ready<br/>for QR Ordering</h2>
      <p>Get set up in under 48 hours with no hardware costs, no long contract, and no commission on a single dine-in order.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Set Up QR Ordering Free →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. QR ordering for the modern restaurant. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, offset: 60 });
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let W = canvas.width = window.innerWidth, H = canvas.height = window.innerHeight;
    const pts = Array.from({length:50},()=>({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.5+0.5,vx:(Math.random()-0.5)*0.25,vy:(Math.random()-0.5)*0.25,o:Math.random()*0.3+0.08}));
    function draw(){ctx.clearRect(0,0,W,H);pts.forEach(p=>{ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);ctx.fillStyle=`rgba(217,119,6,${p.o})`;ctx.fill();p.x+=p.vx;p.y+=p.vy;if(p.x<0||p.x>W)p.vx*=-1;if(p.y<0||p.y>H)p.vy*=-1;});requestAnimationFrame(draw);}
    draw();
    window.addEventListener('resize',()=>{W=canvas.width=window.innerWidth;H=canvas.height=window.innerHeight;});
    gsap.from('.hero > div > *',{y:30,opacity:0,stagger:0.15,duration:0.9,ease:'power3.out',delay:0.3});
  </script>
</body>
</html>
