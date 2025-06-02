<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\BloodInventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RiwayatController;

// Halaman Utama (Dashboard)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk menampilkan halaman beforelogin.blade.php (Pilihan Login/Register)
Route::get('/before-login', function () {
    return view('beforelogin');
})->name('before-login');

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Registration Routes - Modified to redirect to before-login after registration
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
    ->name('register.submit');

// RS Routes
Route::prefix('rs')->name('rs.')->middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin-rs'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'rsDashboard'])->name('dashboard');
    Route::resource('blood-requests', BloodRequestController::class)->only(['create', 'store']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    
    // PMI Locations
    Route::get('/pmi-locations', [\App\Http\Controllers\PMILocationController::class, 'index'])->name('pmi-locations.index');
    Route::get('/pmi-locations/data', [\App\Http\Controllers\PMILocationController::class, 'getLocations'])->name('pmi-locations.data');
    Route::post('/pmi-locations/nearest', [\App\Http\Controllers\PMILocationController::class, 'findNearest'])->name('pmi-locations.nearest');
   });

// PMI Routes
Route::prefix('pmi')->name('pmi.')->middleware(['web', 'auth', 'role:admin-pmi'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'pmiDashboard'])->name('dashboard');
    Route::resource('blood-requests', BloodRequestController::class)->only(['index', 'show', 'update']);

    // Blood Inventory
    Route::get('/blood-inventory', [BloodInventoryController::class, 'index'])->name('blood-inventory.index');
    Route::post('/blood-inventory', [BloodInventoryController::class, 'store'])->name('blood-inventory.store');
    Route::put('/blood-inventory/{inventory}', [BloodInventoryController::class, 'update'])->name('blood-inventory.update');
    Route::delete('/blood-inventory/{inventory}', [BloodInventoryController::class, 'destroy'])->name('blood-inventory.destroy');
});

// Login user (API - kemungkinan tidak terpakai untuk login web)
// Route::post('/api/login', [AuthController::class, 'login']);

// Login untuk web berdasarkan role - Form Routes
Route::get('/login/superuser', function() {
    return view('Auth.login-superuser');
})->name('login.superuser.form');

Route::get('/login/rs', function() {
    return view('Auth.login-rs');
})->name('login.rs.form');

Route::get('/login/pmi', function() {
    return view('Auth.login-pmi');
})->name('login.pmi.form');

// Login untuk web berdasarkan role - Processing Routes
Route::post('/login/superuser', [AuthController::class, 'loginSuperuserWeb'])->name('login.superuser');
Route::post('/login/rs', [AuthController::class, 'loginRSWeb'])->name('login.rs');
Route::post('/login/pmi', [AuthController::class, 'loginPMIWeb'])->name('login.pmi');
Route::get('/logout', [AuthController::class, 'logoutWeb'])->name('logout');

// Get user yang sedang login (API)
Route::middleware('auth:sanctum')->get('/api/user', [AuthController::class, 'getLoggedInUser']);

// Document Verification Routes (Super Admin Only)
Route::prefix('document-verification')->name('document-verification.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Auth\DocumentVerificationController::class, 'index'])->name('index');
    Route::post('/{id}/verify', [App\Http\Controllers\Auth\DocumentVerificationController::class, 'verify'])->name('verify');
});

// Super Admin Verification Dashboard Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/verification-dashboard', [App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('verification-dashboard');
    Route::get('/document-verification/{userId}', [App\Http\Controllers\SuperAdminController::class, 'viewDocument'])->name('document-verification');
    Route::post('/verify-user/{userId}', [App\Http\Controllers\SuperAdminController::class, 'verifyUser'])->name('verify-user');
    Route::get('/users', [App\Http\Controllers\SuperAdminController::class, 'listUsers'])->name('users');
});

Route::get('/riwayat', function () { 
    return view('rs.riwayat'); 
});

Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
