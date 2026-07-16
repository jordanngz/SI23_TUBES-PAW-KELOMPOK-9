<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'db_reservation.reservations';

    protected $fillable = [
        'user_id',
        'table_id',
        'reserved_at',
        'event_type',
        'decoration_request',
        'special_request',
        'phone',
        'menu_preference',
        'is_special',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
        'is_special'  => 'boolean',
    ];

    /**
     * Relasi: reservasi milik satu meja.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
