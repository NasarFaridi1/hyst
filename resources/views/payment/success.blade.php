<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #eafaf1;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      text-align: center;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .icon {
      font-size: 60px;
      color: #2ecc71;
      animation: pop 0.5s ease;
    }

    @keyframes pop {
      0% { transform: scale(0); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    h1 {
      color: #2c3e50;
      margin-top: 20px;
    }

    p {
      color: #666;
      margin: 10px 0 20px;
    }

    .details {
      font-size: 0.9rem;
      color: #888;
      margin-bottom: 20px;
    }

    .btn {
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
      background-color: #2ecc71;
      color: #fff;
    }

    .btn:hover {
      background-color: #27ae60;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="icon">✅</div>
    <h1>Payment Successful</h1>
    <p>Thank you! Your payment was processed successfully.</p>
    <p>Please check your Mail we provided your login details There.</p>
    <div class="details">
      <p>Order ID: {{ $transactionId }}</p>
    </div>
    <button class="btn" onclick="window.location.href='/'">Go For Login</button>
  </div>
</body>
</html>
