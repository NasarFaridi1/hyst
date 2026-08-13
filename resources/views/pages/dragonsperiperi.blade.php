<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dragon's Peri Peri | Flame-Grilled Peri Peri Chicken & Gourmet Burgers | Order Direct on HYST</title>

    <!-- Meta Tags for SEO, AEO & GEO -->
    <meta name="description"
        content="Feast on authentic flame-grilled Peri Peri chicken, succulent smash burgers, sizzling Peri wings & loaded chips at Dragon's Peri Peri. Order direct on HYST to save up to 25% with zero delivery app markups!">
    <meta name="keywords"
        content="Dragon's Peri Peri, Dragon's Peri Peri HYST, Flame Grilled Chicken, Peri Peri Wings, Halal Peri Peri UK, Order Direct HYST, Peri Peri Burgers, Squad Platters">
    <meta name="robots" content="index, follow">

    <!-- Open Graph & Social Meta -->
    <meta property="og:title" content="Dragon's Peri Peri | Flame-Grilled Spice & Gourmet Eats | Order Direct on HYST">
    <meta property="og:description"
        content="Bold flame-grilled Peri Peri flavors marinated for 24 hours. Order directly on HYST for guaranteed lowest menu prices and zero app commissions!">
    <meta property="og:type" content="restaurant">
    <meta property="og:url" content="https://hyst.uk/restaurant/dragons-peri-peri">
    <meta property="og:image"
        content="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&w=1200&q=80">

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
      "@type": "Restaurant",
      "name": "Dragon's Peri Peri",
      "image": "https://images.unsplash.com/photo-1598515214211-89d3c73ae83b",
      "url": "https://hyst.uk/restaurant/dragons-peri-peri",
      "telephone": "+441234567890",
      "priceRange": "££",
      "menu": "https://hyst.uk/restaurant/dragons-peri-peri",
      "servesCuisine": ["Peri Peri Chicken", "Flame-Grilled", "Gourmet Burgers", "Loaded Chips", "Halal"],
      "acceptsReservations": "True",
      "hasMenu": "https://hyst.uk/restaurant/dragons-peri-peri"
    }
    </script>

    <style>
        /* ==========================================================================
           DRAGON'S PERI PERI BRAND COLOR SYSTEM (MATCHING DRAGONSPERIPERI.CO.UK)
           ========================================================================== */
        :root {
            /* Base Light Backgrounds */
            --bg-main: #FFFBF7;
            /* Soft Fiery Warm Cream */
            --bg-card: #FFFFFF;
            /* Pure White Surface */
            --bg-accent-soft: #FFF2E6;
            /* Light Flame Orange Tint */
            --border-soft: #F3E0D0;
            /* Subtle Border Line */

            /* Dragon's Brand Colors */
            --brand-red: #C8102E;
            /* Dragon Flame Crimson Red */
            --brand-red-hover: #A00C23;
            --brand-orange: #FF6B00;
            /* Sizzling Peri Peri Orange */
            --brand-gold: #FFB800;
            /* Char Gold Highlight */
            --brand-dark: #121212;
            /* Deep Charcoal Header/Footer */
            --brand-dark-surface: #1E1E1E;

            /* Contrast Typography */
            --text-primary: #1C1917;
            /* Dark Charcoal Body Text */
            --text-muted: #57534E;
            /* Earthy Grey Subtext */
            --text-light: #FFFBF7;
            /* Off-white Text */

            --font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
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
            font-family: var(--font-family);
            line-height: 1.7;
            background-color: var(--bg-main);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
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

        /* Standard Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--brand-red) 0%, var(--brand-orange) 100%);
            color: #ffffff !important;
            font-weight: 800;
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--brand-gold);
            box-shadow: 0 10px 25px rgba(200, 16, 46, 0.3);
            transition: var(--transition);
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.88rem;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(200, 16, 46, 0.45);
            background: linear-gradient(135deg, var(--brand-orange) 0%, var(--brand-red) 100%);
        }

        .btn-secondary {
            background: #ffffff;
            border: 2px solid var(--brand-red);
            color: var(--brand-red);
            font-weight: 800;
            padding: 14px 28px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 0.88rem;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .btn-secondary:hover {
            background: var(--brand-red);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .section-tag {
            color: var(--brand-red);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 2px;
            display: inline-block;
            margin-bottom: 12px;
            background: var(--bg-accent-soft);
            padding: 6px 16px;
            border-radius: 30px;
            border: 1px solid var(--border-soft);
        }

        .section-title {
            font-size: clamp(2.2rem, 4.5vw, 3.4rem);
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .section-desc {
            max-width: 820px;
            font-size: 1.08rem;
            margin-bottom: 35px;
            line-height: 1.8;
            color: var(--text-muted);
        }

        .highlight-red {
            color: var(--brand-red);
        }

        .highlight-orange {
            color: var(--brand-orange);
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
            background: var(--brand-dark);
            border-bottom: 2px solid var(--brand-orange);
            padding: 14px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .logo {
            font-size: 1.35rem;
            font-weight: 900;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .logo i {
            color: var(--brand-orange);
            font-size: 1.5rem;
        }

        .nav-menu {
            display: flex;
            align-items: center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
            list-style: none;
        }

        .nav-links a {
            font-weight: 700;
            font-size: 0.88rem;
            color: #E5E5E5;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--brand-orange);
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
            color: var(--brand-orange);
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
                background: var(--brand-dark);
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                padding: 40px 20px;
                gap: 25px;
                transition: var(--transition);
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
           SECTION 1: HERO SECTION
           ========================================================================== */
        .hero {
            padding: 160px 0 90px;
            background: linear-gradient(135deg, #FFFBF7 0%, #FFEEDD 100%);
            border-bottom: 1px solid var(--border-soft);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 50px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: clamp(2.4rem, 5vw, 4rem);
            line-height: 1.12;
            margin-bottom: 22px;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: var(--text-muted);
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
            background: #ffffff;
            border: 1px solid var(--border-soft);
            padding: 12px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .badge-item i {
            color: var(--brand-red);
            font-size: 1.1rem;
        }

        .badge-item span {
            font-size: 0.88rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        .hero-img-box {
            background: #ffffff;
            border: 2px solid var(--border-soft);
            border-radius: 28px;
            padding: 16px;
            box-shadow: 0 20px 40px rgba(200, 16, 46, 0.1);
        }

        .hero-img-box img {
            width: 100%;
            height: 460px;
            border-radius: 20px;
            object-fit: cover;
        }

        /* ==========================================================================
           SECTION 2: ABOUT US / BRAND STORY
           ========================================================================== */
        .about-section {
            padding: 100px 0;
            background: #ffffff;
            border-bottom: 1px solid var(--border-soft);
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
            border: 1px solid var(--border-soft);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.07);
        }

        .about-experience-badge {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: var(--brand-dark);
            color: #ffffff;
            padding: 20px 28px;
            border-radius: 20px;
            border: 2px solid var(--brand-orange);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
            text-align: center;
        }

        .about-experience-badge .num {
            font-size: 2.2rem;
            font-weight: 900;
            line-height: 1;
            color: var(--brand-orange);
        }

        .about-experience-badge .txt {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .about-feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 30px 0;
        }

        .about-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .about-feature-item i {
            color: var(--brand-orange);
            font-size: 1.25rem;
            margin-top: 3px;
        }

        .about-feature-item h4 {
            font-size: 1rem;
            margin-bottom: 2px;
        }

        .about-feature-item p {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* ==========================================================================
           SECTION 3: GEN Z & SQUAD SECTION
           ========================================================================== */
        .genz-section {
            padding: 100px 0;
            background: var(--bg-accent-soft);
            border-bottom: 1px solid var(--border-soft);
        }

        .genz-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .genz-cards-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .genz-mini-card {
            background: #ffffff;
            border: 1px solid var(--border-soft);
            padding: 22px;
            border-radius: 18px;
            transition: var(--transition);
        }

        .genz-mini-card:hover {
            border-color: var(--brand-orange);
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(255, 107, 0, 0.12);
        }

        .genz-mini-card i {
            font-size: 1.8rem;
            color: var(--brand-red);
            margin-bottom: 10px;
        }

        .genz-mini-card h4 {
            font-size: 1.05rem;
            margin-bottom: 6px;
        }

        .genz-mini-card p {
            font-size: 0.88rem;
            color: var(--text-muted);
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
            background: var(--brand-red);
            color: #ffffff;
            font-weight: 800;
            padding: 10px 22px;
            border-radius: 30px;
            font-size: 0.82rem;
            box-shadow: 0 8px 20px rgba(200, 16, 46, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid var(--brand-gold);
        }

        .genz-image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            background: #ffffff;
            padding: 16px;
            border-radius: 28px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        }

        .genz-img-card {
            position: relative;
            height: 220px;
            border-radius: 18px;
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
            transform: scale(1.08);
        }

        .genz-img-card .img-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 12px 14px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.88), transparent);
            color: var(--brand-gold);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ==========================================================================
           SECTION 4: SIGNATURE PERI PERI MENU HIGHLIGHTS
           ========================================================================== */
        .menu-section {
            padding: 100px 0;
            background: #ffffff;
            border-bottom: 1px solid var(--border-soft);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 28px;
            margin-top: 45px;
        }

        .menu-card {
            background: var(--bg-main);
            border: 1px solid var(--border-soft);
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            border-color: var(--brand-orange);
            box-shadow: 0 15px 35px rgba(255, 107, 0, 0.12);
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
            background: var(--brand-dark);
            border: 1px solid var(--brand-orange);
            color: var(--brand-orange);
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
            font-size: 1.18rem;
        }

        .menu-price {
            font-size: 1.25rem;
            color: var(--brand-red);
            font-weight: 900;
        }

        .menu-desc {
            color: var(--text-muted);
            font-size: 0.88rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        /* ==========================================================================
           SECTION 5: SAVINGS CALCULATOR
           ========================================================================== */
        .calculator-section {
            padding: 100px 0;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border-soft);
        }

        .calc-box {
            background: #ffffff;
            border: 2px solid var(--border-soft);
            border-radius: 24px;
            padding: 40px;
            max-width: 950px;
            margin: 0 auto;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
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
            color: var(--brand-red);
        }

        .calc-slider {
            width: 100%;
            accent-color: var(--brand-orange);
            height: 8px;
            background: var(--border-soft);
            border-radius: 5px;
            outline: none;
            cursor: pointer;
        }

        .vibe-select {
            width: 100%;
            padding: 14px;
            background: var(--bg-main);
            border: 1px solid var(--border-soft);
            color: var(--text-primary);
            border-radius: 12px;
            font-family: var(--font-family);
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
            background: rgba(239, 68, 68, 0.06);
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
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .price-value-other {
            font-size: 2.2rem;
            font-weight: 900;
            color: #ef4444;
            text-decoration: line-through;
        }

        .price-value-hyst {
            font-size: 2.5rem;
            font-weight: 900;
            color: #10b981;
        }

        /* ==========================================================================
           SECTION 6: COMPARISON TABLE
           ========================================================================== */
        .compare-section {
            padding: 100px 0;
            background: #ffffff;
            border-bottom: 1px solid var(--border-soft);
        }

        .table-wrapper {
            overflow-x: auto;
            margin-top: 40px;
        }

        .compare-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--border-soft);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        .compare-table th,
        .compare-table td {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-soft);
        }

        .compare-table th {
            background: var(--bg-accent-soft);
            font-size: 1.05rem;
            text-transform: uppercase;
        }

        .compare-table th.brand-col {
            color: #ffffff;
            background: var(--brand-red);
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
           SECTION 7: FAQS ACCORDION (10 FAQS)
           ========================================================================== */
        .faq-section {
            padding: 100px 0;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border-soft);
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
            background: #ffffff;
            padding: 12px;
            border-radius: 22px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
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
            background: rgba(18, 18, 18, 0.92);
            backdrop-filter: blur(10px);
            border: 1px solid var(--brand-orange);
            color: #ffffff;
            padding: 16px 18px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .faq-image-badge i {
            font-size: 1.8rem;
            color: var(--brand-orange);
        }

        .faq-image-badge h5 {
            font-size: 0.95rem;
            color: var(--brand-orange);
            margin-bottom: 2px;
        }

        .faq-image-badge p {
            font-size: 0.82rem;
            color: #D5D5D5;
            margin: 0;
        }

        .faq-grid {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .faq-item {
            background: #ffffff;
            border: 1px solid var(--border-soft);
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
        }

        .faq-question i {
            color: var(--brand-red);
            transition: var(--transition);
        }

        .faq-answer {
            padding: 0 24px 20px;
            color: var(--text-muted);
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
            background: var(--brand-dark);
            color: #FFFBF7;
            padding: 75px 0 30px;
            border-top: 2px solid var(--brand-orange);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-brand p {
            color: #A3A3A3;
            margin-top: 16px;
            font-size: 0.92rem;
            line-height: 1.7;
        }

        .footer-col h4 {
            font-size: 1.08rem;
            margin-bottom: 20px;
            color: var(--brand-orange);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: #D5D5D5;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: var(--brand-orange);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #282828;
            color: #A3A3A3;
            font-size: 0.88rem;
        }

        @media (max-width: 991px) {

            .hero-grid,
            .about-grid,
            .genz-grid,
            .calc-controls,
            .calc-comparison-grid,
            .footer-grid,
            .faq-layout {
                grid-template-columns: 1fr;
            }

            .faq-image-wrapper {
                position: relative;
                top: 0;
            }

            .genz-cards-container,
            .about-feature-list {
                grid-template-columns: 1fr;
            }

            .hero {
                padding-top: 130px;
            }

            .about-image-wrapper img,
            .hero-img-box img {
                height: 360px;
            }

            .genz-img-card {
                height: 180px;
            }
        }

        /* Mobile Screen Fix for Savings Calculator Box & Button */
        @media (max-width: 576px) {
            .calc-box {
                padding: 24px 16px;
            }

            .calculator-section .btn-primary {
                font-size: 0.78rem;
                padding: 12px 18px;
                white-space: normal;
                text-align: center;
                width: 100%;
                justify-content: center;
                line-height: 1.4;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER / NAVIGATION -->
    <header>
        <div class="container nav-container">
            <a href="https://hyst.uk/restaurant/dragons-peri-peri" class="logo">
                <i class="fa-solid fa-fire"></i> DRAGON'S PERI PERI
            </a>

            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="#about">Flame Craft</a></li>
                    <li><a href="#squad">Squad Vibe</a></li>
                    <li><a href="#menu">Menu Highlights</a></li>
                    <li><a href="#calculator">Savings Calc</a></li>
                    <li><a href="#compare">HYST vs Apps</a></li>
                    <li><a href="#faq">FAQs</a></li>
                </ul>

                <div class="mobile-hyst-btn">
                    <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-bag-shopping"></i> Order Direct on HYST
                    </a>
                </div>
            </div>

            <div class="header-actions">
                <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-bag-shopping"></i> Order Direct
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
                <span class="section-tag"><i class="fa-solid fa-fire-flame-curved"></i> 24-Hour Marinated Flame-Grilled
                    Perfection</span>
                <h1>Ignite Your Tastebuds With <span class="highlight-red">Dragon’s Peri Peri</span> Magic</h1>
                <p>Welcome to Dragon's Peri Peri — the ultimate home of succulent, 24-hour marinated flame-grilled Peri
                    Peri chicken, spicy smash burgers, sizzling wings, and loaded Peri chips! From Lemon & Herb mildness
                    to Extra Fiery Extra Hot, experience authentic Portuguese-African fiery spice craft. Skip unfair
                    delivery app price markups — order directly on HYST for guaranteed original menu prices and instant
                    savings!</p>

                <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                    <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-fire"></i> Order Direct on HYST
                    </a>
                    <a href="#calculator" class="btn-secondary">
                        <i class="fa-solid fa-calculator"></i> Compare App Prices
                    </a>
                </div>

                <div class="hero-badges">
                    <div class="badge-item">
                        <i class="fa-solid fa-drumstick-bite"></i>
                        <span>100% Fresh Halal Chicken</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-percent"></i>
                        <span>Zero App Commission Fees</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Express Grill Dispatch</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-img-box">
                    <img src="https://dragonsperiperi.co.uk/wp-content/uploads/2026/03/QUALITY-YOU-CAN-TASTE-1536x886.jpg"
                        alt="Flame Grilled Dragon's Peri Peri Chicken Platter">
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section class="about-section" id="about">
        <div class="container about-grid">
            <div class="about-image-wrapper">
                <img src="https://images.unsplash.com/photo-1532550907401-a500c9a57435?auto=format&fit=crop&w=900&q=80"
                    alt="Grill Master preparing Peri Peri Wings">
                <div class="about-experience-badge">
                    <div class="num">100%</div>
                    <div class="txt">Fiery Taste</div>
                </div>
            </div>

            <div class="about-content">
                <span class="section-tag"><i class="fa-solid fa-pepper-hot"></i> Our Flame Heritage</span>
                <h2 class="section-title">24-Hour Marination & <span class="highlight-red">Open Flame Roasting</span>
                </h2>
                <p>At Dragon's Peri Peri, we take our spice craft seriously. Every single chicken cut is hand-marinated
                    for a full 24 hours in our secret blend of crushed African bird's eye chillies, sun-ripened lemons,
                    garlic, and Mediterranean herbs. We then flame-grill it fresh to order on open char-broilers to seal
                    in maximum moisture and caramelize the spicy glaze.</p>
                <p>Whether you prefer a gentle Lemon & Herb zing or an explosive Extra Hot punch, our kitchen serves up
                    uncompromising bold flavor. When you order direct through HYST, you support our local kitchen team
                    directly while saving up to 25% compared to third-party food delivery apps!</p>

                <div class="about-feature-list">
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>24-Hr Herb & Spice Infusion</h4>
                            <p>Deep flavor penetration ensuring juicy meat in every single bite.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>5 Spice Intensity Levels</h4>
                            <p>From Lemon & Herb, Mild, Medium, Hot to Extra Hot Dragon Fire.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>100% Halal Certified Meats</h4>
                            <p>Freshly sourced UK halal chicken grilled with zero artificial additives.</p>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>HYST Wallet Protection</h4>
                            <p>Direct ordering eliminates inflated service fees & commission markups.</p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-book-open"></i> Explore Menu & Order Direct on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- GEN Z & SQUAD SECTION -->
    <section class="genz-section" id="squad">
        <div class="container genz-grid">
            <div class="genz-content">
                <span class="section-tag"><i class="fa-solid fa-users"></i> Squad Hangout & Match Day Feasts</span>
                <h2 class="section-title">Built For <span class="highlight-red">Late-Night Squad Hangouts</span> & Game
                    Nights</h2>
                <p>Whether you're gearing up for a FIFA/CoD gaming marathon with the mates, hosting a Premier League
                    watch party, or craving late-night indulgent Peri Peri platters after a long week, Dragon's Peri
                    Peri is built for youth foodies who love big portions and bold heat.</p>
                <p>Load up on our famous Dragon Squad Sharing Platters, flame-grilled wings, Peri-dusted chips, and
                    fiery gourmet burgers. Skip the hassle of inflated menu prices on third-party apps! Ordering direct
                    on HYST ensures your group gets maximum food for your wallet.</p>

                <div class="genz-cards-container">
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-drumstick-bite"></i>
                        <h4>Dragon Platter Combos</h4>
                        <p>2 Whole Chickens, 12 Wings, 4 Regular Sides & 1.5L Drink for the team.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-burger"></i>
                        <h4>Double Peri Smash Burgers</h4>
                        <p>Flame-grilled Peri chicken breast & smashed beef layered with cheese & garlic mayo.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-fire-burner"></i>
                        <h4>Fiery Loaded Peri Chips</h4>
                        <p>Golden skin-on chips dusted in spicy Peri salt, drizzled with liquid cheddar.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <h4>Zero App Markups</h4>
                        <p>Save money on every group order by ordering directly through HYST.</p>
                    </div>
                </div>

                <div style="margin-top: 35px;">
                    <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-users"></i> Order Squad Feast on HYST
                    </a>
                </div>
            </div>

            <!-- Active British Youth Foodie Gallery -->
            <div class="genz-gallery-wrapper">
                <div class="genz-floating-tag">
                    <i class="fa-solid fa-fire"></i> Squad Foodie Hub
                </div>
                <div class="genz-image-grid">
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=600&q=80"
                            alt="British Youth Squad Cheering with Peri Peri Chicken">
                        <div class="img-overlay"><i class="fa-solid fa-heart"></i> Squad Platter Vibe</div>
                    </div>
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80"
                            alt="Young British Friends Dining Together">
                        <div class="img-overlay"><i class="fa-solid fa-users"></i> Match Day Feast</div>
                    </div>
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1543007630-9710e4a00a20?auto=format&fit=crop&w=600&q=80"
                            alt="Gen Z Foodies Enjoying Peri Burgers">
                        <div class="img-overlay"><i class="fa-solid fa-burger"></i> Peri Smash Craze</div>
                    </div>
                    <div class="genz-img-card">
                        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=600&q=80"
                            alt="Friends Laughing over Late Night Food">
                        <div class="img-overlay"><i class="fa-solid fa-fire"></i> Flame Squad</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SIGNATURE MENU HIGHLIGHTS -->
    <section class="menu-section" id="menu">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-star"></i> Crowd Favorites</span>
                <h2 class="section-title">Dragon’s Peri Peri <span class="highlight-red">Signatures</span></h2>
                <p class="section-desc" style="margin: 0 auto;">Hand-marinated flame-grilled chickens, sizzling wings,
                    smash burgers, and loaded sides hot off the char-broiler.</p>
            </div>

            <div class="menu-grid">
                <!-- Item 1 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">#1 Bestseller</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSZJtZM9VP6TKTctb5ONXeVfes7TQc48l4lElnvqSkN7g&s=10"
                            alt="Whole Flame-Grilled Peri Peri Chicken">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Full Flame-Grilled Chicken</h3>
                                <span class="menu-price">£13.95</span>
                            </div>
                            <p class="menu-desc">24-hr marinated fresh chicken flame-grilled to sizzling perfection.
                                Basted in your choice of Lemon & Herb, Mild, Medium, Hot, or Extra Hot Dragon Baste.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary"
                            style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">House Special</span>
                        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=600&q=80"
                            alt="Dragon Peri Smash Burger">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Dragon Peri Smash Burger</h3>
                                <span class="menu-price">£8.95</span>
                            </div>
                            <p class="menu-desc">Flame-grilled tender Peri Peri chicken breast topped with melted
                                Monterey Jack cheese, spicy Peri mayo, crisp lettuce, and jalapenos on a toasted brioche
                                bun.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary"
                            style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Sizzling Wings</span>
                        <img src="https://images.unsplash.com/photo-1527477396000-e27163b481c2?auto=format&fit=crop&w=600&q=80"
                            alt="Flame-Grilled Peri Peri Wings">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Flame Peri Wings (6 Pcs)</h3>
                                <span class="menu-price">£7.95</span>
                            </div>
                            <p class="menu-desc">Juicy jumbo chicken wings flame-broiled and generously glazed with your
                                favorite Peri Peri marinade. Served with cool garlic dip.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary"
                            style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="dish-badge">Ultimate Side</span>
                        <img src="https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&fit=crop&w=600&q=80"
                            alt="Loaded Dragon Peri Chips">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Loaded Dragon Peri Chips</h3>
                                <span class="menu-price">£5.95</span>
                            </div>
                            <p class="menu-desc">Golden crisp skin-on chips tossed in intense Peri Peri seasoning,
                                smothered in warm liquid cheddar cheese and chopped grilled Peri chicken bits.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary"
                            style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>
            </div>

            <div class="cta-row-center">
                <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-fire"></i> View Full Menu & Order Direct on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- SAVINGS CALCULATOR -->
    <section class="calculator-section" id="calculator">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-calculator"></i> Smart Price Protection</span>
                <h2 class="section-title">Calculate Your Savings <span class="highlight-red">By Ordering Direct</span>
                </h2>
                <p class="section-desc" style="margin: 0 auto;">Third-party delivery apps add hidden platform fees and
                    charge up to 25% higher menu prices. See how much you save when you order directly through HYST!</p>
            </div>

            <div class="calc-box">
                <div class="calc-controls">
                    <div class="control-group">
                        <label>Squad Group Size: <span id="peopleCountText" style="color:var(--brand-red);">3
                                People</span></label>
                        <input type="range" min="1" max="10" value="3" class="calc-slider" id="peopleSlider">
                    </div>

                    <div class="control-group">
                        <label>Feast Scale</label>
                        <select class="vibe-select" id="vibeSelect">
                            <option value="light">Solo Meal (1 Burger / Wrap + Side + Drink)</option>
                            <option value="medium" selected>Standard Combo (Half Chicken + Wings + Chips)</option>
                            <option value="heavy">Mega Squad Platter (Whole Chickens + Wings + Large Sides)</option>
                        </select>
                    </div>
                </div>

                <div class="calc-comparison-grid">
                    <div class="calc-card-other">
                        <div class="price-label">Third-Party Delivery Apps</div>
                        <div class="price-value-other" id="otherPrice">£45.20</div>
                        <p style="font-size:0.82rem; color:#ef4444; margin-top:10px;">Includes 20% menu markup + £3.49
                            service fee + £3.99 delivery</p>
                    </div>

                    <div class="calc-card-hyst">
                        <span class="savings-badge" id="savingsBadge">SAVE £12.20</span>
                        <div class="price-label">HYST Direct Price</div>
                        <div class="price-value-hyst" id="hystPrice">£33.00</div>
                        <p style="font-size:0.88rem; color:#10b981; margin-top:10px; font-weight:700;">Original kitchen
                            menu price with zero inflated markups!</p>
                    </div>
                </div>

                <div class="cta-row-center">
                    <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-piggy-bank"></i> Lock In Direct Price - Order on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPARISON TABLE -->
    <section class="compare-section" id="compare">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-code-compare"></i> Transparent Dining Choice</span>
                <h2 class="section-title">HYST Direct Order vs <span class="highlight-red">Delivery Apps</span></h2>
                <p class="section-desc" style="margin: 0 auto;">See why smart Peri Peri lovers order direct through HYST
                    instead of third-party platforms.</p>
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
                            <td><strong>Exclusive Squad Platters & Deals</strong></td>
                            <td>Access to Full Bundle Combos <i class="fa-solid fa-check-circle"></i></td>
                            <td>Limited Standard Menu Items <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Food Temperature & Freshness</strong></td>
                            <td>Dispatched Straight From Char-Grill <i class="fa-solid fa-check-circle"></i></td>
                            <td>Multiple Rider Stopovers <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Direct Local Business Support</strong></td>
                            <td>100% Payment Reaches Our Kitchen <i class="fa-solid fa-check-circle"></i></td>
                            <td>High App Commission Cuts <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cta-row-center">
                <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-bolt"></i> Order Direct & Save Big on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- FAQS SECTION (MINIMUM 10 FAQS) -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag"><i class="fa-solid fa-circle-question"></i> Help & Info</span>
                <h2 class="section-title">Frequently Asked <span class="highlight-red">Questions</span></h2>
                <p class="section-desc" style="margin: 0 auto;">Everything you need to know about Dragon's Peri Peri
                    menu, spice scale, halal status, and HYST ordering.</p>
            </div>

            <div class="faq-layout">
                <!-- STICKY LEFT SIDE IMAGE -->
                <div class="faq-image-wrapper">
                    <div class="faq-image-container">
                        <img src="https://dragonsperiperi.co.uk/wp-content/uploads/2025/02/Bringing-Bold-Flavours-to-Hounslow.jpg"
                            alt="Dragon's Peri Peri Flame Grilled Food">
                        <div class="faq-image-badge">
                            <i class="fa-solid fa-headset"></i>
                            <div>
                                <h5>Need Quick Help?</h5>
                                <p>Order direct on HYST for live order tracking!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE FAQ ACCORDION -->
                <div class="faq-grid">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>1. What makes Dragon’s Peri Peri chicken so unique?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Our chicken is marinated for 24 hours in authentic African bird's eye chillies, fresh lemon
                            juice, garlic, and Mediterranean herbs. It is then cooked over open flame char-broilers to
                            seal in maximum juices while creating crispy caramelized Peri Peri edges.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>2. Why should I order directly through HYST instead of Deliveroo or UberEats?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Third-party apps charge high commission fees (up to 30%), forcing menu prices up. When you
                            order on HYST, you get direct, guaranteed kitchen menu prices, saving up to 25% on every
                            order with zero platform service charges.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>3. What spice levels do you offer for Peri Peri chicken?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            We offer 5 distinct spice levels: Lemon & Herb (Citrusy & Mild), Mango & Lime (Sweet &
                            Zesty), Medium (Warm & Tangy), Hot (Fiery Kick), and Extra Hot Dragon Fire (For true chilli
                            thrill-seekers).
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>4. Is all food at Dragon’s Peri Peri 100% Halal certified?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! All chicken, beef patties, and sides served at Dragon's Peri Peri are 100% Halal
                            certified, sourced from trusted UK suppliers, and prepared under strict hygiene standards.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>5. How do I place an order on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Click any "Order Direct on HYST" button on this page or visit <a
                                href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank"
                                style="color:var(--brand-red); text-decoration:underline;">our official HYST store
                                link</a> to select items, customize spice levels, and check out securely.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>6. Do you have vegetarian or vegan options available?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! We serve grilled Paneer Peri Wraps, Veggie Gourmet Burgers, Halloumi Sticks, Spicy
                            Rice, Spicy Corn on the Cob, and Loaded Peri Chips suitable for vegetarians.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>7. Are there special group platters or squad deals available on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! We offer exclusive Dragon Family & Squad Platters (including multiple whole chickens,
                            wings, large sides, and 1.5L soft drinks) that are priced significantly cheaper on HYST
                            compared to third-party delivery apps.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>8. How fast is delivery when ordering direct on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Direct HYST orders are prioritized straight in our kitchen queue. As soon as the chicken
                            leaves the char-broiler, it is packed in insulated thermal bags for rapid, direct dispatch
                            to your door.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>9. Can I schedule an order in advance for a match day or event?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! The HYST platform allows you to select a future date and specific delivery/pickup time
                            so your group feast arrives right on time for kick-off or party time.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>10. Can I track my order status live on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! Once your order is placed on HYST, you receive real-time SMS updates from kitchen
                            preparation to courier dispatch and doorstep arrival.
                        </div>
                    </div>

                    <div style="margin-top: 25px;">
                        <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-fire"></i> Hungry Yet? Order Direct on HYST
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
                    <a href="https://hyst.uk/restaurant/dragons-peri-peri" class="logo">
                        <i class="fa-solid fa-fire"></i> DRAGON'S PERI PERI
                    </a>
                    <p>Authentic 24-hour marinated flame-grilled Peri Peri chicken, gourmet smash burgers, sizzling
                        wings, and loaded sides. Order direct on HYST for guaranteed lowest menu prices!</p>
                </div>

                <div class="footer-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#about">Flame Craft</a></li>
                        <li><a href="#squad">Squad Vibe</a></li>
                        <li><a href="#menu">Menu Highlights</a></li>
                        <li><a href="#calculator">Savings Calc</a></li>
                        <li><a href="#compare">HYST vs Apps</a></li>
                        <li><a href="#faq">FAQs</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Direct Menu</h4>
                    <ul>
                        <li><a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank">Flame-Grilled
                                Chicken</a></li>
                        <li><a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank">Peri Smash
                                Burgers</a></li>
                        <li><a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank">Sizzling Peri
                                Wings</a></li>
                        <li><a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank">Loaded Peri Chips</a>
                        </li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Save On Delivery</h4>
                    <p style="color: #A3A3A3; margin-bottom: 15px; font-size: 0.92rem;">Order on HYST to avoid
                        third-party markups!</p>
                    <a href="https://hyst.uk/restaurant/dragons-peri-peri" target="_blank" class="btn-primary"
                        style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-bag-shopping"></i> Order Direct on HYST
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Dragon's Peri Peri. Powered by <a href="https://hyst.uk/restaurant/dragons-peri-peri"
                        target="_blank" style="color:var(--brand-orange);">HYST Direct Ordering Portal</a>.</p>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT -->
    <script>
        // 1. Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            if (navMenu.classList.contains('active')) {
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

        // 2. Savings Calculator Logic
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

            let basePricePerPerson = 8.0;
            if (vibe === 'medium') basePricePerPerson = 11.0;
            if (vibe === 'heavy') basePricePerPerson = 15.0;

            const hystTotal = (people * basePricePerPerson).toFixed(2);
            const otherTotal = ((people * basePricePerPerson * 1.22) + 3.49 + 3.99).toFixed(2);
            const savings = (otherTotal - hystTotal).toFixed(2);

            hystPrice.textContent = `£${hystTotal}`;
            otherPrice.textContent = `£${otherTotal}`;
            savingsBadge.textContent = `SAVE £${savings}`;
        }

        peopleSlider.addEventListener('input', updateSavings);
        vibeSelect.addEventListener('change', updateSavings);

        // 3. FAQ Accordion Logic
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const item = q.parentElement;
                item.classList.toggle('active');
            });
        });
    </script>
</body>

</html>