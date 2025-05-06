<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Darah - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #8B0000; /* Dark red background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .main-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            margin: 0 20px;
        }
        .left-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-right: 20px;
        }
        .right-content {
            width: 320px;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .app-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 30px;
            color: white;
        }
        .character-container {
            position: relative;
            margin-top: 30px;
        }
        .login-btn {
            display: block;
            width: 100%;
            background-color: #8B0000;
            color: white;
            border: none;
            padding: 12px 0;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .login-btn:hover {
            background-color: #6B0000;
            color: white;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        .register-link a {
            color: #8B0000;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="left-content">
            <h1 class="app-title">Sahabat Darah</h1>
            <div class="character-container">
                <!-- Using a publicly available image that resembles the character in the reference image -->
                <img src="https://i.imgur.com/LHbHXlg.png" alt="Character with laptop" style="max-width: 100%; height: auto;">
            </div>
        </div>
        <div class="right-content">
            <div class="d-grid gap-3 mb-4">
                <a href="{{ route('login.rs.form') }}" class="btn login-btn">LOGIN AS HOSPITAL ADMIN</a>
                <a href="{{ route('login.pmi.form') }}" class="btn login-btn">LOGIN AS PMI ADMIN</a>
                <a href="{{ route('login.superuser.form') }}" class="btn login-btn">LOGIN AS SUPER USER</a>
            </div>
            <div class="register-link">
                <p>Don't have any account? <a href="{{ route('register') }}">Registration</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
