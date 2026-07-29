<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant Loyalty Programme – Keep Customers Coming Back | Hyst</title>
  <meta name="description" content="Built-in digital loyalty programmes for restaurants. Stamp cards, points, and tier rewards that bring customers back — without a third-party app." />
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
    .blob-1 { width: 600px; height: 600px; background: var(--gold); top: -200px; right: -100px; }
    .blob-2 { width: 400px; height: 400px; background: #EC4899; bottom: 15%; left: -100px; animation-delay: -10s; }
    @keyframes drift { from{transform:translate(0,0)} to{transform:translate(30px,25px)} }
    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.88); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(217,119,6,0.1); border: 1px solid rgba(217,119,6,0.3); color: var(--gold); font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 2rem; letter-spacing: 0.06em; }
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

    /* Stamp card visual */
    .stamp-section { padding: 6rem 0; background: var(--bg2); }
    .stamp-demo { max-width: 500px; margin: 3rem auto 0; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 24px; padding: 2.5rem; text-align: center; backdrop-filter: blur(16px); }
    .stamp-title { font-size: 0.875rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; }
    .stamp-subtitle { font-size: 0.8rem; color: var(--muted); margin-bottom: 2rem; }
    .stamps-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0.75rem; margin-bottom: 1.5rem; }
    .stamp { width: 100%; aspect-ratio: 1; border-radius: 50%; border: 2px solid rgba(217,119,6,0.3); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; transition: all 0.3s; cursor: default; }
    .stamp.filled { background: linear-gradient(135deg, var(--gold), var(--gold-light)); border-color: var(--gold); box-shadow: 0 0 16px rgba(217,119,6,0.4); }
    .stamp-progress { font-size: 0.8rem; color: var(--muted); }
    .stamp-progress strong { color: var(--gold); }

    /* Programme types */
    .types-section { padding: 6rem 0; }
    .types-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .type-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; transition: all 0.3s; position: relative; overflow: hidden; }
    .type-card:hover { border-color: rgba(217,119,6,0.3); transform: translateY(-3px); }
    .type-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--gold), transparent); }
    .type-icon { font-size: 2.5rem; margin-bottom: 1rem; }
    .type-title { font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem; }
    .type-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }
    .type-example { margin-top: 1rem; background: var(--gold-dim); border: 1px solid rgba(217,119,6,0.2); border-radius: 10px; padding: 0.75rem; font-size: 0.8rem; color: var(--gold); font-style: italic; }

    /* Stats */
    .stats-section { padding: 6rem 0; background: var(--bg2); }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .stat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 2rem 1.5rem; text-align: center; }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900; color: var(--gold); line-height: 1; }
    .stat-lbl { font-size: 0.875rem; color: var(--muted); margin-top: 0.5rem; }

    /* Features */
    .features-section { padding: 6rem 0; }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .feat-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 16px; padding: 1.75rem; transition: all 0.3s; }
    .feat-card:hover { border-color: rgba(217,119,6,0.25); }
    .feat-icon { font-size: 1.75rem; margin-bottom: 0.75rem; }
    .feat-title { font-weight: 700; font-size: 0.9375rem; margin-bottom: 0.375rem; }
    .feat-body { font-size: 0.8125rem; color: var(--muted); line-height: 1.6; }

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
      <div class="hero-badge">🏅 Built-in Loyalty for Restaurants</div>
      <h1>Turn First-Timers Into<br/><span class="gold">Loyal Regulars</span></h1>
      <p class="hero-sub">A digital loyalty programme built into your direct ordering system. Stamp cards, points, and tier rewards that keep customers coming back — to you, not to a platform.</p>
      <div class="hero-actions">
        <a href="#get-started" class="btn-primary">Launch Your Loyalty Programme →</a>
        <a href="#types" class="btn-secondary">See How It Works</a>
      </div>
    </div>
  </section>

  <!-- Live stamp card demo -->
  <section class="stamp-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Interactive preview</p>
      <h2 class="section-title" data-aos="fade-up">What Your Customers See</h2>
      <div class="stamp-demo" data-aos="fade-up">
        <div class="stamp-title">🍕 Mamma's Pizzeria — Loyalty Card</div>
        <div class="stamp-subtitle">Collect 10 stamps, get a free pizza</div>
        <div class="stamps-grid" id="stamps"></div>
        <div class="stamp-progress"><strong id="stampCount">7</strong> of 10 stamps — <strong>3 more for your free pizza!</strong></div>
        <button onclick="addStamp()" style="margin-top:1.5rem;background:var(--gold);color:#000;border:none;font-weight:700;padding:0.75rem 1.75rem;border-radius:50px;cursor:pointer;font-size:0.9rem;">+ Add a Stamp</button>
      </div>
    </div>
  </section>

  <!-- Types -->
  <section class="types-section" id="types">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Choose your format</p>
      <h2 class="section-title" data-aos="fade-up">Three Loyalty Formats, All Built-In</h2>
      <div class="types-grid">
        <div class="type-card" data-aos="fade-up">
          <div class="type-icon">🎫</div>
          <div class="type-title">Stamp Cards</div>
          <div class="type-body">Classic and effective. Customers earn one stamp per order, redeem after a set number. Works brilliantly for cafés, takeaways, and regular visitors.</div>
          <div class="type-example">"Buy 9 coffees, get your 10th free"</div>
        </div>
        <div class="type-card" data-aos="fade-up" data-aos-delay="100">
          <div class="type-icon">💰</div>
          <div class="type-title">Points & Rewards</div>
          <div class="type-body">Customers earn points per pound spent. Redeem for discounts, free items, or exclusive experiences. Drives higher average order value.</div>
          <div class="type-example">"Earn 1 point per £1 — 100 points = £5 off"</div>
        </div>
        <div class="type-card" data-aos="fade-up" data-aos-delay="200">
          <div class="type-icon">👑</div>
          <div class="type-title">Tier Membership</div>
          <div class="type-body">Bronze, Silver, Gold tiers based on cumulative spend. Higher tiers unlock bigger discounts, priority booking, and exclusive menu items.</div>
          <div class="type-example">"Gold members get 15% off every order"</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <section class="stats-section">
    <div class="container" style="text-align:center">
      <p class="section-eyebrow" data-aos="fade-up">Why it works</p>
      <h2 class="section-title" data-aos="fade-up">The Numbers Behind Loyalty</h2>
      <div class="stats-grid">
        <div class="stat-card" data-aos="fade-up"><div class="stat-num" data-count="40">0</div><div style="font-size:1.5rem;color:var(--gold)">%</div><div class="stat-lbl">Higher lifetime value for loyalty members</div></div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100"><div class="stat-num" data-count="5">0</div><div style="font-size:1.5rem;color:var(--gold)">x</div><div class="stat-lbl">Cheaper to retain than acquire a new customer</div></div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="200"><div class="stat-num" data-count="67">0</div><div style="font-size:1.5rem;color:var(--gold)">%</div><div class="stat-lbl">More likely to recommend when in a loyalty programme</div></div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="300"><div class="stat-num" data-count="23">0</div><div style="font-size:1.5rem;color:var(--gold)">%</div><div class="stat-lbl">Higher average order from members</div></div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="features-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">Everything included</p>
      <h2 class="section-title" data-aos="fade-up">What Makes Hyst Loyalty Different</h2>
      <div class="features-grid">
        <div class="feat-card" data-aos="fade-up"><div class="feat-icon">📲</div><div class="feat-title">No app download needed</div><div class="feat-body">Customers access their loyalty card via SMS link or QR code. Works on any phone, no app store required.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="50"><div class="feat-icon">🔗</div><div class="feat-title">Tied to direct ordering</div><div class="feat-body">Stamps are only earned on direct orders through Hyst — not through Deliveroo or Just Eat. This incentivises customers to order from you directly.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="100"><div class="feat-icon">🎂</div><div class="feat-title">Birthday rewards</div><div class="feat-body">Automatically send a special offer on each customer's birthday. One of the highest-converting loyalty tactics in hospitality.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="150"><div class="feat-icon">📧</div><div class="feat-title">Automated re-engagement</div><div class="feat-body">Customers who haven't used their loyalty card in 30 days get an automatic nudge. Zero manual effort from you.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="200"><div class="feat-icon">📊</div><div class="feat-title">Loyalty analytics</div><div class="feat-body">See stamp redemption rates, top customers, and which rewards drive the most repeat orders. Know what's working.</div></div>
        <div class="feat-card" data-aos="fade-up" data-aos-delay="250"><div class="feat-icon">🎨</div><div class="feat-title">Fully branded</div><div class="feat-body">Your logo, your colours, your name. Customers see your brand at every touchpoint — not a third-party loyalty platform.</div></div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="get-started">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">Retention starts now</p>
      <h2>Start Your Loyalty Programme<br/>in Under an Hour</h2>
      <p>Hyst includes loyalty built into every plan. No extra fee. No third-party app. Just customers who keep coming back.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Launch Your Loyalty Programme →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. Restaurant loyalty that works for you. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, offset: 60 });
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let W = canvas.width = window.innerWidth, H = canvas.height = window.innerHeight;
    const pts = Array.from({length:50},()=>({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.5+0.5,vx:(Math.random()-0.5)*0.25,vy:(Math.random()-0.5)*0.25,o:Math.random()*0.3+0.08}));
    function draw(){ctx.clearRect(0,0,W,H);pts.forEach(p=>{ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);ctx.fillStyle=`rgba(217,119,6,${p.o})`;ctx.fill();p.x+=p.vx;p.y+=p.vy;if(p.x<0||p.x>W)p.vx*=-1;if(p.y<0||p.y>H)p.vy*=-1;});requestAnimationFrame(draw);}
    draw();
    window.addEventListener('resize',()=>{W=canvas.width=window.innerWidth;H=canvas.height=window.innerHeight;});
    gsap.registerPlugin(ScrollTrigger);
    // Stamp card
    let stampCount = 7;
    function renderStamps(){
      const grid = document.getElementById('stamps');
      grid.innerHTML = '';
      for(let i=0;i<10;i++){
        const s = document.createElement('div');
        s.className = 'stamp'+(i<stampCount?' filled':'');
        s.textContent = i<stampCount ? '🍕' : '';
        grid.appendChild(s);
      }
      document.getElementById('stampCount').textContent = stampCount;
    }
    window.addStamp = function(){
      if(stampCount < 10) {
        stampCount++;
        renderStamps();
        if(stampCount===10){
          setTimeout(()=>{stampCount=0;renderStamps();},1200);
        }
      }
    };
    renderStamps();
    // Counters
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
