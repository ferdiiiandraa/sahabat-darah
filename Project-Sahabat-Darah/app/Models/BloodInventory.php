<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'blood_type',
        'rhesus',
        'quantity'
    ];
    
    /**
     * Mengurangi stok darah
     * 
     * @param int $amount
     * @return bool
     */
    public function decrementQuantity($amount = 1)
    {
        if ($this->quantity >= $amount) {
            $this->quantity -= $amount;
            return $this->save();
        }
        
        return false;
    }
    
    /**
     * Mencari inventory berdasarkan golongan darah dan rhesus
     */
    public static function findByBloodTypeAndRhesus($bloodType, $rhesus)
    {
        return self::where('blood_type', $bloodType)
                ->where('rhesus', $rhesus)
                ->first();
    }
} 