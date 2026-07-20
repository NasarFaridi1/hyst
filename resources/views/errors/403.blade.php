<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Forbidden — HYST</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #FAF7F2;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #0D0D0D;
        }
        .wrap { max-width: 480px; text-align: center; }
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 36px;
            text-decoration: none;
        }
        .logo-mark {
            width: 36px; height: 36px;
            background: #C25A2A;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: #0D0D0D;
        }
        .illustration { margin-bottom: 28px; }
        .code {
            font-family: 'Poppins', sans-serif;
            font-size: 90px;
            font-weight: 800;
            color: #0D0D0D;
            line-height: 1;
            letter-spacing: -2px;
            margin-bottom: 8px;
        }
        h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -.3px;
        }
        p {
            color: #6B7280;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            padding: 13px 26px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            transition: opacity .2s;
        }
        .btn:hover { opacity: .9; }
        .btn-primary { background: #C25A2A; color: #fff; }
        .btn-outline { background: #fff; color: #0D0D0D; border: 1.5px solid #E5E7EB; }
        @media (max-width: 480px) {
            .code { font-size: 64px; }
            h1 { font-size: 20px; }
            .actions { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-mark">
                <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7" />
                </svg>
            </span>
            <span class="logo-text">HYST</span>
        </a>

        <div class="illustration">
            <svg width="120" height="100" viewBox="0 0 120 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="60" cy="88" rx="42" ry="8" fill="#EFE9DF"/>
                <rect x="32" y="40" width="56" height="44" rx="10" fill="#fff" stroke="#0D0D0D" stroke-width="2"/>
                <path d="M42 40v-8a18 18 0 0136 0v8" stroke="#C25A2A" stroke-width="2" fill="none" stroke-linecap="round"/>
                <circle cx="60" cy="58" r="5" fill="#C25A2A"/>
                <rect x="57" y="60" width="6" height="12" rx="2" fill="#C25A2A"/>
            </svg>
        </div>

        <div class="code">403</div>
        <h1>You don't have access to this page</h1>
        <p>This area is restricted. If you think this is a mistake, try signing in with the right account or head back home.</p>

        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Go to Homepage
            </a>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Sign In
                </a>
            @endguest
        </div>
    </div>
</body>
</html>