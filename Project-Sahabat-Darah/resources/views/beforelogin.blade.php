<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Darah - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link Font Awesome untuk icon (jika belum ada) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        /* Styling untuk Pop-up Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }
        .modal-overlay.show .modal-content {
             transform: translateY(0);
        }
        .modal-icon {
            width: 60px;
            height: 60px;
            background: #fffbe0; /* Warna kuning lembut */
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            font-size: 30px;
            color: #f59e0b; /* Warna icon jam */
        }
        .modal-content h4 {
            margin-bottom: 10px;
            color: #333;
        }
        .modal-content p {
            color: #555;
            margin-bottom: 20px;
        }
        .modal-button {
            background: #dc2626; /* Warna merah */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .modal-button:hover {
            background-color: #b91c1c; /* Warna merah lebih gelap saat hover */
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
            <!-- Success Message Banner (Optional, bisa dihapus jika hanya ingin pop-up) -->
            @if(session('success'))
                {{-- Pesan sukses ini akan ditangkap oleh JavaScript untuk menampilkan pop-up --}}
            @endif

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

    <!-- Struktur Pop-up Modal -->
    <div id="verification-pending-modal" class="modal-overlay">
        <div class="modal-content">
            <!-- Icon Jam -->
            <div class="modal-icon">
                 <i class="fas fa-clock"></i>
            </div>

            <h4>Verification Pending</h4>
            <p>Your account registration has been received. Please wait for verification from the Super Admin before you can log in. This process may take some time.</p>

            <button id="understood-button" class="modal-button">Understood</button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Debug: Log session success message
            console.log('Session success:', @json(session('success')));
            console.log('Auth check:', @json(Auth::check()));
            console.log('User status:', @json(Auth::check() ? Auth::user()->status : null));

            // Tampilkan pop-up jika ada session success
            @if(session('success'))
                var modal = document.getElementById('verification-pending-modal');
                modal.classList.add('show');

                var understoodButton = document.getElementById('understood-button');
                understoodButton.onclick = function() {
                    modal.classList.remove('show');
                }

                // Sembunyikan modal jika klik di luar konten modal
                modal.onclick = function(event) {
                    if (event.target == modal) {
                        modal.classList.remove('show');
                    }
                }
            @endif
        });
    </script>
</body>
</html>
