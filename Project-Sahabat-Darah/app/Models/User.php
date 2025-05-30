<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Status verifikasi
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'telepon',
        'role',
        'rumah_sakit_id',
        'pmi_id',
        'document_path',
        'is_verified',
        'status',
        'latitude',
        'longitude',
        'address',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * Relasi ke model RumahSakit jika user adalah admin_rs
     */
    public function rumahSakit()
    {
        // Temporarily commented out until RumahSakit model is defined
        // return $this->belongsTo(RumahSakit::class, 'rumah_sakit_id');
        return null;
    }

    /**
     * Relasi ke model PMI jika user adalah admin_pmi
     */
    public function pmi()
    {
        // Temporarily commented out until PMI model is defined
        // return $this->belongsTo(PMI::class, 'pmi_id');
        return $this->belongsTo(PMI::class, 'pmi_id');
    }

    /**
     * Relasi ke model Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Relasi ke model UserDocument
     */
    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    /**
     * Scope untuk user yang sudah diverifikasi
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope untuk user berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Cek apakah user adalah superuser
     */
    public function isSuperuser()
    {
        return $this->role === 'superuser';
    }

    /**
     * Cek apakah user adalah admin RS
     */
    public function isAdminRS()
    {
        return $this->role === 'admin_rs';
    }

    /**
     * Cek apakah user adalah admin PMI
     */
    public function isAdminPMI()
    {
        return $this->role === 'admin_pmi';
    }

    /**
     * Check if user is approved
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if user is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if user is rejected
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Scope for approved users
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope for pending users
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for rejected users
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
        $this->save();
    }
}