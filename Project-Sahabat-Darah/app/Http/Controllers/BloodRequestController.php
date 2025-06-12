<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Notification;
use App\Models\BloodInventory;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Diperlukan untuk Auth::user()->id
use Illuminate\Support\Facades\Log; // Diperlukan untuk Log::error

class BloodRequestController extends Controller
{
    /**
     * Menampilkan form untuk membuat permintaan darah baru (untuk RS).
     */
    public function create()
    {
        return view('rs.blood-requests.create');
    }

    /**
     * Menyimpan permintaan darah baru (dari RS).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'blood_type' => 'required|in:A,B,AB,O',
            'rhesus' => 'required|in:+,-',
            'request_date' => 'required|date',
            'hospital_phone' => 'required|string|max:20',
            'hospital_address' => 'required|string',
            'quantity' => 'required|integer|min:1', // Menambahkan validasi untuk quantity
        ]);

        // Mengisi `rumah_sakit_id` dengan ID user RS yang sedang login
        $validated['rumah_sakit_id'] = Auth::user()->id;
        // Kolom `pmi_id` akan diisi saat PMI menyetujui/menolak permintaan

        $bloodRequest = BloodRequest::create($validated);

        // Membuat notifikasi untuk admin PMI
        Notification::create([
            'blood_request_id' => $bloodRequest->id,
            'title' => 'Permintaan Darah Baru',
            'message' => "Permintaan darah baru dari {$bloodRequest->patient_name} dengan golongan darah {$bloodRequest->blood_type}{$bloodRequest->rhesus} sejumlah {$bloodRequest->quantity} kantong.", // Menambahkan quantity ke pesan
            'is_read' => false,
        ]);

        return redirect()->route('rs.dashboard')
            ->with('success', 'Permintaan darah berhasil dikirim');
    }

    /**
     * Menampilkan daftar permintaan darah (untuk PMI).
     */
    public function index()
    {
        // Filter permintaan berdasarkan PMI yang sedang login
        // Ini akan menampilkan permintaan yang sudah "ditangani" atau ditugaskan ke PMI ini.
        // Jika ingin melihat semua permintaan pending yang belum ditangani, logika perlu diubah.
        $bloodRequests = BloodRequest::where('pmi_id', Auth::user()->id)
                                     ->latest()
                                     ->paginate(10);
        return view('pmi.blood-requests.index', compact('bloodRequests'));
    }

    /**
     * Menampilkan detail permintaan darah (untuk PMI).
     */
    public function show(BloodRequest $bloodRequest)
    {
        // Pastikan PMI yang login hanya bisa melihat permintaan yang terkait dengannya.
        // Jika pmi_id masih null (permintaan baru), maka PMI manapun bisa melihatnya untuk ditindak.
        if ($bloodRequest->pmi_id !== null && Auth::user()->id !== $bloodRequest->pmi_id) {
            abort(403, 'Unauthorized action.');
        }

        // Cari stok darah yang sesuai dengan permintaan
        $inventory = BloodInventory::findByBloodTypeAndRhesus(
            $bloodRequest->blood_type,
            $bloodRequest->rhesus
        );

        // Jika inventory tidak ditemukan, set quantity ke 0
        $availableStock = $inventory ? $inventory->quantity : 0;

        // Cari semua stok darah untuk rekomendasi alternatif
        $allInventory = BloodInventory::all()->keyBy(function($item) {
            return $item->blood_type . $item->rhesus;
        });

        // Dapatkan alternatif kompatibel berdasarkan golongan darah
        $compatibleTypes = $this->getCompatibleBloodTypes($bloodRequest->blood_type, $bloodRequest->rhesus);

        // Filter stok yang tersedia untuk golongan darah yang kompatibel
        $alternativeStocks = [];
        foreach ($compatibleTypes as $type) {
            if (isset($allInventory[$type]) && $allInventory[$type]->quantity > 0) {
                $alternativeStocks[$type] = $allInventory[$type]->quantity;
            }
        }

        return view('pmi.blood-requests.show', compact(
            'bloodRequest',
            'availableStock',
            'alternativeStocks'
        ));
    }

    /**
     * Memperbarui status permintaan darah (oleh PMI).
     */
    public function update(Request $request, BloodRequest $bloodRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'alternative_blood_type' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Mengisi `pmi_id` dengan ID user PMI yang sedang login saat menyetujui/menolak
            // Ini akan memastikan blood_request terkait dengan PMI yang menanganinya.
            $bloodRequest->pmi_id = Auth::user()->id;

            // Jika status diterima, cek dan kurangi stok darah, lalu buat invoice
            if ($validated['status'] === 'accepted') {
                $useAlternative = !empty($validated['alternative_blood_type']);
                $bloodTypeToUse = $bloodRequest->blood_type;
                $rhesusToUse = $bloodRequest->rhesus;

                if ($useAlternative) {
                    $bloodTypeParts = $this->parseBloodType($validated['alternative_blood_type']);
                    $bloodTypeToUse = $bloodTypeParts['type'];
                    $rhesusToUse = $bloodTypeParts['rhesus'];
                }

                // Cari stok darah yang sesuai (baik asli atau alternatif)
                $inventory = BloodInventory::findByBloodTypeAndRhesus($bloodTypeToUse, $rhesusToUse);

                // Cek ketersediaan stok
                if (!$inventory) {
                    DB::rollBack();
                    $message = "Stok darah golongan {$bloodTypeToUse}{$rhesusToUse} tidak tersedia sama sekali. ";
                    $message .= "Silakan tambahkan stok terlebih dahulu atau gunakan golongan darah yang kompatibel lainnya.";
                    return redirect()->back()->with('error', $message);
                }

                // Cek kecukupan stok berdasarkan quantity yang diminta
                if ($inventory->quantity < $bloodRequest->quantity) {
                    DB::rollBack();
                    $message = "Stok darah golongan {$bloodTypeToUse}{$rhesusToUse} tidak mencukupi (tersisa {$inventory->quantity} kantong). ";
                    $message .= "Permintaan sejumlah {$bloodRequest->quantity} kantong. Silakan tambahkan stok terlebih dahulu.";
                    return redirect()->back()->with('error', $message);
                }

                // Perbarui status permintaan dan informasi golongan darah alternatif yang digunakan
                $bloodRequest->update([
                    'status' => $validated['status'],
                    'used_alternative_blood_type' => $useAlternative ? $bloodTypeToUse . $rhesusToUse : null
                ]);

                // Kurangi stok darah sebanyak quantity yang diminta
                $inventory->decrementQuantity($bloodRequest->quantity);

                // Buat Invoice
                $pricePerUnit = 500000; // Harga per 1 quantity/kantong darah = Rp 500.000,00
                $totalPrice = $bloodRequest->quantity * $pricePerUnit; // Hitung total harga

                Invoice::create([
                    'blood_request_id' => $bloodRequest->id,
                    'amount' => $bloodRequest->quantity, // Jumlah kantong darah
                    'price' => $pricePerUnit, // Harga per kantong
                    'total' => $totalPrice, // Total harga
                    'status' => 'unpaid', // Status awal invoice
                ]);

            } else { // Jika status ditolak, cukup perbarui status
                $bloodRequest->update(['status' => $validated['status']]);
            }

            // Buat notifikasi untuk admin RS
            $statusText = $validated['status'] === 'accepted' ? 'diterima' : 'ditolak';
            $message = "Permintaan darah untuk {$bloodRequest->patient_name} telah {$statusText}";

            if ($validated['status'] === 'accepted' && !empty($bloodRequest->used_alternative_blood_type)) {
                $message .= " (menggunakan golongan darah {$bloodRequest->used_alternative_blood_type})";
            }

            Notification::create([
                'blood_request_id' => $bloodRequest->id,
                'title' => 'Update Status Permintaan',
                'message' => $message,
                'is_read' => false,
            ]);

            DB::commit(); // Commit transaksi database jika semua berhasil

            return redirect()->route('pmi.blood-requests.index')
                ->with('success', 'Status permintaan berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan
            Log::error('Error updating blood request: ' . $e->getMessage()); // Catat kesalahan ke log
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage() . '. Pastikan kolom `quantity`, `rumah_sakit_id`, dan `pmi_id` ada di tabel `blood_requests`.');
        }
    }

    /**
     * Memparsing string golongan darah (misal: "A+", "B-") menjadi array dengan kunci 'type' dan 'rhesus'.
     *
     * @param string $bloodTypeString
     * @return array
     */
    private function parseBloodType($bloodTypeString)
    {
        $bloodTypeString = trim($bloodTypeString);
        $lastChar = substr($bloodTypeString, -1);

        if ($lastChar === '+' || $lastChar === '-') {
            return [
                'type' => substr($bloodTypeString, 0, -1),
                'rhesus' => $lastChar
            ];
        }

        // Default jika format tidak sesuai (misal hanya "A")
        return [
            'type' => $bloodTypeString,
            'rhesus' => '+'
        ];
    }

    /**
     * Mendapatkan daftar golongan darah yang kompatibel untuk penerima tertentu.
     *
     * @param string $bloodType
     * @param string $rhesus
     * @return array
     */
    private function getCompatibleBloodTypes($bloodType, $rhesus)
    {
        $compatible = [];

        // Aturan kompatibilitas:
        // - Penerima A+ dapat menerima dari A+, A-, O+, O-
        // - Penerima A- dapat menerima dari A-, O-
        // - Penerima B+ dapat menerima dari B+, B-, O+, O-
        // - Penerima B- dapat menerima dari B-, O-
        // - Penerima AB+ dapat menerima dari semua golongan darah
        // - Penerima AB- dapat menerima dari semua golongan darah dengan rhesus negatif
        // - Penerima O+ dapat menerima dari O+, O-
        // - Penerima O- hanya dapat menerima dari O-

        switch ($bloodType . $rhesus) {
            case 'A+':
                $compatible = ['A+', 'A-', 'O+', 'O-'];
                break;
            case 'A-':
                $compatible = ['A-', 'O-'];
                break;
            case 'B+':
                $compatible = ['B+', 'B-', 'O+', 'O-'];
                break;
            case 'B-':
                $compatible = ['B-', 'O-'];
                break;
            case 'AB+':
                $compatible = ['AB+', 'AB-', 'A+', 'A-', 'B+', 'B-', 'O+', 'O-'];
                break;
            case 'AB-':
                $compatible = ['AB-', 'A-', 'B-', 'O-'];
                break;
            case 'O+':
                $compatible = ['O+', 'O-'];
                break;
            case 'O-':
                $compatible = ['O-'];
                break;
        }

        return $compatible;
    }
}