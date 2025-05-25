<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Darah - Pilih Login</title>
    <link rel="stylesheet" href="{{ asset('css/beforelogin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>
<body>
    <div class="before-login-container">
        <div class="left-section">
            <h1 class="title">Sahabat Darah</h1>
            <img
                src="{{ asset('assets/character.png') }}" alt="Character"
                class="character-img"
            />
        </div>

        <div class="right-section">
            <div class="login-box">
                <button
                    class="login-button"
                    onclick="window.location.href='{{ route('login') }}'"
                >
                    LOGIN AS HOSPITAL ADMIN
                </button>
                <button
                    class="login-button"
                    onclick="window.location.href='{{ route('login') }}'"
                >
                    LOGIN AS PMI ADMIN
                </button>
                <button
                    class="login-button"
                    onclick="window.location.href='{{ route('login') }}'"
                >
                    LOGIN AS SUPER USER
                </button>

                <p class="register-text">
                    Don’t have any account?
                    <span
                        class="register-link"
                        onclick="window.location.href='{{ route('register.form') }}'"
                    >
                        Sign Up
                    </span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>