<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Notification;
use App\Models\BloodInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloodRequestController extends Controller
{
    public function create()
    {
        return view('rs.blood-requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'blood_type' => 'required|in:A,B,AB,O',
            'rhesus' => 'required|in:+,-',
            'request_date' => 'required|date',
            'hospital_phone' => 'required|string|max:20',
            'hospital_address' => 'required|string',
        ]);

        $bloodRequest = BloodRequest::create($validated);

        // Create notification for PMI admin
        Notification::create([
            'blood_request_id' => $bloodRequest->id,
            'title' => 'Permintaan Darah Baru',
            'message' => "Permintaan darah baru dari {$bloodRequest->patient_name} dengan golongan darah {$bloodRequest->blood_type}{$bloodRequest->rhesus}",
            'is_read' => false,
        ]);

        return redirect()->route('rs.dashboard')
            ->with('success', 'Permintaan darah berhasil dikirim');
    }

    public function index()
    {
        $bloodRequests = BloodRequest::latest()->paginate(10);
        return view('pmi.blood-requests.index', compact('bloodRequests'));
    }

    public function show(BloodRequest $bloodRequest)
    {
        // Cari stok darah yang sesuai dengan permintaan
        $inventory = BloodInventory::findByBloodTypeAndRhesus(
            $bloodRequest->blood_type,
            $bloodRequest->rhesus
        );
        
        // Jika inventory tidak ditemukan, set quantity ke 0
        $availableStock = $inventory ? $inventory->quantity : 0;
        
        // Cari semua stok darah untuk rekomendasi
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
     * Dapatkan golongan darah yang kompatibel
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

    public function update(Request $request, BloodRequest $bloodRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'alternative_blood_type' => 'nullable|string',
        ]);

        // Jika status accepted, cek dan kurangi stok darah
        if ($validated['status'] === 'accepted') {
            // Cek apakah menggunakan golongan darah alternatif
            $useAlternative = !empty($validated['alternative_blood_type']);
            
            // Ambil golongan darah dan rhesus untuk stok yang akan digunakan
            if ($useAlternative) {
                // Format golongan darah alternatif: "A+" or "O-"
                $bloodTypeParts = $this->parseBloodType($validated['alternative_blood_type']);
                $bloodType = $bloodTypeParts['type'];
                $rhesus = $bloodTypeParts['rhesus'];
            } else {
                // Gunakan golongan darah asli dari permintaan
                $bloodType = $bloodRequest->blood_type;
                $rhesus = $bloodRequest->rhesus;
            }
            
            // Cari stok darah yang sesuai
            $inventory = BloodInventory::findByBloodTypeAndRhesus($bloodType, $rhesus);

            // Cek apakah stok tersedia
            if (!$inventory) {
                $message = "Stok darah golongan {$bloodType}{$rhesus} tidak tersedia sama sekali. ";
                $message .= "Silakan tambahkan stok terlebih dahulu atau gunakan golongan darah yang kompatibel lainnya.";
                return redirect()->back()->with('error', $message);
            }
            
            if ($inventory->quantity < 1) {
                $message = "Stok darah golongan {$bloodType}{$rhesus} tidak mencukupi (tersisa {$inventory->quantity} kantong). ";
                $message .= "Silakan tambahkan stok terlebih dahulu.";
                return redirect()->back()->with('error', $message);
            }

            // Mulai transaksi database untuk memastikan konsistensi data
            DB::beginTransaction();
            
            try {
                // Update status permintaan
                $bloodRequest->update([
                    'status' => $validated['status'],
                    'used_alternative_blood_type' => $useAlternative ? $bloodType . $rhesus : null
                ]);
                
                // Kurangi stok darah
                $inventory->decrementQuantity();
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
            }
        } else {
            // Jika rejected, cukup update status
            $bloodRequest->update(['status' => $validated['status']]);
        }

        // Create notification for RS admin
        $statusText = $validated['status'] === 'accepted' ? 'diterima' : 'ditolak';
        $message = "Permintaan darah untuk {$bloodRequest->patient_name} telah {$statusText}";
        
        // Tambahkan informasi golongan darah alternatif jika digunakan
        if ($validated['status'] === 'accepted' && !empty($bloodRequest->used_alternative_blood_type)) {
            $message .= " (menggunakan golongan darah {$bloodRequest->used_alternative_blood_type})";
        }
        
        Notification::create([
            'blood_request_id' => $bloodRequest->id,
            'title' => 'Update Status Permintaan',
            'message' => $message,
            'is_read' => false,
        ]);

        return redirect()->route('pmi.blood-requests.index')
            ->with('success', 'Status permintaan berhasil diperbarui');
    }

    /**
     * Parse string golongan darah (A+, B-, dll) menjadi array dengan kunci type dan rhesus
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
        
        // Default jika format tidak sesuai
        return [
            'type' => $bloodTypeString,
            'rhesus' => '+'
        ];
    }
}
