<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reservation_id',
        'transaction_code',
        'payment_method',
        'status',
        'subtotal',
        'service_charge',
        'tax',
        'total',
        'phone',
        'special_request'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function table()
    {
        return $this->belongsTo(\App\Models\Table::class);
    }
}
