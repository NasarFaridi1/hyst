<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentic Italian Restaurant & Delivery | Order on HYST</title>
    <meta name="description"
        content="Experience authentic handcrafted Italian pasta, 72-hour slow-fermented wood-fired pizza, and vibrant dining. Fast delivery & exclusive group rewards. Order on HYST now!">
    <meta name="keywords"
        content="Italian Restaurant, Order Italian Food, HYST Italian, Handcrafted Pasta, Wood Fired Pizza UK, Gen Z Italian Feast, Italian Takeaway">
    <link rel="canonical" href="https://hyst.uk/restaurant/italian-restaurant">

    <!-- Open Graph for Social Sharing & GEO Search Engines -->
    <meta property="og:title" content="Authentic Italian Culinary Experience | Order on HYST">
    <meta property="og:description"
        content="Taste the true passion of Italy. Savor stone-baked sourdough pizzas and handcrafted fresh pasta delivered straight to your door via HYST.">
    <meta property="og:type" content="restaurant">
    <meta property="og:url" content="https://hyst.uk/restaurant/italian-restaurant">
    <meta property="og:image"
        content="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=1200&q=80">

    <!-- Premium Fonts: Playfair Display + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --color-primary: #C8102E;
            /* ASK Italian Vibrant Crimson Red */
            --color-primary-dark: #9A0B22;
            /* Deep Italian Wine Red */
            --color-teal: #1B7583;
            /* ASK Italian Signature Teal / Blue */
            --color-teal-dark: #12515B;
            /* Dark Mediterranean Teal */
            --color-teal-light: #EBF5F6;
            /* Light Teal Wash */
            --color-gold: #E5A93C;
            /* Italian Warm Ochre / Gold */
            --color-bg: #FAF7F2;
            /* Creamy Tuscan Dough Off-White */
            --color-card: #FFFFFF;
            /* Pure White */
            --color-dark: #1A1A1A;
            /* Deep Charcoal Text */
            --color-muted: #555555;
            /* Muted Grey Text */
            --radius-sm: 10px;
            --radius-md: 18px;
            --radius-lg: 28px;
            --shadow: 0 12px 35px rgba(27, 117, 131, 0.08);
            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--color-bg);
            color: var(--color-dark);
            font-family: var(--font-body);
            line-height: 1.7;
            overflow-x: hidden;
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-heading);
            color: var(--color-dark);
            line-height: 1.25;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: clamp(2.4rem, 5vw, 3.8rem);
            font-weight: 800;
        }

        h2 {
            font-size: clamp(1.9rem, 4vw, 2.8rem);
            font-weight: 700;
        }

        h3 {
            font-size: 1.35rem;
            font-weight: 700;
        }

        p {
            margin-bottom: 1.2rem;
            font-size: 1.05rem;
            color: var(--color-muted);
        }

        .highlight-red {
            color: var(--color-primary);
        }

        .highlight-teal {
            color: var(--color-teal);
        }

        .container {
            width: 90%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .section-padding {
            padding: 90px 0;
        }

        .text-center {
            text-align: center;
        }

        /* Navbar */
        header {
            background-color: rgba(250, 247, 242, 0.95);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid var(--color-teal);
            padding: 16px 0;
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .logo {
            font-family: var(--font-heading);
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--color-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo span {
            background: var(--color-primary);
            color: #fff;
            padding: 5px 16px;
            border-radius: 8px;
            font-size: 1.4rem;
            font-family: var(--font-heading);
            letter-spacing: 2px;
            font-weight: 800;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-links {
            display: flex;
            gap: 28px;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--color-dark);
            font-weight: 600;
            font-size: 0.98rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--color-primary);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--color-dark);
            cursor: pointer;
            padding: 4px 8px;
        }

        /* Buttons */
        .btn-hyst {
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            color: #ffffff !important;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 22px rgba(200, 16, 46, 0.35);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-hyst:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(200, 16, 46, 0.5);
            background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary));
        }

        .btn-teal {
            background: linear-gradient(135deg, var(--color-teal), var(--color-teal-dark));
            color: #ffffff !important;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 22px rgba(27, 117, 131, 0.35);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-teal:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(27, 117, 131, 0.5);
        }

        .btn-secondary {
            background: transparent;
            color: var(--color-teal);
            border: 2px solid var(--color-teal);
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: var(--color-teal);
            color: #fff;
        }

        /* Hero Section */
        .hero {
            padding: 70px 0 90px;
            background: radial-gradient(circle at top right, rgba(27, 117, 131, 0.12), transparent 55%),
                radial-gradient(circle at bottom left, rgba(200, 16, 46, 0.08), transparent 55%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 50px;
            align-items: center;
        }

        .badge-teal {
            background: var(--color-teal-light);
            color: var(--color-teal);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 18px;
            border: 1px solid rgba(27, 117, 131, 0.2);
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 2px solid rgba(0, 0, 0, 0.06);
        }

        .stat-card h4 {
            font-size: 1.8rem;
            color: var(--color-primary);
            margin-bottom: 2px;
        }

        .stat-card p {
            font-size: 0.85rem;
            margin: 0;
            font-weight: 600;
            color: var(--color-dark);
        }

        .hero-image-box {
            position: relative;
        }

        .hero-img {
            width: 100%;
            height: 480px;
            object-fit: cover;
            border-radius: var(--radius-lg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 8px solid #ffffff;
        }

        .floating-tag {
            position: absolute;
            bottom: -20px;
            left: -20px;
            background: #ffffff;
            padding: 16px 24px;
            border-radius: var(--radius-md);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 700;
            border-left: 5px solid var(--color-primary);
        }

        /* About Section */
        .about-card-box {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 60px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-bullets {
            list-style: none;
            margin-top: 20px;
        }

        .feature-bullets li {
            position: relative;
            padding-left: 32px;
            margin-bottom: 14px;
            font-weight: 600;
            color: var(--color-dark);
        }

        .feature-bullets li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--color-teal);
            font-weight: 900;
            font-size: 1.3rem;
        }

        /* Gen Z Squad & Group Fun Section */
        .genz-section {
            background: linear-gradient(135deg, #12515B 0%, #1A1A1A 100%);
            color: #ffffff;
            border-radius: var(--radius-lg);
            padding: 70px 45px;
            margin: 70px 0;
            position: relative;
            overflow: hidden;
        }

        .genz-section h2,
        .genz-section h3 {
            color: #ffffff;
        }

        .genz-section p {
            color: #D0E3E6;
        }

        .genz-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            align-items: center;
            margin-top: 35px;
        }

        .genz-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .genz-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 24px;
            border-radius: var(--radius-md);
            backdrop-filter: blur(8px);
            transition: transform 0.3s;
        }

        .genz-card:hover {
            transform: translateX(8px);
            border-color: var(--color-gold);
        }

        /* Calculator Section Outer Box */
        .calculator-section {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 55px;
            box-shadow: var(--shadow);
            border: 2px solid var(--color-teal-light);
            margin: 70px 0;
        }

        .calc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 45px;
            margin-top: 35px;
            align-items: center;
        }

        /* Range Slider Styling */
        .slider-container {
            background: var(--color-bg);
            padding: 30px;
            border-radius: var(--radius-md);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .slider-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .slider-header label {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--color-dark);
        }

        .people-display {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--color-teal);
            background: #ffffff;
            padding: 4px 16px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .calc-slider {
            width: 100%;
            height: 12px;
            border-radius: 10px;
            background: #E2E8F0;
            outline: none;
            accent-color: var(--color-teal);
            cursor: pointer;
            transition: background 0.3s;
        }

        .slider-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--color-muted);
            margin-top: 10px;
        }

        .calc-result-box {
            background: var(--color-bg);
            border: 2px dashed var(--color-teal);
            padding: 35px 25px;
            border-radius: var(--radius-md);
            text-align: center;
        }

        .price-compare-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 20px 0 10px;
            background: #ffffff;
            padding: 18px 12px;
            border-radius: var(--radius-sm);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .price-block .label {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--color-muted);
        }

        .price-block .old-price {
            font-size: 1.6rem;
            color: #888888;
            text-decoration: line-through;
            font-weight: 700;
        }

        .price-block .hyst-price {
            font-size: 2.2rem;
            font-family: var(--font-heading);
            color: var(--color-teal);
            font-weight: 800;
        }

        .savings-badge {
            background: #D4EDDA;
            color: #155724;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.95rem;
            display: inline-block;
            margin-top: 10px;
            border: 1px solid #C3E6CB;
        }

        /* Comparison Section Outer Box - EXACT MATCH WITH CALCULATOR BOX */
        .comparison-section {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 55px;
            box-shadow: var(--shadow);
            border: 2px solid var(--color-teal-light);
            margin: 70px 0;
        }

        .table-responsive {
            overflow-x: auto;
            margin: 35px auto 0;
            width: 100%;
            border-radius: var(--radius-md);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid #EAEAEA;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            overflow: hidden;
            table-layout: fixed;
        }

        .comparison-table th,
        .comparison-table td {
            padding: 20px 24px;
            vertical-align: middle;
        }

        .comparison-table th {
            background: var(--color-teal);
            color: #ffffff;
            font-family: var(--font-heading);
            font-size: 1.2rem;
            text-align: center;
        }

        /* Column 1: Left Aligned Feature Names */
        .comparison-table th:first-child {
            text-align: left;
            padding-left: 35px;
            width: 42%;
        }

        /* Column 2: Centered Other Platforms */
        .comparison-table th:nth-child(2) {
            width: 29%;
        }

        /* Column 3: Centered HYST Column */
        .comparison-table th.hyst-col {
            background: var(--color-primary);
            width: 29%;
        }

        .comparison-table td:first-child {
            text-align: left;
            padding-left: 35px;
            font-weight: 700;
            color: var(--color-dark);
            font-size: 1.02rem;
        }

        .comparison-table td:nth-child(2),
        .comparison-table td:nth-child(3) {
            text-align: center;
        }

        .comparison-table tr:nth-child(even) {
            background-color: #FAF7F2;
        }

        .comparison-table tr {
            border-bottom: 1px solid #EAEAEA;
        }

        /* Icon & Text Indicators */
        .indicator-bad {
            color: var(--color-primary);
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .indicator-good {
            color: var(--color-teal-dark);
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .icon-cross {
            background: #FADBD8;
            color: var(--color-primary);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .icon-check {
            background: #D4EDDA;
            color: #155724;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* Menu Section */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
            gap: 30px;
            margin-top: 45px;
        }

        .menu-card {
            background: #ffffff;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .menu-card:hover {
            transform: translateY(-8px);
        }

        .menu-card-img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .menu-card-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .menu-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .menu-card-price {
            color: var(--color-primary);
            font-weight: 800;
            font-size: 1.25rem;
        }

        /* FAQ Section */
        .faq-section {
            background: #ffffff;
            padding: 80px 0;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            margin: 70px 0;
        }

        .faq-accordion {
            max-width: 900px;
            margin: 40px auto 0;
            padding: 0 20px;
        }

        .faq-item {
            border-bottom: 1px solid #E2E8F0;
            padding: 22px 0;
        }

        .faq-question {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--color-dark);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-answer {
            margin-top: 14px;
            color: var(--color-muted);
            display: none;
            font-size: 1rem;
            line-height: 1.8;
            text-align: left;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-toggle {
            transform: rotate(45deg);
            color: var(--color-primary);
        }

        .faq-toggle {
            font-size: 1.6rem;
            transition: transform 0.3s ease;
            color: var(--color-teal);
        }

        /* Footer */
        footer {
            background: #111817;
            color: #A0AAB0;
            padding: 75px 0 30px;
            border-top: 5px solid var(--color-primary);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-col h4 {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: #A0AAB0;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-col ul li a:hover {
            color: var(--color-gold);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {

            .hero-grid,
            .about-grid,
            .calc-grid,
            .genz-grid {
                grid-template-columns: 1fr;
            }

            .hero-img {
                height: 360px;
            }

            .about-card-box {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #FAF7F2;
                flex-direction: column;
                padding: 20px;
                gap: 18px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                border-bottom: 3px solid var(--color-teal);
                z-index: 1001;
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-links {
                flex-direction: column;
                gap: 15px;
                width: 100%;
                text-align: center;
            }

            .nav-menu .btn-hyst {
                width: 100%;
                justify-content: center;
            }

            .genz-section {
                padding: 40px 20px;
            }

            .calculator-section,
            .comparison-section {
                padding: 25px;
            }

            .hero-content .btn-hyst,
            .hero-content .btn-teal {
                width: 100%;
                justify-content: center;
            }

            .comparison-table {
                min-width: 650px;
            }
        }
    </style>

    <!-- Structured Data (JSON-LD) for SEO, AEO & GEO Search Engines -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Restaurant",
      "name": "Italian Restaurant",
      "image": "https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=1200&q=80",
      "url": "https://hyst.uk/restaurant/italian-restaurant",
      "telephone": "+44-800-HYST-ITA",
      "priceRange": "££",
      "menu": "https://hyst.uk/restaurant/italian-restaurant#menu",
      "servesCuisine": ["Italian", "Pasta", "Pizza", "Desserts"],
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "123 Authentic Way",
        "addressLocality": "London",
        "postalCode": "EC1A 1BB",
        "addressCountry": "UK"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 51.5074,
        "longitude": -0.1278
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "1280"
      }
    }
    </script>
</head>

<body>

    <!-- Header / Navbar -->
    <header>
        <div class="container nav-wrapper">
            <a href="#" class="logo">
                <span>ITALIAN</span>
            </a>
            <button class="menu-toggle" id="menuToggle" onclick="toggleMenu()" aria-label="Toggle Menu">☰</button>
            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="#about" onclick="closeMenu()">About Us</a></li>
                    <li><a href="#genz-squad" onclick="closeMenu()">Squad Deals</a></li>
                    <li><a href="#calculator" onclick="closeMenu()">Price Calc</a></li>
                    <li><a href="#compare" onclick="closeMenu()">Why HYST?</a></li>
                    <li><a href="#menu" onclick="closeMenu()">Menu</a></li>
                    <li><a href="#faq" onclick="closeMenu()">FAQs</a></li>
                </ul>
                <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-hyst">Order on HYST 🍕</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <span class="badge-teal">🇮🇹 Fresh Handcrafted Italian Cuisine</span>
                <h1>Crafted with Passion. Delivered <span class="highlight-red">Piping Hot</span>.</h1>
                <p>Welcome to the ultimate Italian dining experience on HYST. From 72-hour slow-fermented sourdough
                    pizzas to fresh pasta extruded daily, savor true Italian culinary craft engineered for group
                    hangouts, late-night cravings, and instant satisfaction.</p>

                <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 28px;">
                    <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-hyst">Order on HYST Now 🚀</a>
                    <a href="#menu" class="btn-secondary">Explore Menu</a>
                </div>

                <div class="hero-stats">
                    <div class="stat-card">
                        <h4>72 Hours</h4>
                        <p>Sourdough Fermentation</p>
                    </div>
                    <div class="stat-card">
                        <h4>100%</h4>
                        <p>DOP San Marzano Tomatoes</p>
                    </div>
                    <div class="stat-card">
                        <h4>4.9 ★</h4>
                        <p>1,200+ HYST Reviews</p>
                    </div>
                </div>
            </div>

            <div class="hero-image-box">
                <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=900&q=80"
                    alt="Wood-fired authentic sourdough pizza" class="hero-img">
                <div class="floating-tag">
                    <span style="font-size: 2rem;">⚡</span>
                    <div>
                        <div style="font-size: 0.85rem; color: var(--color-muted);">Express HYST Delivery</div>
                        <div style="color: var(--color-teal); font-weight: 800;">Hot & Fresh in 30 Mins</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="section-padding" id="about">
        <div class="container">
            <div class="about-card-box">
                <div class="about-grid">
                    <div>
                        <span
                            style="color: var(--color-teal); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Our
                            Craft & Heritage</span>
                        <h2 style="margin-top: 8px;">Authentic Ingredients. No Fast-Food Shortcuts.</h2>
                        <p>At Italian, we believe great food brings people together. Our olive oil is cold-pressed
                            directly from Puglian groves, our Parmigiano Reggiano is aged for 24 months, and our plum
                            tomatoes are harvested under the Southern Italian sun.</p>

                        <ul class="feature-bullets">
                            <li>Hand-rolled pasta extruded every morning with Italian durum wheat & eggs</li>
                            <li>Stone-baked pizzas cooked at 450°C for an airy, crisp blistered crust</li>
                            <li>Extensive Vegan, Vegetarian & Gluten-conscious menu selections</li>
                            <li>Eco-friendly thermal packaging engineered to lock in heat and crispness</li>
                        </ul>

                        <div style="margin-top: 30px;">
                            <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-teal">Order Authentic
                                Italian on HYST</a>
                        </div>
                    </div>

                    <div>
                        <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=800&q=80"
                            alt="Chef preparing fresh Italian pasta" class="about-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gen Z Squad & Group Fun Section -->
    <section class="container" id="genz-squad">
        <div class="genz-section">
            <div class="text-center" style="max-width: 750px; margin: 0 auto;">
                <span
                    style="background: rgba(229, 169, 60, 0.2); color: var(--color-gold); padding: 5px 16px; border-radius: 20px; font-weight: 800; font-size: 0.85rem; text-transform: uppercase;">Squad
                    Approved 📸</span>
                <h2 style="margin-top: 12px;">Gen Z Vibe Check: Ultimate Italian Feasts</h2>
                <p>No pretentious dining rules. Just aesthetic cheese pulls, sourdough pizza slices, and huge group
                    combo discounts delivered straight to your door.</p>
            </div>

            <div class="genz-grid">
                <div>
                    <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=800&q=80"
                        alt="Friends having an Italian feast"
                        style="width: 100%; height: 380px; object-fit: cover; border-radius: var(--radius-md); border: 4px solid rgba(255,255,255,0.2);">
                </div>

                <div class="genz-cards">
                    <div class="genz-card">
                        <h3>🧀 The Cheese Pull Challenge</h3>
                        <p>Our slow-baked burrata and doubled-mozzarella pizzas are built for camera feeds. Tag
                            <strong>@ItalianFeast</strong> on Instagram or TikTok for weekly meal rewards!</p>
                    </div>

                    <div class="genz-card">
                        <h3>💸 Easy Split-Bill Bundles</h3>
                        <p>Order group party bundles on HYST starting at under £9 per head, including 3 sourdough
                            pizzas, 2 fresh pastas, garlic dough balls, and soft drinks.</p>
                    </div>

                    <div class="genz-card">
                        <h3>🌙 Late Night Cravings Fuel</h3>
                        <p>Study sessions or weekend bashes? HYST delivers steaming-hot sourdough pizzas and fresh
                            pastas late into the night.</p>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-hyst"
                    style="background: var(--color-gold); color: var(--color-dark) !important;">Claim Squad Bundle on
                    HYST 🎉</a>
            </div>
        </div>
    </section>

    <!-- Interactive Calculator Section -->
    <section class="container" id="calculator">
        <div class="calculator-section">
            <div class="text-center" style="max-width: 720px; margin: 0 auto;">
                <span class="badge-teal">Live Price Match</span>
                <h2>Savings Calculator 🧮</h2>
                <p>Drag the bar forward to see how much you save when ordering directly on HYST with zero platform
                    commissions & hidden fees!</p>
            </div>

            <div class="calc-grid">
                <!-- Interactive Range Slider -->
                <div class="slider-container">
                    <div class="slider-header">
                        <label for="peopleRange">Group Size:</label>
                        <span class="people-display" id="peopleCountText">4 People</span>
                    </div>
                    <input type="range" id="peopleRange" min="1" max="20" value="4" class="calc-slider"
                        oninput="calculateSavings(this.value)">
                    <div class="slider-labels">
                        <span>1 Person</span>
                        <span>10 People</span>
                        <span>20 People</span>
                    </div>
                    <p style="margin-top: 25px; font-size: 0.9rem; color: var(--color-muted);">
                        💡 <strong>Slide forward</strong> to calculate savings for larger groups, family meals, or squad
                        parties!
                    </p>
                </div>

                <div class="calc-result-box">
                    <span
                        style="text-transform: uppercase; font-size: 0.85rem; font-weight: 800; color: var(--color-muted);">Cost
                        Comparison Breakdown</span>

                    <div class="price-compare-container">
                        <div class="price-block">
                            <div class="label">Other Platforms</div>
                            <div class="old-price" id="otherPrice">£54.89</div>
                        </div>
                        <div style="font-size: 1.5rem; font-weight: bold; color: var(--color-muted);">VS</div>
                        <div class="price-block">
                            <div class="label" style="color: var(--color-teal);">HYST Price</div>
                            <div class="hyst-price" id="hystPrice">£38.00</div>
                        </div>
                    </div>

                    <div class="savings-badge" id="savingsTag">
                        🎉 Total Savings on HYST: £16.89
                    </div>

                    <p id="calcDetails" style="font-size: 0.95rem; margin-top: 15px; color: var(--color-muted);">
                        Includes 2 Sourdough Pizzas, 2 Handcrafted Pastas & 1 Garlic Dough Bites.</p>
                    <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-hyst"
                        style="margin-top: 20px; width: 100%; justify-content: center;">Save Now & Order on HYST</a>
                </div>
            </div>
        </div>
    </section>

    <!-- PERFECTLY MATCHED OUTER BOX COMPARISON SECTION -->
    <section class="container" id="compare">
        <div class="comparison-section">
            <div class="text-center" style="max-width: 750px; margin: 0 auto;">
                <span class="badge-teal">Honest Pricing & Superior Quality</span>
                <h2>Other Platforms vs. HYST 🏆</h2>
                <p>Why pay extra? See how ordering directly on HYST saves you money with zero commissions, no hidden
                    charges, and top food quality.</p>
            </div>

            <div class="table-responsive">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Platform & Quality Feature</th>
                            <th>Other Platforms</th>
                            <th class="hyst-col">HYST Direct</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Platform Commission</td>
                            <td>
                                <span class="indicator-bad">
                                    <span class="icon-cross">✕</span>
                                    Up to 30% Commission
                                </span>
                            </td>
                            <td>
                                <span class="indicator-good">
                                    <span class="icon-check">✓</span>
                                    0% Commission
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Hidden Charges & Extra Fees</td>
                            <td>
                                <span class="indicator-bad">
                                    <span class="icon-cross">✕</span>
                                    High Service & Admin Fees
                                </span>
                            </td>
                            <td>
                                <span class="indicator-good">
                                    <span class="icon-check">✓</span>
                                    Zero Hidden Fees
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Menu Pricing Markup</td>
                            <td>
                                <span class="indicator-bad">
                                    <span class="icon-cross">✕</span>
                                    Inflated Dish Prices
                                </span>
                            </td>
                            <td>
                                <span class="indicator-good">
                                    <span class="icon-check">✓</span>
                                    Direct Fair Pricing
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Dough Preparation</td>
                            <td>
                                <span class="indicator-bad">
                                    <span class="icon-cross">✕</span>
                                    Pre-made Dough
                                </span>
                            </td>
                            <td>
                                <span class="indicator-good">
                                    <span class="icon-check">✓</span>
                                    72-Hr Sourdough
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Fresh Daily Pasta</td>
                            <td>
                                <span class="indicator-bad">
                                    <span class="icon-cross">✕</span>
                                    Pre-boiled Dry Pasta
                                </span>
                            </td>
                            <td>
                                <span class="indicator-good">
                                    <span class="icon-check">✓</span>
                                    Handcrafted Daily
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Sauce Authenticity</td>
                            <td>
                                <span class="indicator-bad">
                                    <span class="icon-cross">✕</span>
                                    Tomato Paste Mix
                                </span>
                            </td>
                            <td>
                                <span class="indicator-good">
                                    <span class="icon-check">✓</span>
                                    100% DOP San Marzano
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Delivery Packaging</td>
                            <td>
                                <span class="indicator-bad">
                                    <span class="icon-cross">✕</span>
                                    Soggy Cardboard
                                </span>
                            </td>
                            <td>
                                <span class="indicator-good">
                                    <span class="icon-check">✓</span>
                                    Vented Thermal Box
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="section-padding" id="menu" style="background: rgba(27, 117, 131, 0.04);">
        <div class="container">
            <div class="text-center" style="max-width: 750px; margin: 0 auto;">
                <h2>Our Signature Italian Dishes 🍝</h2>
                <p>A taste of our bestselling handcrafted recipes. Explore full customization options when ordering on
                    HYST.</p>
            </div>

            <div class="menu-grid">
                <!-- Dish 1 -->
                <div class="menu-card">
                    <img src="https://images.unsplash.com/photo-1546549032-9571cd6b27df?auto=format&fit=crop&w=600&q=80"
                        alt="Truffle Pasta" class="menu-card-img">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <h3>Truffle Wild Mushroom Tagliatelle</h3>
                            <span class="menu-card-price">£14.50</span>
                        </div>
                        <p>Fresh artisan ribbon pasta in black truffle butter, sautéed wild mushrooms, 24-month
                            Parmigiano Reggiano, and fresh thyme.</p>
                        <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-secondary"
                            style="margin-top: auto; align-self: flex-start; padding: 8px 20px; font-size: 0.9rem;">Order
                            on HYST</a>
                    </div>
                </div>

                <!-- Dish 2 -->
                <div class="menu-card">
                    <img src="https://images.unsplash.com/photo-1534308983496-4fabb1a015ee?auto=format&fit=crop&w=600&q=80"
                        alt="Spicy Diablo Pizza" class="menu-card-img">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <h3>Diablo Spicy Salami Sourdough</h3>
                            <span class="menu-card-price">£13.90</span>
                        </div>
                        <p>72-hour sourdough, San Marzano tomatoes, fior di latte mozzarella, spicy Calabrian Nduja,
                            pepperoni, and hot chili honey drizzle.</p>
                        <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-secondary"
                            style="margin-top: auto; align-self: flex-start; padding: 8px 20px; font-size: 0.9rem;">Order
                            on HYST</a>
                    </div>
                </div>

                <!-- Dish 3 -->
                <div class="menu-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2uE-Cb7TKD14YFaPAUoN_w9UBprpDIryY4mjJJDruyA&s=10"
                        alt="Beef Shin Rigatoni" class="menu-card-img">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <h3>Slow-Braised Beef Shin Rigatoni</h3>
                            <span class="menu-card-price">£15.20</span>
                        </div>
                        <p>12-hour slow-cooked beef shin ragù with Chianti red wine, handmade tube rigatoni, and grated
                            Pecorino Romano.</p>
                        <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-secondary"
                            style="margin-top: auto; align-self: flex-start; padding: 8px 20px; font-size: 0.9rem;">Order
                            on HYST</a>
                    </div>
                </div>

                <!-- Dish 4 -->
                <div class="menu-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBQ2jD7fAnAK1C4axdb-yB_zNoGx_L5mXO8YyXmvWygA&s=10"
                        alt="Burrata Pesto Pasta" class="menu-card-img">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <h3>Pesto Genovese & Fresh Burrata</h3>
                            <span class="menu-card-price">£13.50</span>
                        </div>
                        <p>Hand-pounded Sicilian basil pesto, toasted pine nuts, creamy whole Italian Burrata cheese
                            over fresh trofie pasta.</p>
                        <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-secondary"
                            style="margin-top: auto; align-self: flex-start; padding: 8px 20px; font-size: 0.9rem;">Order
                            on HYST</a>
                    </div>
                </div>

                <!-- Dish 5 -->
                <div class="menu-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgkntVO3_OzqFPZtfnGgnT0xAUPND3tFC9ehajaIDRog&s=10"
                        alt="Garlic Dough Bites" class="menu-card-img">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <h3>Garlic & Rosemary Dough Bites</h3>
                            <span class="menu-card-price">£6.50</span>
                        </div>
                        <p>Fluffy sourdough dough balls brushed with warm garlic butter, sea salt, fresh rosemary,
                            served with marinara dip.</p>
                        <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-secondary"
                            style="margin-top: auto; align-self: flex-start; padding: 8px 20px; font-size: 0.9rem;">Order
                            on HYST</a>
                    </div>
                </div>

                <!-- Dish 6 -->
                <div class="menu-card">
                    <img src="https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?auto=format&fit=crop&w=600&q=80"
                        alt="Classic Tiramisu" class="menu-card-img">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <h3>Classic Italian Espresso Tiramisù</h3>
                            <span class="menu-card-price">£6.90</span>
                        </div>
                        <p>Layers of Italian Savoiardi ladyfingers soaked in dark espresso & Marsala wine, layered with
                            whipped mascarpone cream.</p>
                        <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-secondary"
                            style="margin-top: auto; align-self: flex-start; padding: 8px 20px; font-size: 0.9rem;">Order
                            on HYST</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container" id="faq">
        <div class="faq-section">
            <div class="text-center" style="max-width: 750px; margin: 0 auto;">
                <h2>Frequently Asked Questions 🤔</h2>
                <p>Everything you need to know about ordering authentic Italian food directly on HYST.</p>
            </div>

            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>1. How do I order authentic Italian food online from HYST?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        Simply click any "Order on HYST" button on this landing page. You will be directed to our
                        official ordering page where you can pick your pizzas, pastas, appetizers, and drinks, customize
                        toppings, and check out securely.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>2. Why is sourdough fermented for 72 hours better for pizza dough?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        A slow 72-hour cold fermentation gives natural wild yeast time to digest complex carbohydrates
                        and gluten proteins. This produces a light, airy, blistered pizza crust that is delicious and
                        much easier to digest.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>3. Are there Vegan and Gluten-Free Italian menu options available?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        Yes! We offer vegan sourdough pizzas with dairy-free artisan mozzarella, plant-based pasta
                        options, and certified gluten-free pasta substitutes upon request.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>4. How fast will my food arrive when I order on HYST?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        Average delivery times are between 25 and 40 minutes. We utilize vented heat-locking thermal
                        boxes so your pizza crust remains crisp and your pasta arrives piping hot.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>5. Does HYST offer special discounts for group and squad orders?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        Yes! We feature special "Squad Feast Bundles" designed for groups of 2 to 10+ people. These
                        bundles save you up to 25% compared to purchasing dishes individually.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>6. Where do you source your ingredients from?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        We import DOP San Marzano tomatoes from Campania, Extra Virgin Olive Oil from Puglia, and Fior
                        di Latte Mozzarella from Italy, while pairing them with fresh local produce.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>7. Is your pasta fresh or pre-packaged dry pasta?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        Our pasta is handcrafted fresh every morning in our kitchen using durum wheat semolina, fresh
                        free-range eggs, and pure water for authentic al dente bite.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>8. Can I customize my pizza toppings or pasta sauce on HYST?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        Yes, our HYST online ordering system lets you add extra cheeses, fresh burrata, spicy nduja,
                        prosciutto, or substitute sauces according to your dietary preferences.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>9. What are your operational and delivery hours?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        We operate 7 days a week from 11:30 AM to 11:00 PM, with extended late-night delivery until 2:00
                        AM on Fridays and Saturdays via HYST.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>10. Can I pre-order Italian food for a party or event in advance?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        Yes, you can schedule pre-orders up to 7 days in advance through HYST by selecting your desired
                        delivery date and time slot at checkout.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="container" style="margin-bottom: 80px;">
        <div
            style="background: linear-gradient(135deg, var(--color-teal), var(--color-teal-dark)); border-radius: var(--radius-lg); padding: 60px 30px; text-align: center; color: white; box-shadow: var(--shadow);">
            <h2 style="color: white; font-size: 2.5rem;">Craving Authentic Italian Tonight?</h2>
            <p style="color: #EBF5F6; max-width: 600px; margin: 15px auto 30px; font-size: 1.15rem;">Fresh handmade
                pasta, sourdough wood-fired pizzas, and classic desserts are just a click away.</p>
            <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-hyst"
                style="font-size: 1.15rem; padding: 16px 42px;">Order Now on HYST 🍕🍝</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="#" class="logo" style="margin-bottom: 15px; display: inline-block;">
                        <span>ITALIAN</span>
                    </a>
                    <p style="font-size: 0.9rem; color: #A0AAB0;">Delivering true Italian food craft: 72-hour sourdough
                        pizzas, fresh handcrafted daily pasta, and authentic imported ingredients.</p>
                </div>

                <div class="footer-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#about">About Our Craft</a></li>
                        <li><a href="#genz-squad">Squad Feasts</a></li>
                        <li><a href="#calculator">Price Calculator</a></li>
                        <li><a href="#compare">Why HYST?</a></li>
                        <li><a href="#menu">Signature Menu</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Top Favorites</h4>
                    <ul>
                        <li><a href="https://hyst.uk/restaurant/italian-restaurant">Sourdough Diablo Pizza</a></li>
                        <li><a href="https://hyst.uk/restaurant/italian-restaurant">Truffle Wild Mushroom
                                Tagliatelle</a></li>
                        <li><a href="https://hyst.uk/restaurant/italian-restaurant">Beef Shin Rigatoni</a></li>
                        <li><a href="https://hyst.uk/restaurant/italian-restaurant">Espresso Tiramisù</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Direct HYST Delivery</h4>
                    <p style="font-size: 0.9rem; color: #A0AAB0; margin-bottom: 15px;">Fast order tracking, zero
                        inflated delivery app markups, and exclusive rewards on HYST.</p>
                    <a href="https://hyst.uk/restaurant/italian-restaurant" class="btn-hyst"
                        style="font-size: 0.9rem; padding: 10px 22px;">Order on HYST</a>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2026 Italian Restaurant. All Rights Reserved. Fully Optimized for SEO, AEO & GEO Search
                    Engines.</p>
            </div>
        </div>
    </footer>

    <!-- Interactive JS Script -->
    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        function closeMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.remove('active');
        }

        function calculateSavings(val) {
            const people = parseInt(val) || 1;

            // Update UI Slider Text
            document.getElementById('peopleCountText').innerText = people + (people === 1 ? ' Person' : ' People');

            // Calculation logic
            const basePricePerPerson = 9.50;
            const hystTotal = people * basePricePerPerson;

            // Other platforms calculation: 30% commission markup + £3.99 delivery fee + £1.50 service/hidden fee
            const otherTotal = (hystTotal * 1.30) + 3.99 + 1.50;
            const savings = otherTotal - hystTotal;

            // Render Output
            document.getElementById('hystPrice').innerText = '£' + hystTotal.toFixed(2);
            document.getElementById('otherPrice').innerText = '£' + otherTotal.toFixed(2);
            document.getElementById('savingsTag').innerText = '🎉 Total Savings on HYST: £' + savings.toFixed(2);

            let itemsText = `${Math.ceil(people * 0.5)} Sourdough Pizzas, ${Math.floor(people * 0.5)} Handcrafted Pastas`;
            if (people > 4) {
                itemsText += `, Starters & Drinks for ${people} people!`;
            } else {
                itemsText += ` & Garlic Dough Bites.`;
            }

            document.getElementById('calcDetails').innerText = `Includes ${itemsText}`;
        }

        function toggleFaq(element) {
            const item = element.parentElement;
            const isActive = item.classList.contains('active');

            document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('active'));

            if (!isActive) {
                item.classList.add('active');
            }
        }

        // Initialize calculation on page load
        calculateSavings(4);
    </script>
</body>

</html>