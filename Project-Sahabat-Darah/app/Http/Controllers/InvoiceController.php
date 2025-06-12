<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices for the authenticated RS.
     */
    public function index()
    {
        $user = Auth::user();
        // Menggunakan 'rumah_sakit_id' untuk memfilter permintaan darah berdasarkan RS yang login
        $bloodRequestIds = BloodRequest::where('rumah_sakit_id', $user->id)->pluck('id');
        $invoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)->with('bloodRequest', 'payment')->latest()->paginate(10);

        return view('rs.invoices.index', compact('invoices'));
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        // Memastikan RS yang login hanya bisa melihat invoice yang terkait dengan permintaannya
        if (Auth::user()->id !== $invoice->bloodRequest->rumah_sakit_id) {
            abort(403, 'Unauthorized action.');
        }
        $invoice->load('bloodRequest', 'payment');
        return view('rs.invoices.show', compact('invoice'));
    }

    /**
     * Display a listing of payments for PMI admin.
     */
    public function pmiIndex()
    {
        $user = Auth::user();
        // Memfilter invoice berdasarkan pmi_id yang terkait dengan blood requests
        $bloodRequestIds = BloodRequest::where('pmi_id', $user->id)->pluck('id');
        $invoices = Invoice::whereIn('blood_request_id', $bloodRequestIds)
                            ->with('bloodRequest', 'payment')
                            ->latest()
                            ->paginate(10);

        return view('pmi.invoices.index', compact('invoices'));
    }
}