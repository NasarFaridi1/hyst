<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Why Food Costs More on Deliveroo & Just Eat | Hyst</title>
  <meta name="description" content="Restaurants charge 15–30% more on delivery platforms to cover commission costs. Here's the hidden economics — and how to fix it." />
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
    .blob { position: fixed; border-radius: 50%; filter: blur(140px); opacity: 0.09; pointer-events: none; z-index: 0; animation: drift 24s ease-in-out infinite alternate; }
    .blob-1 { width: 600px; height: 600px; background: var(--danger); top: -200px; right: -100px; }
    .blob-2 { width: 400px; height: 400px; background: var(--gold); bottom: 20%; left: -100px; animation-delay: -10s; }
    @keyframes drift { from{transform:translate(0,0)} to{transform:translate(30px,25px)} }

    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(13,13,13,0.88); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--gold); }
    .nav-cta { background: var(--gold); color: #000; font-weight: 700; font-size: 0.875rem; padding: 0.625rem 1.5rem; border-radius: 50px; text-decoration: none; transition: all 0.3s; }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

    .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 1.5rem 4rem; text-align: center; }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: var(--danger); font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 2rem; letter-spacing: 0.06em; text-transform: uppercase; }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.1; margin-bottom: 1.5rem; }
    .hero h1 .gold { color: var(--gold); }
    .hero h1 .red { color: var(--danger); }
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
    .section-body { color: #aaa; font-size: 1.0625rem; line-height: 1.8; }

    /* Receipt visual */
    .receipt-section { padding: 6rem 0; background: var(--bg2); }
    .receipt-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 3rem; align-items: start; }
    .receipt-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; }
    .receipt-header { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px dashed var(--glass-border); }
    .receipt-header.je { color: #FF6600; }
    .receipt-header.direct { color: var(--gold); }
    .receipt-row { display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.9rem; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .receipt-row .bad { color: var(--danger); font-weight: 600; }
    .receipt-row .good { color: var(--success); font-weight: 600; }
    .receipt-total { display: flex; justify-content: space-between; padding: 1rem 0 0; font-weight: 700; font-size: 1.1rem; border-top: 2px solid var(--glass-border); margin-top: 0.5rem; }
    .receipt-profit { font-size: 0.8rem; text-align: center; padding: 0.5rem; border-radius: 8px; margin-top: 0.75rem; font-weight: 600; }
    .receipt-profit.bad { background: rgba(239,68,68,0.1); color: var(--danger); }
    .receipt-profit.good { background: rgba(217,119,6,0.1); color: var(--gold); }
    @media(max-width:640px){ .receipt-grid{grid-template-columns:1fr;} }

    /* Explainer cards */
    .explainer-section { padding: 6rem 0; }
    .explainer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
    .explainer-card { background: var(--glass); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; }
    .explainer-card:hover { border-color: rgba(217,119,6,0.3); }
    .explainer-num { font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 900; color: var(--danger); line-height: 1; margin-bottom: 0.75rem; }
    .explainer-title { font-weight: 700; font-size: 1.0625rem; margin-bottom: 0.5rem; }
    .explainer-body { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* Surcharge visual */
    .surcharge-section { padding: 6rem 0; background: var(--bg2); }
    .surcharge-bar { margin-top: 3rem; }
    .surcharge-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem; }
    .s-label { width: 180px; flex-shrink: 0; font-size: 0.875rem; font-weight: 500; color: #ccc; }
    .s-track { flex: 1; height: 40px; background: rgba(255,255,255,0.04); border-radius: 10px; overflow: hidden; }
    .s-fill { height: 100%; display: flex; align-items: center; padding-left: 1rem; font-size: 0.8rem; font-weight: 600; color: white; transition: width 1.5s ease; }
    .s-pct { width: 70px; text-align: right; font-weight: 700; font-size: 0.9rem; }

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
    <a href="#fix-it" class="nav-cta">Get Direct Ordering →</a>
  </nav>

  <section class="hero">
    <div>
      <div class="hero-badge">⚠️ The platform price premium</div>
      <h1>Your £12 Burger Costs<br/><span class="red">£15.60</span> on <span class="gold">Just Eat</span></h1>
      <p class="hero-sub">Delivery platforms charge restaurants so much commission that restaurants have to inflate menu prices to survive. Customers pay more, restaurants earn less. The platform wins both ways.</p>
      <div class="hero-actions">
        <a href="#fix-it" class="btn-primary">Offer Real Prices Direct →</a>
        <a href="#the-maths" class="btn-secondary">See How It Works</a>
      </div>
    </div>
  </section>

  <!-- Receipt comparison -->
  <section class="receipt-section" id="the-maths">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">The same meal, two very different numbers</p>
      <h2 class="section-title" data-aos="fade-up">What a £50 Order Actually Means</h2>
      <div class="receipt-grid">
        <div class="receipt-card" data-aos="fade-right">
          <div class="receipt-header je">🍕 Just Eat / Deliveroo Order</div>
          <div class="receipt-row"><span>Inflated menu price (customer pays)</span><span>£57.50</span></div>
          <div class="receipt-row"><span>Delivery service fee</span><span class="bad">+£3.49</span></div>
          <div class="receipt-row"><span>Tip (prompted)</span><span class="bad">+£2.00</span></div>
          <div class="receipt-row"><span>Restaurant commission (30%)</span><span class="bad">-£15.00</span></div>
          <div class="receipt-row"><span>Payment processing</span><span class="bad">-£1.09</span></div>
          <div class="receipt-row"><span>Marketing / visibility fee</span><span class="bad">-£3.00</span></div>
          <div class="receipt-total"><span>Restaurant keeps</span><span class="bad">£38.41</span></div>
          <div class="receipt-profit bad">Real margin: ~28% of the original £50</div>
        </div>
        <div class="receipt-card" data-aos="fade-left">
          <div class="receipt-header direct">⚡ Hyst Direct Order</div>
          <div class="receipt-row"><span>Real menu price (customer pays)</span><span>£50.00</span></div>
          <div class="receipt-row"><span>Delivery service fee</span><span>£2.50</span></div>
          <div class="receipt-row"><span>Commission to platform</span><span class="good">£0.00</span></div>
          <div class="receipt-row"><span>Payment processing</span><span>-£0.99</span></div>
          <div class="receipt-row"><span>Marketing / visibility fee</span><span class="good">£0.00</span></div>
          <div class="receipt-row" style="visibility:hidden"><span>—</span><span>—</span></div>
          <div class="receipt-total"><span>Restaurant keeps</span><span class="good">£49.01</span></div>
          <div class="receipt-profit good">Real margin: ~98% of every order</div>
        </div>
      </div>
    </div>
  </section>

  <!-- The 3 reasons -->
  <section class="explainer-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">The hidden mechanics</p>
      <h2 class="section-title" data-aos="fade-up">Three Reasons Platforms Cost You More</h2>
      <div class="explainer-grid">
        <div class="explainer-card" data-aos="fade-up" data-aos-delay="0">
          <div class="explainer-num">01</div>
          <div class="explainer-title">Restaurants inflate prices to survive</div>
          <div class="explainer-body">With 25–35% commission per order, restaurants must mark up their platform menu by 15–30% just to maintain the same profit margin. Customers pay more without knowing why.</div>
        </div>
        <div class="explainer-card" data-aos="fade-up" data-aos-delay="100">
          <div class="explainer-num">02</div>
          <div class="explainer-title">Platforms pile on extra fees</div>
          <div class="explainer-body">Service fees, small order charges, and "priority delivery" upsells all add to the customer's total — none of which reaches the restaurant. The platform collects on both sides.</div>
        </div>
        <div class="explainer-card" data-aos="fade-up" data-aos-delay="200">
          <div class="explainer-num">03</div>
          <div class="explainer-title">Visibility requires paid placement</div>
          <div class="explainer-body">Want to appear in search results? Restaurants pay extra for promotion within the platform, on top of commission. This cost gets baked into menu prices.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Surcharge by platform -->
  <section class="surcharge-section">
    <div class="container">
      <p class="section-eyebrow" data-aos="fade-up">By platform</p>
      <h2 class="section-title" data-aos="fade-up">Average Price Markup on Platforms vs Direct</h2>
      <div class="surcharge-bar" data-aos="fade-up">
        <div class="surcharge-row">
          <div class="s-label">Deliveroo</div>
          <div class="s-track"><div class="s-fill" style="width:0%;background:linear-gradient(90deg,#EF4444,#DC2626)" data-width="72%" id="bar1">Deliveroo markup</div></div>
          <div class="s-pct" style="color:var(--danger)">~26%</div>
        </div>
        <div class="surcharge-row">
          <div class="s-label">Just Eat</div>
          <div class="s-track"><div class="s-fill" style="width:0%;background:linear-gradient(90deg,#FF6600,#FF4500)" data-width="64%" id="bar2">Just Eat markup</div></div>
          <div class="s-pct" style="color:#FF6600">~22%</div>
        </div>
        <div class="surcharge-row">
          <div class="s-label">Uber Eats</div>
          <div class="s-track"><div class="s-fill" style="width:0%;background:linear-gradient(90deg,#1DB954,#16A34A)" data-width="58%" id="bar3">Uber Eats markup</div></div>
          <div class="s-pct" style="color:#1DB954">~20%</div>
        </div>
        <div class="surcharge-row">
          <div class="s-label" style="color:var(--gold);font-weight:700">Hyst (direct)</div>
          <div class="s-track"><div class="s-fill" style="width:0%;background:linear-gradient(90deg,var(--gold),var(--gold-light));color:#000" data-width="3%" id="bar4">0%</div></div>
          <div class="s-pct" style="color:var(--gold)">0%</div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section" id="fix-it">
    <div class="cta-glow"></div>
    <div class="container" style="position:relative;z-index:1">
      <p class="section-eyebrow">The fix</p>
      <h2>Give Customers Real Prices.<br/>Keep Real Margins.</h2>
      <p>With direct ordering through Hyst, you charge fair prices, keep your margin, and stop funding a platform that earns more from your food than you do.</p>
      <a href="#" class="btn-primary" style="font-size:1.125rem;padding:1.25rem 3rem">Start Commission-Free Ordering →</a>
    </div>
  </section>

  <footer>
    <p>© 2025 Hyst. Fair pricing, starting with restaurants. &nbsp;|&nbsp; <a href="/privacy">Privacy</a> &nbsp;|&nbsp; <a href="/terms">Terms</a></p>
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
    gsap.from('.hero > div > *',{y:30,opacity:0,stagger:0.15,duration:0.9,ease:'power3.out',delay:0.3});
    gsap.registerPlugin(ScrollTrigger);
    ['bar1','bar2','bar3','bar4'].forEach(id=>{
      const el=document.getElementById(id);
      const target=el.dataset.width;
      ScrollTrigger.create({trigger:el,start:'top 85%',once:true,onEnter:()=>gsap.to(el,{width:target,duration:1.4,ease:'power2.out'})});
    });
  </script>
</body>
</html>
