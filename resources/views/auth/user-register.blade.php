<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create HYST Account</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }

        .card-top-bar {
            height: 6px;
            background: #C25A2A;
            border-radius: 24px 24px 0 0;
        }

        .field-wrap { position: relative; }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #C25A2A;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .field-input {
            width: 100%;
            border: 1.5px solid #EBE5DE;
            padding: 13px 14px 13px 42px;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #0D0D0D;
            background: #FDFAF7;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.18s, background 0.18s;
        }
        .field-input::placeholder { color: #BFBAB3; }
        .field-input:focus { border-color: #C25A2A; background: #fff; }
        .field-input.field-error { border-color: #E24B4A; background: #FFF8F8; }
        .field-input.field-ok    { border-color: #2E9E6B; background: #F6FDF9; }

        .pw-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #BFBAB3;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }
        .pw-toggle:hover { color: #C25A2A; }

        .pw-strength-bar { display: flex; gap: 5px; margin-top: 7px; }
        .pw-strength-bar span {
            flex: 1;
            height: 4px;
            border-radius: 4px;
            background: #EBE5DE;
            transition: background 0.2s;
        }

        .btn-primary {
            width: 100%;
            background: #C25A2A;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 14px 0;
            cursor: pointer;
            letter-spacing: 0.01em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.16s, transform 0.12s, opacity 0.2s;
        }
        .btn-primary:not(:disabled):hover { background: #A84B22; transform: scale(1.01); }
        .btn-primary:disabled {
            background: #D9C9BF;
            cursor: not-allowed;
            transform: none;
            opacity: 0.75;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.25rem 0;
        }
        .divider-line { flex: 1; height: 1px; background: #EBE5DE; }
        .divider-text { font-size: 12px; color: #BBB; font-weight: 500; }

        .btn-social {
            border: 1.5px solid #EBE5DE;
            border-radius: 10px;
            background: #fff;
            padding: 10px 0;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: border-color 0.16s, background 0.16s, color 0.16s;
        }
        .btn-social:hover { border-color: #C25A2A; background: #FDF5F0; color: #C25A2A; }

        .field-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .inline-error {
            font-size: 12px;
            color: #E24B4A;
            margin-top: 5px;
            display: none;
        }

        /* Password rule list */
        #password-rules { font-size: 12px; color: #777; margin-top: 8px; padding-left: 18px; }
        #password-rules li { transition: color 0.15s; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-5" style="background:#F5F0E8;">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl overflow-hidden" style="box-shadow: 0 8px 40px rgba(194,90,42,0.12), 0 1px 6px rgba(0,0,0,0.06);">

            <div class="card-top-bar"></div>

            <div class="p-9">
                <a href="/" style="display:flex; align-items:center; gap:9px; text-decoration:none; margin-bottom:1.5rem;">
                    <div style="width:36px; height:36px; background:#C25A2A; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i data-lucide="utensils" style="color:#fff; width:18px; height:18px;"></i>
                    </div>
                    <span style="font-weight:800; font-size:19px; color:#0D0D0D; letter-spacing:-0.4px;">HYST</span>
                </a>

                <h1 style="font-size:22px; font-weight:700; color:#0D0D0D; margin:0 0 4px; line-height:1.25;">
                    Create your account
                </h1>
                <p style="font-size:13px; color:#888; margin:0 0 1.75rem;">
                    Join thousands ordering zero-commission food with HYST
                </p>

                <form method="POST" action="/register-user" id="register-form" novalidate>
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-4">
                        <label class="field-label">Full name</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <i data-lucide="user" style="width:17px; height:17px;"></i>
                            </span>
                            <input
                                type="text"
                                name="name"
                                id="name-field"
                                placeholder="Jane Smith"
                                class="field-input"
                                autocomplete="name">
                        </div>
                        <p class="inline-error" id="name-error">Name can only contain letters and spaces.</p>
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="field-label">Email address</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <i data-lucide="mail" style="width:17px; height:17px;"></i>
                            </span>
                            <input
                                type="email"
                                name="email"
                                id="email-field"
                                placeholder="jane@example.com"
                                class="field-input"
                                autocomplete="email">
                        </div>
                        <p class="inline-error" id="email-error">Please enter a valid email address.</p>
                    </div>

                    {{-- Password --}}
                    <div class="mb-6">
                        <label class="field-label">Password</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <i data-lucide="lock" style="width:17px; height:17px;"></i>
                            </span>
                            <input
                                type="password"
                                name="password"
                                id="pw-field"
                                placeholder="Create a strong password"
                                class="field-input"
                                style="padding-right: 42px;"
                                autocomplete="new-password">
                            <button type="button" class="pw-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                                <i data-lucide="eye" id="pw-eye-icon" style="width:17px; height:17px;"></i>
                            </button>
                        </div>

                        {{-- Strength bar --}}
                        <div class="pw-strength-bar">
                            <span id="bar1"></span>
                            <span id="bar2"></span>
                            <span id="bar3"></span>
                            <span id="bar4"></span>
                        </div>

                        {{-- Rule checklist --}}
                        <ul id="password-rules">
                            <li id="rule-length">Minimum 8 characters</li>
                            <li id="rule-upper">One uppercase letter (A–Z)</li>
                            <li id="rule-lower">One lowercase letter (a–z)</li>
                            <li id="rule-number">One number (0–9)</li>
                            <li id="rule-special">One special character (@$!%*?&amp;)</li>
                        </ul>
                    </div>

                    {{-- Turnstile --}}
                    <div class="mb-5 flex justify-center">
                        <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}"></div>
                    </div>

                    {{-- Submit (disabled by default) --}}
                    <button type="submit" class="btn-primary" id="submit-btn" disabled>
                        <i data-lucide="check" style="width:17px; height:17px;"></i>
                        Create account
                    </button>

                </form>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">or sign up with</span>
                    <div class="divider-line"></div>
                </div>

                <div class="social-grid">
                    <a href="{{ route('social.redirect', 'google') }}" class="btn-social">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Google
                    </a>
                </div>

                <div class="text-center mt-5">
                    <a href="/login" style="color:#C25A2A; font-weight:600; font-size:13px; text-decoration:none;">
                        Already have an account? <span style="text-decoration:underline;">Log in</span>
                    </a>
                </div>
                <div class="text-center mt-5">
                    <a href="/ambassador/register" style="color:#C25A2A; font-weight:600; font-size:13px; text-decoration:none;">
                        Are you an ambassador? <span style="text-decoration:underline;">Ambassador Sign up</span>
                    </a>
                </div>

                <p style="text-align:center; font-size:11.5px; color:#BBB; margin-top:1rem; line-height:1.6;">
                    By creating an account you agree to our
                    <a href="#" style="color:#C25A2A; text-decoration:none;">Terms</a> and
                    <a href="#" style="color:#C25A2A; text-decoration:none;">Privacy Policy</a>.
                </p>

            </div>
        </div>
    </div>

    @if(session('message'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: @json(session('type', 'success')),
            title: @json(ucfirst(session('type', 'success'))),
            text: @json(session('message')),
            confirmButtonColor: '#C25A2A'
        });
    });
    </script>
    @endif

    <script>
        lucide.createIcons();

        /* ─── Element refs ─── */
        const nameField   = document.getElementById('name-field');
        const emailField  = document.getElementById('email-field');
        const pwField     = document.getElementById('pw-field');
        const nameError   = document.getElementById('name-error');
        const emailError  = document.getElementById('email-error');
        const submitBtn   = document.getElementById('submit-btn');

        const bars   = [1,2,3,4].map(i => document.getElementById('bar' + i));
        const rules  = {
            length:  document.getElementById('rule-length'),
            upper:   document.getElementById('rule-upper'),
            lower:   document.getElementById('rule-lower'),
            number:  document.getElementById('rule-number'),
            special: document.getElementById('rule-special'),
        };

        /* ─── Validation state ─── */
        const state = { name: false, email: false, password: false };

        function updateSubmit() {
            submitBtn.disabled = !(state.name && state.email && state.password);
        }

        /* ─── Name validation ─── */
        // Block number/special key input in real-time
        nameField.addEventListener('keypress', function (e) {
            // Allow control keys (backspace, arrows etc.) via keydown; keypress fires only for printable chars
            if (!/^[A-Za-z\s]$/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Also handle paste
        nameField.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const cleaned = pasted.replace(/[^A-Za-z\s]/g, '');
            document.execCommand('insertText', false, cleaned);
        });

        nameField.addEventListener('input', function () {
            const val = this.value;
            const valid = val.trim().length >= 2 && /^[A-Za-z\s]+$/.test(val);

            if (!val.trim()) {
                // Empty — neutral state
                this.classList.remove('field-error', 'field-ok');
                nameError.style.display = 'none';
                state.name = false;
            } else if (valid) {
                this.classList.remove('field-error');
                this.classList.add('field-ok');
                nameError.style.display = 'none';
                state.name = true;
            } else {
                this.classList.remove('field-ok');
                this.classList.add('field-error');
                nameError.textContent = /\d/.test(val)
                    ? 'Name cannot contain numbers.'
                    : 'Name can only contain letters and spaces.';
                nameError.style.display = 'block';
                state.name = false;
            }
            updateSubmit();
        });

        /* ─── Email validation ─── */
        emailField.addEventListener('input', function () {
            const val = this.value.trim();
            const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);

            if (!val) {
                this.classList.remove('field-error', 'field-ok');
                emailError.style.display = 'none';
                state.email = false;
            } else if (valid) {
                this.classList.remove('field-error');
                this.classList.add('field-ok');
                emailError.style.display = 'none';
                state.email = true;
            } else {
                this.classList.remove('field-ok');
                this.classList.add('field-error');
                emailError.style.display = 'block';
                state.email = false;
            }
            updateSubmit();
        });

        /* ─── Password validation (single handler) ─── */
        const strengthColors = ['#EBE5DE', '#E24B4A', '#F09527', '#4CAF50', '#2E9E6B'];

        pwField.addEventListener('input', function () {
            const v = this.value;

            const checks = {
                length:  v.length >= 8,
                upper:   /[A-Z]/.test(v),
                lower:   /[a-z]/.test(v),
                number:  /\d/.test(v),
                special: /[@$!%*?&]/.test(v),
            };

            // Update rule list
            Object.entries(checks).forEach(([key, pass]) => {
                const el = rules[key];
                const text = el.textContent.replace(/^[✓✗] /, '');
                el.textContent = (pass ? '✓ ' : '✗ ') + text;
                el.style.color      = pass ? '#2E9E6B' : '#E24B4A';
                el.style.fontWeight = pass ? '600' : '400';
            });

            // Strength score (0–4)
            const score = Object.values(checks).filter(Boolean).length - (checks.length ? 0 : 1);
            // Simpler: count how many of the 4 non-length rules pass + length
            const barScore = [checks.length, checks.upper || checks.lower, checks.number, checks.special]
                             .filter(Boolean).length;

            const activeColor = v.length ? strengthColors[barScore] : '#EBE5DE';
            bars.forEach((bar, i) => {
                bar.style.background = i < barScore ? activeColor : '#EBE5DE';
            });

            // Password input border state
            const allPass = Object.values(checks).every(Boolean);
            if (!v) {
                this.classList.remove('field-error', 'field-ok');
            } else if (allPass) {
                this.classList.remove('field-error');
                this.classList.add('field-ok');
            } else {
                this.classList.remove('field-ok');
                this.classList.add('field-error');
            }

            state.password = allPass;
            updateSubmit();
        });

        /* ─── Toggle password visibility ─── */
        function togglePassword() {
            const isPassword = pwField.type === 'password';
            pwField.type = isPassword ? 'text' : 'password';
            document.getElementById('pw-eye-icon').setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
            lucide.createIcons();
        }
    </script>

</body>
</html>