<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Direct Online Ordering for Restaurants – Own Your Orders | Hyst</title>
  <meta name="description" content="Your own direct online ordering page. No Deliveroo, no Just Eat, no commission. Customers order from your website — you keep 100% of the revenue." />
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
    .blob-2 { width: 450px; height: 450px; background: #6366F1; bottom: 0; left: -150px; animation-delay: -10s; }
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
    .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: var(--gold); color: #000; font-weight: 700; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; transition: all 0.3s; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(217,119,6,0.5); }
    .btn-secondary { background: transparent; color: var(--text); font-weight: 600; padding: 1rem 2.5rem; border-radius: 50px; text-decoration: none; font-size: 1rem; border: 1px solid var(--glass-border); transition: all 0.3s; }
    .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }
    section { position: relative; z-index: 1; }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
    .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.25rem; }

    /* Stats */
    .stats-row { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto; padding: 0 1.5rem 5rem; }
    .stat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.75rem 1.5rem; text-align: center; backdrop-filter: blur(12px); }
    .stat-number { font-family: 'Playfair Display', serif; font-size: 2.75rem; font-weight: 900; color: var(--gold); line-height: 1; }
    .stat-label { font-size: 0.875rem; color: var(--muted); margin-top: 0.5rem; }

    /* Channel breakdown */
    .channels-section { padding: 6rem 0; background: var(--bg2); }
    .channels-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; margin-top: 3rem; align-items: center; }
    .channel-list { }
    .channel-item { display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid var(--glass-border); }
    .channel-icon { font-size: 1.5rem; width: 44px; flex-shrink: 0; text-align: center; }
    .channel-name { font-weight: 600; font-size: 0.9375rem; }
    .channel-sub { font-size: 0.8rem; color: var(--muted); }
    .channel-badge { margin-left: auto; font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.75rem; border-radius: 50px; }
    .badge-free { background: rgba(34,197,94,0.1); color: var(--success); }
    .badge-link { background: var(--gold-dim); color: var(--gold); }
    .channel-visual { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; text-align: center; }
    .channel-visual-url { font-family: monospace; font-size: 0.9rem; color: var(--gold); background: rgba(217,119,6,0.05); border: 1px solid rgba(217,119,6,0.2); border-radius: 8px; padding: 0.625rem 1rem; margin: 1rem 0; display: inline-block; }
    @media(max-width:640px){ .channels-grid{grid-template-columns:1fr;} }

    /* Features */
    .features-section { padding: 6rem 0; }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .feat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; transition: all 0.3s; }
    .feat-card:hover { border-color: rgba(217,119,6,0.25); transform: translateY(-2px); }
    .feat-icon { font-size: 2rem; margin-bottom: 1rem; }
    .feat-title { font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem; }
    .feat-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* Timeline */
    .timeline-section { padding: 6rem 0; background: var(--bg2); }
    .timeline { max-width: 640px; margin: 3rem auto 0; }
    .timeline-item { display: flex; gap: 1.5rem; margin-bottom: 2rem; position: relative; }
    .timeline-item::before { content: ''; position: absolute; left: 19px; top: 44px; width: 2px; height: calc(100% + 0.5rem); background: linear-gradient(to bottom, var(--gold), transparent); }
    .timeline-item:last-child::before { display: none; }
    .timeline-dot { width: 40px; height: 40px; border-radius: 50%; background: var(--gold-dim); border: 2px solid var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: 800; font-size: 0.875rem; color: var(--gold); }
    .timeline-content { flex: 1; padding-top: 0.5rem; }
    .timeline-title { font-weight: 700; font-size: 1rem; margin-bottom: 0.25rem; }
    .timeline-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

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
      <div class="hero-badge">🌐 Your Own Ordering System</div>
      <h1>Direct Online Ordering<br/>That <span class="gold">Pays You Fairly</span></h1>
      <p class="hero-sub">Your own branded ordering page — share it anywhere, take orders from everywhere, pay zero commission on any of them. Your food. Your customers. Your money.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Get Your Ordering Page Free →</a>
        <a href="#channels" class="btn-secondary">How Customers Find You</a>
      </div>
    </div>
  </section>

  <div class="stats-row">
    <div class="stat-card" data-aos="fade-up"><div class="stat-number" data-count="0">0</div><div style="font-size:1.2rem;color:var(--gold)">%</div><div class="stat-label">Commission on every order</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="100"><div class="stat-number" data-count="100">0</div><div style="font-size:1.2rem;color:var(--gold)">%</div><div class="stat-label">Revenue goes to you</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="200"><div class="stat-number" data-count="48">0</div><div style="font-size:1.2rem;color:var(--gold)">hr</div><div class="stat-label">Setup time</div></div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="300"><div class="stat-number" data-count="100">0</div><div style="font-size:1.2rem;color:var(--gold)">%</div><div class="stat-label">Customer data ownership</div></div>
  </div>

  <!-- Channels -->
  <section class="channels-section" id="channels">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Every touchpoint covered</p>
      <h2 class="section-title" data-aos="fade-up">One Link. Shared Everywhere.</h2>
      <div class="channels-grid" data-aos="fade-up">
        <div class="channel-list">
          <div class="channel-item"><div class="channel-icon">🌐</div><div><div class="channel-name">Your website</div><div class="channel-sub">Embed the ordering widget or link</div></div><span class="channel-badge badge-link">Embed</span></div>
          <div class="channel-item"><div class="channel-icon">📍</div><div><div class="channel-name">Google Business</div><div class="channel-sub">"Order Online" button in search results</div></div><span class="channel-badge badge-free">Free traffic</span></div>
          <div class="channel-item"><div class="channel-icon">📸</div><div><div class="channel-name">Instagram</div><div class="channel-sub">Link in bio, story links, Reels CTA</div></div><span class="channel-badge badge-link">Link</span></div>
          <div class="channel-item"><div class="channel-icon">💬</div><div><div class="channel-name">WhatsApp</div><div class="channel-sub">Share link with saved contacts</div></div><span class="channel-badge badge-free">Direct</span></div>
          <div class="channel-item"><div class="channel-icon">📦</div><div><div class="channel-name">Packaging QR</div><div class="channel-sub">Convert marketplace customers to direct</div></div><span class="channel-badge badge-free">Re-order</span></div>
          <div class="channel-item"><div class="channel-icon">🪑</div><div><div class="channel-name">Table QR codes</div><div class="channel-sub">Dine-in ordering at every table</div></div><span class="channel-badge badge-free">In-venue</span></div>
        </div>
        <div class="channel-visual">
          <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.5rem">YOUR BRANDED ORDERING URL</div>
          <div class="channel-visual-url">order.yourmenu.co.uk</div>
          <div style="font-size:0.8rem;color:var(--muted);margin-bottom:1.5rem">or share as a link from any channel</div>
          <div style="font-size:3rem;margin-bottom:1rem">🍽️</div>
          <div style="font-size:0.875rem;color:#ccc;line-height:1.6">One ordering page. Every channel. Zero commission.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="features-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">What you get</p>
      <h2 class="section-title" data-aos="fade-up">A Complete Direct Ordering System</h2>
      <div class="features-grid">
        <div class="feat-card" data-aos="fade-up"><div class="feat-icon">🎨</div><div class="feat-title">Fully branded ordering page</div><div class="feat-body">Your logo, your colours, your domain. Looks completely native to your restaurant, not like a generic ordering tool.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="50"><div class="feat-icon">📱</div><div class="feat-title">Mobile-first design</div><div class="feat-body">Over 80% of orders come from phones. Hyst is built mobile-first so ordering is effortless on any device.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="100"><div class="feat-icon">🔌</div><div class="feat-title">POS integration</div><div class="feat-body">Direct orders go straight to your POS and kitchen printer. No manual re-entry. Instant confirmation to the customer.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="150"><div class="feat-icon">💳</div><div class="feat-title">All payment methods</div><div class="feat-body">Apple Pay, Google Pay, card, and cash on collection. One-click reorder for returning customers saves them time.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="200"><div class="feat-icon">🚗</div><div class="feat-title">Delivery or collection</div><div class="feat-body">Toggle delivery zones, minimum orders, and pickup slots. Full control over how and where you fulfil orders.</div></div>
        <div class="feat-card" data-aos="feat-up" data-aos-delay="250"><div class="feat-icon">📈</div><div class="feat-title">Order analytics</div><div class="feat-body">Track conversion rate, popular items, peak hours, repeat order rate, and customer lifetime value from one dashboard.</div></div>
      </div>
    </div>
  </section>

  <!-- Timeline -->
  <section class="timeline-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Live in 48 hours</p>
      <h2 class="section-title" data-aos="fade-up">Your First Direct Order Timeline</h2>
      <div class="timeline" data-aos="fade-up">
        <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-content"><div class="timeline-title">Day 1, Hour 1 — Menu uploaded</div><div class="timeline-body">Import from your POS or upload manually. Add photos and customise categories.</div></div></div>
        <div class="timeline-item"><div class="timeline-dot">2</div><div class="timeline-content"><div class="timeline-title">Day 1, Hour 2 — Page live</div><div class="timeline-body">Your ordering page is live at your custom URL. Share it wherever customers find you.</div></div></div>
        <div class="timeline-item"><div class="timeline-dot">3</div><div class="timeline-content"><div class="timeline-title">Day 1, Evening — First orders</div><div class="timeline-body">Add the link to Instagram bio and Google. First direct orders typically arrive within hours.</div></div></div>
        <div class="timeline-item"><div class="timeline-dot">4</div><div class="timeline-content"><div class="timeline-title">Day 7 — Customer list building</div><div class="timeline-body">Every customer who orders has opted in. Start building your direct marketing list from day one.</div></div></div>
        <div class="timeline-item"><div class="timeline-dot">5</div><div class="timeline-content"><div class="timeline-title">Month 1 — Commission-free growth</div><div class="timeline-body">Every order you've taken has cost you 0% commission. That money stays in your business.</div></div></div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">Your page. Your profit.</p>
      <h2>Get Your Direct Ordering<br/>Page Today</h2>
      <p>30 days free. No credit card. Take your first commission-free order before tomorrow morning.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Get Your Ordering Page Free →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. Direct online ordering for restaurants. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
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
