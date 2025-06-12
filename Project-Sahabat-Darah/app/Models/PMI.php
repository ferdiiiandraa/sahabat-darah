<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMI extends Model
{
    use HasFactory;

    protected $table = 'pmis';

    protected $fillable = [
        'namainstitusi',
        'email',
        'alamat',
        'telepon',
        'dokumen',
        'is_verified',
        'latitude',
        'longitude',
        // 'user_id',
    ];

    // Definisikan relasi ke model User jika ada
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
