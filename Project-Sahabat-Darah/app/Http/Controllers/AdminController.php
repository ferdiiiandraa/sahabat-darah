<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Notification;
use App\Models\BloodInventory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function rsDashboard()
    {
        $recentRequests = BloodRequest::latest()->take(5)->get();
        $unreadNotifications = Notification::where('is_read', false)->count();
        
        // Get statistics
        $totalRequests = BloodRequest::count();
        $acceptedRequests = BloodRequest::where('status', 'accepted')->count();
        $pendingRequests = BloodRequest::where('status', 'pending')->count();
        
        return view('rs.dashboard', compact(
            'recentRequests',
            'unreadNotifications',
            'totalRequests',
            'acceptedRequests',
            'pendingRequests'
        ));
    }

    public function pmiDashboard()
    {
        $pendingRequests = BloodRequest::where('status', 'pending')->count();
        $acceptedRequests = BloodRequest::where('status', 'accepted')->count();
        $rejectedRequests = BloodRequest::where('status', 'rejected')->count();
        $recentRequests = BloodRequest::latest()->take(5)->get();
        
        // Dapatkan stok darah saat ini
        $bloodInventory = BloodInventory::all();
        
        // Grouping stok darah berdasarkan golongan darah
        $bloodStock = [];
        foreach ($bloodInventory as $stock) {
            $key = $stock->blood_type . $stock->rhesus;
            $bloodStock[$key] = $stock;
        }
        
        return view('pmi.dashboard', compact(
            'pendingRequests',
            'acceptedRequests',
            'rejectedRequests',
            'recentRequests',
            'bloodStock'
        ));
    }
}
