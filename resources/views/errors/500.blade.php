<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something Went Wrong — HYST</title>
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
            color: #C0392B;
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
        <a href="/" class="logo">
            <span class="logo-mark">
                <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7" />
                </svg>
            </span>
            <span class="logo-text">HYST</span>
        </a>

        <div class="illustration">
            <svg width="130" height="100" viewBox="0 0 130 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="65" cy="88" rx="46" ry="8" fill="#EFE9DF"/>
                <path d="M40 78V44a8 8 0 018-8h34a8 8 0 018 8v34" stroke="#0D0D0D" stroke-width="2" fill="#fff"/>
                <path d="M40 78h50" stroke="#0D0D0D" stroke-width="2"/>
                <circle cx="65" cy="56" r="15" fill="#FFF2EE" stroke="#C0392B" stroke-width="2"/>
                <path d="M60 51l10 10m0-10l-10 10" stroke="#C0392B" stroke-width="2" stroke-linecap="round"/>
                <path d="M65 28v-8" stroke="#C25A2A" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="code">500</div>
        <h1>Something went wrong on our end</h1>
        <p>Our kitchen hit a snag. We've already been notified and we're looking into it — try refreshing in a moment.</p>

        <div class="actions">
            <a href="/" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Go to Homepage
            </a>
            <button onclick="location.reload()" class="btn btn-outline">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Try Again
            </button>
        </div>
    </div>
</body>
</html>