<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User - Rumah Sakit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f8f9fa;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #dc3545;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .navbar .brand {
            color: #fff;
            font-size: 1.2em;
            font-weight: bold;
        }
        .navbar .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }
        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }
        .navbar .logout-btn {
            background-color: #fff;
            color: #dc3545;
            border: none;
            padding: 6px 12px;
            border-radius: 3px;
            font-weight: bold;
            cursor: pointer;
        }

        h2, h3 {
            text-align: center;
            color: #343a40;
        }

        .search-box {
            border: 2px solid #dc3545;
            width: fit-content;
            padding: 15px;
            margin: 0 auto 30px auto;
            background-color: #ffffff;
            border-radius: 5px;
        }

        .search-box table {
            width: 100%;
        }

        .search-box input[type="text"] {
            width: 150px;
        }

        .search-box td {
            padding: 5px;
        }

        .dashboard {
            border: 2px solid #dc3545;
            margin-top: 30px;
            background-color: #ffffff;
            border-radius: 5px;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        thead th {
            background-color: #dc3545;
            color: white;
        }

        .navbar .nav-links a.active {
        font-weight: bold;
        background-color: #fff;
        color: #dc3545;
        padding: 5px 10px;
        border-radius: 4px;
        }

/* Styling untuk icon aksi (Edit, Delete, Reset Password, Enable/Disable) */
        .actions {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .actions form {
            display: inline;
        }

        .actions button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            transition: transform 0.2s;
        }

        .actions button:hover {
            transform: scale(1.2);
        }

        .fa-edit { color: #28a745; }      /* Hijau untuk Edit */
        .fa-trash { color: #dc3545; }     /* Merah untuk Hapus */
        .fa-key { color: #fd7e14; }       /* Oranye untuk Reset Password */
        .fa-lock, .fa-unlock { color: #6c757d; } /* Abu-abu untuk Lock / Unlock */

        .actions i {
            cursor: pointer;
            margin: 0 5px;
        }

        .fa-edit { color: green; }
        .fa-trash { color: red; }
        .fa-lock, .fa-unlock { color: #dc3545; }
        .fa-key { color: orange; }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- NAVBAR with Welcome & Logout -->
    <nav class="navbar">
        <div class="brand">Welcome: Superuser</div>
        <ul class="nav-links">
    <li>
        <a href="{{ route('users.pmi') }}" 
           class="{{ Route::is('users.pmi') ? 'active' : '' }}">User Management PMI</a>
    </li>
    <li>
        <a href="{{ route('users.index') }}" 
           class="{{ Route::is('users.index') ? 'active' : '' }}">User Management RS</a>
    </li>
    <li>
        <a href="{{ route('monitoring.index') }}" 
           class="{{ Route::is('monitoring.index') ? 'active' : '' }}">Monitoring</a>
    </li>
</ul>

        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </nav>

    <h2>Search User - Rumah Sakit</h2>
    <div class="search-box">
        <form action="{{ route('users.search') }}" method="GET">
            <table>
                <tr>
                    <td><label for="id_name">ID Name:</label></td>
                    <td><input type="text" name="id_name" id="id_name"></td>
                </tr>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" name="name" id="name"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">Search</button>
                        <a href="{{ route('users.index') }}">Back</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="dashboard">
        <h3>SUPERUSER DASHBOARD (RUMAH SAKIT)</h3>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ID Name</th>
                    <th>Name</th>
                    <th>Login User</th>
                    <th>Extension</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Reset Password</th>
                    <th>Disable/Enable</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->id_name }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->login_user }}</td>
                    <td>{{ $user->extension }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->login_time)->format('l, d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->logout_time)->format('l, d M Y') }}</td>
                    <td class="actions">
                        <a href="{{ route('users.edit', $user->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td class="actions">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                    <td class="actions">
                       <form action="{{ route('users.resetPassword', $user->id) }}" method="POST" onsubmit="return confirm('Reset password user ini ke default?');">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-key"></i>
                            </button>
                        </form>
                    </td>
                    <td class="actions">
                        <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" onsubmit="return confirm('Ubah status user ini?');" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none; border:none;">
                                @if ($user->status === 'disabled')
                                    <i class="fas fa-lock"></i>
                                @else
                                    <i class="fas fa-unlock"></i>
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
