<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Darah - Super Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .sidebar {
            background-color: #8B0000;
            color: white;
            width: 173px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 100;
        }
        
        .sidebar-brand {
            padding: 20px 15px;
            font-size: 18px;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-item {
            padding: 10px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
        }
        
        .sidebar-item i {
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .sidebar-item span {
            font-size: 14px;
        }
        
        .sidebar-item:hover, .sidebar-item.active {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .main-content {
            margin-left: 173px;
        }
        
        .header {
            background-color: white;
            border-bottom: 1px solid #eaeaea;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }
        
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .admin-profile-icon {
            width: 24px;
            height: 24px;
            background-color: #e9e9e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .content-area {
            padding: 20px;
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            background-color: white;
        }
        
        .stat-card {
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }
        
        .stat-icon.blue {
            background-color: #4e73df;
        }
        
        .stat-icon.yellow {
            background-color: #f6c23e;
        }
        
        .stat-icon.green {
            background-color: #1cc88a;
        }
        
        .stat-icon.red {
            background-color: #e74a3b;
        }
        
        .stat-info h6 {
            font-size: 14px;
            color: #858796;
            margin-bottom: 5px;
        }
        
        .stat-info h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }
        
        .verification-section {
            margin-top: 20px;
        }
        
        .verification-header {
            margin-bottom: 10px;
        }
        
        .verification-header h5 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }
        
        .verification-header p {
            font-size: 12px;
            color: #858796;
            margin: 5px 0 0 0;
        }
        
        .table {
            margin-bottom: 0;
            background-color: white;
            border-radius: 8px;
        }
        
        .table th {
            font-size: 12px;
            font-weight: 500;
            color: #858796;
            text-transform: uppercase;
            padding: 15px;
            border-top: none;
            border-bottom: 1px solid #eaeaea;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
            border-top: none;
        }
        
        .empty-state {
            padding: 20px;
            text-align: center;
            color: #858796;
            background-color: white;
            border-radius: 8px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">Sahabat Darah</div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.verification-dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.verification-dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="sidebar-item">
                <i class="fas fa-users"></i>
                <span>Manage Users</span>
            </a>
        </div>
        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="sidebar-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="header-title">Verification Dashboard</div>
            <div class="admin-profile">
                <span>Super Admin</span>
                <div class="admin-profile-icon">
                    <i class="fas fa-user text-secondary"></i>
                </div>
            </div>
        </div>
        
        <div class="content-area">
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
