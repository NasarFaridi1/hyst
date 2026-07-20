@extends('front.layouts.app')

@section('content')
<section style="
    background:rgba(245,240,232,0.95);
    min-height:100vh;
    padding:60px 20px;
">

    <div style="max-width:1000px;margin:auto;">

        <div style="text-align:center;margin-bottom:40px;">

            <h1 style="
                font-size:42px;
                font-weight:800;
                color:#111827;
                font-family:'Syne',sans-serif;
                margin-bottom:15px;
            ">
                Refund & Cancellation Policy
            </h1>

            <p style="
                color:#6B7280;
                font-size:18px;
            ">
                Effective Date: <strong>1st October 2025</strong>
            </p>

        </div>

        <div style="
            background:#fff;
            border-radius:24px;
            padding:50px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
            border:1px solid #F1F1F1;
        ">

            <p>
                At Hyst.uk, we aim to provide a smooth and reliable online food
                ordering experience by connecting customers with registered
                restaurants. This Refund & Cancellation Policy explains order
                cancellations, refund eligibility, and how refund requests are
                handled through our platform.
            </p>

            <div style="
                background:#FFF7ED;
                border-left:5px solid #E63946;
                padding:20px;
                border-radius:12px;
                margin:30px 0;
            ">
                <h3 style="margin:0 0 10px;color:#111827;">
                    Platform Overview
                </h3>

                <p style="margin:0;">
                    Hyst.uk operates as an online restaurant ordering platform
                    where customers can discover restaurants, browse menus,
                    and place orders through app.hyst.uk.
                </p>
            </div>

            <div class="policy-section">

                <h2>Key Terms</h2>

                <ul>
                    <li><strong>Customer</strong> — Any person placing food orders through Hyst.uk or app.hyst.uk.</li>
                    <li><strong>Restaurant Partner</strong> — A restaurant registered on Hyst.uk.</li>
                    <li><strong>Order</strong> — Food items purchased through our platform.</li>
                    <li><strong>Payment</strong> — Amount paid online for food orders and applicable charges.</li>
                </ul>

                <h2>Order Cancellation Policy</h2>

                <p>
                    Customers may cancel an order only before the restaurant
                    accepts or starts preparing the order.
                </p>

                <p>
                    Once food preparation has started, cancellation may not be
                    possible and refund eligibility may be limited.
                </p>

                <ul>
                    <li>Restaurant item unavailability</li>
                    <li>Incorrect pricing or menu information</li>
                    <li>Payment verification failure</li>
                    <li>Delivery service limitations</li>
                    <li>Unexpected operational issues</li>
                </ul>

                <h2>Refund Policy</h2>

                <p>Refunds may be considered if:</p>

                <ul>
                    <li>Payment was deducted but the order was not confirmed.</li>
                    <li>The restaurant cancelled the order.</li>
                    <li>Ordered items became unavailable.</li>
                    <li>Duplicate payment occurred.</li>
                    <li>A verified service issue occurred.</li>
                </ul>

                <p>
                    Refund requests are reviewed by Hyst.uk support and processed
                    according to payment provider timelines.
                </p>

                <h2>Non-Refundable Cases</h2>

                <ul>
                    <li>Incorrect delivery address provided.</li>
                    <li>Customer unavailable during delivery.</li>
                    <li>Customer changes mind after preparation starts.</li>
                    <li>Delays outside platform control.</li>
                    <li>Incorrect order placed by customer.</li>
                </ul>

                <h2>Restaurant Partner Responsibility</h2>

                <p>
                    Restaurants are responsible for maintaining accurate menus,
                    prices, food availability, preparation standards, packaging,
                    and order fulfilment.
                </p>

                <p>
                    Complaints relating to food quality, ingredients, or hygiene
                    may require investigation before refund approval.
                </p>

                <h2>Refund Request Process</h2>

                <p>
                    To request a refund, please provide:
                </p>

                <ul>
                    <li>Full Name</li>
                    <li>Email Address or Phone Number</li>
                    <li>Order ID / Transaction Reference</li>
                    <li>Restaurant Name</li>
                    <li>Reason for Refund Request</li>
                    <li>Supporting Images (if applicable)</li>
                </ul>

                <p>
                    Our support team aims to respond within 7 working days.
                </p>

                <h2>Payment Issues</h2>

                <p>
                    If payment is deducted but your order is unsuccessful,
                    please contact support for verification and refund review.
                </p>

                <h2>Policy Updates</h2>

                <div style="
                    background:#F9FAFB;
                    border-left:4px solid #111827;
                    padding:18px;
                    border-radius:12px;
                ">
                    Hyst.uk may update this Refund & Cancellation Policy from
                    time to time. The latest version published on our website
                    will always apply.
                </div>

                <h2>Contact Us</h2>

                <div style="
                    background:#F9FAFB;
                    border-radius:16px;
                    padding:20px;
                    margin-top:15px;
                ">
                    <strong>Website:</strong> www.hyst.uk<br>
                    <strong>Application:</strong> app.hyst.uk
                </div>

            </div>

        </div>

    </div>

</section>

<style>
.policy-section h2{
    font-size:24px;
    margin-top:40px;
    margin-bottom:15px;
    color:#111827;
    font-family:'Syne',sans-serif;
    font-weight:700;
}

.policy-section p{
    color:#4B5563;
    line-height:1.9;
    margin-bottom:15px;
}

.policy-section ul{
    padding-left:20px;
    margin-bottom:20px;
}

.policy-section li{
    color:#4B5563;
    line-height:1.9;
    margin-bottom:10px;
}

@media(max-width:768px){

    .policy-section h2{
        font-size:20px;
    }

    .policy-section{
        font-size:14px;
    }

    div[style*="padding:50px"]{
        padding:25px !important;
    }
}
</style>

@endsection
