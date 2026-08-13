<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Grill Newcastle | Flame-Grilled Peri Peri, Smashed Burgers & Squad Feasts | Order Direct on HYST</title>
    
    <!-- Meta Tags for SEO/AEO/GEO -->
    <meta name="description" content="Newcastle's top flame-grilled peri peri chicken, smashed burgers & squad platters. Order direct on HYST to save up to 25% compared to third-party delivery apps!">
    <meta name="keywords" content="Go Grill Newcastle, Peri Peri Chicken, Smashed Burgers Newcastle, Squad Platters, HYST Food Delivery, Best Food Newcastle">
    <meta name="robots" content="index, follow">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Schema.org JSON-LD for GEO/AEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Restaurant",
      "name": "Go Grill Newcastle",
      "image": "https://images.unsplash.com/photo-1555939594-58d7cb561ad1",
      "url": "https://hyst.uk/restaurant/go-grill-1780488145",
      "telephone": "+441910000000",
      "priceRange": "££",
      "menu": "https://hyst.uk/restaurant/go-grill-1780488145",
      "servesCuisine": ["Grill", "Peri Peri", "Burgers", "Kebabs", "Fast Food"],
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Newcastle upon Tyne",
        "addressCountry": "UK"
      }
    }
    </script>

    <style>
        /* ==========================================================================
           COLOR PALETTE: LIGHT & DARK CONTRAST (Inspired by gogrillnewcastle.com)
           ========================================================================== */
        :root {
            /* Dark Contrast Theme Variables */
            --bg-dark: #0f1015;
            --bg-dark-card: #181920;
            --border-dark: #2a2c38;
            
            /* Light Contrast Theme Variables */
            --bg-light: #f8f9fc;
            --bg-light-card: #ffffff;
            --border-light: #e2e8f0;

            /* Brand Accent Colors */
            --primary-orange: #ff4d00;
            --primary-red: #e52e00;
            --accent-gold: #f59e0b;
            
            /* Typography Colors */
            --text-dark-theme: #ffffff;
            --text-dark-muted: #9ca3af;
            --text-light-theme: #0f172a;
            --text-light-muted: #475569;

            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            line-height: 1.6;
            overflow-x: hidden;
            background-color: var(--bg-dark);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Reusable Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-red));
            color: #ffffff !important;
            font-weight: 800;
            padding: 14px 28px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(255, 77, 0, 0.35);
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.92rem;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 77, 0, 0.55);
            background: linear-gradient(135deg, var(--accent-gold), var(--primary-orange));
            color: #000000 !important;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid var(--border-dark);
            color: #ffffff;
            font-weight: 700;
            padding: 12px 26px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            border-color: var(--primary-orange);
            color: var(--primary-orange);
            background: rgba(255, 77, 0, 0.1);
        }

        .btn-secondary-light {
            background: #ffffff;
            border: 2px solid var(--border-light);
            color: var(--text-light-theme);
            font-weight: 700;
            padding: 12px 26px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .btn-secondary-light:hover {
            border-color: var(--primary-orange);
            color: var(--primary-orange);
        }

        .section-tag {
            color: var(--primary-orange);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 2px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.15;
            margin-bottom: 18px;
        }

        .section-desc {
            max-width: 750px;
            font-size: 1.05rem;
            margin-bottom: 30px;
        }

        .highlight {
            color: var(--primary-orange);
            background: linear-gradient(90deg, var(--primary-orange), var(--accent-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Section Button Centering Wrapper */
        .section-cta-row {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
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
            background: rgba(15, 16, 21, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-dark);
            padding: 15px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            font-weight: 900;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo i {
            color: var(--primary-orange);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
            list-style: none;
        }

        .nav-links a {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark-muted);
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--primary-orange);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.6rem;
            cursor: pointer;
        }

        @media (max-width: 991px) {
            .menu-toggle {
                display: block;
            }

            .header-actions .btn-primary {
                display: none;
            }

            .nav-menu {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background: var(--bg-dark);
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
                gap: 20px;
                text-align: center;
                width: 100%;
            }

            .nav-links a {
                font-size: 1.2rem;
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
           SECTION 1: HERO (DARK CONTRAST)
           ========================================================================== */
        .hero {
            padding: 160px 0 90px;
            background: var(--bg-dark);
            color: var(--text-dark-theme);
            position: relative;
            background: radial-gradient(circle at 70% 30%, rgba(255, 77, 0, 0.18) 0%, transparent 60%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 50px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: clamp(2.5rem, 5vw, 4.2rem);
            line-height: 1.08;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.15rem;
            color: var(--text-dark-muted);
            margin-bottom: 35px;
        }

        .hero-badges {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            flex-wrap: wrap;
        }

        .badge-item {
            background: var(--bg-dark-card);
            border: 1px solid var(--border-dark);
            padding: 10px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-item i {
            color: var(--accent-gold);
        }

        .badge-item span {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .hero-img-box {
            background: linear-gradient(145deg, var(--bg-dark-card), #22232e);
            border: 2px solid var(--border-dark);
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
        }

        .hero-img-box img {
            width: 100%;
            border-radius: 16px;
            object-fit: cover;
        }

        /* ==========================================================================
           SECTION 2: GEN Z SQUAD (LIGHT CONTRAST)
           ========================================================================== */
        .genz-section {
            padding: 100px 0;
            background: var(--bg-light);
            color: var(--text-light-theme);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .genz-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .genz-image-wrapper {
            position: relative;
        }

        .genz-image-wrapper img {
            width: 100%;
            border-radius: 20px;
            border: 4px solid #ffffff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .genz-badge-floating {
            position: absolute;
            top: -20px;
            left: -20px;
            background: linear-gradient(135deg, var(--primary-orange), var(--accent-gold));
            color: #000000;
            font-weight: 900;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 0.9rem;
            box-shadow: 0 10px 20px rgba(255, 77, 0, 0.3);
            text-transform: uppercase;
        }

        .genz-content p {
            color: var(--text-light-muted);
            font-size: 1.05rem;
            margin-bottom: 15px;
        }

        .genz-cards-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 25px;
        }

        .genz-mini-card {
            background: var(--bg-light-card);
            border: 1px solid var(--border-light);
            padding: 22px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
            transition: var(--transition);
        }

        .genz-mini-card:hover {
            border-color: var(--primary-orange);
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(255, 77, 0, 0.15);
        }

        .genz-mini-card i {
            font-size: 1.8rem;
            color: var(--primary-orange);
            margin-bottom: 10px;
        }

        .genz-mini-card h4 {
            font-size: 1.05rem;
            margin-bottom: 6px;
            color: var(--text-light-theme);
        }

        .genz-mini-card p {
            font-size: 0.88rem;
            color: var(--text-light-muted);
            margin-bottom: 0;
        }

        /* ==========================================================================
           SECTION 3: SIGNATURE MENU (DARK CONTRAST)
           ========================================================================== */
        .menu-section {
            padding: 100px 0;
            background: var(--bg-dark);
            color: var(--text-dark-theme);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .menu-card {
            background: var(--bg-dark-card);
            border: 1px solid var(--border-dark);
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-orange);
            box-shadow: 0 15px 35px rgba(255, 77, 0, 0.25);
        }

        .menu-img-container {
            height: 200px;
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

        .spice-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0,0,0,0.85);
            border: 1px solid var(--primary-orange);
            color: var(--primary-orange);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 800;
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
            font-size: 1.25rem;
        }

        .menu-price {
            font-size: 1.3rem;
            color: var(--accent-gold);
            font-weight: 800;
            font-family: var(--font-heading);
        }

        .menu-desc {
            color: var(--text-dark-muted);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        /* ==========================================================================
           SECTION 4: CALCULATOR SAVINGS (LIGHT CONTRAST)
           ========================================================================== */
        .calculator-section {
            padding: 100px 0;
            background: var(--bg-light);
            color: var(--text-light-theme);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .calc-box {
            background: var(--bg-light-card);
            border: 2px solid var(--border-light);
            border-radius: 24px;
            padding: 40px;
            max-width: 950px;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
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
            font-size: 0.9rem;
            letter-spacing: 1px;
            color: var(--text-light-theme);
        }

        .calc-slider {
            width: 100%;
            accent-color: var(--primary-orange);
            height: 8px;
            background: #cbd5e1;
            border-radius: 5px;
            outline: none;
        }

        .vibe-select {
            width: 100%;
            padding: 14px;
            background: #f1f5f9;
            border: 1px solid var(--border-light);
            color: var(--text-light-theme);
            border-radius: 12px;
            font-family: var(--font-body);
            font-weight: 700;
            outline: none;
        }

        .calc-comparison-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 35px;
        }

        .calc-card-other {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            padding: 25px;
            border-radius: 18px;
            text-align: center;
        }

        .calc-card-hyst {
            background: #ecfdf5;
            border: 2px solid #10b981;
            padding: 25px;
            border-radius: 18px;
            text-align: center;
            position: relative;
        }

        .calc-card-hyst .savings-badge {
            position: absolute;
            top: -12px;
            right: 20px;
            background: #10b981;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .price-label {
            font-size: 0.9rem;
            color: var(--text-light-muted);
            text-transform: uppercase;
            margin-bottom: 5px;
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
            color: #059669;
            font-family: var(--font-heading);
        }

        /* ==========================================================================
           SECTION 5: COMPARISON TABLE (DARK CONTRAST)
           ========================================================================== */
        .compare-section {
            padding: 100px 0;
            background: var(--bg-dark);
            color: var(--text-dark-theme);
        }

        .table-wrapper {
            overflow-x: auto;
            margin-top: 40px;
        }

        .compare-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            background: var(--bg-dark-card);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-dark);
        }

        .compare-table th, .compare-table td {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-dark);
        }

        .compare-table th {
            background: #12131a;
            font-family: var(--font-heading);
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        .compare-table th.brand-col {
            color: var(--primary-orange);
            background: rgba(255, 77, 0, 0.12);
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
           SECTION 6: FAQS (LIGHT CONTRAST - WITH LEFT SIDE IMAGE)
           ========================================================================== */
        .faq-section {
            padding: 100px 0;
            background: var(--bg-light);
            color: var(--text-light-theme);
            border-top: 1px solid var(--border-light);
        }

        /* Responsive 2-Column Grid Layout for FAQ Section */
        .faq-layout {
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            gap: 45px;
            align-items: flex-start;
            margin-top: 40px;
        }

        /* FAQ Left Side Image Container Styling */
        .faq-image-wrapper {
            position: sticky;
            top: 100px;
            background: var(--bg-light-card);
            padding: 12px;
            border-radius: 24px;
            border: 1px solid var(--border-light);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
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
            transition: var(--transition);
        }

        .faq-image-wrapper:hover .faq-image-container img {
            transform: scale(1.03);
        }

        /* Floating Badge on Left Side FAQ Image */
        .faq-image-badge {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(15, 16, 21, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            padding: 15px 20px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .faq-image-badge i {
            font-size: 1.8rem;
            color: var(--primary-orange);
        }

        .faq-image-badge h5 {
            font-size: 0.95rem;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .faq-image-badge p {
            font-size: 0.8rem;
            color: var(--text-dark-muted);
            margin: 0;
        }

        /* FAQ Accordion Grid */
        .faq-grid {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .faq-item {
            background: var(--bg-light-card);
            border: 1px solid var(--border-light);
            border-radius: 14px;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .faq-question {
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 800;
            font-size: 1.05rem;
            color: var(--text-light-theme);
        }

        .faq-question i {
            color: var(--primary-orange);
            transition: var(--transition);
        }

        .faq-answer {
            padding: 0 28px 22px;
            color: var(--text-light-muted);
            font-size: 0.98rem;
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
           SECTION 7: FOOTER (DARK CONTRAST)
           ========================================================================== */
        footer {
            background: #090a0d;
            color: var(--text-dark-theme);
            padding: 80px 0 30px;
            border-top: 1px solid var(--border-dark);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-brand p {
            color: var(--text-dark-muted);
            margin-top: 15px;
            font-size: 0.95rem;
        }

        .footer-col h4 {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: var(--primary-orange);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: var(--text-dark-muted);
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--border-dark);
            color: var(--text-dark-muted);
            font-size: 0.88rem;
        }

        @media (max-width: 991px) {
            .hero-grid, .genz-grid, .calc-controls, .calc-comparison-grid, .footer-grid, .faq-layout {
                grid-template-columns: 1fr;
            }
            .faq-image-wrapper {
                position: relative;
                top: 0;
            }
            .genz-cards-container {
                grid-template-columns: 1fr;
            }
            .hero {
                padding-top: 130px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER / NAVIGATION (BUTTON INCLUDED) -->
    <header>
        <div class="container nav-container">
            <a href="#" class="logo">
                <i class="fa-solid fa-fire-flame-curved"></i> GO GRILL
            </a>

            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="#genz">Gen Z Squad</a></li>
                    <li><a href="#menu">Our Menu</a></li>
                    <li><a href="#calculator">HYST Savings Calc</a></li>
                    <li><a href="#compare">HYST vs Third Party Apps</a></li>
                    <li><a href="#faq">FAQs</a></li>
                </ul>
                
                <div class="mobile-hyst-btn">
                    <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                    </a>
                </div>
            </div>

            <div class="header-actions">
                <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                </a>
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- SECTION 1: HERO (DARK THEME - BUTTONS INCLUDED) -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <span class="section-tag"><i class="fa-solid fa-bolt"></i> Flame-Grilled Perfection</span>
                <h1>Newcastle's Ultimate <span class="highlight">Peri Peri & Grill</span> Spot</h1>
                <p>Craving 100% authentic flame-grilled peri peri chicken, smashed gourmet burgers, juicy kebabs, and squad-sized party platters? Go Grill serves Newcastle's finest late-night food. Stop paying extra delivery app markup fees — order direct on HYST!</p>
                
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-fire"></i> Order Direct on HYST
                    </a>
                    <a href="#calculator" class="btn-secondary">
                        <i class="fa-solid fa-calculator"></i> Compare App Prices
                    </a>
                </div>

                <div class="hero-badges">
                    <div class="badge-item">
                        <i class="fa-solid fa-fire-burner"></i>
                        <span>100% Real Flame-Grilled</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-tag"></i>
                        <span>Zero App Price Inflation</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-motorcycle"></i>
                        <span>Express HYST Delivery</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-img-box">
                    <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=800&q=80" alt="Go Grill Flame Grilled Food">
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: GEN Z SQUAD (LIGHT THEME - BUTTON INCLUDED) -->
    <section class="genz-section" id="genz">
        <div class="container genz-grid">
            <div class="genz-image-wrapper">
                <div class="genz-badge-floating">
                    <i class="fa-solid fa-crown"></i> Newcastle's #1 Squad Hub
                </div>
                <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=900&q=80" alt="Gen Z Friends Fun Eating Go Grill Food">
            </div>

            <div class="genz-content">
                <span class="section-tag">Pure Vibe & Pure Flavor</span>
                <h2 class="section-title" style="color:var(--text-light-theme);">Built For The <span class="highlight">Gen Z Squad</span></h2>
                <p>No Cap. Go Grill Newcastle is where your crew pulls up for epic food, insane flavor explosions, and unbeatable late-night chill sessions. Whether you're fueling an all-night gaming session, celebrating after exams, or hosting a pre-party feast, we bring the heat!</p>
                <p>We craft massive squad sharing platters, peri wing towers, loaded spicy fries, and double-smashed cheese burgers designed specifically to keep the vibe high and your stomach full without blowing your budget.</p>

                <div class="genz-cards-container">
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-users-viewfinder"></i>
                        <h4>Squad Mega Sharing</h4>
                        <p>Jumbo wing platters & whole peri chickens split easy with your squad.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-pepper-hot"></i>
                        <h4>Your Heat, Your Way</h4>
                        <p>From gentle Lemon & Herb to intense Extra Hot Fiery Blast.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-moon"></i>
                        <h4>Late Night Savior</h4>
                        <p>Serving scorching hot meals late into the night when other kitchens close.</p>
                    </div>
                    <div class="genz-mini-card">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <h4>HYST Wallet Protection</h4>
                        <p>Save money by cutting out third-party delivery service charges.</p>
                    </div>
                </div>

                <!-- SECTION BUTTON -->
                <div style="margin-top: 30px;">
                    <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-users"></i> Order For Your Squad on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: SIGNATURE MENU (DARK THEME - BUTTONS INCLUDED) -->
    <section class="menu-section" id="menu">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag">Explore The Taste</span>
                <h2 class="section-title">Go Grill <span class="highlight">Signature Dishes</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-dark-muted);">Marinated for 24 hours in authentic peri peri spices and flame-grilled to sizzling perfection upon order.</p>
            </div>

            <div class="menu-grid">
                <!-- Menu Item 1 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="spice-tag"><i class="fa-solid fa-fire"></i> Best Seller</span>
                        <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&w=600&q=80" alt="Full Flame-Grilled Peri Peri Chicken">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Whole Peri Chicken</h3>
                                <span class="menu-price">£13.99</span>
                            </div>
                            <p class="menu-desc">Fresh whole chicken, flame-seared with your choice of Peri marinade (Mild, Hot, Extra Hot, Lemon & Herb).</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Menu Item 2 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="spice-tag"><i class="fa-solid fa-cheese"></i> Fan Favorite</span>
                        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=600&q=80" alt="Double Smashed Gourmet Burger">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Double Smashed Burger</h3>
                                <span class="menu-price">£8.49</span>
                            </div>
                            <p class="menu-desc">Two smashed 100% beef patties, melted double cheddar, caramelized onions & secret house grill sauce.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Menu Item 3 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="spice-tag"><i class="fa-solid fa-crown"></i> Ultimate Party</span>
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80" alt="Mega Squad Feast Platter">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>Mega Squad Platter</h3>
                                <span class="menu-price">£29.99</span>
                            </div>
                            <p class="menu-desc">2 Whole Peri Chickens + 12 Fiery Wings + 4 Large Sides (Peri Fries, Coleslaw, Rice) + 1.5L Drink.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>

                <!-- Menu Item 4 -->
                <div class="menu-card">
                    <div class="menu-img-container">
                        <span class="spice-tag"><i class="fa-solid fa-pepper-hot"></i> Spicy Munch</span>
                        <img src="https://images.unsplash.com/photo-1527477396000-e27163b481c2?auto=format&fit=crop&w=600&q=80" alt="Fiery Peri Wings Bucket">
                    </div>
                    <div class="menu-details">
                        <div>
                            <div class="menu-title-row">
                                <h3>12 Fiery Peri Wings</h3>
                                <span class="menu-price">£9.99</span>
                            </div>
                            <p class="menu-desc">Charcoal-grilled jumbo wings tossed in signature house-blended peri sauce served with garlic mayo dip.</p>
                        </div>
                        <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary" style="justify-content: center; width: 100%;">
                            <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                        </a>
                    </div>
                </div>
            </div>

            <!-- SECTION BUTTON -->
            <div class="section-cta-row">
                <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-utensils"></i> View & Order Full Menu on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 4: SAVINGS CALCULATOR (LIGHT THEME - BUTTON INCLUDED) -->
    <section class="calculator-section" id="calculator">
        <div class="container">
            <div style="text-align: center; margin-bottom: 20px;">
                <span class="section-tag">Stop Paying Extra Fees</span>
                <h2 class="section-title" style="color:var(--text-light-theme);">Other Platforms vs <span class="highlight">HYST Savings</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-light-muted);">Third-party delivery apps inflate menu prices by up to 25% and add hidden service fees. Slide below to see how much you save by ordering direct on HYST!</p>
            </div>

            <div class="calc-box">
                <div class="calc-controls">
                    <div class="control-group">
                        <label>Squad Size: <span id="peopleCountText" style="color:var(--primary-orange);">4 Friends</span></label>
                        <input type="range" min="1" max="10" value="4" class="calc-slider" id="peopleSlider">
                    </div>

                    <div class="control-group">
                        <label>Hunger Level / Order Type</label>
                        <select class="vibe-select" id="vibeSelect">
                            <option value="light">Light Munchies (Burgers + Wings)</option>
                            <option value="medium" selected>Standard Squad (Chicken Platter + Burgers)</option>
                            <option value="heavy">Mega Party Banquet (XL Platters + Extras)</option>
                        </select>
                    </div>
                </div>

                <div class="calc-comparison-grid">
                    <div class="calc-card-other">
                        <div class="price-label">Other Platforms</div>
                        <div class="price-value-other" id="otherPrice">£42.50</div>
                        <p style="font-size:0.8rem; color:#ef4444; margin-top:8px;">Includes 20% menu markup + £2.99 service fee + £3.50 delivery</p>
                    </div>

                    <div class="calc-card-hyst">
                        <span class="savings-badge" id="savingsBadge">SAVE £11.50</span>
                        <div class="price-label">HYST Direct Price</div>
                        <div class="price-value-hyst" id="hystPrice">£31.00</div>
                        <p style="font-size:0.85rem; color:#059669; margin-top:8px; font-weight:700;">Direct from kitchen price + lowest delivery rates!</p>
                    </div>
                </div>

                <!-- SECTION BUTTON -->
                <div class="section-cta-row">
                    <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                        <i class="fa-solid fa-piggy-bank"></i> Claim Your Savings - Order on HYST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: COMPARISON TABLE (DARK THEME - BUTTON INCLUDED) -->
    <section class="compare-section" id="compare">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag">Smart Ordering Choice</span>
                <h2 class="section-title">HYST Direct vs <span class="highlight">Delivery Apps</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-dark-muted);">Compare ordering directly on HYST versus third-party delivery services like Uber Eats, Deliveroo, and Just Eat.</p>
            </div>

            <div class="table-wrapper">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th>Feature / Service</th>
                            <th class="brand-col"><i class="fa-solid fa-check"></i> HYST Direct Order</th>
                            <th>Third-Party Apps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Food Price Inflation</strong></td>
                            <td>0% Markup (Original Menu Price) <i class="fa-solid fa-check-circle"></i></td>
                            <td>15% to 25% Inflated Item Prices <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Hidden Service Charges</strong></td>
                            <td>Zero Sneaky Service Fees <i class="fa-solid fa-check-circle"></i></td>
                            <td>Added Service & Small Order Fees <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Exclusive Combo Deals</strong></td>
                            <td>Full Access to Go Grill Bundles <i class="fa-solid fa-check-circle"></i></td>
                            <td>Restricted / Partial Menu Options <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Food Freshness & Speed</strong></td>
                            <td>Dispatched Straight from Grill <i class="fa-solid fa-check-circle"></i></td>
                            <td>Multi-stop Batch Deliveries <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                        <tr>
                            <td><strong>Supports Local Business</strong></td>
                            <td>100% Direct Support to Go Grill <i class="fa-solid fa-check-circle"></i></td>
                            <td>Huge Commissions Cut by Big Apps <i class="fa-solid fa-times-circle"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- SECTION BUTTON -->
            <div class="section-cta-row">
                <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                    <i class="fa-solid fa-shield-halved"></i> Skip App Fees - Order Direct on HYST
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 6: FAQS WITH PROFESSIONAL LEFT-SIDE IMAGE -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag">Got Questions?</span>
                <h2 class="section-title" style="color:var(--text-light-theme);">Frequently Asked <span class="highlight">Questions</span></h2>
                <p class="section-desc" style="margin: 0 auto; color: var(--text-light-muted);">Everything you need to know about Go Grill Newcastle menu, spice levels, and HYST direct ordering.</p>
            </div>

            <div class="faq-layout">
                <!-- LEFT SIDE PROFESSIONAL BRAND IMAGE -->
                <div class="faq-image-wrapper">
                    <div class="faq-image-container">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80" alt="Go Grill Fresh Food Kitchen Preparation">
                        <div class="faq-image-badge">
                            <i class="fa-solid fa-headset"></i>
                            <div>
                                <h5>Need Instant Help?</h5>
                                <p>Order direct on HYST for live tracking & support</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE FAQ ACCORDION -->
                <div class="faq-grid">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>1. What makes Go Grill Newcastle special?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Go Grill Newcastle specializes in 100% authentic flame-grilled peri peri chicken, smashed beef burgers, sizzling kebabs, and high-value group sharing platters cooked fresh over real grill fires.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>2. Why is ordering on HYST cheaper than Uber Eats or Deliveroo?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Third-party delivery apps charge restaurants huge commissions (up to 30%), forcing food prices to increase. When you order direct on HYST, you pay the original in-store price with zero hidden service fees!
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>3. How do I place an order for Go Grill on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Simply click any "Order on HYST" button on this page or visit <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" style="color:var(--primary-orange);">https://hyst.uk/restaurant/go-grill-1780488145</a> to select your items and checkout securely.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>4. What spice flavors can I choose for my chicken?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            We offer Lemon & Herb, Mango & Lime, Garlic Peri, Mild Spice, Medium Flame, Hot Peri Peri, and Extra Hot Fiery Blast.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>5. Do you offer student and group discounts?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes! Our Mega Squad Platters and Wing Bundles are specially priced to give student groups and party crowds maximum food for the best price.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>6. Is all the meat at Go Grill Halal?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, 100% of our meat and chicken supply is certified Halal and prepared following strict hygienic standards.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>7. Does Go Grill deliver late at night in Newcastle?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, we operate late night delivery hours across Newcastle upon Tyne so you can always satisfy midnight cravings.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>8. Are vegetarian or plant-based meals available?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, we serve grilled halloumi burgers, veggie patties, falafel wraps, spicy peri rice, and fresh salads.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>9. Can I customize sauce and topping levels on HYST?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, the HYST ordering portal allows complete customization of toppings, extra sauce dips, cheese additions, and sides.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span>10. What are the most popular sides at Go Grill?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Our top sides are Loaded Peri Fries, Flaming Corn on the Cob, Peri Rice, Creamy Coleslaw, and Halloumi Sticks.
                        </div>
                    </div>

                    <!-- SECTION CTA BUTTON -->
                    <div class="section-cta-row" style="justify-content: flex-start; margin-top: 20px;">
                        <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-circle-question"></i> Ready to Feast? Order Now on HYST
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 7: FOOTER (DARK THEME - BUTTON INCLUDED) -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#" class="logo">
                        <i class="fa-solid fa-fire-flame-curved"></i> GO GRILL
                    </a>
                    <p>Newcastle's home of authentic flame-grilled peri peri chicken, smashed burgers, and squad feasts. Direct delivery powered by HYST.</p>
                </div>

                <div class="footer-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#genz">Gen Z Squad</a></li>
                        <li><a href="#menu">Our Menu</a></li>
                        <li><a href="#calculator">Savings Calc</a></li>
                        <li><a href="#compare">HYST vs Apps</a></li>
                        <li><a href="#faq">FAQs</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Direct Order</h4>
                    <ul>
                        <li><a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank">Flame Grilled Chicken</a></li>
                        <li><a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank">Smashed Burgers</a></li>
                        <li><a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank">Squad Platters</a></li>
                        <li><a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank">Fiery Wings</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Save on Delivery</h4>
                    <p style="color: var(--text-dark-muted); margin-bottom: 15px; font-size: 0.9rem;">Order on HYST to bypass app commission markups!</p>
                    <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" class="btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-bag-shopping"></i> Order on HYST
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Go Grill Newcastle. Powered by <a href="https://hyst.uk/restaurant/go-grill-1780488145" target="_blank" style="color:var(--primary-orange);">HYST Ordering</a>.</p>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT -->
    <script>
        // 1. Mobile Menu Toggle Logic
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

        // 2. Interactive Calculator Logic
        const peopleSlider = document.getElementById('peopleSlider');
        const peopleCountText = document.getElementById('peopleCountText');
        const vibeSelect = document.getElementById('vibeSelect');
        const otherPrice = document.getElementById('otherPrice');
        const hystPrice = document.getElementById('hystPrice');
        const savingsBadge = document.getElementById('savingsBadge');

        function updateSavings() {
            const people = parseInt(peopleSlider.value);
            const vibe = vibeSelect.value;
            peopleCountText.textContent = `${people} ${people === 1 ? 'Person' : 'Friends'}`;

            let basePricePerPerson = 7.5;
            if (vibe === 'medium') basePricePerPerson = 9.5;
            if (vibe === 'heavy') basePricePerPerson = 12.5;

            const hystTotal = (people * basePricePerPerson).toFixed(2);
            const otherTotal = ((people * basePricePerPerson * 1.22) + 2.99 + 3.50).toFixed(2);
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
                q.parentElement.classList.toggle('active');
            });
        });
    </script>
</body>
</html>