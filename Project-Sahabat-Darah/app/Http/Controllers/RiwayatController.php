<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input ID blood_request
        $request->validate([
            'blood_request_id' => 'required|exists:blood_requests,id',
        ]);

        // Ambil data dari blood_requests
        $bloodRequest = BloodRequest::findOrFail($request->blood_request_id);

        // Simpan ke tabel transactions
        Transaction::create([
            'blood_request_id'   => $bloodRequest->id,
            'patient_name'       => $bloodRequest->patient_name,
            'tanggal_transaksi'  => $bloodRequest->updated_at,
        ]);

        return redirect()->back()->with('success', 'Riwayat transaksi berhasil disimpan!');
    }

    // (Opsional) untuk menampilkan riwayat transaksi
    public function index()
    {
        $transactions = Transaction::with('bloodRequest')->get()->map(function ($trx) {
            return (object) [
                'name' => $trx->patient_name,
                'transaction_date' => $trx->tanggal_transaksi,
                'status' => $trx->bloodRequest->status ?? 'Unknown',
            ];
        });

        return view('rs.riwayat', compact('transactions'));
    }
    
}

