<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to BlockForge</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a0a2e 0%, #16082a 50%, #0d0221 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-text {
            display: inline-block;
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
            padding: 15px 30px;
            border-radius: 12px;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
        }
        p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .highlight {
            color: #a855f7;
            font-weight: 600;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
        }
        .btn-block {
            display: block;
            text-align: center;
        }
        .info-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: rgba(255, 255, 255, 0.6);
        }
        .info-value {
            color: white;
            font-weight: 500;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .footer p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <div class="logo-text">BFB</div>
        </div>
        
        <h1>Welcome to BlockForge! ⚡</h1>
        
        <p>Hello <span class="highlight">{{ $name }}</span>,</p>
        
        <p>Welcome to <strong>BlockForge</strong> - the future of decentralized mining! We're excited to have you join our growing community of miners and crypto enthusiasts.</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Username</span>
                <span class="info-value">{{ $username }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Country</span>
                <span class="info-value">{{ $country }}</span>
            </div>
            @if($state)
            <div class="info-row">
                <span class="info-label">State</span>
                <span class="info-value">{{ $state }}</span>
            </div>
            @endif
        </div>
        
        <p>You can now start mining BFB tokens and be part of the revolution in blockchain gaming!</p>
        
        <a href="{{ $loginUrl }}" class="btn btn-block">Start Mining Now</a>
        
        <p style="margin-top: 30px;">Here's what you can do now:</p>
        <ul style="color: rgba(255, 255, 255, 0.7); margin-left: 20px; margin-bottom: 20px;">
            <li>Complete your profile setup</li>
            <li>Start free mining to earn BFB tokens</li>
            <li>Invite friends and earn referral bonuses</li>
            <li>Check the leaderboard rankings</li>
            <li>Explore our ecosystem utilities</li>
        </ul>
        
        <div class="footer">
            <p>© 2024 BlockForge. All rights reserved.</p>
            <p>This email was sent to {{ $email }}</p>
        </div>
    </div>
</body>
</html>
