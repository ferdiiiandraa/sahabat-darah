<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodInventory extends Model
{
    use HasFactory;

    protected $table = 'blood_inventories'; // Pastikan nama tabel benar

    protected $fillable = [
        'pmi_id',
        'blood_type',
        'rhesus',
        'quantity',
        'last_updated',
    ];

    /**
     * Decrement the quantity of the blood inventory.
     *
     * @param int $amount The amount to decrement. Defaults to 1.
     * @return bool
     */
    public function decrementQuantity(int $amount = 1)
    {
        if ($this->quantity >= $amount) {
            $this->quantity -= $amount;
            return $this->save();
        }
        return false; // Or throw an exception if quantity is insufficient
    }

    /**
     * Find blood inventory by blood type and rhesus.
     *
     * @param string $bloodType
     * @param string $rhesus
     * @return \App\Models\BloodInventory|null
     */
    public static function findByBloodTypeAndRhesus($bloodType, $rhesus)
    {
        return static::where('blood_type', $bloodType)
                     ->where('rhesus', $rhesus)
                     ->first();
    }

    // Relasi ke PMI jika diperlukan
    public function pmi()
    {
        return $this->belongsTo(USER::class, 'pmi_id');
    }
}