<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Untuk sementara, kita buat data dummy atau kosong
        $trackingData = [];
        
        return view('rs.tracking.index', compact('trackingData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Tampilkan daftar tracking untuk RS Admin
     */
    public function rsIndex()
    {
        $bloodRequests = BloodRequest::where('status', 'accepted')
            ->with(['rumahSakit', 'pmi'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('rs.tracking.index', compact('bloodRequests'));
    }

    /**
     * Tampilkan detail tracking untuk RS Admin
     */
    public function rsShow(BloodRequest $bloodRequest)
    {
        $bloodRequest->load(['rumahSakit', 'pmi']);
        
        return view('rs.tracking.show', compact('bloodRequest'));
    }

    /**
     * Tampilkan daftar tracking untuk PMI Admin
     */
    public function pmiIndex()
    {
        $bloodRequests = BloodRequest::where('status', 'accepted')
            ->with(['rumahSakit', 'pmi'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('pmi.tracking.index', compact('bloodRequests'));
    }

    /**
     * Tampilkan detail tracking untuk PMI Admin
     */
    public function pmiShow(BloodRequest $bloodRequest)
    {
        $bloodRequest->load(['rumahSakit', 'pmi']);
        
        return view('pmi.tracking.show', compact('bloodRequest'));
    }

    /**
     * Update status pengiriman (hanya PMI yang bisa update)
     */
    public function updateStatus(Request $request, BloodRequest $bloodRequest)
    {
        $request->validate([
            'delivery_status' => 'required|in:preparing,shipped,delivered',
            'tracking_notes' => 'nullable|string|max:500'
        ]);

        $bloodRequest->update([
            'delivery_status' => $request->delivery_status,
            'tracking_notes' => $request->tracking_notes,
            'updated_at' => now()
        ]);

        // Buat notifikasi untuk RS
        $statusText = [
            'preparing' => 'sedang dipersiapkan',
            'shipped' => 'dalam perjalanan',
            'delivered' => 'telah dikirim'
        ];

        Notification::create([
            'blood_request_id' => $bloodRequest->id,
            'title' => 'Update Status Pengiriman',
            'message' => "Status pengiriman darah untuk {$bloodRequest->patient_name} {$statusText[$request->delivery_status]}",
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui');
    }
}