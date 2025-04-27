<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header with Navigation</title>
    <!-- Link to Google Fonts for Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Basic styles for the header */
        body {
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            font-family: Arial, sans-serif;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100vw;
            padding: 20px;
            background-color: #f8f8f8;
        }

        .header-text {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 16px;
            color: #333;
            white-space: nowrap; 
             
            
        }

        nav {
            display: flex;
            justify-content: center; /* Center the tabs */
            align-items: center;
            gap: 20px;
            width: 100%; /* Make nav take full width */
        }

        nav a {
            font-family: 'Poppins', sans-serif;
            font-weight: normal;
            font-size: 16px;
            color: #333;
            text-decoration: none;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
            text-align: center; /* Ensure text is centered within each link */
        }

        nav a:hover {
            background-color: #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-text">Sahabat Darah</div>
        <nav>
            <a href="#">Home</a>
            <a href="{{ route('rs.dashboard') }}">Dashboard Management</a>
            <a href="#">Stok Darah</a>
            <a href="#">Live Chat</a>
            <a href="#">Riwayat</a>
        </nav>
    </header>
</body>
</html>
