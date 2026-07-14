<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['table_number', 'seats', 'status', 'type'];

    // Scope untuk filter meja special
    public function scopeSpecial($query)
    {
        return $query->where('type', 'special');
    }

    // Relasi ke tabel reservations
    public function reservations()
    {
        return $this->hasMany(\App\Models\Reservation::class);
    }
}