<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment'; // Specify the table name

    protected $fillable = [
        'invoice_id',
        'description',
        'payment_method',
        'price',
        'payment_date',
        'file_path',
    ];

    /**
     * Get the invoice that owns the payment.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'transaction_id');
    }
}