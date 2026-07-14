<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = ['table_number', 'seats', 'status', 'type', 'image'];

    /**
     * Relasi: satu meja punya banyak reservasi.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Scope: filter hanya meja special.
     */
    public function scopeSpecial($query)
    {
        return $query->where('type', 'special');
    }

    /**
     * Scope: filter meja yang tersedia (tidak ada reservasi di waktu tertentu).
     */
    public function scopeAvailableAt($query, string $date, string $time, int $partySize)
    {
        return $query
            ->special()
            ->where('seats', '>=', $partySize)
            ->whereDoesntHave('reservations', function ($q) use ($date, $time) {
                $q->whereDate('reserved_at', $date)
                  ->whereTime('reserved_at', $time);
            });
    }
}
