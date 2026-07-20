<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired — HYST</title>
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
        @media (max-width: 480px) {
            .code { font-size: 64px; }
            h1 { font-size: 20px; }
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
            <svg width="110" height="100" viewBox="0 0 110 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="55" cy="88" rx="38" ry="8" fill="#EFE9DF"/>
                <circle cx="55" cy="48" r="34" fill="#fff" stroke="#0D0D0D" stroke-width="2"/>
                <path d="M55 30v18l12 8" stroke="#C25A2A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </div>

        <div class="code">419</div>
        <h1>This page has expired</h1>
        <p>Your session timed out, probably because the page was open for a while. Just refresh and pick up where you left off.</p>

        <div class="actions">
            <button onclick="location.reload()" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Refresh Page
            </button>
        </div>
    </div>
</body>
</html>