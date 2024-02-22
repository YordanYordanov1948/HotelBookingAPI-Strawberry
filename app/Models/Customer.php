<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone_number'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
