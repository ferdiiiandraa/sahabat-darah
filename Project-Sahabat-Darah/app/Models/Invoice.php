<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice'; // Specify the table name if it's not the plural form of the model name

    protected $fillable = [
        'blood_request_id',
        'amount',
        'price',
        'total',
        'status',
        'transaction_id',
    ];

    /**
     * Get the blood request associated with the invoice.
     */
    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }

    /**
     * Get the payment associated with the invoice.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'invoice_id', 'transaction_id');
    }
}