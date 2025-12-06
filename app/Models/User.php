<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Model user (admin & mahasiswa)
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Keluhan milik user (sebagai mahasiswa)
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    // Respons yang ditangani user (sebagai admin)
    public function handledResponses(): HasMany
    {
        return $this->hasMany(ComplaintResponse::class, 'admin_id');
    }

    // Cek apakah user adalah admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah mahasiswa
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}
