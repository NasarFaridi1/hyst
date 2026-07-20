<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found — HYST</title>
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
            color: #C25A2A;
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
            <svg width="140" height="100" viewBox="0 0 140 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="70" cy="88" rx="50" ry="8" fill="#EFE9DF"/>
                <circle cx="70" cy="44" r="38" fill="#FFF2EE" stroke="#C25A2A" stroke-width="2" stroke-dasharray="6 6"/>
                <path d="M52 38c0-6 4-10 10-10h16c6 0 10 4 10 10v8c0 9-8 16-18 16h-2c-10 0-16-7-16-16v-8z" fill="#fff" stroke="#0D0D0D" stroke-width="2"/>
                <circle cx="60" cy="42" r="2.5" fill="#0D0D0D"/>
                <circle cx="80" cy="42" r="2.5" fill="#0D0D0D"/>
                <path d="M58 54c3 3 17 3 20 0" stroke="#0D0D0D" stroke-width="2" stroke-linecap="round" fill="none"/>
                <path d="M70 16v-6m-12 4l-3-5m27 5l3-5" stroke="#C25A2A" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="code">404</div>
        <h1>This page got lost on the way</h1>
        <p>The page you're looking for doesn't exist or may have moved. Let's get you back to something delicious.</p>

        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Go to Homepage
            </a>
            <a href="{{ url('/restaurants') }}" class="btn btn-outline">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg>
                Browse Restaurants
            </a>
        </div>
    </div>
</body>
</html>