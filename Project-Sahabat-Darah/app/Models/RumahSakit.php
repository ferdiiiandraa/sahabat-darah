<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    use HasFactory;

    protected $fillable = [
        'namainstitusi',
        'email', // Jika email disimpan di sini
        'alamat',
        'telepon',
        'dokumen',
        'is_verified', // Jika is_verified disimpan di sini
        // 'user_id', // Jika ada foreign key ke user
    ];

    // Definisikan relasi ke model User jika ada
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}