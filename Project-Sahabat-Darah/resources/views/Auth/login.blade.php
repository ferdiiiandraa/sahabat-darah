<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Darah - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #b30000;
            min-height: 100vh;
            display: flex;
        }
        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }
        .left-side {
            width: 60%;
            display: flex;
            flex-direction: column;
            padding: 40px;
            position: relative;
        }
        .right-side {
            width: 40%;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .title {
            font-size: 70px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }
        .illustration-container {
            position: relative;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .laptop-img {
            width: 350px;
        }
        .character-img {
            position: absolute;
            width: 150px;
            left: 100px;
            top: 40px;
        }
        .speech-bubble {
            position: absolute;
            width: 150px;
            left: 180px;
            top: 0;
        }
        .login-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            max-width: 400px;
        }
        .login-button {
            background-color: #b30000;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-transform: uppercase;
        }
        .signup-link {
            text-align: center;
            font-size: 14px;
            color: #333;
            margin-top: 30px;
        }
        .signup-link a {
            color: #b30000;
            text-decoration: none;
            font-weight: 600;
        }
        .alert {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 13px;
        }
        .alert-error {
            background-color: #ffebee;
            color: #c62828;
        }
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .alert-warning {
            background-color: #fff8e1;
            color: #f57f17;
        }
        .input-field {
            background-color: #f0f0f0;
            border: none;
            padding: 15px;
            border-radius: 8px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin: 10px 0;
        }
        .remember-me {
            display: flex;
            align-items: center;
        }
        .remember-me input {
            margin-right: 8px;
        }
        .forgot-password {
            color: #666;
            font-size: 12px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left side with title and illustration -->
        <div class="left-side">
            <h1 class="title">Sahabat Darah</h1>
            <div class="illustration-container">
                <img src="{{ asset('images/laptop.png') }}" alt="Laptop" class="laptop-img">
                <img src="{{ asset('images/character.png') }}" alt="Character" class="character-img">
                <img src="{{ asset('images/speech-bubble.png') }}" alt="Speech Bubble" class="speech-bubble">
            </div>
        </div>
        
        <!-- Right side with login form -->
        <div class="right-side">
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="login-buttons">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 style="text-align: center; margin-bottom: 20px; font-size: 24px; color: #333;">Login</h2>
                    
                    <input id="email" name="email" type="email" placeholder="Email" autocomplete="email" required 
                        class="input-field" value="{{ old('email') }}">
                    @error('email')
                        <p style="color: #c62828; font-size: 12px; margin-top: -10px; margin-bottom: 10px;">{{ $message }}</p>
                    @enderror

                    <input id="password" name="password" type="password" placeholder="Password" autocomplete="current-password" required 
                        class="input-field">
                    @error('password')
                        <p style="color: #c62828; font-size: 12px; margin-top: -10px; margin-bottom: 10px;">{{ $message }}</p>
                    @enderror

                    <div class="remember-row">
                        <div class="remember-me">
                            <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" style="font-size: 13px;">Remember me</label>
                        </div>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="login-button">LOGIN</button>
                </form>
            </div>

            <div class="signup-link">
                Don't have an account? <a href="{{ route('register') }}">Registration</a>
            </div>
        </div>
    </div>
</body>
</html>
