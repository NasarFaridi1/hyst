<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant Ordering Platform UK – Direct Orders, No Commission | Hyst</title>
  <meta name="description" content="The UK's leading commission-free restaurant ordering platform. Take direct orders online and in-person without paying a penny to Deliveroo or Just Eat." />
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
    .blob-2 { width: 450px; height: 450px; background: #0EA5E9; bottom: 10%; right: -150px; animation-delay: -11s; }
    @keyframes drift { from{transform:translate(0,0)} to{transform:translate(30px,25px)} }
    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.88); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--gold-dim); border: 1px solid rgba(217,119,6,0.3); color: var(--gold); font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 2rem; letter-spacing: 0.08em; text-transform: uppercase; }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.08; margin-bottom: 1.5rem; }
    .hero h1 .gold { color: var(--gold); }
    .hero-sub { font-size: clamp(1rem, 2vw, 1.2rem); color: #aaa; max-width: 620px; margin: 0 auto 3rem; line-height: 1.7; }
    .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 3rem; }
    .btn-primary { background: var(--gold); color: #000; font-weight: 700; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; transition: all 0.3s; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(217,119,6,0.5); }
    .btn-secondary { background: transparent; color: var(--text); font-weight: 600; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; border: 1px solid var(--glass-border); transition: all 0.3s; }
    .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }
    .trusted-by { text-align: center; font-size: 0.8rem; color: var(--muted); font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; margin-top: 0.5rem; }

    .stats-row { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto; padding: 0 1.5rem 5rem; }
    .stat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.75rem 1.5rem; text-align: center; backdrop-filter: blur(12px); }
    .stat-number { font-family: 'Playfair Display', serif; font-size: 2.75rem; font-weight: 900; color: var(--gold); line-height: 1; }
    .stat-label { font-size: 0.875rem; color: var(--muted); margin-top: 0.5rem; }

    section { position: relative; z-index: 1; }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
    .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.25rem; }

    /* Use cases */
    .usecases-section { padding: 6rem 0; background: var(--bg2); }
    .usecase-tabs { display: flex; gap: 0.5rem; margin-top: 2rem; flex-wrap: wrap; }
    .usecase-tab { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 50px; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .usecase-tab.active, .usecase-tab:hover { background: var(--gold-dim); border-color: rgba(217,119,6,0.4); color: var(--gold); }
    .usecase-panels { margin-top: 2rem; }
    .usecase-panel { display: none; }
    .usecase-panel.active { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; }
    .panel-title { font-family: 'Playfair Display', serif; font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; }
    .panel-body { color: #aaa; line-height: 1.7; margin-bottom: 1.5rem; }
    .panel-list { list-style: none; }
    .panel-list li { display: flex; gap: 0.75rem; padding: 0.5rem 0; font-size: 0.9375rem; }
    .panel-list li::before { content: '✓'; color: var(--gold); font-weight: 700; flex-shrink: 0; }
    .panel-visual { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2.5rem; text-align: center; font-size: 5rem; }
    @media(max-width:640px){ .usecase-panel.active{grid-template-columns:1fr;} }

    /* Cities */
    .cities-section { padding: 6rem 0; }
    .cities-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem; margin-top: 3rem; }
    .city-pill { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 12px; padding: 0.875rem 1rem; text-align: center; font-size: 0.875rem; font-weight: 600; transition: all 0.3s; cursor: default; }
    .city-pill:hover { border-color: rgba(217,119,6,0.3); color: var(--gold); }
    .city-flag { font-size: 1.25rem; display: block; margin-bottom: 0.25rem; }

    /* Integrations */
    .integrations-section { padding: 6rem 0; background: var(--bg2); }
    .integrations-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .integration-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.5rem; text-align: center; transition: all 0.3s; }
    .integration-card:hover { border-color: rgba(217,119,6,0.3); transform: translateY(-2px); }
    .integration-icon { font-size: 2rem; margin-bottom: 0.5rem; }
    .integration-name { font-size: 0.8rem; font-weight: 600; color: var(--muted); }

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
      <div class="hero-badge">🇬🇧 Built for UK Restaurants</div>
      <h1>The UK's <span class="gold">Commission-Free</span><br/>Restaurant Ordering Platform</h1>
      <p class="hero-sub">Everything UK restaurants need to take orders directly — online, at the table, and via QR — without paying commission to Deliveroo, Just Eat, or anyone else.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Try Free for 30 Days →</a>
        <a href="#use-cases" class="btn-secondary">See How It Works</a>
      </div>
      <div class="trusted-by">Trusted by 2,400+ independent UK restaurants</div>
    </div>
  </section>

  <!-- Stats -->
  <div class="stats-row">
    <div class="stat-card" data-aos="fade-up"><div class="stat-number" data-count="2400">0</div><div style="font-size:1.2rem;color:var(--gold)">+</div><div class="stat-label">UK restaurants</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="100"><div class="stat-number" data-count="0">0</div><div style="font-size:1.2rem;color:var(--gold)">%</div><div class="stat-label">Commission forever</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="200"><div class="stat-number" data-count="4">0</div><div style="font-size:1.2rem;color:var(--gold)">M+</div><div class="stat-label">Orders processed</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="300"><div class="stat-number" data-count="40">0</div><div style="font-size:1.2rem;color:var(--gold)">+</div><div class="stat-label">POS integrations</div></div>
  </div>

  <!-- Use cases -->
  <section class="usecases-section" id="use-cases">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Every restaurant type</p>
      <h2 class="section-title" data-aos="fade-up">Hyst Works for Every Kind of Restaurant</h2>
      <div class="usecase-tabs" data-aos="fade-up">
        <div class="usecase-tab active" data-panel="takeaway">Takeaway</div>
        <div class="usecase-tab" data-panel="dinein">Dine-In</div>
        <div class="usecase-tab" data-panel="cafe">Café</div>
        <div class="usecase-tab" data-panel="group">Restaurant Group</div>
      </div>
      <div class="usecase-panels" data-aos="fade-up">
        <div class="usecase-panel active" id="panel-takeaway">
          <div>
            <div class="panel-title">Built for Takeaways</div>
            <div class="panel-body">Stop splitting your revenue with Just Eat. Take orders directly through your own page, shared via WhatsApp, Google, and social — with no commission on any of them.</div>
            <ul class="panel-list">
              <li>Your own ordering link — share anywhere</li>
              <li>Direct payout, no weekly marketplace delay</li>
              <li>Customer data yours for re-marketing</li>
              <li>Real-time order notifications on any device</li>
            </ul>
          </div>
          <div class="panel-visual">🥡<br/><span style="font-size:1rem;color:var(--gold);font-weight:700">0% commission</span></div>
        </div>
        <div class="usecase-panel" id="panel-dinein">
          <div>
            <div class="panel-title">Seamless Dine-In Ordering</div>
            <div class="panel-body">QR code ordering at every table — customers scan, browse your full menu, order, and pay without waiting for staff. Faster turns, fewer errors, bigger average spend.</div>
            <ul class="panel-list">
              <li>Table-specific QR codes</li>
              <li>No app download for customers</li>
              <li>Orders go directly to kitchen printer</li>
              <li>Integrated tab splitting and tipping</li>
            </ul>
          </div>
          <div class="panel-visual">🍽️<br/><span style="font-size:1rem;color:var(--gold);font-weight:700">Scan. Order. Done.</span></div>
        </div>
        <div class="usecase-panel" id="panel-cafe">
          <div>
            <div class="panel-title">Perfect for Cafés</div>
            <div class="panel-body">Pre-order with click-and-collect, QR table service, and loyalty stamp cards — everything your regulars love, with your branding on every touchpoint.</div>
            <ul class="panel-list">
              <li>Click and collect pre-ordering</li>
              <li>Digital loyalty stamp cards</li>
              <li>Seasonal menu updates in minutes</li>
              <li>Works alongside your till system</li>
            </ul>
          </div>
          <div class="panel-visual">☕<br/><span style="font-size:1rem;color:var(--gold);font-weight:700">Loyalty built-in</span></div>
        </div>
        <div class="usecase-panel" id="panel-group">
          <div>
            <div class="panel-title">Scales Across All Your Sites</div>
            <div class="panel-body">Manage menus, pricing, promotions, and reporting across every location from one central dashboard. Each site can be customised independently.</div>
            <ul class="panel-list">
              <li>Central menu and pricing control</li>
              <li>Per-location customisation</li>
              <li>Group-wide analytics</li>
              <li>Dedicated account manager</li>
            </ul>
          </div>
          <div class="panel-visual">🏢<br/><span style="font-size:1rem;color:var(--gold);font-weight:700">Multi-site ready</span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- UK cities -->
  <section class="cities-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Nationwide coverage</p>
      <h2 class="section-title" data-aos="fade-up">Restaurants Across the UK Trust Hyst</h2>
      <div class="cities-grid" data-aos="fade-up">
        <div class="city-pill"><span class="city-flag">🏙️</span>London</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Manchester</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Birmingham</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Leeds</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Bristol</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Edinburgh</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Glasgow</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Sheffield</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Liverpool</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Nottingham</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Cardiff</div>
        <div class="city-pill"><span class="city-flag">🏙️</span>Newcastle</div>
      </div>
    </div>
  </section>

  <!-- Integrations -->
  <section class="integrations-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Works with your existing setup</p>
      <h2 class="section-title" data-aos="fade-up">40+ POS and Tech Integrations</h2>
      <div class="integrations-grid" data-aos="fade-up">
        <div class="integration-card"><div class="integration-icon">🟦</div><div class="integration-name">Square</div></div>
        <div class="integration-card"><div class="integration-icon">💡</div><div class="integration-name">Lightspeed</div></div>
        <div class="integration-card"><div class="integration-icon">⚡</div><div class="integration-name">Epos Now</div></div>
        <div class="integration-card"><div class="integration-icon">🔶</div><div class="integration-name">Tevalis</div></div>
        <div class="integration-card"><div class="integration-icon">🟩</div><div class="integration-name">TouchBistro</div></div>
        <div class="integration-card"><div class="integration-icon">💳</div><div class="integration-name">SumUp</div></div>
        <div class="integration-card"><div class="integration-icon">📊</div><div class="integration-name">Tabology</div></div>
        <div class="integration-card"><div class="integration-icon">🔌</div><div class="integration-name">Kobas</div></div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">Start today</p>
      <h2>The UK's Smartest Restaurants<br/>Order Through Hyst</h2>
      <p>Try free for 30 days. No card needed. Zero commission on every order, from day one to forever.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Start Your Free Trial →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. The UK's commission-free restaurant ordering platform. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
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
    // Tab switching
    document.querySelectorAll('.usecase-tab').forEach(tab=>{
      tab.addEventListener('click',()=>{
        document.querySelectorAll('.usecase-tab').forEach(t=>t.classList.remove('active'));
        document.querySelectorAll('.usecase-panel').forEach(p=>p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById('panel-'+tab.dataset.panel).classList.add('active');
      });
    });
  </script>
</body>
</html>
