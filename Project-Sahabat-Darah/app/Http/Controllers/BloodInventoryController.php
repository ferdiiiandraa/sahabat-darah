<?php

namespace App\Http\Controllers;

use App\Models\BloodInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloodInventoryController extends Controller
{
    public function index()
    {
        // Hanya tampilkan stok yang dimiliki oleh PMI yang sedang login
        $bloodInventories = BloodInventory::where('pmi_id', Auth::user()->id)->latest()->paginate(10);
        return view('pmi.blood-inventory.index', compact('bloodInventories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blood_type' => 'required|string|in:A,B,AB,O',
            'rhesus' => 'required|string|in:+,-',
            'quantity' => 'required|integer|min:0',
        ]);

        // Mengisi pmi_id dengan ID user PMI yang sedang login
        $validated['pmi_id'] = Auth::user()->id;

        BloodInventory::create($validated);

        return redirect()->route('pmi.blood-inventory.index')
            ->with('success', 'Stok darah berhasil ditambahkan');
    }

    public function update(Request $request, BloodInventory $inventory)
    {
        // Pastikan PMI yang login memiliki hak untuk mengupdate stok ini
        if (Auth::user()->id !== $inventory->pmi_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update($validated);

        return redirect()->route('pmi.blood-inventory.index')
            ->with('success', 'Stok darah berhasil diperbarui');
    }

    public function destroy(BloodInventory $inventory)
    {
        // Pastikan PMI yang login memiliki hak untuk menghapus stok ini
        if (Auth::user()->id !== $inventory->pmi_id) {
            abort(403, 'Unauthorized action.');
        }

        $inventory->delete();

        return redirect()->route('pmi.blood-inventory.index')
            ->with('success', 'Stok darah berhasil dihapus');
    }
}