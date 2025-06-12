<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice; // Pastikan ini di-import
use App\Models\Notification; // Diperlukan untuk notifikasi pembayaran
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Diperlukan untuk logging

class PaymentController extends Controller
{
    /**
     * Show the form for creating a new payment.
     * (Route ini akan dipanggil oleh action form `rs.payments.store/{invoice}`)
     * Namun, karena form pembayaran kini ada di dashboard, create method ini tidak lagi dipanggil langsung oleh user,
     * melainkan hanya menerima data dari form di dashboard.
     */
    public function create(Invoice $invoice)
    {
        // Ini mungkin tidak lagi relevan jika pembayaran dilakukan langsung dari dashboard.
        // Anda bisa menghapus method ini jika tidak digunakan, atau menjadikannya redirect.
        return redirect()->route('rs.dashboard')->with('error', 'Akses tidak langsung ke form pembayaran.');
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request, Invoice $invoice) // Menggunakan Route Model Binding untuk Invoice
    {
        // Pastikan RS yang mencoba membayar adalah pemilik invoice ini
        // Asumsi bloodRequest memiliki 'rumah_sakit_id' yang sama dengan Auth::user()->id
        if (Auth::user()->id !== $invoice->bloodRequest->rumah_sakit_id) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan invoice belum lunas
        if ($invoice->status === 'paid') {
            return redirect()->back()->with('error', 'Invoice ini sudah lunas.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:transfer_bank,qris,ewallet,cash,credit',
            'amount' => 'required|numeric|min:0', // Pastikan jumlah pembayaran tidak negatif
            'payment_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);

        // Cek apakah jumlah pembayaran mencukupi total invoice
        if ($validated['amount'] < $invoice->total) {
            return redirect()->back()->with('error', 'Jumlah pembayaran kurang dari total invoice. Harap bayar sesuai total invoice.');
        }

        DB::beginTransaction(); // Memulai transaksi database

        try {
            $filePath = null;
            if ($request->hasFile('proof_of_payment')) {
                // Simpan bukti pembayaran ke storage
                $filePath = $request->file('proof_of_payment')->store('payments', 'public');
            }

            // Buat entri Payment baru
            Payment::create([
                'invoice_id' => $invoice->transaction_id, // Menggunakan transaction_id dari invoice
                'description' => $validated['description'],
                'payment_method' => $validated['payment_method'],
                'price' => $validated['amount'], // Kolom 'price' di tabel payments seharusnya adalah jumlah yang dibayarkan
                'payment_date' => $validated['payment_date'],
                'file_path' => $filePath,
            ]);

            // Perbarui status invoice menjadi 'paid'
            $invoice->update(['status' => 'paid']);

            // Buat notifikasi untuk admin PMI bahwa pembayaran telah diterima
            Notification::create([
                'blood_request_id' => $invoice->blood_request_id, // Terkait dengan permintaan darah yang sama
                'title' => 'Pembayaran Invoice Diterima',
                'message' => "Pembayaran untuk Invoice #{$invoice->transaction_id} sebesar Rp" . number_format($validated['amount'], 0, ',', '.') . " telah diterima dari RS.",
                'is_read' => false,
            ]);

            DB::commit(); // Commit transaksi jika semua operasi berhasil

            return redirect()->route('rs.dashboard')->with('success', 'Pembayaran berhasil dikirim. Invoice telah lunas.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan
            Log::error('Error processing payment: ' . $e->getMessage()); // Catat kesalahan ke log
            // Hapus file yang sudah terupload jika terjadi kesalahan di tengah transaksi
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
}