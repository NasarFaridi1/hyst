<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambassador Registration — HYST</title>

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

        .field-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .ambassador-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #FDF0E8;
            border: 1px solid #F0D5C2;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
            color: #C25A2A;
            letter-spacing: 0.04em;
            margin-bottom: 1rem;
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

                {{-- Ambassador Badge --}}
                <div class="ambassador-badge">
                    <i data-lucide="star" style="width:12px; height:12px;"></i>
                    Ambassador Program
                </div>

                {{-- Heading --}}
                <h1 style="font-size:22px; font-weight:700; color:#0D0D0D; margin:0 0 4px; line-height:1.25;">
                    Become an Ambassador
                </h1>
                <p style="font-size:13px; color:#888; margin:0 0 1.75rem;">
                    Join our ambassador network and earn rewards with HYST
                </p>

                {{-- Form --}}
                <form method="POST" action="{{ route('ambassador.register.store') }}">
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
                                value="{{ old('name') }}"
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
                                value="{{ old('email') }}"
                                placeholder="jane@example.com"
                                class="field-input">
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="mb-4">
                        <label class="field-label">Phone number</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <i data-lucide="phone" style="width:17px; height:17px;"></i>
                            </span>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+91 98765 43210"
                                class="field-input">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
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
                            <button type="button" class="pw-toggle" onclick="togglePassword('pw-field','pw-eye-icon')" aria-label="Toggle password visibility">
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
                        <i data-lucide="star" style="width:17px; height:17px;"></i>
                        Register as Ambassador
                    </button>

                </form>

                {{-- Divider --}}
                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">already a member?</span>
                    <div class="divider-line"></div>
                </div>

                {{-- Login link --}}
                <div class="text-center">
                    <a href="{{ route('login') }}" style="color:#C25A2A; font-weight:600; font-size:13px; text-decoration:none;">
                        Already have an account? <span style="text-decoration:underline;">Log in</span>
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="/register" style="color:#C25A2A; font-weight:600; font-size:13px; text-decoration:none;">
                        Not an ambassador? <span style="text-decoration:underline;">User register</span>
                    </a>
                </div>

                <p style="text-align:center; font-size:11.5px; color:#BBB; margin-top:1rem; line-height:1.6;">
                    By registering you agree to our
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

        function togglePassword(fieldId, iconId) {
            var field = document.getElementById(fieldId);
            var icon = document.getElementById(iconId);
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