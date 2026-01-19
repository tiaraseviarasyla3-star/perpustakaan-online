<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    // 🔹 Relasi ke tabel loans
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function fines()
        {
            return $this->hasMany(Fine::class);
        }


    /**
     * Helper: Cek apakah user punya denda yang belum dibayar
     */
    public function hasUnpaidFines()
    {
        return $this->fines()->where('status', 'unpaid')->exists();
    }
    
    /**
     * Helper: Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    
    // 🔹 Relasi ke tabel reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    

    
}
