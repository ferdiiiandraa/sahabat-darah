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
        'patient_name',
        'blood_type',
        'rhesus',
        'quantity',
        'urgency_level',
        'request_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'request_date' => 'datetime',
    ];

    // Relationship dengan Hospital/RS
    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    // Relationship dengan PMI (jika ada)
    public function pmi()
    {
        return $this->belongsTo(User::class, 'pmi_id');
    }
}
