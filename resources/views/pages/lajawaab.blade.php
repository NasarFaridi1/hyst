<!DOCTYPE html>
<html lang="en-GB">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ============================= PRIMARY SEO, AEO & GEO ============================= -->
  <title>La Jawaab | Legendary Sindhi Chicken Biryani &amp; Street Food — Powered by HYST</title>
  <meta name="description"
    content="Craving authentic street food without paying 30%+ app markups? La Jawaab brings you legendary Sindhi Chicken Biryani, Chole Bhature &amp; Halwa Puri. Order direct via HYST for zero commission delivery!">
  <meta name="keywords"
    content="La Jawaab, HYST food delivery, Sindhi Chicken Biryani, Chole Bhature, Halwa Puri Channa, zero commission food delivery, best street food UK, GenZ food deals, order food online direct, cheap biryani delivery, squad food deals">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
  <meta name="author" content="La Jawaab x HYST">
  <link rel="canonical" href="https://www.lajawaab.co.uk/">
  <meta name="theme-color" content="#C25A2A">

  <!-- Open Graph / Social Media -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="La Jawaab x HYST">
  <meta property="og:title" content="La Jawaab — Authentic Street Food, Zero Commission via HYST">
  <meta property="og:description"
    content="Skip UberEats, Deliveroo & Just Eat markups! Order Sindhi Chicken Biryani, Chole Bhature & Halwa Puri directly on HYST at authentic menu prices.">
  <meta property="og:url" content="https://www.lajawaab.co.uk/">
  <meta property="og:image"
    content="https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=1200&q=80">

  <!-- ============================= JSON-LD ============================= -->
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Restaurant",
      "@id": "https://www.lajawaab.co.uk/#restaurant",
      "name": "La Jawaab",
      "description": "Authentic street food kitchen famous for Sindhi Chicken Biryani, Chole Bhature, Aloo Kulcha, and Halwa Puri Channa. Powered by HYST zero-commission delivery.",
      "servesCuisine": ["Pakistani", "Indian", "Street Food"],
      "priceRange": "£",
      "url": "https://www.lajawaab.co.uk/",
      "menu": "https://www.hyst.uk/restaurant/la-jawaab-currys",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "5.0",
        "reviewCount": "240",
        "bestRating": "5"
      },
      "potentialAction": {
        "@type": "OrderAction",
        "target": "https://www.hyst.uk/restaurant/la-jawaab-currys",
        "deliveryMethod": "http://purl.org/goodrelations/v1#DeliveryModeOwnFleet"
      }
    },
    {
      "@type": "FAQPage",
      "@id": "https://www.lajawaab.co.uk/#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Why is ordering La Jawaab via HYST cheaper than other platforms?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Traditional delivery platforms charge up to 30%+ in middleman commissions and extra service fees. HYST is a zero-commission direct delivery platform, meaning you pay real kitchen menu prices with zero hidden markups."
          }
        },
        {
          "@type": "Question",
          "name": "What are the advantages of using HYST for food delivery?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "HYST offers zero app price-hikes, faster direct restaurant dispatch, exclusive Gen-Z squad discounts, and guarantees 100% of your payment directly supports local kitchens instead of big tech middlemen."
          }
        },
        {
          "@type": "Question",
          "name": "What is La Jawaab's signature flagship dish?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "La Jawaab is world-famous for its iconic Sindhi Chicken Biryani — fragrant, layered basmati rice with tender slow-spiced chicken. Other popular favorites include Chole Bhature, Aloo Kulcha, and Halwa Puri Channa."
          }
        },
        {
          "@type": "Question",
          "name": "Does La Jawaab offer student discounts or group munch deals?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes! Through HYST, La Jawaab offers exclusive Squad Bundles, flatmate dinner packages, and late-night munchie packs crafted specifically for youth foodies and Gen-Z groups."
          }
        },
        {
          "@type": "Question",
          "name": "How do I order La Jawaab street food online?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "You can order directly online by visiting the HYST official restaurant link: https://www.hyst.uk/restaurant/la-jawaab-currys for instant direct delivery or quick pickup."
          }
        }
      ]
    }
  ]
}
 
// Menu toggle
const t=document.getElementById('menuToggle');
const m=document.getElementById('navMenu');
t.onclick=()=>{m.classList.toggle('active');t.textContent=m.classList.contains('active')?'✕':'☰';};
document.querySelectorAll('#navMenu a').forEach(a=>a.onclick=()=>{m.classList.remove('active');t.textContent='☰';});
 
// Scroll reveal animations
document.addEventListener('DOMContentLoaded', () => {
  const reveals = document.querySelectorAll('.reveal');
  
  const reveal = () => {
    reveals.forEach(element => {
      const windowHeight = window.innerHeight;
      const elementTop = element.getBoundingClientRect().top;
      const elementVisible = 150;
 
      if (elementTop < windowHeight - elementVisible) {
        element.classList.add('active');
      } else {
        element.classList.remove('active');
      }
    });
  };
 
  // Add reveal class to all sections and cards
  document.querySelectorAll('section, .card, .feature-card, .menu-card, .faq-item').forEach(el => {
    if (!el.classList.contains('hero')) {
      el.classList.add('reveal');
    }
  });
 
  window.addEventListener('scroll', reveal);
  reveal();
});
 
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
 
// Add interactive glow effect on mouse move
const interactiveElements = document.querySelectorAll('.btn, .card, .hero-card, .feature-card');
document.addEventListener('mousemove', (e) => {
  interactiveElements.forEach(el => {
    const rect = el.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    if (x > 0 && x < rect.width && y > 0 && y < rect.height) {
      el.style.setProperty('--mouse-x', x + 'px');
      el.style.setProperty('--mouse-y', y + 'px');
    }
  });
});
 
// Page load animation
window.addEventListener('load', () => {
  document.body.style.opacity = '1';
  document.body.style.animation = 'fadeInUp 0.8s ease-out';
});
 
</script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --hyst-orange: #C25A2A;
      --hyst-orange-dark: #973F19;
      --hyst-dark: #1A0F09;
      --hyst-dark-deep: #1A0F09;
      --hyst-bg-light: #FBF6EF;
      --hyst-surface: #FFFFFF;
      --text-main: #1A0F09;
      --text-muted: #6B5F57;
      --border-color: rgba(26, 15, 9, 0.10);
      --badge-bg: #F5DDC9;

      --font-heading: 'Space Grotesk', sans-serif;
      --font-body: 'Poppins', sans-serif;
      --radius-lg: 16px;
      --radius-md: 12px;
      --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.05);
      --shadow-card: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      background: var(--hyst-bg-light);
      color: var(--text-main);
      font-family: var(--font-body);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    h1,
    h2,
    h3,
    h4 {
      font-family: var(--font-heading);
      line-height: 1.2;
    }

    .wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }

    section {
      padding: 35px 0;
      position: relative;
    }

    section:not(.hero) {
      animation: fadeInUp 0.8s ease-out;
    }

    h2 {
      animation: slideInUp 0.6s ease-out;
      transition: all 0.3s ease;
    }

    h2:hover {
      color: var(--hyst-orange);
    }

    @media (max-width: 768px) {
      section {
        padding: 25px 0;
      }
    }

    /* Parallax effect */
    .parallax {
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    @media (max-width: 768px) {
      .parallax {
        background-attachment: scroll;
      }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes scaleIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-15px);
      }
    }

    @keyframes glow {
      0% {
        box-shadow: 0 0 10px rgba(194, 90, 42, 0.3);
      }

      50% {
        box-shadow: 0 0 30px rgba(194, 90, 42, 0.6), 0 4px 14px rgba(194, 90, 42, 0.3);
      }

      100% {
        box-shadow: 0 0 10px rgba(194, 90, 42, 0.3);
      }
    }

    @keyframes pulse {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0.7;
      }

      100% {
        opacity: 1;
      }
    }

    /* Scroll reveal effect */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }

    .reveal-delay-1 {
      transition-delay: 0.1s;
    }

    .reveal-delay-2 {
      transition-delay: 0.2s;
    }

    .reveal-delay-3 {
      transition-delay: 0.3s;
    }

    .reveal-delay-4 {
      transition-delay: 0.4s;
    }

    .reveal-delay-5 {
      transition-delay: 0.5s;
    }

    .badge-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--badge-bg);
      border: 1px solid var(--hyst-orange);
      color: var(--hyst-orange);
      padding: 6px 18px;
      border-radius: 100px;
      font-weight: 700;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      animation: slideInLeft 0.8s ease-out 0.2s both;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .badge-pill:hover {
      transform: translateX(8px);
      background: var(--hyst-orange);
      color: #fff;
      box-shadow: 0 6px 20px rgba(194, 90, 42, 0.25);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 14px 30px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 1rem;
      cursor: pointer;
      border: none;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 0.7s ease-out 0.4s both;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    .btn:active::before {
      width: 300px;
      height: 300px;
    }

    .btn-hyst {
      background-color: var(--hyst-orange);
      color: var(--text-main);
      box-shadow: 0 4px 14px rgba(194, 90, 42, .30);
    }

    .btn-hyst:hover {
      background-color: var(--hyst-orange-dark);
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(194, 90, 42, .45);
    }

    .btn-hyst:active {
      transform: translateY(-2px);
    }

    .btn-outline-dark {
      border: 2px solid var(--hyst-dark);
      color: var(--hyst-dark);
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .btn-outline-dark:hover {
      border-color: var(--hyst-orange);
      color: #fff;
      background: var(--hyst-orange);
      transform: translateY(-4px);
      box-shadow: 0 12px 28px rgba(194, 90, 42, 0.25);
    }

    .btn-outline-dark:active {
      transform: translateY(-1px);
    }

    /* Top Alert Strip */
    .top-strip {
      background: var(--hyst-orange);
      color: #fff;
      text-align: center;
      padding: 10px 24px;
      font-weight: 700;
      font-size: 0.88rem;
      letter-spacing: 0.02em;
    }

    /* Header */
    header.site-header {
      position: sticky;
      top: 0;
      z-index: 1000;
      background: rgba(255, 245, 250, 0.78);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(194, 90, 42, .12);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      animation: slideInDown 0.6s ease-out;
    }

    nav.nav-wrap {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 24px;
    }

    .brand-logo {
      display: flex;
      align-items: center;
      gap: 8px;
      font-family: var(--font-heading);
      font-size: 1.7rem;
      font-weight: 800;
      color: #fff;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .brand-logo:hover {
      transform: scale(1.05);
    }

    .brand-logo span.highlight {
      color: var(--hyst-orange);
      animation: glow 2s ease-in-out infinite;
    }

    .nav-links {
      display: flex;
      gap: 24px;
      list-style: none;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .nav-links a {
      color: var(--text-main);
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      padding-bottom: 4px;
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--hyst-orange);
      transition: width 0.3s ease;
    }

    .nav-links a:hover {
      color: var(--hyst-orange);
      transform: translateY(-2px);
    }

    .nav-links a:hover::after {
      width: 100%;
    }

    @media(max-width: 860px) {
      .nav-links {
        display: none;
      }
    }

    /* Hero Section */
    .hero {
      position: relative;
      padding: 40px 0 45px;
      overflow: hidden;
      background: #faf2e9;
      color: var(--text-main);
      border-bottom: 1px solid var(--border-color);
    }

    .hero::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 800px;
      height: 800px;
      background: radial-gradient(circle, rgba(194, 90, 42, 0.08) 0%, transparent 70%);
      border-radius: 50%;
      animation: float 6s ease-in-out infinite;
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 50px;
      align-items: center;
      position: relative;
      z-index: 2;
    }

    @media (max-width: 900px) {
      .hero-grid {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .hero-ctas {
        justify-content: center;
      }
    }

    .hero h1 {
      font-size: clamp(2.5rem, 5vw, 4.2rem);
      font-weight: 800;
      margin: 20px 0;
      color: var(--text-main);
      animation: slideInLeft 0.8s ease-out;
    }

    .hero h1 span.glow {
      color: var(--hyst-orange);
      animation: glow 2.5s ease-in-out infinite;
    }

    .hero p.lead {
      font-size: 1.1rem;
      color: var(--text-muted);
      margin-bottom: 32px;
      max-width: 580px;
      animation: slideInLeft 0.8s ease-out 0.2s both;
      line-height: 1.8;
    }

    .hero-ctas {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    .hero-card {
      background: var(--hyst-bg-light);
      border-radius: var(--radius-lg);
      padding: 32px;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-soft);
      color: var(--text-main);
      animation: slideInRight 0.8s ease-out 0.2s both;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .hero-card:hover {
      transform: translateY(-8px);
      border-color: var(--hyst-orange);
      box-shadow: 0 20px 40px rgba(194, 90, 42, 0.15);
    }

    .badge-no-commission {
      background: #F5DDC9;
      border: 1px dashed var(--hyst-orange);
      color: var(--hyst-orange);
      padding: 12px 18px;
      border-radius: var(--radius-md);
      text-align: center;
      font-weight: 800;
      margin-bottom: 24px;
      font-size: 0.9rem;
      text-transform: uppercase;
      animation: slideInLeft 0.8s ease-out;
      transition: all 0.3s ease;
    }

    .badge-no-commission:hover {
      border-style: solid;
      box-shadow: 0 4px 12px rgba(194, 90, 42, 0.2);
      transform: translateX(4px);
    }

    /* Card Animations */
    .card,
    .feature-card,
    .menu-card {
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      animation: fadeInUp 0.6s ease-out both;
    }

    .card:hover,
    .feature-card:hover,
    .menu-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 20px 50px rgba(194, 90, 42, 0.15) !important;
      border-color: var(--hyst-orange);
    }

    .menu-card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .menu-card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .menu-card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .menu-card:nth-child(4) {
      animation-delay: 0.4s;
    }

    .feature-card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .feature-card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .feature-card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .feature-card:nth-child(4) {
      animation-delay: 0.4s;
    }

    /* FAQ Animations */
    .faq-item {
      animation: fadeInUp 0.6s ease-out both;
      transition: all 0.3s ease;
    }

    .faq-item:nth-child(1) {
      animation-delay: 0.1s;
    }

    .faq-item:nth-child(2) {
      animation-delay: 0.2s;
    }

    .faq-item:nth-child(3) {
      animation-delay: 0.3s;
    }

    .faq-item:nth-child(4) {
      animation-delay: 0.4s;
    }

    .faq-item:nth-child(5) {
      animation-delay: 0.5s;
    }

    .faq-item:hover {
      transform: translateX(4px);
    }

    details {
      transition: all 0.3s ease;
    }

    details[open] {
      box-shadow: 0 8px 24px rgba(194, 90, 42, 0.12);
    }

    summary {
      transition: color 0.2s ease;
      cursor: pointer;
    }

    summary:hover {
      color: var(--hyst-orange);
    }

    /* Interactive Calculator Section */
    .calc-section {
      background: #faf2e9;
      border-bottom: 1px solid var(--border-color);
    }

    .calc-box {
      background: var(--hyst-bg-light);
      border: 2px solid var(--hyst-orange);
      border-radius: var(--radius-lg);
      padding: 36px;
      max-width: 750px;
      margin: 20px auto 0;
      box-shadow: var(--shadow-soft);
      text-align: center;
    }

    /* Input animations */
    input,
    textarea,
    select {
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    input:focus,
    textarea:focus,
    select:focus {
      outline: none;
      border-color: var(--hyst-orange) !important;
      box-shadow: 0 0 0 4px rgba(194, 90, 42, 0.1) !important;
      transform: translateY(-2px);
    }

    .calc-slider {
      width: 100%;
      margin: 20px 0;
      accent-color: var(--hyst-orange);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .calc-slider:hover {
      filter: brightness(1.1);
    }

    .calc-results {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 24px;
    }

    .calc-res-card {
      padding: 18px;
      border-radius: var(--radius-md);
      font-weight: 700;
    }

    .calc-res-card.bad {
      background: #FEF2F2;
      color: #DC2626;
      border: 1px solid #FCA5A5;
    }

    .calc-res-card.good {
      background: #ECFDF5;
      color: #059669;
      border: 1px solid #6EE7B7;
    }

    /* Anti App Fee Section */
    .vs-section {
      background: var(--hyst-bg-light);
      border-bottom: 1px solid var(--border-color);
    }

    .vs-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      margin-top: 20px;
    }

    @media(max-width: 768px) {
      .vs-grid {
        grid-template-columns: 1fr;
      }
    }

    .card-app {
      background: var(--hyst-surface);
      border-radius: var(--radius-md);
      padding: 32px;
      border: 1px solid var(--border-color);
    }

    .card-app.bad {
      border-color: #EF4444;
      background: #FEF2F2;
    }

    .card-app.good {
      border-color: var(--hyst-orange);
      background: #F5DDC9;
      box-shadow: var(--shadow-card);
    }

    .app-list {
      list-style: none;
      margin: 20px 0 0;
    }

    .app-list li {
      padding: 12px 0;
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 0.95rem;
      color: var(--text-main);
    }

    /* About Us Section */
    .about-section {
      background: #faf2e9;
      border-bottom: 1px solid var(--border-color);
    }

    .about-grid {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 50px;
      align-items: center;
    }

    @media(max-width: 850px) {
      .about-grid {
        grid-template-columns: 1fr;
        text-align: center;
      }
    }

    .stat-box {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 20px;
    }

    .stat-card {
      background: var(--hyst-bg-light);
      padding: 20px;
      border-radius: var(--radius-md);
      border: 1px solid var(--border-color);
      text-align: center;
      box-shadow: var(--shadow-card);
    }

    .stat-card .num {
      font-family: var(--font-heading);
      font-size: 2.2rem;
      font-weight: 800;
      color: var(--hyst-orange);
    }

    .stat-card .lbl {
      color: var(--text-muted);
      font-size: 0.85rem;
      font-weight: 600;
      margin-top: 4px;
    }

    /* Gen-Z & Social Proof Reel Grid */
    .social-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-top: 20px;
    }

    @media(max-width: 850px) {
      .social-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    .social-card {
      position: relative;
      border-radius: var(--radius-md);
      overflow: hidden;
      height: 260px;
    }

    .social-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .social-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
      color: #fff;
      padding: 12px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    /* Live Popup Notification */
    .live-toast {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 9999;
      background: #FFFFFF;
      border: 2px solid var(--hyst-orange);
      border-radius: var(--radius-md);
      padding: 12px 18px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 12px;
      animation: slideUp 0.5s ease-out;
      max-width: 320px;
      font-size: 0.85rem;
    }

    @keyframes slideUp {
      from {
        transform: translateY(100px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    /* Menu Section */
    .menu-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
      margin-top: 20px;
    }

    @media(max-width: 768px) {
      .menu-grid {
        grid-template-columns: 1fr;
      }
    }

    .menu-card {
      background: var(--hyst-surface);
      border-radius: var(--radius-md);
      padding: 28px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-card);
      transition: border-color 0.2s ease;
    }

    .menu-card:hover {
      border-color: var(--hyst-orange);
    }

    .menu-card h3 {
      font-size: 1.25rem;
      color: var(--text-main);
      margin-bottom: 6px;
    }

    .menu-card p {
      color: var(--text-muted);
      font-size: 0.9rem;
      margin: 0;
    }

    .tag-badge {
      background: #F5DDC9;
      color: var(--hyst-orange);
      border: 1px solid var(--hyst-orange);
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 0.8rem;
      white-space: nowrap;
    }

    /* FAQs Section */
    .faq-section {
      background: #faf2e9;
      border-top: 1px solid var(--border-color);
    }

    .faq-container {
      max-width: 860px;
      margin: 20px auto 0;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    details {
      background: var(--hyst-bg-light);
      border-radius: var(--radius-md);
      padding: 20px 24px;
      border: 1px solid var(--border-color);
    }

    summary {
      font-family: var(--font-heading);
      font-weight: 700;
      font-size: 1.05rem;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      list-style: none;
      color: var(--text-main);
    }

    summary::-webkit-details-marker {
      display: none;
    }

    summary::after {
      content: "+";
      font-size: 1.5rem;
      color: var(--hyst-orange);
      font-weight: 600;
    }

    details[open] summary::after {
      content: "−";
    }

    details p {
      margin: 14px 0 0;
      color: var(--text-muted);
      font-size: 0.95rem;
      line-height: 1.7;
    }

    /* B2B Partner Section for HYST Growth */
    .b2b-banner {
      background: var(--hyst-dark-deep);
      color: #fff;
      padding: 40px;
      border-radius: var(--radius-lg);
      margin-top: 20px;
      text-align: center;
    }

    /* Footer Section */
    footer {
      background: var(--hyst-dark);
      padding: 35px 0 20px;
      color: #94A3B8;
      font-size: 0.92rem;
    }

    .foot-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 40px;
      margin-bottom: 20px;
    }

    @media(max-width: 850px) {
      .foot-grid {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media(max-width: 500px) {
      .foot-grid {
        grid-template-columns: 1fr;
      }
    }

    .foot-col h4 {
      color: #FFFFFF;
      font-size: 1.05rem;
      margin-bottom: 18px;
    }

    .foot-col ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .foot-col ul a {
      color: #94A3B8;
      transition: color 0.2s;
    }

    .foot-col ul a:hover {
      color: var(--hyst-orange);
    }

    /* Customer Reviews */
    .review-section {
      background: #faf2e9;
      border-top: 1px solid var(--border-color)
    }

    .review-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 20px
    }

    .review-card {
      background: #fff;
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px;
      box-shadow: var(--shadow-card)
    }

    .review-card:hover {
      transform: translateY(-4px)
    }

    .stars {
      color: #f59e0b;
      font-size: 18px;
      margin-bottom: 10px
    }

    .review-user {
      margin-top: 16px;
      font-weight: 700;
      color: var(--hyst-orange)
    }

    .review-user small {
      display: block;
      color: var(--text-muted);
      font-weight: 500
    }

    @media(max-width:900px) {
      .review-grid {
        grid-template-columns: 1fr
      }
    }


    /* Extra Responsive Improvements */
    img {
      max-width: 100%;
      height: auto
    }

    .hero-grid,
    .about-grid,
    .vs-grid,
    .menu-grid,
    .review-grid,
    .foot-grid,
    .calc-results,
    .stat-box {
      align-items: stretch
    }

    @media(max-width:1024px) {

      .hero-grid,
      .about-grid {
        grid-template-columns: 1fr !important;
        gap: 32px
      }

      .hero {
        text-align: center
      }

      .hero-ctas {
        justify-content: center
      }
    }

    @media(max-width:768px) {
      .wrap {
        padding: 0 18px
      }

      .review-stats,
      .stat-box,
      .calc-results {
        grid-template-columns: 1fr !important
      }

      .menu-card {
        flex-direction: column;
        align-items: flex-start
      }

      nav.nav-wrap {
        padding: 14px 18px
      }

      .brand-logo {
        font-size: 1.4rem
      }

      .hero h1 {
        font-size: 2.3rem
      }

      .hero p.lead {
        margin-left: auto;
        margin-right: auto
      }
    }



    /* ===== Responsive Navbar Upgrade ===== */
    /* 🔲 HEADER LOGO - BLACK */
    header.site-header .brand-logo {
      color: #1A0F09 !important;
    }

    /* ⚪ FOOTER LOGO - WHITE */
    footer .brand-logo {
      color: #fff !important;
    }

    .menu-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 30px;
      color: #111;
      cursor: pointer
    }

    .mobile-btn {
      display: none
    }

    .btn-hyst {
      background: #c75926 !important;
      color: #fff !important;
      transition: .3s
    }

    .btn-hyst:hover {
      background: #ce330c !important;
      color: #fff !important;
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(151, 63, 25, .35)
    }

    @media(max-width:992px) {
      .menu-toggle {
        display: block
      }

      .desktop-btn {
        display: none !important
      }

      .nav-links {
        position: fixed;
        top: 72px;
        right: -100%;
        width: 290px;
        height: calc(100vh - 72px);
        background: #FBF6EF;
        flex-direction: column;
        padding: 30px 20px;
        transition: .35s;
        box-shadow: -8px 0 25px rgba(0, 0, 0, .1);
        display: flex !important;
      }

      .nav-links.active {
        right: 0
      }

      .mobile-btn {
        display: block;
        width: 100%
      }

      .mobile-btn .btn {
        width: 100%
      }
    }
  </style>
</head>

<body>

  <!-- Live Floating Social Proof Toast -->
  <div class="live-toast">
    <span style="font-size: 1.5rem;">🔥</span>
    <div>
      <strong>Ayesha from London</strong> saved <strong>£7.20</strong> ordering via HYST 5 mins ago!
    </div>
  </div>

  <!-- <div class="top-strip">
    🚀 USE CODE <span
      style="background: #fff; color: var(--hyst-orange); padding: 2px 8px; border-radius: 4px;">HYSTFIRST</span> FOR
    ZERO FEES & FREE CHUTNEY BOX
  </div> -->

  <header class="site-header">
    <nav class="wrap nav-wrap">
      <a href="#top" class="brand-logo">🌶️ <span>La Jawaab</span> <span class="highlight">x HYST</span></a>
      <button class="menu-toggle" id="menuToggle">☰</button>
      <ul class="nav-links" id="navMenu">
        <li><a href="#calc">Savings Calculator</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#genz">Gen-Z</a></li>
        <li><a href="#menu">Menu</a></li>
        <li><a href="#reviews">Reviews</a></li>
        <li><a href="#faq">FAQs</a></li>
        <li class="mobile-btn"><a href="https://www.hyst.uk/restaurant/la-jawaab-currys" class="btn btn-hyst">Order
            Direct From HYST</a></li>
      </ul>
      <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" class="btn btn-hyst desktop-btn">Order Direct From
        HYST</a>
    </nav>
  </header>

  <main id="top">

    <!-- HERO SECTION -->
    <section class="hero">
      <div class="wrap hero-grid">
        <div>
          <span class="badge-pill">🔥 Direct Delivery Revolution</span>
          <h1>No Cap. Just Legendary <span class="glow">Street Food</span> at Real Prices.</h1>
          <p class="lead">Stop paying insane 30%+ delivery app commissions! Craving flagship Sindhi Chicken Biryani or
            hot Chole Bhature? Order direct via <strong>HYST</strong> with zero markups.</p>
          <div class="hero-ctas">
            <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener"
              class="btn btn-hyst">Order Direct on HYST 🚀</a>
            <a href="#calc" class="btn btn-outline-dark">Calculate Savings 🧮</a>
          </div>
        </div>

        <div class="hero-card">

          <div class="badge-no-commission">
            💡 Say NO to 30%+ Middleman App Markups!
          </div>

          <h3 style="margin-bottom:12px;text-align:center;font-size:1.5rem;color:var(--text-main);">
            ⭐ 5.0 ★ Rated Street Food
          </h3>

          <p style="text-align:center;color:var(--text-muted);font-size:0.95rem;">
            "The Sindhi Chicken Biryani is an absolute vibe! Authentic spices,
            huge portions, and ordering direct on HYST saved our squad £14 on dinner!"
          </p>

          <!-- High Quality Biryani Image -->
          <div style="margin:25px 0;">
            <img src="https://images.unsplash.com/photo-1633945274405-b6c8069047b0?auto=format&fit=crop&w=1200&q=80"
              alt="Chicken Biryani" style="
            width:100%;
            height:280px;
            object-fit:cover;
            border-radius:18px;
            box-shadow:0 18px 40px rgba(0,0,0,.18);
        ">
          </div>

          <div style="text-align:center;margin-bottom:15px;">
            <span style="
            display:inline-block;
            background:#F5DDC9;
            color:#C25A2A;
            padding:8px 20px;
            border-radius:40px;
            font-weight:700;
            font-size:15px;
        ">
              🍛 Signature Sindhi Chicken Biryani
            </span>
          </div>

          <div style="
        margin-top:20px;
        padding-top:18px;
        border-top:1px solid var(--border-color);
        text-align:center;
        font-weight:700;
        color:var(--hyst-orange);
    ">
            ⚡ Powered by HYST Zero-Commission Tech
          </div>

        </div>
      </div>
    </section>

    <!-- INTERACTIVE SAVINGS CALCULATOR -->
    <section class="calc-section" id="calc">
      <div class="wrap">
        <div style="text-align: center; max-width: 700px; margin: 0 auto;">
          <span class="badge-pill">HYST Smart Savings</span>
          <h2 style="font-size: 2.3rem; margin-top: 12px; color: var(--text-main);">See How Much You Save on HYST</h2>
          <p style="color: var(--text-muted);">Move the slider to calculate your food bill vs middleman delivery apps!
          </p>
        </div>

        <div class="calc-box">
          <label style="font-weight: 700; font-size: 1.1rem;">Your Estimated Food Amount: <span id="spend-val"
              style="color: var(--hyst-orange); font-size: 1.4rem;">£30</span></label>
          <input type="range" min="10" max="100" value="30" class="calc-slider" id="calc-range"
            oninput="updateSavings(this.value)">

          <div class="calc-results">
            <div class="calc-res-card bad">
              <div style="font-size: 0.85rem; text-transform: uppercase;">Other Platforms</div>
              <div id="other-price" style="font-size: 1.8rem; margin-top: 6px;">£38.50</div>
              <div style="font-size: 0.75rem; font-weight: 400; margin-top: 4px;">Includes 25% Markup + £2.50 Service
                Fee</div>
            </div>
            <div class="calc-res-card good">
              <div style="font-size: 0.85rem; text-transform: uppercase;">HYST Direct Order</div>
              <div id="hyst-price" style="font-size: 1.8rem; margin-top: 6px;">£30.00</div>
              <div style="font-size: 0.75rem; font-weight: 400; margin-top: 4px;">0% Markup + Pure Kitchen Price</div>
            </div>
          </div>

          <div style="margin-top: 20px; font-weight: 800; color: var(--hyst-orange); font-size: 1.2rem;">
            🎉 You Save <span id="saved-val">£8.50</span> with HYST!
          </div>
        </div>
        <div style="text-align: center; margin-top: 25px;">
          <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst">Order on HYST 🚀</a>
        </div>
      </div>
    </section>

    <!-- VERSUS BIG APPS SECTION -->
    <section class="vs-section">
      <div class="wrap">
        <div style="text-align: center; max-width: 720px; margin: 0 auto;">
          <span class="badge-pill">Commission Breakdown</span>
          <h2 style="font-size: 2.3rem; margin-top: 12px; color: var(--text-main);">Why Foodies & Youth Are Switching to
            HYST</h2>
        </div>

        <div class="vs-grid">
          <div class="card-app bad">
            <h3 style="color: #DC2626; font-size: 1.35rem;"><i class="fa-solid fa-xmark"></i> Other Platforms</h3>
            <ul class="app-list">
              <li>⛔ Up to 30%+ higher food prices per menu item</li>
              <li>⛔ Extra "Service Fees" & inflated delivery charges</li>
              <li>⛔ Money goes to corporate tech platforms</li>
              <li>⛔ Lukewarm food due to driver multi-restaurant batching</li>
            </ul>
          </div>

          <div class="card-app good">
            <h3 style="color: var(--hyst-orange); font-size: 1.35rem;"><i class="fa-solid fa-check"></i> HYST Direct
              Ordering Platform</h3>
            <ul class="app-list">
              <li>⚡ <strong>Zero Commission:</strong> Genuine, original kitchen prices</li>
              <li>⚡ <strong>Express Dispatch:</strong> Hotter, fresh street food delivered faster</li>
              <li>⚡ <strong>100% Support:</strong> Every penny goes straight to the kitchen</li>
              <li>⚡ <strong>Gen-Z Perks:</strong> Exclusive squad munch bundles & reward deals</li>
            </ul>
          </div>
        </div>
        <div style="text-align: center; margin-top: 25px;">
          <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst">Order on HYST 🚀</a>
        </div>
      </div>
    </section>

    <!-- ABOUT US SECTION (WITH UPDATED HIGH-RES BIRYANI IMAGE) -->
    <section class="about-section" id="about">
      <div class="wrap about-grid">
        <div>
          <span class="badge-pill">Our Heritage & Mission</span>
          <h2 style="font-size: 2.3rem; margin-top: 12px; color: var(--text-main);">Authentic Recipes. Direct Fair
            Pricing.</h2>
          <p style="color: var(--text-muted); margin-top: 16px;">La Jawaab was born out of a passion for real,
            uncompromised street food—from rich, slow-marinated Sindhi Chicken Biryani to fluffy Chole Bhature and sweet
            Halwa Puri. We believe legendary food shouldn't come with inflated third-party app markup fees.</p>
          <p style="color: var(--text-muted); margin-top: 12px;">By partnering directly with <strong>HYST</strong>, we
            cut out corporate middlemen. This allows us to deliver piping hot street food straight from our kitchen to
            your table at exact menu prices.</p>

          <div class="stat-box">
            <div class="stat-card">
              <div class="num">£25K+</div>
              <div class="lbl">Customer Savings via HYST</div>
            </div>
            <div class="stat-card">
              <div class="num">100%</div>
              <div class="lbl">Authentic Spices & Recipes</div>
            </div>
          </div>
        </div>
        <div>
          <img src="https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=800&q=80"
            alt="Authentic Sindhi Chicken Biryani - La Jawaab"
            style="width:100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft);">
        </div>
      </div>
      <div style="text-align: center; margin-top: 25px;">
        <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst">Order on HYST 🚀</a>
      </div>
    </section>

    <!-- INSTAGRAM / UGC SOCIAL PROOF GRID -->
    <section id="genz" style="background: var(--hyst-bg-light); border-bottom: 1px solid var(--border-color);">
      <div class="wrap">
        <div style="text-align: center; max-width: 750px; margin: 0 auto;">
          <span class="badge-pill">Social Vibes</span>
          <h2 style="font-size: 2.4rem; margin-top: 12px; color: var(--text-main);">Tagged on Social #LaJawaabXHYST 📸
          </h2>
          <p style="color: var(--text-muted);">See how our squad is enjoying direct delivery authentic food!</p>
        </div>

        <div class="social-grid">
          <div class="social-card">
            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=600&q=80"
              alt="Foodie selfie">
            <div class="social-overlay">@sam_foodie: Saved £9 on biryani night! 🍗</div>
          </div>
          <div class="social-card">
            <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80"
              alt="Squad eating">
            <div class="social-overlay">@pree_z: Chole Bhature directly from HYST! 🔥</div>
          </div>
          <div class="social-card">
            <img src="https://images.unsplash.com/photo-1543007630-9710e4a00a20?auto=format&fit=crop&w=600&q=80"
              alt="Biryani box">
            <div class="social-overlay">@uk_munchies: Real menu prices only on HYST 💯</div>
          </div>
          <div class="social-card">
            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=600&q=80"
              alt="Halwa Puri">
            <div class="social-overlay">@ali_khan: Fast direct dispatch is real ⚡</div>
          </div>
        </div>
        <div style="text-align: center; margin-top: 25px;">
          <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst">Order on HYST 🚀</a>
        </div>
      </div>
    </section>

    <!-- MENU SECTION -->
    <section id="menu" style="background:#faf2e9;">
      <div class="wrap">
        <div style="text-align: center; max-width: 700px; margin: 0 auto;">
          <span class="badge-pill">On The Board</span>
          <h2 style="font-size: 2.3rem; margin-top: 12px; color: var(--text-main);">Street Food Classics Done Properly
          </h2>
        </div>

        <div class="menu-grid">
          <div class="menu-card">
            <div>
              <h3>Sindhi Chicken Biryani 🔥</h3>
              <p>Our flagship dish — layered basmati rice, slow-marinated chicken, and authentic Sindhi spices.</p>
            </div>
            <span class="tag-badge">Flagship Item</span>
          </div>

          <div class="menu-card">
            <div>
              <h3>Chole Bhature 🫓</h3>
              <p>Pillowy fried bhature served with rich, tangy spiced chickpea masala.</p>
            </div>
            <span class="tag-badge">Squad Fav</span>
          </div>

          <div class="menu-card">
            <div>
              <h3>Aloo Kulcha + Chana Masala 🥔</h3>
              <p>Stuffed potato kulcha cooked to crisp perfection, paired with savory chana masala.</p>
            </div>
            <span class="tag-badge">Popular</span>
          </div>

          <div class="menu-card">
            <div>
              <h3>Halwa Puri Channa 🍯</h3>
              <p>Melt-in-the-mouth sweet halwa, golden crisp puri, and spiced channa plate.</p>
            </div>
            <span class="tag-badge">Classic</span>
          </div>
        </div>

        <div style="text-align: center; margin-top: 25px;">
          <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener"
            class="btn btn-hyst">Order on HYST 🚀</a>
        </div>
      </div>
    </section>


    <section class="review-section" id="reviews">
      <div class="wrap">
        <div style="text-align:center;max-width:720px;margin:0 auto;">
          <span class="badge-pill">Customer Reviews</span>
          <h2 style="font-size:2.3rem;margin-top:12px;">Loved by Food Lovers ❤️</h2>
          <p style="color:var(--text-muted)">Real experiences from customers who ordered La Jawaab through HYST.</p>
        </div>
        <div class="review-grid">
          <div class="review-card">
            <div class="stars">★★★★★</div>
            <p>The Sindhi Chicken Biryani was absolutely delicious. Fresh, authentic and delivered hot.</p>
            <div class="review-user">Sarah M.<small>Verified Customer • Hounslow</small></div>
          </div>
          <div class="review-card">
            <div class="stars">★★★★★</div>
            <p>Ordering through HYST was simple and cheaper than other delivery apps. Highly recommended.</p>
            <div class="review-user">James R.<small>Verified Customer</small></div>
          </div>
          <div class="review-card">
            <div class="stars">★★★★★</div>
            <p>Perfect family meal. Big portions, amazing taste and quick delivery.</p>
            <div class="review-user">Aisha K.<small>Verified Customer</small></div>
          </div>
        </div>
        <div style="text-align: center; margin-top: 25px;">
          <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst">Order on HYST 🚀</a>
        </div>
      </div>
    </section>


    <!-- HYST B2B GROWTH BANNER FOR OTHER RESTAURANTS -->
    <section class="wrap">
      <div class="b2b-banner">
        <h3 style="font-size: 1.8rem; margin-bottom: 12px; color: #fff;">Own a Restaurant or Food Business? 🏪</h3>
        <p style="color: #94A3B8; max-width: 650px; margin: 0 auto 24px;">Stop giving 30% of your hard-earned profits to
          delivery platforms. Join HYST today and own 100% of your direct customer base with zero commissions.</p>
        <a href="https://www.hyst.uk" target="_blank" rel="noopener" class="btn btn-hyst"
          style="background: #fff; color: var(--hyst-orange);">Partner with HYST Now 🤝</a>
        <!-- <div style="margin-top: 20px;">
          <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst">Order on HYST 🚀</a>
        </div> -->
      </div>
    </section>

    <!-- EXTENSIVE MULTI-FAQ SECTION -->
    <section class="faq-section" id="faq">
      <div class="wrap">
        <div style="text-align: center; max-width: 720px; margin: 0 auto;">
          <span class="badge-pill">Search Engine & Customer Guide</span>
          <h2 style="font-size: 2.3rem; margin-top: 12px; color: var(--text-main);">Frequently Asked Questions</h2>
          <p style="color: var(--text-muted);">Everything you need to know about La Jawaab, HYST zero-commission
            delivery, and direct ordering.</p>
        </div>

        <div class="faq-container">
          <details open>
            <summary>Why is ordering La Jawaab via HYST cheaper than other platforms?</summary>
            <p>Traditional food delivery platforms charge restaurants up to 30%+ in commission fees, which forces
              restaurants to increase their menu prices on those platforms. In addition, apps add high service fees.
              HYST operates on a zero-commission model, connecting you directly with La Jawaab. You pay genuine kitchen
              menu prices without third-party app inflation.</p>
          </details>

          <details>
            <summary>What is La Jawaab's signature flagship dish?</summary>
            <p>La Jawaab is renowned for its signature <strong>Sindhi Chicken Biryani</strong> — layered long-grain
              basmati rice cooked with slow-marinated chicken and authentic Sindhi spices. Other crowd favorites include
              Chole Bhature, Aloo Kulcha with Chana Masala, and Halwa Puri Channa.</p>
          </details>

          <details>
            <summary>How does HYST benefit student foodies and Gen-Z groups?</summary>
            <p>By eliminating unfair middleman app fees, HYST lets students and young foodies enjoy authentic street
              food without overpaying. Group orders, flatmate feasts, and late-night munchies become significantly more
              affordable when ordering direct on HYST.</p>
          </details>

          <details>
            <summary>Is the food delivery faster when ordering through HYST?</summary>
            <p>Yes! Because your order is sent directly to La Jawaab's kitchen without driver rerouting or
              multi-restaurant app batching, your food is prepared immediately and dispatched directly to your door
              hotter and fresher.</p>
          </details>

          <details>
            <summary>How do I place an order for delivery or collection on HYST?</summary>
            <p>Simply click any "Order on HYST" button on this landing page or visit the official link: <a
                href="https://www.hyst.uk/restaurant/la-jawaab-currys"
                style="color: var(--hyst-orange); font-weight: 600; text-decoration: underline;">https://www.hyst.uk/restaurant/la-jawaab-currys</a>
              to browse the live menu and checkout seamlessly.</p>
          </details>

          <details>
            <summary>Why should I support direct restaurant ordering over corporate delivery apps?</summary>
            <p>When you order direct via HYST, 100% of your money goes to supporting the local restaurant and culinary
              staff rather than corporate tech giants. You get better quality food, bigger portions, and genuine prices.
            </p>
          </details>

          <details>
            <summary>Are there any hidden service charges when ordering on HYST?</summary>
            <p>None at all! HYST believes in complete transparency. You pay exact kitchen menu prices with clear,
              upfront delivery terms and zero surprise markups at checkout.</p>
          </details>

          <details>
            <summary>Can I order catering or large group meals through HYST?</summary>
            <p>Yes, HYST supports large group orders and squad deals. Whether it is a flatmate party, family dinner, or
              office lunch, ordering in bulk on HYST maximizes your savings since there are no percentage-based
              middleman markups.</p>
          </details>
        </div>
        <div style="text-align: center; margin-top: 25px;">
          <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst">Order on HYST 🚀</a>
        </div>
      </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section
      style="background:#faf2e9; text-align:center; padding:40px 0; color:var(--text-main); border-top:1px solid var(--border-color);">
      <div class="wrap">
        <h2 style="font-size: clamp(2rem, 4.5vw, 3.4rem); margin-bottom: 16px; color: var(--text-main);">Ready for Real
          Street Food without App Fees?</h2>
        <p style="max-width: 620px; margin: 0 auto 32px; color: var(--text-muted); font-size: 1.1rem;">Join thousands of
          smart foodies who stopped overpaying corporate apps. Order La Jawaab direct on HYST today!</p>
        <a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener" class="btn btn-hyst"
          style="font-size: 1.1rem; padding: 16px 36px;">Order Direct on HYST Now 🚀</a>
      </div>
    </section>

  </main>

  <!-- FOOTER WITH DETAILED LINKS LIST -->
  <footer>
    <div class="wrap">
      <div class="foot-grid">
        <div class="foot-col">
          <div class="brand-logo" style="margin-bottom: 14px;">🌶️ La Jawaab <span class="highlight">x HYST</span></div>
          <p style="line-height: 1.7; max-width: 320px;">Your favorite legendary street food kitchen — powered by HYST
            zero-commission delivery technology. Enjoy direct menu prices without middleman markups.</p>
        </div>

        <div class="foot-col">
          <h4>Navigation</h4>
          <ul>
            <li><a href="#top">Home</a></li>
            <li><a href="#calc">Savings Calculator</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#genz">Gen-Z Vibes</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#faq">FAQs</a></li>
          </ul>
        </div>

        <div class="foot-col">
          <h4>Popular Menu</h4>
          <ul>
            <li><a href="#menu">Sindhi Chicken Biryani</a></li>
            <li><a href="#menu">Chole Bhature</a></li>
            <li><a href="#menu">Aloo Kulcha &amp; Chana</a></li>
            <li><a href="#menu">Halwa Puri Channa</a></li>
          </ul>
        </div>

        <div class="foot-col">
          <h4>Order &amp; Partner</h4>
          <ul>
            <li><a href="https://www.hyst.uk/restaurant/la-jawaab-currys" target="_blank" rel="noopener"
                style="color: var(--hyst-orange); font-weight: 700;">Order Direct on HYST 🚀</a></li>
            <li><a href="https://www.hyst.uk" target="_blank" rel="noopener">Partner with HYST</a></li>
            <li><a href="#faq">Zero Commission Tech</a></li>
          </ul>
        </div>
      </div>

      <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 24px; text-align: center;">
        <p>&copy; 2026 La Jawaab. Direct Delivery powered by <a href="https://www.hyst.uk" target="_blank"
            rel="noopener" style="color: var(--hyst-orange); font-weight: 600;">HYST</a>. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    function updateSavings(val) {
      document.getElementById('spend-val').innerText = '£' + val;
      let otherPrice = (parseFloat(val) * 1.25 + 2.50).toFixed(2);
      let hystPrice = parseFloat(val).toFixed(2);
      let saved = (otherPrice - hystPrice).toFixed(2);

      document.getElementById('other-price').innerText = '£' + otherPrice;
      document.getElementById('hyst-price').innerText = '£' + hystPrice;
      document.getElementById('saved-val').innerText = '£' + saved;
    }

    const t = document.getElementById('menuToggle');
    const m = document.getElementById('navMenu');
    t.onclick = () => { m.classList.toggle('active'); t.textContent = m.classList.contains('active') ? '✕' : '☰'; };
    document.querySelectorAll('#navMenu a').forEach(a => a.onclick = () => { m.classList.remove('active'); t.textContent = '☰'; });

  </script>

</body>

</html>