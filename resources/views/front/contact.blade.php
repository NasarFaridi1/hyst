@extends('front.layouts.app')

@section('content')
<main style="background: #F5F5F0; min-height: 80vh; padding: 40px 0 60px;">
    <div class="mx-auto max-w-5xl" style="padding: 0 24px;">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 20px;">
            <ol style="display: flex; gap: 8px; font-size: 13px; color: #6B7280; list-style: none; padding: 0;">
                <li><a href="/" style="color: #6B7280; text-decoration: none;">Home</a></li>
                <li>/</li>
                <li style="color: #C25A2A; font-weight: 600;">Contact Us</li>
            </ol>
        </nav>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">

            <!-- Contact Information -->
            <div class="card" style="padding: 36px; background: #ffffff;">
                <span class="badge-primary" style="margin-bottom: 12px; display: inline-block;">GET IN TOUCH</span>
                <h1 style="font-size: 28px; font-weight: 800; color: #0D0D0D; margin-bottom: 16px;">
                    Contact HYST Hounslow
                </h1>
                <p style="font-size: 14.5px; color: #4B5563; line-height: 1.6; margin-bottom: 28px;">
                    Have questions about restaurant partnerships, orders, or support in Hounslow & West London? We are here to help.
                </p>

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; background: #FFF0EC; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-lucide="map-pin" style="width: 20px; height: 20px; color: #C25A2A;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 15px; font-weight: 700; color: #0D0D0D; margin-bottom: 2px;">Headquarters / Location</h3>
                            <p style="font-size: 13.5px; color: #6B7280; margin: 0;">Hounslow, London, TW3 2DX, United Kingdom</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; background: #FFF0EC; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-lucide="mail" style="width: 20px; height: 20px; color: #C25A2A;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 15px; font-weight: 700; color: #0D0D0D; margin-bottom: 2px;">Email Inquiries</h3>
                            <p style="font-size: 13.5px; color: #6B7280; margin: 0;">info@hyst.uk</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; background: #FFF0EC; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-lucide="phone" style="width: 20px; height: 20px; color: #C25A2A;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 15px; font-weight: 700; color: #0D0D0D; margin-bottom: 2px;">Phone & WhatsApp</h3>
                            <p style="font-size: 13.5px; color: #6B7280; margin: 0;">+44 7879 175585</p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #F0F0EC;">
                    <button onclick="openPartnerModal()" class="btn-primary" style="width: 100%; padding: 12px; text-align: center; border: none;">
                        Become a Partner Request
                    </button>
                </div>
            </div>

            <!-- Quick Direct Form -->
            <div class="card" style="padding: 36px; background: #ffffff;">
                <h2 style="font-size: 22px; font-weight: 700; color: #0D0D0D; margin-bottom: 16px;">
                    Send Us a Message
                </h2>
                <form action="/offers/contact" method="POST">
                    @csrf
                    <div style="margin-bottom: 16px;">
                        <label for="contact-name">Your Full Name *</label>
                        <input type="text" id="contact-name" name="name" required placeholder="Enter your name">
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label for="contact-email">Email Address *</label>
                        <input type="email" id="contact-email" name="email" required placeholder="name@example.com">
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label for="contact-phone">Phone Number</label>
                        <input type="tel" id="contact-phone" name="phone" placeholder="+44 7123 456789">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label for="contact-message">Message *</label>
                        <textarea id="contact-message" name="message" rows="4" required placeholder="How can we help you?"></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; border: none; font-size: 14px;">
                        Send Message
                    </button>
                </form>
            </div>

        </div>

    </div>
</main>
@endsection
