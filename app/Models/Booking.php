<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'house_id',
        'status',
    ];

    public function house()
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}