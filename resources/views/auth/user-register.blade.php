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
            transition: background 0.16s, transform 0.12s;
        }
        .btn-primary:hover { background: #A84B22; transform: scale(1.01); }

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
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-5" style="background:#F5F0E8;">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl overflow-hidden" style="box-shadow: 0 8px 40px rgba(194,90,42,0.12), 0 1px 6px rgba(0,0,0,0.06);">

            <div class="card-top-bar"></div>

            <div class="p-9">

                {{-- Logo --}}
                <a href="/" style="display:flex; align-items:center; gap:9px; text-decoration:none; margin-bottom:1.5rem;">
                    <div style="width:36px; height:36px; background:#C25A2A; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i data-lucide="utensils" style="color:#fff; width:18px; height:18px;"></i>
                    </div>
                    <span style="font-weight:800; font-size:19px; color:#0D0D0D; letter-spacing:-0.4px;">HYST</span>
                </a>

                {{-- Heading --}}
                <h1 style="font-size:22px; font-weight:700; color:#0D0D0D; margin:0 0 4px; line-height:1.25;">
                    Create your account
                </h1>
                <p style="font-size:13px; color:#888; margin:0 0 1.75rem;">
                    Join thousands ordering zero-commission food with HYST
                </p>

                {{-- Form --}}
                <form method="POST" action="/register-user">
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
                                placeholder="Jane Smith"
                                class="field-input">
                        </div>
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
                                placeholder="jane@example.com"
                                class="field-input">
                        </div>
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
                                style="padding-right: 42px;">
                            <button type="button" class="pw-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                                <i data-lucide="eye" id="pw-eye-icon" style="width:17px; height:17px;"></i>
                            </button>
                        </div>
                        <div class="pw-strength-bar" id="pw-strength">
                            <span id="bar1"></span>
                            <span id="bar2"></span>
                            <span id="bar3"></span>
                            <span id="bar4"></span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-primary">
                        <i data-lucide="check" style="width:17px; height:17px;"></i>
                        Create account
                    </button>

                </form>

                {{-- Divider --}}
                {{-- Divider --}}
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

                {{-- Login link --}}
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

    {{-- Session Alert --}}
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

        function togglePassword() {
            var field = document.getElementById('pw-field');
            var icon = document.getElementById('pw-eye-icon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                field.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        document.getElementById('pw-field').addEventListener('input', function () {
            var v = this.value;
            var score = 0;
            if (v.length >= 8) score++;
            if (/[A-Z]/.test(v)) score++;
            if (/[0-9]/.test(v)) score++;
            if (/[^A-Za-z0-9]/.test(v)) score++;

            var colors = ['#E24B4A', '#F09527', '#2E9E6B', '#C25A2A'];
            var active = v.length > 0 ? colors[score - 1] || '#EBE5DE' : '#EBE5DE';

            for (var i = 1; i <= 4; i++) {
                document.getElementById('bar' + i).style.background = i <= score ? active : '#EBE5DE';
            }
        });
    </script>

</body>
</html>