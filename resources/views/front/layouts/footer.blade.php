<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<footer style="background:#0D0D0D; color:#fff; margin-top:80px;">
    <div style="max-width:1280px; margin:0 auto; padding:60px 24px 36px;">

        <div class="footer-grid" style="display:grid; grid-template-columns: 1.8fr 1fr 1fr 1.2fr 1.2fr; gap:36px; margin-bottom:48px;">

            <!-- BRAND -->
            <div>
                <a href="/" style="display:flex; align-items:center; gap:10px; text-decoration:none; margin-bottom:16px;">
                    <div style="width:38px; height:38px; background:#C25A2A; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i data-lucide="utensils" style="color:#fff; width:20px; height:20px;"></i>
                    </div>
                    <span style="font-family:'Poppins',sans-serif; font-weight:800; font-size:20px; letter-spacing:-.3px;">
                        HYST
                    </span>
                </a>
                <p style="color:#9CA3AF; line-height:1.8; font-size:14px; max-width:260px; margin-bottom:24px;">
                    Premium food delivery from the best restaurants. Fresh, fast, and always delicious.
                </p>
                <div style="display:flex; gap:10px;">
                    <a href="https://www.instagram.com/hyst722/" target="_blank" rel="noopener noreferrer"
                    style="width:38px;height:38px;border:1px solid #2A2A2A;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-brands fa-instagram" style="color:#9CA3AF;font-size:16px;"></i>
                    </a>

                    <a href="https://www.tiktok.com/@hyst829" target="_blank" rel="noopener noreferrer"
                    style="width:38px;height:38px;border:1px solid #2A2A2A;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-brands fa-tiktok" style="color:#9CA3AF;font-size:16px;"></i>
                    </a>

                    <a href="https://www.facebook.com/profile.php?id=61592088563196" target="_blank"
                    style="width:38px;height:38px;border:1px solid #2A2A2A;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-brands fa-facebook-f" style="color:#9CA3AF;font-size:16px;"></i>
                    </a>

                    <a href="https://linkedin.com/" target="_blank"
                    style="width:38px;height:38px;border:1px solid #2A2A2A;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-brands fa-linkedin-in" style="color:#9CA3AF;font-size:16px;"></i>
                    </a>
                </div>
            </div>

            <!-- QUICK LINKS -->
            <div>
                <h4 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:14px; margin-bottom:20px; color:#fff; letter-spacing:.02em;">Quick Links</h4>
                <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
                    <li><a href="/" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Home
                    </a></li>
                    <li><a href="{{ route('front.banners.index') }}" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i>Business Categories
                    </a></li>
                    {{-- <li><a href="#products" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Products
                    </a></li> --}}
                    <li><a href="/my-orders" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> My Orders
                    </a></li>
                    <li><a href="{{ route('terms.conditions') }}" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Terms & Conditions
                    </a></li>
                    <li><a href="{{ route('privacy.policy') }}" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Privacy Policy
                    </a></li>

                    
                </ul>
            </div>

            <!-- ACCOUNT -->
            <div>
                <h4 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:14px; margin-bottom:20px; color:#fff; letter-spacing:.02em;">Account</h4>
                <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
                    <li><a href="/login" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Login
                    </a></li>
                    <li><a href="/register" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Register
                    </a></li>
                    <li><a href="/dashboard" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Dashboard
                    </a></li>
                    <li><a href="/profile" style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                           onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#9CA3AF'">
                        <i data-lucide="chevron-right" style="width:13px; height:13px;"></i> Profile
                    </a></li>
                    <li>
                        <a href="{{ route('faqs') }}"
                            style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                            onmouseover="this.style.color='#C25A2A'"
                            onmouseout="this.style.color='#9CA3AF'">
                            <i data-lucide="circle-help" style="width:13px; height:13px;"></i>
                            FAQs
                        </a>
                    </li>
                </ul>
            </div>

            <!-- PARTNERSHIPS -->
            <div>
                <h4 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:14px; margin-bottom:20px; color:#fff; letter-spacing:.02em;">Partner With Us</h4>
                <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
                    <li>
                        <a href="{{ route('front.become.partner.page') }}"
                            style="color:#C25A2A; font-weight:700; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                            onmouseover="this.style.color='#fff'"
                            onmouseout="this.style.color='#C25A2A'">
                            <i data-lucide="store" style="width:14px; height:14px;"></i>
                            Become Restaurant Partner
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.become.ambassador') }}"
                            style="color:#C25A2A; font-weight:700; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                            onmouseover="this.style.color='#fff'"
                            onmouseout="this.style.color='#C25A2A'">
                            <i data-lucide="award" style="width:14px; height:14px;"></i>
                            HYST Ambassador Programme
                        </a>
                    </li>
                    @php
                        $slug = request()->route('slug');
                    @endphp

                    @if($slug)
                        <li>
                            <a href="{{ route('policy', $restaurant->slug) }}"
                            style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                            onmouseover="this.style.color='#C25A2A'"
                            onmouseout="this.style.color='#9CA3AF'">
                                <i data-lucide="chevron-right" style="width:13px; height:13px;"></i>
                                Restaurant Privacy Policy
                            </a>
                        </li>
                    @endif
                    @if($slug)
                        <li>
                            <a href="{{ route('restaurant.terms', $slug) }}"
                            style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                            onmouseover="this.style.color='#C25A2A'"
                            onmouseout="this.style.color='#9CA3AF'">
                                <i data-lucide="chevron-right" style="width:13px; height:13px;"></i>
                                Restaurant Terms & Conditions
                            </a>
                        </li>
                    @endif
                    @if($slug)
                        <li>
                            <a href="{{ route('restaurant.refund-policy', $slug) }}"
                            style="color:#9CA3AF; text-decoration:none; font-size:14px; transition:color .15s; display:flex; align-items:center; gap:6px;"
                            onmouseover="this.style.color='#C25A2A'"
                            onmouseout="this.style.color='#9CA3AF'">
                                <i data-lucide="chevron-right" style="width:13px;height:13px;"></i>
                                Restaurant Refund Policy
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- CONTACT -->
            <div>
                <h4 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:14px; margin-bottom:20px; color:#fff; letter-spacing:.02em;">Contact Us</h4>
                <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:14px;">
                    <li style="display:flex; align-items:flex-start; gap:10px; color:#9CA3AF; font-size:14px; line-height:1.5;">
                        <i data-lucide="map-pin" style="width:15px; height:15px; color:#C25A2A; flex-shrink:0; margin-top:2px;"></i>
                       Hounslow, London. UK, TW3 2DX
                    </li>
                    <li style="display:flex; align-items:center; gap:10px; color:#9CA3AF; font-size:14px;">
                        <i data-lucide="phone" style="width:15px; height:15px; color:#C25A2A; flex-shrink:0;"></i>
                       +44 7879 175585
                    </li>
                    <li style="display:flex; align-items:center; gap:10px; color:#9CA3AF; font-size:14px;">
                        <i data-lucide="mail" style="width:15px; height:15px; color:#C25A2A; flex-shrink:0;"></i>
                        info@hyst.uk
						
                    </li>
                    <li style="display:flex; align-items:center; gap:10px; color:#9CA3AF; font-size:14px;">
                        <i data-lucide="mail" style="width:15px; height:15px; color:#C25A2A; flex-shrink:0;"></i>
                        media@hyst.uk
                    </li>
                </ul>
            </div>
        </div>

        <!-- DIVIDER -->
        <div style="border-top:1px solid #1F1F1F; padding-top:28px;">
            {{-- <div class="footer-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                <p style="color:#4B5563; font-size:13px; margin:0;">© {{ date('Y') }} HYST. All rights reserved.</p>
                
                <p style="color:#4B5563; font-size:13px; margin:0; letter-spacing:.2px;">
                    © 2026 Designed & Developed by
                    <a href="https://www.thenexteck.com/"
                    target="_blank"
                    style="color:#C25A2A; text-decoration:none; font-weight:700;">
                        Nexteck
                    </a>
                </p>
            </div> --}}
            <div class="footer-bottom"
                style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;">

                <!-- Left -->
                <p style="color:#4B5563;font-size:13px;margin:0;">
                    © {{ date('Y') }} HYST. All rights reserved.
                </p>

                <!-- Center -->
                <p style="color:#4B5563;font-size:13px;margin:0;letter-spacing:.2px;">
                    Designed & Developed by
                    <a href="https://www.thenexteck.com/"
                    target="_blank"
                    style="color:#C25A2A;text-decoration:none;font-weight:700;">
                        Nexteck
                    </a>
                </p>

                <!-- Right -->
                <div style="display:flex;align-items:center;gap:10px;">
                    {{-- <span style="color:#6B7280;font-size:13px;">We Accept</span> --}}

                    <div style="background:#fff;border-radius:8px;padding:6px 12px;display:flex;align-items:center;">
                        <img src="https://cdn.simpleicons.org/visa/1A1F71"
                            alt="Visa"
                            style="height:18px;">
                    </div>

                    <div style="background:#fff;border-radius:8px;padding:6px 12px;display:flex;align-items:center;">
                        <img src="{{ asset('master.jpeg') }}"
                            alt="Mastercard"
                            style="height:18px;">
                    </div>
                </div>

            </div>
        </div>

    </div>
</footer>