<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentRequest extends Model
{
    protected $table = 'installment_requests';

    protected $fillable = [
        'house_id',
        'customer_id',
        'room_info',
        'total_price',
        'months',
        'monthly_pay',
        'status'
    ];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function house()
    {
        return $this->belongsTo(House::class,'house_id');
    }
}