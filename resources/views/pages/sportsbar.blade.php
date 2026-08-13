<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>The Sports Bar | Live Matches, Gourmet Eats & Game Day Drinks | Order Direct on HYST</title>

    <!-- Meta Tags for SEO, AEO & GEO -->
    <meta name="description"
        content="Catch every Premier League game, UFC fight & Champions League clash live at The Sports Bar! Enjoy cold draught beers, cocktail pitchers, wing buckets & smash burgers. Order direct on HYST to save up to 25%!">
    <meta name="keywords"
        content="The Sports Bar UK, Sports Bar Drinks, Draught Beer Sports Bar, Cocktail Pitchers, Match Day Buckets, Gourmet Burgers, Order Direct HYST, Zero Delivery Markup">
    <meta name="robots" content="index, follow">

    <!-- Open Graph & Social Meta -->
    <meta property="og:title" content="The Sports Bar | Cold Beers, Cocktails & Sizzling Stadium Eats">
    <meta property="og:description"
        content="Experience the ultimate match day vibe with ice-cold draught beers, game day cocktail pitchers, and gourmet eats. Order directly on HYST for direct venue prices!">
    <meta property="og:type" content="restaurant">
    <meta property="og:url" content="https://hyst.uk/restaurant/sports-bar">
    <meta property="og:image"
        content="https://images.unsplash.com/photo-1511193311914-0346f16efe90?auto=format&fit=crop&w=1200&q=80">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SportsActivityLocation",
      "name": "The Sports Bar",
      "image": "https://images.unsplash.com/photo-1511193311914-0346f16efe90",
      "url": "https://hyst.uk/restaurant/sports-bar",
      "telephone": "+442081234567",
      "priceRange": "££",
      "menu": "https://hyst.uk/restaurant/sports-bar",
      "servesCuisine": ["Draft Beers", "Cocktails", "Gourmet Burgers", "Flame-Grilled Wings", "Match Day Buckets"],
      "acceptsReservations": "True"
    }
    </script>

    <style>
        /* ==========================================================================
           COLOR PALETTE & RESPONSIVE CORE VARIABLES
           ========================================================================== */
        :root {
            /* Arena Dark Base */
            --bg-main: #0c0f12;          /* Deep Pitch Dark */
            --bg-card: #141920;          /* Raised Panel Surface */
            --bg-accent-soft: #1d2430;    /* Soft Contrast Accent */
            --border-soft: #2a3445;       /* Sleek Metallic Border */

            /* Signature Vivid Sports Bar Colors */
            --brand-green: #00a859;      /* Signature Sports Bar Turf Green */
            --brand-green-hover: #008747;
            --brand-gold: #ffb703;       /* Stadium Floodlight Gold */
            --brand-gold-hover: #e0a200;
            --brand-red: #e63946;        /* Live Match Red */
            --brand-red-hover: #c92a37;
            --brand-dark: #07090c;       /* Solid Header / Footer */

            /* High Contrast Typography */
            --text-primary: #ffffff;     /* Stark White */
            --text-muted: #94a3b8;       /* Silver Slate */
            --text-gold: #ffb703;

            --font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            font-family: var(--font-family);
            line-height: 1.6;
            background-color: var(--bg-main);
            color: var(--text-primary);
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            word-wrap: break-word;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Buttons & Dynamic Controls */
        .btn-primary {
            background: linear-gradient(135deg, var(--brand-green) 0%, #008747 100%);
            color: #ffffff !important;
            font-weight: 800;
            padding: 14px 28px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 1px solid var(--brand-green);
            box-shadow: 0 10px 25px rgba(0, 168, 89, 0.3);
            transition: var(--transition);
            cursor: pointer;
            text-transform: uppercase;
            font-size: clamp(0.78rem, 2vw, 0.88rem);
            letter-spacing: 1px;
            white-space: nowrap;
            text-align: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(0, 168, 89, 0.5);
            background: linear-gradient(135deg, #008747 0%, var(--brand-green) 100%);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid var(--brand-green);
            color: var(--brand-green);
            font-weight: 800;
            padding: 13px 26px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: clamp(0.78rem, 2vw, 0.88rem);
            letter-spacing: 1px;
            white-space: nowrap;
            text-align: center;
        }

        .btn-secondary:hover {
            background: var(--brand-green);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .section-tag {
            color: var(--brand-green);
            font-weight: 800;
            text-transform: uppercase;
            font-size: clamp(0.72rem, 1.8vw, 0.82rem);
            letter-spacing: 1.5px;
            display: inline-block;
            margin-bottom: 12px;
            background: var(--bg-accent-soft);
            padding: 6px 16px;
            border-radius: 30px;
            border: 1px solid var(--border-soft);
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 3.2rem);
            line-height: 1.18;
            margin-bottom: 18px;
        }

        .section-desc {
            max-width: 850px;
            font-size: clamp(0.92rem, 2vw, 1.08rem);
            margin-bottom: 30px;
            line-height: 1.7;
            color: var(--text-muted);
        }

        .highlight-gold {
            color: var(--brand-green);
        }

        .cta-row-center {
            margin-top: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            width: 100%;
        }

        /* ==========================================================================
           HEADER / NAVIGATION
           ========================================================================== */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(7, 9, 12, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 2px solid var(--brand-green);
            padding: 12px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .logo {
            font-size: clamp(1.1rem, 2.5vw, 1.35rem);
            font-weight: 900;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .logo i {
            color: var(--brand-green);
            font-size: 1.4rem;
        }

        .nav-menu {
            display: flex;
            align-items: center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
            list-style: none;
        }

        .nav-links a {
            font-weight: 700;
            font-size: 0.88rem;
            color: #E5E5E5;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--brand-green);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--brand-green);
            font-size: 1.6rem;
            cursor: pointer;
            padding: 5px;
        }

        .mobile-hyst-btn {
            display: none;
        }

        /* Responsive Mobile Drawer */
        @media (max-width: 1024px) {
            .menu-toggle {
                display: block;
            }

            .header-actions .btn-primary {
                display: none;
            }

            .nav-menu {
                position: fixed;
                top: 60px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 60px);
                background: var(--brand-dark);
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                padding: 35px 20px;
                gap: 20px;
                transition: var(--transition);
                overflow-y: auto;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-links {
                flex-direction: column;
                gap: 20px;
                text-align: center;
                width: 100%;
            }

            .nav-links a {
                font-size: 1.1rem;
                display: block;
                padding: 8px 0;
            }

            .mobile-hyst-btn {
                display: flex !important;
                width: 100%;
                justify-content: center;
                margin-top: 15px;
            }

            .mobile-hyst-btn .btn-primary {
                width: 100%;
                max-width: 320px;
            }
        }

        /* ==========================================================================
           SECTION 1: HERO SECTION
           ========================================================================== */
        .hero {
            padding: 140px 0 70px;
            background: radial-gradient(circle at 50% 20%, rgba(0, 168, 89, 0.15) 0%, var(--bg-main) 70%);
            border-bottom: 1px solid var(--border-soft);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 40px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: clamp(2.1rem, 4.8vw, 3.8rem);
            line-height: 1.14;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: clamp(0.95rem, 2vw, 1.1rem);
            color: var(--text-muted);
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .hero-cta-group {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .hero-badges {
            display: flex;
            gap: 12px;
            margin-top: 35px;
            flex-wrap: wrap;
        }

        .badge-item {
            background: var(--bg-card);
            border: 1px solid var(--border-soft);
            padding: 10px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            flex: 1 1 auto;
        }

        .badge-item i {
            color: var(--brand-green);
            font-size: 1rem;
        }

        .badge-item span {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        .hero-img-box {
            background: var(--bg-card);
            border: 2px solid var(--border-soft);
            border-radius: 24px;
            padding: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            width: 100%;
        }

        .hero-img-box img {
            width: 100%;
            aspect-ratio: 4/3;
            max-height: 440px;
            border-radius: 16px;
            object-fit: cover;
        }

        /* Breakpoints for Hero */
        @media (max-width: 991px) {
            .hero {
                padding: 110px 0 50px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .hero-content {
                text-align: center;
            }

            .hero-cta-group {
                justify-content: center;
            }

            .hero-badges {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .hero-cta-group {
                flex-direction: column;
                width: 100%;
            }

            .hero-cta-group .btn-primary,
            .hero-cta-group .btn-secondary {
                width: 100%;
            }

            .badge-item {
                width: 100%;
                justify-content: center;
            }
        }

        /* ==========================================================================
           SECTION 2: ABOUT US / STADIUM ATMOSPHERE
           ========================================================================== */
        .about-section {
            padding: 80px 0;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-soft);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-image-wrapper {
            position: relative;
            width: 100%;
        }

        .about-image-wrapper img {
            width: 100%;
            aspect-ratio: 4/3;
            max-height: 480px;
            object-fit: cover;
            border-radius: 20px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .about-experience-badge {
            position: absolute;
            bottom: -15px;
            right: -15px;
            background: var(--brand-dark);
            color: #ffffff;
            padding: 16px 24px;
            border-radius: 18px;
            border: 2px solid var(--brand-green);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        .about-experience-badge .num {
            font-size: 2rem;
            font-weight: 900;
            line-height: 1;
            color: var(--brand-green);
        }

        .about-experience-badge .txt {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .about-feature-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 25px 0;
        }

        .about-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .about-feature-item i {
            color: var(--brand-green);
            font-size: 1.15rem;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .about-feature-item h4 {
            font-size: 0.98rem;
            margin-bottom: 2px;
        }

        .about-feature-item p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @media (max-width: 991px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .about-experience-badge {
                position: relative;
                bottom: 0;
                right: 0;
                margin-top: 15px;
                display: inline-block;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .about-feature-list {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        /* ==========================================================================
           SECTION 3: GEN Z & SQUAD VIBE
           ========================================================================== */
        .genz-section {
            padding: 80px 0;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border-soft);
        }

        .genz-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .genz-cards-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-top: 25px;
        }

        .genz-mini-card {
            background: var(--bg-card);
            border: 1px solid var(--border-soft);
            padding: 18px;
            border-radius: 16px;
            transition: var(--transition);
        }

        .genz-mini-card:hover {
            border-color: var(--brand-green);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 168, 89, 0.2);
        }

        .genz-mini-card i {
            font-size: 1.6rem;
            color: var(--brand-green);
            margin-bottom: 10px;
        }

        .genz-mini-card h4 {
            font-size: 0.98rem;
            margin-bottom: 4px;
        }

        .genz-mini-card p {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .genz-gallery-wrapper {
            position: relative;
            width: 100%;
        }

        .genz-floating-tag {
            position: absolute;
            top: -14px;
            left: 20px;
            z-index: 10;
            background: var(--brand-green);
            color: #ffffff;
            font-weight: 800;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 0.78rem;
            box-shadow: 0 8px 20px rgba(0, 168, 89, 0.4);
            text-transform: uppercase;
            border: 1px solid var(--brand-gold);
        }

        .genz-image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            background: var(--bg-card);
            padding: 14px;
            border-radius: 24px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .genz-img-card {
            position: relative;
            aspect-ratio: 4/3;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border-soft);
        }

        .genz-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .genz-img-card:hover img {
            transform: scale(1.06);
        }

        .genz-img-card .img-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 8px 10px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            color: var(--brand-green);
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        @media (max-width: 991px) {
            .genz-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }

        @media (max-width: 576px) {
            .genz-cards-container {
                grid-template-columns: 1fr;
            }

            .genz-floating-tag {
                left: 50%;
                transform: translateX(-50%);
                white-space: nowrap;
            }
        }

        /* ==========================================================================
           SECTION 4: SIGNATURE MENU & DRINKS SECTIONS
           ========================================================================== */
        .menu-section {
            padding: 80px 0;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-soft);
        }

        .menu-category-title {
            font-size: clamp(1.3rem, 3vw, 1.7rem);
            color: var(--brand-green);
            margin: 35px 0 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid var(--border-soft);
            padding-bottom: 8px;
            flex-wrap: wrap;
        }

        /* Dynamic Fluid Grid for 320px+ Screens */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(100%, 260px), 1fr));
            gap: 22px;
            margin-top: 20px;
        }

        .menu-card {
            background: var(--bg-main);
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            border-color: var(--brand-green);
            box-shadow: 0 12px 30px rgba(0, 168, 89, 0.25);
        }

        .menu-img-container {
            position: relative;
            width: 100%;
            aspect-ratio: 16/10;
            overflow: hidden;
        }

        .menu-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .menu-card:hover .menu-img-container img {
            transform: scale(1.06);
        }

        .dish-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--brand-dark);
            border: 1px solid var(--brand-green);
            color: var(--brand-green);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .menu-details {
            padding: 18px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 15px;
        }

        .menu-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 8px;
        }

        .menu-title-row h3 {
            font-size: 1.05rem;
            line-height: 1.3;
        }

        .menu-price {
            font-size: 1.15rem;
            color: var(--brand-green);
            font-weight: 900;
            white-space: nowrap;
        }

        .menu-desc {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* ==========================================================================
           SECTION 5: SAVINGS CALCULATOR
           ========================================================================== */
        .calculator-section {
            padding: 80px 0;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border-soft);
        }

        .calc-box {
            background: var(--bg-card);
            border: 2px solid var(--border-soft);
            border-radius: 20px;
            padding: clamp(20px, 4vw, 36px);
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .calc-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
            gap: 24px;
            margin-top: 25px;
        }

        .control-group label {
            display: block;
            font-weight: 800;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            color: var(--brand-green);
        }

        .calc-slider {
            width: 100%;
            accent-color: var(--brand-green);
            height: 8px;
            background: var(--border-soft);
            border-radius: 5px;
            outline: none;
            cursor: pointer;
        }

        .vibe-select {
            width: 100%;
            padding: 12px;
            background: var(--bg-main);
            border: 1px solid var(--border-soft);
            color: var(--text-primary);
            border-radius: 12px;
            font-family: var(--font-family);
            font-weight: 700;
            font-size: 0.88rem;
            outline: none;
            cursor: pointer;
        }

        .calc-comparison-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
            gap: 18px;
            margin-top: 30px;
        }

        .calc-card-other {
            background: rgba(230, 57, 70, 0.1);
            border: 1px solid rgba(230, 57, 70, 0.4);
            padding: 20px;
            border-radius: 16px;
            text-align: center;
        }

        .calc-card-hyst {
            background: rgba(0, 168, 89, 0.1);
            border: 2px solid var(--brand-green);
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            position: relative;
        }

        .calc-card-hyst .savings-badge {
            position: absolute;
            top: -12px;
            right: 15px;
            background: var(--brand-green);
            color: #ffffff;
            font-weight: 900;
            font-size: 0.72rem;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .price-label {
            font-size: 0.82rem;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .price-value-other {
            font-size: clamp(1.8rem, 4vw, 2.2rem);
            font-weight: 900;
            color: #ef4444;
            text-decoration: line-through;
        }

        .price-value-hyst {
            font-size: clamp(2rem, 4.5vw, 2.5rem);
            font-weight: 900;
            color: var(--brand-green);
        }

        /* ==========================================================================
           SECTION 6: COMPARISON TABLE
           ========================================================================== */
        .compare-section {
            padding: 80px 0;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-soft);
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 30px;
            border-radius: 16px;
            border: 1px solid var(--border-soft);
        }

        .compare-table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            text-align: left;
            background: var(--bg-main);
        }

        .compare-table th,
        .compare-table td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-soft);
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }

        .compare-table th {
            background: var(--bg-accent-soft);
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .compare-table th.brand-col {
            color: #ffffff;
            background: var(--brand-green);
        }

        .compare-table td i.fa-check-circle {
            color: var(--brand-green);
            font-size: 1.1rem;
        }

        .compare-table td i.fa-times-circle {
            color: #ef4444;
            font-size: 1.1rem;
        }

        /* ==========================================================================
           SECTION 7: FAQS ACCORDION
           ========================================================================== */
        .faq-section {
            padding: 80px 0;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border-soft);
        }

        .faq-layout {
            display: grid;
            grid-template-columns: 0.8fr 1.2fr;
            gap: 40px;
            align-items: flex-start;
            margin-top: 30px;
        }

        .faq-image-wrapper {
            position: sticky;
            top: 80px;
            background: var(--bg-card);
            padding: 10px;
            border-radius: 18px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            width: 100%;
        }

        .faq-image-container {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
        }

        .faq-image-container img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            border-radius: 14px;
        }

        .faq-image-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            right: 12px;
            background: rgba(7, 9, 12, 0.92);
            backdrop-filter: blur(8px);
            border: 1px solid var(--brand-green);
            color: #ffffff;
            padding: 12px 14px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .faq-image-badge i {
            font-size: 1.5rem;
            color: var(--brand-green);
            flex-shrink: 0;
        }

        .faq-image-badge h5 {
            font-size: 0.88rem;
            color: var(--brand-green);
        }

        .faq-image-badge p {
            font-size: 0.78rem;
            color: #D5D5D5;
        }

        .faq-grid {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .faq-item {
            background: var(--bg-card);
            border: 1px solid var(--border-soft);
            border-radius: 14px;
            overflow: hidden;
            transition: var(--transition);
        }

        .faq-question {
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 700;
            font-size: clamp(0.9rem, 2vw, 0.98rem);
            gap: 10px;
        }

        .faq-question i {
            color: var(--brand-green);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .faq-answer {
            padding: 0 20px 18px;
            color: var(--text-muted);
            font-size: 0.88rem;
            display: none;
            line-height: 1.6;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        @media (max-width: 991px) {
            .faq-layout {
                grid-template-columns: 1fr;
            }

            .faq-image-wrapper {
                position: relative;
                top: 0;
            }
        }

        /* ==========================================================================
           FOOTER
           ========================================================================== */
        footer {
            background: var(--brand-dark);
            color: #FFFBF7;
            padding: 60px 0 25px;
            border-top: 2px solid var(--brand-green);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
            gap: 35px;
            margin-bottom: 40px;
        }

        .footer-brand p {
            color: #A3A3A3;
            margin-top: 14px;
            font-size: 0.88rem;
            line-height: 1.6;
        }

        .footer-col h4 {
            font-size: 1rem;
            margin-bottom: 18px;
            color: var(--brand-green);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            color: #D5D5D5;
            font-size: 0.88rem;
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: var(--brand-green);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #1c2638;
            color: #A3A3A3;
            font-size: 0.82rem;
        }

        /* ==========================================================================
           ULTRA-SMALL MOBILE SCREENS (320px - 380px)
           ========================================================================== */
        @media (max-width: 380px) {
            .container {
                padding: 0 12px;
            }

            .btn-primary, .btn-secondary {
                padding: 12px 18px;
                font-size: 0.75rem;
                width: 100%;
            }

            .menu-title-row {
                flex-direction: column;
                gap: 4px;
            }

            .menu-price {
                font-size: 1.05rem;
            }

            .calc-box {
                padding: 16px 12px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER / NAVIGATION -->
    <header>
        <div class="container nav-container">
            <a href="https://hyst.uk/restaurant/sports-bar" class="logo">
                <i class="fa-solid fa-trophy"></i> THE SPORTS BAR
            </a>

            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="#about">Arena Experience</a></li>
                    <li><a href="#squad">Squad & Game Day</a></li>
                    <li><a href="#menu">Drinks & Menu</a></li>
                    <li><a href="#calculator">Savings Calc</a></li>
                    <li><a href="#compare">HYST vs Apps</a></li>
                    <li><a href="#faq">FAQs</a></li>
                </ul>

                <div class="mobile-hyst-btn">
                    <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-beer-mug-empty"></i> Order Direct on HYST
                    </a>
                </div>
            </div>

            <div class="header-actions">
                <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-beer-mug-empty"></i> Order Direct
                </a>
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <span class="section-tag"><i class="fa-solid fa-tv"></i> Live Matches & Cold Craft Drinks</span>
                <h1>Ice-Cold Draughts, <span class="highlight-gold">Game Day Pitchers</span> & Sizzling Eats</h1>
                <p>Welcome to The Sports Bar — your premium match day stadium venue! From crisp draft lagers, craft IPAs, and game day cocktail pitchers to flame-grilled smash burgers and 30-piece wing buckets. Watch every match on crisp 4K screens and order directly on HYST to enjoy direct prices without middleman app fees!</p>

                <div class="hero-cta-group">
                    <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-trophy"></i> Order Direct on HYST
                    </a>
                    <a href="#calculator" class="btn-secondary">
                        <i class="fa-solid fa-calculator"></i> Compare App Prices
                    </a>
                </div>

                <div class="hero-badges">
                    <div class="badge-item">
                        <i class="fa-solid fa-beer-mug-empty"></i>
                        <span>Cold Draught Beer & Ciders</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-cocktail"></i>
                        <span>Cocktails & Sharing Pitchers</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Zero App Markup on HYST</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-img-box">
                    <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                        <img src="https://images.unsplash.com/photo-1535958636474-b021ee887b13?auto=format&fit=crop&w=900&q=80"
                            alt="Sports Bar Atmosphere with Cold Beer and Big Screen">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <section class="about-section" id="about">
        <div class="container about-grid">
            <div class="about-image-wrapper">
                <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                    <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=900&q=80"
                        alt="Sports Bar Taps pouring Cold Draught Beers">
                </a>
                <div class="about-experience-badge">
                    <div class="num">4K</div>
                    <div class="txt">Ultra HD Vibe</div>
                </div>
            </div>

            <div class="about-content">
                <span class="section-tag"><i class="fa-solid fa-whiskey-glass"></i> Craft Kitchen & Full Bar</span>
                <h2 class="section-title">Where Cold Craft Drinks Meet <span class="highlight-gold">High Octane Sports</span></h2>
                <p class="section-desc">At The Sports Bar, we take match day celebrations seriously. Whether you’re celebrating a late winner or gathering your squad for a high-stakes title fight, our bar is stocked with cold draught beers, signature cocktail pitchers, craft ciders, and premium spirits.</p>

                <div class="about-feature-list">
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>Chilled Draught & Craft</h4>
                            <p>Stella Artois, Madri Excepcional, Guinness & IPAs.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>Sharing Pitchers</h4>
                            <p>Red Bull Vodka pitchers & Tequila Sunrises.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>100% Fresh Halal Eats</h4>
                            <p>Flame-grilled beef smash patties & wing buckets.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>Direct HYST Pricing</h4>
                            <p>Zero delivery markups & fast kitchen dispatch.</p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 25px;">
                    <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-book-open"></i> Explore Menu on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- GEN Z & SQUAD GROUP FUN SECTION -->
    <section class="genz-section" id="squad">
        <div class="container genz-grid">
            <div class="genz-content">
                <span class="section-tag"><i class="fa-solid fa-users"></i> Game Night Squad Zone</span>
                <h2 class="section-title">The Ultimate Hangout For <span class="highlight-gold">Your Match Day Crew</span></h2>
                <p class="section-desc">Gathering the crew for Premier League weekenders, FIFA tournaments, or UFC main cards? The Sports Bar is crafted for high-energy group gatherings.</p>

                <div class="genz-cards-container">
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-wine-bottle"></i>
                        <h4>Beer Buckets</h4>
                        <p>5x Corona or Peroni bottles served over ice.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-glass-water"></i>
                        <h4>Game Day Pitchers</h4>
                        <p>2-Litre sharing pitchers for the whole table.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-drumstick-bite"></i>
                        <h4>Champion Wings</h4>
                        <p>20 or 30 Jumbo Wings tossed in spicy buffalo.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <h4>HYST Savings</h4>
                        <p>True menu pricing with zero app inflation.</p>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-users"></i> Order Squad Feast on HYST
                    </a>
                </div>
            </div>

            <!-- Active Sports & Squad Gallery -->
            <div class="genz-gallery-wrapper">
                <div class="genz-floating-tag">
                    <i class="fa-solid fa-bolt"></i> Match Day Fan Zone
                </div>
                <div class="genz-image-grid">
                    <div class="genz-img-card">
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=600&q=80"
                                alt="Group of Friends Cheering with Drinks">
                        </a>
                        <div class="img-overlay"><i class="fa-solid fa-heart"></i> Stadium Fan Vibe</div>
                    </div>
                    <div class="genz-img-card">
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?auto=format&fit=crop&w=600&q=80"
                                alt="Cold Draught Beers on Sports Bar Counter">
                        </a>
                        <div class="img-overlay"><i class="fa-solid fa-beer-mug-empty"></i> Cold Draught Taps</div>
                    </div>
                    <div class="genz-img-card">
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1561758033-d89a9ad46330?auto=format&fit=crop&w=600&q=80"
                                alt="Sizzling Gourmet Smash Burgers">
                        </a>
                        <div class="img-overlay"><i class="fa-solid fa-burger"></i> Smash Burgers</div>
                    </div>
                    <div class="genz-img-card">
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=600&q=80"
                                alt="Game Day Cocktail Pitcher">
                        </a>
                        <div class="img-overlay"><i class="fa-solid fa-cocktail"></i> Cocktails</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SIGNATURE MENU & DRINKS SECTIONS -->
    <section class="menu-section" id="menu">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-star"></i> Stadium Menu & Bar</span>
                <h2 class="section-title">Match Day Drinks & <span class="highlight-gold">Gourmet Food Menu</span></h2>
                <p class="section-desc" style="margin: 0 auto;">Cold beers, signature pitchers, draft ciders, Halal smash burgers, wing buckets, and loaded fries.</p>
            </div>

            <!-- DRINKS CATEGORY -->
            <h3 class="menu-category-title"><i class="fa-solid fa-beer-mug-empty"></i> Draught Beers, Pitchers & Game Day Drinks</h3>
            <div class="menu-grid">
                <!-- Drink Item 1 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Draught Special</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1608270586620-248524c67de9?auto=format&fit=crop&w=600&q=80"
                                alt="Pint of Cold Draught Lager">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Madri / Stella Pint</h3>
                                <span class="menu-price">£5.80</span>
                            </div>
                            <p class="menu-desc">Ice-cold crisp Mediterranean lager poured fresh from our stadium taps.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Drink Item 2 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Squad Bucket</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS4vvCMj4I-oe1XwaUa3JhCt697Zj3Cu6cQZE1djh6rw&s=10"
                                alt="Ice Cold Beer Bucket">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Corona Ice Bucket (5x)</h3>
                                <span class="menu-price">£21.95</span>
                            </div>
                            <p class="menu-desc">5 Bottles of cold Corona Extra served over ice with fresh lime wedges.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Drink Item 3 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Sharing Pitcher</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=600&q=80"
                                alt="Red Bull Vodka Cocktail Pitcher">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Stadium Punch Pitcher</h3>
                                <span class="menu-price">£18.50</span>
                            </div>
                            <p class="menu-desc">2-Litre sharing pitcher with Red Bull, vodka, rum & tropical juice.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Drink Item 4 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Non-Alcoholic</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTy0x0MpPl8fj21VlSGh24_huN-OEac_nOCSPk0gA8CIg&s=10"
                                alt="Frozen Slush Mocktail">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Monster Frozen Slush</h3>
                                <span class="menu-price">£4.95</span>
                            </div>
                            <p class="menu-desc">Frozen energy blast layered with blue raspberry & passion fruit.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>
            </div>

            <!-- FOOD CATEGORY -->
            <h3 class="menu-category-title"><i class="fa-solid fa-burger"></i> Gourmet Match Day Eats</h3>
            <div class="menu-grid">
                <!-- Food Item 1 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">#1 Best Seller</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=600&q=80"
                                alt="The Victory Smash Burger">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>The Victory Smash Burger</h3>
                                <span class="menu-price">£9.95</span>
                            </div>
                            <p class="menu-desc">Double smashed halal beef, American cheese, crispy onions & house relish.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Food Item 2 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Bucket Special</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1527477396000-e27163b481c2?auto=format&fit=crop&w=600&q=80"
                                alt="Stadium Wing Bucket">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Wing Bucket (6 Pcs)</h3>
                                <span class="menu-price">£11.95</span>
                            </div>
                            <p class="menu-desc">Jumbo wings tossed in Spicy Buffalo, Honey Garlic, or Smoky BBQ sauce.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Food Item 3 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Squad Combo</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=600&q=80"
                                alt="Champion Squad Feast Platter">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Champion Squad Feast</h3>
                                <span class="menu-price">£24.95</span>
                            </div>
                            <p class="menu-desc">2 Burgers, 10 Buffalo Wings, Large Cheese Fries & 2 Drinks or Pints.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Food Item 4 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Loaded Side</span>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&fit=crop&w=600&q=80"
                                alt="Loaded Overtime Cheese Fries">
                        </a>
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Overtime Loaded Fries</h3>
                                <span class="menu-price">£6.50</span>
                            </div>
                            <p class="menu-desc">Golden fries with cheddar sauce, crispy tenders, jalapeños & spicy ranch.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>
            </div>

            <div class="cta-row-center">
                <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-trophy"></i> View Full Menu & Order Direct on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- SAVINGS CALCULATOR SECTION -->
    <section class="calculator-section" id="calculator">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-calculator"></i> Smart Price Shield</span>
                <h2 class="section-title">Calculate Your Savings <span class="highlight-gold">By Ordering Direct</span></h2>
                <p class="section-desc" style="margin: 0 auto;">Food apps add service fees and mark up menu prices by up to 25%. See how much you save by ordering directly on HYST!</p>
            </div>

            <div class="calc-box">
                <div class="calc-controls">
                    <div class="control-group">
                        <label>Squad Group Size: <span id="peopleCountText" style="color:var(--brand-green);">4 People</span></label>
                        <input type="range" min="1" max="10" value="4" class="calc-slider" id="peopleSlider">
                    </div>

                    <div class="control-group">
                        <label>Match Day Feast Scale</label>
                        <select class="vibe-select" id="vibeSelect">
                            <option value="light">Solo Match Combo (Burger + Pint)</option>
                            <option value="medium" selected>Squad Combo (Burgers + Wings + Pitcher)</option>
                            <option value="heavy">Mega Squad Party (Burgers + Wings + Corona Bucket)</option>
                        </select>
                    </div>
                </div>

                <div class="calc-comparison-grid">
                    <div class="calc-card-other">
                        <div class="price-label">Third-Party Apps</div>
                        <div class="price-value-other" id="otherPrice">£62.50</div>
                        <p style="font-size:0.78rem; color:#ef4444; margin-top:8px;">Includes 22% menu markup + service + delivery fees</p>
                    </div>

                    <div class="calc-card-hyst">
                        <span class="savings-badge" id="savingsBadge">SAVE £15.50</span>
                        <div class="price-label">HYST Direct Price</div>
                        <div class="price-value-hyst" id="hystPrice">£47.00</div>
                        <p style="font-size:0.82rem; color:var(--brand-green); margin-top:8px; font-weight:700;">Guaranteed direct kitchen price!</p>
                    </div>
                </div>

                <div class="cta-row-center">
                    <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-piggy-bank"></i> Lock In Direct Price - Order on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPARISON TABLE SECTION -->
    <section class="compare-section" id="compare">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-code-compare"></i> Value Comparison</span>
                <h2 class="section-title">HYST Direct Order vs <span class="highlight-gold">Third-Party Apps</span></h2>
                <p class="section-desc" style="margin: 0 auto;">Compare the perks of ordering direct from our venue team versus third-party apps.</p>
            </div>

            <div class="table-wrapper">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th>Feature / Service Benefit</th>
                            <th class="brand-col"><i class="fa-solid fa-shield-halved"></i> HYST Direct Order</th>
                            <th>Third-Party Delivery Apps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Menu & Drink Markup</strong></td>
                            <td>0% Markup (Original Price) <i class="fa-solid fa-check-circle"></i></td>
                            <td>15% to 25% Higher Prices <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Service Charges</strong></td>
                            <td>Zero Added Fees <i class="fa-solid fa-check-circle"></i></td>
                            <td>Mandatory Service Fees <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Exclusive Combos</strong></td>
                            <td>Full Access to Beer Buckets <i class="fa-solid fa-check-circle"></i></td>
                            <td>Limited Menu Items <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Kick-off Delivery Priority</strong></td>
                            <td>Direct Dispatch Priority <i class="fa-solid fa-check-circle"></i></td>
                            <td>Multiple Rider Stops <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Direct Venue Support</strong></td>
                            <td>100% Revenue Keeps Bar Running <i class="fa-solid fa-check-circle"></i></td>
                            <td>High Corporate Deductions <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cta-row-center">
                <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-bolt"></i> Order Direct & Save Big on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- FAQS ACCORDION SECTION -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-circle-question"></i> Everything You Need To Know</span>
                <h2 class="section-title">Frequently Asked <span class="highlight-gold">Questions</span></h2>
                <p class="section-desc" style="margin: 0 auto;">Find answers regarding broadcasts, drinks menu, halal food certification, and ordering via HYST.</p>
            </div>

            <div class="faq-layout">
                <!-- STICKY LEFT SIDE IMAGE -->
                <div class="faq-image-wrapper">
                    <div class="faq-image-container">
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank">
                            <img src="https://images.unsplash.com/photo-1572116469696-31de0f17cc34?auto=format&fit=crop&w=900&q=80"
                                alt="The Sports Bar Big Screen Experience">
                        </a>
                        <div class="faq-image-badge">
                            <i class="fa-solid fa-headset"></i>
                            <div>
                                <h5>Need Game Day Help?</h5>
                                <p>Order direct on HYST for live tracking!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE FAQ ACCORDION -->
                <div class="faq-grid">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>1. What live sporting events do you broadcast?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            We broadcast all major live events in 4K: Premier League, Champions League, UFC Pay-Per-View, Formula 1, Six Nations Rugby, and Boxing.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>2. What drinks are available on draught & bottle?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Madri, Stella Artois, Guinness, Cider, Craft IPAs on tap, along with 5x Corona Ice Buckets, Cocktail Pitchers, and energy slushies.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>3. Why should I order food & drinks on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Delivery apps mark up menu prices by up to 25%. Ordering directly on HYST gives you direct venue prices with zero service markups.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>4. Is all food 100% Halal certified?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! All beef smash burgers, chicken wings, tenders, and sauces are 100% Halal certified and freshly prepared.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>5. What signature wing flavors do you offer?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Spicy Buffalo, Smoky Honey BBQ, Spicy Mango Habanero, Garlic Parmesan, and Sweet Chili.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>6. How do I place a direct order on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Click any "Order Direct" button on this page or visit <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" style="color:var(--brand-green); text-decoration:underline;">https://hyst.uk/restaurant/sports-bar</a>.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>7. Are vegetarian or vegan options available?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! We offer Beyond Meat smash burgers, grilled halloumi sticks, loaded vegetarian nachos, and skin-on fries.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>8. Can I order squad bundles for large groups?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! Our HYST menu features exclusive Champion Squad Platters, giant 20/30 Wing Buckets, and Beer Bucket Combos.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>9. Can I pre-order before kick-off?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! Select your kick-off time during checkout on HYST to ensure hot food arrives right on time.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>10. Can I track my order status in real-time?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! You will receive real-time updates and SMS notifications from prep time to doorstep arrival.
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-trophy"></i> Ready For Kick-Off? Order Direct on HYST
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="https://hyst.uk/restaurant/sports-bar" class="logo">
                        <i class="fa-solid fa-trophy"></i> THE SPORTS BAR
                    </a>
                    <p>The UK's premier sports atmosphere venue serving draught lagers, cocktail pitchers, smash burgers, and wing buckets.</p>
                </div>

                <div class="footer-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#about">Arena Experience</a></li>
                        <li><a href="#squad">Squad & Game Day</a></li>
                        <li><a href="#menu">Drinks & Menu</a></li>
                        <li><a href="#calculator">Savings Calc</a></li>
                        <li><a href="#compare">HYST vs Apps</a></li>
                        <li><a href="#faq">FAQs</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Direct Menu</h4>
                    <ul>
                        <li><a href="https://hyst.uk/restaurant/sports-bar" target="_blank">Draught Beers & Pitchers</a></li>
                        <li><a href="https://hyst.uk/restaurant/sports-bar" target="_blank">Smash Burgers</a></li>
                        <li><a href="https://hyst.uk/restaurant/sports-bar" target="_blank">Stadium Wing Buckets</a></li>
                        <li><a href="https://hyst.uk/restaurant/sports-bar" target="_blank">Overtime Loaded Fries</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Match Day Ordering</h4>
                    <p style="color: #A3A3A3; margin-bottom: 12px; font-size: 0.88rem;">Skip third-party markups & support your venue!</p>
                    <a href="https://hyst.uk/restaurant/sports-bar" target="_blank" class="btn-primary" style="width:100%;">
                        <i class="fa-solid fa-beer-mug-empty"></i> Order Direct on HYST
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 The Sports Bar. Powered by <a href="https://hyst.uk/restaurant/sports-bar"
                        target="_blank" style="color:var(--brand-green);">HYST Direct Ordering Portal</a>.</p>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT -->
    <script>
        // 1. Responsive Mobile Navigation Toggle & Scroll Lock
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const isOpen = navMenu.classList.contains('active');
            menuToggle.querySelector('i').className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                menuToggle.querySelector('i').className = 'fa-solid fa-bars';
                document.body.style.overflow = '';
            });
        });

        // 2. Interactive Savings Calculator
        const peopleSlider = document.getElementById('peopleSlider');
        const peopleCountText = document.getElementById('peopleCountText');
        const vibeSelect = document.getElementById('vibeSelect');
        const otherPrice = document.getElementById('otherPrice');
        const hystPrice = document.getElementById('hystPrice');
        const savingsBadge = document.getElementById('savingsBadge');

        function updateSavings() {
            const people = parseInt(peopleSlider.value);
            const vibe = vibeSelect.value;
            peopleCountText.textContent = `${people} ${people === 1 ? 'Person' : 'People'}`;

            let basePricePerPerson = 9.5;
            if (vibe === 'medium') basePricePerPerson = 12.0;
            if (vibe === 'heavy') basePricePerPerson = 17.5;

            const hystTotal = (people * basePricePerPerson).toFixed(2);
            const otherTotal = ((people * basePricePerPerson * 1.22) + 3.99 + 3.99).toFixed(2);
            const savings = (otherTotal - hystTotal).toFixed(2);

            hystPrice.textContent = `£${hystTotal}`;
            otherPrice.textContent = `£${otherTotal}`;
            savingsBadge.textContent = `SAVE £${savings}`;
        }

        peopleSlider.addEventListener('input', updateSavings);
        vibeSelect.addEventListener('change', updateSavings);

        // 3. FAQ Accordion Toggle
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const item = q.parentElement;
                item.classList.toggle('active');
            });
        });
    </script>
</body>

</html>