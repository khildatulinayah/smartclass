<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMARTCLASS LOGIN - PIXEL GAME</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body {
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, #87ceeb 0%, #87ceeb 100%);
            background-attachment: fixed;
            font-family: 'Press Start 2P', cursive;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 500px;
        }
        
        .login-card {
            background: #ffff99;
            border: 6px solid #000;
            padding: 30px;
            box-shadow: 8px 8px 0 #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #ff6600;
            font-size: 24px;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #0066ff;
            font-size: 12px;
            letter-spacing: 1px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: #000;
            font-size: 12px;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .form-group input {
            width: 100%;
            padding: 15px;
            background: white;
            border: 4px solid #000;
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            color: #000;
            box-shadow: 4px 4px 0 #000;
        }
        
        .form-group input:focus {
            outline: none;
            box-shadow: 6px 6px 0 #000;
        }
        
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #00cc00;
            border: 4px solid #000;
            color: white;
            font-family: 'Press Start 2P', cursive;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 4px 4px 0 #000;
            transition: all 0.1s;
            letter-spacing: 1px;
        }
        
        .btn-submit:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0 #000;
        }
        
        .btn-submit:active {
            transform: translate(4px, 4px);
            box-shadow: 0 0 0 #000;
        }
        
        .divider {
            height: 2px;
            background: #999;
            margin: 20px 0;
        }
        
        .error-box {
            background: #ff6666;
            border: 4px solid #000;
            padding: 15px;
            margin-bottom: 20px;
            color: white;
            font-size: 11px;
            box-shadow: 4px 4px 0 #000;
        }
        
        .error-box p {
            margin-bottom: 5px;
        }
        
        .demo-box {
            background: #99ccff;
            border: 4px solid #000;
            padding: 15px;
            margin-top: 20px;
            font-size: 10px;
            box-shadow: 4px 4px 0 #000;
        }
        
        .demo-box strong {
            color: #0066cc;
            display: block;
            margin-bottom: 10px;
            font-size: 11px;
        }
        
        .demo-account {
            background: white;
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 8px;
            font-size: 10px;
        }
        
        .demo-pass {
            margin-top: 10px;
            color: #cc6600;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: white;
            font-size: 11px;
        }
        
        .footer-title {
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="header">
                <h1>★SMARTCLASS★</h1>
                <p>LOGIN GAME 2026</p>
            </div>
            
            @if ($errors->any())
            <div class="error-box">
                <p><strong>⚠ LOGIN GAGAL!</strong></p>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="form-group">
                    <label>EMAIL</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>
                
                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-submit">▶ GAME START</button>
            </form>
            
            <div class="divider"></div>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ url('/') }}" style="color: #0066ff; text-decoration: none; font-size: 10px; letter-spacing: 1px;">← HOME</a>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-title">SMARTCLASS 2025/2026</div>
            <div>★ LEVEL UP YOUR SCHOOL ★</div>
        </div>
    </div>
</body>
</html>


