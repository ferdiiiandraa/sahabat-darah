<?php

namespace App\Http\Controllers;

use App\Models\BloodInventory;
use Illuminate\Http\Request;

class BloodInventoryController extends Controller
{
    public function index()
    {
        $inventory = BloodInventory::all();
        return view('pmi.blood-inventory.index', compact('inventory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blood_type' => 'required|string|in:A,B,AB,O',
            'rhesus' => 'required|string|in:+,-',
            'quantity' => 'required|integer|min:0',
        ]);

        BloodInventory::create($validated);

        return redirect()->route('pmi.blood-inventory.index')
            ->with('success', 'Stok darah berhasil ditambahkan');
    }

    public function update(Request $request, BloodInventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update($validated);

        return redirect()->route('pmi.blood-inventory.index')
            ->with('success', 'Stok darah berhasil diperbarui');
    }

    public function destroy(BloodInventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('pmi.blood-inventory.index')
            ->with('success', 'Stok darah berhasil dihapus');
    }
} 