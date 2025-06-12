<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Notification;
use App\Models\BloodInventory;
use App\Models\Invoice; // Pastikan ini sudah di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PMI;
use App\Models\USER;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function rsDashboard()
    {
        $user = Auth::user();
        $recentRequests = BloodRequest::where('rumah_sakit_id', $user->id)->latest()->take(5)->get();
        $unreadNotifications = Notification::where('is_read', false)->count();

        // Get statistics
        $totalRequests = BloodRequest::where('rumah_sakit_id', $user->id)->count();
        $acceptedRequests = BloodRequest::where('rumah_sakit_id', $user->id)->where('status', 'accepted')->count();
        $pendingRequests = BloodRequest::where('rumah_sakit_id', $user->id)->where('status', 'pending')->count();

        // Get Invoice Stats for RS
        $bloodRequestIds = BloodRequest::where('rumah_sakit_id', $user->id)->pluck('id');
        $totalInvoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)->count();
        $paidInvoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)->where('status', 'paid')->count();

        // Ambil invoice yang belum lunas untuk RS yang sedang login
        // Filter invoice berdasarkan blood_request_id yang dimiliki oleh RS tersebut
        $unpaidInvoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)
                                 ->where('status', 'unpaid')
                                 ->get();

        return view('rs.dashboard', compact(
            'recentRequests',
            'unreadNotifications',
            'totalRequests',
            'acceptedRequests',
            'pendingRequests',
            'totalInvoices',
            'paidInvoices',
            'unpaidInvoices' // Tambahkan ini
        ));
    }

    public function pmiDashboard()
    {
        try {
            $user = Auth::user();

            // Get PMI data
            $pmi = USER::where('email', $user->email)->first(); //

            if (!$pmi) {
                Auth::logout();
                return redirect()->route('login.pmi.form')
                    ->with('error', 'Data PMI tidak ditemukan.');
            }

            // Get blood inventory data
            $bloodInventory = BloodInventory::where('pmi_id', $pmi->id)->get(); //

            // Prepare bloodStock array from bloodInventory
            $bloodStock = [];
            foreach ($bloodInventory as $item) {
                if ($item->blood_type && $item->rhesus) { // Tambahkan pengecekan ini
                    $bloodStock[$item->blood_type . $item->rhesus] = $item;
                }
            }
            // Get recent blood requests
            $bloodRequests = BloodRequest::with(['rumahSakit'])
                ->where('pmi_id', $pmi->id) // Menambahkan filter pmi_id
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(); //

            // Calculate pending, accepted, and rejected requests for stats
            $pendingRequests = BloodRequest::where('pmi_id', $pmi->id)->where('status', 'pending')->count();
            $acceptedRequests = BloodRequest::where('pmi_id', $pmi->id)->where('status', 'accepted')->count();
            $rejectedRequests = BloodRequest::where('pmi_id', $pmi->id)->where('status', 'rejected')->count(); // Assuming you have a 'rejected' status

            // Get Invoice Stats for PMI
            $bloodRequestIds = BloodRequest::where('pmi_id', $pmi->id)->pluck('id');
            $totalInvoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)->count();
            $unpaidInvoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)->where('status', 'unpaid')->count();
            $paidInvoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)->where('status', 'paid')->count();

            return view('pmi.dashboard', [
                'pmi' => $pmi,
                'bloodInventory' => $bloodInventory,
                'bloodRequests' => $bloodRequests,
                'bloodStock' => $bloodStock, // Pass the bloodStock to the view
                'pendingRequests' => $pendingRequests,
                'acceptedRequests' => $acceptedRequests,
                'rejectedRequests' => $rejectedRequests,
                'totalInvoices' => $totalInvoices,
                'unpaidInvoices' => $unpaidInvoices,
                'paidInvoices' => $paidInvoices,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in PMI dashboard: ' . $e->getMessage()); //
            return redirect()->route('login.pmi.form')
                ->with('error', 'Terjadi kesalahan saat mengakses dashboard.'); //
        }
    }
}