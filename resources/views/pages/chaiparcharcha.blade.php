<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chai Par Charcha | Authentic Kulhad Chai, Indian Street Eats & Parathas | Order Direct on HYST</title>
    
    <!-- Meta Tags for SEO, AEO & GEO -->
    <meta name="description" content="Experience authentic Indian Kulhad Masala Chai, piping hot stuffed parathas, crisp samosas & street food at Chai Par Charcha. Order direct on HYST to save up to 25% with zero app commissions!">
    <meta name="keywords" content="Chai Par Charcha, Chai Par Charcha HYST, Authentic Kulhad Chai, Indian Street Food, Stuffed Parathas, Samosa Chaat, Bun Maska, Cutting Chai, Order Direct HYST">
    <meta name="robots" content="index, follow">

    <!-- Open Graph & Social Meta -->
    <meta property="og:title" content="Chai Par Charcha | Authentic Chai & Street Food | Order Direct on HYST">
    <meta property="og:description" content="Piping hot kulhad chai, buttered bun maska, and authentic street eats. Order directly on HYST for guaranteed lowest menu prices!">
    <meta property="og:type" content="restaurant">
    <meta property="og:url" content="https://hyst.uk/restaurant/chai-par-charcha-1780510502">
    <meta property="og:image" content="https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=1200&q=80">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Schema.org JSON-LD for GEO/AEO/SEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Restaurant",
      "name": "Chai Par Charcha",
      "image": "https://images.unsplash.com/photo-1576092768241-dec231879fc3",
      "url": "https://hyst.uk/restaurant/chai-par-charcha-1780510502",
      "telephone": "+441234567890",
      "priceRange": "£",
      "menu": "https://hyst.uk/restaurant/chai-par-charcha-1780510502",
      "servesCuisine": ["Indian Chai", "Street Food", "Parathas", "Samosa", "Desi Breakfast", "Halal Snacks"],
      "acceptsReservations": "True",
      "hasMenu": "https://hyst.uk/restaurant/chai-par-charcha-1780510502"
    }
    </script>

    <style>
        /* ==========================================================================
           CHAI PE CHARCHA BRAND DESIGN SYSTEM & COLOR PALETTE
           ========================================================================== */
        :root {
            /* Brand Theme Palette based on Chai Pe Charcha */
            --chai-brown-dark: #2C1810;     /* Deep Roasted Tea / Dark Wood */
            --chai-brown-card: #3A2218;     /* Card Background Dark */
            --border-dark: #523427;         /* Subtle Wood Border */
            
            --chai-saffron: #D96B27;        /* Vibrant Saffron / Kulhad Terracotta */
            --chai-saffron-dark: #B55217;   /* Deep Spice Rust */
            --chai-gold: #E5A823;          /* Cardamom Honey Gold */
            --chai-gold-glow: rgba(229, 168, 35, 0.25);

            --bg-light-cream: #FDF8F2;      /* Warm Milk Cream Background */
            --bg-light-card: #FFFFFF;       /* Pure White Card */
            --border-light: #EBDAC8;        /* Soft Cream Border */

            --text-dark-theme: #FFF8F0;     /* Warm Cream Text on Dark */
            --text-dark-muted: #D1BEB0;     /* Muted Cream Text */
            --text-light-theme: #2C1810;    /* Dark Roast Text on Light */
            --text-light-muted: #6E5A51;    /* Muted Brown Text */

            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            line-height: 1.7;
            overflow-x: hidden;
            background-color: var(--chai-brown-dark);
            color: var(--text-dark-theme);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            letter-spacing: 0.5px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Buttons & Call To Actions */
        .btn-primary {
            background: linear-gradient(135deg, var(--chai-saffron), var(--chai-saffron-dark));
            color: #ffffff !important;
            font-weight: 800;
            padding: 13px 26px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--chai-gold);
            box-shadow: 0 10px 25px rgba(217, 107, 39, 0.38);
            transition: var(--transition);
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.84rem;
            letter-spacing: 0.8px;
            white-space: nowrap;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, var(--chai-gold), var(--chai-saffron));
            color: var(--chai-brown-dark) !important;
            box-shadow: 0 15px 35px rgba(229, 168, 35, 0.45);
            border-color: #ffffff;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--chai-gold);
            color: var(--chai-gold);
            font-weight: 700;
            padding: 13px 26px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 0.84rem;
            letter-spacing: 0.8px;
            white-space: nowrap;
        }

        .btn-secondary:hover {
            background: rgba(229, 168, 35, 0.18);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .section-tag {
            color: var(--chai-gold);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 3px;
            display: inline-block;
            margin-bottom: 12px;
            position: relative;
        }

        .section-title {
            font-size: clamp(2.2rem, 4.5vw, 3.4rem);
            line-height: 1.18;
            margin-bottom: 20px;
        }

        .section-desc {
            max-width: 820px;
            font-size: 1.08rem;
            margin-bottom: 35px;
            line-height: 1.8;
        }

        .highlight-gold {
            color: var(--chai-gold);
            background: linear-gradient(135deg, #F8D376, var(--chai-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .highlight-saffron {
            color: var(--chai-saffron);
        }

        .cta-row-center {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
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
            background: rgba(44, 24, 16, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-dark);
            padding: 12px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .logo {
            font-family: var(--font-heading);
            font-size: 1.3rem;
            font-weight: 900;
            color: var(--chai-gold);
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .logo i {
            color: var(--chai-saffron);
            font-size: 1.2rem;
        }

        .nav-menu {
            display: flex;
            align-items: center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
            list-style: none;
        }

        .nav-links a {
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--text-dark-muted);
            transition: var(--transition);
            white-space: nowrap;
        }

        .nav-links a:hover {
            color: var(--chai-gold);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--chai-gold);
            font-size: 1.6rem;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .menu-toggle {
                display: block;
            }

            .header-actions .btn-primary {
                display: none;
            }

            .nav-menu {
                position: fixed;
                top: 65px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 65px);
                background: var(--chai-brown-dark);
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                padding: 40px 20px;
                gap: 25px;
                transition: var(--transition);
                border-top: 1px solid var(--border-dark);
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-links {
                flex-direction: column;
                gap: 22px;
                text-align: center;
                width: 100%;
            }

            .nav-links a {
                font-size: 1.1rem;
            }

            .mobile-hyst-btn {
                display: flex !important;
                width: 100%;
                justify-content: center;
                margin-top: 15px;
            }
        }

        .mobile-hyst-btn {
            display: none;
        }

        /* ==========================================================================
           SECTION 1: HERO
           ========================================================================== */
        .hero {
            padding: 155px 0 95px;
            background: radial-gradient(circle at 80% 20%, rgba(217, 107, 39, 0.28) 0%, rgba(44, 24, 16, 1) 75%);
            color: var(--text-dark-theme);
            position: relative;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 50px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: clamp(2.4rem, 5vw, 4.2rem);
            line-height: 1.12;
            margin-bottom: 22px;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: var(--text-dark-muted);
            margin-bottom: 35px;
            line-height: 1.8;
        }

        .hero-badges {
            display: flex;
            gap: 16px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .badge-item {
            background: var(--chai-brown-card);
            border: 1px solid var(--border-dark);
            padding: 12px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-item i {
            color: var(--chai-gold);
            font-size: 1.1rem;
        }

        .badge-item span {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-dark-theme);
        }

        .hero-img-box {
            background: linear-gradient(145deg, var(--chai-brown-card), #482B1F);
            border: 2px solid var(--border-dark);
            border-radius: 28px;
            padding: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.8);
            position: relative;
        }

        .hero-img-box img {
            width: 100%;
            height: 470px;
            border-radius: 20px;
            object-fit: cover;
        }

        /* ==========================================================================
           SECTION 2: ABOUT US
           ========================================================================== */
        .about-section {
            padding: 100px 0;
            background: var(--bg-light-cream);
            color: var(--text-light-theme);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-image-wrapper {
            position: relative;
        }

        .about-image-wrapper img {
            width: 100%;
            height: 510px;
            object-fit: cover;
            border-radius: 24px;
            border: 6px solid #ffffff;
            box-shadow: 0 20px 45px rgba(44, 24, 16, 0.12);
        }

        .about-experience-badge {
            position: absolute;
            bottom: -25px;
            right: -25px;
            background: linear-gradient(135deg, var(--chai-saffron), var(--chai-saffron-dark));
            color: #ffffff;
            padding: 20px 28px;
            border-radius: 20px;
            border: 2px solid var(--chai-gold);
            box-shadow: 0 15px 30px rgba(217, 107, 39, 0.35);
            text-align: center;
        }

        .about-experience-badge .num {
            font-family: var(--font-heading);
            font-size: 2.3rem;
            font-weight: 900;
            line-height: 1;
            color: var(--chai-gold);
        }

        .about-experience-badge .txt {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .about-content p {
            color: var(--text-light-muted);
            font-size: 1.05rem;
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .about-feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin: 30px 0;
        }

        .about-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .about-feature-item i {
            color: var(--chai-saffron);
            font-size: 1.2rem;
            margin-top: 3px;
        }

        .about-feature-item h4 {
            font-size: 0.98rem;
            color: var(--text-light-theme);
            margin-bottom: 2px;
        }

        .about-feature-item p {
            font-size: 0.85rem;
            color: var(--text-light-muted);
            margin: 0;
        }

        /* ==========================================================================
           SECTION 3: SQUAD LOUNGE & GEN Z VIBE (4-IMAGE GRID)
           ========================================================================== */
        .genz-section {
            padding: 100px 0;
            background: var(--chai-brown-dark);
            color: var(--text-dark-theme);
        }

        .genz-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .genz-content p {
            color: var(--text-dark-muted);
            font-size: 1.05rem;
            margin-bottom: 25px;
            line-height: 1.8;
        }

        .genz-cards-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .genz-mini-card {
            background: var(--chai-brown-card);
            border: 1px solid var(--border-dark);
            padding: 22px;
            border-radius: 18px;
            transition: var(--transition);
        }

        .genz-mini-card:hover {
            border-color: var(--chai-gold);
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(229, 168, 35, 0.15);
        }

        .genz-mini-card i {
            font-size: 1.8rem;
            color: var(--chai-gold);
            margin-bottom: 10px;
        }

        .genz-mini-card h4 {
            font-size: 1.1rem;
            margin-bottom: 6px;
            color: var(--text-dark-theme);
        }

        .genz-mini-card p {
            font-size: 0.88rem;
            color: var(--text-dark-muted);
            margin-bottom: 0;
        }

        .genz-gallery-wrapper {
            position: relative;
        }

        .genz-floating-tag {
            position: absolute;
            top: -18px;
            left: 20px;
            z-index: 10;
            background: linear-gradient(135deg, var(--chai-gold), #F8D376);
            color: var(--chai-brown-dark);
            font-weight: 900;
            padding: 10px 22px;
            border-radius: 30px;
            font-size: 0.82rem;
            box-shadow: 0 10px 25px rgba(229, 168, 35, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .genz-image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            background: var(--chai-brown-card);
            padding: 16px;
            border-radius: 28px;
            border: 2px solid var(--border-dark);
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
        }

        .genz-img-card {
            position: relative;
            height: 220px;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--border-dark);
        }

        .genz-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .genz-img-card:hover img {
            transform: scale(1.1);
        }

        .genz-img-card .img-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 12px 14px;
            background: linear-gradient(to top, rgba(44, 24, 16, 0.94), transparent);
            color: var(--chai-gold);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ==========================================================================
           SECTION 4: SIGNATURE MENU HIGHLIGHTS
           ========================================================================== */
        .menu-section {
            padding: 100px 0;
            background: var(--bg-light-cream);
            color: var(--text-light-theme);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 28px;
            margin-top: 45px;
        }

        .menu-card {
            background: var(--bg-light-card);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 25px rgba(44, 24, 16, 0.05);
        }

        .menu-card:hover {
            transform: translateY(-8px);
            border-color: var(--chai-saffron);
            box-shadow: 0 18px 40px rgba(217, 107, 39, 0.18);
        }

        .menu-img-container {
            height: 210px;
            position: relative;
            overflow: hidden;
        }

        .menu-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .menu-card:hover .menu-img-container img {
            transform: scale(1.08);
        }

        .dish-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(44, 24, 16, 0.92);
            border: 1px solid var(--chai-gold);
            color: var(--chai-gold);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .menu-details {
            padding: 22px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .menu-title-row h3 {
            font-size: 1.2rem;
            color: var(--text-light-theme);
        }

        .menu-price {
            font-size: 1.25rem;
            color: var(--chai-saffron);
            font-weight: 900;
            font-family: var(--font-heading);
        }

        .menu-desc {
            color: var(--text-light-muted);
            font-size: 0.88rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        /* ==========================================================================
           SECTION 5: SAVINGS CALCULATOR
           ========================================================================== */
        .calculator-section {
            padding: 100px 0;
            background: var(--chai-brown-dark);
            color: var(--text-dark-theme);
        }

        .calc-box {
            background: var(--chai-brown-card);
            border: 2px solid var(--border-dark);
            border-radius: 24px;
            padding: 40px;
            max-width: 950px;
            margin: 0 auto;
            box-shadow: 0 25px 60px rgba(0,0,0,0.7);
        }

        .calc-controls {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }

        .control-group label {
            display: block;
            font-weight: 800;
            margin-bottom: 12px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            color: var(--chai-gold);
        }

        .calc-slider {
            width: 100%;
            accent-color: var(--chai-saffron);
            height: 8px;
            background: var(--border-dark);
            border-radius: 5px;
            outline: none;
            cursor: pointer;
        }

        .vibe-select {
            width: 100%;
            padding: 14px;
            background: #23120B;
            border: 1px solid var(--border-dark);
            color: var(--text-dark-theme);
            border-radius: 12px;
            font-family: var(--font-body);
            font-weight: 700;
            outline: none;
            cursor: pointer;
        }

        .calc-comparison-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 35px;
        }

        .calc-card-other {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 24px;
            border-radius: 18px;
            text-align: center;
        }

        .calc-card-hyst {
            background: rgba(16, 185, 129, 0.08);
            border: 2px solid #10b981;
            padding: 24px;
            border-radius: 18px;
            text-align: center;
            position: relative;
        }

        .calc-card-hyst .savings-badge {
            position: absolute;
            top: -14px;
            right: 20px;
            background: #10b981;
            color: #ffffff;
            font-weight: 900;
            font-size: 0.78rem;
            padding: 4px 14px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .price-label {
            font-size: 0.88rem;
            color: var(--text-dark-muted);
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .price-value-other {
            font-size: 2.2rem;
            font-weight: 900;
            color: #ef4444;
            font-family: var(--font-heading);
            text-decoration: line-through;
        }

        .price-value-hyst {
            font-size: 2.5rem;
            font-weight: 900;
            color: #10b981;
            font-family: var(--font-heading);
        }

        /* ==========================================================================
           SECTION 6: COMPARISON TABLE
           ========================================================================== */
        .compare-section {
            padding: 100px 0;
            background: var(--bg-light-cream);
            color: var(--text-light-theme);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .table-wrapper {
            overflow-x: auto;
            margin-top: 40px;
        }

        .compare-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            background: var(--bg-light-card);
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--border-light);
            box-shadow: 0 15px 35px rgba(44, 24, 16, 0.05);
        }

        .compare-table th, .compare-table td {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-light);
        }

        .compare-table th {
            background: #F5EAE0;
            font-family: var(--font-heading);
            font-size: 1.08rem;
            text-transform: uppercase;
            color: var(--text-light-theme);
        }

        .compare-table th.brand-col {
            color: #ffffff;
            background: var(--chai-saffron-dark);
        }

        .compare-table td i.fa-check-circle {
            color: #10b981;
            font-size: 1.2rem;
        }

        .compare-table td i.fa-times-circle {
            color: #ef4444;
            font-size: 1.2rem;
        }

        /* ==========================================================================
           SECTION 7: FAQS (10 ACCORDION ITEMS WITH STICKY SIDE IMAGE)
           ========================================================================== */
        .faq-section {
            padding: 100px 0;
            background: var(--chai-brown-dark);
            color: var(--text-dark-theme);
        }

        .faq-layout {
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            gap: 45px;
            align-items: flex-start;
            margin-top: 40px;
        }

        .faq-image-wrapper {
            position: sticky;
            top: 90px;
            background: var(--chai-brown-card);
            padding: 12px;
            border-radius: 22px;
            border: 1px solid var(--border-dark);
            box-shadow: 0 20px 45px rgba(0,0,0,0.6);
        }

        .faq-image-container {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
        }

        .faq-image-container img {
            width: 100%;
            height: 100%;
            max-height: 580px;
            object-fit: cover;
            display: block;
            border-radius: 16px;
        }

        .faq-image-badge {
            position: absolute;
            bottom: 16px;
            left: 16px;
            right: 16px;
            background: rgba(44, 24, 16, 0.94);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-dark);
            color: #ffffff;
            padding: 16px 18px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .faq-image-badge i {
            font-size: 1.8rem;
            color: var(--chai-gold);
        }

        .faq-image-badge h5 {
            font-size: 0.95rem;
            color: var(--chai-gold);
            margin-bottom: 2px;
        }

        .faq-image-badge p {
            font-size: 0.82rem;
            color: var(--text-dark-muted);
            margin: 0;
        }

        .faq-grid {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .faq-item {
            background: var(--chai-brown-card);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            overflow: hidden;
            transition: var(--transition);
        }

        .faq-question {
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-dark-theme);
        }

        .faq-question i {
            color: var(--chai-gold);
            transition: var(--transition);
        }

        .faq-answer {
            padding: 0 24px 20px;
            color: var(--text-dark-muted);
            font-size: 0.95rem;
            display: none;
            line-height: 1.7;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        /* ==========================================================================
           FOOTER
           ========================================================================== */
        footer {
            background: #1C0F0A;
            color: var(--text-dark-theme);
            padding: 75px 0 30px;
            border-top: 1px solid var(--border-dark);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-brand p {
            color: var(--text-dark-muted);
            margin-top: 16px;
            font-size: 0.92rem;
            line-height: 1.7;
        }

        .footer-col h4 {
            font-size: 1.08rem;
            margin-bottom: 20px;
            color: var(--chai-gold);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: var(--text-dark-muted);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: var(--chai-gold);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--border-dark);
            color: var(--text-dark-muted);
            font-size: 0.88rem;
        }

        /* Responsive Layout Overrides */
        @media (max-width: 991px) {
            .hero-grid, .about-grid, .genz-grid, .calc-controls, .calc-comparison-grid, .footer-grid, .faq-layout {
                grid-template-columns: 1fr;
            }
            .faq-image-wrapper {
                position: relative;
                top: 0;
            }
            .genz-cards-container, .about-feature-list {
                grid-template-columns: 1fr;
            }
            .hero {
                padding-top: 130px;
            }
            .about-image-wrapper img, .hero-img-box img {
                height: 360px;
            }
            .genz-img-card {
                height: 180px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER / NAVIGATION -->
    <header>
        <div class="container nav-container">
            <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" class="logo">
                <i class="fa-solid fa-mug-hot"></i> CHAI PAR CHARCHA
            </a>

            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="#about">Our Chai Story</a></li>
                    <li><a href="#squad">Chai & Charcha Squad</a></li>
                    <li><a href="#menu">Menu Highlights</a></li>
                    <li><a href="#calculator">Savings Calc</a></li>
                    <li><a href="#compare">HYST vs Apps</a></li>
                    <li><a href="#faq">FAQs</a></li>
                </ul>
                
                <div class="mobile-hyst-btn">
                    <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-bag-shopping"></i> Order Direct on HYST
                    </a>
                </div>
            </div>

            <div class="header-actions">
                <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-bag-shopping"></i> Order Direct
                </a>
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- SECTION 1: HERO -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <span class="section-tag"><i class="fa-solid fa-fire"></i> Authentic Indian Street Cafe & Chai Bistro</span>
                <h1>Where Fresh <span class="highlight-gold">Kulhad Chai</span> Meets Authentic Desi Charcha</h1>
                <p>Welcome to Chai Par Charcha — your ultimate neighborhood hub for freshly brewed cardamom-ginger kulhad tea, buttery bun maska, crisp samosa chaat, and steaming hot stuffed parathas! Experience the nostalgic warmth of roadside street stalls paired with contemporary cafe comfort. Skip third-party app markup commissions — order directly on HYST to enjoy guaranteed original menu prices and instant kitchen dispatch!</p>
                
                <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                    <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-mug-hot"></i> Order Direct on HYST
                    </a>
                    <a href="#calculator" class="btn-secondary">
                        <i class="fa-solid fa-calculator"></i> Compare App Prices
                    </a>
                </div>

                <div class="hero-badges">
                    <div class="badge-item">
                        <i class="fa-solid fa-mortar-pestle"></i>
                        <span>Fresh Hand-Crushed Spices</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-tag"></i>
                        <span>Zero App Commission Markup</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-motorcycle"></i>
                        <span>Express Direct Delivery</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-img-box">
                    <img src="https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=900&q=80" alt="Freshly Brewed Indian Masala Kulhad Chai">
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: ABOUT US -->
    <section class="about-section" id="about">
        <div class="container about-grid">
            <div class="about-image-wrapper">
                <img src="https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=900&q=80" alt="Freshly Made Samosas and Street Snacks">
                <div class="about-experience-badge">
                    <div class="num">100%</div>
                    <div class="txt">Authentic Brews</div>
                </div>
            </div>

            <div class="about-content">
                <span class="section-tag"><i class="fa-solid fa-heart"></i> The Heritage of Great Conversations</span>
                <h2 class="section-title" style="color:var(--text-light-theme);">Brewing Memories, One <span class="highlight-saffron">Kulhad Cup</span> At A Time</h2>
                <p>In India, Chai is not just a drink; it is an emotion, a daily ritual, and the centerpiece of every meaningful discussion. At Chai Par Charcha, we bring that rich street-side tea stall tradition straight to your table. Our signature teas are slow-boiled in brass kettles using freshly crushed ginger, green cardamom, cloves, and whole cinnamon bark.</p>
                <p>Paired with our hand-rolled stuffed parathas, fiery vada pavs, crisp samosas, and maska-smeared bun maska, every bite takes you back to bustling college canteens and evening street corners. When you order through HYST, your food arrives piping hot straight from our kitchen with zero inflated app prices.</p>

                <div class="about-feature-list">
                    <div class="about-feature-item">
                        <i class="fa-solid fa-check-double"></i>
                        <div>
                            <h4>Authentic Clay Kulhads</h4>
                            <p>Earthy terracotta cups adding that distinct aroma to every sip.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-check-double"></i>
                        <div>
                            <h4>Slow-Boiled Spice Infusion</h4>
                            <p>Natural ginger, cardamom & clove crushed fresh for every kettle batch.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-check-double"></i>
                        <div>
                            <h4>Fresh Hot Parathas</h4>
                            <p>Hand-rolled whole wheat parathas stuffed generously with spiced fillings.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-check-double"></i>
                        <div>
                            <h4>HYST Wallet Protection</h4>
                            <p>Order directly on HYST to eliminate 20%+ delivery app commissions.</p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-book-open"></i> Explore Our Menu & Order on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: SQUAD LOUNGE & GEN Z VIBE (4-IMAGE GRID) -->
    <section class="genz-section" id="squad">
        <div class="container genz-grid">
            <div class="genz-content">
                <span class="section-tag"><i class="fa-solid fa-users"></i> Squad Hangout & Evening Charcha</span>
                <h1>The Ultimate Spot For <span class="highlight-gold">Chai Breaks & Squad Gossip</span></h1>
                <p>Late night study sessions, post-work catchups, or weekend squad hangouts — everything happens over chai! Chai Par Charcha is designed for youth foodies, Gen Z crews, and families who love bold flavors and relaxed cafe energy. Stack up our sharing platters, crisp pakoras, garlic butter parathas, and endless cutting chai rounds.</p>
                <p>Whether you're hosting a game night at home or craving late-night street food, Chai Par Charcha delivers fast. Ordering on HYST ensures your group gets max food for your money without paying extra delivery platform markups!</p>

                <div class="genz-cards-container">
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-cookie-bite"></i>
                        <h4>Cutting Chai & Bun Maska</h4>
                        <p>The iconic duo: sweet Irani chai with warm maska-bun hot off the toaster grill.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-fire-burner"></i>
                        <h4>Sizzling Street Bites</h4>
                        <p>Loaded samosa chaat, dahi puri, and hot paneer rolls made for sharing with squad.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-moon"></i>
                        <h4>Late Night Cravings</h4>
                        <p>Satisfy late tea cravings with piping hot delivery straight to your doorstep.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <h4>Zero App Markups</h4>
                        <p>Get maximum snacks for your budget by ordering direct through HYST.</p>
                    </div>
                </div>

                <div style="margin-top: 35px;">
                    <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-users"></i> Order Squad Feast on HYST
                    </a>
                </div>
            </div>

            <!-- 4 Gen Z / Youth Foodie Image Grid -->
            <div class="genz-gallery-wrapper">
                <div class="genz-floating-tag">
                    <i class="fa-solid fa-fire"></i> Youth Foodie Hub
                </div>
                <div class="genz-image-grid">
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=600&q=80" alt="Youth Friends Having Fun Over Tea">
                        <div class="img-overlay"><i class="fa-solid fa-heart"></i> Squad Hangout</div>
                    </div>
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=80" alt="Gen Z Friends Enjoying Street Food">
                        <div class="img-overlay"><i class="fa-solid fa-utensils"></i> Foodie Vibe</div>
                    </div>
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=600&q=80" alt="Friends Cheering Tea Cups">
                        <div class="img-overlay"><i class="fa-solid fa-mug-hot"></i> Chai Time</div>
                    </div>
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1578474846511-04ba529f0b88?auto=format&fit=crop&w=600&q=80" alt="Group Share Street Snacks">
                        <div class="img-overlay"><i class="fa-solid fa-user-group"></i> Great Gossip</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: SIGNATURE MENU HIGHLIGHTS -->
    <section class="menu-section" id="menu">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-star"></i> Street Canteen Favorites</span>
                <h2 class="section-title" style="color:var(--text-light-theme);">Chai Par Charcha <span class="highlight-saffron">Signature Delights</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-light-muted);">Explore our top-selling street treats, brewed hot and fried crisp on order.</p>
            </div>

            <div class="menu-grid">
                <!-- Item 1 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">House Special</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTok4D8-RwLmVShvLeztViMYh8aUZStmuyUVxb6LeozBg&s=10" alt="Desi Kulhad Masala Chai">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Desi Kulhad Masala Chai</h3>
                                <span class="menu-price">£3.50</span>
                            </div>
                            <p class="menu-desc">Slow-boiled black tea with whole cardamom, ginger, crushed lemongrass, served in authentic unglazed clay kulhad.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Sizzling Hot</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSUbaLGygvm_oeKgiXLt--6vwdrGWKeCPWSef2GxZ5Vog&s" alt="Amritsari Aloo Cheese Paratha">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Amritsari Stuffed Paratha</h3>
                                <span class="menu-price">£6.95</span>
                            </div>
                            <p class="menu-desc">Hand-rolled whole wheat paratha packed with spiced potato & cheese, served with white butter, pickle & curd.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Street Chaat</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBxGCMQlfjVkNZGoXZ8iUXSqD2Cn8fGbSgqfMW0HXFIg&s=10" alt="Loaded Samosa Chaat">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Loaded Samosa Chaat</h3>
                                <span class="menu-price">£5.95</span>
                            </div>
                            <p class="menu-desc">Crushed potato samosas topped with tangy chickpea curry, sweetened yogurt, tamarind chutney, and crisp sev.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Irani Classic</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9R5VqgoZ9sBcQfFwfQ9pCkv4zlr6LCNsJjJiS2GoJyw&s=10" alt="Bun Maska with Sweet Chai">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Classic Bun Maska</h3>
                                <span class="menu-price">£3.95</span>
                            </div>
                            <p class="menu-desc">Warm toasted sweet bun slathered with rich salted butter, topped with Tutti Frutti, perfect for dipping in chai.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>
            </div>

            <div class="cta-row-center">
                <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-utensils"></i> View Complete Menu & Order on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 5: SAVINGS CALCULATOR -->
    <section class="calculator-section" id="calculator">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-calculator"></i> Smart Price Protection</span>
                <h2 class="section-title">See How Much You Save <span class="highlight-gold">By Ordering Direct</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-dark-muted);">Delivery apps secretly mark up food prices up to 25% and charge heavy service fees. Calculate your direct HYST savings below!</p>
            </div>

            <div class="calc-box">
                <div class="calc-controls">
                    <div class="control-group">
                        <label>Group / Squad Size: <span id="peopleCountText" style="color:var(--chai-gold);">3 People</span></label>
                        <input type="range" min="1" max="10" value="3" class="calc-slider" id="peopleSlider">
                    </div>

                    <div class="control-group">
                        <label>Snack / Charcha Scale</label>
                        <select class="vibe-select" id="vibeSelect">
                            <option value="light">Light Snack (Chai + Bun Maska)</option>
                            <option value="medium" selected>Standard Combo (Chai + Paratha + Samosa)</option>
                            <option value="heavy">Mega Squad Feast (Chai + Platters + Chaat + Desserts)</option>
                        </select>
                    </div>
                </div>

                <div class="calc-comparison-grid">
                    <div class="calc-card-other">
                        <div class="price-label">Third-Party Apps</div>
                        <div class="price-value-other" id="otherPrice">£38.50</div>
                        <p style="font-size:0.82rem; color:#ef4444; margin-top:10px;">Includes 20% menu markup + £2.99 service fee + £3.49 delivery</p>
                    </div>

                    <div class="calc-card-hyst">
                        <span class="savings-badge" id="savingsBadge">SAVE £11.00</span>
                        <div class="price-label">HYST Direct Price</div>
                        <div class="price-value-hyst" id="hystPrice">£27.50</div>
                        <p style="font-size:0.88rem; color:#10b981; margin-top:10px; font-weight:700;">Original kitchen menu price with zero inflated markups!</p>
                    </div>
                </div>

                <div class="cta-row-center">
                    <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-piggy-bank"></i> Lock In Direct Price - Order on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: COMPARISON TABLE -->
    <section class="compare-section" id="compare">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-code-compare"></i> Transparent Dining Choice</span>
                <h2 class="section-title" style="color:var(--text-light-theme);">HYST Direct Order vs <span class="highlight-saffron">Delivery Apps</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-light-muted);">Compare why smart chai lovers choose ordering direct through HYST instead of third-party delivery apps.</p>
            </div>

            <div class="table-wrapper">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th>Feature / Perk</th>
                            <th class="brand-col"><i class="fa-solid fa-shield-halved"></i> HYST Direct Order</th>
                            <th>Third-Party Delivery Apps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Menu Price Markup</strong></td>
                            <td>0% Markup (Guaranteed Kitchen Price) <i class="fa-solid fa-check-circle"></i></td>
                            <td>15% to 25% Higher Prices <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Hidden Service Charges</strong></td>
                            <td>Zero Added Platform Service Fees <i class="fa-solid fa-check-circle"></i></td>
                            <td>Mandatory Service & Small Order Fees <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Exclusive Chai & Paratha Combos</strong></td>
                            <td>Access to Full Canteen Deals <i class="fa-solid fa-check-circle"></i></td>
                            <td>Limited Standard Menu Items <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Tea Temperature & Packaging</strong></td>
                            <td>Dispatched Immediately in Thermal Flasks <i class="fa-solid fa-check-circle"></i></td>
                            <td>Delayed Delivery Stops <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Direct Restaurant Support</strong></td>
                            <td>100% Payment Reaches Our Kitchen <i class="fa-solid fa-check-circle"></i></td>
                            <td>High App Commission Cuts <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cta-row-center">
                <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-bolt"></i> Order Direct & Save Big on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 7: FAQS (10 ITEMS WITH ACCORDION & STICKY SIDE IMAGE) -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-circle-question"></i> Help & Questions</span>
                <h2 class="section-title">Frequently Asked <span class="highlight-gold">Questions</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-dark-muted);">Everything you need to know about our chai brewing, street food menu, dietary preferences, and HYST direct ordering.</p>
            </div>

            <div class="faq-layout">
                <!-- STICKY LEFT SIDE IMAGE -->
                <div class="faq-image-wrapper">
                    <div class="faq-image-container">
                        <img src="https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=800&q=80" alt="Chai Par Charcha Fresh Kulhad Tea">
                        <div class="faq-image-badge">
                            <i class="fa-solid fa-headset"></i>
                            <div>
                                <h5>Need Quick Help?</h5>
                                <p>Order direct on HYST for live order updates!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE FAQ ACCORDION (10 FAQS) -->
                <div class="faq-grid">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>1. What makes Chai Par Charcha's tea special?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Our chai is brewed fresh in small batches using high-grade Assam tea leaves, freshly crushed ginger, green cardamom, and cloves. We boil it in traditional kettles and serve in unglazed clay kulhads for an authentic Indian roadside taste.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>2. Why is ordering directly on HYST cheaper than UberEats or Deliveroo?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Third-party delivery apps charge heavy commissions (often 20% to 30%), forcing restaurants to inflate food menu prices. When you order via HYST, you get our original in-cafe prices with zero app markups or extra platform fees.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>3. How do I place an order on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Click any "Order Direct on HYST" button on this page or visit <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" style="color:var(--chai-gold); text-decoration:underline;">our official HYST ordering link</a> to add your items, select delivery or pickup, and complete checkout.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>4. Does tea stay piping hot during delivery?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! We pack all direct HYST tea orders in specialized insulated thermal flasks and spill-proof clay containers to ensure your chai arrives steaming hot.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>5. Are vegetarian, vegan, and Halal options available?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! Most of our snacks, samosas, pakoras, and parathas are 100% vegetarian. We also offer vegan tea options with oat/almond milk and certified Halal meat rolls.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>6. Can I customize sweet levels and spices in my chai?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Absolutely! You can choose your preferred sweetness level (No Sugar, Medium Sugar, Extra Sweet) and spice profile (Extra Ginger, Cardamom Only, Sugar-Free Jaggery) on HYST checkout.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>7. What food pairs best with Masala Chai?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Our top recommended pairings are Bun Maska, Amritsari Stuffed Aloo Paratha, Crispy Samosa Chaat, and Spicy Vada Pav.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>8. Do you cater for office chai breaks, meetings, and group events?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, we offer bulk chai flasks and snack platters for office meetings, birthday parties, and squad get-togethers. You can order party bundles directly on HYST.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>9. Can I pre-order my chai and breakfast for a specific time?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, our HYST portal features scheduled ordering so you can pick your exact pickup or delivery time in advance.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>10. Are there special discounts for ordering direct on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! Besides saving up to 10% on base menu prices compared to third-party apps, direct HYST orders frequently receive exclusive combo offers and loyalty perks.
                        </div>
                    </div>

                    <div style="margin-top: 25px;">
                        <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-mug-hot"></i> Ready For Chai? Order Direct on HYST
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
                    <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" class="logo">
                        <i class="fa-solid fa-mug-hot"></i> CHAI PAR CHARCHA
                    </a>
                    <p>Authentic Indian Kulhad Masala Chai, hand-rolled stuffed parathas, crisp street snacks, and bun maska. Order direct on HYST for guaranteed lowest menu prices!</p>
                </div>

                <div class="footer-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#about">Our Story</a></li>
                        <li><a href="#squad">Chai & Charcha Squad</a></li>
                        <li><a href="#menu">Menu Highlights</a></li>
                        <li><a href="#calculator">Savings Calc</a></li>
                        <li><a href="#compare">HYST vs Apps</a></li>
                        <li><a href="#faq">FAQs</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Direct Order</h4>
                    <ul>
                        <li><a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank">Desi Kulhad Chai</a></li>
                        <li><a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank">Amritsari Parathas</a></li>
                        <li><a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank">Loaded Samosa Chaat</a></li>
                        <li><a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank">Bun Maska & Snacks</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Save On Delivery</h4>
                    <p style="color: var(--text-dark-muted); margin-bottom: 15px; font-size: 0.92rem;">Order on HYST to avoid app commission markups!</p>
                    <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" class="btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-bag-shopping"></i> Order Direct on HYST
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Chai Par Charcha. Powered by <a href="https://hyst.uk/restaurant/chai-par-charcha-1780510502" target="_blank" style="color:var(--chai-gold);">HYST Direct Ordering System</a>.</p>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT -->
    <script>
        // 1. Mobile Navigation Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            if(navMenu.classList.contains('active')) {
                icon.className = 'fa-solid fa-xmark';
            } else {
                icon.className = 'fa-solid fa-bars';
            }
        });

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                menuToggle.querySelector('i').className = 'fa-solid fa-bars';
            });
        });

        // 2. Interactive HYST Savings Calculator Logic
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

            let basePricePerPerson = 6.5;
            if (vibe === 'medium') basePricePerPerson = 9.0;
            if (vibe === 'heavy') basePricePerPerson = 13.5;

            const hystTotal = (people * basePricePerPerson).toFixed(2);
            const otherTotal = ((people * basePricePerPerson * 1.22) + 2.99 + 3.49).toFixed(2);
            const savings = (otherTotal - hystTotal).toFixed(2);

            hystPrice.textContent = `£${hystTotal}`;
            otherPrice.textContent = `£${otherTotal}`;
            savingsBadge.textContent = `SAVE £${savings}`;
        }

        peopleSlider.addEventListener('input', updateSavings);
        vibeSelect.addEventListener('change', updateSavings);

        // 3. FAQ Accordion Click Logic
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const item = q.parentElement;
                item.classList.toggle('active');
            });
        });
    </script>
</body>
</html>