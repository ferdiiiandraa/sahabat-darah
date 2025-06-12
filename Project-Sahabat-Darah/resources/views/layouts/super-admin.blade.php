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

        /* Manage Users Styles */
        .user-management-section {
            margin-top: 20px;
        }

        .filter-tabs {
            margin-bottom: 20px;
        }

        .filter-tabs .nav-link {
            color: #858796;
            border: none;
            background: none;
            padding: 10px 20px;
            border-radius: 20px;
            margin-right: 10px;
        }

        .filter-tabs .nav-link.active {
            background-color: #8B0000;
            color: white;
        }

        .user-card {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background-color: white;
        }

        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-details h6 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .user-details p {
            margin: 5px 0;
            color: #858796;
            font-size: 14px;
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        .btn-sm {
            padding: 5px 15px;
            font-size: 12px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background-color: #d1edff;
            color: #0c5460;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .modal-header {
            border-bottom: 1px solid #eaeaea;
        }

        .modal-footer {
            border-top: 1px solid #eaeaea;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            border-radius: 20px;
            padding: 10px 20px;
            border: 1px solid #eaeaea;
        }

        .hidden {
            display: none !important;
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
            <a href="#" class="sidebar-item" onclick="showManageUsers()">
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
            <div class="header-title" id="page-title">Verification Dashboard</div>
            <div class="admin-profile">
                <span>Super Admin</span>
                <div class="admin-profile-icon">
                    <i class="fas fa-user text-secondary"></i>
                </div>
            </div>
        </div>
        
        <div class="content-area">
            <!-- Original Dashboard Content -->
            <div id="dashboard-content">
                @yield('content')
            </div>

            <!-- Manage Users Content -->
            <div id="manage-users-content" class="hidden">
                <div class="user-management-section">
                    <!-- Search Box -->
                    <div class="search-box">
                        <input type="text" class="form-control" id="userSearch" placeholder="Cari berdasarkan nama atau email...">
                    </div>

                    <!-- Filter Tabs -->
                    <div class="filter-tabs">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="filterUsers('all')">Semua User</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="filterUsers('rs')">Rumah Sakit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="filterUsers('pmi')">PMI</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="filterUsers('pending')">Pending</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Users List -->
                    <div id="users-container">
                        <!-- Users will be loaded here via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    Apakah Anda yakin?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let currentUsers = [];
        let currentFilter = 'all';

        // Sample users data - In real application, this would come from backend
        const sampleUsers = [
            {
                id: 1,
                name: 'RS Siloam Jakarta',
                email: 'admin@siloam.com',
                role: 'rs',
                status: 'pending',
                created_at: '2024-01-15'
            },
            {
                id: 2,
                name: 'PMI Jakarta Pusat',
                email: 'admin@pmi-jakarta.org',
                role: 'pmi',
                status: 'approved',
                created_at: '2024-01-10'
            },
            {
                id: 3,
                name: 'RS Fatmawati',
                email: 'admin@fatmawati.com',
                role: 'rs',
                status: 'approved',
                created_at: '2024-01-12'
            },
            {
                id: 4,
                name: 'PMI Bandung',
                email: 'admin@pmi-bandung.org',
                role: 'pmi',
                status: 'pending',
                created_at: '2024-01-18'
            },
            {
                id: 5,
                name: 'RS Harapan Kita',
                email: 'admin@harapankita.com',
                role: 'rs',
                status: 'rejected',
                created_at: '2024-01-08'
            }
        ];

        function showManageUsers() {
            document.getElementById('dashboard-content').classList.add('hidden');
            document.getElementById('manage-users-content').classList.remove('hidden');
            document.getElementById('page-title').textContent = 'Manage Users';
            
            // Update sidebar active state
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector('.sidebar-item:nth-child(2)').classList.add('active');
            
            loadUsers();
        }

        function showDashboard() {
            document.getElementById('manage-users-content').classList.add('hidden');
            document.getElementById('dashboard-content').classList.remove('hidden');
            document.getElementById('page-title').textContent = 'Verification Dashboard';
            
            // Update sidebar active state
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector('.sidebar-item:first-child').classList.add('active');
        }

        function loadUsers() {
            currentUsers = sampleUsers;
            displayUsers(currentUsers);
        }

        function displayUsers(users) {
            const container = document.getElementById('users-container');
            
            if (users.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <p>Tidak ada user yang ditemukan</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = users.map(user => `
                <div class="user-card" data-role="${user.role}" data-status="${user.status}">
                    <div class="user-info">
                        <div class="user-details">
                            <h6>${user.name}</h6>
                            <p><i class="fas fa-envelope"></i> ${user.email}</p>
                            <p>
                                <span class="badge bg-primary">${user.role.toUpperCase()}</span>
                                <span class="status-badge status-${user.status}">${getStatusText(user.status)}</span>
                            </p>
                            <p class="text-muted"><small>Bergabung: ${formatDate(user.created_at)}</small></p>
                        </div>
                        <div class="user-actions">
                            ${user.status === 'pending' ? `
                                <button class="btn btn-success btn-sm" onclick="approveUser(${user.id}, '${user.name}')">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="rejectUser(${user.id}, '${user.name}')">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            ` : ''}
                            ${user.role !== 'super_admin' ? `
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteUser(${user.id}, '${user.name}')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterUsers(filter) {
            currentFilter = filter;
            
            // Update active tab
            document.querySelectorAll('.filter-tabs .nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');

            let filteredUsers = currentUsers;

            switch(filter) {
                case 'rs':
                    filteredUsers = currentUsers.filter(user => user.role === 'rs');
                    break;
                case 'pmi':
                    filteredUsers = currentUsers.filter(user => user.role === 'pmi');
                    break;
                case 'pending':
                    filteredUsers = currentUsers.filter(user => user.status === 'pending');
                    break;
                case 'all':
                default:
                    filteredUsers = currentUsers;
                    break;
            }

            displayUsers(filteredUsers);
        }

        function approveUser(userId, userName) {
            showConfirmationModal(
                'Approve User',
                `Apakah Anda yakin ingin menyetujui akun "${userName}"?`,
                'btn-success',
                () => {
                    // In real application, make AJAX call to backend
                    updateUserStatus(userId, 'approved');
                    showAlert('success', `Akun "${userName}" berhasil disetujui!`);
                }
            );
        }

        function rejectUser(userId, userName) {
            showConfirmationModal(
                'Reject User',
                `Apakah Anda yakin ingin menolak akun "${userName}"?`,
                'btn-danger',
                () => {
                    // In real application, make AJAX call to backend
                    updateUserStatus(userId, 'rejected');
                    showAlert('warning', `Akun "${userName}" telah ditolak!`);
                }
            );
        }

        function deleteUser(userId, userName) {
            showConfirmationModal(
                'Delete User',
                `Apakah Anda yakin ingin menghapus akun "${userName}"? Tindakan ini tidak dapat dibatalkan!`,
                'btn-danger',
                () => {
                    // In real application, make AJAX call to backend
                    removeUser(userId);
                    showAlert('info', `Akun "${userName}" berhasil dihapus!`);
                }
            );
        }

        function updateUserStatus(userId, status) {
            const userIndex = currentUsers.findIndex(user => user.id === userId);
            if (userIndex !== -1) {
                currentUsers[userIndex].status = status;
                displayUsers(getFilteredUsers());
            }
        }

        function removeUser(userId) {
            currentUsers = currentUsers.filter(user => user.id !== userId);
            displayUsers(getFilteredUsers());
        }

        function getFilteredUsers() {
            switch(currentFilter) {
                case 'rs':
                    return currentUsers.filter(user => user.role === 'rs');
                case 'pmi':
                    return currentUsers.filter(user => user.role === 'pmi');
                case 'pending':
                    return currentUsers.filter(user => user.status === 'pending');
                case 'all':
                default:
                    return currentUsers;
            }
        }

        function showConfirmationModal(title, message, buttonClass, callback) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalBody').textContent = message;
            
            const confirmButton = document.getElementById('confirmButton');
            confirmButton.className = `btn ${buttonClass}`;
            confirmButton.onclick = () => {
                callback();
                bootstrap.Modal.getInstance(document.getElementById('confirmationModal')).hide();
            };

            new bootstrap.Modal(document.getElementById('confirmationModal')).show();
        }

        function showAlert(type, message) {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Insert at top of content area
            const contentArea = document.querySelector('.content-area');
            contentArea.insertBefore(alertDiv, contentArea.firstChild);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        function getStatusText(status) {
            switch(status) {
                case 'pending': return 'Menunggu';
                case 'approved': return 'Disetujui';
                case 'rejected': return 'Ditolak';
                default: return status;
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('userSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const filteredUsers = getFilteredUsers().filter(user => 
                        user.name.toLowerCase().includes(searchTerm) || 
                        user.email.toLowerCase().includes(searchTerm)
                    );
                    displayUsers(filteredUsers);
                });
            }

            // Update dashboard link to work properly
            const dashboardLink = document.querySelector('.sidebar-item[href*="verification-dashboard"]');
            if (dashboardLink) {
                dashboardLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showDashboard();
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
