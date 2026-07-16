<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['id', 'name', 'email', 'role'];
    public $timestamps = false;

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
