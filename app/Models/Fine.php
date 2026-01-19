<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'loan_id',
        'user_id',
        'days_late',
        'amount',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

     // denda milik satu peminjaman
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // denda milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
