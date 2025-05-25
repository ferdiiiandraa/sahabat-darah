<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    // Verification status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    
    protected $fillable = [
        'user_id',
        'document_type',
        'file_path',
        'is_verified',
        'verification_status',
        'verification_notes'
    ];

    protected $casts = [
        'is_verified' => 'boolean'
    ];
    
    protected $attributes = [
        'verification_status' => self::STATUS_PENDING
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Check if the document is pending verification
     */
    public function isPending()
    {
        return $this->verification_status === self::STATUS_PENDING;
    }
    
    /**
     * Check if the document is approved
     */
    public function isApproved()
    {
        return $this->verification_status === self::STATUS_APPROVED || $this->is_verified === true;
    }
    
    /**
     * Check if the document is rejected
     */
    public function isRejected()
    {
        return $this->verification_status === self::STATUS_REJECTED;
    }
}
