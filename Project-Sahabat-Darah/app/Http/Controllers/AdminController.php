<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Notification;
use App\Models\BloodInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PMI;
use Illuminate\Support\Facades\Log;

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
        try {
            $user = Auth::user();
            
            // Get PMI data
            $pmi = PMI::where('email', $user->email)->first();
            
            if (!$pmi) {
                Auth::logout();
                return redirect()->route('login.pmi.form')
                    ->with('error', 'Data PMI tidak ditemukan.');
            }

            // Get blood inventory data
            $bloodInventory = BloodInventory::where('pmi_id', $pmi->id)->get();
            
            // Get recent blood requests
            $bloodRequests = BloodRequest::with(['rumahSakit'])
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('pmi.dashboard', [
                'pmi' => $pmi,
                'bloodInventory' => $bloodInventory,
                'bloodRequests' => $bloodRequests
            ]);
        } catch (\Exception $e) {
            Log::error('Error in PMI dashboard: ' . $e->getMessage());
            return redirect()->route('login.pmi.form')
                ->with('error', 'Terjadi kesalahan saat mengakses dashboard.');
        }
    }
}
