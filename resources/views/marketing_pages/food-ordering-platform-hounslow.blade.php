@extends('front.layouts.app')

@section('title', 'Takeaway & Food Delivery Near Me | Dine In Hounslow TW3 | HYST')
@section('meta_description', 'Find top takeaways, food delivery near me & dine in restaurants in Hounslow, London TW3. Order direct on HYST with zero commission & genuine menu prices.')
@section('keywords', 'takeaway near me, food delivery near me, dine in Hounslow, ordering platform Hounslow, takeaway Hounslow TW3, food ordering Hounslow, HYST')

@section('ld_json')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Service",
    "serviceType": "Takeaway, Dine In & Food Delivery Platform",
    "provider": {
        "@type": "LocalBusiness",
        "name": "HYST Hounslow",
        "image": "https://hyst.uk/social-share.jpeg",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Hounslow",
            "addressLocality": "London",
            "postalCode": "TW3 2DX",
            "addressCountry": "GB"
        },
        "telephone": "+44 7879 175585"
    },
    "areaServed": {
        "@type": "City",
        "name": "Hounslow",
        "sameAs": "https://en.wikipedia.org/wiki/Hounslow"
    },
    "description": "Zero-commission takeaway, dine in, and food delivery platform serving Hounslow, London TW3."
}
</script>
@endsection

@section('content')
<div style="background: linear-gradient(135deg, #0D0D0D 0%, #1A1A1A 100%); color: #fff; padding: 70px 24px; text-align: center;">
    <div style="max-width: 900px; margin: 0 auto;">
        <span style="background: rgba(194, 90, 42, 0.2); color: #C25A2A; font-weight: 700; padding: 6px 16px; border-radius: 50px; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 16px;">
            Hounslow, London TW3 Takeaway & Dine In
        </span>
        <h1 style="font-size: 38px; font-weight: 800; margin-bottom: 16px; line-height: 1.2;">
            Takeaway & Food Delivery Near Me in Hounslow, TW3 (Dine In & Direct Order)
        </h1>
        <p style="font-size: 18px; color: #D1D5DB; margin-bottom: 32px; max-width: 750px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            Order directly from your favourite local Hounslow restaurants & takeaways at genuine menu prices — with no hidden 30% delivery app markups or extra fees.
        </p>
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="/restaurants" style="background: #C25A2A; color: #fff; font-weight: 700; padding: 14px 32px; border-radius: 12px; text-decoration: none; display: inline-block; font-size: 16px; transition: background 0.2s;">
                Browse Hounslow Restaurants
            </a>
            <a href="/become-a-partner" style="background: rgba(255,255,255,0.1); color: #fff; font-weight: 600; padding: 14px 28px; border-radius: 12px; text-decoration: none; display: inline-block; font-size: 16px; border: 1px solid rgba(255,255,255,0.2);">
                Register Hounslow Restaurant
            </a>
        </div>
    </div>
</div>

<div style="max-width: 1100px; margin: 60px auto; padding: 0 24px;">
    <h2 style="font-size: 28px; font-weight: 800; color: #0D0D0D; margin-bottom: 24px; text-align: center;">
        Why Hounslow Residents & Restaurants Choose HYST
    </h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 36px;">
        <div style="background: #FFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <div style="font-size: 32px; margin-bottom: 12px;">💰</div>
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 10px; color: #0D0D0D;">Cheaper Takeaway Prices</h3>
            <p style="color: #4B5563; font-size: 15px; line-height: 1.6;">
                Because HYST charges zero commission to restaurants, Hounslow food spots display their real, un-marked-up menu prices. Save up to 25% on every order!
            </p>
        </div>

        <div style="background: #FFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <div style="font-size: 32px; margin-bottom: 12px;">🚀</div>
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 10px; color: #0D0D0D;">Fast Local Delivery</h3>
            <p style="color: #4B5563; font-size: 15px; line-height: 1.6;">
                Powered by automated local driver dispatch and Uber Direct, your food arrives hot, fresh, and on time across Hounslow, Heston, Isleworth, and Feltham.
            </p>
        </div>

        <div style="background: #FFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <div style="font-size: 32px; margin-bottom: 12px;">🤝</div>
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 10px; color: #0D0D0D;">Support Hounslow Businesses</h3>
            <p style="color: #4B5563; font-size: 15px; line-height: 1.6;">
                Big aggregator apps take 30%+ from local Hounslow takeaways. HYST lets 100% of your food payment go directly to the hard-working local restaurant staff.
            </p>
        </div>
    </div>
</div>
@endsection
