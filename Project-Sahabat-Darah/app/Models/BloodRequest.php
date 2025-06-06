<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'pmi_id',
        'patient_name',
        'blood_type',
        'rhesus',
        'quantity',
        'urgency_level',
        'request_date',
        'hospital_phone',
        'hospital_address',
        'status',
        'used_alternative_blood_type',
        'notes'
    ];

    protected $casts = [
        'request_date' => 'datetime',
    ];

    /**
     * Relasi: BloodRequest dimiliki oleh sebuah rumah sakit (hospital).
     * Diasumsikan rumah sakit adalah user dengan role tertentu.
     */
    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    /**
     * Relasi: BloodRequest berhubungan dengan PMI (jika ditugaskan).
     * Diasumsikan PMI juga merupakan user dengan role tertentu.
     */
    public function pmi()
    {
        return $this->belongsTo(User::class, 'pmi_id');
    }

    /**
     * Relasi: BloodRequest memiliki satu transaksi darah.
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * Relasi: BloodRequest memiliki banyak notifikasi.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
