@extends('front.layouts.app')

@section('content')

<section class="hero-banner"
    style="position:relative; min-height:250px; display:flex; align-items:center; overflow:hidden; background:#0D0D0D;">

    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070"
        style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">

    <div
        style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(13,13,13,.92) 0%, rgba(13,13,13,.65) 55%, rgba(13,13,13,.30) 100%);">
    </div>

    <div style="position:relative; max-width:1280px; margin:auto; width:100%; padding:20px;">

        <div
            style="display:inline-flex; align-items:center; gap:10px; background:rgba(194,90,42,.15); border:1px solid rgba(194,90,42,.4); padding:8px 18px; border-radius:50px; margin-bottom:20px;">
            <i class="fas fa-question-circle" style="color:#fff;"></i>
            <span style="color:#fff;font-size:13px;font-weight:600;">Need Help?</span>
        </div>

        <h1
            style="font-size:48px;font-weight:800;color:#fff;font-family:'Poppins',sans-serif;margin-bottom:15px;">
            Frequently <span style="color:#C25A2A;">Asked Questions</span>
        </h1>

        <p style="color:#D1D5DB;font-size:16px;max-width:700px;line-height:1.8;">
            Find answers to common questions — whether you're ordering food as a
            customer or partnering with us as a restaurant.
        </p>

    </div>

</section>


<section style="background:#fff;padding:80px 20px;">

    <div style="max-width:1000px;margin:auto;">

        <div style="text-align:center;margin-bottom:40px;">
            <h2
                style="font-size:38px;font-weight:700;color:#111;font-family:'Poppins',sans-serif;margin-bottom:15px;">
                How can we help you?
            </h2>

            <p style="color:#A1A1AA;font-size:16px;line-height:1.8;">
                Choose a category below to see the most relevant questions.
            </p>
        </div>

        <!-- Tab Switcher -->
        <div style="display:flex;justify-content:center;gap:16px;margin-bottom:40px;flex-wrap:wrap;">

            <button class="faq-tab-btn active" data-tab="customer"
                style="padding:14px 32px;border-radius:50px;border:1px solid #C25A2A;background:#C25A2A;color:#fff;font-weight:600;font-size:15px;cursor:pointer;font-family:'Poppins',sans-serif;">
                For Customers
            </button>

            <button class="faq-tab-btn" data-tab="restaurant"
                style="padding:14px 32px;border-radius:50px;border:1px solid #C25A2A;background:transparent;color:#C25A2A;font-weight:600;font-size:15px;cursor:pointer;font-family:'Poppins',sans-serif;">
                For Restaurants
            </button>

        </div>


        <!-- ===================== CUSTOMER FAQs ===================== -->
        <div class="faq-panel" id="panel-customer" style="display:block;">

            <div class="accordion" id="faqAccordionCustomer">

                <!-- 1 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Why are your prices lower than food delivery apps?</button>
                    <div class="faq-content active">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            We never charge restaurants high commissions. Because restaurants don't
                            pay excessive fees, they can offer their actual menu prices to customers.
                        </div>
                    </div>
                </div>

                <!-- 2 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Do restaurants decide their own prices?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Yes. Restaurants manage their own menus and prices. We simply display
                            their genuine menu pricing without additional markups.
                        </div>
                    </div>
                </div>

                <!-- 3 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Is online payment secure?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Absolutely. All payments on HYST are processed through <strong>Worldpay</strong> (<a href="https://platforms.worldpay.com/en" target="_blank" rel="noopener noreferrer" style="color:#C25A2A; text-decoration:underline;">platforms.worldpay.com</a>), a global payment processing leader. Every transaction uses end-to-end encryption and PCI DSS compliance to ensure your payment details are completely safe and protected.
                        </div>
                    </div>
                </div>

                <!-- 4 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">How does food delivery work with Uber Direct?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Our doorstep deliveries are powered by <strong>Uber Direct</strong> (<a href="https://merchants.uber.com/uber-direct.html" target="_blank" rel="noopener noreferrer" style="color:#fff; text-decoration:underline; font-weight:bold;">merchants.uber.com/uber-direct.html</a>). Once the restaurant prepares your order, a dedicated Uber courier picks up your meal and delivers it straight to your doorstep with real-time GPS tracking.
                        </div>
                    </div>
                </div>

                <!-- 5 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Can I cancel my order?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Orders can be cancelled only before the restaurant starts preparing
                            your food. Once preparation begins, cancellation may not be possible.
                        </div>
                    </div>
                </div>

                <!-- 6 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">What payment methods do you accept?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Through Worldpay, we accept all major debit and credit cards, along with popular digital wallet payments, so you can check out smoothly and securely.
                        </div>
                    </div>
                </div>

                <!-- 7 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Can I track my order in real time?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Yes. Thanks to Uber Direct's delivery tracking system, you can follow your order live from kitchen preparation all the way to your doorstep.
                        </div>
                    </div>
                </div>

                <!-- 8 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">What if my order arrives incorrect or late?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            If there's an issue with your order, contact our support team right
                            away through the Contact Us page, email, or phone, and we'll help
                            resolve it as quickly as possible.
                        </div>
                    </div>
                </div>

                <!-- 9 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;overflow:hidden;">
                    <button class="faq-btn">How do I contact customer support?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            You can reach our support team through the Contact Us page, email,
                            or phone. We are happy to assist with any issue.
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <!-- ===================== RESTAURANT FAQs ===================== -->
        <div class="faq-panel" id="panel-restaurant" style="display:none;">

            <div class="accordion" id="faqAccordionRestaurant">

                <!-- 1 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Do you charge restaurants commission?</button>
                    <div class="faq-content active">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            No. Our platform follows a zero-commission model, helping restaurants
                            earn more while customers enjoy fair menu prices.
                        </div>
                    </div>
                </div>

                <!-- 2 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">How do I list my restaurant on the platform?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Simply get in touch with our team through the Contact Us page, and
                            we'll guide you through onboarding your restaurant and menu.
                        </div>
                    </div>
                </div>

                <!-- 3 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Can I set and update my own menu prices?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Yes. You have full control over your menu items, pricing, and
                            availability, and can update them at any time.
                        </div>
                    </div>
                </div>

                <!-- 4 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">How do I receive and manage orders?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Orders come through in real time to your restaurant dashboard, where
                            you can accept, prepare, and update the status of each order.
                        </div>
                    </div>
                </div>

                <!-- 5 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">How does payment processing & payout work with Worldpay?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            HYST integrates directly with <strong>Worldpay</strong> (<a href="https://platforms.worldpay.com/en" target="_blank" rel="noopener noreferrer" style="color:#C25A2A; text-decoration:underline;">platforms.worldpay.com</a>) for enterprise payment processing. Customer payments are verified instantly and earnings are deposited directly into your designated account on a reliable payout schedule with full transparency and zero commission fees.
                        </div>
                    </div>
                </div>

                <!-- 6 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">How does delivery dispatch work with Uber Direct?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            You don't need to hire or manage your own delivery drivers! Our partnership with <strong>Uber Direct</strong> (<a href="https://merchants.uber.com/uber-direct.html" target="_blank" rel="noopener noreferrer" style="color:#fff; text-decoration:underline; font-weight:bold;">merchants.uber.com/uber-direct.html</a>) automatically dispatches an Uber courier as soon as order preparation starts, delivering meals fast and hot to your customers.
                        </div>
                    </div>
                </div>

                <!-- 7 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Is there a signup or listing fee?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            There's no cost to list your restaurant. Our goal is to help
                            restaurants grow without extra fees eating into their earnings.
                        </div>
                    </div>
                </div>

                <!-- 8 -->
                <div style="background:#C25A2A;border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:18px;overflow:hidden;">
                    <button class="faq-btn">Can I pause or stop taking orders temporarily?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Yes. You can mark your restaurant as temporarily closed or unavailable
                            directly from your dashboard whenever needed, such as during busy
                            periods or holidays.
                        </div>
                    </div>
                </div>

                <!-- 9 -->
                <div style="background:#181818;border:1px solid rgba(255,255,255,.08);border-radius:14px;overflow:hidden;">
                    <button class="faq-btn">What support do you provide restaurant partners?</button>
                    <div class="faq-content">
                        <div style="padding:0 25px 22px;color:#fff;font-size:15px;line-height:1.9;">
                            Our partner support team is available to help with onboarding, menu
                            setup, order issues, and any other questions you may have.
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>


<section style="padding:80px 20px;background:linear-gradient(135deg,#1A1A1A,#0D0D0D);">

    <div style="max-width:900px;margin:auto;text-align:center;
        border:1px solid rgba(194,90,42,.25);
        background:#181818;
        padding:60px 40px;
        border-radius:18px;">

        <h2 style="font-size:38px;
            color:#fff;
            font-weight:700;
            margin-bottom:18px;
            font-family:'Poppins',sans-serif;">
            Still have questions?
        </h2>

        <p style="color:#D1D5DB;
            font-size:16px;
            line-height:1.8;
            margin-bottom:40px;">
            Our support team is always ready to help you with orders,
            restaurants, payments, or any other queries.
        </p>

        <div style="display:flex;
            flex-wrap:wrap;
            justify-content:center;
            gap:25px;">

            <!-- Address -->
            <div style="flex:1;min-width:250px;background:#111;padding:25px;border-radius:14px;border:1px solid rgba(194,90,42,.15);">
                <div style="display:flex;justify-content:center;align-items:center;margin-bottom:15px;">
                    <i data-lucide="map-pin" style="width:28px;height:28px;color:#C25A2A;margin-bottom:15px;"></i>
                </div>
                <h5 style="color:#fff;font-weight:600;margin-bottom:10px;">Address</h5>

                <p style="color:#BDBDBD;margin:0;line-height:1.8;">
                    Hounslow, London<br>
                    United Kingdom<br>
                    TW3 2DX
                </p>
            </div>

            <!-- Phone -->
            <div style="flex:1;min-width:220px;background:#111;padding:25px;border-radius:14px;border:1px solid rgba(194,90,42,.15);">
                <div style="display:flex;justify-content:center;align-items:center;margin-bottom:15px;">
                    <i data-lucide="phone-call" style="width:28px;height:28px;color:#C25A2A;margin-bottom:15px;"></i>
                </div>
                <h5 style="color:#fff;font-weight:600;margin-bottom:10px;">Phone</h5>

                <a href="tel:+447879175585"
                    style="color:#BDBDBD;text-decoration:none;font-size:16px;">
                    +44 7879 175585
                </a>
            </div>

            <!-- Email -->
            <div style="flex:1;min-width:220px;background:#111;padding:25px;border-radius:14px;border:1px solid rgba(194,90,42,.15);">
                <div style="display:flex;justify-content:center;align-items:center;margin-bottom:15px;">
                    <i data-lucide="mail" style="width:28px;height:28px;color:#C25A2A;margin-bottom:15px;"></i>
                </div>
                <h5 style="color:#fff;font-weight:600;margin-bottom:10px;">Email</h5>

                <a href="mailto:info@hyst.uk"
                    style="color:#BDBDBD;text-decoration:none;font-size:16px;">
                    info@hyst.uk
                </a>
            </div>

        </div>

    </div>

</section>

<style>
.faq-btn{
    width:100%;
    padding:22px 25px;
    border:none;
    background:none;
    color:#fff;
    font-size:18px;
    font-weight:600;
    text-align:left;
    cursor:pointer;
    box-shadow:none;
}

.faq-content{
    display:none;
    padding:0 25px 22px;
    color:#fff;
    line-height:1.8;
}

.faq-content.active{
    display:block;
}

.faq-tab-btn:hover{
    opacity:.9;
}
</style>

<script>
// Accordion behavior (per-panel so both tabs work independently)
document.querySelectorAll('.faq-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
        const content = this.nextElementSibling;
        const panel = this.closest('.faq-panel');

        panel.querySelectorAll('.faq-content').forEach(function(item){
            if(item !== content){
                item.classList.remove('active');
            }
        });

        content.classList.toggle('active');
    });
});

// Tab switcher
document.querySelectorAll('.faq-tab-btn').forEach(function(tabBtn){
    tabBtn.addEventListener('click', function(){
        const target = this.dataset.tab;

        document.querySelectorAll('.faq-tab-btn').forEach(function(b){
            b.classList.remove('active');
            b.style.background = 'transparent';
            b.style.color = '#C25A2A';
        });
        this.classList.add('active');
        this.style.background = '#C25A2A';
        this.style.color = '#fff';

        document.querySelectorAll('.faq-panel').forEach(function(panel){
            panel.style.display = 'none';
        });
        document.getElementById('panel-' + target).style.display = 'block';
    });
});
</script>
@endsection