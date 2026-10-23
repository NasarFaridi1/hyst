@extends('front.layouts.app')

@section('title', 'Privacy Policy for HYST Customer | HYST UK')
@section('meta_description', 'Privacy Policy for the HYST Customer mobile application (Google Play Store & Apple App Store) and web ordering services by HYST UK.')
@section('canonical', url('/customer-privacy-policy'))

@section('content')
<div class="hyst-policy-wrapper">
    <!-- HERO HEADER -->
    <header class="policy-hero">
        <div class="policy-container">
            <nav class="policy-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="crumb-separator">/</span>
                <span class="crumb-active">HYST Customer Privacy Policy</span>
            </nav>

            <div class="hero-badge">
                <span class="badge-dot"></span>
                <span>Mobile App & Web Privacy Notice</span>
            </div>

            <h1 class="hero-title">Privacy Policy for HYST Customer</h1>
            <p class="hero-subtitle">
                This policy outlines how HYST UK collects, protects, uses, and deletes personal and sensitive data when you use the HYST Customer mobile app on Android (Google Play Store) and iOS (Apple App Store), as well as our web ordering platform.
            </p>

            <!-- METADATA STRIP -->
            <div class="policy-meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Application</span>
                    <span class="meta-value"><strong>HYST Customer</strong> (Android & iOS)</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Developer / Entity</span>
                    <span class="meta-value"><strong>HYST UK</strong></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Effective Date</span>
                    <span class="meta-value">October 23, 2024</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Last Updated</span>
                    <span class="meta-value">October 2024</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Official Website</span>
                    <a href="https://hyst.uk" target="_blank" class="meta-link">hyst.uk</a>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Contact Email</span>
                    <a href="mailto:support@hyst.uk" class="meta-link">support@hyst.uk</a>
                </div>
            </div>

            <!-- ACTION SHORTCUTS -->
            <div class="hero-actions">
                <a href="#section-5" class="action-btn action-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    <span>Account Deletion Instructions</span>
                </a>
                <a href="mailto:support@hyst.uk?subject=Privacy%20Policy%20Inquiry%20-%20HYST%20Customer" class="action-btn action-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                    <span>Contact Privacy Team</span>
                </a>
                <button type="button" onclick="window.print()" class="action-btn action-outline" title="Print this policy">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect width="12" height="8" x="6" y="14"></rect></svg>
                    <span>Print Policy</span>
                </button>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT AREA -->
    <main class="policy-main">
        <div class="policy-container main-layout">
            <!-- SIDEBAR NAV (Sticky on Desktop) -->
            <aside class="policy-sidebar" aria-label="Table of Contents">
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>Sections in this Policy</span>
                    </div>
                    <nav class="sidebar-links">
                        <a href="#section-1" class="toc-link">
                            <span class="toc-num">1</span>
                            <span>Introduction</span>
                        </a>
                        <a href="#section-2" class="toc-link">
                            <span class="toc-num">2</span>
                            <span>Information We Collect</span>
                        </a>
                        <a href="#section-3" class="toc-link">
                            <span class="toc-num">3</span>
                            <span>How We Use Your Information</span>
                        </a>
                        <a href="#section-4" class="toc-link">
                            <span class="toc-num">4</span>
                            <span>Third-Party Services & Sharing</span>
                        </a>
                        <a href="#section-5" class="toc-link highlight-toc">
                            <span class="toc-num">5</span>
                            <span>Account & Data Deletion</span>
                        </a>
                        <a href="#section-6" class="toc-link">
                            <span class="toc-num">6</span>
                            <span>Data Security & Encryption</span>
                        </a>
                        <a href="#section-7" class="toc-link">
                            <span class="toc-num">7</span>
                            <span>Your Legal Rights (GDPR / CCPA)</span>
                        </a>
                        <a href="#section-8" class="toc-link">
                            <span class="toc-num">8</span>
                            <span>Children’s Privacy</span>
                        </a>
                        <a href="#section-9" class="toc-link">
                            <span class="toc-num">9</span>
                            <span>Contact Information</span>
                        </a>
                    </nav>

                    <div class="sidebar-help-box">
                        <div class="help-title">Need help with your data?</div>
                        <p class="help-desc">Our Data Protection & Support team is available to assist you.</p>
                        <a href="mailto:support@hyst.uk" class="help-link">support@hyst.uk</a>
                    </div>
                </div>
            </aside>

            <!-- POLICY BODY -->
            <article class="policy-body">

                <!-- SECTION 1 -->
                <section id="section-1" class="policy-section-card">
                    <div class="section-badge">Section 1</div>
                    <h2 class="section-title">1. Introduction</h2>
                    <div class="section-content">
                        <p>
                            This Privacy Policy outlines how <strong>HYST UK</strong> (&ldquo;we&rdquo;, &ldquo;us&rdquo;, or &ldquo;our&rdquo;) collects, uses, stores, and protects personal and sensitive information when you download, install, or use the <strong>HYST Customer</strong> mobile application (the &ldquo;App&rdquo;) on Android (Google Play Store) and iOS (Apple App Store), as well as our related web services accessible through <a href="https://hyst.uk" target="_blank" rel="noopener">https://hyst.uk</a>.
                        </p>
                        <p>
                            We are committed to respecting your privacy and complying with applicable data protection laws, including:
                        </p>
                        <div class="compliance-badges">
                            <span class="law-pill">UK Data Protection Act 2018</span>
                            <span class="law-pill">UK GDPR</span>
                            <span class="law-pill">EU General Data Protection Regulation (EU GDPR)</span>
                            <span class="law-pill">California Consumer Privacy Act (CCPA)</span>
                            <span class="law-pill">Google Play Developer Policies</span>
                            <span class="law-pill">Apple App Store Review Guidelines</span>
                        </div>
                    </div>
                </section>

                <!-- SECTION 2 -->
                <section id="section-2" class="policy-section-card">
                    <div class="section-badge">Section 2</div>
                    <h2 class="section-title">2. Information We Collect</h2>
                    <div class="section-content">
                        <p>
                            We collect only the minimum necessary data to provide our food discovery, ordering, and customer support services.
                        </p>

                        <!-- Part A -->
                        <div class="sub-block">
                            <h3 class="sub-title">A. Information Provided Directly by You</h3>
                            <div class="feature-list">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    </div>
                                    <div class="feature-details">
                                        <strong>User Registration & Profile:</strong>
                                        <span>Name, email address, password (stored in securely hashed/encrypted format), and optional profile photo.</span>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    </div>
                                    <div class="feature-details">
                                        <strong>Authentication & Session Data:</strong>
                                        <span>User ID, role, and secure authentication tokens (API tokens) used to maintain your authenticated session.</span>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                    </div>
                                    <div class="feature-details">
                                        <strong>Support & Communications:</strong>
                                        <span>Inquiries, feedback, order complaints, or password reset requests submitted to our support team.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Part B -->
                        <div class="sub-block">
                            <h3 class="sub-title">B. Information Collected Automatically</h3>
                            <div class="feature-list">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                                    </div>
                                    <div class="feature-details">
                                        <strong>Device & Diagnostics Information:</strong>
                                        <span>Device model, operating system version (Android / iOS), app build version, and network connectivity status.</span>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    </div>
                                    <div class="feature-details">
                                        <strong>IP Address & Web Telemetry:</strong>
                                        <span>IP address, WebView user-agent details, and session timestamps used for security verification and fraud prevention.</span>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                                    </div>
                                    <div class="feature-details">
                                        <strong>Local Device Storage:</strong>
                                        <span>Encrypted session data and authentication tokens saved locally via SharedPreferences (Android) / UserDefaults (iOS) to keep you securely signed in.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Part C -->
                        <div class="sub-block">
                            <h3 class="sub-title">C. Device Permissions</h3>
                            <div class="perm-grid">
                                <div class="perm-card">
                                    <div class="perm-tag required">Required</div>
                                    <div class="perm-name">Internet & Network State</div>
                                    <div class="perm-manifest">android.permission.INTERNET, ACCESS_NETWORK_STATE</div>
                                    <p class="perm-desc">Required to communicate with the HYST server, verify connectivity, and load ordering services.</p>
                                </div>
                                <div class="perm-card">
                                    <div class="perm-tag optional">Optional</div>
                                    <div class="perm-name">Push Notifications</div>
                                    <div class="perm-manifest">POST_NOTIFICATIONS / APNs</div>
                                    <p class="perm-desc">Used to send transactional updates regarding orders, security notices, and status changes. You can revoke this permission at any time in device settings.</p>
                                </div>
                                <div class="perm-card">
                                    <div class="perm-tag optional">Optional</div>
                                    <div class="perm-name">Location Services</div>
                                    <div class="perm-manifest">ACCESS_COARSE_LOCATION / ACCESS_FINE_LOCATION</div>
                                    <p class="perm-desc">If enabled, used to display nearby restaurant partners and streamline delivery address selection.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 3 -->
                <section id="section-3" class="policy-section-card">
                    <div class="section-badge">Section 3</div>
                    <h2 class="section-title">3. How We Use Your Information</h2>
                    <div class="section-content">
                        <p>We process your personal information strictly for legitimate business and operational purposes:</p>

                        <div class="purpose-grid">
                            <div class="purpose-card">
                                <div class="purpose-num">01</div>
                                <h4>Core Functionality</h4>
                                <p>Authenticate your account, maintain secure login sessions, process restaurant menus, and manage customer food orders.</p>
                            </div>
                            <div class="purpose-card">
                                <div class="purpose-num">02</div>
                                <h4>Communications</h4>
                                <p>Deliver order updates, transactional account alerts, password resets, and prompt responses to your customer support queries.</p>
                            </div>
                            <div class="purpose-card">
                                <div class="purpose-num">03</div>
                                <h4>Security & Fraud Prevention</h4>
                                <p>Prevent bot attacks, brute-force attempts, unauthorized access, and abusive requests using security layers such as Cloudflare Turnstile.</p>
                            </div>
                            <div class="purpose-card">
                                <div class="purpose-num">04</div>
                                <h4>Legal & Regulatory Compliance</h4>
                                <p>Comply with applicable UK/EU statutory obligations, financial accounting laws, and enforce our Terms of Service.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 4 -->
                <section id="section-4" class="policy-section-card">
                    <div class="section-badge">Section 4</div>
                    <h2 class="section-title">4. Third-Party Services & Data Sharing</h2>
                    <div class="section-content">
                        <div class="statement-banner">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>
                            <div>
                                <strong>We do NOT sell, lease, or trade your personal data.</strong>
                                <span>We only share information with trusted third-party service providers under strict confidentiality and data-processing agreements:</span>
                            </div>
                        </div>

                        <div class="providers-list">
                            <div class="provider-card">
                                <div class="provider-header">
                                    <span class="provider-title">HYST UK Backend (hyst.uk)</span>
                                    <span class="provider-badge">Primary Service</span>
                                </div>
                                <p>Processes user credentials, authentication tokens, menu data, and restaurant customer orders over secure HTTPS endpoints.</p>
                            </div>
                            <div class="provider-card">
                                <div class="provider-header">
                                    <span class="provider-title">Cloudflare (Turnstile & CDN)</span>
                                    <span class="provider-badge">Infrastructure & Security</span>
                                </div>
                                <p>Provides bot detection, DDoS mitigation, and global edge network delivery. Cloudflare processes network headers and IP addresses for security.</p>
                            </div>
                            <div class="provider-card">
                                <div class="provider-header">
                                    <span class="provider-title">Google Sign-In & Services</span>
                                    <span class="provider-badge">Authentication & Store</span>
                                </div>
                                <p>Provides optional social authentication, Firebase Cloud Messaging for order notifications, and Google Play app distribution.</p>
                            </div>
                            <div class="provider-card">
                                <div class="provider-header">
                                    <span class="provider-title">Apple Services</span>
                                    <span class="provider-badge">iOS & App Store</span>
                                </div>
                                <p>Provides iOS application runtime, Apple Push Notification service (APNs), and Apple App Store distribution.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 5 (COMPLIANCE CRITICAL) -->
                <section id="section-5" class="policy-section-card deletion-section">
                    <div class="section-badge badge-alert">Section 5 • Mandatory Policy</div>
                    <h2 class="section-title">5. Account and Data Deletion</h2>
                    <div class="section-content">
                        <div class="compliance-highlight-box">
                            <div class="highlight-header">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C42D0A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                <strong>Google Play & Apple App Store Mandatory Compliance Notice</strong>
                            </div>
                            <p>
                                In compliance with <strong>Google Play Store Developer Policies</strong> and <strong>Apple App Store Review Guideline 5.1.1(v)</strong>, all HYST Customer users have the unequivocal right to request permanent deletion of their account and all associated personal data.
                            </p>
                        </div>

                        <h3 class="sub-title" style="margin-top:24px;">How to Request Account Deletion:</h3>
                        <div class="deletion-methods-grid">
                            <div class="del-method-card">
                                <div class="del-step">Method 1</div>
                                <h4>In-App Request</h4>
                                <p>Open the <strong>HYST Customer App</strong> &rarr; Go to <strong>Settings</strong> &rarr; Tap <strong>Request Account Deletion</strong> (or contact customer support inside the app).</p>
                            </div>
                            <div class="del-method-card">
                                <div class="del-step">Method 2</div>
                                <h4>Web Deletion Form</h4>
                                <p>Visit our online contact portal: <br>
                                    <a href="{{ url('/contact') }}" class="portal-link"><strong>hyst.uk/contact</strong></a>
                                </p>
                            </div>
                            <div class="del-method-card">
                                <div class="del-step">Method 3</div>
                                <h4>Email Request</h4>
                                <p>Send an email from your registered address to: <br>
                                    <a href="mailto:support@hyst.uk?subject=Account%20Deletion%20Request&body=Hello%20HYST%20Support%20Team,%0A%0APlease%20permanently%20delete%20my%20HYST%20Customer%20account%20and%20all%20associated%20personal%20data.%0A%0ARegistered%20Email:%20%0A%0AThank%20you." class="portal-link"><strong>support@hyst.uk</strong></a><br>
                                    with subject line: <code class="code-pill">Account Deletion Request</code>
                                </p>
                            </div>
                        </div>

                        <div class="timeline-box">
                            <h4 class="timeline-title">Data Retention & Deletion Timeline:</h4>
                            <ul class="timeline-list">
                                <li>
                                    <strong>Personal Profile Data:</strong> Name, email address, profile photo, phone number, and authentication tokens will be <strong>permanently erased or irreversibly anonymized</strong> from active databases within <strong>30 days</strong> of receiving your verified request.
                                </li>
                                <li>
                                    <strong>Financial & Accounting Records:</strong> Completed order transaction history and invoices (if any) may be retained only for the minimum duration strictly mandated by statutory UK HM Revenue & Customs (HMRC) accounting and tax legislation.
                                </li>
                            </ul>
                        </div>

                        <div class="del-cta-bar">
                            <span>Submit your account deletion request directly:</span>
                            <a href="mailto:support@hyst.uk?subject=Account%20Deletion%20Request&body=Hello%20HYST%20Support%20Team,%0A%0APlease%20permanently%20delete%20my%20HYST%20Customer%20account%20and%20all%20associated%20personal%20data.%0A%0ARegistered%20Email:%20%0A%0AThank%20you." class="action-btn action-danger">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span>Email Account Deletion Request</span>
                            </a>
                        </div>
                    </div>
                </section>

                <!-- SECTION 6 -->
                <section id="section-6" class="policy-section-card">
                    <div class="section-badge">Section 6</div>
                    <h2 class="section-title">6. Data Security and Encryption</h2>
                    <div class="section-content">
                        <p>We implement stringent technical and organizational security measures to protect your personal data:</p>

                        <div class="security-grid">
                            <div class="security-card">
                                <div class="sec-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                </div>
                                <h4>In Transit (Network Encryption)</h4>
                                <p>All communications between your mobile device and HYST UK cloud servers are encrypted using industry-standard <strong>Transport Layer Security (HTTPS / TLS 1.2 and TLS 1.3)</strong> with strict certificate verification.</p>
                            </div>
                            <div class="security-card">
                                <div class="sec-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                </div>
                                <h4>At Rest (Storage Encryption)</h4>
                                <p>User passwords are irreversibly hashed using secure cryptographic algorithms (Bcrypt/Argon2). Sensitive session tokens are encrypted and kept in secure, sandboxed private storage.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 7 -->
                <section id="section-7" class="policy-section-card">
                    <div class="section-badge">Section 7</div>
                    <h2 class="section-title">7. Your Legal Rights (UK / EU GDPR & CCPA)</h2>
                    <div class="section-content">
                        <p>Depending on your jurisdiction (including the UK, European Union, and California), you possess statutory privacy rights:</p>

                        <div class="rights-list">
                            <div class="right-item">
                                <span class="right-tag">Right to Access</span>
                                <p>Request confirmation of whether we process your data and receive a readable copy of personal records held by HYST.</p>
                            </div>
                            <div class="right-item">
                                <span class="right-tag">Right to Rectification</span>
                                <p>Request prompt correction of inaccurate, outdated, or incomplete personal details.</p>
                            </div>
                            <div class="right-item">
                                <span class="right-tag">Right to Erasure (&ldquo;Right to be Forgotten&rdquo;)</span>
                                <p>Request the permanent deletion of your personal profile and account data as outlined in Section 5.</p>
                            </div>
                            <div class="right-item">
                                <span class="right-tag">Right to Restriction & Objection</span>
                                <p>Object to or request restriction of certain processing activities where applicable under law.</p>
                            </div>
                            <div class="right-item">
                                <span class="right-tag">Right to Data Portability</span>
                                <p>Obtain your data in a structured, commonly used, machine-readable format.</p>
                            </div>
                        </div>

                        <div class="exercise-rights-callout">
                            <p>To exercise any of these statutory rights without charge, please email our Data Privacy Officer at:</p>
                            <a href="mailto:support@hyst.uk?subject=GDPR%20Data%20Rights%20Request" class="email-badge-link">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span>support@hyst.uk</span>
                            </a>
                        </div>
                    </div>
                </section>

                <!-- SECTION 8 -->
                <section id="section-8" class="policy-section-card">
                    <div class="section-badge">Section 8</div>
                    <h2 class="section-title">8. Children’s Privacy</h2>
                    <div class="section-content">
                        <p>
                            <strong>HYST Customer</strong> is not directed towards children under the age of <strong>13</strong> (or under <strong>16</strong> within the UK and European Economic Area). We do not knowingly solicit, collect, or store personal information from minors.
                        </p>
                        <p>
                            If you are a parent or legal guardian and discover that your minor child has created an account or provided us with personal information without required parental consent, please contact us immediately at <a href="mailto:support@hyst.uk" class="text-link">support@hyst.uk</a>. We will promptly investigate and permanently delete such accounts and information from our systems.
                        </p>
                    </div>
                </section>

                <!-- SECTION 9 -->
                <section id="section-9" class="policy-section-card contact-card-section">
                    <div class="section-badge">Section 9</div>
                    <h2 class="section-title">9. Contact Information</h2>
                    <div class="section-content">
                        <p>If you have any questions, comments, or concerns regarding this Privacy Policy or HYST UK&rsquo;s data protection practices, please contact us:</p>

                        <div class="contact-box-grid">
                            <div class="contact-card">
                                <span class="c-label">Organization</span>
                                <span class="c-val"><strong>HYST UK</strong></span>
                                <small style="color:#6B7280;margin-top:4px;">London, United Kingdom</small>
                            </div>
                            <div class="contact-card">
                                <span class="c-label">Official Website</span>
                                <a href="https://hyst.uk" target="_blank" rel="noopener" class="c-link">
                                    https://hyst.uk
                                </a>
                            </div>
                            <div class="contact-card">
                                <span class="c-label">Support & Privacy Email</span>
                                <a href="mailto:support@hyst.uk" class="c-link">
                                    support@hyst.uk
                                </a>
                            </div>
                        </div>

                        <div class="footer-note">
                            <p>By downloading, registering, or continuing to use the HYST Customer mobile application or our online ordering services, you acknowledge that you have read and understood this Privacy Policy.</p>
                        </div>
                    </div>
                </section>

            </article>
        </div>
    </main>
</div>

<style>
/* -------------------------------------------------------------
   HYST CUSTOMER PRIVACY POLICY - COMPLETE RESPONSIVE STYLES
   ------------------------------------------------------------- */
.hyst-policy-wrapper {
    background: #FAF8F5;
    color: #1F2937;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.75;
    padding-bottom: 60px;
}

.policy-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Hero Header */
.policy-hero {
    background: linear-gradient(180deg, #FFFFFF 0%, #F5F0E8 100%);
    border-bottom: 1px solid #EBE5DB;
    padding: 44px 0 36px;
}

.policy-breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #6B7280;
    margin-bottom: 18px;
}
.policy-breadcrumbs a {
    color: #C25A2A;
    text-decoration: none;
    font-weight: 500;
}
.policy-breadcrumbs a:hover {
    text-decoration: underline;
}
.crumb-separator {
    color: #D1D5DB;
}
.crumb-active {
    color: #374151;
    font-weight: 600;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #FFF0EC;
    color: #C25A2A;
    border: 1px solid rgba(194, 90, 42, 0.2);
    border-radius: 999px;
    padding: 4px 14px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.badge-dot {
    width: 8px;
    height: 8px;
    background: #C25A2A;
    border-radius: 50%;
    display: inline-block;
}

.hero-title {
    font-size: 38px;
    font-weight: 800;
    color: #111827;
    line-height: 1.25;
    margin-bottom: 14px;
    letter-spacing: -0.02em;
}

.hero-subtitle {
    font-size: 16px;
    color: #4B5563;
    max-width: 880px;
    line-height: 1.7;
    margin-bottom: 28px;
}

/* Metadata Grid */
.policy-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
    background: #FFFFFF;
    border: 1px solid #EBE5DB;
    border-radius: 16px;
    padding: 18px 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    margin-bottom: 24px;
}
.meta-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.meta-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #9CA3AF;
    font-weight: 600;
}
.meta-value {
    font-size: 14px;
    color: #111827;
}
.meta-link {
    color: #C25A2A;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
}
.meta-link:hover {
    text-decoration: underline;
}

/* Action Buttons */
.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 10px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}
.action-primary {
    background: #C25A2A;
    color: #FFFFFF;
}
.action-primary:hover {
    background: #A3481D;
    color: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(194, 90, 42, 0.3);
}
.action-secondary {
    background: #111827;
    color: #FFFFFF;
}
.action-secondary:hover {
    background: #1F2937;
    color: #FFFFFF;
    transform: translateY(-1px);
}
.action-outline {
    background: #FFFFFF;
    color: #374151;
    border: 1px solid #D1D5DB;
}
.action-outline:hover {
    background: #F3F4F6;
    color: #111827;
}
.action-danger {
    background: #DC2626;
    color: #FFFFFF;
}
.action-danger:hover {
    background: #B91C1C;
    color: #FFFFFF;
}

/* Main Layout: 2 Columns */
.policy-main {
    padding-top: 36px;
}
.main-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 32px;
    align-items: flex-start;
}

/* Sidebar */
.policy-sidebar {
    position: sticky;
    top: 24px;
}
.sidebar-card {
    background: #FFFFFF;
    border: 1px solid #E5E7EB;
    border-radius: 18px;
    padding: 22px 18px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
}
.sidebar-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #111827;
    padding-bottom: 14px;
    border-bottom: 1px solid #F3F4F6;
    margin-bottom: 12px;
}
.sidebar-links {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.toc-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
    color: #4B5563;
    text-decoration: none;
    transition: all 0.15s ease;
}
.toc-link:hover {
    background: #FFF0EC;
    color: #C25A2A;
}
.toc-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 6px;
    background: #F3F4F6;
    color: #374151;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}
.toc-link:hover .toc-num {
    background: #C25A2A;
    color: #FFFFFF;
}
.highlight-toc {
    background: #FEF2F2;
    color: #DC2626;
    font-weight: 600;
}
.highlight-toc .toc-num {
    background: #FEE2E2;
    color: #DC2626;
}
.highlight-toc:hover {
    background: #FEE2E2;
    color: #B91C1C;
}

.sidebar-help-box {
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px dashed #E5E7EB;
}
.help-title {
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}
.help-desc {
    font-size: 12px;
    color: #6B7280;
    line-height: 1.5;
    margin-bottom: 8px;
}
.help-link {
    display: inline-block;
    font-size: 12px;
    color: #C25A2A;
    font-weight: 700;
    text-decoration: none;
}
.help-link:hover {
    text-decoration: underline;
}

/* Policy Content Cards */
.policy-body {
    display: flex;
    flex-direction: column;
    gap: 28px;
}
.policy-section-card {
    background: #FFFFFF;
    border: 1px solid #EBE5DB;
    border-radius: 20px;
    padding: 36px 36px 32px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    scroll-margin-top: 28px;
}
.section-badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #C25A2A;
    background: #FFF0EC;
    padding: 3px 10px;
    border-radius: 6px;
    margin-bottom: 12px;
}
.badge-alert {
    color: #DC2626;
    background: #FEE2E2;
}
.section-title {
    font-size: 24px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 18px;
    letter-spacing: -0.01em;
}
.section-content p {
    color: #4B5563;
    font-size: 15px;
    line-height: 1.8;
    margin-bottom: 14px;
}
.section-content strong {
    color: #111827;
}

/* Compliance Badges */
.compliance-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 14px;
}
.law-pill {
    background: #F3F4F6;
    color: #374151;
    border: 1px solid #E5E7EB;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 8px;
}

/* Sub-blocks */
.sub-block {
    margin-top: 26px;
    padding-top: 20px;
    border-top: 1px solid #F3F4F6;
}
.sub-title {
    font-size: 17px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 14px;
}

/* Features List */
.feature-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #FDFBF7;
    border: 1px solid #EFEAE1;
    border-radius: 12px;
    padding: 14px 16px;
}
.feature-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #FFF0EC;
    color: #C25A2A;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.feature-details {
    font-size: 14px;
    color: #4B5563;
    line-height: 1.6;
}
.feature-details strong {
    display: block;
    color: #111827;
    font-size: 14px;
    margin-bottom: 2px;
}

/* Permissions Grid */
.perm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 14px;
}
.perm-card {
    background: #FDFBF7;
    border: 1px solid #EFEAE1;
    border-radius: 14px;
    padding: 18px;
    position: relative;
}
.perm-tag {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 2px 8px;
    border-radius: 4px;
    margin-bottom: 8px;
}
.perm-tag.required {
    background: #FEE2E2;
    color: #DC2626;
}
.perm-tag.optional {
    background: #DCFCE7;
    color: #15803D;
}
.perm-name {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}
.perm-manifest {
    font-size: 11px;
    font-family: monospace;
    background: #ECE6DC;
    color: #4B5563;
    padding: 2px 6px;
    border-radius: 4px;
    display: inline-block;
    margin-bottom: 10px;
}
.perm-desc {
    font-size: 13px !important;
    color: #4B5563 !important;
    line-height: 1.6 !important;
    margin-bottom: 0 !important;
}

/* Purpose Grid */
.purpose-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-top: 14px;
}
.purpose-card {
    background: #FDFBF7;
    border: 1px solid #EFEAE1;
    border-radius: 14px;
    padding: 20px 18px;
}
.purpose-num {
    font-size: 12px;
    font-weight: 800;
    color: #C25A2A;
    background: #FFF0EC;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}
.purpose-card h4 {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}
.purpose-card p {
    font-size: 13px !important;
    color: #4B5563 !important;
    line-height: 1.6 !important;
    margin-bottom: 0 !important;
}

/* Statement Banner */
.statement-banner {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #F0FDF4;
    border: 1px solid #BBF7D0;
    border-radius: 14px;
    padding: 16px 18px;
    margin-bottom: 20px;
}
.statement-banner strong {
    display: block;
    color: #166534;
    font-size: 15px;
    margin-bottom: 3px;
}
.statement-banner span {
    font-size: 14px;
    color: #14532D;
}

/* Providers List */
.providers-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 14px;
}
.provider-card {
    background: #FFFFFF;
    border: 1px solid #E5E7EB;
    border-radius: 12px;
    padding: 18px;
}
.provider-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 8px;
}
.provider-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
}
.provider-badge {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    background: #F3F4F6;
    color: #4B5563;
    padding: 2px 7px;
    border-radius: 4px;
}
.provider-card p {
    font-size: 13px !important;
    color: #4B5563 !important;
    line-height: 1.6 !important;
    margin-bottom: 0 !important;
}

/* Section 5: Deletion Highlight */
.deletion-section {
    border: 2px solid #FCA5A5;
    background: #FFFFFF;
}
.compliance-highlight-box {
    background: #FEF2F2;
    border-left: 4px solid #DC2626;
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 20px;
}
.highlight-header {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #991B1B;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 6px;
}
.compliance-highlight-box p {
    font-size: 14px !important;
    color: #7F1D1D !important;
    line-height: 1.6 !important;
    margin-bottom: 0 !important;
}

.deletion-methods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}
.del-method-card {
    background: #FDFBF7;
    border: 1px solid #EFEAE1;
    border-radius: 14px;
    padding: 18px;
}
.del-step {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    color: #C25A2A;
    margin-bottom: 6px;
}
.del-method-card h4 {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}
.del-method-card p {
    font-size: 13px !important;
    color: #4B5563 !important;
    line-height: 1.6 !important;
    margin-bottom: 0 !important;
}
.portal-link {
    color: #C25A2A;
    text-decoration: underline;
    font-weight: 700;
}
.portal-link:hover {
    color: #A3481D;
}
.code-pill {
    background: #ECE6DC;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12px;
    color: #1F2937;
}

.timeline-box {
    background: #F9FAFB;
    border: 1px solid #E5E7EB;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}
.timeline-title {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
}
.timeline-list {
    margin: 0;
    padding-left: 20px;
}
.timeline-list li {
    font-size: 14px;
    color: #4B5563;
    line-height: 1.7;
    margin-bottom: 10px;
}
.timeline-list li:last-child {
    margin-bottom: 0;
}

.del-cta-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    background: #FFF0EC;
    border: 1px solid rgba(194, 90, 42, 0.25);
    border-radius: 12px;
    padding: 14px 20px;
}
.del-cta-bar span {
    font-size: 14px;
    font-weight: 600;
    color: #7C2D12;
}

/* Security Grid */
.security-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
    margin-top: 14px;
}
.security-card {
    background: #FDFBF7;
    border: 1px solid #EFEAE1;
    border-radius: 14px;
    padding: 22px 20px;
}
.sec-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #FFF0EC;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
}
.security-card h4 {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}
.security-card p {
    font-size: 13.5px !important;
    color: #4B5563 !important;
    line-height: 1.65 !important;
    margin-bottom: 0 !important;
}

/* Rights List */
.rights-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 16px;
    margin-bottom: 22px;
}
.right-item {
    background: #FDFBF7;
    border: 1px solid #EFEAE1;
    border-radius: 12px;
    padding: 14px 18px;
}
.right-tag {
    display: inline-block;
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}
.right-item p {
    font-size: 13.5px !important;
    color: #4B5563 !important;
    line-height: 1.6 !important;
    margin-bottom: 0 !important;
}

.exercise-rights-callout {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 14px;
    background: #F9FAFB;
    border: 1px solid #E5E7EB;
    border-radius: 12px;
    padding: 14px 18px;
}
.exercise-rights-callout p {
    margin: 0 !important;
    font-size: 14px !important;
    color: #374151 !important;
}
.email-badge-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #C25A2A;
    color: #FFFFFF;
    font-size: 13px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.15s ease;
}
.email-badge-link:hover {
    background: #A3481D;
    color: #FFFFFF;
}

/* Contact Grid */
.contact-box-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-top: 16px;
    margin-bottom: 24px;
}
.contact-card {
    background: #FDFBF7;
    border: 1px solid #EFEAE1;
    border-radius: 14px;
    padding: 18px;
    display: flex;
    flex-direction: column;
}
.c-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #9CA3AF;
    font-weight: 700;
    margin-bottom: 4px;
}
.c-val {
    font-size: 16px;
    color: #111827;
}
.c-link {
    color: #C25A2A;
    text-decoration: none;
    font-weight: 700;
    font-size: 15px;
}
.c-link:hover {
    text-decoration: underline;
}

.footer-note {
    background: #F3F4F6;
    border-radius: 10px;
    padding: 14px 18px;
}
.footer-note p {
    font-size: 13px !important;
    color: #6B7280 !important;
    line-height: 1.6 !important;
    margin-bottom: 0 !important;
}

.text-link {
    color: #C25A2A;
    text-decoration: underline;
    font-weight: 600;
}

/* -------------------------------------------------------------
   RESPONSIVENESS (Mobile, Tablet, Desktop)
   ------------------------------------------------------------- */
@media (max-width: 991px) {
    .main-layout {
        grid-template-columns: 1fr;
    }
    .policy-sidebar {
        position: static;
        margin-bottom: 12px;
    }
    .sidebar-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 6px;
    }
    .hero-title {
        font-size: 30px;
    }
}

@media (max-width: 768px) {
    .policy-hero {
        padding: 30px 0 24px;
    }
    .hero-title {
        font-size: 26px;
    }
    .hero-subtitle {
        font-size: 14.5px;
    }
    .policy-section-card {
        padding: 24px 20px;
        border-radius: 16px;
    }
    .section-title {
        font-size: 20px;
    }
    .policy-meta-grid {
        grid-template-columns: 1fr 1fr;
        padding: 14px 16px;
    }
    .hero-actions {
        flex-direction: column;
    }
    .action-btn {
        width: 100%;
        justify-content: center;
    }
    .del-cta-bar {
        flex-direction: column;
        align-items: flex-start;
    }
    .del-cta-bar .action-btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .policy-meta-grid {
        grid-template-columns: 1fr;
    }
    .hero-title {
        font-size: 23px;
    }
    .sidebar-links {
        grid-template-columns: 1fr;
    }
    .section-title {
        font-size: 18.5px;
    }
}

/* Print Stylesheet */
@media print {
    body {
        background: #FFFFFF !important;
        color: #000000 !important;
    }
    .policy-sidebar,
    .hero-actions,
    .policy-breadcrumbs,
    nav,
    footer,
    #btnFooterPushRefresh {
        display: none !important;
    }
    .main-layout {
        display: block !important;
    }
    .policy-section-card {
        box-shadow: none !important;
        border: 1px solid #CCCCCC !important;
        page-break-inside: avoid;
        margin-bottom: 20px;
        padding: 20px !important;
    }
}
</style>
@endsection
