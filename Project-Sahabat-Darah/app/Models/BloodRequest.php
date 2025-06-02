<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'blood_type',
        'rhesus',
        'request_date',
        'hospital_phone',
        'hospital_address',
        'status',
        'used_alternative_blood_type',
    ];

    protected $casts = [
        'request_date' => 'datetime',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

}
