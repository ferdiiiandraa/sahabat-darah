<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BloodInventoryController;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('dashboard');
});

// RS Routes
Route::prefix('rs')->name('rs.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'rsDashboard'])->name('dashboard');
    Route::resource('blood-requests', BloodRequestController::class)->only(['create', 'store']);
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
});

// PMI Routes
Route::prefix('pmi')->name('pmi.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'pmiDashboard'])->name('dashboard');
    Route::resource('blood-requests', BloodRequestController::class)->only(['index', 'show', 'update']);
    
    // Blood Inventory
    Route::get('/blood-inventory', [BloodInventoryController::class, 'index'])->name('blood-inventory.index');
    Route::post('/blood-inventory', [BloodInventoryController::class, 'store'])->name('blood-inventory.store');
    Route::put('/blood-inventory/{inventory}', [BloodInventoryController::class, 'update'])->name('blood-inventory.update');
    Route::delete('/blood-inventory/{inventory}', [BloodInventoryController::class, 'destroy'])->name('blood-inventory.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Home
// routes/web.php
Route::get('/rs/dashboard', function () {
    // Pastikan variabel-variabel ini tersedia atau diganti dengan controller jika perlu
    return view('rs.dashboard', [
        'totalRequests' => 0, 
        'acceptedRequests' => 0, 
        'pendingRequests' => 0, 
        'recentRequests' => collect(), 
        'unreadNotifications' => 0
    ]);
})->name('rs.dashboard');







