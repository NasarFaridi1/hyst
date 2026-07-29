<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant POS Integration – Direct Orders Straight to Your Till | Hyst</title>
  <meta name="description" content="Hyst integrates with 40+ POS systems including Square, Lightspeed, and Epos Now. Direct orders go straight to your kitchen — no extra tablets, no manual re-entry." />
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
    .blob { position: fixed; border-radius: 50%; filter: blur(130px); opacity: 0.09; pointer-events: none; z-index: 0; animation: drift 20s ease-in-out infinite alternate; }
    .blob-1 { width: 600px; height: 600px; background: var(--gold); top: -200px; right: -100px; }
    .blob-2 { width: 400px; height: 400px; background: #0EA5E9; bottom: 15%; left: -100px; animation-delay: -10s; }
    @keyframes drift { from{transform:translate(0,0)} to{transform:translate(30px,25px)} }
    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.88); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }
    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(14,165,233,0.1); border: 1px solid rgba(14,165,233,0.3); color: #38BDF8; font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 2rem; letter-spacing: 0.06em; }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.08; margin-bottom: 1.5rem; }
    .hero h1 .gold { color: var(--gold); }
    .hero-sub { font-size: clamp(1rem, 2vw, 1.2rem); color: #aaa; max-width: 620px; margin: 0 auto 3rem; line-height: 1.7; }
    .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: var(--gold); color: #000; font-weight: 700; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; transition: all 0.3s; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(217,119,6,0.5); }
    .btn-secondary { background: transparent; color: var(--text); font-weight: 600; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; border: 1px solid var(--glass-border); transition: all 0.3s; }
    .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }
    section { position: relative; z-index: 1; }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
    .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.25rem; }

    /* Flow diagram */
    .flow-section { padding: 6rem 0; background: var(--bg2); }
    .flow { display: flex; align-items: center; justify-content: center; gap: 0; flex-wrap: wrap; margin-top: 3rem; }
    .flow-node { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.5rem 1.25rem; text-align: center; min-width: 130px; transition: all 0.3s; }
    .flow-node:hover { border-color: rgba(217,119,6,0.3); }
    .flow-node-icon { font-size: 2rem; margin-bottom: 0.5rem; }
    .flow-node-label { font-size: 0.8rem; font-weight: 600; }
    .flow-arrow { font-size: 1.5rem; color: var(--gold); padding: 0 0.75rem; }
    .flow-highlight { border-color: rgba(217,119,6,0.4); background: linear-gradient(135deg, rgba(217,119,6,0.08), var(--glass)); }

    /* POS grid */
    .pos-section { padding: 6rem 0; }
    .pos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .pos-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.75rem 1.25rem; text-align: center; transition: all 0.3s; }
    .pos-card:hover { border-color: rgba(217,119,6,0.3); transform: translateY(-2px); }
    .pos-icon { font-size: 2.25rem; margin-bottom: 0.75rem; }
    .pos-name { font-weight: 700; font-size: 0.9rem; margin-bottom: 0.25rem; }
    .pos-status { font-size: 0.75rem; color: var(--success); font-weight: 600; }

    /* Benefits */
    .benefits-section { padding: 6rem 0; background: var(--bg2); }
    .benefits-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .benefit-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; transition: all 0.3s; }
    .benefit-card:hover { border-color: rgba(217,119,6,0.25); }
    .benefit-icon { font-size: 2rem; margin-bottom: 1rem; }
    .benefit-title { font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem; }
    .benefit-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* FAQ */
    .faq-section { padding: 6rem 0; }
    .faq-list { max-width: 720px; margin: 3rem auto 0; }
    .faq-item { border-bottom: 1px solid var(--glass-border); }
    .faq-q { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 0; font-weight: 600; font-size: 0.9375rem; cursor: pointer; gap: 1rem; }
    .faq-q:hover { color: var(--gold); }
    .faq-toggle { color: var(--gold); font-size: 1.25rem; flex-shrink: 0; transition: transform 0.3s; }
    .faq-a { font-size: 0.875rem; color: var(--muted); line-height: 1.7; padding-bottom: 1.25rem; display: none; }
    .faq-item.open .faq-a { display: block; }
    .faq-item.open .faq-toggle { transform: rotate(45deg); }

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
    <a href="#get-started" class="nav-cta">Connect Your POS →</a>
  </nav>

  <section class="hero">
    <div>
      <div class="hero-badge">🔌 40+ POS Integrations</div>
      <h1>Direct Orders Go<br/><span class="gold">Straight to Your Kitchen</span></h1>
      <p class="hero-sub">Hyst integrates with every major POS system in the UK. Online orders, QR table orders, and delivery — all appearing automatically on your till and kitchen printer. Zero manual re-entry.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Connect Your POS Free →</a>
        <a href="#pos-list" class="btn-secondary">See All Integrations</a>
      </div>
    </div>
  </section>

  <!-- Flow diagram -->
  <section class="flow-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">How orders flow</p>
      <h2 class="section-title" data-aos="fade-up">Customer to Kitchen — Automatically</h2>
      <div class="flow" data-aos="fade-up">
        <div class="flow-node"><div class="flow-node-icon">📱</div><div class="flow-node-label">Customer orders<br/>on Hyst</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-node flow-highlight"><div class="flow-node-icon">⚡</div><div class="flow-node-label" style="color:var(--gold)">Hyst processes<br/>instantly</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-node"><div class="flow-node-icon">🖥️</div><div class="flow-node-label">Appears on<br/>your POS</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-node"><div class="flow-node-icon">🖨️</div><div class="flow-node-label">Prints in<br/>kitchen</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-node"><div class="flow-node-icon">✅</div><div class="flow-node-label">Customer<br/>confirmed</div></div>
      </div>
      <p style="margin-top:2rem;color:var(--muted);font-size:0.875rem">Average time from order placed to kitchen print: <strong style="color:var(--gold)">under 3 seconds</strong></p>
    </div>
  </section>

  <!-- POS list -->
  <section class="pos-section" id="pos-list">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Works with your setup</p>
      <h2 class="section-title" data-aos="fade-up">40+ POS Integrations</h2>
      <div class="pos-grid" data-aos="fade-up">
        <div class="pos-card"><div class="pos-icon">🟦</div><div class="pos-name">Square</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">💡</div><div class="pos-name">Lightspeed</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">⚡</div><div class="pos-name">Epos Now</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">🔶</div><div class="pos-name">Tevalis</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">🟩</div><div class="pos-name">TouchBistro</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">💳</div><div class="pos-name">SumUp</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">📊</div><div class="pos-name">Tabology</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">🔌</div><div class="pos-name">Kobas</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">🏷️</div><div class="pos-name">Clover</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">🟠</div><div class="pos-name">iKentoo</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">🔷</div><div class="pos-name">Oracle MICROS</div><div class="pos-status">✓ Connected</div></div>
        <div class="pos-card"><div class="pos-icon">➕</div><div class="pos-name">+ 30 more</div><div class="pos-status" style="color:var(--gold)">Ask us</div></div>
      </div>
    </div>
  </section>

  <!-- Benefits -->
  <section class="benefits-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Why integration matters</p>
      <h2 class="section-title" data-aos="fade-up">No Extra Tablets. No Manual Entry. No Errors.</h2>
      <div class="benefits-grid">
        <div class="benefit-card" data-aos="fade-up"><div class="benefit-icon">🚫</div><div class="benefit-title">No extra hardware</div><div class="benefit-body">Other ordering systems give you a separate tablet on the counter. Hyst sends orders directly to your existing POS — no new hardware, no new screen to manage.</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="100"><div class="benefit-icon">📋</div><div class="benefit-title">Menus stay in sync</div><div class="benefit-body">Update your menu on your POS and it syncs to Hyst automatically. No duplicate management. One source of truth for your whole operation.</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="200"><div class="benefit-icon">📊</div><div class="benefit-title">Unified reporting</div><div class="benefit-body">All orders — dine-in, takeaway, delivery — appear in one report. Total revenue, covers, and average spend across every channel in one view.</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="300"><div class="benefit-icon">🔄</div><div class="benefit-title">Real-time stock sync</div><div class="benefit-body">Run out of sea bass? Your POS marks it unavailable and it disappears from your online menu instantly. Customers can never order what you can't serve.</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="400"><div class="benefit-icon">⚡</div><div class="benefit-title">Instant order acknowledgment</div><div class="benefit-body">When your POS accepts an order, the customer gets an instant confirmation. If you're busy, you can set auto-accept with a predicted wait time.</div></div>
        <div class="benefit-card" data-aos="fade-up" data-aos-delay="500"><div class="benefit-icon">🛡️</div><div class="benefit-title">Reliable uptime</div><div class="benefit-body">Hyst's integration layer monitors every connection 24/7. If anything needs attention, our support team is notified before you are.</div></div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="faq-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Common questions</p>
      <h2 class="section-title" data-aos="fade-up">POS Integration FAQ</h2>
      <div class="faq-list" data-aos="fade-up">
        <div class="faq-item"><div class="faq-q">Does my POS need to be updated?<span class="faq-toggle">+</span></div><div class="faq-a">Not usually. Hyst integrates via API or middleware with most POS systems, so there's no update needed on your end. Our team handles the technical setup during onboarding.</div></div>
        <div class="faq-item"><div class="faq-q">What if my POS isn't on the list?<span class="faq-toggle">+</span></div><div class="faq-a">We add new integrations regularly. If your POS isn't listed, contact us — we can often connect to systems via API within a few days. We've never left a restaurant stuck.</div></div>
        <div class="faq-item"><div class="faq-q">How long does integration take?<span class="faq-toggle">+</span></div><div class="faq-a">For major POS systems, integration is completed during your onboarding call — typically under an hour. Custom or legacy systems may take a few days for our engineering team to connect.</div></div>
        <div class="faq-item"><div class="faq-q">What happens if the POS goes offline?<span class="faq-toggle">+</span></div><div class="faq-a">Hyst queues orders and delivers them the moment your POS reconnects. Customers are never left in the dark — they receive an estimated wait time during any interruption.</div></div>
        <div class="faq-item"><div class="faq-q">Can I manage menus from my POS?<span class="faq-toggle">+</span></div><div class="faq-a">Yes. For two-way integrations, updates made to your POS menu sync to Hyst automatically. You can also manage your Hyst menu independently if you prefer.</div></div>
        <div class="faq-item"><div class="faq-q">Is there a cost for POS integration?<span class="faq-toggle">+</span></div><div class="faq-a">No. POS integration is included in all Hyst plans. There's no setup fee, no monthly add-on, and no cost for switching POS systems in future.</div></div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">Seamless connection</p>
      <h2>Connect Your POS.<br/>Start Taking Direct Orders.</h2>
      <p>Our team handles the technical setup. You just tell us what POS you use, and we do the rest — usually in under an hour.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Connect Your POS Free →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. POS-integrated direct ordering for restaurants. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
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
    // FAQ accordion
    document.querySelectorAll('.faq-q').forEach(q=>{
      q.addEventListener('click',()=>{
        const item = q.parentElement;
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i=>i.classList.remove('open'));
        if(!wasOpen) item.classList.add('open');
      });
    });
  </script>
</body>
</html>
