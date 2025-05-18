<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'table_id', 'reserved_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function table() {
        return $this->belongsTo(Table::class);
    }

    // app/Models/Reservation.php
    protected $casts = [
        'reserved_at' => 'datetime',
    ];

}
